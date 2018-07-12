<?php


namespace App\Metin2Domain\Item;


class ItemInfo {

    protected $vnum;

    protected $count;

    protected $socket0;

    protected $socket1;

    protected $socket2;

    protected $socket3;

    protected $socket4;

    protected $socket5;

    protected $attrType0;

    protected $attrType1;

    protected $attrType2;

    protected $attrType3;

    protected $attrType4;

    protected $attrType5;

    protected $attrType6;

    protected $attrValue0;

    protected $attrValue1;

    protected $attrValue2;

    protected $attrValue3;

    protected $attrValue4;

    protected $attrValue5;

    protected $attrValue6;

    public function __construct(
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
        $this->vnum = $vnum;
        $this->count = $count;

        $this->socket0 = $socket0;
        $this->socket1 = $socket1;
        $this->socket2 = $socket2;
        $this->socket3 = $socket3;
        $this->socket4 = $socket4;
        $this->socket5 = $socket5;
        $this->attrType0 = $attrType0;
        $this->attrType1 = $attrType1;
        $this->attrType2 = $attrType2;
        $this->attrType3 = $attrType3;
        $this->attrType4 = $attrType4;
        $this->attrType5 = $attrType5;
        $this->attrType6 = $attrType6;
        $this->attrValue0 = $attrValue0;
        $this->attrValue1 = $attrValue1;
        $this->attrValue2 = $attrValue2;
        $this->attrValue3 = $attrValue3;
        $this->attrValue4 = $attrValue4;
        $this->attrValue5 = $attrValue5;
        $this->attrValue6 = $attrValue6;
    }


    public function getVnum(): int { return $this->vnum; }

    public function getCount(): int { return $this->count; }

    public function getSocket0(): int { return $this->socket0; }

    public function getSocket1(): int { return $this->socket1; }

    public function getSocket2(): int { return $this->socket2; }

    public function getSocket3(): int { return $this->socket3; }

    public function getSocket4(): int { return $this->socket4; }

    public function getSocket5(): int { return $this->socket5; }

    public function getAttrType0(): int { return $this->attrType0; }

    public function getAttrType1(): int { return $this->attrType1; }

    public function getAttrType2(): int { return $this->attrType2; }

    public function getAttrType3(): int { return $this->attrType3; }

    public function getAttrType4(): int { return $this->attrType4; }

    public function getAttrType5(): int { return $this->attrType5; }

    public function getAttrType6(): int { return $this->attrType6; }

    public function getAttrValue0(): int { return $this->attrValue0; }

    public function getAttrValue1(): int { return $this->attrValue1; }

    public function getAttrValue2(): int { return $this->attrValue2; }

    public function getAttrValue3(): int { return $this->attrValue3; }

    public function getAttrValue4(): int { return $this->attrValue4; }

    public function getAttrValue5(): int { return $this->attrValue5; }

    public function getAttrValue6(): int { return $this->attrValue6; }
}