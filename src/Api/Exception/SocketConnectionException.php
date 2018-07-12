<?php


namespace App\Api\Exception;


use Throwable;

class SocketConnectionException extends \Exception {
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null) {
        $message = "Couldn't connect to the metin2 socket api: ".$message;
        parent::__construct($message, $code, $previous);
    }
}