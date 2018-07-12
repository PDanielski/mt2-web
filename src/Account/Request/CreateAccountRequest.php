<?php


namespace App\Account\Request;


use App\Metin2Domain\Account\Email;
use App\Metin2Domain\Account\Login;
use App\Metin2Domain\Account\Password;
use App\Metin2Domain\Account\SocialId;

class CreateAccountRequest {

    protected $login;

    protected $email;

    protected $password;

    protected $socialId;

    public function __construct(Login $login, Email $email, Password $password, SocialId $socialId) {
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->socialId = $socialId;
    }

    public function getLogin(): Login {
        return $this->login;
    }

    public function getEmail(): Email {
        return $this->email;
    }

    public function getPassword(): Password {
        return $this->password;
    }

    public function getSocialId(): SocialId {
        return $this->socialId;
    }

}