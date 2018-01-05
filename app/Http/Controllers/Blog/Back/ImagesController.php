<?php

namespace App\Http\Controllers\Blog\Back;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Response;
use Sentinel;
use Activity;

class ImagesController extends PainelController
{

    /**
     * Vars
     */
    protected $images;

    /**
     * Construct
     */
    public function __construct(Image $images)
    {
      $this->images = $images;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // Get all posts
      $data = $this->images->select('id', 'user_id')->orderBy('created_at', 'desc')->get();


      $images = [];

      foreach ($data as $key => $image):
        $images[$key]['id'] = $image->id;
        $images[$key]['image'] = $image->file->getUrl('cover');
        $images[$key]['thumbs'] = $image->file->getUrl('thumbs');
        $images[$key]['created_at'] = $image->created_at;
      endforeach;

      return $images;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data['user_id'] = Sentinel::check()->id;
      // Save or fail
      if ($image = $this->images->create($data)):
        $file = $request->file('image');
        $filename = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
        $image->addMedia($file)->usingFileName($filename)->toCollection('media_library');
        // Create log
        Activity::log([
          'contentId'   => $image->id,
          'contentType' => 'media_library',
          'action'      => 'create',
          'description' => 'enviou uma imagem.',
          'details'     => null
        ]);
        return Response::json(['success' => true]);
      else:
        return Response::json(['success' => false, 'data' => 'Erro ao enviar imagem.'], 401);
      endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // Find image by id
      if ($image = $this->images->findOrFail($id)):
        // Delete image
        $image->delete();
        // Create log
        Activity::log([
          'contentId'   => $image->id,
          'contentType' => 'media_library',
          'action'      => 'delete',
          'description' => 'excluiu uma imagem.',
          'details'     => null
        ]);
        return Response::json(['success' => true]);
      endif;
      return Response::json(['success' => false], 200);
    }

}
