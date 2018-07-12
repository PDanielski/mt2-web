<?php


namespace App\Metin2Domain\Account\Exception;


class EmailNotValidException extends \Exception {

    protected $invalidEmail;

    public function __construct($invalidEmail) {
        $message = "The email '{$invalidEmail}' is not valid";
        parent::__construct($message);
    }

    public function getInvalidEmail(): string {
        return $this->invalidEmail;
    }

}