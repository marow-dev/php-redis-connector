<?php
require_once __DIR__ . '/../src/RedisConnector/Client.php';
require_once __DIR__ . '/../src/RedisConnector/CommandBuilder.php';
require_once __DIR__ . '/../src/RedisConnector/Connection.php';
require_once __DIR__ . '/../src/RedisConnector/ConnectorException.php';
require_once __DIR__ . '/../src/RedisConnector/Response.php';

class ErrorsTest extends PHPUnit_Framework_TestCase {
    private static $redis;

    public function setUp() {
        self::$redis = new RedisConnector\Client(new RedisConnector\Connection());
    }

    public function testConfig() {
        $setResult = self::$redis->config('set', 'slowlog-max-len', '256');
        $this->assertEquals('OK', $setResult);
        $slowlog = self::$redis->config('get', 'slowlog-max-len');
        $this->assertEquals(['slowlog-max-len', 256], $slowlog);
    }
}
