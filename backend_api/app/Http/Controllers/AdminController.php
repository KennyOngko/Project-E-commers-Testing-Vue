<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProductAdmin()
    {
        try {
            $dataProduct = DB::table('products')
            ->join('categories','categories.id','=','products.categoriesID')
            ->select('products.id','categories.name'
            ,'products.categoriesID'
            ,'products.productName'
            ,'products.price'
            ,'products.qty'
            ,'products.description'
            ,'products.gambar'
            ,'products.toggle')
            ->orderBy('products.categoriesID')
            ->get();

        } catch (Exception $err) {
            return response()->json($err, 500);
        }
        return response()->json([
            'data_product_admin' => $dataProduct,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'message'=>$validator->errors()
                ], 401);
            }
            $newDataCategory = new Category;
            $newDataCategory->name = $request->name;
            $newDataCategory->save();
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
        return response()->json([
            'Message'=>'Berhasil'
        ], 200);
    }


    public function storeProduct(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50',
                'price' => 'required|numeric|max:100000000',
                'qty' => 'required|string|max:3',
                'description' => 'required|string|max:500',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'message'=>$validator->errors()
                ], 401);
            }

            $newDataProduct = new Product;
            $newDataProduct->categoriesID = $request->categoriesID;
            $newDataProduct->productName = $request->name;
            $newDataProduct->qty = $request->qty;
            $newDataProduct->price = $request->price;
            $newDataProduct->description = $request->description;
            $newDataProduct->save();
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
        return response()->json([
            'Message'=>'Berhasil',
            'id'=>$newDataProduct->id
        ], 200);
    }


    public function uploadImage (Request $req) {
        $validator = Validator::make($req->all(), [
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:20048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }

        $dataUpdatedProduct = DB::table('products')->where('id','=',$req->id)->first();
        if (!is_null($req->gambar))
        {
            if (!isset($dataUpdatedProduct->gambar)) {
                $dataImageProfile= DB::table('products')
                ->select(DB::raw('SUBSTRING(gambar,30,100) AS path'))
                ->where('id','=',$req->id)->first();
                Storage::delete('/public/'.$dataImageProfile->path);

                $dateNow = carbon::now()->format("Y-m-d_H-i-s");
                $fullNameTemp = str_replace(' ', '', $dataUpdatedProduct->productName);
                $ext = $req->gambar->getClientOriginalExtension();
                $path = $req->file('gambar')->storeAs('Img', strtolower($fullNameTemp.$dateNow.$dataUpdatedProduct->id.'.'.$ext), 'public');
                $imagePath = 'http://127.0.0.1:8000/storage/'. $path;
                $dataProduct = DB::table('products')->where('id','=',$req->id)
                ->update(['gambar' => $imagePath]);

            }
            else{

                $dateNow = carbon::now()->format("Y-m-d_H-i-s");
                $fullNameTemp = str_replace(' ', '', $dataUpdatedProduct->productName);
                $ext = $req->gambar->getClientOriginalExtension();
                $path = $req->file('gambar')->storeAs('Img', strtolower($fullNameTemp.$dateNow.$dataUpdatedProduct->id.'.'.$ext), 'public');
                $imagePath = 'http://127.0.0.1:8000/storage/'. $path;
                $dataProduct = DB::table('products')->where('id','=',$req->id)
                ->update(['gambar' => $imagePath]);
            }

        }
        else{
            $dataProduct = DB::table('products')->where('id','=',$req->id)->update(['gambar' =>null]);
        }
        return response()->json([
            'message' => 'success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDataCategory(Request $request)
    {
        try {
            $updateData = DB::table('categories')
            ->where('id','=',$request->id)
            ->update(['name'=>$request->updated]);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
        return response()->json([
            'Message'=>'Data Berhasil DiUpdate'
        ], 200);
    }

    public function updateDataProduct(Request $request)
    {
        try {
            $updateData = DB::table('products')
            ->where('id','=',$request->id)
            ->update(['productName'=>$request->productName, 
            'categoriesID'=>$request->categoriesID, 
            'price'=>$request->price, 
            'qty'=>$request->qty, 
            'description'=>$request->description]);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
        return response()->json([
            'Message'=>'Data Berhasil DiUpdate Product'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataCategory(Request $request)
    {

        try {
            $data_category = DB::table('categories')
            ->where('id', '=', $request->id)
            ->delete();
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
        return response()->json([
            'Message'=>'Data Berhasil DiHapus'
        ], 200);
    }

    public function deleteDataProduct(Request $request)
    {

        try {
            $data_category = DB::table('products')
            ->where('id', '=', $request->id)
            ->delete();
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
        return response()->json([
            'Message'=>'Data Berhasil DiHapus'
        ], 200);
    }
}
