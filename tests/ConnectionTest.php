<?php declare(strict_types=1);

namespace monoclus\db;

use PHPUnit\Framework\TestCase;


final class ConnectionTest extends TestCase
{
    use LoggingTrait;

    public function testCanConnect()
    {
        $db_dsn = $_ENV['DB_DSN'];
        $db_user = $_ENV['DB_USER'];
        $db_pass = $_ENV['DB_PASS'];
        $this->logger()->info("Connecting to $db_user @ $db_dsn");
        $conn = new Connection($db_dsn, $db_user, $db_pass);
        $this->assertNotNull($conn);
    }
}
