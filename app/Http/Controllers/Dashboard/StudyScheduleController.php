<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Controllers\Dashboard\UserController;
use GuzzleHttp\Client as GuzzleClient;
use JavaScript;

class StudyScheduleController extends Controller
{
	const DEFAULT_URL   = 'https://controle-examedaoab.firebaseio.com/';
	const DEFAULT_TOKEN = 'QHFHyfnDbO7hU8sp26pTbRDiqCFLFCzsKsyE5eIJ';
	const DEFAULT_PATH  = 'users/';

	protected $client, $userController, $firebase;

	public function __construct(UserController $userController)
	{
		$this->client	= new GuzzleClient(['base_uri' => $this->guzzle_http_dns]);
		$this->firebase 	  = new \Firebase\FirebaseLib(self::DEFAULT_URL, self::DEFAULT_TOKEN);
		$this->userController = $userController;
	}

	public function index(Request $request)
	{
//		$schedule = $this->firebase->get(self::DEFAULT_PATH . $user->id . '/schedule');

        $user = session('user');

        $user = json_encode($user);


		return view('dashboard.studySchedule.index',compact('user'));
	}

	public function availability(Request $request)
	{
		return view('dashboard.studySchedule.availability');
	}

	public static function filterSubjectsByCycle($userId){
		$firebase = new \Firebase\FirebaseLib(self::DEFAULT_URL, self::DEFAULT_TOKEN);
		$schedule = $firebase->get(self::DEFAULT_PATH . $userId . '/schedule/');

		if($schedule === 'null')
			return;

		$cycles = \GuzzleHttp\json_decode($schedule,true);
		$size = count($cycles);

		$i = 0;
		$cycleUser = 0;

		foreach($cycles as $cycleDate=>$cycle){
			if($i === $size-1)
			$cycleUser = $cycle['cycle'];
			$i++;
		}

		$cycleUser = array_filter($cycleUser);

		return array_keys($cycleUser);
	}

	public function subject(Request $request)
	{
		$this->userController->updateSession();

		$token = session('token');
		$user  = session('user');

		try {
			$response = $this->client->request('GET', 'subject?token='.$token);
		} catch(\Exception $e) {
			session()->forget('user');
			session()->forget('token');
			return response()->view('front.errors.session-expired');
		}

		JavaScript::put([
			'userId' => $user->id,
			'token'	 => $token
		]);

		$subjects = json_decode($response->getBody()->getContents());

		$subjects = SubjectsController::orderSubjectsByRelevance($subjects);

		$userSubjects = [];

		foreach($user->subjects as $subject){
			$userSubjects[$subject->idsubject] = (double) number_format($subject->theta*100, 2);
		}

		return view('dashboard.studySchedule.subject', compact('subjects', 'userSubjects'));
	}

	public function cycle(Request $request)
	{
		$user = session('user');
		$token = session('token');
		$schedule = $this->firebase->get(self::DEFAULT_PATH . $user->id . '/schedule');

		JavaScript::put([
			'userId' 		 => $user->id,
			'token'	 		 => $token,
			'userEfficiency' => $user->efficiency
		]);

		if($schedule == "null")
			return redirect('/dashboard/controle');
		else
			return view('dashboard.studySchedule.cycle');
	}

	public function historic(Request $request)
	{
		return view('dashboard.studySchedule.historic');
	}
}
