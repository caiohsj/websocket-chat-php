<?php
require __DIR__ . "/vendor/autoload.php";

use Source\App\ChatServer;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

try {
    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new ChatServer()
            )
        ),
        8080
    );

    $server->run();
} catch(Exception $e) {

}