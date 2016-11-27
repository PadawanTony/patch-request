<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/11/16
 */

namespace App\Socialike\Model;

interface Modeling
{
    public static function getTable ();

    public static function create (array $data) : Model;
}