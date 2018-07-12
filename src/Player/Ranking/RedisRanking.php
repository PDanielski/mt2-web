<?php


namespace App\Player\Ranking;

use App\Player\Exception\PlayerNotFoundException;
use App\Player\Ranking\Warmer\RankingWarmerInterface;
use App\Warmer\Warmable;
use Predis\Client;

class RedisRanking implements PlayerRankingInterface, Warmable {

    protected $client;

    protected $provider;

    protected $warmer;

    protected $rankingId;

    protected $meta;

    public function __construct(
        Client $client,
        PlacedPlayersProviderInterface $provider,
        RankingWarmerInterface $warmer,
        string $rankingId,
        PlayerRankingMetaInterface $meta
    ) {
        $this->client = $client;
        $this->warmer = $warmer;
        $this->provider = $provider;
        $this->rankingId = $rankingId;
        $this->meta = $meta;
    }

    /** @inheritdoc */
    public function get(int $offset = 0, int $limit = 0): array {
        $start = $offset;
        $end = $limit > 0 ? $start + $limit - 1 : $start;

        $ids = $this->client->zrange($this->getRedisKey(), $start, $end);

        $placedPlayers = $this->provider->getByPlayerIds($ids);

        $positionToPlacedPlayerMap = [];
        $position = $offset;
        foreach($ids as $id) {
            if(isset($placedPlayers[$id])){
                $placedPlayer = $placedPlayers[$id];
                $placedPlayer->setPosition($position);
                $positionToPlacedPlayerMap[$position] = $placedPlayer;
                $position++;
            }
        }

        return $positionToPlacedPlayerMap;
    }

    /** @inheritdoc */
    public function getByName(string $name): PlacedPlayer {
        $placedPlayer = $this->provider->getByPlayerName($name);
        $id = $placedPlayer->getId();

        $position = $this->client->zrank($this->getRedisKey(), $id);

        if(!$position && $position !== 0)
            throw new PlayerNotFoundException("The player $name is not present in this ranking");

        $placedPlayer->setPosition($position);

        return $placedPlayer;
    }

    public function getNumOfRankedPlayers(): int {
        return $this->client->zcard($this->getRedisKey());
    }

    public function getByGuildName(string $guildName): array {
        $placedPlayers = $this->provider->getByGuildName($guildName);

        foreach($placedPlayers as $placedPlayer) {
            $placedPlayer->setPosition($this->client->zrank($this->getRedisKey(), $placedPlayer->getId()));
        }
        usort($placedPlayers, function(PlacedPlayer $a, PlacedPlayer $b) {
            return $a->getPosition() <=> $b->getPosition();
        });
        return $placedPlayers;
    }

    public function warmup(): void {
        $redisKey = $this->getRedisKey();
        $client = $this->client;
        $this->warmer->warmup(function(array $ids) use ($redisKey, $client) {
            $idToScore = array_flip($ids);
            foreach($idToScore as $id => $score) {
                $client->zadd($redisKey, [$id => $score]);
            }

        });
    }

    public function getId(): string {
        return $this->rankingId;
    }

    public function getMetaInfo(): PlayerRankingMetaInterface {
        return $this->meta;
    }

    protected function getRedisKey(): string {
        return 'app.player.ranking.' . $this->getId();
    }

}