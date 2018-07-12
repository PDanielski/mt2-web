<?php


namespace App\Player\Ranking;



use App\Player\Exception\PlayerNotFoundException;

interface PlayerRankingInterface {

    /**
     * @param int $offset
     * @param int $limit
     * @return array[int]PlacedPlayer
     */
    public function get(int $offset = 0, int $limit = 0): array;

    /**
     * @param string $name
     * @return PlacedPlayer
     * @throws PlayerNotFoundException
     */
    public function getByName(string $name): PlacedPlayer;

    /**
     * @return int
     */
    public function getNumOfRankedPlayers(): int;

    /**
     * @param string $guildName
     * @return array[int]PlacedPlayer
     */
    public function getByGuildName(string $guildName): array;

    /**
     * @return PlayerRankingMetaInterface
     */
    public function getMetaInfo(): PlayerRankingMetaInterface;

    /**
     * @return string
     */
    public function getId(): string;

}