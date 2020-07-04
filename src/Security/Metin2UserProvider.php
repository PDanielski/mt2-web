<?php


namespace App\Security;


use App\Account\Repository\AccountRepositoryInterface;
use App\Account\Repository\Exception\AccountNotFoundException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class Metin2UserProvider implements UserProviderInterface {

    protected $repo;

    public function __construct(AccountRepositoryInterface $repository) {
        $this->repo = $repository;
    }

    public function loadUserById(int $id) {
        try {
            $account = $this->repo->getById($id);
            $user = new Metin2User($id, $account->getLogin()->getLogin(), $account->getPassword()->getEncryptedPassword(), $account->getPremiumpoints());
            return $user;
        } catch (AccountNotFoundException $ex) {
            throw new UsernameNotFoundException("Account with id {$id} was not found", 0, $ex);
        }
    }

    public function loadUserByUsername($username) {
        try {
            $account = $this->repo->getByLogin($username);
            $user = new Metin2User($account->getId(), $account->getLogin()->getLogin(), $account->getPassword()->getEncryptedPassword(), $account->getPremiumpoints());
            return $user;
        } catch (AccountNotFoundException $ex) {
            throw new UsernameNotFoundException("{$username} was not found", 0, $ex);
        }
    }

    public function refreshUser(UserInterface $user) {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return $class == Metin2User::class;
    }

}