<?php


namespace App\Account;

use App\Metin2Domain\Account\AccountInterface;
use App\Metin2Domain\Account\AccountStatuses;
use App\Metin2Domain\Account\Email;
use App\Metin2Domain\Account\Login;
use App\Metin2Domain\Account\Password;
use App\Metin2Domain\Account\SocialId;
use Doctrine\DBAL\Connection;

class AccountFactory implements AccountFactoryInterface {

    protected $conn;

    public function __construct(Connection $conn) {
        $this->conn = $conn;
    }

    public function create(
        int $id,
        Login $login,
        Email $email,
        Password $password,
        SocialId $socialId,
        int $gold = 0,
        int $warpoints = 0,
        int $biscuits = 0,
        string $status = AccountStatuses::CONFIRMED
    ): AccountInterface {
        return new Account(
            $this->conn,
            $id,
            $login,
            $email,
            $password,
            $socialId,
            $gold,
            $warpoints,
            $biscuits,
            $status
        );
    }

}