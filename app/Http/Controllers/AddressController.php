<?php

namespace App\Http\Controllers;

use App\Models\Address_store;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'district' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required|numeric|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $validator->errors()
            ], 400);
        }

        $customer_id = isset($request->customer_id) ? $request->customer_id : null;
        $address = $request->address;
        $district = $request->district;
        $city = $request->city;
        $province = $request->province;
        $postal_code = $request->postal_code;

        $data = [
            'customer_id' => $customer_id,
            'address' => $address,
            'district' => $district,
            'city' => $city,
            'province' => $province,
            'postal_code' => $postal_code
        ];

        DB::beginTransaction();

        try {
            $insert = Address_store::create($data);

            DB::commit();

            return response()->json([
                "status" => true,
                "message" => "Data berhasil disimpan",
                "data" => $insert
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'district' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required|numeric|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => $validator->errors()
            ], 400);
        }

        $address_data = Address_store::findorFail($id);
        if (!$address_data) {
            return response()->json([
                "status" => false,
                "message" => "Data tidak ditemukan",
                "data" => $id
            ], 400);
        }

        // $customer_id = isset($request->customer_id) ? $request->customer_id : null;
        $address = $request->address;
        $district = $request->district;
        $city = $request->city;
        $province = $request->province;
        $postal_code = $request->postal_code;

        DB::beginTransaction();

        try {

            DB::commit();

            $address_data->update([
                'address' => $address,
                'district' => $district,
                'city' => $city,
                'province' => $province,
                'postal_code' => $postal_code
            ]);

            return response()->json([
                "status" => true,
                "message" => "Data berhasil dirubah",
                "data" => $address_data
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

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
        $cek_data = Address_store::find($id);
        if(!$cek_data){
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

            if($delete){
                return response()->json([
                    "status" => true,
                    "message" => "Data berhasil di delete",
                    "data" => $id
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan: " . $e->getMessage()
            ], 500);
        }
    }
}
