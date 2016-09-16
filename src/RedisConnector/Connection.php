<?php
/**
 * Connection file
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
 * Connection
 *
 * @category Class
 * @package  RedisConnector
 * @author   Marcin Owczarczyk <marow.dev@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/marow-dev/php-redis-connector
 */
class Connection
{
    protected $hostname;
    protected $port;
    protected $socket;

    /**
     * Constructor
     *
     * @param string $hostname    Redis server hostname - default = 'localhost'
     * @param int    $port        Redis server port number - default = 6379
     * @param bool   $autoConnect Automatically creates socket connection to redis server
     */
    public function __construct($hostname = 'localhost', $port = 6379, $autoConnect = true)
    {
        $this->hostname = $hostname;
        $this->port = $port;
        if ($autoConnect === true) {
            $this->connect();
        }
    }

    /**
     * Returns true if connection to redis is established
     *
     * @return bool
     */
    public function isConnected()
    {
        return is_resource($this->socket);
    }

    /**
     * Creates socket connection to redis
     *
     * @throws ConnectorException
     *
     * @return boolean
     */
    public function connect()
    {
        $this->socket = @fsockopen($this->hostname, $this->port);
        if (!$this->socket) {
            throw new ConnectorException('Connection cannot be established', 10000);
        }
        return true;
    }

    /**
     * Sends command to redis
     *
     * @param string $command Command
     *
     * @throws ConnectorException
     *
     * @return int
     */
    public function send($command)
    {
        if (!$this->isConnected()) {
            throw new ConnectorException('Not connected to redis', 10001);
        }
        return fwrite($this->socket, $command);
    }

    /**
     * Reads data from redis server
     *
     * @return string
     */
    public function read()
    {
        return fgets($this->socket);
    }

    /**
     * Get connection socket
     *
     * @return resource
     */
    public function getSocket()
    {
        return $this->socket;
    }
}
