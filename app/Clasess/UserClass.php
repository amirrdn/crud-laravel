<?php

namespace App\Clasess;

use Illuminate\Http\Request;
use App\User;

use Auth;
use DB;

class UserClass {
    public function GetUser()
    {
        $user                       = User::all();

        return $user;
    }
    public function storesUsers(Request $request)
    {
        if(\Route::currentRouteName() == 'userstore'){
            $users                      = new User;
        }else{
            $users                      = User::find($request->id);
        }

        $users->name                = $request->name;
        $users->email               = $request->email;
        if(!empty($request->password)){
            $users->password            = bcrypt($request->password);
        }
        $users->save();

        return $users;
    }
    public function getUsersID($id)
    {
        $users                      = User::find($id);

        return $users;
    }
    public function DeleteUsers($id)
    {
        $users                      = User::FindOrFail($id);
        $users->delete();
        return $users;
    }
    public function DeleteArray(Request $request)
    {
        $users                      = User::whereIn('id',explode(",",$request->get('id')))->delete();

        return $users;
    }
}