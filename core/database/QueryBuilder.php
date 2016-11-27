<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @author Antony Kalogeropoulos <anthonykalogeropoulos@gmail.com>
 * @since  10/23/16
 */

namespace Core\database;

use App\Socialike\Model\Model;
use App\Socialike\Model\Modeling;
use Carbon\Carbon;
use Core\App;
use Exception;
use PDO;

/**
 * Class QueryBuilder
 * @package Core\database
 */
class QueryBuilder
{
    const KEY = 'key';
    const VALUE = 'value';
    const COMPARISON = 'comparison';
    const UNIQUE = 'unique';
    const COLUMN = 'column';
    /**
     * @var Modeling
     */
    protected $model;
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * QueryBuilder constructor.
     *
     * @param $model
     */
    public function __construct (Modeling $model)
    {
        $this->pdo = Connection::make(App::get('config.database'));

        $dbType = App::get('config.database')['type'];

        $this->dbName = App::get('config.database')[ $dbType ]['dbname'];

        $this->model = $model;
    }

    /**
     * @param array $data
     *
     * @return Model
     * @throws Exception
     */
    public function insert (array $data) : Model
    {
        $now = Carbon::now()->format('Y-m-d H:m:s');
        $data['created_at'] = $now;
        $data['updated_at'] = $now;

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            "{$this->dbName}.{$this->model->getTable()}",
            implode(', ', array_keys($data)),
            ':' . implode(', :', array_keys($data))
        );

        $statement = $this->pdo->prepare($sql);

        if ( ! $statement->execute($data))
        {
            throw new Exception('Unable to insert data.');
        }

        return self::first(['*'], [['id' => $this->pdo->lastInsertId()]]);
    }

    /**
     * @param array $select
     *
     * @param array $clauses
     *
     * @return Model|false
     */
    public function first (array $select = ['*'], array $clauses = [])
    {
        $sql = sprintf("select %s from {$this->dbName}.{$this->model->getTable()}", implode(', ', $select));

        if ( ! empty($clauses))
        {
            $sql = sprintf("$sql where %s", self::generateWhereClauses($clauses));
        }

        $sql .= ' limit 1';

        $statement = $this->pdo->prepare($sql);

        $statement->execute(self::generateExecuteWhereClauses($clauses));

        return $statement->fetchObject(get_class($this->model));
    }

    /**
     * @param array $inputClauses
     *
     * @return string
     */
    private static function generateWhereClauses (array $inputClauses) : string
    {
        $outputClauses = [];

        foreach ($inputClauses as $column => $value)
        {
            if ( ! is_array($value))
            {
                $outputClauses[] = $column . '=:' . $column;

                continue;
            }
            if (count($value) == 1)
            {
                $outputClauses[] = key($value) . '=:' . key($value);

                continue;
            }

            $outputClauses[] = $value[ self::KEY ] . $value[ self::COMPARISON ] . ':' . $value[ self::KEY ];
        }

        return implode(' and ', $outputClauses);
    }

    private static function generateExecuteWhereClauses ($clauses)
    {
        $outputClauses = [];

        foreach ($clauses as $key => $clause)
        {
            if ( ! is_array($clause))
            {
                $outputClauses[ $key ] = $clause;

                continue;
            }

            if (count($clause) == 1)
            {
                $outputClauses[ key($clause) ] = $clause[ key($clause) ];

                continue;
            }

            $outputClauses[ $clause[ self::KEY ] ] = $clause[ self::VALUE ];
        }

        return $outputClauses;
    }

    /**
     * @param array $select
     * @param array $clauses
     * @param       $limit
     * @param null  $offset
     *
     * @return array
     */
    public function all (array $select = ['*'], array $clauses = [], $limit = null, $offset = null) : array
    {
        $sql = sprintf("select %s from {$this->dbName}.{$this->model->getTable()}", implode(', ', $select));

        if ( ! empty($clauses))
        {
            $sql = sprintf("$sql where %s", self::generateWhereClauses($clauses));
        }

        if (isset($limit))
        {
            $sql = sprintf("$sql limit %d", $limit);
        }

        if (isset($offset))
        {
            $sql = sprintf("$sql offset %d", $offset);
        }

        $statement = $this->pdo->prepare($sql);

        $statement->execute(self::generateExecuteWhereClauses($clauses));

        return $statement->fetchAll(PDO::FETCH_CLASS, get_class($this->model));
    }

    /**
     * @param array $inputSetClauses
     * @param array $inputWhereClauses
     *
     * @return Model|false
     * @throws QueryBuilderException
     */
    public function update (array $inputSetClauses, array $inputWhereClauses = [])
    {
        $now = Carbon::now()->format('Y-m-d H:m:s');

        $inputSetClauses['updated_at'] = $now;

        $setClauses = [];

        foreach ($inputSetClauses as $columnName => $inputSetClause)
        {
            $setClauses[ $columnName ] = [
                self::UNIQUE => "{$columnName}_set",
                self::COLUMN => $columnName,
                self::VALUE  => $inputSetClause,
            ];
        }

        $sql = empty($inputWhereClauses) ? 'UPDATE %s SET %s' : 'UPDATE %s SET %s WHERE %s';

        $sql = sprintf(
            $sql,
            "{$this->dbName}.{$this->model->getTable()}",
            $this->generateSetClauses($setClauses),
            self::generateWhereClauses($inputWhereClauses)
        );

        $statement = $this->pdo->prepare($sql);

        $executeParameters = array_merge(
            self::generateExecuteSetClauses($setClauses), self::generateExecuteWhereClauses($inputWhereClauses)
        );

        if ( ! $statement->execute($executeParameters))
        {
            throw new QueryBuilderException('Updated failed.');
        }

        return self::first(['*'], self::generateWhereSetClauses($inputSetClauses, $inputWhereClauses));
    }

    private static function generateSetClauses (array $clauses): string
    {
        array_walk($clauses, function (&$clause, $key)
        {
            $clause = "{$clause[self::COLUMN]}=:{$clause[self::UNIQUE]}";
        });

        return implode(', ', $clauses);
    }

    private static function generateExecuteSetClauses (array $clauses)
    {
        $outputClauses = [];

        foreach ($clauses as $key => $clause)
        {
            $outputClauses[ $clause[ self::UNIQUE ] ] = $clause[ self::VALUE ];
        }

        return $outputClauses;
    }

    private static function generateWhereSetClauses (array $inputSetClauses, array $inputWhereClauses)
    {
        $whereClauses = [];

        foreach ($inputWhereClauses as $inputWhereClause)
        {
            foreach ($inputWhereClause as $key => $whereClause)
            {
                $whereClauses[ $key ] = $whereClause;
            }
        }

        return array_diff_assoc($whereClauses, $inputSetClauses);
    }

    public function count (array $clauses) : int
    {
        $sql = "select count( id ) from {$this->dbName}.{$this->model->getTable()}";

        if ( ! empty($clauses))
        {
            $sql = sprintf("$sql where %s", self::generateWhereClauses($clauses));
        }

        $statement = $this->pdo->prepare($sql);

        $statement->execute($clauses);

        return $statement->fetchColumn();
    }
}