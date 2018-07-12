<?php


namespace App\Account;


use Metin2Domain\Account\Event\PasswordChangedEvent;
use Metin2Domain\Account\Password;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PasswordChangerTest extends KernelTestCase {

    public function testConstructor() {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        $emailChanger = $container->get('test.'.PasswordChanger::class);
        $this->assertInstanceOf(PasswordChanger::class, $emailChanger);

        return $emailChanger;
    }

    /**
     * @depends testConstructor
     * @param PasswordChanger $changer
     * @throws
     */
    public function testChange(PasswordChanger $changer) {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        /** @var AccountRepository $accountRepository */
        $accountRepository = $container->get('test.'.AccountRepository::class);

        $accountBeforeChange = $accountRepository->getByLogin('account');

        //Necessary for adding a listener to the dispatcher hold by the $registration object
        $registrationReflected = new \ReflectionClass($changer);
        $dispatcherProperty = $registrationReflected->getProperty('dispatcher');
        $dispatcherProperty->setAccessible(true);
        $dispatcher = $dispatcherProperty->getValue($changer);

        $eventFired = false;
        $passwordFromEvent = null;
        $checkListener = function (PasswordChangedEvent $event) use (&$eventFired, &$passwordFromEvent) {
            $passwordFromEvent = $event->getNewPassword();
            $eventFired = true;
        };
        $dispatcher->addListener('app.account.password_changed', $checkListener);

        $newPassword = new Password("newPassword");
        $changer->change($accountBeforeChange->getId(), $newPassword);

        $accountAfterChange = $accountRepository->getByLogin('account');

        $this->assertEquals($newPassword->getEncryptedPassword(), $accountAfterChange->getPassword()->getEncryptedPassword());
        $this->assertTrue($eventFired);
        $this->assertEquals($passwordFromEvent, $accountAfterChange->getPassword());

        $changer->change($accountBeforeChange->getId(), $accountBeforeChange->getPassword());

        $accountAfterUndoChange = $accountRepository->getByLogin('account');

        $this->assertEquals($accountBeforeChange->getPassword()->getEncryptedPassword(),
            $accountAfterUndoChange->getPassword()->getEncryptedPassword());

    }
}