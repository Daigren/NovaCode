<?php
header('Content-Type: application/json');

$secrets = require_once __DIR__ . '/secrets.php';
$apiKey = $secrets['openrouter_key'];

$data = json_decode(file_get_contents('php://input'), true);
$userMessage = isset($data['message']) ? trim($data['message']) : '';

if (empty($userMessage)) {
    echo json_encode(['reply' => 'Пожалуйста, напиши что-нибудь.']);
    exit;
}

$apiUrl = 'https://openrouter.ai/api/v1/chat/completions';
$systemPrompt = "Ты ИИ-ментор платформы NovaCode. Проанализируй запрос пользователя и порекомендуй ТОЛЬКО ОДИН язык из списка: C, C++, C# или Java. Ответь кратко, в 2-3 предложениях, в профессиональном, но дружелюбном стиле.";

$requestData = [
    "model" => "openrouter/free", 
    
    "messages" => [
        ["role" => "system", "content" => $systemPrompt],
        ["role" => "user", "content" => $userMessage]
    ],
    "temperature" => 0.7 
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
    'HTTP-Referer: http://localhost', 
    'X-Title: NovaCode'
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo json_encode(['reply' => 'Системная ошибка сети: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);

if ($httpCode == 200) {
    $responseData = json_decode($response, true);
    $aiText = $responseData['choices'][0]['message']['content'] ?? 'Не удалось сгенерировать ответ.';
    echo json_encode(['reply' => $aiText]);
} else {
    echo json_encode(['reply' => "Ошибка API ($httpCode): $response"]);
}
?>