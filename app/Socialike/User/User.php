<?php declare(strict_types = 1);

namespace App\Socialike\User;

use App\Socialike\Model\Model;

class User extends Model
{
    const TABLE = 'users';

    /**
     * Get the columns of the table.
     *
     * @return array
     */
    public static function columns ()
    {
        return [
            'email',
        ];
    }
}