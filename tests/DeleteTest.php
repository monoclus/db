<?php declare(strict_types=1);

namespace monoclus\db;

use PDOException;
use PHPUnit\Framework\TestCase;


final class DeleteTest extends TestCase
{
    use LoggingTrait;

    public function test_simpleDelete()
    {
        $res = Connection::create()
            ->setLogger($this->logger())
            ->table('a')
            ->filter(['a' => 2])
            ->delete();
        self::assertTrue($res);
    }

    public function test_deleteWrongField()
    {
        $this->expectException(PDOException::class);
        Connection::create()
            ->setLogger($this->logger())
            ->table('a')
            ->filter(['x' => 1])
            ->delete();
    }
}
