<?php declare(strict_types = 1);

namespace App\Socialike\App;

use App\Socialike\Model\Model;

/**
 * User: antony
 * Date: 11/18/16
 * Time: 2:45 PM
 */
class App extends Model
{
    const TABLE = 'apps';
    const OWNER_ID = 'owner_id';
    const TOKEN = 'token';
    const NAME = 'name';

    /**
     * Get the columns of the table.
     *
     * @return mixed
     */
    public static function columns ()
    {
        return [
            'name',
            'owner_id',
        ];
    }
}