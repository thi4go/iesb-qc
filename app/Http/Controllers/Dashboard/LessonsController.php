<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleClient;
use Crumbs;
use Meta;
use JavaScript;

class LessonsController extends BaseController
{

    /**
     * Vars
     */
    protected $course, $lesson,$client;

    /**
     * Construct
     */
    public function __construct()
    {
        // Entities
        $this->client   = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
    }

    /**
     * Display lesson
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function show($courseId, $lessonId)
    {
        $token = session('token');
        $user  = session('user');
        $url = null;

        try {
            $response = $this->client->request('GET', 'lessons/'.$courseId.'/'.$lessonId.'/'.$user->id.'?token='.$token);
            $response = \GuzzleHttp\json_decode($response->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            session()->forget('user');
            session()->forget('token');
            return response()->view('front.errors.session-expired');
        }
        $data = $response->data;

        $course = $data->course;
        $lesson = $data->lesson;
        $related = $data->related;
        $topicId = $data->topicId;

        if($topicId != null)
            $topicId = $topicId->idtopic;

        $userMadeLesson = $data->userMadeLesson;

        if($topicId != null){
            $url = '/dashboard/questoes?subject='.
                    $course->subject_idsubject .
                    '&topic='.
                    $topicId.
                    '&status=1';
        }


        // Set breadcrumbs
        Crumbs::add(route('dashboard.courses.index'), 'Matérias');
        Crumbs::add(route('dashboard.courses.show', ['course' => $course->id]), $course->title);
        Crumbs::addCurrent($lesson->title);
        // Set seo tags
        Meta::setTitle($lesson->title);
        $i = 0;
        $j = 0;
        $isLast = 0;
        $next = $lesson->id;
        $prev = $lesson->id;
        if(!empty($related)){

        // if the lesson is not the first
            if($lesson->id >= $related[$j]->id){
                while ($lesson->id < $related[$j]->id) {
                    $j++;
                }
                $prev = $related[$j]->id;
            }else{
            //the first lesson has no previous lesson, so it remains ont he actual lesson
                $prev = $lesson->id;
            }

        // if the lesson is not the last
            if ($lesson->id < $related[sizeof($related)-1]->id) {

                while ($lesson->id > $related[$i]->id) {
                    $i++;
                }

                $next = $related[$i]->id;
            }else{
            //the last lesson has no next lesson, so it remains ont he actual lesson
                $next = $lesson->id;
                $isLast = 1;
            }
        }
        $lesson->userMade = $userMadeLesson;

        $course = json_encode($course);
        $lesson = json_encode($lesson);
        $related = json_encode($related);
        $userId = $user->id;

        return view('dashboard.lessons.show', compact('course', 'lesson', 'related', 'userId', 'userMadeLesson','url'));
    }

}
