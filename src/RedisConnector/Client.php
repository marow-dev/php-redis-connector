<?php
/**
 * Client file
 *
 * PHP version 5
 *
 * @category Class
 * @package  RedisConnector
 * @author   Marcin Owczarczyk <marow.dev@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/marow-dev/php-redis-connector
 */
namespace RedisConnector;

/**
 * Client
 *
 * @category Class
 * @package  RedisConnector
 * @author   Marcin Owczarczyk <marow.dev@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/marow-dev/php-redis-connector
 */
class Client
{
    protected $connection;

    /**
     * Constructor
     *
     * @param RedisConnector\Connection $connection Connection object
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * Sends command to redis server and reads response
     *
     * @param string $command Command object
     *
     * @return mixed
     */
    protected function send($command)
    {
        $commandStr = $command->build();
        if (!$this->connection->send($commandStr)) {
            throw new ConnectorException('Command send error', 10004);
        }
        $response = new Response($this->connection);
        return $response->read();
    }

    /**
     * Redis GET command
     *
     * @param string $key Key
     *
     * @return string
     */
    public function get($key)
    {
        $this->connection->connect();
        return $this->send(new CommandBuilder('get', $key));
    }

    /**
     * Redis HSET command
     *
     * @param string $key   Key
     * @param string $hash  Hash
     * @param string $value Value
     *
     * @return string
     */
    public function hset($key, $hash, $value)
    {
        $this->connection->connect();
        return $this->send(new CommandBuilder('hset', array($key, $hash, $value)));
    }

    /**
     * Redis EXISTS command
     *
     * @param string $key Key
     *
     * @return string
     */
    public function exists($key)
    {
        return $this->send(new CommandBuilder('exists', $key));
    }

    /**
     * Redis DEL command
     *
     * @param string $key Key
     *
     * @return string
     */
    public function del($key)
    {
        return $this->send(new CommandBuilder('del', $key));
    }

    /**
     * Redis SET command
     *
     * @param string $key   Key
     * @param string $value Value
     *
     * @return string
     */
    public function set($key, $value)
    {
        return $this->send(new CommandBuilder('set', array($key, $value)));
    }

    /**
     * Redis APPEND command
     *
     * @param string $key   Key
     * @param string $value Value
     *
     * @return string
     */
    public function append($key, $value)
    {
        return $this->send(new CommandBuilder('append', array($key, $value)));
    }

    /**
     * Redis RPUSH command
     *
     * @param string $key   Key
     * @param string $value Value
     *
     * @return string
     */
    public function rpush($key, $value)
    {
        return $this->send(new CommandBuilder('rpush', array($key, $value)));
    }

    /**
     * Redis LPUSH command
     *
     * @param string $key   Key
     * @param string $value Value
     *
     * @return string
     */
    public function lpush($key, $value)
    {
        return $this->send(new CommandBuilder('lpush', array($key, $value)));
    }

    /**
     * Redis RANGE command
     *
     * @param string $key  Key
     * @param string $from From value
     * @param string $to   To value
     *
     * @return string
     */
    public function range($key, $from, $to)
    {
        return $this->send(new CommandBuilder('lrange', array($key, $from, $to)));
    }

    /**
     * Redis RPOP command
     *
     * @param string $key Key
     *
     * @return string
     */
    public function rpop($key)
    {
        return $this->send(new CommandBuilder('rpop', array($key)));
    }

    /**
     * Redis LPOP command
     *
     * @param string $key Key
     *
     * @return string
     */
    public function lpop($key)
    {
        return $this->send(new CommandBuilder('lpop', array($key)));
    }

    /**
     * Redis FLUSHALL command
     *
     * @return string
     */
    public function flushall()
    {
        return $this->send(new CommandBuilder('flushall'));
    }

    /**
     * Redis TTL command
     *
     * @param string $key Key
     *
     * @return string
     */
    public function ttl($key)
    {
        return $this->send(new CommandBuilder('ttl', array($key)));
    }

    /**
     * Redis EXPIRE command
     *
     * @param string $key     Key
     * @param int    $timeout Timeout value
     *
     * @return string
     */
    public function expire($key, $timeout)
    {
        return $this->send(new CommandBuilder('expire', array($key, $timeout)));
    }

    /**
     * Redis EXPIREAT command
     *
     * @param string $key         Key
     * @param string $miliseconds Miliseconds
     *
     * @return string
     */
    public function expireat($key, $miliseconds)
    {
        return $this->send(new CommandBuilder('expireat', array($key, $miliseconds)));
    }

    /**
     * Sends command to redis
     *
     * @param string $command   Redis command
     * @param array  $arguments Command arguments
     *
     * @return string
     */
    public function __call($command, $arguments)
    {
        $comBuilder = new CommandBuilder($command, $arguments);
        if ($comBuilder) {
            return $this->send($comBuilder);
        }
    }
}
