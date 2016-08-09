# php-redis-connector
Redis client

# Connecting to redis

$connection = RedisConnector\Connection();

If connection cant be established RedisConnector\ConnectorException is thrown.

# Client

$client = new RedisConnector\Client(new RedisConnector\Connection());

# Sending commands to redis

$client = new RedisConnector\Client(new RedisConnector\Connection());
$client->set('key', 'value');

Most popular commands are methods in RedisConnector\Client class. You can issue other commands by using RedisConnector\Client object (class implements magic method __call).
