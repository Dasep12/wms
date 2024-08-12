<?php

namespace Modules\Administrator\App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Modules\Administrator\Database\factories\MaterialFactory;

class Adjustment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    //protected $table = '';
    //protected $primaryKey = '';
    protected $fillable = [];



    public static function jsonList($req)
    {
        $page = $req->input('page');
        $limit = $req->input('rows');
        $sidx = $req->input('sidx', 'id');
        $sord = $req->input('sord', 'asc');
        $start = ($page - 1) * $limit;

        // Total count of records
        $qry = "SELECT COUNT(1) AS count FROM vw_tbl_adjust  ";
        if ($req->search) {
            $qry .= " WHERE no_reference='$req->search' ";
        }
        $countResult = DB::select($qry);
        $count = $countResult[0]->count;

        // Total pages calculation
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        // Fetch data using DB::raw
        $query = "SELECT * FROM vw_tbl_adjust  ";
        if ($req->search) {
            $query .= " WHERE no_reference='$req->search' ";
        }
        $query .= " ORDER BY  id  DESC  LIMIT  $start , $limit ";
        $data = DB::select($query);

        // Prepare rows for jqGrid
        $rows = [];
        foreach ($data as $item) {
            $rows[] = [
                'id'                => $item->id,
                'customer_id'       => $item->customer_id,
                'code_customers'    => $item->code_customers,
                'name_customers'    => ucwords(strtoupper($item->name_customers)),
                'status'            => $item->status,
                'no_surat_jalan'    => $item->no_surat_jalan,
                'no_reference'      => $item->no_reference,
                'remarks'           => $item->remarks,
                'types'             => $item->types,
                'ship_to'           => ucwords(strtolower($item->ship_to)),
                'driver'            => ucwords(strtolower($item->driver)),
                'no_truck'          => $item->no_truck,
                'date_trans'        => $item->date_trans,
                'cell' => [
                    $item->id,
                ] // Adjust fields as needed
            ];
        }

        $response = [
            'page' => $page,
            'total' => $total_pages,
            'records' => $count,
            'rows' => $rows
        ];
        return $response;
    }

    public static function jsonListDetail($req)
    {
        $page = $req->input('page', 1);
        $limit = $req->input('rows', 10);
        $sidx = $req->input('sidx', 'id');
        $sord = $req->input('sord', 'asc');
        $start = ($page - 1) * $limit;

        // Total count of records
        $qry = "SELECT COUNT(1) AS count FROM vw_tbl_inbound_detail WHERE headers_id = '$req->id' ";

        $countResult = DB::select($qry);
        $count = $countResult[0]->count;

        // Total pages calculation
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        // Fetch data using DB::raw
        $query = "SELECT * FROM vw_tbl_inbound_detail WHERE headers_id = '$req->id' ";

        $query .= " ORDER BY  id  ASC  LIMIT  $start , $limit ";
        $data = DB::select($query);

        // Prepare rows for jqGrid
        $rows = [];
        foreach ($data as $item) {
            $rows[] = [
                'id'                => $item->id,
                'no_material'       => $item->no_material,
                'name_material'     => strtoupper($item->name_material),
                'unit'              => $item->unit,
                'units'             => $item->units,
                'packaging'         => $item->packaging,
                'qtyUnit'           => $item->qtyUnit,
                'qtyUnits'          => $item->qtyUnits,
                'qtyPackaging'      => $item->qtyPackaging,
                'cell' => [
                    $item->id,
                ] // Adjust fields as needed
            ];
        }

        $response = [
            'page' => $page,
            'total' => $total_pages,
            'records' => $count,
            'rows' => $rows
        ];
        return $response;
    }

    public static function jsonStockListMaterialByCustomers($req)
    {
        $page = $req->input('page');
        $limit = $req->input('rows');
        $sidx = $req->input('sidx', 'id');
        $sord = $req->input('sord', 'asc');
        $start = ($page - 1) * $limit;

        // Total count of records
        $qry = "SELECT COUNT(1) AS count FROM vw_tbl_control_stock WHERE customers_id = '$req->customers_id'  ";

        $countResult = DB::select($qry);
        $count = $countResult[0]->count;

        // Total pages calculation
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        // Fetch data using DB::raw
        $query = "SELECT * FROM vw_tbl_control_stock WHERE customers_id = '$req->customers_id' ORDER BY updated_at DESC LIMIT  $start , $limit  ";

        $data = DB::select($query);

        // Prepare rows for jqGrid
        $rows = [];
        foreach ($data as $item) {
            $rows[] = [
                'id'                => $item->id,
                'uniqueId'          => $item->uniqueId,
                'units'             => $item->units,
                'unit'              => $item->unit,
                'packaging'         => $item->packaging,
                'name_material'     => $item->name_material,
                'no_material'        => $item->no_material,
                'QtyUnit'           => $item->QtyUnit,
                'QtyUnits'          => $item->QtyUnits,
                'QtyPackaging'      => $item->QtyPackaging,
                'updated_at'      => $item->updated_at,
                'cell' => [
                    $item->id,
                ] // Adjust fields as needed
            ];
        }

        $response = [
            'page' => $page,
            'total' => $total_pages,
            'records' => $count,
            'rows' => $rows
        ];
        return $response;
    }
}
