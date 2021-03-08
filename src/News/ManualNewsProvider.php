<?php


namespace App\News;

class ManualNewsProvider implements NewsProviderInterface {

    public function get(int $limit = 10): array {
        $news = [];
	$news[] = new News("Presentazione", "Spikelino", \DateTimeImmutable::createFromFormat("Y-m-d", "2020-11-14"), "Apertura ufficiale 14/11/2020 alle 18:00", "https://www.inforge.net/forum/threads/warlords-ii-apertura-ufficiale-14-11-2020-alle-18-00.598262/");
	//$news[] = new News("", "Spikelino", \DateTimeImmutable::createFromFormat("Y-m-d", "2020-11-10"), "", "");
        return $news;
    }

    
}