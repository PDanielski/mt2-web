<?php


namespace App\Security\Encoder;


use App\Metin2Domain\Account\Exception\InvalidPasswordLengthException;
use App\Metin2Domain\Account\Password;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class Metin2PasswordEncoder implements PasswordEncoderInterface {

    public function encodePassword($raw, $salt = null) {
        try {
            $password = new Password($raw);
            return $password->getEncryptedPassword();
        } catch (InvalidPasswordLengthException $ex) {
            throw new \RuntimeException($ex->getMessage(), 0, $ex);
        }
    }

    public function isPasswordValid($encoded, $raw, $salt = null) {
        try {
            if(!$raw)
                return false;

            $rawEncoded = (new Password($raw))->getEncryptedPassword();
            return $encoded === $rawEncoded;
        } catch (InvalidPasswordLengthException $ex) {
            return false;
        }
    }

}