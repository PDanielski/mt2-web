<?php


namespace App\News\Warmer;


use App\News\News;

class BoardRssNewsWarmer implements NewsWarmerInterface {

    protected $feedLink;

    public function __construct(string $feedLink) {
        $this->feedLink = $feedLink;
    }

    public function warmup($processNews): void {
        $xml = simplexml_load_file($this->feedLink);
        $items = $xml->channel->item;

        $news = [];
        foreach($items as $item){
            $desc = $item->description;
            $pubDate = new \DateTimeImmutable($item->pubDate);
            $link = $item->link;
            $title = $item->title;
            $dc = $item->children('dc', true);
            $author = $dc->creator;
            $news[] = new News(
                $title,
                $author,
                $pubDate,
                $desc,
                $link
            );
        }
        $processNews($news);
    }

}