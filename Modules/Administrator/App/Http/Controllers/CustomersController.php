<?php

namespace Modules\Administrator\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Administrator\App\Models\Customers;


class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('administrator::customers/index');
    }

    public function jsonCustomers(Request $req)
    {
        $response = Customers::jsonList($req);
        return response()->json($response);
    }

    public function jsonCreate(Request $req)
    {
        $resp = Customers::jsonCreate($req);
        return response()->json(['msg' => $resp]);
    }

    public function jsonDetail(Request $req)
    {
        $response = Customers::find($req->id);
        return response()->json($response);
    }

    public function jsonUpdate(Request $req)
    {
        DB::beginTransaction();
        try {
            $cust = Customers::find($req->id);
            $cust->name_customers = $req->name_customers;
            $cust->code_customers = $req->code_customers;
            $cust->address = $req->address;
            $cust->city = $req->city;
            $cust->phone = $req->phone;
            $cust->email = $req->email;
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
        $resp  = Customers::jsonDelete($req);
        return response()->json(['msg' => $resp]);
    }

    public function jsonForListCustomer(Request $request)
    {
        $query = $request->get('q');
        //$results = Customers::where('name_customers', 'LIKE', "%{$query}%")->paginate();
        $results = Customers::where('name_customers', 'LIKE', "%{$query}%")->get(['id', 'name_customers']);
        return response()->json($results, 200);
        // return response()->json([
        //     'results' => $results->map(function ($item) {
        //         return [
        //             'id' => $item->id,
        //             'text' => $item->name_customers,
        //         ];
        //     }),
        // ]);
    }
}
