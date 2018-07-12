<?php


namespace App\Account\Repository\Exception;


class AccountNotFoundException extends \Exception {

    public function __construct($message = '') {
        if(!$message)
            $message = "Account not found";

        parent::__construct($message);
    }
}