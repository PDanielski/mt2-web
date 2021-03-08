<?php


namespace App\Player\Ranking;

class PlacedPlayer {

    protected $id;

    protected $position;

    protected $accountId;

    protected $name;

    protected $level;

    protected $raceName;

    protected $kingdomName;

    protected $guildName;

    protected $minutesPlayed;

    protected $mmr;

    protected $tower_lv;

    protected $prestige;

    public function __construct(
        int $id,
        int $accountId,
        string $name,
        int $level,
        string $raceName,
        string $kingdomName,
        string $guildName,
        int $minutesPlayed,
        int $mmr,
        int $tower_lv,
        int $prestige = 1
    ) {
        $this->id = $id;
        $this->accountId = $accountId;
        $this->name = $name;
        $this->level = $level;
        $this->raceName = $raceName;
        $this->kingdomName = $kingdomName;
        $this->guildName = $guildName;
        $this->minutesPlayed = $minutesPlayed;
        $this->mmr = $mmr;
        $this->tower_lv = $tower_lv;
        $this->prestige = $prestige;
        $this->position = 0;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getPosition(): int {
        return $this->position;
    }

    public function setPosition(int $position): void {
        $this->position = $position;
    }

    public function getAccountId(): int {
        return $this->accountId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getLevel(): int {
        return $this->level;
    }

    public function getTowerLv(): int {
        return $this->tower_lv;
    }

    public function getRaceName(): string {
        return $this->raceName;
    }

    public function getKingdomName(): string {
        return $this->kingdomName;
    }

    public function getGuildName(): string {
        return $this->guildName;
    }

    public function getMinutesPlayed(): int {
        return $this->minutesPlayed;
    }

    public function getMmr(): int {
        return $this->mmr;
    }

    public function getPrestige(): int {
        return $this->prestige;
    }

}