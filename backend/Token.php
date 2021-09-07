<?php

namespace App\Backend;

use Firebase\JWT\JWT;

class Token
{
    public array $payload;
    protected string $key = 'key';

    public function setPayload(array $payload)
    {
        $this->payload = $payload;
    }

    public function setKey(string $key)
    {
        $this->key = $key;
    }

    public function encode(): string
    {
        return JWT::encode($this->payload, $this->key);
    }

    public function decode($jwt, array $alg = ['HS256']): object
    {
        return JWT::decode($jwt, $this->key, $alg);
    }
}
