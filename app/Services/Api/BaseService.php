<?php

namespace App\Services\Api;

class BaseService
{
    protected string $baseUrl;

    public function __construct()
    {
        // URL base da sua API fake (exemplo)
        $this->baseUrl = 'https://my-json-server.typicode.com/4andresilva/cinema-api/';
    }

}