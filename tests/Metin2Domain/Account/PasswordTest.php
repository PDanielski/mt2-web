<?php

namespace App\Metin2Domain\Account;

use App\Metin2Domain\Account\Exception\InvalidPasswordLengthException;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase {

    public function test__construct() {
        $plainPassword = 'hi123123';
        $expectedPass = '*FB409EAED114570E37D8511F1D2F4B60FE54AFD7';
        $password = new Password($plainPassword);
        $this->assertEquals($expectedPass, $password->getEncryptedPassword());
    }

    public function test__constructWithTooShortPassword() {
        $password = 'hi123';
        $this->expectException(InvalidPasswordLengthException::class);
        new Password($password);
    }

    public function test__constructWithTooLongPassword() {
        $password = str_repeat('a',1024);
        $this->expectException(InvalidPasswordLengthException::class);
        new Password($password);
    }

    public function test__toString() {
        $plainPassword = 'hi123123';
        $expectedPass = '*FB409EAED114570E37D8511F1D2F4B60FE54AFD7';
        $password = new Password($plainPassword);
        $this->assertEquals($expectedPass, $password->__toString());
    }
}
