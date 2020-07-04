<?php


namespace App\PremiumPoints;

class PremiumPointsPackage {
    protected $id;
    protected $name;
    protected $cost;
    protected $points;
    protected $description;

    public function __construct($id, $name, $description, $cost, $points) {
        $this->cost = $cost;
        $this->name = $name;
        $this->description = $description;
        $this->id = $id;
        $this->points = $points;

    }

    public function getId(): string {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getCost(): int {
        return $this->cost;
    }

    public function getPoints(): int {
        return $this->points;
    }


}