<?php


namespace App\ItemShop\Wallet;


class WalletOwner {

    protected $id;

    public function __construct($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

}