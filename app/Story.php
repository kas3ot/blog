<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model {

	protected $fillable = ['name', 'description', 'photo', 'user_id'];

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function comment(){
		return $this->hasMany('App\Comment');
	}

}
