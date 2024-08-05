<?php

namespace Modules\Administrator\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Administrator\App\Models\Customers;
use Modules\Administrator\App\Models\Outbound;
use Modules\Administrator\App\Models\SummaryStock;
use PhpParser\Node\Expr\Match_;

class OutboundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('administrator::outbound/index');
    }

    public function jsonOutbound(Request $req)
    {
        $response = Outbound::jsonList($req);
        return response()->json($response);
    }

    public function jsonDetailMaterial(Request $req)
    {
        $response = Outbound::jsonListDetail($req);
        return response()->json($response);
    }

    public function jsonListUnitsByCustomers(Request $req)
    {
        $response = Customers::where('status_customer', '1')->get();
        return response()->json($response);
    }

    public function jsonDetailListMaterialEdit(Request $req)
    {
        $response = DB::select("SELECT * FROM  vw_tbl_Outbound_detail WHERE headers_id='$req->id' ");
        return response()->json($response);
    }

    public function jsonCreateOutbound(Request $req)
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
            $details = array(
                'headers_id'    => '',
                'material_id'   => $material[$i]->id,
                'no_material'   => $material[$i]->no_material,
                'name_material' => $material[$i]->name_material,
                'nameStorage'   => $material[$i]->name_storage,
                'storage'       => $material[$i]->totalStorage,
                'qty'           => $material[$i]->qty,
                'uom'           => $material[$i]->satuan,
                'qtyPerUnit'    => $material[$i]->qtyUnit,
                'unit'          => $material[$i]->name_unit,
                'Outbound'       => $material[$i]->qty * $material[$i]->qtyUnit,
            );
            array_push($detailMaterial, $details);
        }

        if (count($material) <= 0) {
            return response()->json(['msg' => "list material cannot empty"]);
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
            // try {
            //     try {
            // for ($l = 0; $l < count($detailMaterial); $l++) {
            //     DB::table('tbl_trn_detailshipingmaterial')->insert($detailMaterial[$l]);
            //     $parent_IdDetails = DB::getPdo()->lastInsertId();
            //     $stock_exist =    SummaryStock::where('material_id', $detailMaterial[$l]['material_id']);

            //     if ($stock_exist->count() <= 0) {
            //         $par = [
            //             'material_id'   => $detailMaterial[$l]['material_id'],
            //             'begin_stock'   => 0,
            //             'Outbound_stock' => $detailMaterial[$l]['qty'],
            //             'end_stock'     => $detailMaterial[$l]['qty'],
            //             'created_at'    => date('Y-m-d H:i:s'),
            //             'headers_detail_id' => $parent_IdDetails
            //         ];
            //         SummaryStock::create($par);
            //     } else {
            //         $stock_exist_1 = SummaryStock::where('material_id', $detailMaterial[$l]['material_id'])->orderBy('id', 'DESC')->first();
            //         SummaryStock::where('material_id', $detailMaterial[$l]['material_id'])->create([
            //             'material_id'   => $detailMaterial[$l]['material_id'],
            //             'begin_stock'   => $stock_exist_1->end_stock,
            //             'Outbound_stock' => $detailMaterial[$l]['qty'],
            //             'end_stock'     => $stock_exist_1->end_stock + $detailMaterial[$l]['qty'],
            //             'headers_detail_id' => $parent_IdDetails
            //         ]);
            //     }
            // }
            //         DB::commit();
            //         return response()->json(['msg' => "err"]);
            //     } catch (\Illuminate\Database\QueryException $ex) {
            //         return response()->json(['msg' => $ex->getMessage()]);
            //     }
            // } catch (\Illuminate\Database\QueryException $ex) {
            //     DB::rollBack();
            //     return response()->json(['msg' => $ex->getMessage()]);
            // }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => $e->getMessage()]);
        }
    }

    public function jsonUpdateOutbound(Request $req)
    {
        $material = json_decode($req->dataMaterial);
        $detailMaterial = [];
        $headersId = $req->id;
        for ($i = 0; $i < count($material); $i++) {
            $details = array(
                'headers_id'    => $req->id,
                // 'detail_id'     => $material[$i]->detail_id,
                'material_id'   => $material[$i]->id,
                'no_material'   => $material[$i]->no_material,
                'name_material' => $material[$i]->name_material,
                'nameStorage'   => $material[$i]->name_storage,
                'storage'       => $material[$i]->totalStorage,
                'qty'           => $material[$i]->qty,
                'uom'           => $material[$i]->satuan,
                'qtyPerUnit'    => $material[$i]->qtyUnit,
                'unit'          => $material[$i]->name_unit,
                'Outbound'       => $material[$i]->qty * $material[$i]->qtyUnit,
            );
            array_push($detailMaterial, $details);
        }





        $listIdDetail = DB::select("SELECT id as detail_id FROM tbl_trn_detailshipingmaterial WHERE headers_id = '$headersId' ");
        $existingIdInDB = array_filter(array_column($listIdDetail, 'detail_id'));
        DB::beginTransaction();
        try {
            $dataHeader = [
                'customer_id'       => $req->customer_id,
                'no_reference'      => $req->no_reference,
                'no_surat_jalan'    => $req->no_surat_jalan,
                'ship_to'           => $req->ship_to,
                'driver'            => $req->driver,
                'no_truck'          => $req->no_truck,
                'date_trans'        => $req->date_trans,
                'date_in'           => $req->date_in,
                'created_at'        => date('Y-m-d H:i:s'),
                'status'            => 'open',
                'types'             => 'in',
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

    public function jsonDeleteOutbound(Request $req)
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
}
