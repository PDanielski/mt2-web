<?php


namespace App\Account;


use Metin2Domain\Account\Email;
use Metin2Domain\Account\Event\EmailChangedEvent;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EmailChangerTest extends KernelTestCase {

    public function testConstructor() {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        $emailChanger = $container->get('test.'.EmailChanger::class);
        $this->assertInstanceOf(EmailChanger::class, $emailChanger);

        return $emailChanger;
    }

    /**
     * @depends testConstructor
     * @param EmailChanger $changer
     * @throws
     */
    public function testChange(EmailChanger $changer) {
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
        $emailFromEvent = null;
        $checkListener = function (EmailChangedEvent $event) use (&$eventFired, &$emailFromEvent) {
            $emailFromEvent = $event->getNewEmail();
            $eventFired = true;
        };
        $dispatcher->addListener('app.account.email_changed', $checkListener);

        $changer->change($accountBeforeChange->getId(), new Email("email-changed@email.it"));

        $accountAfterChange = $accountRepository->getByLogin('account');

        $this->assertEquals('email-changed@email.it', $accountAfterChange->getEmail()->getEmail());
        $this->assertTrue($eventFired);
        $this->assertEquals($emailFromEvent, $accountAfterChange->getEmail());

        $changer->change($accountBeforeChange->getId(), $accountBeforeChange->getEmail());

        $accountAfterUndoChange = $accountRepository->getByLogin('account');

        $this->assertEquals($accountBeforeChange->getEmail()->getEmail(),
            $accountAfterUndoChange->getEmail()->getEmail());

    }
}