<?php
/**
 * Response file
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
 * Response
 *
 * @category Class
 * @package  RedisConnector
 * @author   Marcin Owczarczyk <marow.dev@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/marow-dev/php-redis-connector
 */
class Response
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
     * Returns method name that will parse response
     *
     * @param string $response Response from Redis
     *
     * @return string
     */
    protected function getResponseMethod($response)
    {
        switch($response) {
        case '$':
            $method = 'readBulk';
            break;
        case '+':
            $method = 'readInline';
            break;
        case ':':
            $method = 'readInteger';
            break;
        case '*':
            $method = 'readArray';
            break;
        case '-':
            $method = 'readError';
            break;
        default:
            throw new ConnectorException("No response method for {$response}", 10100);
        }
        return $method;
    }

    /**
     * Reads response from connection object
     *
     * @return mixed
     */
    public function read()
    {
        do {
            $response = $this->connection->read();
            if ($response === false || strlen($response) == 0) {
                throw new ConnectorException('Response read error', 10002);
            }
            $response = trim($response);
        } while ($response == '');
        $method = $this->getResponseMethod($response[0]);
        return call_user_func(array($this, $method), $response);
    }

    /**
     * Parses bulk data
     *
     * @param string $response Response from Redis
     *
     * @return string
     */
    protected function readBulk($response)
    {
        if ($response == '$-1') {
            return false;
        }

        $size = (int)substr($response, 1);
        if ($size > 0) {
            $response = stream_get_contents($this->connection->getSocket(), $size);
        }
        return $response;
    }

    /**
     * Parses integer data
     *
     * @param string $response Response from Redis
     *
     * @return int
     */
    protected function readInteger($response)
    {
        return (int)substr($response, 1);
    }

    /**
     * Parses inline data
     *
     * @param string $response Response from Redis
     *
     * @return string
     */
    protected function readInline($response)
    {
        return substr($response, 1);
    }

    /**
     * Parses array data
     *
     * @param string $response Response from Redis
     *
     * @return array
     */
    protected function readArray($response)
    {
        $count = substr($response, 1);
        if ($count == '-1') {
            return null;
        } elseif ($count == '0') {
            return array();
        }
        $respArray = array();
        for ($i = 0; $i < $count; $i++) {
            $respArray[] = $this->read();
        }
        return $respArray;
    }

    /**
     * Parses error
     *
     * @param string $response Response from Redis
     *
     * @throws RedisConnector\ConnectorException
     *
     * @return true;
     */
    protected function readError($response)
    {
        $response = substr($response, 1);
        throw new ConnectorException($response, 10003);
        return $response;
    }
}
