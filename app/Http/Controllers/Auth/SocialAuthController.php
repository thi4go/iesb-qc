<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7;
use Validator;
use Socialite;

class SocialAuthController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
    }

    public function redirect()
    {
        // $response = $this->client->request('GET', 'auth/redirectapi');
        // $url = $response->getBody()->getContents();
        // return redirect($url);
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(Request $request)
    {
        $providerUser = \Socialite::driver('facebook')->user();
        try {
            $response = $this->client->request('POST', 'auth/facebook-auth', [
                'json' => ['user' => $providerUser]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            //echo Psr7\str($e->getRequest());
            // dd($e);
        }

        $data = json_decode($response->getBody()->getContents());

        if(isset($e) || isset($data->error)){
            return redirect()->route('dashboard.login', ['fb_error' => true]);
        } else {
            session(['user'  => $data->user]);
            session(['token' => $data->token]);
            return redirect()->route('dashboard.homes.index');
        }


        return redirect()->route('dashboard.login', ['user_created' => true]);
    }

}
