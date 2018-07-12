<?php

namespace App\Metin2Domain\Account;

use App\Metin2Domain\Account\Exception\EmailNotValidException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase {

    public function test__construct() {
        $emailString = 'test@test.it';
        $email = new Email($emailString);
        $this->assertEquals($emailString, $email->getEmail());
    }

    public function test__constructFailure() {
        $wrongEmail = 'test@test';
        $this->expectException(EmailNotValidException::class);
        new Email($wrongEmail);
    }

    public function test__toString() {
        $email = new Email('ciao@ciao.it');
        $this->assertEquals('ciao@ciao.it',$email->__toString());
    }

}
