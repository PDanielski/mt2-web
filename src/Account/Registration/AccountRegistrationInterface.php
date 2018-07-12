<?php


namespace App\Account\Registration;


use App\Account\Exception\DuplicateAccountException;
use App\Account\Request\CreateAccountRequest;
use App\Metin2Domain\Account\Account;

interface AccountRegistrationInterface {

    /**
     * @param CreateAccountRequest $request
     * @return Account
     * @throws DuplicateAccountException
     */
    public function register(CreateAccountRequest $request): Account;

}