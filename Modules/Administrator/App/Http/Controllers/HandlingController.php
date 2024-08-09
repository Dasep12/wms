<?php

namespace Modules\Administrator\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Administrator\App\Models\Handling;

class HandlingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('administrator::handling/index');
    }

    public function jsonHandling(Request $req)
    {
        $response = Handling::jsonList($req);
        return response()->json($response);
    }

    public function jsonCreate(Request $req)
    {
        $resp = Handling::jsonCreate($req);
        return response()->json(['msg' => $resp]);
    }

    public function jsonDetail(Request $req)
    {
        $response = Handling::find($req->id);
        return response()->json($response);
    }

    public function jsonUpdate(Request $req)
    {
        DB::beginTransaction();
        try {
            $cust = Handling::find($req->id);
            $cust->nameHandling = $req->nameHandling;
            $cust->price = $req->price;
            $cust->status_handling = $req->status_handling == null ? 0 : 1;
            $cust->updated_at = date('Y-m-d H:i:s');
            $cust->updated_by = session()->get("user_id");
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
        $resp  = Handling::jsonDelete($req);
        return response()->json(['msg' => $resp]);
    }

    public function jsonForListHandling(Request $request)
    {
        $query = $request->get('q');
        $results = Handling::where('nameHandling', 'LIKE', "%{$query}%")->get(['id', 'nameHandling']);
        return response()->json($results, 200);
    }
}
