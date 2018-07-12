<?php


namespace App\Metin2Domain\Player\Race;


abstract class Race implements RaceInterface {

    protected $isMale;

    public function __construct(bool $isMale = true) {
        $this->isMale = $isMale;
    }

    public function isMale(): bool {
        return $this->isMale;
    }

    public function getName():string {
        $gender = $this->isMale()? 'male' : 'female';
        return $this->getUnisexName() . '_' . $gender;
    }

    public function __toString() {
        return $this->getName();
    }

    protected abstract function getUnisexName(): string;

}