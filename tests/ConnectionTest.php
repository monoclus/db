<?php declare(strict_types=1);

namespace monoclus\db;

use PHPUnit\Framework\TestCase;


final class ConnectionTest extends TestCase
{
    use LoggingTrait;

    public function testCanConnect()
    {
        $conn = new Connection();
        $this->assertNotNull($conn);
    }
}
