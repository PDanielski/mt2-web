<?php


namespace App\Account\EventListener;


use App\Account\Event\AccountBlockedEvent;
use Doctrine\DBAL\Connection;

class RecordBlockListener {

    protected $conn;

    public function __construct(Connection $conn) {
        $this->conn = $conn;
    }

    public function onAccountBlocked(AccountBlockedEvent $event) {
        $block = $event->getBlock();
        $queryBuilder = $this->conn->createQueryBuilder();
        $queryBuilder
            ->insert('account.account_blocks')
            ->values([
                'whoBlocked' => ':whoBlocked',
                'whoWasBlocked' => ':whoWasBlocked',
                'reason' => ':reason',
                'time' => ':time',
                'isPermanent' => ':isPermanent',
                'whenExpires' => ':whenExpires'
            ])
            ->setParameters([
                'whoBlocked' => $block->getWhoBlocked(),
                'whoWasBlocked' => $block->getWhoWasBlocked(),
                'reason' => $block->getReason(),
                'time' => $block->getWhen()->format('Y-m-d H:i:s'),
                'isPermanent' => $block->isPermanent()?1:0,
                'whenExpires' => $block->getWhenExpires()? $block->getWhenExpires()->format('Y-m-d H:i:s'):null
            ])
            ->execute();
    }
}