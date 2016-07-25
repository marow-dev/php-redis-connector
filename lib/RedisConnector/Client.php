<?php
namespace RedisConnector;

class Client {
    protected $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    protected function send($command) {
        $commandStr = $command->build();
        if ( ! $this->connection->send($commandStr)) {
            throw new Exception();
        }
        $response = new Response($this->connection);
        return $response->read();
    }

    public function get($key) {
        $this->connection->connect();
        return $this->send(new CommandBuilder('get', $key));
    }

    public function hashset($key, $hash, $value) {
        $this->connection->connect();
        return $this->send(new CommandBuilder('hset', array($key, $hash, $value)));
    }

    public function exists($key) {
        return $this->send(new CommandBuilder('exists', $key));
    }

    public function set($key, $value) {
        return $this->send(new CommandBuilder('set', array($key, $value)));
    }

    public function listRPush($key, $value) {
        return $this->send(new CommandBuilder('rpush', array($key, $value)));
    }

    public function listLPush($key, $value) {
        return $this->send(new CommandBuilder('lpush', array($key, $value)));
    }

    public function listRange($key, $from, $to) {
        return $this->send(new CommandBuilder('lrange', array($key, $from, $to)));
    }

    public function listRPop($key) {
        return $this->send(new CommandBuilder('rpop', array($key)));
    }

    public function listLPop($key) {
        return $this->send(new CommandBuilder('lpop', array($key)));
    }
}
