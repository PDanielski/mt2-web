<?php


namespace App\Account\Event;


use App\Metin2Domain\Account\Password;
use Symfony\Component\EventDispatcher\Event;

class PasswordChangedEvent extends Event {

    const NAME = "app.account.password_changed";

    protected $accountId;

    protected $newPassword;

    protected $context;

    public function __construct(int $accountId, Password $newPassword, $context = []) {
        $this->accountId = $accountId;
        $this->newPassword = $newPassword;
        $this->context = $context;
    }

    public function getAccountId(): int {
        return $this->accountId;
    }

    public function getNewPassword(): Password {
        return $this->newPassword;
    }

    public function getContext(): array {
        return $this->context;
    }

}