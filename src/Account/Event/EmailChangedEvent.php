<?php


namespace App\Account\Event;


use App\Metin2Domain\Account\Email;
use Symfony\Component\EventDispatcher\Event;

class EmailChangedEvent extends Event {

    const NAME = "app.account.email_changed";

    protected $accountId;

    protected $newEmail;

    protected $context;

    public function __construct(int $accountId, Email $newEmail, $context = []) {
        $this->accountId = $accountId;
        $this->newEmail = $newEmail;
        $this->context = $context;
    }

    public function getAccountId(): int {
        return $this->accountId;
    }

    public function getNewEmail(): Email {
        return $this->newEmail;
    }

    public function getContext(): array {
        return $this->context;
    }

}