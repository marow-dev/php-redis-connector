<?php
namespace RedisConnector\Data;

class ArrayData extends Base {
    public function __construct($key, $data = null) {
        if (is_array($data) or is_null($data)) {
            parent::__construct($key, $data);
        } else {
            throw new \RedisConnector\ConnectorException('Data is not an array', 10201);
        }
    }

    public function encode($data) {
        return json_encode($data);
    }

    public function decode($data) {
        return json_decode($data);
    }
}
