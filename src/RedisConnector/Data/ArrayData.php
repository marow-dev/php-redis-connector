<?php
/**
 * ArrayData file
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
 * ArrayData
 *
 * @category Class
 * @package  RedisConnector
 * @author   Marcin Owczarczyk <marow.dev@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/marow-dev/php-redis-connector
 */
class ArrayData extends Base
{
    /**
     * Constructor
     *
     * @param string $key  Key
     * @param array  $data Data
     */
    public function __construct($key, $data = null)
    {
        if (!is_array($data) && !is_null($data)) {
            throw new \RedisConnector\ConnectorException('Data is not an array', 10201);
        }
        parent::__construct($key, $data);
    }

    /**
     * Encodes data to string
     *
     * @param array $data Data that will be send to Redis
     *
     * @return string
     */
    public function encode($data)
    {
        return json_encode($data);
    }

    /**
     * Decodes data from string
     *
     * @param string $data Data from Redis
     *
     * @return array
     */
    public function decode($data)
    {
        return json_decode($data);
    }
}
