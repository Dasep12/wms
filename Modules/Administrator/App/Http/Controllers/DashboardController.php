<?php

namespace Modules\Administrator\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Administrator\App\Models\Customers;
use Modules\Administrator\App\Models\Inbound;
use Modules\Administrator\App\Models\Material;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('administrator::dashboard/index');
    }

    public function countCustomers()
    {
        if (session()->get("customers_id") != "*") {
            $data = Customers::where('id', session()->get("customers_id"))->count();
        } else {
            $data = Customers::count();
        }
        return response()->json(['data' => $data]);
    }

    public function countMaterial()
    {
        if (session()->get("customers_id") != "*") {
            $data = Material::where('customers_id', session()->get("customers_id"))->count();
        } else {
            $data = Material::count();
        }
        return response()->json(['data' => $data]);
    }

    public function countInbound()
    {
        if (session()->get("customers_id") != "*") {
            $data = Inbound::where(['customers_id' => session()->get("customers_id"), 'types' => 'in', 'types_trans' => 'Order'])->count();
        } else {
            $data = Inbound::where(['types' => 'in', 'types_trans' => 'Order'])->count();
        }
        return response()->json(['data' => $data]);
    }

    public function countOutbound()
    {
        if (session()->get("customers_id") != "*") {
            $data = Inbound::where(['customers_id' => session()->get("customers_id"), 'types' => 'out', 'types_trans' => 'Order'])->count();
        } else {
            $data = Inbound::where(['types' => 'out', 'types_trans' => 'Order'])->count();
        }
        return response()->json(['data' => $data]);
    }

    public function countAdjust()
    {
        if (session()->get("customers_id") != "*") {
            $data = Inbound::where(['customers_id' => session()->get("customers_id"), 'types_trans' => 'Adjust'])->count();
        } else {
            $data = Inbound::where(['types_trans' => 'Adjust'])->count();
        }
        return response()->json(['data' => $data]);
    }
}
