-- ============================================================
-- LA FAKH — Migration base de données
-- À exécuter dans phpMyAdmin ou en ligne de commande MySQL
-- ============================================================

-- TABLE COMMENTS
CREATE TABLE IF NOT EXISTS `comments` (
    `id`          INT AUTO_INCREMENT PRIMARY KEY,
    `project_id`  INT         NOT NULL,
    `author_name` VARCHAR(100) NOT NULL,
    `content`     TEXT        NOT NULL,
    `approved`    TINYINT(1)  NOT NULL DEFAULT 1,
    `created_at`  DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_project` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- MISE À JOUR TABLE PROJECTS
-- Ajouter colonnes si elles n'existent pas déjà
ALTER TABLE `projects`
    ADD COLUMN IF NOT EXISTS `category`    VARCHAR(100) DEFAULT '' AFTER `title`,
    ADD COLUMN IF NOT EXISTS `media_items` LONGTEXT     DEFAULT NULL AFTER `media_path`,
    ADD COLUMN IF NOT EXISTS `video_embed` VARCHAR(512) DEFAULT '' AFTER `media_items`;

-- MISE À JOUR TABLE PRODUCTS
-- Ajouter colonnes pour la boutique enrichie
ALTER TABLE `products`
    ADD COLUMN IF NOT EXISTS `description` TEXT         DEFAULT NULL AFTER `image_path`,
    ADD COLUMN IF NOT EXISTS `includes`    VARCHAR(512) DEFAULT NULL AFTER `description`,
    ADD COLUMN IF NOT EXISTS `compat`      VARCHAR(255) DEFAULT NULL AFTER `includes`,
    ADD COLUMN IF NOT EXISTS `badge`       VARCHAR(50)  DEFAULT NULL AFTER `compat`;

-- TABLE USERS (si elle n'existe pas encore)
CREATE TABLE IF NOT EXISTS `users` (
    `id`       INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insérer l'admin par défaut (mot de passe: lafakh2026)
-- CHANGE CE MOT DE PASSE AVANT DE METTRE EN PRODUCTION !
INSERT IGNORE INTO `users` (`username`, `password`)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
-- (hash bcrypt de "lafakh2026" — généré avec password_hash('lafakh2026', PASSWORD_DEFAULT))
