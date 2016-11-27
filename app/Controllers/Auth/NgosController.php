<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/19/16
 */

namespace App\Controllers\Auth;

use App\Http\Requests\Auth\Ngos\StoreNgoRequest;
use App\Http\Requests\Auth\Ngos\UpdateNgoRequest;
use App\Socialike\Faker;
use App\Socialike\Ngo\Ngo;
use Core\flash\Flash;
use Core\Request;
use Core\Response;

class NgosController extends AuthController
{
    public function create ()
    {
        return $this->view('auth.ngos.create');
    }

    /**
     * @param StoreNgoRequest $request
     */
    public function store (StoreNgoRequest $request)
    {
        $ngo = Ngo::create(Request::only('name'));

        Flash::success('Ngo created.');

        return Response::redirect("/ngos/$ngo->id/edit");
    }

    public function update (Ngo $ngo, UpdateNgoRequest $request)
    {
        $ngo = Ngo::where(['id' => $ngo->id])->update(Request::only('name'));

        Flash::success('Ngo updated.');

        return Response::redirect("/ngos/$ngo->id/edit");
    }

    public function edit (Ngo $ngo)
    {
        return $this->view('auth.ngos.edit', compact('ngo'));
    }

    public function index ()
    {
        $ngos = Ngo::paginate();

        return $this->view('auth.ngos.index', compact('ngos'));
    }
}