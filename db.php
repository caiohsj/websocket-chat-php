<?php

$pdo = new PDO("mysql:host=localhost;dbname=websocket","root","");

$query = $pdo->query("SELECT * FROM chat ORDER BY id ASC");

header("Content-Type: application/json");
echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));