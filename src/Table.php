<?php declare(strict_types=1);


namespace monoclus\db;


use PDOException;

class Table
{
    /**
     * @var string
     */
    private $tableName;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * Table constructor.
     * @param string $tableName
     * @param Connection $connection
     */
    public function __construct(string $tableName, Connection $connection)
    {
        $this->tableName = $tableName;
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param array $where
     * @return FilteredTable
     */
    public function filter($where)
    {
        return new FilteredTable($this, $where);
    }

    /**
     * @param array $values
     * @return bool
     * @throws PDOException
     */
    public function insert($values)
    {
        $parameters = [];

        $fieldsStrArr = [];
        $valuesStrArr = [];
        foreach ($values as $k => $v) {
            $fieldsStrArr[] = $this->connection->quoteField($k);
            $valuesStrArr[] = ':V_' . $k;
            $parameters[':V_' . $k] = $v;
        }
        $fieldsStr = join(', ', $fieldsStrArr);
        $valuesStr = join(', ', $valuesStrArr);

        $sql = "insert into {$this->tableName}($fieldsStr) values($valuesStr)";

        $this->getConnection()->log($sql, $parameters);

        $stmt = $this->connection->prepare($sql);
        foreach ($parameters as $k => $v) {
            $stmt->bindValue($k, $v);
        }

        return $stmt->execute();
    }

}