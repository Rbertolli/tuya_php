<?php
require_once __DIR__ . '/../src/SmartLock.php';
use Tuya\SmartLock;
header("Content-Type: application/json");

$deviceId = $_GET['device_id'] ?? null;
$password = $_GET['password'] ?? null;
$startTime = $_GET['start_time'] ?? null;
$endTime = $_GET['end_time'] ?? null;

if (!$deviceId || !$password || !$startTime || !$endTime) {
    echo json_encode(["error" => "Missing required parameters"]);
    exit;
}

$smartLock = new SmartLock();
$response = $smartLock->createTemporaryPassword($deviceId, $password, $startTime, $endTime);

echo json_encode($response);