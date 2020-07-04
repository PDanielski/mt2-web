<?php


namespace App\Security;


use App\Metin2Domain\Account\Account;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Metin2User implements UserInterface, EquatableInterface {

    protected $accountId;

    protected $login;

    protected $password;

    protected $roles = array('ROLE_USER');

    protected $premiumpoints;

    public function __construct(int $accountId, string $login, string $password, $premiumpoints, $roles = array()) {
        $this->accountId = $accountId;
        $this->login = $login;
        $this->password = $password;
        $this->premiumpoints = $premiumpoints;
        if(count($roles) > 0) $this->roles = $roles;
    }

    public function getAccountId() {
        return $this->accountId;
    }
    public function getRoles() {
        return $this->roles;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPremiumpoints() {
        return $this->premiumpoints;
    }

    public function getSalt() {
        return null;
    }

    public function getUsername() {
        return $this->login;
    }

    public function eraseCredentials() {
        return null;
    }

    public function isEqualTo(UserInterface $user) {
        return $this->login == $user->getUsername() && $this->password == $user->getPassword();
    }

}