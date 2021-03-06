<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use DB;

class ProductController extends Controller
{

    // menampilkan seluruh isi data
    public function index()
    {
        $product = DB::table('products')->orderBy('product_id')->get()->all();
        return $product;
    }

    
    // menambah data
    public function store(ProductRequest $request)
    {

        $response = [];

        $product = Product::where('name', $request->name)->first();
        $category = Category::where('category_id', $request->category_id)->first();

        if ( !is_null($product) || is_null($category) ) {
            if (!is_null($product)) {
                $response['name'] = 'Nama Product sudah terdaftar';
            }

            if (is_null($category)) {
                $response['category_id'] = 'Category_id yang anda masukkan tidak terdaftar';
            }
        
            return response()->json(['msg' => $response], 406);
        }

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price
        ]);

        $response = [
            'msg' => 'Create data Success',
            'data' => $product
        ];

        return response()->json($response, 201);
    }

    // menampilkan data id
    public function show(Product $product)
    {
        return $product;
    }


    // untuk mengupdate data / mengubah data 
    public function update(ProductRequest $request, Product $product)
    {

        $response = [];

        $product = Product::where('name', $request->name)->first();
        $category = Category::where('category_id', $request->category_id)->first();
        
        if ( !is_null($product) || is_null($category) ) {
            if (!is_null($product)) {
                $response['name'] = 'Nama Product sudah terdaftar';
            }

            if (is_null($category)) {
                $response['category_id'] = 'Category_id yang anda masukkan tidak terdaftar';
            }
        
            return response()->json(['msg' => $response], 406);
        }

        $product->name=$request->name;
        $product->category_id=$request->category_id;
        $product->price=$request->price;
        $product->save();

        $response = [
            'msg' => 'Update data Success',
            'data' => $product
        ];

        return response()->json($response, 200);
    }


    // menghapus data
    public function destroy(Product $product)
    {
        $product->delete();
        return ['msg' => 'data has been deleted'];
    }
}
