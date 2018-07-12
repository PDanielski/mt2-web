<?php


namespace App\Account\Blocker;


class BlockRecord extends Block {

    protected $id;

    public function __construct(
        int $id,
        int $whoWasBlocked,
        int $whoBlocked,
        \DateTimeImmutable $when,
        string $reason,
        bool $isPermanent = true,
        \DateTimeImmutable $whenExpires = null
    ) {
        parent::__construct($whoWasBlocked, $whoBlocked, $when, $reason, $isPermanent, $whenExpires);
        $this->id = $id;
    }

    public static function fromBlock(int $id, Block $block): self {
        return new BlockRecord(
            $id,
            $block->getWhoWasBlocked(),
            $block->getWhoBlocked(),
            $block->getWhen(),
            $block->getReason(),
            $block->isPermanent(),
            $block->getWhenExpires()
        );
    }

    public function getId(): int {
        return $this->id;
    }

}