<?php
namespace RedisConnector;

class Response {
    protected $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    protected function getResponseMethod($response) {
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
            default:
                throw new Exception("No response method for {$response}");
        }
        return $method;
    }

    public function read() {
        do {
            $response = $this->connection->read();
            if ($response === false || strlen($response) == 0) {
                throw new Exception();
            }
            $response = trim($response);
        } while ($response == '');
        $method = $this->getResponseMethod($response[0]);
        return call_user_func(array($this, $method), $response);
    }

    protected function readBulk($response) {
        if ($response == '$-1') {
            return false;
        }

        $size = (int)substr($response, 1);
        if ($size > 0) {
            $response = stream_get_contents($this->connection->getSocket(), $size);
        }
        return $response;
    }

    protected function readInteger($response) {
        return (int)substr($response, 1);
    }

    protected function readInline($response) {
        return substr($response, 1);
    }

    protected function readArray($response) {
        $count = substr($response, 1);
        if ($count == '-1') {
            return null;
        } elseif($count == '0') {
            return array();
        } else {
            $respArray = array();
            for ($i = 0; $i < $count; $i++) {
                $respArray[] = $this->read();
            }
            return $respArray;
        }
    }
}
