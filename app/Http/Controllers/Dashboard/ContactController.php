<?php

namespace App\Http\Controllers\Dashboard;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client as GuzzleClient;



class ContactController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client         = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
    }


    public function index()
    {
        return view('dashboard.emails.contact');
    }

    public function postContact(Request $request)
    {
        $this->validate($request,[

            'name'      => 'required',
            'email'     =>'required|email',
            'subject'   => 'min:3',
            'message'   => 'min:5'
        ]);

        $data = [
            'name'          =>  $request->name,
            'email'         =>  $request->email,
            'subject'       =>  $request->subject,
            'bodyMessage'   =>  $request->message
        ];


        Mail::send('dashboard.emails.email',$data, function ($message) use ($data)
        {

            $message->replyTo($data['email'], $data['name']);
            $message->to('iesb@examedaoab.com');
            $message->subject($data['subject']);

        });

        return \GuzzleHttp\json_encode($data);
    }


    public function reportError(Request $request)
    {

        try {
            $q = $this->client->request('GET', 'user/get-user/' . $request->userId);
            $response = json_decode($q->getBody()->getContents());
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            return response()->view('errors.404', [], 404);
        }

        date_default_timezone_set('America/Sao_Paulo');


        $data = [
            'name'          =>  $response->data->name,
            'email'         =>  $response->data->email,
            'subject'       =>  $request->subject,
            'bodyMessage'   =>  $request->message,
            'pageUrl'       =>  $request->pageUrl,
            'questionId'    =>  $request->questionId,
            'date'          => gmDate('d-m-Y\TH:i:s\Z', time() + date("Z"))
        ];


        Mail::send('dashboard.emails.report', $data, function ($message) use ($data)
        {
            $message->replyTo($data['email'], $data['name']);
            $message->to('iesb@examedaoab.com');
            $message->subject($data['subject']);
        });

        return \GuzzleHttp\json_encode($data);
    }

    public function askLesson(Request $request)
    {
        try {
            $q = $this->client->request('GET', 'user/get-user/' . $request->userId);
            $response = json_decode($q->getBody()->getContents());
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            return response()->view('errors.404', [], 404);
        }

        date_default_timezone_set('America/Sao_Paulo');


        $data = [
            'name'          =>  $response->data->name,
            'email'         =>  $response->data->email,
            'subject'       =>  '['.__('generics.title').']'.$request->subject,
            'lessonTitle'   =>  $request->lessonTitle,
            'lessonSubject' =>  $request->lessonSubject,
            'date'          => gmDate('d-m-Y\TH:i:s\Z', time() + date("Z"))
        ];


        Mail::send('dashboard.emails.lesson', $data, function ($message) use ($data)
        {
            $message->replyTo($data['email'], $data['name']);
            $message->to('iesb@examedaoab.com');
            $message->subject($data['subject']);
        });

        return \GuzzleHttp\json_encode($data);
    }

}
