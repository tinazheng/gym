<?php namespace App\Http\Controllers;

use App\Person;
use App\Transaction;
use App\User;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class UserController extends Controller {
	//TODO move this to .env
	const CLIENT_ID = 2065;
	const CLIENT_SECRET = 'rygvBxweYnSmsSxfuWJVAsNvkmZeVmkz';

	protected $auth;

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
		$this->middleware('auth', ['except' => ['create', 'store']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * @Get("/register")
	 */
	public function create()
	{
		//technically login should be not be the same as registering i think..oh well
		return response()->redirectGuest('https://api.venmo.com/v1/oauth/authorize?client_id=' . static::CLIENT_ID . '&scope=make_payments%20access_profile%20access_friends&response_type=code');
	}

	/**
	 * @Get("/oauth")
	 */
	public function store(Request $request)
	{
		if($request->has('code'))
		{
			$code = $request->input('code');
			$curl = curl_init('https://api.venmo.com/v1/oauth/access_token');
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
					'client_id' => static::CLIENT_ID,
					'client_secret' => static::CLIENT_SECRET,
					'code' => $code
				)
			));
			$result = curl_exec($curl);
			curl_close($curl);
			if($result !== false)
			{
				$result = json_decode($result);
				if(property_exists($result, 'access_token') && property_exists($result, 'refresh_token'))
				{
					$person = Person::firstOrCreate(array('venmo_id' => $result->user->id));
					$person->name = $result->user->display_name;
					$person->profile_picture_url = $result->user->profile_picture_url;
					$person->save();
					$user = User::firstOrCreate(array('person_id' => $person->id));
					$user->access_token = $result->access_token;
					$user->refresh_token = $result->refresh_token;
					$user->save();
					$this->auth->login($user);
					return response()->redirectToIntended();
				}
			}
		}
		return new Response('Could not log in!', 401);
	}

	/**
	 * @Get("/user")
	 */
	public function show()
	{
		$user = $this->auth->user();
		$curl = curl_init("https://api.venmo.com/v1/users/{$user->person->venmo_id}?access_token={$user->access_token}");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);
		if($result !== false) return (new Response($result, 200))->header('Content-Type', 'application/json');
		return new Response('Error!', 500);
	}

	/**
	 * @Get("/user/friends")
	 */
	public function friends()
	{
		$user = $this->auth->user();
		$curl = curl_init("https://api.venmo.com/v1/users/{$user->person->venmo_id}/friends?access_token={$user->access_token}");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);
		if($result !== false) return (new Response($result, 200))->header('Content-Type', 'application/json');
		return new Response('Error!', 500);
	}

	/**
	 * @Put("/user")
	 */
	public function update(Request $request)
	{
		$user = $this->auth->user();
		if($request->has('goal')) $user->goal = $request->input('goal');
		$user->save();

		$amount = $request->input('amount', 0);
		if($request->has('friends'))
		{
			$venmoIds = $request->input('friends');
			$people = new Collection;
			foreach($venmoIds as $venmoId)
			{
				$person = Person::whereVenmoId($venmoId)->first();
				if(is_null($person))
				{
					$curl = curl_init("https://api.venmo.com/v1/users/$venmoId?access_token={$user->access_token}");
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					$result = curl_exec($curl);
					if($result !== false)
					{
						$result = json_decode($result);
						$person = new Person;
						$person->venmo_id = $venmoId;
						$person->name = $result->data->display_name;
						$person->profile_picture_url = $result->data->profile_picture_url;
						$person->save();
						$people->push($person);
					}else
					{
						dd("Could not retrieve data about friend with id $venmoId");
					}
				}
			}
		}else
		{
			$people = $user->friends;
		}
		if($people->count() > 0)
		{
			$personIds = $people->map(function($person){ return $person->id; });
			$user->friends()->sync(array_combine(
				$personIds->all(),
				array_fill(0, $personIds->count(), array('amount' => $amount))
			));
		}
		return new Response(null, 204);
	}

	/**
	 * @Post("/user/pay")
	 */
	public function pay()
	{
		$user = $this->auth->user();
		foreach($user->friends as $friend)
		{
			//the sandbox "payment" is always identical so there is no point using it
			/*
			//using sandbox since I don't want to donate $100 to mike
			$curl = curl_init('https://sandbox-api.venmo.com/v1/payments');
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
					'access_token' => $user->access_token,
					'note' => 'for not meeting gym goal',
//					'amount' => $friend->pivot->amount,
					'amount' => 0.10,
					'user_id' => '145434160922624933'
				)
			));
			$result = curl_exec($curl);
			curl_close($curl);
			if($result !== false)
			{
				$result = json_decode($result); dd($result->data);
				if(!property_exists($result, 'error'))
				{
					continue;
				}
			}
			 */
			$transaction = new Transaction;
			$transaction->user_id = $user->person_id;
			$transaction->person_id = $friend->id;
			$transaction->amount = $friend->pivot->amount;
			$transaction->save();
		}

		return new Response(null, 204);
	}

	/**
	 * @Get("/user/transactions")
	 */
	public function transactions()
	{
		$user = $this->auth->user();
		return response()->json($user->transactions->map(function($transaction){ return "{$transaction->user->person->name} --\${$transaction->amount}--> {$transaction->person->name} (hi Mike)"; }));
	}

	/**
	 * @Get("/user/progress")
	 */
	public function getProgress()
	{
		$user = $this->auth->user();
		return response()->json(array('progress' => $user->progress));
	}

	/**
	 * @Post("/user/checkin")
	 */
	public function checkIn()
	{
		$user = $this->auth->user();
		//"verify user location is near a gym"
		//we are near a gym
		$user->progress++;
		$user->save();
		return response()->json($user);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
