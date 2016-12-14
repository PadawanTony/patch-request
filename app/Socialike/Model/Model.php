<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  10/23/16
 */

namespace App\Socialike\Model;

use App\Http\Paginator;
use App\Socialike\App\App;
use App\Socialike\Article;
use App\Socialike\Campaign\Campaign;
use App\Socialike\Element\Element;
use App\Socialike\Ngo\Ngo;
use App\Socialike\Question\Question;
use App\Socialike\QuestionValue\QuestionValue;
use App\Socialike\Responder\Responder;
use App\Socialike\Response\Response;
use App\Socialike\User\User;
use Core\database\DB;
use Core\Route;
use ReflectionClass;

abstract class Model implements Modeling
{
    /**
     * @var array
     */
    protected static $clauses = [];
    /**
     * @var
     */
    protected static $instance;
    protected static $limit;
    protected static $offset;
    private static $models = [
        Ngo::TABLE           => Ngo::class,
        User::TABLE          => User::class,
        Campaign::TABLE      => Campaign::class,
        App::TABLE           => App::class,
        Element::TABLE       => Element::class,
        Question::TABLE      => Question::class,
        QuestionValue::TABLE => QuestionValue::class,
        Response::TABLE      => Response::class,
        Responder::TABLE     => Responder::class,
        Article::TABLE       => Article::class,
    ];

    /**
     * @return string Name of DB table
     * @throws \Exception
     */
    public static function getTable ()
    {
        $tables = array_flip(self::$models);

        $model = static::class;

        $reflect = new ReflectionClass($model);

        if ( ! array_key_exists($reflect->getName(), $tables))
        {
            throw new \Exception('Unable to find table for model: ' . $reflect->getName());
        }

        return $tables[ $reflect->getName() ];
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public static function create (array $data) : Model
    {
        $model = static::class;

        return DB::table($model)->insert($data);
    }

    /**
     * @param array $select
     *
     * @return Model|false
     */
    public static function first (array $select = ['*'])
    {
        $model = static::class;

        $results = DB::table($model)->first($select, self::$clauses);

        self::$clauses = [];

        return $results;
    }

    /**
     * Get the columns of the table.
     *
     * @return mixed
     */
    abstract public static function columns ();

    /**
     * @param $table
     *
     * @return Model
     */
    public static function getModelByTable ($table)
    {
        $modelClass = self::$models[ $table ];

        return new $modelClass;
    }

    /**
     * @param int|null $perPage
     * @param array    $columns
     * @param string   $pageName
     * @param int|null $page
     *
     * @return Paginator
     */
    public static function paginate ($perPage = 10, $columns = ['*'], $pageName = 'page', $page = 0)
    {
        $page = $page == 0 ? (int)(Route::get($pageName)) : $page;

        return new Paginator(self::instance(), $perPage, $columns, $pageName, $page);
    }

    public static function instance ()
    {
        return self::$instance == null ? new static : self::$instance;
    }

    /**
     * @param array $select
     *
     * @return Collection
     */
    public static function all (array $select = ['*']) : Collection
    {
        $model = static::class;

        $array = DB::table($model)->all($select, self::$clauses, self::$limit, self::$offset);

        self::$clauses = [];

        return new Collection($array);
    }

    public static function limit ($limit)
    {
        self::$limit = $limit;

        return self::instance();
    }

    public static function offset ($offset)
    {
        self::$offset = $offset;

        return self::instance();
    }

    public static function update ($data)
    {
        $model = static::class;

        if (empty(self::$clauses))
        {
            self::where(['id' => self::$id]);
        }

        $results = DB::table($model)->update($data, self::$clauses);

        self::$clauses = [];

        return $results;
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public static function where (array $data) : Model
    {
        self::$clauses[] = $data;

        return self::instance();
    }

    public function count ()
    {
        $model = static::class;

        return DB::table($model)->count(self::$clauses);
    }

    public function __get ($property)
    {
        if (property_exists($this, $property))
        {
            return $this->$property();
        }
    }
}