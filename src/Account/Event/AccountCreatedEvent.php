<?php


namespace App\Account\Event;


use App\Metin2Domain\Account\Account;
use Symfony\Component\EventDispatcher\Event;

class AccountCreatedEvent extends Event {

    const NAME = "app.account.created";

    /** @var Account */
    protected $account;

    public function __construct(Account $account) {
        $this->account = $account;
    }

    public function getCreatedAccount(): Account {
        return $this->account;
    }

}