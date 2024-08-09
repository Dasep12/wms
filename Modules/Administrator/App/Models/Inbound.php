<?php

namespace Modules\Administrator\App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Modules\Administrator\Database\factories\MaterialFactory;

class Inbound extends Model
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
        $qry = "SELECT COUNT(1) AS count FROM vw_tbl_inbound  ";
        if ($req->search) {
            $qry .= " WHERE no_surat_jalan='$req->search' ";
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
        $query = "SELECT * FROM vw_tbl_inbound  ";
        if ($req->search) {
            $query .= " WHERE no_surat_jalan='$req->search' ";
        }
        $query .= " ORDER BY  id  DESC  LIMIT  $start , $limit ";
        $data = DB::select($query);

        // Prepare rows for jqGrid
        $rows = [];
        foreach ($data as $item) {
            $rows[] = [
                'id'                => $item->id,
                'customer_id'       => $item->customer_id,
                'code_customers'       => $item->code_customers,
                'name_customers'    => ucwords(strtoupper($item->name_customers)),
                'status'            => $item->status,
                'no_surat_jalan'    => $item->no_surat_jalan,
                'no_reference'      => $item->no_reference,
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

    public static function jsonCreate($req)
    {
        DB::beginTransaction();
        try {
            try {
                DB::table('tbl_mst_units')
                    ->insert([
                        'name_unit' => $req->name_unit,
                        'code_unit' => $req->code_unit,
                        'status_unit' => $req->status_unit,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => 1,
                    ]);
                DB::commit();
                return "success";
            } catch (\Illuminate\Database\QueryException $ex) {
                return $ex->getMessage();
            }
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public static function jsonDelete($req)
    {
        DB::beginTransaction();
        try {
            DB::table('tbl_mst_units')->where('id', $req->id)->delete();
            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public static function jsonListMaterialByCustomers($req)
    {
        $page = $req->input('page');
        $limit = $req->input('rows');
        $sidx = $req->input('sidx', 'id');
        $sord = $req->input('sord', 'asc');
        $start = ($page - 1) * $limit;

        $qry = "SELECT COUNT(1) AS count 
                FROM tbl_mst_material a 
                left join tbl_mst_units b on b.id = a.unit_id   
                left join tbl_mst_units d on b.id = a.parentUnitId   
                left join tbl_mst_customers c on c.id  = a.customers_id
                left join tbl_mst_locationwarehouse f on f.id = a.location_id
                left join tbl_mst_packaging e on e.id = a.packaging_id
                WHERE customers_id='" . $req->customers_id . "'  and status_material= 1 ";


        // Total count of records
        $countResult = DB::select($qry);
        $count = $countResult[0]->count;

        // Total pages calculation
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        // Fetch data using DB::raw
        $query = "SELECT a.* , b.code_unit as unit_code , c.name_customers , d.name_unit , d.code_unit , b.name_unit  as satuan , e.name_packaging , c.code_customers
                FROM tbl_mst_material a 
                left join tbl_mst_units b on b.id = a.unit_id   
                left join tbl_mst_units d on d.id = a.parentUnitId   
                left join tbl_mst_packaging e on e.id = a.packaging_id
                left join tbl_mst_locationwarehouse f on f.id = a.location_id
                left join tbl_mst_customers c on c.id  = a.customers_id 
                WHERE customers_id='" . $req->customers_id . "'  and status_material= 1 ";

        $query .= " ORDER BY  id  DESC  LIMIT  $start , $limit ";
        $data = DB::select($query);

        // Prepare rows for jqGrid
        $rows = [];
        foreach ($data as $item) {
            $rows[] = [
                'id'                =>  $item->id,
                'customers'         =>  $item->name_customers,
                'uniqueId'          =>  $item->uniqueId,
                'code_customers'    =>  $item->code_customers,
                'name_material'     =>  strtoupper($item->name_material),
                'no_material'       =>  $item->no_material,
                'status_material'   =>  $item->status_material,
                'unit'              =>  $item->code_unit,
                'unitQty'           =>  $item->QtyPerUnit,
                'name_packaging'    =>  $item->name_packaging,
                'satuan'            =>  $item->satuan,
                'created_at'        =>  $item->created_at,
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
