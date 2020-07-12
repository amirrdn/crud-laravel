<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Clasess\BookClass;
use App\Http\Resources\Books as Booksres;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->books                = new BookClass;
        $this->bases                = new BaseController;
    }
    public function index()
    {
        return view('books.index');
    }
    public function GetBooks(Request $request)
    {
        $books                      = $this->books->GetAllBooks();
        //return response()->json($books);
        $data = \DataTables::of($books);
        $data->addIndexColumn();
        $data->addColumn('checkbox', function($books) {
            return '<input type="checkbox" name="id[]" value="'.$books->id.'">' ;
        })
        ->addColumn('action', function ($books) {
            $action                    = '<button class="btn btn-xs btn-primary" value="'.$books->id.'" id="editBooks"><i class="glyphicon glyphicon-trash"></i> Edit</button>
                                            <button class="btn btn-xs btn-danger" value="'.$books->id.'" id="delete"><i class="glyphicon glyphicon-trash">
                                            </i> Delete</button>';
            return $action;
        });
        $data->rawColumns(['action', 'checkbox']);
        return $data->toJson();
    }
    public function create()
    {
        $code                       = $this->books->CodeBooks();
        $book_publication           = '2000';
        $book_author                = '';
        $stock                      = '1';
        return view('books.form', compact('code', 'book_publication', 'book_author', 'stock'))->render();
    }
    public function store(Request $request)
    {
        $validatedData = \Validator::make(request()->all(), [
            'code_book'             => 'required',
            'book_title'            => 'required',
            'book_publication'      => 'required',
            'stock'                 => 'required'
        ]);
        
        if ($validatedData->fails()) {
            return response()->json([
                'fail' => true,
                'errors' => $validatedData->errors()
            ]);
        }else{
            $books                  = $this->books->store($request);
            return response()->json(['success' => 'success'], 200);
        }
    }
    public function edit($id)
    {
        $books                      = $this->books->BooksByID($id);
        $code                       = $books->code_book;
        $book_publication           = $books->book_publication;
        $book_author                = $books->book_author;
        $stock                      = $books->stock;

        return view('books.form', compact('books', 'code', 'book_publication', 'book_author', 'stock'))->render();
    }
    public function update(Request $request, $id)
    {
        $validatedData = \Validator::make(request()->all(), [
            'code_book'             => 'required',
            'book_title'            => 'required',
            'book_publication'      => 'required',
            'stock'                 => 'required'
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'fail' => true,
                'errors' => $validatedData->errors()
            ]);
        }else{
            $books                  = $this->books->store($request);
            return response()->json(['success' => 'success'], 200);
        }
    }
    public function destroy($id)
    {
        $books                      = $this->books->DeleteBooks($id);
        return response()->json(['success' => 'success'], 200);
    }
    public function destroyarray(Request $request)
    {
        $books                      = $this->books->DeleteArray($request);
        return response()->json(['success' => 'success'], 200);
    }
    public function booksAPi()
    {
        $books                      = $this->books->GetAllBooks();   
        return $this->bases->sendResponse(Booksres::collection($books), 'Books retrieved successfully.');
    }
    public function booksAPiBYid($id)
    {
        $books                      = $this->books->BooksByID($id);
        return $this->bases->sendResponse($books, 'Books retrieved successfully.');
    }
    public function booksAPistore(Request $request)
    {
        $validatedData = \Validator::make(request()->all(), [
            'code_book'             => 'required',
            'book_title'            => 'required',
            'book_publication'      => 'required',
            'stock'                 => 'required'
        ]);
        if($validatedData->fails()){
            return $this->bases->sendError('Validation Error.', $validatedData->errors());       
        }
        $books                  = $this->books->storeApi($request);
        return $this->bases->sendResponse(new Booksres($books), 'Books created successfully.');
    }
    public function EditbooksAPiBYid(Request $request,$id)
    {
        $validatedData = \Validator::make(request()->all(), [
            'code_book'             => 'required',
            'book_title'            => 'required',
            'book_publication'      => 'required',
            'stock'                 => 'required'
        ]);
        if($validatedData->fails()){
            return $this->bases->sendError('Validation Error.', $validatedData->errors());       
        }
        $books                  = $this->books->store($request);
        return $this->bases->sendResponse(new Booksres($books), 'Books created successfully.');
    }
    public function destroyBookApi($id)
    {
        $books                      = $this->books->DeleteBooks($id);
        return $this->bases->sendResponse([], 'Books deleted successfully.');
    }
}
