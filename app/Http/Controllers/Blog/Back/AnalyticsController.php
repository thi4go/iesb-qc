<?php

namespace App\Http\Controllers\Blog\Back;

use Crumbs;
use Analytics;

class AnalyticsController extends PainelController
{

    /**
     * Construct
     */
    public function __construct()
    {
        // Middlewares
        $this->middleware('sentinel.access:painel.analytics.read', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get google analytics data for last 7 days
        $visitorsData = Analytics::getVisitorsAndPageViews(7);
        $pagesData =    Analytics::getMostVisitedPages(365, 10);
        $keywordData =  Analytics::getTopKeywords(365, 10);
        $referrerData = Analytics::getTopReferrers(365, 10);
        $browserData =  Analytics::getTopBrowsers(365, 10);
        // Set breadcrumbs
        Crumbs::addCurrent('Acessos');
        // Return view index
        return view('blog.back.analytics.index', compact('visitorsData', 'pagesData', 'keywordData', 'referrerData', 'browserData'));
    }

}
