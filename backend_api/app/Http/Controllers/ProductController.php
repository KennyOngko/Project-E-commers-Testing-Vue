<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
class ProductController extends Controller
{
    public function getAllProduct(){
        try {
            $dataProduct = DB::table('products')->get();
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
        return response()->json([
            'data_product' => $dataProduct
        ], 200);
    }
    public function getAllCategories(){
        try {
            $dataCategories = DB::table('categories')->get();
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
        return response()->json([
            'data_categories' => $dataCategories
        ], 200);
    }

}
