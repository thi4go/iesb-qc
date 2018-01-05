<?php

namespace App\Http\Controllers\Front;

use App\Models\Campaign;
use App\Models\Testimony;
use Meta;
use OpenGraph;
use Request;

class CampaignsController extends BaseController
{

    /**
     * @var [type]
     */
    protected $campaign, $testimony;

    /**
     * Construct
     */
    public function __construct(Campaign $campaign, Testimony $testimony)
    {
        parent::__construct();
        // Repositories
        $this->campaign = $campaign;
        $this->testimony = $testimony;
    }

    /**
     * Display campaign
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function show($slug)
    {
        $idRd = "6e952b9da4b283af3009839102846546";
        // Find campaign
        $data = $this->campaign->where('slug', $slug)->first();

        if ($data == null):
          $controller = app()->make(PagesController::class);
          return $controller->callAction('show', ['slug' => $slug]);
        endif;

        // Check inscription is active
        if($this->inscription->value == 0 && $data->group_id != 2):
          return redirect()->route('pages.wait');
        endif;

        // Get related group videos
        $videos = $this->campaign->select('id', 'slug', 'title', 'video_id')->where('id', '<>', $data->id)->where('group_id', '=', $data->group_id)->get(3);

        // Get testimonies
        $testimonies = $this->testimony->select('id', 'name', 'testimony', 'function', 'url')->orderByRaw('RAND()')->get(2);

        // Define footer
        switch ($data->footer_id):
          case 1:
            $footer = 'front.partials.section_comments';
            break;
          case 2:
            $footer = 'front.partials.section_buy';
            break;
          case 3:
            $footer = 'front.partials.section_ebooks';
            break;
          case 4:
            $footer = 'front.partials.section_timeline';
            break;
          default:
            $footer = 'front.partials.section_timeline';
            break;
        endswitch;

        // Set seo tags
        Meta::setTitle($data->seo->meta_title);
        Meta::setDescription($data->seo->meta_description);
        Meta::setKeywords($data->seo->meta_keywords);
        OpenGraph::setTitle($data->seo->meta_title);
        OpenGraph::setDescription($data->seo->meta_description);
        OpenGraph::addImage(asset('/assets/images/facebook.jpg'));

        //dd($data->url_success);;

        // Return view show
        return view('front.campaigns.show', compact('data', 'videos', 'testimonies', 'footer', 'idRd'));
    }
    public function redirect_ebook()
    {
      // dd($url);
      return view('front.pages.engagement-ebook');
    }

}
