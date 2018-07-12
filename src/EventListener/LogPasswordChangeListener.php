<?php


namespace App\EventListener;

use App\Account\Event\PasswordChangedEvent;
use Psr\Log\LoggerInterface;

class LogPasswordChangeListener {

    protected $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public function onPasswordChange(PasswordChangedEvent $event) {
        $this->logger->info("Password changed", [
            'accountId' => $event->getAccountId(),
            'context' => $event->getContext()
        ]);
    }
}