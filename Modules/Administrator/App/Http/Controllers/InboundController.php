<?php

namespace Modules\Administrator\App\Http\Controllers;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Administrator\App\Models\Customers;
use Modules\Administrator\App\Models\Inbound;
use Modules\Administrator\App\Models\Material;
use Modules\Administrator\App\Models\SummaryStock;
use PhpParser\Node\Expr\Match_;

class InboundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('administrator::inbound/index');
    }

    public function jsonInbound(Request $req)
    {
        $response = Inbound::jsonList($req);
        return response()->json($response);
    }

    public function jsonDetailMaterial(Request $req)
    {
        $response = Inbound::jsonListDetail($req);
        return response()->json($response);
    }

    public function jsonListUnitsByCustomers(Request $req)
    {
        $response = Customers::where('status_customer', '1')->get();
        return response()->json($response);
    }
    public function jsonListMaterialByCustomers(Request $req)
    {
        $response = Inbound::jsonListMaterialByCustomers($req);
        return response()->json($response);
    }


    public function jsonDetailListMaterialEdit(Request $req)
    {
        $response = DB::select("SELECT * FROM  vw_tbl_inbound_detail WHERE headers_id='$req->id' ");
        return response()->json($response);
    }

    public function jsonCreateInbound(Request $req)
    {
        $material = json_decode($req->dataMaterial);

        $dataHeader = [
            'customer_id'       => $req->customer_id,
            'no_reference'      => $req->no_reference,
            'no_surat_jalan'    => $req->no_surat_jalan,
            'ship_to'           => $req->ship_to,
            'driver'            => $req->driver,
            'no_truck'          => $req->no_truck,
            'date_trans'        => $req->date_trans . ' ' . date('H:i:s'),
            'date_in'           => $req->date_in,
            'created_at'        => date('Y-m-d H:i:s'),
            'status'            => 'open',
            'types'             => 'in',
        ];


        $detailMaterial = [];
        for ($i = 0; $i < count($material); $i++) {
            $stock =  DB::select("CALL sp_tbl_checkStock(" . $material[$i]->id . ")");
            $details = array(
                'headers_id'    => '',
                'material_id'   => $material[$i]->id,
                'name_material' => $material[$i]->name_material,
                'no_material'   => $material[$i]->no_material,
                'uniqid'        => $material[$i]->uniqid,
                'unit'          => $material[$i]->unit,
                'units'         => $material[$i]->units,
                'packaging'     => $material[$i]->packaging,
                'qtyUnit'       => $material[$i]->qtyUnit,
                'qtyUnits'      => $material[$i]->qtyUnits,
                'qtyPackaging'  => $material[$i]->qtyPackaging,
                'begin_stock_unit'   => $stock[0]->qtyUnitBeginStock,
                'begin_stock_units'   => $stock[0]->qtyUnitsBeginStock,
                'begin_stock_packaging'   => $stock[0]->qtyPackagingBeginStock,
                'created_at'            => date('Y-m-d H:i:s'),
                'created_by'            => session()->get("user_id"),
            );
            array_push($detailMaterial, $details);
        }

        if (count($material) <= 0) {
            return response()->json(['msg' => "list material cannot be empty"]);
        }

        DB::beginTransaction();
        try {
            DB::table('tbl_trn_shipingmaterial')->insert($dataHeader);
            $headersId = DB::getPdo()->lastInsertId();
            for ($k = 0; $k < count($detailMaterial); $k++) {
                $detailMaterial[$k]['headers_id'] = $headersId;
            }
            DB::table('tbl_trn_detailshipingmaterial')->insert($detailMaterial);
            try {
                DB::commit();
                return response()->json(['msg' => "success"]);
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollBack();
                return response()->json(['msg' => $ex->getMessage()]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => $e->getMessage()]);
        }
    }

    public function jsonUpdateInbound(Request $req)
    {
        $material = json_decode($req->dataMaterial);
        $detailMaterial = [];
        $headersId = $req->id;
        for ($i = 0; $i < count($material); $i++) {
            // Create a DateTime object from the original date string
            $stock =  DB::select("CALL sp_tbl_checkStock(" . $material[$i]->id . ")");
            $details = array(
                'headers_id'    => $req->id,
                'material_id'   => $material[$i]->id,
                'name_material' => $material[$i]->name_material,
                'no_material'   => $material[$i]->no_material,
                'uniqid'        => $material[$i]->uniqid,
                'unit'          => $material[$i]->unit,
                'units'         => $material[$i]->units,
                'packaging'     => $material[$i]->packaging,
                'qtyUnit'       => $material[$i]->qtyUnit,
                'qtyUnits'      => $material[$i]->qtyUnits,
                'qtyPackaging'  => $material[$i]->qtyPackaging,
                'begin_stock_unit'   => $stock[0]->qtyUnitBeginStock,
                'begin_stock_units'   => $stock[0]->qtyUnitsBeginStock,
                'begin_stock_packaging'   => $stock[0]->qtyPackagingBeginStock,
                'created_at'            => date('Y-m-d H:i:s'),
                'created_by'            => session()->get("user_id"),
            );
            array_push($detailMaterial, $details);
        }




        $listIdDetail = DB::select("SELECT id as detail_id FROM tbl_trn_detailshipingmaterial WHERE headers_id = '$headersId' ");
        $existingIdInDB = array_filter(array_column($listIdDetail, 'detail_id'));
        DB::beginTransaction();
        try {
            date_default_timezone_set('Asia/Jakarta');
            // $dates =  date("Y-m-d H:i:s", strtotime($req->date_trans));
            //DateTime::createFromFormat('d M Y H:i:s', $req->date_trans);
            $dataHeader = [
                'customer_id'       => $req->customer_id,
                'no_reference'      => $req->no_reference,
                'no_surat_jalan'    => $req->no_surat_jalan,
                'ship_to'           => $req->ship_to,
                'driver'            => $req->driver,
                'no_truck'          => $req->no_truck,
                'date_trans'        => $req->date_trans . ' ' . date('H:i:s'),
                'date_in'           => $req->date_in,
                'created_at'        => date('Y-m-d H:i:s'),
                'status'            => 'open',
                'types'             => 'in',
                'updated_at'        => date('Y-m-d H:i:s'),
                'updated_by'        => session()->get("user_id")
            ];
            DB::table("tbl_trn_shipingmaterial")->where('id', $headersId)->update($dataHeader);
            DB::table('tbl_trn_detailshipingmaterial')->whereIn('id', $existingIdInDB)->delete();
            DB::table('tbl_trn_detailshipingmaterial')->insert($detailMaterial);
            DB::commit();
            return response()->json(['msg' => "success"]);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return response()->json(['msg' => $ex->getMessage()]);
        }
    }

    public function jsonDeleteInbound(Request $req)
    {
        if ($req->action == "delete") {
            DB::beginTransaction();
            try {
                DB::table("tbl_trn_detailshipingmaterial")->where('headers_id', $req->id)->delete();
                DB::table("tbl_trn_shipingmaterial")->where('id', $req->id)->delete();
                try {
                    DB::commit();
                    return response()->json(['msg' => "success"]);
                } catch (\Illuminate\Database\QueryException $ex) {
                    DB::rollBack();
                    return response()->json(['msg' =>  $ex->getMessage()]);
                }
            } catch (Exception $e) {
                return response()->json(['msg' => $e->getMessage()]);
            }
        }
    }

    public function jsonPutawayInbound(Request $req)
    {
        if ($req->action == "putaway") {
            DB::beginTransaction();
            try {
                DB::table("tbl_trn_detailshipingmaterial")->where('headers_id', $req->id)->update([
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'updated_by'    => session()->get("user_id"),
                ]);
                DB::table("tbl_trn_shipingmaterial")->where('id', $req->id)->update([
                    'date_in'       => date('Y-m-d H:i:s'),
                    'status'        => "close",
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'updated_by'    => session()->get("user_id")
                ]);
                try {
                    DB::commit();
                    return response()->json(['msg' => "success"]);
                } catch (\Illuminate\Database\QueryException $ex) {
                    DB::rollBack();
                    return response()->json(['msg' =>  $ex->getMessage()]);
                }
            } catch (Exception $e) {
                return response()->json(['msg' => $e->getMessage()]);
            }
        }
    }
}
