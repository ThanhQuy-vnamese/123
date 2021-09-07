<?php
require_once '../vendor/autoload.php';

use App\Backend\Token;

$token = new Token();

$payload = [
    "email" => $_POST['email'],
    "password" => $_POST['password'],
];

$token->setPayload($payload);
$token->setKey('abc');

var_dump($token->encode());
