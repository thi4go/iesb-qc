<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Http\Controllers\Dashboard\HomesController;
use Response;

class AuthController extends Controller
{
    protected $client,$userController;

    public function __construct()
    {
        $this->client         = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
        $this->userController = new UserController();
    }

    public function index()
    {
        $token = session('token');
        $user  = session('user');


        if($user == null && $token == null)
            return view('dashboard.auth.login');
        else
            return redirect('/dashboard/');

    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {

            $response = $this->client->request('POST', 'login', [
                'form_params' => [
                    'email' => $credentials['email'],
                    'password' => $credentials['password']
                ]
            ], ['http_errors' => false]);

            $data = json_decode($response->getBody()->getContents());

            if($data->user->birthdate !== null){
                $format = date('d-m-Y', strtotime($data->user->birthdate));
                $data->user->birthdate = $format;
            }

            $this->userController->sendToRdStation($data->user);

            if($data->user->activated == 1) {
                session(['user'  => $data->user ]);
                session(['token' => $data->token ]);
            } else {
                return redirect()->route('dashboard.login', ['activate_email' => true]);
            }

            return redirect()->route('dashboard.homes.index');

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return redirect()->route('dashboard.login.index', ['failed' => true]);
        }

    }

    public function logout()
    {
        session()->forget('token');
        session()->forget('user');

        return redirect()->route('dashboard.login.index');
    }


    public function forgotPassword()
    {
        return view('dashboard.auth.forgot');
    }


    /**
     * Send reco
     * @param Request $request
     * @return mixed
     */
    public function sendRecoveryMail(Request $request)
    {

        date_default_timezone_set('America/Sao_Paulo');
//        $expirationDate = gmDate('Y-m-d\TH:i:s\Z', time() + date("Z") + 86400);
        $utc = (time() + date("Z") + 86400);

        $message = [
            'date'      => $utc,
            'userId'    => $request->userId,
            'name'      => $request->name
        ];



        $encrypted = Crypt::encryptString(\GuzzleHttp\json_encode($message));

        $url = "https://iesb.examedaoab.com/change-page/" . $encrypted;


        $data = [
            'userId'        => $request->userId,
            'name'          => $request->name,
            'email'         => $request->email,
            'subject'       => 'examedaoab.com - Recuperar Senha',
            'url'           => $url
        ];



        Mail::send('dashboard.emails.recover', $data, function ($message) use ($data)
        {
            $message->to($data['email']);
            $message->subject($data['subject']);

        });
//
        return Response::json([
            'success' => True,
            'message' => "ok"
        ]);
    }


    public function changePassword($token)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $decrypted = Crypt::decryptString($token);

        $message = \GuzzleHttp\json_decode($decrypted);

        $userId = $message->userId;
        $date   = $message->date;
        $name   = $message->name;
        $now    = (time() + date("Z"));

        if($now > $date)
            $expired = true;
        else
            $expired = false;


        return view('dashboard.auth.changePassword', compact('userId','expired','name'));
    }

}
