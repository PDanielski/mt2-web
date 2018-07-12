<?php


namespace App\Account\Event;


use App\Account\Blocker\Unblock;
use Symfony\Component\EventDispatcher\Event;

class AccountUnblockedEvent extends Event {

    protected $unblock;

    public function __construct(Unblock $unblock) {
        $this->unblock = $unblock;
    }

    public function getUnblock(): Unblock {
        return $this->unblock;
    }

}