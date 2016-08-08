<?php
namespace RedisConnector\Data;

abstract class Base {
    protected $key, $data;

    public function __construct($key, $data) {
        if ( ! is_string($key) || ! strlen($key)) {
            throw new Exception('Wrong key');
        }
        $this->key = $key;
        $this->data = $data;
    }

    public function save($client) {
        if ($client instanceof \RedisConnector\Client) {
            $client->set($this->key, $this->encode($this->data));
        }
    }

    public function load($client) {
        if ($client instanceof RedisConnector\Client) {
            $this->data = $this->decode($client->get($this->key));
        }
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
