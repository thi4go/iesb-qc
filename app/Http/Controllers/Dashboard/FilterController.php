<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use GuzzleHttp\Client as GuzzleClient;
// use JavaScript;

class FilterController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
    }

    public function index(Request $request)
    {
        $user = session('user');

        $user = json_encode($user);

        return view('dashboard.filter.index', compact('user'));
    }

}
