<?php


namespace App\News\Warmer;


interface NewsWarmerInterface {

    public function warmup($processNews): void;

}