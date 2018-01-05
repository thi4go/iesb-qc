<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleClient;
use App\Http\Requests;
use PagarMe_Transaction;
use PagarMe_Subscription;
use PagarMe_Plan;
use PagarMe;

class PaymentController extends Controller
{

	protected $client, $userController;

    public function __construct()
    {
        $this->client = new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
        $this->userController = new UserController();
    }

	public function plans()

	{	$user = session('user');
		$this->userController->newSale($user);
		return view('payment.index');
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

		if(isset($request->pagarme))
			$payment_method = $request->pagarme['payment_method'];
		else
			$payment_method = $request->payment_method;

		$plan = $request->plan;

		try {

			if($plan == "premium" && $payment_method == "credit_card"){
				$subscription = $this->createSubscription($request->pagarme);

				$response	  = $this->createCreditSubscriptionRequest($subscription);
			}
			elseif($plan == "premium" && $payment_method == "boleto"){
				$transaction = PagarMe_Transaction::findById("$request->token");
				$transaction->capture(4000);

				$response = $this->createBoletoTransaction($transaction);
			}
			elseif($plan == "consultoria" && $payment_method == "credit_card") {
				$transaction = PagarMe_Transaction::findById("$request->token");
				$transaction->capture(40000);

				$response = $this->createCreditTransaction($transaction);
			}
			elseif($plan == "consultoria" && $payment_method == "boleto") {
				$transaction = PagarMe_Transaction::findById("$request->token");
				$transaction->capture(40000);

				$response = $this->createBoletoTransaction($transaction);
			}

		} catch(\Exception $e) {
			// dd($e->getMessage());
			return response()->view('errors.404', [$e->getMessage()], 404);
		}

		if($response->success){
			$this->userController->newSale($user);
			return redirect()->route('dashboard.profile.history');
		}
		else
			return response()->view('errors.404', [], 404);
	}

	public function createBoletoTransaction($transaction)
	{
		try {
			$response = $this->client->request('POST', 'transaction/new?token='.session('token'), [
				'form_params' => [
					'idtransaction' 		 => $transaction->id,
					'user_id'		 		 => session('user')->id,
					'payment_method' 		 => $transaction->payment_method,
					'amount'		 		 => $transaction->amount,
					'status'		 		 => $transaction->status,
					'boleto_url'	 		 => $transaction->boleto_url,
					'boleto_barcode' 		 => $transaction->boleto_barcode,
					'boleto_expiration_date' => $transaction->boleto_expiration_date,
					'date_created'	 		 => $transaction->date_created,
					'date_updated'	 		 => $transaction->date_updated,
					'postback_url'	 		 => $transaction->postback_url
				]
			]);
		} catch (\GuzzleHttp\Exception\ClientException $e) {
			return response()->view('errors.404', [], 404);
		}

		$response = json_decode($response->getBody()->getContents());

		return $response;
	}

	public function createCreditTransaction($transaction)
	{
		$response = $this->client->request('POST', 'transaction/new?token='.session('token'), [
			'form_params' => [
				'idtransaction' 		 => $transaction->id,
				'user_id'		 		 => session('user')->id,
				'payment_method' 		 => $transaction->payment_method,
				'amount'		 		 => $transaction->amount,
				'status'		 		 => $transaction->status,
				'idcard'				 => $transaction->card->id,
				'card_brand'			 => $transaction->card_brand,
				'card_last_digits'		 => $transaction->card_last_digits,
				'fingerprint'			 => $transaction->card->fingerprint,
				'date_created'	 		 => $transaction->date_created,
				'date_updated'	 		 => $transaction->date_updated,
				'postback_url'	 		 => $transaction->postback_url
			]
		]);

		$response = json_decode($response->getBody()->getContents());

		return $response;
	}

	public function createCreditSubscriptionRequest($subscription)
	{
		$response = $this->client->request('POST', 'transaction/new?token='.session('token'), [
			'form_params' => [
				'idsubscription'		 => $subscription->id,
				'idtransaction' 		 => $subscription->current_transaction->id,
				'idcard'				 => $subscription->card->id,
				'idplan'				 => 45735,
				'user_id'		 		 => session('user')->id,
				'current_period_start'	 => $subscription->current_period_start,
				'current_period_end'	 => $subscription->current_period_end,
				'payment_method' 		 => $subscription->payment_method,
				'card_brand'			 => $subscription->card_brand,
				'card_last_digits'		 => $subscription->card->last_digits,
				'fingerprint'			 => $subscription->card->fingerprint,
				'amount'		 		 => $subscription->current_transaction->amount,
				'status'		 		 => $subscription->current_transaction->status,
				'date_created'	 		 => $subscription->current_transaction->date_created,
				'date_updated'	 		 => $subscription->current_transaction->date_updated,
				'postback_url'	 		 => $subscription->postback_url
			]
		]);

		$response = json_decode($response->getBody()->getContents());

		return $response;
	}

	public function createSubscription($data)
	{
		$subscription = new PagarMe_Subscription(array(
			'payment_method' => $data['payment_method'],
			'plan'		     => PagarMe_Plan::findById('138563'),
			'card_hash'		 => $data['card_hash'],
			'postback_url'	 => 'https://iesbapi.examedaoab.com/api/transaction/postback-status-signature',
			'customer'		 => array(
				'email' 		=> session('user')->email
			)
		));

		$subscription->create();

		return $subscription;
	}




}
