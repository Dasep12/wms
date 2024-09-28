<?php

namespace Modules\Administrator\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Modules\Administrator\Database\factories\MaterialFactory;

use function Laravel\Prompts\select;

class Material extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'tbl_mst_material';
    protected $primaryKey = 'id';
    protected $fillable = [
        'no_material',
        'nama_material',
        'customers_id',
        'satuan_id',
        'location_id',
        'begin_stock',
        'inbound_stock',
        'outbound_stock',
        'status_material',
        'stock_akhir',
        'created_at',
        'created_by',
        'updated_by',
        'updated_at',
    ];



    // public static function jsonList($req)
    // {
    //     $page = $req->input('page');
    //     $limit = $req->input('rows');
    //     $sidx = $req->input('sidx', 'id');
    //     $sord = $req->input('sord', 'asc');
    //     $start = ($page - 1) * $limit;
    //     $custId = session()->get("customers_id")  == "*" ? null : session()->get("customers_id");
    //     $qry = "SELECT COUNT(1) AS count 
    //             FROM tbl_mst_material a 
    //             left join tbl_mst_units b on b.id = a.unit_id   
    //             left join tbl_mst_units d on b.id = a.parentUnitId   
    //             left join tbl_mst_customers c on c.id  = a.customers_id
    //             left join tbl_mst_locationwarehouse f on f.id = a.location_id
    //             left join tbl_mst_packaging e on e.id = a.packaging_id 
    //           ";

    //     if ($custId != null) {
    //         $qry .= " WHERE customers_id = '$custId' ";
    //     } else {
    //         $qry .= " WHERE customers_id !='$custId' ";
    //     }
    //     if ($req->customers_id) {
    //         $qry .= " AND customers_id='$req->customers_id'  and status_material= 1 ";
    //     }

    //     if ($req->search) {
    //         $qry .= " AND name_material LIKE '%$req->search%' ";
    //     }
    //     // Total count of records
    //     $countResult = DB::select($qry);
    //     $count = $countResult[0]->count;

    //     // Total pages calculation
    //     if ($count > 0) {
    //         $total_pages = ceil($count / $limit);
    //     } else {
    //         $total_pages = 0;
    //     }

    //     // Fetch data using DB::raw
    //     $query = "SELECT a.* , b.code_unit as unit_code , c.name_customers , d.name_unit , d.code_unit , b.name_unit  as satuan , e.name_packaging , c.code_customers
    //             FROM tbl_mst_material a 
    //             left join tbl_mst_units b on b.id = a.unit_id   
    //             left join tbl_mst_units d on d.id = a.parentUnitId   
    //             left join tbl_mst_packaging e on e.id = a.packaging_id
    //             left join tbl_mst_locationwarehouse f on f.id = a.location_id
    //             left join tbl_mst_customers c on c.id  = a.customers_id 
    //             ";

    //     if ($custId != null) {
    //         $query .= " WHERE customers_id = '$custId' ";
    //     } else {
    //         $query .= " WHERE customers_id !='$custId' ";
    //     }
    //     if ($req->search) {
    //         $query .= " AND  name_material LIKE '%$req->search%'  ";
    //     }



    //     $query .= " ORDER BY  id  DESC  LIMIT  $start , $limit ";
    //     $data = DB::select($query);

    //     // Prepare rows for jqGrid
    //     $rows = [];
    //     foreach ($data as $item) {
    //         $rows[] = [
    //             'id'                => $item->id,
    //             'customers'         =>  $item->name_customers,
    //             'uniqueId'          =>  $item->uniqueId,
    //             'code_customers'    =>  $item->code_customers,
    //             'name_material'     =>  strtoupper($item->name_material),
    //             'no_material'       =>  $item->no_material,
    //             'status_material'   =>  $item->status_material,
    //             'unit'              =>  $item->code_unit,
    //             'unitQty'           =>  $item->QtyPerUnit,
    //             'name_packaging'    =>  $item->name_packaging,
    //             'satuan'            =>  $item->satuan,
    //             'created_at'        =>  $item->created_at,
    //             'cell' => [
    //                 $item->id,
    //             ] // Adjust fields as needed
    //         ];
    //     }

    //     $response = [
    //         'page' => $page,
    //         'total' => $total_pages,
    //         'records' => $count,
    //         'rows' => $rows
    //     ];
    //     return $response;
    // }

    public static function jsonList($req)
    {
        $page = $req->input('page'); // current page number
        $limit = $req->input('rows'); // rows per page
        $sidx = $req->input('sidx'); // sort column
        $sord = $req->input('sord'); // sort direction
        $custId = session()->get("customers_id")  == "*" ? null : session()->get("customers_id");
        $query = DB::table('tbl_mst_material as a')
            ->leftJoin('tbl_mst_units  as b', 'b.id', '=', 'a.unit_id')
            ->leftJoin('tbl_mst_units  as c', 'c.id', '=', 'a.parentUnitId')
            ->leftJoin('tbl_mst_customers  as d', 'd.id', '=', 'a.customers_id')
            ->leftJoin('tbl_mst_locationwarehouse  as e', 'e.id', '=', 'a.location_id')
            ->leftJoin('tbl_mst_packaging  as f', 'f.id', '=', 'a.packaging_id')
            ->select('a.*', 'b.code_unit as unit_code', 'd.name_customers', 'c.name_unit', 'c.code_unit as unit', 'b.name_unit  as satuan', 'f.name_packaging', 'd.code_customers');


        // Applying filters based on customers_id
        if ($custId !== null) {
            $query->where('a.customers_id', $custId);
        } else {
            $query->whereNotNull('a.customers_id'); // If $custId is null, get rows with a non-null customers_id
        }

        // Apply filters based on the request customers_id and status
        if ($req->customers_id) {
            $query->where([
                ['a.customers_id', '=', $req->customers_id],
                ['a.status_material', '=', 1]
            ]);
        }

        // Apply search filter
        if ($req->search) {
            $query->where('a.name_material', 'like', '%' . $req->search . '%');
        }
        if ($sidx) {
            $query->orderBy($sidx, $sord);
        }



        $count = $query->count();

        $data = $query->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        $totalPages = ($count > 0) ? ceil($count / $limit) : 0;

        $response = [
            'page' => $page,
            'total' => $totalPages,
            'records' => $count,
            'rows' => $data->toArray(),
        ];

        return $response;
    }

    public static function jsonCreate($req)
    {
        DB::beginTransaction();
        try {
            try {
                DB::table('tbl_mst_material')
                    ->insert([
                        'uniqueId'          => $req->uniqueId,
                        'no_material'       => $req->no_material,
                        'name_material'     => $req->name_material,
                        'customers_id'      => $req->customers_id,
                        'parentUnitId'      => $req->parentUnitId,
                        'packaging_id'      => $req->packaging_id,
                        'location_id'      => $req->location_id,
                        'unit_id'           => $req->unit_id,
                        'QtyPerUnit'        => $req->QtyPerUnit,
                        'status_material'   =>  $req->status_material == null ? 0 : 1,
                        'created_at'        => date('Y-m-d H:i:s'),
                        'created_by'        => session()->get("user_id"),
                        'updated_at'        => date('Y-m-d H:i:s'),
                        'updated_by'        => session()->get("user_id"),
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
            DB::table('tbl_mst_material')->where('id', $req->id)->delete();
            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
