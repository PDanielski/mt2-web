<?php


namespace App\Account\Blocker;

use App\Account\Event\AccountBlockedEvent;
use App\Account\Event\AccountUnblockedEvent;
use App\Metin2Domain\Account\AccountInterface;
use Doctrine\DBAL\Connection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AccountBlocker implements AccountBlockerInterface {

    protected $conn;

    protected $tableName;

    protected $dispatcher;

    public function __construct(Connection $conn, string $tableName, EventDispatcherInterface $dispatcher) {
        $this->conn = $conn;
        $this->tableName = $tableName;
        $this->dispatcher = $dispatcher;
    }

    public function block(Block $block, AccountInterface $account) {
        if($block->isPermanent()) {
            $account->block();
        } else {
            $account->blockUntil($block->getWhenExpires());
        }

        $event = new AccountBlockedEvent($block);
        $this->dispatcher->dispatch('app.account.blocked', $event);
    }

    public function unblock(Unblock $unblock, AccountInterface $account) {
        $account->unblock();
        $event = new AccountUnblockedEvent($unblock);
        $this->dispatcher->dispatch('app.account.unblocked', $event);
    }

}