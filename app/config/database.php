<?php
$host = '127.0.0.1';
$user = 'appuser';
$pass = 'appsecret';
$dbname = 'venda_carros';

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
