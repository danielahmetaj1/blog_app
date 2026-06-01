<?php
require 'config/constants.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user-id'])) {
    echo json_encode(['error' => 'Duhet te kycesh per te perdorur chatbot-in.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Kerkese e pavlefshme.']);
    exit;
}

$input    = json_decode(file_get_contents('php://input'), true);
$messages = $input['messages'] ?? [];

if (empty($messages)) {
    echo json_encode(['error' => 'Nuk ka mesazhe.']);
    exit;
}

$messages = array_slice($messages, -50);

foreach ($messages as &$msg) {
    $msg['role']    = in_array($msg['role'], ['user', 'assistant']) ? $msg['role'] : 'user';
    $msg['content'] = mb_substr(strip_tags((string)$msg['content']), 0, 2000);
}
unset($msg);


$api_key = 'Celesi_api_ketu'; // fillon me gsk_...

$payload = json_encode([
    'model'       => 'llama-3.3-70b-versatile',
    'max_tokens'  => 512,
    'temperature' => 0.7,
    'messages'    => array_merge(
        [[
            'role'    => 'system',
            'content' => 'Jeni asistenti i support-it te blogut WriteX. Ndihmoni perdoruesit me pyetje rreth platformes: si te publikojne postime, si te menaxhojne llogarine, si te nderveprojne me postimet (pelqime, komente, shperndarje). Jini te shkurter, miqesor dhe profesional. Pergjigjuni ne gjuhen qe flet perdoruesi.'
        ]],
        $messages
    ),
]);

$ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key,
    ],
    CURLOPT_TIMEOUT => 30,
]);

$response  = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_err  = curl_error($ch);
curl_close($ch);

if ($response === false || $http_code !== 200) {
    $error_data = json_decode($response, true);
    $error_msg  = $error_data['error']['message'] ?? ('HTTP ' . $http_code . ' - ' . ($curl_err ?: $response));
    echo json_encode(['error' => 'Gabim API: ' . $error_msg]);
    exit;
}

$data  = json_decode($response, true);
$reply = $data['choices'][0]['message']['content'] ?? 'Nuk mora pergjigje. Provo perseri.';

echo json_encode(['reply' => $reply]);
