<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleClient;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    protected $token, $client;
    const DEFAULT_URL   = 'https://iesb-quiz.firebaseio.com';
    const DEFAULT_TOKEN = 'PK6uK83h1l7OL4bPctcra20PAkMejCLmiTm7qksx';
    const DEFAULT_PATH  = 'users/';

    public function __construct()
    {
        $this->client = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
        $this->userController = new UserController();
        $this->firebase = new \Firebase\FirebaseLib(self::DEFAULT_URL, self::DEFAULT_TOKEN);
    }

    public function getQuizBySubject($subjectId){

        $token = session('token');
        $user  = session('user');
        $userId = $user->id;

        try {
            $q = $this->client->request('GET', 'quiz/get-last-or-new-quiz/'.$subjectId.'/'.$user->id.'?token='.$token);
            $response = json_decode($q->getBody()->getContents());
            $quiz = $response->data;
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            return response()->view('errors.404', [], 404);
        }

        return view('dashboard/quiz/index',compact('quiz','userId','subjectId'));

    }
    public function result($subjectId){
//        $subjectName = $request->input()['subjectName'];
        $user = session('user');
        $userId = $user->id;
        $subjects = $user->subjects;
        $subjectName = null;

        foreach($subjects as $subject){
            if($subject->idsubject == intval($subjectId)){
                $subjectName = $subject->subject_name;
                break;
            }
        }


        return view('dashboard.quiz.result',compact('subjectId','userId','subjectName'));
    }

    public function landing(){
        $this->userController->updateSession();
        $token = session('token');
        $user  = session('user');

        $userId = $user->id;
        $subjectsId = [];


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

////         That if is used when there are no subjects registered
//        if(count($subjectsId) >= 3){
//            $subjects      = SubjectsController::orderSubjectsByRelevance($subjects);
//            $cycleSubjects = StudyScheduleController::filterSubjectsByCycle($user->id);
//            $subjects      = SubjectsController::filterSubjectsById($subjects,$cycleSubjects);
//            return view('dashboard.homes.fullDashboard', compact('subjects','totalStudied'));
//        }

//        $cycleSubjects = StudyScheduleController::filterSubjectsByCycle($user->id);
//        $subjects      = SubjectsController::filterSubjectsById($subjects,$cycleSubjects);
//        $subjectsQuiz  = SubjectsController::filterSubjectsById($subjects,$subjectsId,true);


        $subjectsQuiz = $subjects;

        return view('dashboard.quiz.landing', compact('subjects','subjectsQuiz','totalStudied','userId'));
    }
}