<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::get();
        echo json_encode($product);
    }

    /**
     * Deletes all rows.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll()
    {

        Product::truncate();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $nameV = Str::contains($product->name, ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0']);
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $product->name))
            {
                $nameV = true;
            }
        $product->price = $request->input('price');
        $product->type = $request->input('type');
        $product->date_input = $request->input('date_input');
        // $typeV = Str::containsAll($product->type, ["Comestible", "No"]);
        // $typeV = Str::containsAll($product->type, 'Comestible');
        $typeV = false;
        if($product->type == "Comestible" || $product->type == "No Comestible"){
            $typeV = true;
        }


        if($nameV){

            abort(405, "Number or Special Character in parameter name");
        }
        if(!$typeV){
            abort(405, "Wrong input in parameter type. Only try with [Comestible] and [No comestible]");
        }
        else{
            $product->save();
            echo json_encode($product);

        }


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->type = $request->input('type');
        $product->date_input = $request->input('date_input');
        $product->save();
        echo json_encode($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        $product = Product::find($product_id);
        $product->delete();

        echo "Producto eliminado";
    }
}
