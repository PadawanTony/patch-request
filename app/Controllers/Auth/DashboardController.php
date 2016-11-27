<?php
namespace App\Controllers\Auth;

use App\Socialike\User\User;

class DashboardController extends AuthController
{
    public function index ()
    {
        $user = User::where(['id' => '1'])->first();

        return $this->view('auth.dashboard');
    }
}