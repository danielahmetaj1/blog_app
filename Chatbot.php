<?php
require 'config/constants.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user-id'])) {
    echo json_encode(['error' => 'Duhet të kyçesh për të përdorur chatbot-in.']);
    exit;
}

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

$messages = array_slice($messages, -50);

foreach ($messages as &$msg) {
    $msg['role']    = in_array($msg['role'], ['user', 'assistant']) ? $msg['role'] : 'user';
    $msg['content'] = mb_substr(strip_tags((string)$msg['content']), 0, 2000);
}
unset($msg);

// ── Groq API — FALAS 100% ────────────────────────────────────
// 1. Shko te: console.groq.com
// 2. Regjistrohu (falas, nuk kërkon kartë)
// 3. Klik "API Keys" → "Create API Key"
// 4. Vendose key-n këtu poshtë:
$api_key = 'YOUR_GROQ_API_KEY'; // fillon me gsk_...

$payload = json_encode([
    'model'       => 'llama-3.3-70b-versatile',
    'max_tokens'  => 512,
    'temperature' => 0.7,
    'messages'    => array_merge(
        [[
            'role'    => 'system',
            'content' => 'Jeni asistenti i support-it të blogut WriteX. Ndihmoni përdoruesit me pyetje rreth platformës: si të publikojnë postime, si të menaxhojnë llogarinë, si të ndërveprojnë me postimet (likes, komente, share). Jini të shkurtër, miqësor dhe profesional. Përgjigjuni në gjuhën që flet përdoruesi.'
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
    $error_msg  = $error_data['error']['message'] ?? ('HTTP ' . $http_code . ' — ' . ($curl_err ?: $response));
    echo json_encode(['error' => 'API Error: ' . $error_msg]);
    exit;
}

$data  = json_decode($response, true);
$reply = $data['choices'][0]['message']['content'] ?? 'Nuk mora përgjigje. Provo përsëri.';

echo json_encode(['reply' => $reply]);