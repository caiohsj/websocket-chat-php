<?php

namespace Source\App;

use Exception;
use SplObjectStorage;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use PDO;

final class ChatServer implements MessageComponentInterface
{
    private $clients;
    private $pdo;

    public function __construct()
    {
        $this->clients = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn): void
    {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg): void
    {
        $data = json_decode($msg);
        $pdo = new PDO("mysql:host=localhost;dbname=websocket","root","");
        $query = $pdo->query("INSERT INTO chat(nome,mensagem) VALUES('$data->nome','$data->mensagem')");
        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }

    public function onClose(ConnectionInterface $conn): void
    {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $exception): void
    {
        $conn->close();
    }
}