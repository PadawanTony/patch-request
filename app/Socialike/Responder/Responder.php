<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/20/16
 */

namespace App\Socialike\Responder;

use App\Socialike\App\App;
use App\Socialike\Model\Model;

class Responder extends Model
{
    const TABLE = 'responders';
    const APP_ID = 'app_id';
    const MOBILE_UUID = 'mobile_uuid';
    const BIRTHDATE = 'birthdate';
    const GENDER = 'gender';
    const EMAIL = 'email';
    const LOCATION = 'location';

    /**
     * @var App
     */
    protected $app;

    /**
     * Get the columns of the table.
     *
     * @return mixed
     */
    public static function columns ()
    {
        // TODO: Implement columns() method.
    }

    public function app ()
    {
        if (empty($this->app))
        {
            $this->app = App::where(['id' => $this->app_id])->first();
        }

        return $this->app;
    }
}