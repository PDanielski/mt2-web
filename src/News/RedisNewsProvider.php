<?php


namespace App\News;

use App\News\Warmer\NewsWarmerInterface;
use App\Warmer\Warmable;
use Predis\Client;

class RedisNewsProvider implements NewsProviderInterface, Warmable {

    protected $feedLink;

    protected $warmer;

    protected $client;

    public function __construct(NewsWarmerInterface $warmer, Client $client) {
        $this->warmer = $warmer;
        $this->client = $client;
    }

    public function get(int $limit = 10): array {
        $responses = $this->client->lrange($this->getRedisKey(), 0 , $limit-1);
        $news = [];
        foreach($responses as $response) {
            $news[] = unserialize($response);
        }
        return $news;
    }

    public function warmup(): void {
        $redisKey = $this->getRedisKey();
        $client = $this->client;
        $this->warmer->warmup(function(array $news) use ($redisKey, $client) {
            $serialized = [];
            for($i = count($news)-1; $i >= 0; $i--) {
                $serialized[] = serialize($news[$i]);
            }
            $client->lpush($redisKey, $serialized);
        });
    }

    protected function getRedisKey(): string {
        return "app.news";
    }

}