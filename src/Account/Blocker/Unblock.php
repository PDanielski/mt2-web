<?php


namespace App\Account\Blocker;


class Unblock {

    protected $whoUnblocked;

    protected $whoWasBlocked;

    protected $reason;

    protected $when;

    public function __construct(
        int $whoUnblocked,
        int $whoWasBlocked,
        string $reason,
        \DateTimeImmutable $when = null
    ) {
        $this->whoUnblocked = $whoUnblocked;
        $this->whoWasBlocked = $whoWasBlocked;
        $this->reason = $reason;
        try {
            $this->when = $when?:new \DateTimeImmutable();
        } catch (\Exception $ex) {
            throw new \RuntimeException("Error while creating date", 0, $ex);
        }
    }

    public function getWhoUnblocked(): int {
        return $this->whoUnblocked;
    }

    public function getWhoWasBlocked(): int {
        return $this->whoWasBlocked;
    }

    public function getReason(): string {
        return $this->reason;
    }

    public function getWhen(): \DateTimeImmutable {
        return $this->when;
    }

}