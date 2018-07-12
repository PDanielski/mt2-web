<?php


namespace App\Account;

use Metin2Domain\Account\Account;
use Metin2Domain\Account\Repository\Exception\AccountNotFoundException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AccountRepositoryTest extends KernelTestCase {

    public function testConstructor() {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        $accountRepository = $container->get('test.'.AccountRepository::class);

        $this->assertInstanceOf(AccountRepository::class, $accountRepository);

        return $accountRepository;
    }

    /**
     * @depends testConstructor
     * @param AccountRepository $repository
     * @throws
     */
    public function testGetById(AccountRepository $repository) {
        $account = $repository->getById(14);

        $this->assertInstanceOf(Account::class, $account);
        $this->assertEquals(14, $account->getId());
        $this->assertEquals('account7', $account->getLogin()->getLogin());
        $this->assertEquals('email@email.it', $account->getEmail()->getEmail());
    }

    /**
     * @depends testConstructor
     * @param AccountRepository $repository
     * @throws
     */
    public function testGetByLogin(AccountRepository $repository) {
        $account = $repository->getByLogin('account15');

        $this->assertInstanceOf(Account::class, $account);
        $this->assertEquals(16, $account->getId());
        $this->assertEquals('account15', $account->getLogin()->getLogin());
        $this->assertEquals('email@email.it', $account->getEmail()->getEmail());
    }

    /**
     * @depends testConstructor
     * @param AccountRepository $repository
     * @throws
     */
    public function testGetByIdWithNotExistingId(AccountRepository $repository) {
        $this->expectException(AccountNotFoundException::class);
        $repository->getById(7897242);
    }

    /**
     * @depends testConstructor
     * @param AccountRepository $repository
     * @throws
     */
    public function testGetByLoginWithNotExistingLogin(AccountRepository $repository) {
        $this->expectException(AccountNotFoundException::class);
        $repository->getByLogin('not_existing_login');
    }

}