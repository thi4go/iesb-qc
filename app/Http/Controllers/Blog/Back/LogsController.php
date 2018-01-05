<?php

namespace App\Http\Controllers\Blog\Back;

use Activity;
use Crumbs;
use App\Models\ActivityLog;

class LogsController extends PainelController
{

    /**
     * @var [type]
     */
    protected $log;

    /**
     * Construct
     */
    public function __construct(ActivityLog $log)
    {
        // Middlewares
        $this->middleware('sentinel.access:painel.logs.read', ['only' => ['index']]);
        $this->middleware('sentinel.access:painel.logs.write', ['only' => ['destroy']]);
        // Entities
        $this->log = $log;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all logs order by created_at desc
        $data = $this->log->orderBy('created_at','desc')->paginate(10);
        // Set breadcrumbs
        Crumbs::addCurrent('Logs');
        // Return view index
        return view('blog.back.logs.index', compact('data'));
    }

}
