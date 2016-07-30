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

    public function hset($key, $hash, $value) {
        $this->connection->connect();
        return $this->send(new CommandBuilder('hset', array($key, $hash, $value)));
    }

    public function exists($key) {
        return $this->send(new CommandBuilder('exists', $key));
    }

    public function del($key) {
        return $this->send(new CommandBuilder('del', $key));
    }

    public function set($key, $value) {
        return $this->send(new CommandBuilder('set', array($key, $value)));
    }

    public function append($key, $value) {
        return $this->send(new CommandBuilder('append', array($key, $value)));
    }

    public function rpush($key, $value) {
        return $this->send(new CommandBuilder('rpush', array($key, $value)));
    }

    public function lpush($key, $value) {
        return $this->send(new CommandBuilder('lpush', array($key, $value)));
    }

    public function range($key, $from, $to) {
        return $this->send(new CommandBuilder('lrange', array($key, $from, $to)));
    }

    public function rpop($key) {
        return $this->send(new CommandBuilder('rpop', array($key)));
    }

    public function lpop($key) {
        return $this->send(new CommandBuilder('lpop', array($key)));
    }

    public function flushall() {
        return $this->send(new CommandBuilder('flushall'));
    }

    public function ttl($key) {
        return $this->send(new CommandBuilder('ttl', array($key)));
    }

    public function expire($key, $timeout) {
        return $this->send(new CommandBuilder('expire', array($key, $timeout)));
    }

    public function expireat($key, $miliseconds) {
        return $this->send(new CommandBuilder('expireat', array($key, $miliseconds)));
    }

    public function invoke($func, $arguments = array()) {
        return $this->__call($func, $arguments);
    }

    public function __call($func, $arguments) {
        $command = new CommandBuilder($func, $arguments);
        if ($command) {
            return $this->send($command);
        }
    }
}
