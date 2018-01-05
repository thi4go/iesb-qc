<?php

namespace App\Http\Controllers\Blog\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Post;
use willvincent\Rateable\Rating;
use Carbon\Carbon;

class RatingsController extends BaseController
{

  /**
   * Vars
   */
  protected $posts;

  /**
   * Construct
   */
  public function __construct(Post $posts)
  {
    $this->posts = $posts;
  }

  /**
   * Get Rate
   */
  public function view(Request $request)
  {
    if($request->ajax()):
      if ($post = $this->posts->find($request->get('id'))):
        // Get new rating attributes
        $data = [
          'avr' => (int)$post->averageRating(),
          'rtp' => $post->ratingPercent(5),
          'total' => $post->ratings()->count()
        ];
        // Response
        $response['success'] = true;
        $response['message'] = 'Notas retornadas com sucesso!';
        $response['data'] = $data;
        $code = 200;
      else:
        // Response
        $response['success'] = false;
        $response['message'] = 'Ocorreu um erro ao retornar total de notas.';
        $code = 400;
      endif;
    endif;
    return response()->json($response, $code);
  }

  /**
   * Rate
   */
  public function store(Request $request)
  {
    if($request->ajax()):
      if ($post = $this->posts->find($request->get('id'))):
        // Get client ip
        $clientIp = $request->getClientIp();
        // Find exist vote by ip
        $lastVote = $post->ratings()->where('visitor', $clientIp)->whereRaw('DATE(created_at) = CURDATE()')->first();
        // If dont exist lastVote
        if (!$lastVote):
          // Create new vote
          $rating = new Rating;
          $rating->rating = $request->value;
          $rating->visitor = $clientIp;
          $rating->user_id = null;
          $post->ratings()->save($rating);
          // Get new rating attributes
          $data['avr'] = (int)$post->averageRating();
          $data['rtp'] = $post->ratingPercent(5);
          $data['total'] = $post->ratings()->count();
          // Response
          $response['success'] = true;
          $response['message'] = 'Avaliado com sucesso!';
          $response['data'] = $data;
          $code = 200;
        else:
          // Response
          $response['success'] = false;
          $response['message'] = 'Você já avaliou este post hoje.';
          $code = 400;
        endif;
      else:
        // Response
        $response['success'] = false;
        $response['message'] = 'Erro ao adicionar avaliação.';
        $code = 400;
      endif;
    endif;
    return response()->json($response, $code);
  }

}
