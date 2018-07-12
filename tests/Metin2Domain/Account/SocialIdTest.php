<?php

namespace App\Metin2Domain\Account;

use App\Metin2Domain\Account\Exception\InvalidSocialIdLengthException;
use App\Metin2Domain\Account\Exception\NotNumericSocialIdException;
use PHPUnit\Framework\TestCase;

class SocialIdTest extends TestCase {

    public function test__construct() {
        $socialIdString = '1231231';
        $socialId = new SocialId($socialIdString);
        $this->assertEquals($socialIdString, $socialId->getSocialId());
    }

    public function test__constructWithInvalidSizeSocialId(){
        $socialId = '123123';
        $this->expectException(InvalidSocialIdLengthException::class);
        new SocialId($socialId);
    }

    public function test__constructWithNotNumeriSocialId(){
        $socialId = 'abcabca';
        $this->expectException(NotNumericSocialIdException::class);
        new SocialId($socialId);
    }

    public function test__toString() {
        $socialIdString = '1231231';
        $socialId = new SocialId($socialIdString);
        $this->assertEquals($socialIdString, $socialId->__toString());
    }

}
