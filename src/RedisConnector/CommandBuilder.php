<?php
/**
 * CommandBuilder file
 *
 * PHP version 5
 *
 * @category Class
 * @package  RedisConnector
 * @author   Marcin Owczarczyk <marow.dev@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/marow-dev/php-redis-connector
 */
namespace RedisConnector;

/**
 * CommandBuilder
 *
 * @category Class
 * @package  RedisConnector
 * @author   Marcin Owczarczyk <marow.dev@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/marow-dev/php-redis-connector
 */
class CommandBuilder
{
    /**
     * Constructor
     *
     * @param string $command   Command name
     * @param array  $arguments Command arguments
     */
    public function __construct($command, $arguments = array())
    {
        $this->command = $command;
        $this->arguments = (array)$arguments;
    }

    /**
     * Builds command string
     *
     * @return string
     */
    public function build()
    {
        $command = '*' . (count($this->arguments) + 1) . "\r\n";
        $arguments = array_merge(array($this->command), $this->arguments);
        foreach ($arguments as $arg) {
            $command .= '$' . strlen($arg) . "\r\n" . $arg . "\r\n";
        }
        return $command;
    }
}
