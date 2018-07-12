<?php


namespace App\Metin2Domain\Player\Race;


class RaceFactory {

    public static function fromCode(int $code): RaceInterface {
        switch($code) {
            case RaceCode::WARRIOR_MALE:
                return new Warrior();
            case RaceCode::NINJA_FEMALE:
                return new Ninja(false);
            case RaceCode::SURA_MALE:
                return new Sura();
            case RaceCode::SHAMAN_FEMALE:
                return new Shaman(false);
            case RaceCode::WARRIOR_FEMALE:
                return new Warrior(false);
            case RaceCode::NINJA_MALE:
                return new Ninja();
            case RaceCode::SURA_FEMALE:
                return new Sura(false);
            case RaceCode::SHAMAN_MALE:
                return new Shaman();
            case RaceCode::LYCAN_MALE:
                return new Lycan();
            default:
                throw new \RuntimeException("The code {$code} has no race associated");
        }
    }

}