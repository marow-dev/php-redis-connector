<?php
require_once __DIR__ . '/../lib/RedisConnector/Client.php';
require_once __DIR__ . '/../lib/RedisConnector/CommandBuilder.php';
require_once __DIR__ . '/../lib/RedisConnector/Connection.php';
require_once __DIR__ . '/../lib/RedisConnector/ConnectorException.php';
require_once __DIR__ . '/../lib/RedisConnector/Response.php';
require_once __DIR__ . '/../lib/RedisConnector/Data/Base.php';
require_once __DIR__ . '/../lib/RedisConnector/Data/ArrayData.php';

class ErrorsTest extends PHPUnit_Framework_TestCase {
    private static $redis;

    public function setUp() {
        self::$redis = new RedisConnector\Client(new RedisConnector\Connection());
    }

    public function testArray() {
        $array2Save = [1,2,3,4,5];
        $array = new RedisConnector\Data\ArrayData('test', $array2Save);
        $array->save(self::$redis);
        $validate = self::$redis->get('test');
        $this->assertEquals($array->encode($array2Save), $validate);
    }
}
