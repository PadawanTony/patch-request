<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/8/16
 */

namespace Core\database;

class DB extends QueryBuilder
{
    /**
     * @param $classname
     *
     * @return QueryBuilder
     */
    public static function table ($classname) : QueryBuilder
    {
        return new QueryBuilder(new $classname);
    }
}