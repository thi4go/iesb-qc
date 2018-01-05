<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleClient;


class ResultController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client  = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
    }

    public function result($idsubject, $idtopic)
    {
        $iduser    = session('user')->id;
        $idsubject = (int) $idsubject;
        $idtopic   = (int) $idtopic;

        try {
            $subject = $this->client->request('GET', 'subject/get/'.$idsubject);
            $topics  = $idsubject !=0 ? $this->client->request('GET', 'topic/by-subject/'.$idsubject) : $this->client->request('GET','subjects/getSubjects');
            $subject = json_decode($subject->getBody()->getContents());
            $topics  = json_decode($topics->getBody()->getContents());
            if ($idsubject != 0) {
                $topics  = $topics->topic;
            }
        } catch(\Exception $e) {
            return response()->view('errors.404');
        }

        $subject = $subject->subject;
        $subject = json_encode($subject);
        $topics  = json_encode($topics);

        return view('dashboard.questions.result', compact('iduser', 'idsubject', 'idtopic', 'topics', 'subject'));
    }
}
