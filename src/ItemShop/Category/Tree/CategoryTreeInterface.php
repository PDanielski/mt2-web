<?php


namespace App\ItemShop\Category\Tree;


use App\ItemShop\Category\Category;

interface CategoryTreeInterface {

    /**
     * @return CategoryNode[]
     */
    public function getRoots(): array;

}