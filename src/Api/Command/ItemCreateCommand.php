<?php


namespace App\Api\Command;


use App\Api\Exception\InternalErrorException;
use App\Api\Exception\NotEnoughSpaceException;
use App\Api\Exception\PlayerOfflineException;
use App\Api\Metin2SocketClient;

class ItemCreateCommand {

    protected $playerId;

    protected $itemVnum;

    protected $count;

    public function __construct(int $playerId, int $itemVnum, int $count = 1) {
        $this->playerId = $playerId;
        $this->itemVnum = $itemVnum;
        $this->count = $count;
    }

    /**
     * @param Metin2SocketClient $client
     * @throws InternalErrorException
     * @throws NotEnoughSpaceException
     * @throws PlayerOfflineException
     */
    public function execute(Metin2SocketClient $client) {
        $commandMask = "\x40"."ADD_NEW_ITEM %d %d %d"."\x0A";
        $command = sprintf($commandMask, $this->playerId, $this->itemVnum, $this->count);
        $socket = $client->getSocket();

        socket_write($socket, $command);
        $response = socket_read($socket, 256);

        $response = ltrim(rtrim($response));

        if($response == 4)
            throw new PlayerOfflineException("The player with id {$this->playerId} is offline");

        if($response == 3)
            throw new NotEnoughSpaceException("The player with id {$this->playerId} has not enough space in inventory");

        if($response == 2)
            throw new InternalErrorException("The metin2 server has something wrong");
    }
}