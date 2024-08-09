<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Administrator\App\Models\Users;

class AuthController extends Controller
{
    //
    public function index()
    {
        return view("login");
    }

    public function Auth(Request $req)
    {
        $data = Users::where('username', $req->username)
            ->where('password', $req->password)
            ->first();
        if ($data != null) {
            session()->put('user_id', $data->id);
            session()->put('fullname', $data->fullname);
            session()->put('role_id', $data->role_id);
            session()->put('customers_id', $data->customers_id);
            return response()->json(["msg" => "success", "text" => "login successfully"]);
        } else {
            return response()->json(["msg" => "account not found"]);
        }
    }
}
