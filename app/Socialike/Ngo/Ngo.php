<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/10/16
 */

namespace App\Socialike\Ngo;

use App\Socialike\Model\Model;

class Ngo extends Model
{
    const TABLE = 'ngos';

    /**
     * Get the columns a user can fill. Note don't put primary or foreigns key here!
     *
     * @return mixed
     */
    public static function columns ()
    {
        return ['name'];
    }
}