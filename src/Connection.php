<?php declare(strict_types=1);


namespace monoclus\db;


class Connection extends \PDO
{
    /**
     * @param $tableName
     * @return Table
     */
    public function table($tableName)
    {
        return new Table($tableName, $this);
    }
}