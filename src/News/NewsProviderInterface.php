<?php


namespace App\News;


interface NewsProviderInterface {

    /**
     * @param int $limit
     * @return News[]
     */
    public function get(int $limit = 10): array;

}