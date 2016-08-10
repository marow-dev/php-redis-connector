<?php
namespace RedisConnector\Data;

class ObjectData extends Base {
    public function __construct($key, $data = null) {
        if (is_object($data) or is_null($data)) {
            parent::__construct($key, $data);
        } else {
            throw new \RedisConnector\ConnectorException('Data is not an object', 10200);
        }
    }

    public function encode($data) {
        return serialize($data);
    }

    public function decode($data) {
        return unserialize($data);
    }
}
