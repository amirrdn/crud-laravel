<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clasess\BookClass;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->books              = new BookClass;
    }
    public function index()
    {
        return view('transaction.index');
    }
    public function transactions()
    {
        $books                      = $this->books->GetAllBooks();
        $book_publication           = '';
        $book_author                = '';
        $stock                      = '';
        $borrowed_date              = '';
        $date_of_return             = '';
        $trans                      = array('');
        
        return view('transaction.form', compact('books', 'book_publication', 'book_author', 'stock', 'borrowed_date', 'date_of_return', 'trans'));
    }
    public function ajaxBoox($id)
    {
        $books                      = $this->books->BooksByID($id);

        return response()->json($books);
    }
    public function ajaxTrasn(Request $request)
    {
        $trans                      = $this->books->getTransaction($request);
        //return $trans;
        $data = \DataTables::of($trans);
        $data->addIndexColumn();
        $data->addColumn('checkbox', function($trans) {
            return '<input type="checkbox" name="id[]" value="'.$trans->id.'">' ;
        })
        ->addColumn('decisions', function($trans){
            if($trans->decision === '1'){
                $status = 'Approved';
            }elseif($trans->decision === '2'){
                $status = 'Reject';
            }elseif(empty($trans->decision)){
                $status = 'Decision';
            }
            if(\Auth::user()->is_admin == 1){
                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-xs">'.$status.'</button>
                        <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                        <li><a href="javascript:void(0)" id="'.$trans->id.'" class="dropdown-item status" value="1">Approved</a></li>
                        <li><a href="javascript:void(0)" id="'.$trans->id.'" class="dropdown-item status" value="2">Reject</a></li>
                        </ul>
                    </div>
                ';
            }elseif(\Auth::user()->is_admin !== 1){
                return '<button class="btn btn-sm btn-primary">'.$status.'</button>';
                return '<button type="button" class="btn btn-sm btn-primary>'.$status.'</button>';
            }
        })
        ->addColumn('action', function ($trans) {
            $action                    = '<button class="btn btn-xs btn-primary" value="'.$trans->id.'" id="editTrans"><i class="glyphicon glyphicon-trash"></i> Edit</button>
                                            <button class="btn btn-xs btn-danger" value="'.$trans->id.'" id="delete"><i class="glyphicon glyphicon-trash">
                                            </i> Delete</button>';
            return $action;
        });
        $data->rawColumns(['action', 'checkbox', 'decisions']);
        return $data->toJson();
    }
    public function store(Request $request)
    {
        $books                      = $this->books->storeTransaction($request);
        return response()->json($books);
    }
    public function updateStatus(Request $request)
    {
        $trans                      = $this->books->UpdateStatusTrans($request);

        return response()->json('successes');
    }
    public function edit($id)
    {
        $trans                      = $this->books->getTransID($id);
        $books                      = $this->books->GetAllBooks();
        $book_publication           = $trans->book_publication;
        $book_author                = $trans->book_author;
        $stock                      = $trans->stock;
        $borrowed_date              = $trans->borrowed_date;
        $date_of_return             = $trans->date_of_return;
        
        return view('transaction.form', compact('trans', 'books', 'book_publication', 'book_author', 'stock', 'borrowed_date', 'date_of_return'))->render();
    }
    public function update(Request $request)
    {
        $trans                      = $this->books->storeTransaction($request);

        return $trans;
    }
    public function destroy($id)
    {
        $trans                      = $this->books->DeleteTrans($id);
        return response()->json(['success' => 'success'], 200);
    }
    public function destroyarray(Request $request)
    {
        $trans                      = $this->books->DeleteArrayTrans($request);
        return response()->json(['success' => 'success'], 200);
    }
}
