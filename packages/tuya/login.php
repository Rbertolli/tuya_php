<?php
require_once __DIR__ . '/../src/TuyaClient.php';
use Tuya\TuyaClient;
header("Content-Type: application/json");

$tuya = new TuyaClient();
$response = $tuya->authenticate();

echo json_encode($response);