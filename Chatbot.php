<?php
require 'config/constants.php';

header('Content-Type: application/json');

// Vetëm përdoruesit e kyçur
if (!isset($_SESSION['user-id'])) {
    echo json_encode(['error' => 'Duhet të kyçesh për të përdorur chatbot-in.']);
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

// ── Gemini API ───────────────────────────────────────────────
// Merr API key falas nga: aistudio.google.com → Get API Key
$api_key = ''; // <-- vendos API key-n tënd këtu

// Konverto historinë në formatin e Gemini
// Gemini përdor "user"/"model" (jo "assistant")
$system_prompt = 'Jeni asistenti i support-it të blogut WriteX. Ndihmoni përdoruesit me pyetje rreth platformës: si të publikojnë postime, si të menaxhojnë llogarinë, si të ndërveprojnë me postimet (likes, komente, share). Jini të shkurtër, miqësor dhe profesional. Përgjigjuni në gjuhën që flet përdoruesi.';

$contents = [];
foreach ($messages as $msg) {
    $contents[] = [
        'role'  => $msg['role'] === 'assistant' ? 'model' : 'user',
        'parts' => [['text' => $msg['content']]],
    ];
}

$payload = json_encode([
    'system_instruction' => [
        'parts' => [['text' => $system_prompt]]
    ],
    'contents'           => $contents,
    'generationConfig'   => [
        'maxOutputTokens' => 512,
        'temperature'     => 0.7,
    ],
]);

$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $api_key;

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    CURLOPT_TIMEOUT        => 30,
]);

$response  = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false || $http_code !== 200) {
    echo json_encode(['error' => 'Gabim në lidhje me API-n. Provo përsëri.']);
    exit;
}

$data  = json_decode($response, true);
$reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Nuk mora përgjigje. Provo përsëri.';

echo json_encode(['reply' => $reply]);