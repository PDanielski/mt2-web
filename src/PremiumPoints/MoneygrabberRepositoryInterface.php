<?php


namespace App\PremiumPoints;


interface MoneygrabberRepositoryInterface {


    public function getByEmail(string $email): Moneygrabber;

    public function getPoorest(): Moneygrabber;

    public function addEarnings(string $email, int $earnings): void;



}