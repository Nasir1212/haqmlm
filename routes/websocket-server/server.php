<?php

namespace App\Http\Controllers\Backend;
use Workerman\Worker;
require_once __DIR__ . '/vendor/autoload.php';

$ws = new Worker("websocket://0.0.0.0:8080");
$ws->count = 1;

$clients = [];

$ws->onConnect = function($connection) use (&$clients) {
    $connection->onWebSocketConnect = function($conn, $http_header) use (&$clients) {
        $userId = $_GET['user_id'] ?? null;
        if ($userId) {
            $clients[$userId] = $conn;
            $conn->user_id = $userId;
        }
    };
};

$ws->onMessage = function($connection, $data) use (&$clients) {
    $payload = json_decode($data, true);
    
    if (!empty($payload['to_user_id']) && !empty($payload['message'])) {
        $toUserId = $payload['to_user_id'];
        if (isset($clients[$toUserId])) {
            $clients[$toUserId]->send(json_encode([
                'from' => $connection->user_id,
                'message' => $payload['message'],
            ]));
        }
    }
};

$ws->onClose = function($connection) use (&$clients) {
    if (isset($connection->user_id)) {
        unset($clients[$connection->user_id]);
    }
};

Worker::runAll();
