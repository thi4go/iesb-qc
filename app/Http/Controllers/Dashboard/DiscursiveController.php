<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 20/03/17
 * Time: 09:31
 */

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Course;
use GuzzleHttp\Client as GuzzleClient;
use App\Http\Controllers\Dashboard\UserController;
use JavaScript;



class DiscursiveController extends Controller
{
    protected $client, $firebase, $userController;

    public function __construct(Request $request)
    {
        $this->client = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
    }

    public function index()
    {
        $token = session('token');
        $user  = session('user');

        $userId = $user->id;


        try {
            //Gets the subjects for determined user
            $response = $this->client->get('discursives/discursive-subjects/2010,2017,0,1?token='.$token);
//            dd($response);
            $responseCount = $this->client->get('discursives/count?token='.$token);
            $response = \GuzzleHttp\json_decode($response->getBody()->getContents());
            $responseCount = \GuzzleHttp\json_decode($responseCount->getBody()->getContents());

        } catch (\GuzzleHttp\Exception\ClientException $e) {
//            session()->forget('user');
//            session()->forget('token');
            return response()->view('dashboard.auth.login');
        }

        $count = json_encode($responseCount);
        $subjects =   json_encode($response);


        return view('dashboard.discursive.index', compact('subjects', 'count', 'userId'));

    }


    public function questions($id, $startYear, $endYear, $hasFeedback, $type)
    {
        $token = session('token');
        $user  = session('user');

        try {
            $response = $this->client->get('discursives/get-discursive-questions/'
                .$id.','.$startYear.','.$endYear.','.$hasFeedback.','.$type.','.$type.'?token='.$token);
            $response = \GuzzleHttp\json_decode($response->getBody()->getContents());
//            dd($response);

        } catch(\GuzzleHttp\Exception\ClientException $e) {
            session()->forget('user');
            session()->forget('token');
            return response()->view('dashboard.auth.login');
        }

        $questions =   json_encode($response);

//        $questions  = json_decode($q->getBody()->getContents());
//
//        $countQuestion = count($questions->discursive);
//
//        $question = $questions->discursive;
//
//        JavaScript::put(['questions'=>$question,
//            'maxQuestion'=>$countQuestion,
//            'userId' => $user->id,
//            'user' => $user
//        ]);
//
//        $question = $questions->discursive[0];

        $countQuestion = 0;
        $userId = $user->id;

        return view('dashboard.discursive.question', compact('questions','countQuestion', 'userId'));

    }

    public function resolvedQuestions(){
        $token = session('token');
        $user  = session('user');

        try {
            $response = $this->client->get('discursives/get-answered-questions/'
                . $user->id . '?token='.$token);
            $response = \GuzzleHttp\json_decode($response->getBody()->getContents());

        } catch(\GuzzleHttp\Exception\ClientException $e) {
//            session()->forget('user');
//            session()->forget('token');
            return response()->view('dashboard.auth.login');
        }

        $questions =   json_encode($response);

        return view('dashboard.discursive.resolved', compact('questions', 'user'));

    }

}