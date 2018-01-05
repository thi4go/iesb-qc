<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

//    protected $guzzle_http_dns = 'https://iesbapi.examedaoab.com/api/';
    protected $guzzle_http_dns = 'https://iesbapi.examedaoab.com/api/';
//     protected $guzzle_http_dns = 'https://iesbapi.examedaoab.com/api/';
    // protected $guzzle_http_dns = 'https://iesbapi.examedaoab.com/api/';

    protected $pagarme_api_dns = 'https://api.pagar.me/1/';
}
