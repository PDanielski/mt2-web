<?php


namespace App\Account\Blocker;


class Block {

    protected $whoWasBlocked;

    protected $whoBlocked;

    protected $when;

    protected $reason;

    protected $isPermanent;

    protected $whenExpires;

    public function __construct(
        int $whoWasBlocked,
        int $whoBlocked,
        \DateTimeImmutable $when,
        string $reason,
        bool $isPermanent = true,
        \DateTimeImmutable $whenExpires = null
    ) {
        $this->whoWasBlocked = $whoWasBlocked;
        $this->whoBlocked = $whoBlocked;
        $this->when = $when;
        $this->reason = $reason;
        $this->isPermanent = $isPermanent;

        if(!$this->isPermanent && !$whenExpires)
            throw new \RuntimeException("If the block is not permanent, you must supply an expiration date");

        $this->whenExpires = $whenExpires;
    }

    public function getWhoWasBlocked(): int {
        return $this->whoWasBlocked;
    }

    public function getWhoBlocked(): int {
        return $this->whoBlocked;
    }

    public function getWhen(): \DateTimeImmutable {
        return $this->when;
    }

    public function getReason(): string {
        return $this->reason;
    }

    public function isPermanent(): bool {
        return $this->isPermanent;
    }

    public function getWhenExpires(): ?\DateTimeImmutable {
        return $this->whenExpires??null;
    }

}