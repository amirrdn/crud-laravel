<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table    = 'transaction';
    protected $fillable = ['id', 'user_id','book_id', 'decision', 'borrowed_date', 'date_of_return', 'created_at', 'updated_at'];

    public function GetUserTrans()
	{
		return $this->belongsTo('App\User','user_id','id');
    }
    public function BooksTrans()
	{
		return $this->hasMany('App\Models\Book','book_id','id');
    }
}
