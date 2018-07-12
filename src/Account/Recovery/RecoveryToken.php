<?php


namespace App\Account\Recovery;


class RecoveryToken {

    protected $accountId;

    protected $emittedWhen;

    protected $expiresWhen;

    public function __construct(
        int $accountId,
        int $emittedWhen,
        int $expiresWhen
    ) {
        $this->accountId = $accountId;
        $this->emittedWhen = $emittedWhen;
        $this->expiresWhen = $expiresWhen;
    }

    public function getAccountId(): int {
        return $this->accountId;
    }

    public function whenWasEmitted(): int {
        return $this->emittedWhen;
    }

    public function whenExpires(): int {
        return $this->expiresWhen;
    }

    public function isValid(): bool {
        return time() < $this->whenExpires();
    }

}