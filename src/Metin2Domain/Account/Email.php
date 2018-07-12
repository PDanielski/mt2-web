<?php


namespace App\Metin2Domain\Account;


use App\Metin2Domain\Account\Exception\EmailNotValidException;

final class Email {

    protected $email;

    /**
     * Email constructor.
     * @param string $email
     * @throws EmailNotValidException
     */
    public function __construct(string $email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new EmailNotValidException($email);

        $this->email = $email;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function __toString(): string {
        return $this->getEmail();
    }

}