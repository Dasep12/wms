<?php

namespace Modules\Administrator\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Administrator\App\Models\Users;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sql = Users::find(session()->get("user_id"));
        return view('administrator::profile/index', ['data' => $sql]);
    }

    public function updateProfile(Request $req)
    {
        DB::beginTransaction();
        try {
            $cust = Users::find($req->id);
            $cust->username = $req->username;
            $cust->fullname = $req->fullname;
            $cust->phone = $req->phone;
            $cust->email = $req->email;
            if ($req->password != null || $req->password != "") {
                $cust->password =  Hash::make($req->password);
            }
            // Handle the file upload
            if ($req->file('profile') != null) {
                $file = $req->file('profile');

                // Create a unique filename using the original extension
                $newFileName = time() . '_' . $file->getClientOriginalExtension();

                // Store the file with the new name in the 'uploads' directory inside 'storage/app/public'
                // $file->storeAs('assets/images', $newFileName, 'public');
                $tujuan_upload = public_path('assets/images');

                // upload file
                $file->move($tujuan_upload, $newFileName);
                $cust->profile =  $newFileName;
            }
            $cust->updated_at = date('Y-m-d H:i:s');
            $cust->updated_by = session()->get("user_id");
            $cust->save();
            try {
                DB::commit();
                return back()->with('msg', 'Update Successfully');
            } catch (Exception $ex) {
                return response()->json(['msg' => $ex->getMessage()]);
                return back()->with('msg', $ex->getMessage());
            }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }
}
