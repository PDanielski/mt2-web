<?php


namespace App\PremiumPoints;

class Moneygrabber {
    protected $id;
    protected $earnings;
    protected $earnOffset;
    protected $percentage;
    protected $email;

    public function __construct($id, $earnings, $earnOffset, $percentage, $email) {
        $this->earnings = $earnings;
        $this->earnOffset = $earnOffset;
        $this->percentage = $percentage;
        $this->id = $id;
        $this->email = $email;

    }

    public function getId(): string {
        return $this->id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getEarnOffset(): int {
        return $this->earnOffset;
    }
    
    public function getPercentage(): float {
        return $this->percentage;
    }

    public function getEarnings(): int {
        return $this->earnings;
    }


}