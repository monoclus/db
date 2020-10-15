<?php declare(strict_types=1);

namespace monoclus\db;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;


trait LoggingTrait
{
    private $_logger = null;

    public function logger()
    {
        if ($this->_logger === null) {
            $this->_logger = new Logger(get_class($this));
            $this->_logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
        }
        return $this->_logger;
    }

}
