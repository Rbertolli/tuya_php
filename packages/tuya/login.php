<?php
require_once '/.app_platform_workspace/src/TuyaClient.php';
use Tuya\TuyaClient;

function main(array $args): array
{
    $tuya = new TuyaClient();
    $response = $tuya->authenticate();

    // Retorna a resposta codificada em JSON no campo "body"
    return [
        'body' => json_encode($response)
    ];
}
