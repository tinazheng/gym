<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model{
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function person()
	{
		return $this->belongsTo('App\Person');
	}
}
