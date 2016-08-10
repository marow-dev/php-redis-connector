<?php

namespace RedisConnector;

class CommandBuilder {
    public function __construct($command, $arguments = array()) {
        $this->command = $command;
        $this->arguments = (array)$arguments;
    }

    public function build() {
        $command = '*' . (count($this->arguments) + 1) . "\r\n";
        $arguments = array_merge(array($this->command), $this->arguments);
        foreach($arguments as $arg) {
            $command .= '$' . strlen($arg) . "\r\n" . $arg . "\r\n";
        }
        return $command;
    }
}
