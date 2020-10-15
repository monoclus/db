<?php declare(strict_types=1);

namespace monoclus\db;

use PDOException;
use PHPUnit\Framework\TestCase;


final class InsertTest extends TestCase
{
    use LoggingTrait;

    public function test_simpleInsert()
    {
        $conn = new Connection();
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $conn->debug();
        $table = $conn->table('a');
        $res = $table->insert(['a' => 2]);
        self::assertTrue($res);
    }

    public function test_InsertTooManyColumns()
    {
        $this->expectException(PDOException::class);
        $conn = new Connection();
        $conn->debug();
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $table = $conn->table('a');
        $res = $table->insert([
            'a' => 2,
            'b' => 2,
            'c' => 2,
            'd' => 2,
            'e' => 2,
            'f' => 2,
            'g' => 2,
        ]);
        self::assertFalse($res);
    }
}
