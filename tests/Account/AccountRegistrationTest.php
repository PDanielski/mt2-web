<?php

namespace App\Account;

use Metin2Domain\Account\Command\CreateAccountCommand;
use Metin2Domain\Account\Command\Exception\DuplicateAccountException;
use Metin2Domain\Account\Email;
use Metin2Domain\Account\Event\AccountCreatedEvent;
use Metin2Domain\Account\Login;
use Metin2Domain\Account\Password;
use Metin2Domain\Account\SocialId;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AccountRegistrationTest extends KernelTestCase {

    public function testConstructor(){
        self::bootKernel();
        $container = self::$kernel->getContainer();

        $accountRegistration = $container->get('test.'.AccountRegistration::class);

        $this->assertInstanceOf(AccountRegistration::class, $accountRegistration);

        return $accountRegistration;
    }

    /**
     * @depends testConstructor
     * @param AccountRegistration $registration
     * @throws
     */
    public function testRegisterSuccess(AccountRegistration $registration) {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        $command = new CreateAccountCommand(
            $this->createRandomLogin(),
            new Email('test@test.it'),
            new Password('testpassword'),
            new SocialId(1231231)
        );

        //Necessary for adding a listener to the dispatcher hold by the $registration object
        $registrationReflected = new \ReflectionClass($registration);
        $dispatcherProperty = $registrationReflected->getProperty('dispatcher');
        $dispatcherProperty->setAccessible(true);
        $dispatcher = $dispatcherProperty->getValue($registration);

        $eventFired = false;
        $accountFromEvent = null;
        $checkListener = function (AccountCreatedEvent $event) use (&$eventFired, &$accountFromEvent) {
            $accountFromEvent = $event->getCreatedAccount();
            $eventFired = true;
        };

        $dispatcher->addListener('app.account.created', $checkListener);

        $createdAccount = $registration->register($command);

        /** @var AccountRepository $accountRepository */
        $accountRepository = $container->get('test.'.AccountRepository::class);
        $persistedAccount = $accountRepository->getById($createdAccount->getId());

        $this->assertEquals($createdAccount, $persistedAccount);

        $this->assertTrue($eventFired);
        $this->assertEquals($persistedAccount, $accountFromEvent);
    }

    /**
     * @depends testConstructor
     * @param AccountRegistration $registration
     * @throws
     */
    public function testRegisterDuplicationFailure(AccountRegistration $registration) {
        $command = new CreateAccountCommand(
            new Login('account'),
            new Email('test@test.it'),
            new Password('testpassword'),
            new SocialId(1231231)
        );

        $this->expectException(DuplicateAccountException::class);
        $registration->register($command);
    }

    protected function createRandomLogin(): Login {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ12345679';
        $shuffled = str_shuffle($chars);
        $loginString = 'test'.substr($shuffled, 0, Login::MAX_LENGTH - 4);
        return new Login($loginString);
    }

}