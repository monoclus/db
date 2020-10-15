<?php declare(strict_types=1);


namespace monoclus\db;


use PDOStatement;

class Connection extends \PDO
{
    /**
     * @var bool
     */
    private $debugMode = false;

    /**
     * If no parameters are provided, the connection is getting the following variables from $_ENV:
     *     DB_DSN, DB_USER and DB_PASS, DB_DEBUG
     * @param string|null $dsn
     * @param string|null $username
     * @param string|null $passwd
     * @param string|null $options
     */
    public function __construct($dsn = null, $username = null, $passwd = null, $options = null)
    {
        $dsn = $dsn ?? $_ENV['DB_DSN'];
        $username = $username ?? $_ENV['DB_USER'];
        $passwd = $passwd ?? $_ENV['DB_PASS'];
        parent::__construct($dsn, $username, $passwd, $options);
        $debug = (bool)$_ENV['DB_DEBUG'];
        $this->debug($debug);
    }

    /**
     * @param false $debug
     * @return $this
     */
    public function debug($debug=true) {
        $this->debugMode = $debug;
        return $this;
    }

    /**
     * @param $fieldName
     * @return string
     */
    public function quoteField(string $fieldName) {
        // TODO: "`" only works in MySQL
        return "`$fieldName`";
    }

    /**
     * @param $tableName
     * @return Table
     */
    public function table($tableName)
    {
        return new Table($tableName, $this);
    }

    /**
     * @param string $statement
     * @param array $params
     */
    public function log(string $statement, array $params) {
        if ($this->debugMode) {
            echo $statement . "\n";
            foreach ($params as $k => $v) {
                echo "    $k: $v" . "\n";
            }
        }
    }
}