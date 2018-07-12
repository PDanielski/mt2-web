<?php


namespace App\ItemShop\Product;

use App\ItemShop\Discount\Discount;
use App\ItemShop\Media\Hrefable;

class Product {

    protected $id;

    protected $name;

    protected $description;

    protected $trailer;

    protected $thumbnail;

    protected $price;

    protected $insertionTime;

    protected $discount = null;

    /**
     * Product constructor.
     * @param int $id
     * @param string $name
     * @param string $description
     * @param string $trailer
     * @param Hrefable $thumbnail
     * @param Price $price
     * @param \DateTimeImmutable $insertionTime
     */
    public function __construct(
        int $id,
        string $name,
        string $description,
        string $trailer,
        Hrefable $thumbnail,
        Price $price,
        \DateTimeImmutable $insertionTime
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->trailer = $trailer;
        $this->thumbnail = $thumbnail;
        $this->price = $price;
        $this->insertionTime = $insertionTime;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getTrailer(): string {
        return $this->trailer;
    }

    public function getThumbnail(): Hrefable {
        return $this->thumbnail;
    }

    public function getPrice(): Price {
        return $this->price;
    }

    public function applyDiscount(Discount $discount) {
        $this->discount = $discount;
        $this->price = $discount->getDiscountedPrice();
    }

    public function getDiscount(): ?Discount {
        return $this->discount;
    }

    public function isDiscounted(): bool {
        return (bool)$this->discount;
    }

    public function getInsertionTime(): \DateTimeImmutable {
        return $this->insertionTime;
    }

}