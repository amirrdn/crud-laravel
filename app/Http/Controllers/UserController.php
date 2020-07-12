<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Clasess\UserClass;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->users              = new UserClass;
    }
    public function index()
    {
        return view('users.index');
    }
    public function ajaxUser(Request $request)
    {
        $user                      = $this->users->GetUser();
        //return response()->json($user);
        $data = \DataTables::of($user);
        $data->addIndexColumn();
        $data->addColumn('checkbox', function($user) {
            return '<input type="checkbox" name="id[]" value="'.$user->id.'">' ;
        })
        ->addColumn('created_at', function($user){
            return date('Y-m-d H:i:s', strtotime($user->created_at));
        })
        ->addColumn('action', function ($user) {
            $action                    = '<button class="btn btn-xs btn-primary" value="'.$user->id.'" id="editUsers"><i class="glyphicon glyphicon-trash"></i> Edit</button>
                                            <button class="btn btn-xs btn-danger" value="'.$user->id.'" id="delete"><i class="glyphicon glyphicon-trash">
                                            </i> Delete</button>';
            return $action;
        });
        $data->rawColumns(['action', 'checkbox', 'created_at']);
        return $data->toJson();
    }
    public function create()
    {
        $names                          = '';
        $email                          = '';
        $password                       = '';

        return view('users.form', compact('names', 'email', 'password'))->render();
    }
    public function store(Request $request)
    {
        $users                          = $this->users->storesUsers($request);

        return response()->json($users);
    }
    public function edit($id)
    {
        $users                          = $this->users->getUsersID($id);

        $names                          = $users->name;
        $email                          = $users->email;
        $password                       = '';

        return view('users.form', compact('names', 'email', 'password', 'users'))->render();
    }
    public function update(Request $request)
    {
        $users                          = $this->users->storesUsers($request);

        return response()->json($users);
    }
    public function destroy($id)
    {
        $users                      = $this->users->DeleteUsers($id);
        return response()->json(['success' => 'success'], 200);
    }
    public function destroyarray(Request $request)
    {
        $users                      = $this->users->DeleteArray($request);
        return response()->json(['success' => 'success'], 200);
    }
}
