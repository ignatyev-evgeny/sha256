<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (isset($data['text'])) {
        $hash = hash('sha256', $data['text']);
        echo json_encode([
            'original' => $data['text'],
            'sha256' => $hash
        ]);
    } else {
        echo json_encode(['error' => 'Текст не предоставлен']);
    }
} else {
    echo json_encode(['error' => 'Используйте POST запрос']);
}
?>