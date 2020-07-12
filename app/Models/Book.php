<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table    = 'books';
    protected $fillable = ['id', 'code_book', 'book_title', 'book_publication', 'book_author', 'stock', 'created_at', 'updated_at'];

    public function GetUser()
	{
		return $this->belongsTo('App\User','user_id','id');
    }
}
