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
            $this->where[$k] = $v;
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

        $valuesStrArr = [];
        foreach ($values as $k => $v) {
            $valuesStrArr[] = $this->table->getConnection()->quoteField($k) . '=:V_' . $k;
            $parameters[':V_' . $k] = $v;
        }
        $valuesStr = join(', ', $valuesStrArr);

        $whereStrArr = [];
        foreach ($this->where as $k => $v) {
            $whereStrArr[] = '(' . $this->table->getConnection()->quoteField($k) . '=:W_' . $k . ')';
            $parameters[':W_'.$k] = $v;
        }
        $whereStr = join(' and ', $whereStrArr);

        $sql = "update $tableName set $valuesStr where $whereStr";

        $this->table->getConnection()->log($sql, $parameters);
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

        $whereStrArr = [];
        foreach ($this->where as $k => $v) {
            $whereStrArr[] = '(' . $this->table->getConnection()->quoteField($k) . '=:W_' . $k . ')';
            $parameters[':W_'.$k] = $v;
        }
        $whereStr = join(' and ', $whereStrArr);

        $sql = "delete from $tableName where $whereStr";

        $this->table->getConnection()->log($sql, $parameters);
        $stmt = $this->table->getConnection()->prepare($sql);
        return $stmt->execute($parameters);
    }
}