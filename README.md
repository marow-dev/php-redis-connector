# php-redis-connector
Redis client

# Connecting to redis
```
$connection = RedisConnector\Connection();
```
If connection cant be established RedisConnector\ConnectorException is thrown.

Default connection parameters are:

hostname: localhost

port: 6379

# Client
```
$client = new RedisConnector\Client(new RedisConnector\Connection());
```
# Sending commands to redis
```
$client = new RedisConnector\Client(new RedisConnector\Connection());
$client->set('key', 'value');
```
Most popular commands are methods in RedisConnector\Client class (get, set, etc.). You can issue other commands by using RedisConnector\Client object (class RedisConnector\Client implements magic method __call).
