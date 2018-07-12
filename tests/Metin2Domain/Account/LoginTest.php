<?php

namespace App\Metin2Domain\Account;

use App\Metin2Domain\Account\Exception\InvalidLoginLengthException;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase {

    public function test__construct() {
        $login = new Login('randomName');
        $this->assertEquals('randomName', $login->getLogin());
    }

    public function test__constructWithTooShortLogin() {
        $loginString = 'abc';
        $this->expectException(InvalidLoginLengthException::class);
        new Login($loginString);
    }

    public function test__constructWithTooLongLogin() {
        $loginString = 'abcdefghijklmnopqrst';
        $this->expectException(InvalidLoginLengthException::class);
        new Login($loginString);
    }

    public function test__toString() {
        $login = new Login('randomName');
        $this->assertEquals('randomName', $login->__toString());
    }
}
