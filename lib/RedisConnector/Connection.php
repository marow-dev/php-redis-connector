<?php

namespace RedisConnector;

class Connection {
    protected $hostname = 'localhost';
    protected $port = 6379;
    protected $socket;

    public function __construct($hostname = '', $port = '') {
        if(strlen($hostname)) {
            $this->hostname = $hostname;
        }
        if(strlen($port)) {
            $this->port = $port;
        }
        $this->connect();
    }

    public function connect() {
        $this->socket = fsockopen($this->hostname, $this->port);
        if(! $this->socket) {
            throw new Exception();
        }
    }

    public function send($command) {
        return fwrite($this->socket, $command);
    }

    public function read() {
        return fgets($this->socket);
    }

    public function getSocket() {
        return $this->socket;
    }
}
