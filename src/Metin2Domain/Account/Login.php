<?php


namespace App\Metin2Domain\Account;


use App\Metin2Domain\Account\Exception\InvalidLoginLengthException;

final class Login {

    const MIN_LENGTH = 4;

    const MAX_LENGTH = 16;

    protected $login;

    /**
     * Login constructor.
     * @param string $login
     * @throws InvalidLoginLengthException
     */
    public function __construct(string $login) {
        $loginLength = strlen($login);
        if($loginLength < self::MIN_LENGTH || $loginLength > self::MAX_LENGTH)
            throw new InvalidLoginLengthException($login, self::MIN_LENGTH, self::MAX_LENGTH);

        $this->login = $login;
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function __toString(): string {
        return $this->getLogin();
    }

}