<?php

namespace Modules\Administrator\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Administrator\App\Models\Location;
use Modules\Administrator\App\Models\Warehouse;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'warehouse' => Warehouse::get()
        ];
        return view('administrator::location/index', $data);
    }

    public function jsonLocation(Request $req)
    {
        $response = Location::jsonList($req);
        return response()->json($response);
    }

    public function jsonCreate(Request $req)
    {
        $resp = Location::jsonCreate($req);
        return response()->json(['msg' => $resp]);
    }



    public function jsonDetail(Request $req)
    {
        $response = Location::find($req->id);
        return response()->json($response);
    }

    public function jsonUpdate(Request $req)
    {
        DB::beginTransaction();
        try {
            $cust = Location::find($req->id);
            $cust->remarks = $req->remarks;
            $cust->location = $req->location;
            $cust->status_location = $req->status_location == null ? 0 : 1;
            $cust->warehouse_id = $req->warehouse_id;
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
        $resp  = Location::jsonDelete($req);
        return response()->json(['msg' => $resp]);
    }

    public function jsonForListLocation(Request $request)
    {
        $id = $request->get('id');
        $results = Location::where(['status_location' => 1])->get(['id', 'location']);
        return response()->json($results, 200);
    }
}
