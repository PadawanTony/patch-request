<?php

namespace App\Socialike\App\Creator;


use App\Socialike\App\App;
use App\Socialike\App\AppException;
use Core\Validator;
use Exception;

class CreatesApp
{
    private static $rules = [
        'name'    =>  'required|string',
    ];

    /**
     * All data must be already valdated.
     *
     * @param array                   $data
     * @param CreatesAppListener $listener
     *
     * @return mixed
     */
    public function handle (array $data, CreatesAppListener $listener)
    {
        // todo: throw exception if invaild data
        $this->guardAgainstInvalidParameters($data);

        $data = array_only(App::columns(), $data);

        try
        {
            $app = App::create([
                'name'      =>  $data['name'],
                'owner_id'  =>  $data['owner_id'],
            ]);

            return $listener->savedSuccessfully($app);
        }
        catch (Exception $e)
        {
            return $listener->unableToSave($e->getMessage());
        }
    }

    private function guardAgainstInvalidParameters (array $parameters)
    {
        $validator = new Validator();

        $validator->make($parameters, self::$rules);

        if ($validator->fails())
        {
            $message = implode(', ', $validator->messages());

            throw new AppException($message);
        }
    }
}