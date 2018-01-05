<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Crumbs;
use Meta;
use GuzzleHttp\Client as GuzzleClient;

class CoursesController extends BaseController
{

    /**
     * Vars
     */
    protected $client;

    /**
     * Construct
     */
    public function __construct()
    {

        $this->client   = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = session('token');
        $user  = session('user');


        try {

            $courses = $this->client->request('GET', 'course/'.'?token='.$token);
            $courses = \GuzzleHttp\json_decode($courses->getBody()->getContents());


        } catch (\GuzzleHttp\Exception\ClientException $e) {
            session()->forget('user');
            session()->forget('token');
            return response()->view('front.errors.session-expired');
        }

        // Set seo tags
        Meta::setTitle('Matérias');
        // Return view index

        $courses = json_encode($courses);
        $user    = json_encode($user);

        return view('dashboard.courses.index', compact('courses', 'user'));


    }

    /**
     * Display course
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function show($courseId)
    {
        // Get course by slug

        $token = session('token');
        $user  = session('user');

        try {
            $course = $this->client->request('GET', 'course/'.$courseId.'/'.$user->id.'?token='.$token);
            $course = \GuzzleHttp\json_decode($course->getBody()->getContents(),true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            session()->forget('user');
            session()->forget('token');
            return response()->view('front.errors.session-expired');
        }

        // Set breadcrumbs
        Crumbs::add(route('dashboard.courses.index'), 'Matérias');
        Crumbs::addCurrent($course['course']['title']);
        // Set seo tags
        Meta::setTitle($course['course']['title']);
        // Return view index
        $course = $course['course'];
        $course = json_encode($course);
        return view('dashboard.courses.show', compact('course'));
    }

    public function showBySubject($subjectId)
    {
        // Get course by slug

        $token = session('token');
        $user  = session('user');

        try {
            $courses = $this->client->request('GET', 'courses/by-subject/'.$subjectId.'/'.$user->id.'?token='.$token);
            $courses = \GuzzleHttp\json_decode($courses->getBody()->getContents(),true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
        }


        $course  = $courses['data'][0];


        // Set breadcrumbs
        Crumbs::add(route('dashboard.courses.index'), 'Matérias');
        Crumbs::addCurrent($course['title']);
        // Set seo tags
        Meta::setTitle($course['title']);


        $course = json_encode($course);



        return view('dashboard.courses.show', compact('course'));
    }

}
