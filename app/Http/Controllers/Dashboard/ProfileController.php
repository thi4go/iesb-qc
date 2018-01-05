<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\UserController;
use GuzzleHttp\Client as GuzzleClient;

class ProfileController extends Controller
{
    protected $client, $userController;

    public function __construct(UserController $userController)
    {
        $this->client = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
        $this->userController = $userController;
    }

    /**
     * Return index view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->userController->updateSession();
        $url = session()->get('user')->avatar;
        $userId = session()->get('user')->id;
        $user = session()->get('user');
        $userName = session()->get('user')->name;
        $email = session()->get('user')->email;
        $birth = session()->get('user')->birthdate;
        $gender = session()->get('user')->gender;
//        dd($user);
        $avatar = $url;

        return view('dashboard.profile.index', compact('avatar','userId','userName','birth','email','gender'));
    }


}
