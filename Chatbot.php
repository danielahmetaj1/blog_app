<?php
require 'config/constants.php';

header('Content-Type: application/json');

// Vetëm përdoruesit e kyçur
if (!isset($_SESSION['user-id'])) {
    echo json_encode(['error' => 'Duhet te kyçesh per te perdorur chatbot-in.']);
    exit;
}

// Vetëm POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request.']);
    exit;
}

$input    = json_decode(file_get_contents('php://input'), true);
$messages = $input['messages'] ?? [];

if (empty($messages)) {
    echo json_encode(['error' => 'Nuk ka mesazhe.']);
    exit;
}

// Valido — max 50 mesazhe në histori
$messages = array_slice($messages, -50);

// Sanitizo çdo mesazh
foreach ($messages as &$msg) {
    $msg['role']    = in_array($msg['role'], ['user', 'assistant']) ? $msg['role'] : 'user';
    $msg['content'] = mb_substr(strip_tags((string)$msg['content']), 0, 2000);
}
unset($msg);

// ── Claude API ──────────────────────────────────────────────
$api_key = 'YOUR_ANTHROPIC_API_KEY'; // <-- vendos API key-n tënd këtu

$payload = json_encode([
    'model'      => 'claude-sonnet-4-20250514',
    'max_tokens' => 512,
    'system'     => 'Jeni asistenti i support-it te blogut WriteX. Ndihmoni perdoruesit me pyetje rreth platformes: 
        si te publikojne postime, si te menaxhojne llogarine, si te nderveprojne me postimet (likes, komente, share). 
        Jini të shkurter, miqesor dhe profesional. Përgjigjuni ne gjuhen qe flet përdoruesi.',
    'messages'   => $messages,
]);

$ch = curl_init('https://api.anthropic.com/v1/messages');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'x-api-key: ' . $api_key,
        'anthropic-version: 2023-06-01',
    ],
    CURLOPT_TIMEOUT        => 30,
]);

$response  = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false || $http_code !== 200) {
    echo json_encode(['error' => 'Gabim ne lidhje me API-n. Provo perseri.']);
    exit;
}

$data = json_decode($response, true);
$reply = $data['content'][0]['text'] ?? 'Nuk mora përgjigje. Provo perseri.';

echo json_encode(['reply' => $reply]);