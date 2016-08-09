<?php
require_once __DIR__ . '/../lib/RedisConnector/Client.php';
require_once __DIR__ . '/../lib/RedisConnector/CommandBuilder.php';
require_once __DIR__ . '/../lib/RedisConnector/Connection.php';
require_once __DIR__ . '/../lib/RedisConnector/ConnectorException.php';
require_once __DIR__ . '/../lib/RedisConnector/Response.php';

class ErrorsTest extends PHPUnit_Framework_TestCase {
    private static $redis;

    public function setUp() {
        self::$redis = new RedisConnector\Client(new RedisConnector\Connection());
    }

    public function testBasic() {
        $key = 'test key';
        $value = 'test value';
        $appendValue = ' appended value';
        self::$redis->flushall();
        self::$redis->set($key, $value);
        $this->assertEquals(true, self::$redis->exists($key));
        $this->assertEquals($value, self::$redis->get($key));
        self::$redis->append($key, $appendValue);
        $this->assertEquals($value . $appendValue, self::$redis->get($key));
        self::$redis->del($key);
        $this->assertEquals(false, self::$redis->exists($key));
    }

    public function testTtl() {
        $key = 'test key';
        $value = 'test value';
        self::$redis->flushall();
        self::$redis->set($key, $value);
        $this->assertEquals(-1, self::$redis->ttl($key));
        $res = self::$redis->expire($key, 10);
        $this->assertEquals(1, $res);
        $this->assertEquals(10, self::$redis->ttl($key));
        $res = self::$redis->expireat($key, time() + 24 * 60 * 60);
        $this->assertEquals(24 * 60 * 60, self::$redis->ttl($key));
        $this->assertEquals(1, $res);
    }

    public function testInvokeFunction() {
        $keys = ['test1' => 'value1', 'test2' => 'value2', 'test3' => 'value3'];
        self::$redis->flushall();
        foreach ($keys as $k => $v) {
            self::$redis->set($k, $v);
        }
        $keys = self::$redis->keys('test?');
        $this->assertEquals(['test2', 'test1', 'test3'], $keys);
    }

    public function testLPush() {
        self::$redis->flushall();
        self::$redis->lpush('example_list', 'Lorem ipsum dolor sit amet.');
        self::$redis->lpush('example_list', 'Consectetur adipiscing elit.');
        $exampleList = self::$redis->range('example_list', 0, -1);
        $this->assertEquals(['Consectetur adipiscing elit.', 'Lorem ipsum dolor sit amet.'], $exampleList);
    }

    public function testRPush() {
        self::$redis->flushall();
        self::$redis->rpush('example_list', 'Lorem ipsum dolor sit amet.');
        self::$redis->rpush('example_list', 'Consectetur adipiscing elit.');
        $exampleList = self::$redis->range('example_list', 0, -1);
        $this->assertEquals(['Lorem ipsum dolor sit amet.', 'Consectetur adipiscing elit.'], $exampleList);
    }
}
