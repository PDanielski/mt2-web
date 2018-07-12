<?php


namespace App\Metin2Domain\Kingdom;


class KingdomFactory {

    public static function fromCode(int $code): KingdomInterface {
        switch($code) {
            case 0:
                return new class implements KingdomInterface {
                    public function getName(): string {
                        return "unknown";
                    }
                };
            case 1:
                return new Shinsoo;
            case 2:
                return new Chunjo;
            case 3:
                return new Jinno;
            default:
                throw new \RuntimeException("Kingdom with code {$code} does not exist");
        }
    }

}