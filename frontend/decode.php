<?php
require_once '../vendor/autoload.php';

use App\Backend\Token;

$token = new Token();
$token->setKey('abc');
$payload = $token->decode('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6InRyYW50aGFuaHF1eXRoa2dAZ21haWwuY29tIiwicGFzc3dvcmQiOiIyMDJjYjk2MmFjNTkwNzViOTY0YjA3MTUyZDIzNGI3MCJ9.lFXJJu0w7FMoYeTGCvG_Ophi0NaR0ukGIHfdyKRm4eU');
var_dump($payload->username);
