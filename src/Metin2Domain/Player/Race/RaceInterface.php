<?php


namespace App\Metin2Domain\Player\Race;


interface RaceInterface {

    public function isMale(): bool;

    public function getName(): string;

}