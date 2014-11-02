<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model{
	protected $table = 'people';

	protected $fillable = array('venmo_id');

	public $timestamps = false;

	public function user()
	{
		return $this->hasOne('User');
	}
}
