<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (isset($data['text'])) {
        $text = trim($data['text']);
        $hash = hash('sha256', $text);
        echo json_encode([
            'original' => $text,
            'sha256' => $hash
        ]);
        exit;
    }

    if(isset($data['json'])) {
        $firstLevel = array_filter($data['json'], function($value) {
            return !is_array($value);
        });
        ksort($firstLevel);
        $result = implode('', $firstLevel);
        echo $result;
        exit;
    }

} else {
    echo json_encode(['error' => 'Используйте POST запрос']);
}
?>