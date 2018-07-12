<?php


namespace App\Account\Event;


use App\Account\Blocker\Block;
use Symfony\Component\EventDispatcher\Event;

class AccountBlockedEvent extends Event {

    protected $record;

    public function __construct(Block $record) {
        $this->record = $record;
    }

    public function getBlock(): Block {
        return $this->record;
    }

}