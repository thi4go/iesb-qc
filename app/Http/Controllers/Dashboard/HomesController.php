<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Course;
use GuzzleHttp\Client as GuzzleClient;
use App\Http\Controllers\Dashboard\UserController;

class HomesController extends Controller
{
    const DEFAULT_URL   = 'https://iesb-quiz.firebaseio.com';
    const DEFAULT_TOKEN = 'PK6uK83h1l7OL4bPctcra20PAkMejCLmiTm7qksx';
    const DEFAULT_PATH  = 'users/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $client,$firebase,$userController;


    public function __construct()
    {
        $this->client   = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
        $this->firebase = new \Firebase\FirebaseLib(self::DEFAULT_URL, self::DEFAULT_TOKEN);
        $this->userController = new UserController();
    }


    public function index()
    {


        $this->userController->updateSession();
        $token = session('token');
        $user  = session('user');

        $userId = $user->id;
        $userEfficiency = $user->efficiency;
        $subjectsId = [];

        $wizard = $user->wizard;

        if(!$user->wizard)
            return view('dashboard.homes.tutorial', compact('userId', 'token','wizard'));

        $quizzes = $this->firebase->get(self::DEFAULT_PATH . $user->id );

        $quizzes = \GuzzleHttp\json_decode($quizzes);

        if($quizzes !== null)
            foreach($quizzes as $subjectId=>$quiz)
                $subjectsId[] = intval($subjectId);

        try {
            //Gets the subjects for determined user
            $response = $this->client->get('subject/getSubjectCoursePercentagebyUser/'. $userId . '?token='.$token);

            $response = \GuzzleHttp\json_decode($response->getBody()->getContents());

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            session()->forget('user');
            session()->forget('token');
            return response()->view('front.errors.session-expired');
        }

        $subjects =   json_encode($response->data->subjectsWithPercentageMade);

        $totalStudied = $response->data->totalCourseMadeByUser*100;
        $totalStudied = round($totalStudied,2);

        $subjectsQuiz = $subjects;
        $quizCount = count($subjectsId);

        return view('dashboard.homes.index', compact('subjects','subjectsQuiz','totalStudied','userId','userEfficiency', 'quizCount'));

    }


    public function tutorial()
    {
        $this->userController->updateSession();
        $token = session('token');
        $user  = session('user');
        $userId = $user->id;
        $wizard = $user->wizard;

        return view('dashboard.homes.tutorial', compact('userId','token','wizard'));
    }

    public function notFound()
    {
        return view('redirect.page404');
    }

    public function error()
    {
        return view('redirect.page500');
    }

    public function terms(){
        return view('terms.terms');
    }
}
