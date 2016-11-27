<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/13/16
 */

namespace App\Socialike\Model;

use ArrayIterator;
use ArrayObject;
use IteratorAggregate;
use Traversable;

class Collection implements IteratorAggregate
{
    /**
     * @var array
     */
    private $models;

    /**
     * Collection constructor.
     *
     * @param array $models
     */
    public function __construct (array $models)
    {
        $this->models = $models;
    }

    public function pluck ($key, $value) : array
    {
        $output = [];

        foreach ($this->models as $model)
        {
            $model = (array)$model;

            $output[ $model[ $key ] ] = $model[ $value ];
        }

        return $output;
    }

    /**
     * @return int
     */
    public function count ()
    {
        return count($this->models);
    }

    /**
     * Retrieve an external iterator
     * @link  http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator ()
    {
        return new ArrayIterator($this->all());
    }

    /**
     * @return array
     */
    public function all () : array
    {
        return $this->models;
    }

    public function get ($index)
    {
        return $this->models[$index];
    }
}