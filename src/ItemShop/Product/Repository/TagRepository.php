<?php


namespace App\ItemShop\Product\Repository;


use App\ItemShop\Product\Product;
use App\ItemShop\Product\Repository\Exception\TagNotFoundException;
use App\ItemShop\Product\Tag;
use Doctrine\DBAL\Connection;

class TagRepository implements TagRepositoryInterface {

    protected const TAGS_TABLE = 'ItemShop.tags';

    protected const PRODUCTS_TAGS_TABLE = 'ItemShop.products_tags';

    protected const SELECTS = [
        't.tag_id',
        't.name'
    ];

    protected $conn;

    public function __construct(Connection $connection) {
        $this->conn = $connection;
    }

    public function getById(int $tagId): Tag {
        $queryBuilder = $this->conn->createQueryBuilder();
        $tagData = $queryBuilder
            ->select(...self::SELECTS)
            ->from(self::TAGS_TABLE, 't')
            ->where('tag_id = :tagId')
            ->setParameter('tagId', $tagId)
            ->execute()
            ->fetch();

        if(!$tagData)
            throw new TagNotFoundException();

        return $this->createFromSQLData($tagData);
    }

    public function getByProduct(Product $product): array {
        $queryBuilder = $this->conn->createQueryBuilder();
        $tagsData = $queryBuilder
            ->select(...self::SELECTS)
            ->from(self::PRODUCTS_TAGS_TABLE, 'pt')
            ->join('pc', self::TAGS_TABLE, 't', 't.tag_id = pt.tag_id')
            ->where('product_id = :productId')
            ->setParameter('productId', $product->getId())
            ->execute()
            ->fetchAll();

        $tags = [];
        foreach($tagsData as $tagData) {
            $tags[] = $this->createFromSQLData($tagData);
        }

        return $tags;
    }

    protected function createFromSQLData(array $tagData): Tag {
        return new Tag(
            $tagData['tag_id'],
            $tagData['name']
        );
    }

}