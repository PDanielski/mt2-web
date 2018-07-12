<?php


namespace App\Player\Ranking;


use App\Player\Exception\PlayerNotFoundException;

interface PlacedPlayersProviderInterface {

    /**
     * @param int $playerId
     * @return PlacedPlayer
     * @throws PlayerNotFoundException
     */
    public function getByPlayerId(int $playerId): PlacedPlayer;

    /**
     * @param array $playerIds
     * @return PlacedPlayer[]
     */
    public function getByPlayerIds(array $playerIds): array;

    /**
     * @param string $playerName
     * @return PlacedPlayer
     * @throws PlayerNotFoundException
     */
    public function getByPlayerName(string $playerName): PlacedPlayer;

    /**
     * @param string $guildName
     * @return PlacedPlayer[]
     */
    public function getByGuildName(string $guildName): array;

}