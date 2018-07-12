<?php


namespace App\Metin2Domain\Account\Exception;


class InvalidPasswordLengthException extends InvalidLengthException {

    public function __construct($minSize, $maxSize) {
        $message = "The password entered should be at least {$minSize} and at most {$maxSize} characters";
        parent::__construct($message, $minSize, $maxSize);
    }

}