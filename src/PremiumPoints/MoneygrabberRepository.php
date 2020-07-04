<?php


namespace App\PremiumPoints;

use Doctrine\DBAL\Connection;

class MoneygrabberRepository implements MoneygrabberRepositoryInterface {

    protected $conn;

    protected $tableName;

    protected $selects = ['id', 'earnings', 'percentage', 'email', 'earnOffset'];

    public function __construct(Connection $connection, string $tableName) {
        $this->conn = $connection;
        $this->tableName = $tableName;
    }

    public function getById(int $id): Moneygrabber {
        $queryBuilder = $this->conn->createQueryBuilder();
        $data = $queryBuilder
            ->select(...$this->selects)
            ->from($this->tableName)
            ->where('id = :id')
            ->setParameter('id', $id)
            ->execute()
            ->fetch();

        if(!$data)
            return null;

        return $this->buildMoneygrabberFromData($data);
    }

    public function getByEmail(string $email): Moneygrabber {
        $queryBuilder = $this->conn->createQueryBuilder();
        $data = $queryBuilder
            ->select(...$this->selects)
            ->from($this->tableName)
            ->where('email = :email')
            ->setParameter('email', $email)
            ->execute()
            ->fetch();

        if(!$data)
            return null;

        return $this->buildMoneygrabberFromData($data);
    }

    public function getPoorest(): Moneygrabber {
        $queryBuilder = $this->conn->createQueryBuilder();
        $data = $queryBuilder
            ->select(...$this->selects)
            ->from($this->tableName)
            ->execute()
            ->fetchAll();

        if(!$data)
            return null;

        $totalEarnings = 0;
        foreach($data as $moneygrabber){
            $totalEarnings+= $moneygrabber['earnings'];
        }

        $highestCredit = 0.0;
        $highestCreditOwner = $data[0];

        foreach($data as $moneygrabber){
            $moneyDeserved = $totalEarnings * $moneygrabber['percentage'];
            $moneyReceived = $moneygrabber['earnings'];
            $moneyReceived += $moneygrabber['earnOffset'];
            $credit = $moneyDeserved - $moneyReceived;
            if($credit >= $highestCredit){
                $highestCredit = $credit;
                $highestCreditOwner = $moneygrabber;
            }
        }

        return $this->buildMoneygrabberFromData($highestCreditOwner);
    }

    public function addEarnings(string $email, int $earnings): void {
        $queryBuilder = $this->conn->createQueryBuilder();
        $queryBuilder
        ->update($this->tableName)
        ->set('earnings', ':earnings')
        ->setParameter('earnings', $earnings)
        ->where('email = :email')
        ->setParameter('email', $email)
        ->execute();
    }

    protected function buildMoneygrabberFromData(array $data): Moneygrabber {
        return new Moneygrabber(
            $data['id'],
            $data['earnings'],
            $data['earnOffset'],
            $data['percentage'],
            $data['email']
        );
    }

}