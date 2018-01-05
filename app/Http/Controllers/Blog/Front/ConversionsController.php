<?php

namespace App\Http\Controllers\Blog\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use App\Validators\ConversionValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Library\RDStationAPI;
use Carbon\Carbon;

class ConversionsController extends BaseController
{

    /**
     * Vars
     */
    protected $validator;

    /**
     * Construct
     */
    public function __construct(ConversionValidator $validator)
    {
        // Validator
        $this->validator = $validator;
    }

    /**
     * Display quiz store
     */
    public function store(Request $request)
    {
      if($request->ajax()):

        $data = $request->all();

        // Save or fail
        try {
          // Validate $data
          $this->validator->with($data)->passesOrFail();

          // Send new lead to RD Station
          $rdStation = new RDStationAPI(env('RD_PRIVATE_TOKEN'), env('RD_TOKEN'));
          $rdStation->sendNewLead(
              $data['email'], [
              'nome' => $data['name'],
              'identificador' => 'blog-eng-civil'
            ]
          );

          // Url result
          $result = 'http://www.examedaoab.com';

          // Return success
          return Response::json(['success' => true, 'message' => 'O e-book foi encaminhado para o seu email.', 'redirect' => $result], 200);
        } catch(ValidatorException $e) {
          // Return errors
          return Response::json(['success' => false, 'errors' => $e->getMessageBag()], 400);
        }
      endif;
    }

}
