<?php


namespace App\Player\Ranking;


use App\Metin2Domain\Player\Race\RaceFactory;
use App\Player\Exception\PlayerNotFoundException;
use Doctrine\DBAL\Connection;
use App\Metin2Domain\Kingdom\KingdomFactory;

class SqlPlacedPlayersProvider implements PlacedPlayersProviderInterface {

    protected $conn;

    protected $table;

    public function __construct(Connection $connection, string $table) {
        $this->conn = $connection;
        $this->table = $table;
    }

    /** @inheritdoc */
    public function getByPlayerId(int $playerId): PlacedPlayer {
        $queryBuilder = $this->conn->createQueryBuilder();

        $data = $queryBuilder
                        ->select('*')
                        ->from($this->table)
                        ->where('id = :id')
                        ->setParameter('id', $playerId)
                        ->execute()
                        ->fetch();

        if($data) {
            return $this->createPlacedPlayerFromResult($data);
        } else {
            throw new PlayerNotFoundException("The player with id {$playerId} was not found");
        }
    }

    /** @inheritdoc */
    public function getByPlayerIds(array $playerIds): array {
        if(count($playerIds) == 0) return [];

        $queryBuilder = $this->conn->createQueryBuilder();

        $moreData = $queryBuilder
                            ->select('*')
                            ->from($this->table)
                            ->where('id IN(:ids)')
                            ->setParameter('ids', $playerIds, Connection::PARAM_INT_ARRAY)
                            ->execute()
                            ->fetchAll();

        $placedPlayers = [];
        foreach($moreData as $data) {
            $placedPlayers[$data['id']] = $this->createPlacedPlayerFromResult($data);
        }

        return $placedPlayers;
    }

    /** @inheritdoc */
    public function getByPlayerName(string $playerName): PlacedPlayer {
        $queryBuilder = $this->conn->createQueryBuilder();

        $data = $queryBuilder
                        ->select('*')
                        ->from($this->table)
                        ->where('name = :name')
                        ->setParameter('name', $playerName)
                        ->execute()
                        ->fetch();

        if($data) {
            return $this->createPlacedPlayerFromResult($data);
        } else {
            throw new PlayerNotFoundException("The player with name {$playerName} does not exist");
        }
    }

    /** @inheritdoc */
    public function getByGuildName(string $guildName): array {
        $queryBuilder = $this->conn->createQueryBuilder();

        $moreData = $queryBuilder
            ->select('*')
            ->from($this->table)
            ->where('guild_name=:guildName')
            ->setParameter('guildName', $guildName)
            ->execute()
            ->fetchAll();

        if(!$moreData)
            return [];

        $placedPlayers = [];
        foreach($moreData as $data) {
            $placedPlayers[$data['id']] = $this->createPlacedPlayerFromResult($data);
        }

        return $placedPlayers;
    }

    protected function createPlacedPlayerFromResult(array $data): PlacedPlayer {
        $placedPlayer = new PlacedPlayer(
            $data['id'],
            $data['account_id'],
            $data['name'],
            $data['level'],
            RaceFactory::fromCode($data['job'])->getName(),
            KingdomFactory::fromCode($data['empire'])->getName(),
            $data['guild_name'] ?? 'no guild',
            $data['playtime'],
            $data['mmr'] ?? 0,
            $data['prestige'] ?? 0
        );

        return $placedPlayer;
    }

}