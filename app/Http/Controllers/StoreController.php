<?php

namespace App\Http\Controllers;

use App\Models\Customer_store;
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

            if(count($get_all) > 0){
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
            DB::rollBack();

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
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $validator->errors()
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
            ], 201);
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cek_data = Customer_store::find($id);
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
                ], 201);
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
