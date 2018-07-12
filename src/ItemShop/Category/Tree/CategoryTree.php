<?php


namespace App\ItemShop\Category\Tree;


use App\ItemShop\Category\Category;
use Doctrine\DBAL\Connection;

class CategoryTree implements CategoryTreeInterface {

    protected const CATEGORIES_TABLE = "itemshop.categories";

    protected $conn;

    public function __construct(Connection $connection) {
        $this->conn = $connection;
    }

    public function getRoots(): array {
        $queryBuilder = $this->conn->createQueryBuilder();
        $categoryRows = $queryBuilder
            ->select('*')
            ->from(self::CATEGORIES_TABLE)
            ->execute()
            ->fetchAll();

        /** @var CategoryNode[] $idToCategoryNode */
        $idToCategoryNode = [];
        $idToParent = [];
        $parentToIds = [];

        //Instantiate the nodes and gather information about the linkage between them
        foreach($categoryRows as $row) {
            $category = new Category(
                $row['category_id'],
                $row['name'],
                $row['trailer'],
                $row['description'],
                $row['link_segment']
            );
            $node = new CategoryNode($category);
            $idToCategoryNode[$row['category_id']] = $node;

            $idToParent[$row['category_id']] = (int)$row['parent_id']?:0;
            if(isset($parentToIds[$row['parent_id']])){
                $parentToIds[$row['parent_id']][] = (int)$row['category_id'];
            } else {
                $parentToIds[$row['parent_id']] = [(int)$row['category_id']];
            }
        }

        $roots = [];

        //Connect the nodes and find roots
        foreach($idToCategoryNode as $id => $node) {
            $parentNode = $idToParent[$id] ? $idToCategoryNode[$id] : null;
            $idToCategoryNode[$id]->setParent($parentNode);

            if(isset($parentToIds[$id])) {
                foreach($parentToIds[$id] as $childId) {
                    $idToCategoryNode[$id]->addChildren($idToCategoryNode[$childId]);
                }
            }

            if($idToCategoryNode[$id]->isRoot())
                $roots[] = $idToCategoryNode[$id];
        }

        return $roots;
    }

}