<?php declare(strict_types=1);

namespace monoclus\db;

use PHPUnit\Framework\TestCase;

/**
 * @covers \monoclus\db\Connection
 */
final class ConnectionTest extends TestCase
{
    public function testCanConnect() {
        $conn = new Connection("mysql:dbname=db;host=mysql", 'root', 'root');
        $this->assertNotNull($conn);
    }
}
