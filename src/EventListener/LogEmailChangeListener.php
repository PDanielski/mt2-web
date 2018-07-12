<?php


namespace App\EventListener;


use App\Account\Event\EmailChangedEvent;
use Psr\Log\LoggerInterface;

class LogEmailChangeListener {

    protected $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public function onEmailChange(EmailChangedEvent $event) {
        $this->logger->info("Email changed", [
            'id' => $event->getAccountId(),
            'email' => $event->getNewEmail()->getEmail()
        ]);
    }

}