<?php

namespace Modules\Administrator\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Administrator\App\Models\Customers;
use Modules\Administrator\App\Models\Material;


class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('administrator::material/index');
    }

    public function jsonMaterial(Request $req)
    {
        $response = Material::jsonList($req);
        return response()->json($response);
    }


    public function jsonCreate(Request $req)
    {
        $resp = Material::jsonCreate($req);
        return response()->json(['msg' => $resp]);
    }

    public function jsonDetail(Request $req)
    {
        $response = Material::find($req->id);
        return response()->json($response);
    }

    public function jsonUpdate(Request $req)
    {
        DB::beginTransaction();
        try {
            $cust = Material::find($req->id);
            $cust->no_material      = $req->no_material;
            $cust->uniqueId        = $req->uniqueId;
            $cust->name_material    = $req->name_material;
            $cust->customers_id     = $req->customers_id;
            $cust->status_material     = $req->status_material == null ? 0 : 1;
            $cust->unit_id              = $req->unit_id;
            $cust->parentUnitId        = $req->parentUnitId;
            $cust->QtyPerUnit          = $req->QtyPerUnit;
            $cust->packaging_id          = $req->packaging_id;
            $cust->location_id          = $req->location_id;
            $cust->updated_at       = date('Y-m-d H:i:s');
            $cust->updated_by       = session()->get("user_id");
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
        $resp  = Material::jsonDelete($req);
        return response()->json(['msg' => $resp]);
    }
}
