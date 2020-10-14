<?php declare(strict_types=1);


namespace monoclus\db;


class FilteredTable
{
    /**
     * @var Table
     */
    private $table;

    /**
     * @var array
     */
    private $where;

    /**
     * FilteredTable constructor.
     * @param array $where
     * @param Table $table
     */
    public function __construct(Table $table, $where)
    {
        $this->table = $table;
        $this->where = [];
        foreach ($where as $k => $v) {
            $this->where[':W_' . $k] = $v;
        }
    }

    /**
     * @param $values
     * @return bool
     */
    public function update($values)
    {
        $tableName = $this->table->getTableName();

        $parameters = [];

        // update ... set K1=V1, K2=V2 ....
        // TODO: "`" only works in MySQL
        $valuesStrArr = [];
        foreach ($values as $k => $v) {
            $valuesStrArr[] = '`' . $k . '`' . '=:V_' . $k;
            $parameters[':V_' . $k] = $v;
        }
        $valuesStr = join(', ', $valuesStrArr);

        // update ... where K1=V1 AND K2=V2 ...
        // TODO: "`" only works in MySQL
        $whereStrArr = [];
        foreach ($this->where as $k => $v) {
            $whereStrArr[] = '(`' . $k . '`' . '=:W_' . $k . ')';
            $parameters[':W_' . $k] = $v;
        }
        $whereStr = join(' and ', $whereStrArr);

        $sql = "update $tableName set $valuesStr where $whereStr";

        $stmt = $this->table->getConnection()->prepare($sql);
        return $stmt->execute($parameters);
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $tableName = $this->table->getTableName();

        $parameters = [];

        // update ... where K1=V1 AND K2=V2 ...
        // TODO: "`" only works in MySQL
        $whereStrArr = [];
        foreach ($this->where as $k => $v) {
            $whereStrArr[] = '(`' . $k . '`' . '=:W_' . $k . ')';
            $parameters[':W_' . $k] = $v;
        }
        $whereStr = join(' and ', $whereStrArr);

        $sql = "delete from $tableName where $whereStr";

        $stmt = $this->table->getConnection()->prepare($sql);
        return $stmt->execute($parameters);
    }
}