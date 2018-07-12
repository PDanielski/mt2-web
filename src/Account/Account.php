<?php


namespace App\Account;

use App\Metin2Domain\Account\Account as Metin2Account;
use App\Metin2Domain\Account\AccountStatuses;
use App\Metin2Domain\Account\Email;
use App\Metin2Domain\Account\Login;
use App\Metin2Domain\Account\Password;
use App\Metin2Domain\Account\SocialId;
use Doctrine\DBAL\Connection;

class Account extends Metin2Account {

    protected const TABLE_NAME = "account.account";

    protected $conn;

    protected $dispatcher;

    public function __construct(
        Connection $connection,
        int $id,
        Login $login,
        Email $email,
        Password $password,
        SocialId $socialId,
        int $gold = 0,
        int $warpoints = 0,
        int $biscuits = 0,
        string $status = AccountStatuses::CONFIRMED
    ) {
        $this->conn = $connection;
        parent::__construct($id, $login, $email, $password, $socialId, $gold, $warpoints, $biscuits, $status);
    }

    public function changePassword(Password $password): void {
        parent::changePassword($password);
        $this->changeProperty('password', $password->getEncryptedPassword());
    }

    public function changeEmail(Email $email): void {
        parent::changeEmail($email);
        $this->changeProperty('email', $email->getEmail());
    }

    public function setGold(int $amount) {
        parent::setGold($amount);
        $this->changeProperty('gold', $amount);
    }

    public function setWarpoints(int $amount) {
        parent::setWarpoints($amount);
        $this->changeProperty('warpoints', $amount);
    }

    public function setBiscuits(int $amount) {
        parent::setBiscuits($amount);
        $this->changeProperty('biscuits', $amount);
    }

    public function setStatus(string $status) {
        parent::setStatus($status);
        $this->changeProperty('status', $status);
    }

    public function blockUntil(?\DateTimeImmutable $date) {
        parent::blockUntil($date);
        $this->changeProperty('availDt', $date ? $date->format('Y-m-d H:i:s') : null);
    }

    protected function changeProperty($propertyName, $propertyValue) {
        $queryBuilder = $this->conn->createQueryBuilder();
        $queryBuilder
            ->update(self::TABLE_NAME)
            ->set($propertyName, ':property')
            ->setParameter('property', $propertyValue)
            ->where('id = :id')
            ->setParameter('id', $this->getId())
            ->execute();
    }

}