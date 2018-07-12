<?php


namespace App\Account\EventListener;


use App\Account\Event\AccountUnblockedEvent;
use Doctrine\DBAL\Connection;

class RecordUnblockListener {

    protected $conn;

    public function __construct(Connection $conn) {
        $this->conn = $conn;
    }

    public function onAccountUnblocked(AccountUnblockedEvent $event) {
        $block = $event->getUnblock();
        $queryBuilder = $this->conn->createQueryBuilder();
        $queryBuilder
            ->insert('account.account_unblocks')
            ->values([
                'whoUnblocked' => ':whoUnblocked',
                'whoWasBlocked' => ':whoWasBlocked',
                'reason' => ':reason',
                'time' => ':time'
            ])
            ->setParameters([
                'whoUnblocked' => $block->getWhoUnblocked(),
                'whoWasBlocked' => $block->getWhoWasBlocked(),
                'reason' => $block->getReason(),
                'time' => $block->getWhen()->format('Y-m-d H:i:s')
            ])
            ->execute();
    }

}