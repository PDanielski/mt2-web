<?php


namespace App\Player\Ranking\Warmer;

interface RankingWarmerInterface {

    public function warmup(callable $processIds);

}