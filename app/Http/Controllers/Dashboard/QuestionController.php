<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use App\Http\Requests;
use Response;

class QuestionController extends Controller
{
    protected $client, $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer; // Para enviar o email no reportar um erro de uma questão
        $this->client = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
    }

    public function questions($id)
    {
        try {
            $q = $this->client->request('GET', 'question/'.$id.'?token='.$this->token);
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            session()->forget('user');
            session()->forget('token');
            return response()->view('dashboard.auth.login');
        }

        $question = json_decode($q->getBody()->getContents());

        return Response::json($question);
    }

    public function index(Request $request)
    {
        $token = session('token');
        $user  = session('user');
        $data  = $request->all();

        $subject = $this->getSubject($data['ids']);;
        $topic   = $this->getTopic($data['idt']);;

        $questions = $this->getQuestions($data);

        if($data['idt'] == 0)
            $id = $data['ids'];
        else
            $id = $data['idt'];


        if(isset($data['jury'])) {
            $request = [
                'json' => [
                    'id'        => $id,
                    'jury'      => $data['jury'],
                    'nOfAlt'    => 0,
                    'startYear' => 2004,
                    'endYear'   => 2017,
                    'keyword'   => '',
                    'status'    => $data['status']
                ]
            ];
        } else {
            $request = [
                'json' => [
                    'id'        => $id,
                    'startYear' => 2004,
                    'endYear'   => 2017,
                    'keyword'   => '',
                    'status'    => $data['status']
                ]
            ];
        }

        if(!isset($data['count'])) {
            if($data['idt'] == 0)
                $response = $this->client->request('POST', 'questions/count-by-subject/', $request);
            else
                $response = $this->client->request('POST', 'questions/count-by-topic/', $request);

            $count = json_decode($response->getBody()->getContents());
        } else {
            $count = $data['count'];
        }

        if($count == 0) {
            $user = json_encode($user);
            return view('dashboard.filter.index', compact('user'));
        }

        $generic = $data['generic'];

        if($data['idt'] == 0)
            $id = $data['ids'];
        else
            $id = $data['idt'];


        $userId = $user->id;

        $questions = json_encode($questions);
        $user      = json_encode($user);
        $subject   = json_encode($subject);
        $topic     = json_encode($topic);
        $status    = $data['status'];
        $startYear = $data['startYear'];
        $endYear   = $data['endYear'];
        $keyWord   = $data['keyWord'];

        if(isset($data['jury'])) {
            $jury      = $data['jury'];
            $nOfAlt    = $data['nOfAlt'];

            return view('dashboard.questions.resolution', compact('questions', 'subject', 'topic', 'user','count',
                'generic', 'id', 'userId', 'status', 'token', 'jury', 'startYear', 'endYear','keyWord','nOfAlt'));
        } else {
            return view('dashboard.questions.resolution', compact('questions', 'subject', 'topic', 'user','count',
                'generic', 'id', 'userId', 'status', 'token', 'startYear', 'endYear','keyWord'));
        }
    }

    public function getQuestions($data)
    {

        $token = session('token');
        $user  = session('user');
        $generic = $data['generic'];


        if($data['idt'] == 0)
            $id = $data['ids'];
        else
            $id = $data['idt'];

        if(isset($data['jury'])) {
            $info = [ 'json' => ['id' => $id, 'jury' => $data['jury'], 'status' => $data['status'] ,
                'userId' => session('user')->id, 'endYear' => $data['endYear'], 'startYear' => $data['startYear'],
                'pagination' => 0, 'keyWord'   => $data['keyWord'], 'nOfAlt' => $data['nOfAlt']]];
        } else {
            $info = [ 'json' => ['id' => $id, 'status' => $data['status'],
                'userId' => session('user')->id, 'endYear' => $data['endYear'], 'startYear' => $data['startYear'],
                'pagination' => 0, 'keyWord'   => $data['keyWord'] ]];
        }

        try {
            $q = $this->client->request('POST', 'questions/by-'.$generic, $info);

        } catch(\GuzzleHttp\Exception\ClientException $e) {
            return response()->view('front.errors.404');
        }


        $response  = json_decode($q->getBody()->getContents());

        $questions = $response->questions;

        return $questions;
    }

    public function getSubject($id)
    {
        $token = session('token');

        if($id == 0){
            $subject = (object) [];
            $subject->subject_name = 'Questões de todos os assuntos';
            $subject->subject = null;
            $subject->idsubject = 0;

            return $subject;
        }

        try {
            $s = $this->client->request('GET', 'subject/'.$id.'?token='.$token);
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            session()->forget('user');
            session()->forget('token');
            return response()->view('dashboard.auth.login');
        }
        $subject  = json_decode($s->getBody()->getContents());


        $subject  = $subject->subject;

        return $subject;
    }

    public function getTopic($id)
    {
        $token = session('token');

        if($id == 0){
            $topic = (object) [];
            $topic->topic_name = 'Questões de todos os assuntos';
            $topic->idtopic = null;

            return $topic;
        }

        try {
            $t = $this->client->request('GET', 'topic/'.$id.'?token='.$token);
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            session()->forget('user');
            session()->forget('token');
            return response()->view('dashboard.auth.login');
        }

        $topic = json_decode($t->getBody()->getContents());

        return $topic;
    }

    public function getAllTopics($id)
    {
        $token = session('token');

        if($id == 0){
            $topic = (object) [];
            $topic->topic_name = 'Questões de todos os assuntos';

            return $topic;
        }
        try {
            $t = $this->client->request('GET', 'topic/by-subject/'.$id.'?token='.$token);
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            return response()->view('front.errors.404', [], 404);
        }

        $topic = json_decode($t->getBody()->getContents());
        return $topic;
    }



    public function sendReport(Request $request)
    {
        dd($request->all());
        $message = sprintf('');
    }

}
