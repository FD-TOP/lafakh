<?php
header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$project_id  = intval($data['project_id']  ?? 0);
$author_name = trim($data['author_name']   ?? '');
$content     = trim($data['content']       ?? '');

if (!$project_id || !$author_name || !$content) {
    echo json_encode(['ok'=>false,'error'=>'Champs manquants']);
    exit;
}

if (!$pdo) {
    echo json_encode(['ok'=>true,'stored'=>'local']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO comments (project_id, author_name, content, approved, created_at) VALUES (?,?,?,1,NOW())");
    $stmt->execute([$project_id, $author_name, $content]);
    echo json_encode(['ok'=>true,'id'=>$pdo->lastInsertId()]);
} catch (\Throwable $e) {
    echo json_encode(['ok'=>false,'error'=>$e->getMessage()]);
}
