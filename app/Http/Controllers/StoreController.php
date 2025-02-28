<?php

namespace App\Http\Controllers;

use App\Models\Address_store;
use App\Models\Customer_store;
use App\Models\Log_error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDO;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $get_all = Customer_store::orderBy('name', 'asc')->get();

            if (count($get_all) > 0) {
                return response()->json([
                    "status" => true,
                    "message" => null,
                    "data" => $get_all
                ], 200);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => 'data not found',
                    "data" => null
                ], 404);
            }
        } catch (\Exception $e) {
            $data_log = [
                'path' => request()->path(),
                'error_msg' => json_encode($e->getMessage())
            ];

            $insert_log = Log_error::create($data_log);
            
            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan: " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
            'image' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => $validator->errors()
            ], 400);
        }

        $title = $request->title;
        $name = $request->name;
        $gender = $request->gender;
        $phone_number = $request->phone_number;
        $image = $request->image;
        $email = $request->email;

        $data = [
            'title' => $title,
            'name' => $name,
            'gender' => $gender,
            'phone_number' => $phone_number,
            'image' => $image,
            'email' => $email
        ];

        DB::beginTransaction();

        try {
            $insert = Customer_store::create($data);

            DB::commit();

            return response()->json([
                "status" => true,
                "message" => "Data berhasil disimpan",
                "data" => $insert
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            $data_log = [
                'path' => request()->path(),
                'error_msg' => json_encode($e->getMessage())
            ];

            $insert_log = Log_error::create($data_log);

            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan: " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $get_data = Customer_store::find($id);
            if (!$get_data) {
                return response()->json([
                    "status" => false,
                    "message" => "Data tidak ditemukan",
                    "data" => $id
                ], 400);
            }
            $get_address = Address_store::where('customer_id', $id)->get();

            $get_data['address'] = $get_address;
            
            return response()->json([
                "status" => true,
                "message" => null,
                "data" => $get_data
            ], 200);
        } catch (\Exception $e) {

            $data_log = [
                'path' => request()->path(),
                'error_msg' => json_encode($e->getMessage())
            ];

            $insert_log = Log_error::create($data_log);

            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan: " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
            'image' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => $validator->errors()
            ], 400);
        }

        $customer = Customer_store::findorFail($id);
        if (!$customer) {
            return response()->json([
                "status" => false,
                "message" => "Data tidak ditemukan",
                "data" => $id
            ], 400);
        }

        $title = $request->title;
        $name = $request->name;
        $gender = $request->gender;
        $phone_number = $request->phone_number;
        $image = $request->image;
        $email = $request->email;

        DB::beginTransaction();
        
        try {

            DB::commit();

            $customer->update([
                'title' => $title,
                'name' => $name,
                'gender' => $gender,
                'phone_number' => $phone_number,
                'image' => $image,
                'email' => $email
            ]);

            return response()->json([
                "status" => true,
                "message" => "Data berhasil dirubah",
                "data" => $customer
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            $data_log = [
                'path' => request()->path(),
                'error_msg' => json_encode($e->getMessage())
            ];

            $insert_log = Log_error::create($data_log);

            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan: " . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cek_data = Customer_store::find($id);
        if (!$cek_data) {
            return response()->json([
                "status" => false,
                "message" => "Data gagal di delete, pastikan id sesuai",
                "data" => $id
            ], 400);
        }

        DB::beginTransaction();
        try {
            $delete = $cek_data->delete();

            DB::commit();

            if ($delete) {
                return response()->json([
                    "status" => true,
                    "message" => "Data berhasil di delete",
                    "data" => $id
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            $data_log = [
                'path' => request()->path(),
                'error_msg' => json_encode($e->getMessage())
            ];

            $insert_log = Log_error::create($data_log);

            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan: " . $e->getMessage()
            ], 500);
        }
    }
}
