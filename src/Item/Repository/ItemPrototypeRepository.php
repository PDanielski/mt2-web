<?php


namespace App\Item\Repository;


use Doctrine\DBAL\Connection;
use App\Metin2Domain\Item\ItemPrototype;

class ItemPrototypeRepository implements ItemPrototypeRepositoryInterface {

    protected $conn;

    protected $itemProtoTable;

    public function __construct(Connection $conn, string $itemProtoTable) {
        $this->conn = $conn;
        $this->itemProtoTable = $itemProtoTable;
    }

    /** @inheritdoc */
    public function getByVnum(int $vnum): ItemPrototype {
        $queryBuilder = $this->conn->createQueryBuilder();
        $sqlResult = $queryBuilder
            ->from($this->itemProtoTable)
            ->select('size', 'vnum')
            ->where('vnum = :vnum')
            ->setParameter('vnum', $vnum)
            ->execute()
            ->fetch();
       return new ItemPrototype($sqlResult['vnum'], $sqlResult['size']);
    }

}