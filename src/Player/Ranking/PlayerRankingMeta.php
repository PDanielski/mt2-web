<?php


namespace App\Player\Ranking;


class PlayerRankingMeta implements PlayerRankingMetaInterface {

    protected $title;

    protected $desc;

    public function __construct(string $title, string $desc) {
        $this->title = $title;
        $this->desc = $desc;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDesc(): string {
        return $this->desc;
    }

}