<?php


namespace App\Account\Registration;

use App\Account\Event\AccountCreatedEvent;
use App\Account\Exception\DuplicateAccountException;
use App\Account\Request\CreateAccountRequest;
use Doctrine\DBAL\Connection;
use App\Metin2Domain\Account\Account;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AccountRegistration implements AccountRegistrationInterface {

    protected $conn;

    protected $dispatcher;

    protected $duplicationSpecification;

    protected $accountTableName;

    public function __construct(
        Connection $connection,
        DuplicationSpecification $duplicationSpecification,
        string $accountTableName
    ) {
        $this->conn = $connection;
        $this->duplicationSpecification = $duplicationSpecification;
        $this->accountTableName = $accountTableName;
    }

    /** @inheritdoc */
    public function register(CreateAccountRequest $request): Account {
        if($this->duplicationSpecification->isSatisfiedBy($request)){
            $query = $this->conn->createQueryBuilder();

            $query->insert($this->accountTableName)
                ->values([
                    'login' => ':login',
                    'password' => ':password',
                    'social_id' => ':socialId',
                    'email' => ':email'
                ])
                ->setParameter('login', $request->getLogin())
                ->setParameter('password', $request->getPassword())
                ->setParameter('email', $request->getEmail())
                ->setParameter('socialId', $request->getSocialId())
                ->execute();

            $account = new Account(
                $this->conn->lastInsertId(),
                $request->getLogin(),
                $request->getEmail(),
                $request->getPassword(),
                $request->getSocialId()
            );

            return $account;
        } else throw new DuplicateAccountException($request);
    }
}