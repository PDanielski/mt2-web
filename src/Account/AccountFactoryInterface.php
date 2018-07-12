<?php

namespace App\Account;

use App\Metin2Domain\Account\AccountInterface;
use App\Metin2Domain\Account\AccountStatuses;
use App\Metin2Domain\Account\Email;
use App\Metin2Domain\Account\Login;
use App\Metin2Domain\Account\Password;
use App\Metin2Domain\Account\SocialId;

interface AccountFactoryInterface {

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
    ): AccountInterface;

}