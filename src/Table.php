<?php declare(strict_types=1);


namespace monoclus\db;


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
    public function __construct($tableName, Connection $connection)
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
    public function filter($where) {
        return new FilteredTable($this, $where);
    }

    /**
     * @param array $values
     * @return bool
     */
    public function insert($values)
    {
        $tableName = $this->tableName;

        $parameters = [];

        // TODO: "`" only works in MySQL
        $fieldsStrArr = [];
        $valuesStrArr = [];
        foreach ($values as $k => $v) {
            $fieldsStrArr[] = '`' . $k . '`';
            $valuesStrArr[] = '=:V_' . $k;
            $parameters[':V_' . $k] = $v;
        }
        $fieldsStr = join(', ', $fieldsStrArr);
        $valuesStr = join(', ', $valuesStrArr);

        $sql = "insert into $tableName($fieldsStr) values($valuesStr)";

        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($parameters);
    }

}