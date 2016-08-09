<?php
namespace RedisConnector\Data;

class ArrayData extends Base {
    public function __construct($key, $data) {
        if (is_array($data)) {
            parent::__construct($key, $data);
        } else {
            throw new Exception('Not an array');
        }
    }

    public static function create($key, $data) {
        try {
            $array = new self($key, $value);
        } catch (Exception $e) {
            throw $e;
        }
        return $array;
    }

    public function encode($data) {
        return json_encode($data);
    }

    public function decode($data) {
        return json_decode($data);
    }
}
