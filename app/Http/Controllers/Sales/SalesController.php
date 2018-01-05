<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleClient;
use App\Http\Requests;
use GuzzleHttp\Psr7;
use Validator;
use PagarMe_Transaction;
use PagarMe_Subscription;
use PagarMe_Plan;
use PagarMe;

class SalesController extends Controller
{
    protected $client, $userController;

    public function __construct()
    {
        $this->client         = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
        $this->userController = new UserController();

    }
    /**
     * Validador de dados
     **/
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'       => 'required|max:255',
            'email'      => 'required|email|max:255',
            'password'   => 'required|min:6|confirmed',
            // 'cpf'        => 'required|cpf',
        ]);
    }




    /**
     * Controller da pagina de vendas:
     *   Quando o usuário clica em "Eu Quero!"
     **/
    public function index()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $today = getdate();
        $wday = $today['wday'];
        $hours = $today['hours'];
        $minutes = $today['minutes'];
        $seconds = $today['seconds'];
        $utc = $today[0];

        return view('sales.promo',compact('wday', 'hours', 'minutes', 'seconds', 'utc'));
    }

    public function plans()
    {
        return view('sales.plans');
    }

    public function payment(Request $request)
    {
        $plan = $request->plano;

        if($plan == 'basico')
            $value = 40;
        else
            $value = 400;

        return view('payment.payment', compact('plan', 'value'));
    }

    //main payment method
    public function pay(Request $request)
    {
        Pagarme::setApiKey("ak_live_FfqKSf1dZZVHMde0ZIOvMQ0tZaYmCk");

        $transaction = PagarMe_Transaction::findById("$request->token");
        $transaction->capture(4000);

        try {
            if($transaction->payment_method == 'boleto'){
              $response = $this->createBoletoTransaction($transaction);
            }
            else {
              $response = $this->createCreditTransaction($transaction);

            }

        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->view('errors.404', [$e->getMessage()], 404);
        }

        if($transaction->payment_method == 'boleto')
            return redirect($transaction->boleto_url);
        else
            return redirect()->route('dashboard.profile');
    }

    //main payment method
    public function payBoleto(Request $request)
    {
        Pagarme::setApiKey("ak_live_FfqKSf1dZZVHMde0ZIOvMQ0tZaYmCk");

        $transaction = PagarMe_Transaction::findById("$request->token");
        $transaction->capture(25000);

        try {
            if($transaction->payment_method == 'boleto')
                $response = $this->createBoletoTransaction($transaction);
            else
                $response = $this->createCreditTransaction($transaction);

        } catch (\Exception $e) {
            // dd($e->getMessage());
            return response()->view('errors.404', [$e->getMessage()], 404);
        }

        if($transaction->payment_method == 'boleto')
            return redirect($transaction->boleto_url);
        else
            return redirect()->route('dashboard.profile');
    }

    public function createBoletoTransaction($transaction)
    {
      $data = [
          'idtransaction' 		     => $transaction->id,
          'user_id'		 		         => session('user')->id,
          'payment_method' 		     => $transaction->payment_method,
          'amount'		 		         => $transaction->amount,
          'status'		 		         => $transaction->status,
          'boleto_url'	 		       => $transaction->boleto_url,
          'boleto_barcode' 		     => $transaction->boleto_barcode,
          'boleto_expiration_date' => $transaction->boleto_expiration_date,
          'date_created'	 		     => $transaction->date_created,
          'date_updated'	 		     => $transaction->date_updated,
          'postback_url'	 		     => $transaction->postback_url
      ];
        $response = $this->client->request('POST', 'transaction/new?token='.session('token'), $data);

        $response = json_decode($response->getBody()->getContents());
        return $response;
    }

    public function createCreditTransaction($transaction)
    {
        $response = $this->client->request('POST', 'transaction/new?token='.session('token'), [
            'form_params' => [
                'idtransaction'          => $transaction->id,
                'idcard'                 => $transaction->card->id,
                'user_id'                => session('user')->id,
                'payment_method'         => $transaction->payment_method,
                'amount'                 => $transaction->amount,
                'status'                 => $transaction->status,
                'card_brand'             => $transaction->card_brand,
                'fingerprint'            => $transaction->card->fingerprint,
                'date_created'           => $transaction->date_created,
                'date_updated'           => $transaction->date_updated,
                'postback_url'           => $transaction->postback_url
            ]
        ]);

        $response = json_decode($response->getBody()->getContents());

        return $response;
    }

    // payment wizard
    public function  paymentWizard(){
        $this->userController->updateSession();
        $token = session('token');
        $user  = session('user');

        $userId = $user->id;
        $userName = $user->name;

        return view('dashboard.payment.index', compact('userId','userName', 'token'));
    }

    public function  paymentWizard10x(){
        $this->userController->updateSession();
        $token = session('token');
        $user  = session('user');

        $userId = $user->id;

        return view('dashboard.payment.index10x', compact('userId', 'token'));
    }

    public function  paymentWizardBol(){
        $this->userController->updateSession();
        $token = session('token');
        $user  = session('user');

        $userId = $user->id;

        return view('dashboard.payment.index4x', compact('userId', 'token'));
    }

    public function main(){
        return view('sales.sales');
    }
}
