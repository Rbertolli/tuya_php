<?php

require 'vendor/autoload.php';

use Tuya\TuyaClient;
use Tuya\SmartLock;

// Carrega as variáveis de ambiente do arquivo .env

// Recupera as credenciais via variáveis de ambiente
$clientId       = $_ENV['TUYA_CLIENT_ID'];
$clientSecret   = $_ENV['TUYA_CLIENT_SECRET'];
$apiUrl         = $_ENV['TUYA_API_URL'] ?? 'https://api.tuya.com';
$tokenCacheFile = $_ENV['TUYA_TOKEN_CACHE_FILE'] ?? __DIR__ . '/token_cache.json';

// Para funcionalidades genéricas:
$tuyaClient = new TuyaClient($clientId, $clientSecret, $apiUrl, $tokenCacheFile);
$deviceInfo = $tuyaClient->getDeviceInfo('id_do_dispositivo');
print_r($deviceInfo);

// Para funcionalidades de smart-lock:
$smartLock = new SmartLock($clientId, $clientSecret, $apiUrl, $tokenCacheFile);

// Obter ticket de smart-lock
$ticketResponse = $smartLock->getPasswordTicket('id_do_dispositivo');
print_r($ticketResponse);

// Criptografar senha e criar senha temporária, por exemplo:
$plainPassword = "123456";
$debug = [];
$encryptedPassword = $smartLock->encryptNumericPassword($plainPassword, $ticketResponse['result']['ticket_key'], $debug);
echo "Senha criptografada: " . $encryptedPassword;

// Montar payload e criar senha temporária
$payload = [
    "name"           => "TP" . sprintf("%08d", rand(0, 99999999)),
    "password"       => $encryptedPassword,
    "effective_time" => time() + 24 * 3600, // 24h a partir de agora
    "invalid_time"   => time() + 48 * 3600, // 48h a partir de agora
    "password_type"  => "ticket",
    "ticket_id"      => $ticketResponse['result']['ticket_id'],
    "type"           => 0,  // múltiplos usos
    "time_zone"      => "",
    "phone"          => ""
];
$tempPasswordResponse = $smartLock->createTempPassword('id_do_dispositivo', $payload);
print_r($tempPasswordResponse);
