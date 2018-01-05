<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Library\RDStationAPI;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }


    public function registerNormal()
    {
        $token = session('token');
        $user  = session('user');

        if($user != null && $token != null)
            return redirect('/dashboard');

        return view('dashboard.auth.register');
    }
}
