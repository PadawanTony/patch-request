<?php
/**
 * Created by PhpStorm.
 * User: antony
 * Date: 11/18/16
 * Time: 1:48 PM
 */

namespace App\Controllers\Auth;


use App\Http\Requests\Auth\Apps\StoreAppRequest;
use App\Http\Requests\Auth\Apps\UpdateAppRequest;
use App\Socialike\App\App;
use App\Socialike\App\Creator\CreatesApp;
use App\Socialike\App\Creator\CreatesAppListener;
use App\Socialike\Model\Modeling;
use App\Socialike\User\User;
use Core\flash\Flash;
use Core\Request;
use Core\Response;
use Exception;

class AppsController extends AuthController implements CreatesAppListener
{
    public function create ()
    {
        return $this->view('auth.apps.create');
    }

    public function store (StoreAppRequest $request)
    {
        try {
            $surveyor = User::create([
                'email'    => faker()->email,
                'password' => '$2a$06$NTODQCQK7SDwK.F56geB/eCe09Hqw80D8OPHGs4DXkgGAGcKhn0Pi',
            ]);

            $createsApp = new CreatesApp();

            $input = array_merge(['owner_id' => $surveyor->id], Request::all());

            return $createsApp->handle($input, $this);
        }
        catch (Exception $e)
        {
            Flash::error($e->getMessage());

            return Response::back();
        }
    }


    public function savedSuccessfully (Modeling $app)
    {
        Flash::success('App created.');

        return Response::redirect("/apps/$app->id/edit");
    }

    public function unableToSave ($errorMessage)
    {
        Flash::error('Unable to create app.');

        return Response::back();
    }

    public function edit (App $app)
    {
        return $this->view('auth.apps.edit', compact('app'));
    }

    public function index ()
    {
        $apps = App::paginate();

        return $this->view('auth.apps.index', compact('apps'));
    }

    public function update (App $app, UpdateAppRequest $request)
    {
        $app = App::where(['id' => $app->id])->update(Request::only([
            'name',
        ]));

        Flash::success('App updated.');

        return Response::redirect("/apps/$app->id/edit");
    }

}