<?php


namespace App\ItemShop\Category\Tree;


use App\ItemShop\Category\Category;

class CategoryNode {

    protected $parent;

    protected $category;

    protected $children;

    public function __construct(Category $category, CategoryNode $parent = null, array $children = []) {
        $this->category = $category;
        $this->parent = $parent;
        $this->children = $children;
    }

    public function setParent(?CategoryNode $parent): void {
        $this->parent = $parent;
    }

    public function getParent(): ?CategoryNode {
        return $this->parent;
    }

    public function addChildren(CategoryNode $node) {
        $this->children[] = $node;
    }

    public function getChildren(): array {
        return $this->children;
    }

    public function hasChildren(): bool {
        return count($this->children) > 0;
    }

    public function isRoot(): bool {
        return !(bool)$this->parent;
    }

    public function isLeaf(): bool {
        return count($this->children) === 0;
    }

    public function getCategory(): Category {
        return $this->category;
    }

}