<?php

namespace Modules\Administrator\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Administrator\App\Models\Packaging;

class PackagingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('administrator::packaging/index');
    }

    public function jsonPackaging(Request $req)
    {
        $response = Packaging::jsonList($req);
        return response()->json($response);
    }

    public function jsonCreate(Request $req)
    {
        $resp = Packaging::jsonCreate($req);
        return response()->json(['msg' => $resp]);
    }



    public function jsonDetail(Request $req)
    {
        $response = Packaging::find($req->id);
        return response()->json($response);
    }

    public function jsonUpdate(Request $req)
    {
        DB::beginTransaction();
        try {
            $cust = Packaging::find($req->id);
            $cust->name_packaging = $req->name_packaging;
            $cust->status_packaging = $req->status_packaging == null ? 0 : 1;
            // $cust->status_unit = $req->status_unitress;
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
        $resp  = Packaging::jsonDelete($req);
        return response()->json(['msg' => $resp]);
    }

    public function jsonForListPackaging(Request $request)
    {
        $query = $request->get('q');
        $results = Packaging::where(['status_packaging' => 1])->get(['id', 'name_packaging']);
        return response()->json($results, 200);
    }
}
