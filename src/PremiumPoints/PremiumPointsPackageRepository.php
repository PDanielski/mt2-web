<?php


namespace App\PremiumPoints;

use Doctrine\DBAL\Connection;

class PremiumPointsPackageRepository implements PremiumPointsPackageRepositoryInterface {

    protected $conn;

    protected $tableName;

    protected $selects = ['id', 'cost', 'points', 'name', 'description'];

    public function __construct(Connection $connection, string $tableName) {
        $this->conn = $connection;
        $this->tableName = $tableName;
    }


    public function getAll(): array {
        $queryBuilder = $this->conn->createQueryBuilder();
        $data = $queryBuilder
            ->select(...$this->selects)
            ->from($this->tableName)
            ->execute()
            ->fetchAll();

        if(!$data)
            return array();

        $return = array();
        foreach($data as $package) {
            $return[] =  $this->buildPackageFromData($package);
        }
        return $return;
    }
    public function getById(int $id): PremiumPointsPackage {
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

        return $this->buildPackageFromData($data);
    }

    public function getByName(string $name): PremiumPointsPackage {
        $queryBuilder = $this->conn->createQueryBuilder();
        $data = $queryBuilder
            ->select(...$this->selects)
            ->from($this->tableName)
            ->where('name = :name')
            ->setParameter('name', $name)
            ->execute()
            ->fetch();

        if(!$data)
            return null;

        return $this->buildPackageFromData($data);
    }

    protected function buildPackageFromData(array $data): PremiumPointsPackage {
        return new PremiumPointsPackage(
            $data['id'],
            $data['name'],
            $data['description'],
            $data['cost'],
            $data['points']
        );
    }

}