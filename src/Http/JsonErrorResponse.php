<?php


namespace App\Http;


use Symfony\Component\HttpFoundation\JsonResponse;

class JsonErrorResponse extends JsonResponse {

    public function __construct(int $errorCode, string $errorMessage, int $httpCode = 0) {
        $data = array();
        $data["code"] = $errorCode;
        $data["message"] = $errorMessage;
        parent::__construct($data, $httpCode ?: $errorCode, array(), false);
    }
}