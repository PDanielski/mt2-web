<?php


namespace App\EventListener;

use App\Item\Event\ItemSentEvent;
use Psr\Log\LoggerInterface;

class LogItemDeliveryListener {

    protected $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public function onItemSent(ItemSentEvent $event) {
        $this->logger->info(
            "Item sent",
            [
                'inventory' => $event->getInventory()->getName(),
                'vnum' => $event->getRequest()->getVnum(),
                'ownerId' => $event->getRequest()->getReceiverId()
            ]
        );
    }
}