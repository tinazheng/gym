<?php namespace App\Http\Controllers;

use App\Person;
use App\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller {
	//TODO move this to .env
	const CLIENT_ID = 2065;
	const CLIENT_SECRET = 'rygvBxweYnSmsSxfuWJVAsNvkmZeVmkz';

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
		return response()->redirectGuest('https://api.venmo.com/v1/oauth/authorize?client_id=' . static::CLIENT_ID . '&scope=make_payments%20access_friends&response_type=code');
	}

	/**
	 * @Get("/oauth")
	 */
	public function store(Request $request)
	{
		if($request->has('code'))
		{
			$code = $request->get('code');
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
					return response()->redirectToIntended();
				}
			}
		}
		return new Response('Could not log in!', 401);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
