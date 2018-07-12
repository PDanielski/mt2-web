<?php


namespace App\Player;


use App\Metin2Domain\Kingdom\KingdomFactory;
use App\Metin2Domain\Player\Player;
use App\Metin2Domain\Player\Race\RaceFactory;
use App\Player\Exception\PlayerNotFoundException;
use Doctrine\DBAL\Connection;

class PlayerRepository implements PlayerRepositoryInterface {

    protected $conn;

    protected $tableName;

    protected $selects = ['p.id', 'p.account_id', 'p.name', 'p.job', 'p.playtime', 'p.level', 'p.mmr', 'p.last_play', 'p.ip', 'i.empire'];

    public function __construct(Connection $connection, string $tableName) {
        $this->conn = $connection;
        $this->tableName = $tableName;
    }

    public function getById(int $id): Player {
        $queryBuilder = $this->conn->createQueryBuilder();
        $playerData = $queryBuilder
            ->select(...$this->selects)
            ->from($this->tableName, 'p')
            ->leftJoin('p', 'player.player_index','i', 'p.account_id = i.id')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->execute()
            ->fetch();

        if(!$playerData)
            throw new PlayerNotFoundException("The player with id {$id} does not exist");

        return $this->buildPlayerFromData($playerData);
    }

    public function getByName(string $name): Player {
        $queryBuilder = $this->conn->createQueryBuilder();
        $playerData = $queryBuilder
            ->select(...$this->selects)
            ->from($this->tableName, 'p')
            ->leftJoin('p', 'player.player_index','i', 'p.account_id = i.id')
            ->where('name = :name')
            ->setParameter('name', $name)
            ->execute()
            ->fetch();

        if(!$playerData)
            throw new PlayerNotFoundException("The player with name {$name} does not exist");

        return $this->buildPlayerFromData($playerData);
    }

    public function getByAccountId(int $accountId): array {
        $queryBuilder = $this->conn->createQueryBuilder();
        $playersData = $queryBuilder
            ->select(...$this->selects)
            ->from($this->tableName, 'p')
            ->leftJoin('p', 'player.player_index','i', 'p.account_id = i.id')
            ->where('account_id = :accountId')
            ->setParameter('accountId', $accountId)
            ->execute()
            ->fetchAll();

        $players = [];
        foreach($playersData as $playerData)
            $players[] = $this->buildPlayerFromData($playerData);

        return $players;
    }

    public function getByIp(string $ip): array {
        $queryBuilder = $this->conn->createQueryBuilder();
        $playersData = $queryBuilder
            ->select(...$this->selects)
            ->from($this->tableName, 'p')
            ->leftJoin('p', 'player.player_index','i', 'p.account_id = i.id')
            ->where('ip = :ip')
            ->setParameter('ip', $ip)
            ->execute()
            ->fetchAll();

        $players = [];
        foreach($playersData as $playerData)
            $players[] = $this->buildPlayerFromData($playerData);

        return $players;
    }

    protected function buildPlayerFromData(array $data): Player {
        try {
            $player = new Player(
                $data['id'],
                $data['account_id'],
                $data['name'],
                $data['level'],
                RaceFactory::fromCode($data['job']),
                KingdomFactory::fromCode($data['empire']),
                new \DateTimeImmutable($data['last_play']),
                new \DateInterval('PT'.$data['playtime'].'S'),
                $data['mmr'],
                $data['ip']
            );
            return $player;
        } catch (\Exception $ex) {
            throw new \RuntimeException("Something wrong while creating player object", 0, $ex);
        }
    }

}