<?php

namespace App\Clasess;

use Illuminate\Http\Request;
use App\User;
use App\Models\Book;
use App\Models\Transaction;

use Auth;
use DB;

class BookClass {
    public function store(Request $request)
    {
        if(\Route::currentRouteName() == 'storebooks'){
            $book                   = new Book;
        }else{
            $book                   = Book::find($request->id);
        }
        $book->code_book        = $request->code_book;
        $book->book_title       = $request->book_title;
        $book->book_publication = $request->book_publication;
        $book->book_author      = $request->book_author;
        $book->stock            = $request->stock;
        $book->user_id          = Auth::user()->id;

        $book->save();

        return $book;
    }
    public function storeApi(Request $request)
    {
        $book                   = new Book;
        
        $book->code_book        = $request->code_book;
        $book->book_title       = $request->book_title;
        $book->book_publication = $request->book_publication;
        $book->book_author      = $request->book_author;
        $book->stock            = $request->stock;
        $book->user_id          = Auth::user()->id;

        $book->save();

        return $book;
    }
    public static function CodeBooks(){
        $now                                    = \Carbon\Carbon::now();
        $prefix					                = "BK";
        $primary                                = 'code_book';
        $bulanRomawi                            = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $noUrutAkhir                            = Book::select(DB::raw('MAX(LEFT('.$primary.',6)) as kd_max'))->get();
        $no                                     = 1;
        $prx                                    = $prefix;
        if($noUrutAkhir->count() > 0){
            foreach($noUrutAkhir as $k){
                $tmp                            = ((int)intval(preg_replace('/[^0-9]+/', '', $k->kd_max), 10))+1;
                $kd                             = $prx.sprintf("%04s", $tmp);
            }
        }else{
            $kd                                 = $prx."0001";
        }

        if($noUrutAkhir){
            $refs                               = $kd. '/0/'.$bulanRomawi[date('n', strtotime($now))].'/'.date('Y', strtotime($now));
        }else{
           $refs                                = $prefix.''.sprintf("%04s", $no). '/0/'.$bulanRomawi[date('n', strtotime($now))].'/'.date('Y', strtotime($now));
        }
        return $refs;
    }
    public function GetAllBooks()
    {
        $books                                  = Book::with('GetUser')->get();

        return $books;
    }
    public function BooksByID($id)
    {
        $books                                  = Book::find($id);
        return $books;
    }
    public function DeleteBooks($id)
    {
        $books                                  = Book::FindOrFail($id);
        $books->delete();
        return $books;
    }
    public function DeleteArray(Request $request)
    {
        $books                                  = Book::whereIn('id',explode(",",$request->get('id')))->delete();

        return $books;
    }
    public function storeTransaction(Request $request)
    {
        if(\Route::currentRouteName() == 'inserttransactionsection'){
            $trans                              = new Transaction;
            $trans->user_id                     = Auth::user()->id;
        }else{
            $trans                              = Transaction::find($request->id);
            $trans->user_id                     = $trans->user_id;
        }

        $trans->book_id                         = $request->book_id;
        $trans->decision                        = $trans->decision;
        $trans->borrowed_date                   = date('Y-m-d', strtotime($request->borrowed_date));
        $trans->date_of_return                  = date('Y-m-d', strtotime($request->date_of_return));

        $trans->save();

        return $trans;
    }
    public function getTransaction(Request $request)
    {
        if(Auth::user()->is_admin == 1){
            $trans                                  = Transaction::join('books', 'transaction.book_id', 'books.id')
                                                    ->join('users', 'transaction.user_id', 'users.id')
                                                    ->select('transaction.decision', 'transaction.decision', 'borrowed_date', 'date_of_return',
                                                        'transaction.id','books.book_title', 'books.code_book', 'book_publication', 'book_author', 'users.name'
                                                    )
                                                    ->get();
        }else{
            $trans                                  = Transaction::join('books', 'transaction.book_id', 'books.id')
                                                    ->join('users', 'transaction.user_id', 'users.id')
                                                    ->where('users.id', Auth::user()->id)
                                                    ->select('transaction.decision', 'transaction.decision', 'borrowed_date', 'date_of_return',
                                                        'transaction.id','books.book_title', 'books.code_book', 'book_publication', 'book_author', 'users.name'
                                                    )
                                                    ->get();
        }

        return $trans;
    }
    public function UpdateStatusTrans(Request $request)
    {
        $status                 = Transaction::where('id', $request->id)->update([
            'decision' => $request->value
        ]);
        $booksid                = Transaction::find($request->id);
        $stokbook               = Book::find($booksid->book_id);
        if($request->value == 1){
            $books                  = Book::where('id', $booksid->book_id)->update([
                'stock' => $stokbook->stock - 1
            ]);
        }elseif($request->value == 2){
            $books                  = Book::where('id', $booksid->book_id)->update([
                'stock' => $stokbook->stock + 1
            ]);
        }
    }
    public function getTransID($id)
    {
        $trans                                  = Transaction::join('books', 'transaction.book_id', 'books.id')
                                                ->select('transaction.decision', 'transaction.decision', 'borrowed_date', 'date_of_return',
                                                'transaction.id','books.book_title', 'books.code_book', 'book_publication', 'book_author')
                                                ->find($id);

        return $trans;
    }
    public function DeleteTrans($id)
    {
        $trans                                  = Transaction::FindOrFail($id);
        $trans->delete();
        return $books;
    }
    public function DeleteArrayTrans(Request $request)
    {
        $trans                                  = Transaction::whereIn('id',explode(",",$request->get('id')))->delete();

        return $trans;
    }
}