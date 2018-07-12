<?php


namespace App\Metin2Domain\Account\Exception;


class InvalidLoginLengthException extends InvalidLengthException {

    protected $login;

    public function __construct(string $login, int $minSize, int $maxSize) {
        $this->login = $login;

        $message = "The login '{$login}' is too long: the min length is {$minSize}, the max length is '{$maxSize}'";
        parent::__construct($message, $minSize, $maxSize);
    }

    public function getInvalidLogin(): string {
        return $this->login;
    }

}