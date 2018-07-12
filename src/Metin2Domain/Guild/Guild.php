<?php


namespace App\Metin2Domain\Guild;


class Guild {

    protected $id;

    protected $name;

    protected $masterPlayerId;

    protected $level;

    protected $statistics;

    public function __construct(
        int $id,
        string $name,
        int $masterPlayerId,
        int $level = 1,
        GuildStatistics $statistics
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->masterPlayerId = $masterPlayerId;
        $this->level = $level;
        $this->statistics = $statistics;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getMasterPlayerId(): int {
        return $this->masterPlayerId;
    }

    public function getLevel(): int {
        return $this->level;
    }

    public function getStatistics(): GuildStatistics {
        return $this->statistics;
    }

}