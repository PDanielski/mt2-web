<?php


namespace App\Account\Repository;

use App\Account\AccountFactoryInterface;
use App\Account\Repository\Exception\AccountNotFoundException;
use App\Database\Exception\DomainPersistenceMismatchException;
use App\Metin2Domain\Account\AccountInterface;
use Doctrine\DBAL\Connection;
use App\Metin2Domain\Account\Email;
use App\Metin2Domain\Account\Exception\EmailNotValidException;
use App\Metin2Domain\Account\Exception\InvalidLoginLengthException;
use App\Metin2Domain\Account\Exception\InvalidPasswordLengthException;
use App\Metin2Domain\Account\Exception\InvalidSocialIdLengthException;
use App\Metin2Domain\Account\Exception\NotNumericSocialIdException;
use App\Metin2Domain\Account\Login;
use App\Metin2Domain\Account\Password;
use App\Metin2Domain\Account\SocialId;

class AccountRepository implements AccountRepositoryInterface {

    protected $conn;

    protected $accountTableName;

    protected $accountFactory;

    protected $selects = ['id', 'login', 'password', 'email', 'social_id', 'status', 'gold', 'warpoints', 'premiumpoints'];

    public function __construct(Connection $connection, string $accountTableName, AccountFactoryInterface $accountFactory) {
        $this->conn = $connection;
        $this->accountTableName = $accountTableName;
        $this->accountFactory = $accountFactory;
    }

    /**
     * @inheritdoc
     * @throws DomainPersistenceMismatchException
     */
    public function getById(int $id): AccountInterface {
        $query = $this->conn->createQueryBuilder();
        $accountData = $query->from($this->accountTableName)
            ->select($this->selects)
            ->where('id = :id')
            ->setParameter('id', $id)
            ->execute()
            ->fetch();

        if(!$accountData)
            throw new AccountNotFoundException();

        return $this->createAccountFromSQLResult($accountData);
    }

    /**
     * @inheritdoc
     * @throws DomainPersistenceMismatchException
     */
    public function getByLogin(string $login): AccountInterface {
        $query = $this->conn->createQueryBuilder();
        $accountData = $query->from($this->accountTableName)
            ->select($this->selects)
            ->where('login = :login')
            ->setParameter('login', $login)
            ->execute()
            ->fetch();

        if(!$accountData)
            throw new AccountNotFoundException();

        return $this->createAccountFromSQLResult($accountData);
    }

    /**
     * @param array $accountData
     * @return AccountInterface
     * @throws DomainPersistenceMismatchException
     */
    protected function createAccountFromSQLResult(array $accountData): AccountInterface {
        try {
            $id = $accountData['id'];
            $login = new Login($accountData['login']);
            $password = new Password($accountData['password'], true);
            $email = new Email($accountData['email']);
            $socialId = new SocialId($accountData['social_id']);
            $status = $accountData['status'];
            $gold = $accountData['gold'];
            $warpoints = $accountData['warpoints'];
            $premiumpoints = $accountData['premiumpoints'];

            $account = $this->accountFactory->create(
                $id,
                $login,
                $email,
                $password,
                $socialId,
                $gold,
                $warpoints,
                $premiumpoints,
                $status
            );
            return $account;

        } catch(InvalidLoginLengthException $invalidLoginLengthException){
            throw new DomainPersistenceMismatchException($invalidLoginLengthException->getMessage());
        } catch(InvalidPasswordLengthException $invalidPasswordLengthException){
            throw new DomainPersistenceMismatchException($invalidPasswordLengthException->getMessage());
        } catch(EmailNotValidException $emailNotValidException) {
            throw new DomainPersistenceMismatchException($emailNotValidException->getMessage());
        } catch(NotNumericSocialIdException $notNumericSocialIdException) {
            throw new DomainPersistenceMismatchException($notNumericSocialIdException->getMessage());
        } catch(InvalidSocialIdLengthException $invalidSocialIdLengthException) {
            throw new DomainPersistenceMismatchException($invalidSocialIdLengthException->getMessage());
        }
    }

}