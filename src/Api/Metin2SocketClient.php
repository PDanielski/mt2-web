<?php


namespace App\Api;


use App\Api\Exception\SocketConnectionException;

class Metin2SocketClient {

    protected $host;

    protected $port;

    protected $key;

    protected $socket;

    protected $connected = false;

    protected $isAuthenticated = false;

    protected $defaultCommandResponseBuffer = 256;

    /**
     * Metin2SocketClient constructor.
     * @param $host
     * @param $port
     * @param $key
     */
    public function __construct($host,$port,$key){
        $this->host = $host;
        $this->port = $port;
        $this->key = $key;
    }

    /**
     * @return bool
     * @throws SocketConnectionException
     */
    public function connect(){
        if($this->connected)
            return true;

        $this->socket = \socket_create(AF_INET,SOCK_STREAM,SOL_TCP);

        if($this->socket === false)
            throw new SocketConnectionException(\socket_last_error($this->socket));

        $isConnected = \socket_connect($this->socket,$this->host,$this->port);

        if(!$isConnected)
            throw new SocketConnectionException(\socket_last_error($this->socket));

        $this->connected = true;

        $this->authenticate();

        return true;
    }

    public function executeCommand($commandName, ...$params) {
        $command = $commandName;
        foreach($params as $param) {
            $command .= ' '.$param;
        }

        $command = "\x40" . $command . "\x0A";

        \socket_write($this->socket, $command);
        return rtrim(ltrim(\socket_read($this->socket, $this->defaultCommandResponseBuffer)));

    }

    /**
     * @return bool
     * @throws SocketConnectionException
     */
    public function authenticate(){
        if($this->isAuthenticated)
            return true;

        $authMessage = "\x40".$this->key."\x0A";
        $isSuccessful = \socket_write($this->socket,$authMessage,strlen($authMessage));

        if(!$isSuccessful)
            throw new SocketConnectionException(\socket_last_error($this->socket));

        \socket_read($this->socket, 256);

        $this->isAuthenticated = true;

        return true;
    }

    public function getSocket() {
        return $this->socket;
    }

    public function disconnect(){
        \socket_close($this->socket);
    }

    public function isConnected(){
        return $this->connected;
    }

    public function __destruct() {
        if($this->connected)
            $this->disconnect();
    }

}