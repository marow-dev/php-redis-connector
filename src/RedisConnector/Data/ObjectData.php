<?php
namespace RedisConnector\Data;

class ObjectData extends Base {
    public function __construct($key, $data = null) {
        if ( ! is_object($data) && ! is_null($data)) {
            throw new \RedisConnector\ConnectorException('Data is not an object', 10200);
        }
        parent::__construct($key, $data);
    }

    public function encode($data) {
        return serialize($data);
    }

    public function decode($data) {
        return unserialize($data);
    }
}
