<?php


namespace App\Account\Blocker;


class UnblockRecord extends Unblock {

    protected $id;

    public function __construct(
        int $id,
        int $whoUnblocked,
        int $whoWasBlocked,
        string $reason,
        \DateTimeImmutable $when = null
    ) {
        parent::__construct($whoUnblocked, $whoWasBlocked, $reason, $when);
        $this->id = $id;
    }

    public static function fromUnblock(int $id, Unblock $unblock): self {
        return new self(
            $id,
            $unblock->getWhoUnblocked(),
            $unblock->getWhoWasBlocked(),
            $unblock->getReason(),
            $unblock->getWhen()
        );
    }

    public function getId(): int {
        return $this->id;
    }

}