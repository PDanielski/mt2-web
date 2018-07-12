<?php


namespace App\Metin2Domain\Player;


use App\Metin2Domain\Kingdom\KingdomInterface;
use App\Metin2Domain\Player\Race\RaceInterface;

class Player {

    protected $id;

    protected $accountId;

    protected $name;

    protected $kingdom;

    protected $race;

    protected $level;

    protected $lastPlayTime;

    protected $playtime;

    protected $mmr;

    protected $ip;

    public function __construct(
        int $id,
        int $accountId,
        string $name,
        int $level,
        RaceInterface $race,
        KingdomInterface $kingdom,
        \DateTimeImmutable $lastPlayTime,
        \DateInterval $playtime,
        int $mmr,
        string $ip
    ) {
        $this->id = $id;
        $this->accountId = $accountId;
        $this->name = $name;
        $this->race = $race;
        $this->kingdom = $kingdom;
        $this->level = $level;
        $this->lastPlayTime = $lastPlayTime;
        $this->playtime = $playtime;
        $this->mmr = $mmr;
        $this->ip = $ip;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getAccountId(): int {
        return $this->accountId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getRace(): RaceInterface {
        return $this->race;
    }

    public function getKingdom(): KingdomInterface {
        return $this->kingdom;
    }

    public function getLevel(): int {
        return $this->level;
    }

    public function getLastPlayTime(): \DateTimeImmutable {
        return $this->lastPlayTime;
    }

    public function getPlaytime(): \DateInterval {
        return $this->playtime;
    }

    public function getMmr(): int {
        return $this->mmr;
    }

    public function getIp(): string {
        return $this->ip;
    }

}