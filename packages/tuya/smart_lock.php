<?php
require_once __DIR__ . '/../src/SmartLock.php';
use Tuya\SmartLock;

function main(array $args): array
{
    $deviceId = $args['device_id'] ?? null;
    $password = $args['password'] ?? null;
    $startTime = $args['start_time'] ?? null;
    $endTime = $args['end_time'] ?? null;

    if (!$deviceId || !$password || !$startTime || !$endTime) {
        return [
            'body' => json_encode(["error" => "Missing required parameters"])
        ];
    }

    $smartLock = new SmartLock();
    $response = $smartLock->createTemporaryPassword($deviceId, $password, $startTime, $endTime);

    return [
        'body' => json_encode($response)
    ];
}
