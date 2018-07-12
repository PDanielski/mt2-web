<?php


namespace App\Metin2Domain\Guild;


class GuildStatistics {

    protected $numberOfWins;

    protected $numberOfLoses;

    protected $numberOfDraws;

    protected $ladderPoints;

    public function __construct(
        int $numberOfWins,
        int $numberOfLoses,
        int $numberOfDraws,
        int $ladderPoints
    ) {
        $this->numberOfWins = $numberOfWins;
        $this->numberOfLoses = $numberOfLoses;
        $this->numberOfDraws = $numberOfDraws;
        $this->ladderPoints = $ladderPoints;
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