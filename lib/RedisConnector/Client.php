<?php
namespace RedisConnector;

class Client {
    protected $connection;

    /**
     * Constructor
     *
     * @param RedisConnector\Connection $connection
     */
    public function __construct($connection) {
        $this->connection = $connection;
    }

    /**
     * Sends command to redis server and reads response
     *
     * @param string $command
     * @return mixed
     */
    protected function send($command) {
        $commandStr = $command->build();
        if ( ! $this->connection->send($commandStr)) {
            throw new Exception();
        }
        $response = new Response($this->connection);
        return $response->read();
    }

    /**
     * Redis GET command
     */
    public function get($key) {
        $this->connection->connect();
        return $this->send(new CommandBuilder('get', $key));
    }

    /**
     * Redis HSET command
     */
    public function hset($key, $hash, $value) {
        $this->connection->connect();
        return $this->send(new CommandBuilder('hset', array($key, $hash, $value)));
    }

    /**
     * Redis EXISTS command
     */
    public function exists($key) {
        return $this->send(new CommandBuilder('exists', $key));
    }

    /**
     * Redis DEL command
     */
    public function del($key) {
        return $this->send(new CommandBuilder('del', $key));
    }

    /**
     * Redis SET command
     */
    public function set($key, $value) {
        return $this->send(new CommandBuilder('set', array($key, $value)));
    }

    /**
     * Redis APPEND command
     */
    public function append($key, $value) {
        return $this->send(new CommandBuilder('append', array($key, $value)));
    }

    /**
     * Redis RPUSH command
     */
    public function rpush($key, $value) {
        return $this->send(new CommandBuilder('rpush', array($key, $value)));
    }

    /**
     * Redis LPUSH command
     */
    public function lpush($key, $value) {
        return $this->send(new CommandBuilder('lpush', array($key, $value)));
    }

    /**
     * Redis RANGE command
     */
    public function range($key, $from, $to) {
        return $this->send(new CommandBuilder('lrange', array($key, $from, $to)));
    }

    /**
     * Redis RPOP command
     */
    public function rpop($key) {
        return $this->send(new CommandBuilder('rpop', array($key)));
    }

    /**
     * Redis LPOP command
     */
    public function lpop($key) {
        return $this->send(new CommandBuilder('lpop', array($key)));
    }

    /**
     * Redis FLUSHALL command
     */
    public function flushall() {
        return $this->send(new CommandBuilder('flushall'));
    }

    /**
     * Redis TTL command
     */
    public function ttl($key) {
        return $this->send(new CommandBuilder('ttl', array($key)));
    }

    /**
     * Redis EXPIRE command
     */
    public function expire($key, $timeout) {
        return $this->send(new CommandBuilder('expire', array($key, $timeout)));
    }

    /**
     * Redis EXPIREAT command
     */
    public function expireat($key, $miliseconds) {
        return $this->send(new CommandBuilder('expireat', array($key, $miliseconds)));
    }

    /**
     * Sends command to redis
     *
     * @param string $command   Redis command
     * @param array $arguments  Command arguments
     */
    public function __call($command, $arguments) {
        $c = new CommandBuilder($command, $arguments);
        if ($c) {
            return $this->send($c);
        }
    }
}
