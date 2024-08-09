<?php

namespace Modules\Administrator\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Administrator\App\Models\Users;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('administrator::users/index');
    }



    public function jsonUsers(Request $req)
    {
        $response = Users::jsonList($req);
        return response()->json($response);
    }

    public function jsonListMenuForUsers(Request $req)
    {

        $response = Users::jsonDetailListMenu($req);
        return response()->json($response);
    }


    public function jsonCreate(Request $req)
    {


        $resp = Users::jsonCreate($req);
        return response()->json(['msg' => $resp]);
    }

    public function jsonDetail(Request $req)
    {
        $response = Users::find($req->id);
        return response()->json($response);
    }

    public function jsonUpdate(Request $req)
    {
        DB::beginTransaction();
        try {
            $cust = Users::find($req->id);
            $cust->username = $req->username;
            $cust->fullname = $req->fullname;
            $cust->status_user = $req->status_user == null ? 0 : 1;
            $cust->updated_at = date('Y-m-d H:i:s');
            $cust->updated_by = 1;
            $cust->save();
            try {
                DB::commit();
                return response()->json(['msg' => 'success']);
            } catch (Exception $ex) {
                return response()->json(['msg' => $ex->getMessage()]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => $e->getMessage()]);
        }
    }

    public function jsonDelete(Request $req)
    {
        $resp  = Users::jsonDelete($req);
        return response()->json(['msg' => $resp]);
    }
}
