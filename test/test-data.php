<?php
require_once __DIR__ . '/../src/RedisConnector/Client.php';
require_once __DIR__ . '/../src/RedisConnector/CommandBuilder.php';
require_once __DIR__ . '/../src/RedisConnector/Connection.php';
require_once __DIR__ . '/../src/RedisConnector/ConnectorException.php';
require_once __DIR__ . '/../src/RedisConnector/Response.php';
require_once __DIR__ . '/../src/RedisConnector/Data/Base.php';
require_once __DIR__ . '/../src/RedisConnector/Data/ArrayData.php';
require_once __DIR__ . '/../src/RedisConnector/Data/ObjectData.php';

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

    public function testWrongDataType() {
        $array2Save = 10;
        $isException = false;
        try {
            $array = new RedisConnector\Data\ArrayData('test', $array2Save);
        } catch (\RedisConnector\ConnectorException $e) {
            $isException = true;
            $this->assertEquals(10201, $e->getCode());
        }
        $this->assertEquals(true, $isException);
    }

    public function testWrongDataKey() {
        $isException = false;
        try {
            $array = new RedisConnector\Data\ArrayData([12], [12]);
        } catch (\RedisConnector\ConnectorException $e) {
            $isException = true;
            $this->assertEquals(10202, $e->getCode());
        }
        $this->assertEquals(true, $isException);
    }

    public function testObject() {
        $object2Save = new stdClass();
        $object2Save->test1 = 'Test1 Value';
        $object2Save->test2 = 'Test2 Value';

        $object = new RedisConnector\Data\ObjectData('test object', $object2Save);
        $object->save(self::$redis);
        $validate = self::$redis->get('test object');
        $this->assertEquals($object->encode($object2Save), $validate);

        $object = new RedisConnector\Data\ObjectData('test object', null);
        $object->load(self::$redis);
        $this->assertEquals($object->get(), $object2Save);
    }
}
