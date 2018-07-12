<?php


namespace App\Metin2Domain\Guild\Ranking;


class GuildRankingDTO {

    protected $name;

    protected $masterName;

    protected $level;

    protected $numberOfWins;

    protected $numberOfLoses;

    protected $numberOfDraws;

    protected $ladderPoints;

    public function __construct(
        string $name,
        string $masterName,
        int $level,
        int $numberOfWins,
        int $numberOfLoses,
        int $numberOfDraws,
        int $ladderPoints
    ) {
        $this->name = $name;
        $this->masterName = $masterName;
        $this->level = $level;
        $this->numberOfDraws = $numberOfDraws;
        $this->numberOfLoses = $numberOfLoses;
        $this->numberOfWins = $numberOfWins;
        $this->ladderPoints = $ladderPoints;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getMasterName(): string {
        return $this->masterName;
    }

    public function getLevel(): int {
        return $this->level;
    }

    public function getNumberOfWins(): int {
        return $this->numberOfWins;
    }

    public function getNumberOfLoses(): int {
        return $this->numberOfLoses;
    }

    public function getNumberOfDraws(): int {
        return $this->numberOfDraws;
    }

    public function getLadderPoints(): int {
        return $this->ladderPoints;
    }

}