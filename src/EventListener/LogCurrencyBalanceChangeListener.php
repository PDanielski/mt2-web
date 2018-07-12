<?php


namespace App\EventListener;

use App\Wallet\Event\CurrencyBalanceChangedEvent;
use Psr\Log\LoggerInterface;

class LogCurrencyBalanceChangeListener {

    protected $logger;

    public function __construct(LoggerInterface $logger){
        $this->logger = $logger;
    }

    public function onCurrencyBalanceChange(CurrencyBalanceChangedEvent $event) {
        $currencyName = ucfirst($event->getCurrencyName());
        $this->logger->info(
            "{$currencyName} balance changed for owner id {$event->getOwnerId()}",
            ['oldBalance' => $event->getOldBalance(), 'newBalance' => $event->getNewBalance()]
        );
    }
}