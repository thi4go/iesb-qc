<?php

namespace App\Http\Controllers\Blog\Back;

class DashboardController extends PainelController
{

    /**
     * Return dashboard
     */
    public function index()
    {
        return view('blog.back.dashboard.index');
    }

}
