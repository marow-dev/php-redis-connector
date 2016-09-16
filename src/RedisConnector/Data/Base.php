<?php
/**
 * Base file
 *
 * PHP version 5
 *
 * @category Class
 * @package  RedisConnector
 * @author   Marcin Owczarczyk <marow.dev@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/marow-dev/php-redis-connector
 */
namespace RedisConnector\Data;

/**
 * Base
 *
 * @category Class
 * @package  RedisConnector
 * @author   Marcin Owczarczyk <marow.dev@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/marow-dev/php-redis-connector
 */
abstract class Base
{
    protected $key, $data;

    /**
     * Constructor
     *
     * @param string $key  Data will be saved to redis under this key
     * @param mixed  $data Data stored in class
     */
    public function __construct($key, $data)
    {
        if (!is_string($key) || !strlen($key)) {
            throw new \RedisConnector\ConnectorException('Wrong key', 10202);
        }
        $this->key = $key;
        $this->data = $data;
    }

    /**
     * Saves key to redis
     *
     * @param \RedisConnector\Client $client Client object
     *
     * @return boolean
     */
    public function save($client)
    {
        if ($client instanceof \RedisConnector\Client) {
            return $client->set($this->key, $this->encode($this->data));
        }
        return false;
    }

    /**
     * Load key from redis
     *
     * @param \RedisConnector\Client $client Client object
     *
     * @return boolean
     */
    public function load($client)
    {
        if ($client instanceof \RedisConnector\Client) {
            $this->data = $this->decode($client->get($this->key));
            return true;
        }
        return false;
    }

    /**
     * Creates object
     *
     * @param string $key   Data will be saved to redis under this key
     * @param mixed  $value Data stored in class
     *
     * @return object
     */
    public static function create($key, $value)
    {
        $object = new self($key, $value);
        return $object;
    }

    /**
     * Returns data stored in object
     *
     * @return mixed
     */
    public function get()
    {
        return $this->data;
    }

    /**
     * Encodes data to string
     *
     * @param mixed $data Data
     *
     * @return string
     */
    public abstract function encode($data);

    /**
     * Decodes data from string
     *
     * @param string $data Data
     *
     * @return mixed
     */
    public abstract function decode($data);
}
