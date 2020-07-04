<?php


namespace App\PremiumPoints;


interface PremiumPointsPackageRepositoryInterface {

    public function getAll(): array;
    public function getById(int $id): PremiumPointsPackage;
    public function getByName(string $name): PremiumPointsPackage;

}