<?php namespace App;

use Illuminate\Auth\UserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\User as UserContract;

class User extends Model implements UserContract{

	use UserTrait;

	protected $table = 'users';

	protected $primaryKey = 'person_id';

	protected $fillable = array('person_id');

	public $timestamps = false;

	public function person()
	{
		return $this->belongsTo('App\Person');
	}
}
