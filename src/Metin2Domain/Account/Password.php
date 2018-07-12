<?php


namespace App\Metin2Domain\Account;


use App\Metin2Domain\Account\Exception\InvalidPasswordLengthException;

final class Password {

    const MIN_LENGTH = 6;

    const MAX_LENGTH = 16;

    protected $encryptedPassword;

    /**
     * Password constructor.
     * @param string $password
     * @param bool $isEncoded
     * @throws InvalidPasswordLengthException
     */
    public function __construct(string $password, bool $isEncoded = false) {
        if(!$isEncoded) {
            $passwordLength = strlen($password);
            if($passwordLength < self::MIN_LENGTH || $passwordLength > self::MAX_LENGTH)
                throw new InvalidPasswordLengthException(self::MIN_LENGTH, self::MAX_LENGTH);

            $password = sha1($password,true);
            $password = sha1($password);
            $password = '*'.strtoupper($password);
        }
        $this->encryptedPassword = $password;
    }

    public function getEncryptedPassword(): string {
        return $this->encryptedPassword;
    }

    public function __toString(): string {
        return $this->getEncryptedPassword();
    }

}