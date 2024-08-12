<?php

namespace Modules\Administrator\App\Http\Controllers;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Administrator\App\Models\Adjustment;
use Barryvdh\DomPDF\Facade\Pdf;


class AdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('administrator::adjustment/index');
    }

    public function jsonAdjustment(Request $req)
    {
        $response = Adjustment::jsonList($req);
        return response()->json($response);
    }

    public function jsonDetailMaterial(Request $req)
    {
        $response = Adjustment::jsonListDetail($req);
        return response()->json($response);
    }

    public function jsonStockListMaterialByCustomers(Request $req)
    {
        $response = Adjustment::jsonStockListMaterialByCustomers($req);
        return response()->json($response);
    }



    public function jsonCreateAdjustment(Request $req)
    {
        $material = json_decode($req->dataMaterial);
        $dataHeader = [
            'customer_id'       => $req->customer_id,
            // 'no_reference'      => $req->no_reference,
            'no_surat_jalan'    => $req->no_surat_jalan,
            // 'ship_to'           => $req->ship_to,
            // 'driver'            => $req->driver,
            'remarks'           => $req->remarks,
            'date_trans'        => $req->date_trans . ' ' . date('H:i:s'),
            'created_at'        => date('Y-m-d H:i:s'),
            'status'            => 'open',
            'types'             =>  $req->type_adjust,
            'types_trans'       => 'Adjust',
        ];

        $detailMaterial = [];

        for ($i = 0; $i < count($material); $i++) {
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
                'begin_stock_unit'   => $material[$i]->StockqtyUnit,
                'begin_stock_units'   => $material[$i]->StockqtyUnits,
                'begin_stock_packaging'   => $material[$i]->StockqtyPackaging,
                'details_unit'          => $material[$i]->details_unit,
                'created_at'            => date('Y-m-d H:i:s'),
                'created_by'            => session()->get("user_id"),
            );
            array_push($detailMaterial, $details);
        }


        if (count($material) <= 0) {
            return response()->json(['msg' => "list material tidak boleh kosong"]);
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

    public function jsonUpdateAdjustment(Request $req)
    {
        $material = json_decode($req->dataMaterial);
        $detailMaterial = [];
        $headersId = $req->id;
        for ($i = 0; $i < count($material); $i++) {
            $details = array(
                'headers_id'    => $req->id,
                // 'detail_id'     => $material[$i]->detail_id,
                'material_id'   => $material[$i]->id,
                'details_unit'  => $material[$i]->details_unit,
                'name_material' => $material[$i]->name_material,
                'no_material'   => $material[$i]->no_material,
                'uniqid'        => $material[$i]->uniqid,
                'unit'          => $material[$i]->unit,
                'units'         => $material[$i]->units,
                'packaging'     => $material[$i]->packaging,
                'qtyUnit'       => $material[$i]->qtyUnit,
                'qtyUnits'      => $material[$i]->qtyUnits,
                'qtyPackaging'  => $material[$i]->qtyPackaging,
                'begin_stock_unit'   => $material[$i]->StockqtyUnit,
                'begin_stock_units'   => $material[$i]->StockqtyUnits,
                'begin_stock_packaging'   => $material[$i]->StockqtyPackaging,
                'created_at'            => date('Y-m-d H:i:s'),
                'created_by'            => 1,
            );
            array_push($detailMaterial, $details);
        }


        $listIdDetail = DB::select("SELECT id as detail_id FROM tbl_trn_detailshipingmaterial WHERE headers_id = '$headersId' ");
        $existingIdInDB = array_filter(array_column($listIdDetail, 'detail_id'));
        DB::beginTransaction();
        try {
            // Create a DateTime object from the original date string
            $dates = DateTime::createFromFormat('d M Y H:i:s', $req->date_trans);
            $dataHeader = [
                'customer_id'       => $req->customer_id,
                'no_reference'      => $req->no_reference,
                'no_surat_jalan'    => $req->no_surat_jalan,
                'ship_to'           => $req->ship_to,
                'driver'            => $req->driver,
                'no_truck'          => $req->no_truck,
                'date_trans'        => $dates->format('Y-m-d H:i:s'),
                'date_in'           => $req->date_in,
                'created_at'        => date('Y-m-d H:i:s'),
                'status'            => 'open',
                'types'             =>  $req->type_adjust,
                'types_trans'       => 'Adjust',
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

    public function jsonDeleteAdjustment(Request $req)
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

    public function jsonPutawayAdjustment(Request $req)
    {
        if ($req->action == "putaway") {
            DB::beginTransaction();
            try {
                DB::table("tbl_trn_detailshipingmaterial")->where('headers_id', $req->id)->update([
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'updated_by'    => session()->get("user_id"),
                ]);
                DB::table("tbl_trn_shipingmaterial")->where('id', $req->id)->update([
                    'status'        => "close",
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'updated_by'    => session()->get("user_id"),
                    'date_in'       => date('Y-m-d H:i:s'),
                    'date_out'      => date('Y-m-d H:i:s'),
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


    public function generateDN(Request $req)
    {
        return getSuratJalanAdjust($req->customers_id);
    }
}
