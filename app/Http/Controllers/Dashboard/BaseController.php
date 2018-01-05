<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class BaseController extends Controller
{

  /**
   * @var [type]
   */
  protected $inscription;

  /**
   * Construct
   */
  public function __construct()
  {
    $inscription = Setting::select('value')->where('key', '=', 'is_inscriptions')->first();
    $this->inscription = $inscription;
    view()->share(compact('inscription'));
  }

}
