<?php


namespace App\Metin2Domain\Item;


final class Item extends ItemInfo {

    protected $id;

    protected $ownerId;

    protected $window;

    protected $position;

    public function __construct(
        int $id,
        int $ownerId,
        string $window,
        int $position,
        int $vnum,
        int $count = 1,
        int $socket0 = 0,
        int $socket1 = 0,
        int $socket2 = 0,
        int $socket3 = 0,
        int $socket4 = 0,
        int $socket5 = 0,
        int $attrType0 = 0,
        int $attrType1 = 0,
        int $attrType2 = 0,
        int $attrType3 = 0,
        int $attrType4 = 0,
        int $attrType5 = 0,
        int $attrType6 = 0,
        int $attrValue0 = 0,
        int $attrValue1 = 0,
        int $attrValue2 = 0,
        int $attrValue3 = 0,
        int $attrValue4 = 0,
        int $attrValue5 = 0,
        int $attrValue6 = 0
    ) {
        parent::__construct(
            $vnum,
            $count,
            $socket0,
            $socket1,
            $socket2,
            $socket3,
            $socket4,
            $socket5,
            $attrType0,
            $attrType1,
            $attrType2,
            $attrType3,
            $attrType4,
            $attrType5,
            $attrType6,
            $attrValue0,
            $attrValue1,
            $attrValue2,
            $attrValue3,
            $attrValue4,
            $attrValue5,
            $attrValue6
        );
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->position = $position;
        $this->window = $window;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getOwnerId(): int {
        return $this->ownerId;
    }

    public function getWindow(): string {
        return $this->window;
    }

    public function getPosition(): int {
        return $this->position;
    }

}