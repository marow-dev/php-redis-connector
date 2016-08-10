<?php
namespace RedisConnector\Data;

abstract class Base {
    protected $key, $data;

    /**
     * Constructor
     *
     * @param string $key   Data will be saved to redis under this key
     * @param mixed $data
     */
    public function __construct($key, $data) {
        if ( ! is_string($key) || ! strlen($key)) {
            throw new \RedisConnector\ConnectorException('Wrong key', 10202);
        }
        $this->key = $key;
        $this->data = $data;
    }

    /**
     * Saves key to redis
     *
     * @param \RedisConnector\Client $client
     */
    public function save($client) {
        if ($client instanceof \RedisConnector\Client) {
            $client->set($this->key, $this->encode($this->data));
        }
    }

    /**
     * Load key from redis
     *
     * @param \RedisConnector\Client $client
     */
    public function load($client) {
        if ($client instanceof \RedisConnector\Client) {
            $this->data = $this->decode($client->get($this->key));
        }
    }

    public static function create($key, $data) {
        $array = new self($key, $value);
        return $array;
    }

    public function get() {
        return $this->data;
    }

    /**
     * Encodes data to string
     *
     * @param $data
     * @return string
     */
    public abstract function encode($data);

    /**
     * Decodes data from string
     *
     * @param String $data
     * @return Any
     */
    public abstract function decode($data);
}
