<?php

namespace App\Http\Controllers\Sales;

use App\Library\RDStationAPI;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use GuzzleHttp\Client as GuzzleClient;

class UserController extends Controller
{

    // const RD_PRIVATE_TOKEN = '0ee531b4476df1a70e4f2f92caa099d5';
    // const RD_TOKEN = '6e952b9da4b283af3009839102846546';

    public function __construct()
    {
        $this->client = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
    }

    public function updateSession()
    {
        $user  = session('user');
        $token = session('token');

        try {
            $response = $this->client->request('GET', 'user/update-session/'.$user->id.'?token='.$token);
        } catch(\Exception $e) {
            return False;
        }

        $userUpdated = json_decode($response->getBody()->getContents());

        session()->put('user', $userUpdated->user);

        return True;
    }

    public function sendToRdStation($user,$tags = '')
    {
        // $rdStation = new RDStationAPI(self::RD_PRIVATE_TOKEN, self::RD_TOKEN);

        $rdStation = new RDStationAPI('0ee531b4476df1a70e4f2f92caa099d5', '6e952b9da4b283af3009839102846546');

        $rdStation->sendNewLead(
            $user->email, [
                'nome' => $user->name,
                'tags' => $tags,
                'identificador' => 'Engenharia-Civil'
            ]
        );
    }

}

?>
