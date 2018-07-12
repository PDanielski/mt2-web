<?php


namespace App\EventListener;


use App\Account\Event\AccountCreatedEvent;
use Psr\Log\LoggerInterface;

class LogAccountCreationListener {

    protected $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public function onAccountCreated(AccountCreatedEvent $event) {
        $this->logger->info("Account created", [
            'id'=>$event->getCreatedAccount()->getId(),
            'login' => $event->getCreatedAccount()->getLogin()->getLogin()
        ]);
    }

}