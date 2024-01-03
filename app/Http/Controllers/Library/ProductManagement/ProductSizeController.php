<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\Product;
use App\Models\Library\ProductManagement\ProductSize;

class ProductSizeController extends Controller
{
    public function index($proId)
    {
        $id =  $proId;
        $product = Product::findOrFail($id);
        $productSizes = ProductSize::where('product_id', $id)->orderBy('id', 'DESC')->get();
        return view('library.product_management.addon.product_size.index', compact('product', 'productSizes'));
    }

    public function store(Request $request)
    {
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        // return $attributes;
        $rules = [
            'size_name' => 'required',
            'sell_price' => 'required',
            'wholesale_price' => 'numeric',
            'corporate_price' => 'numeric',
            'status'    => 'required',
        ];

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->action('Library\ProductManagement\ProductSizeController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
        } else {
            $ingredient = new ProductSize();
            $ingredient->product_id = $attributes['product_id'];
            $ingredient->size_name = $attributes['size_name'];
            $ingredient->selling_price = $attributes['sell_price'];
            $ingredient->special_price = $attributes['sp_price'];
            $ingredient->special_price_from = $attributes['start_date'];
            $ingredient->special_price_to = $attributes['end_date'];
            $ingredient->wholesale_price = $attributes['wholesale_price'];
            $ingredient->corporate_price = $attributes['corporate_price'];
            $ingredient->created_by = $userid;
            $ingredient->status = $attributes['status'];
            $ingredient->save();
            \LogActivity::addToLog('Add Product Size ' . $attributes['size_name']);
            return redirect()->back()->with('success', getNotify(1));
        }
    }

    public function update(Request $request)
    {
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        // return $attributes;
        $rules = [
            'size_name' => 'required',
            'sell_price' => 'required',
            'u_wholesale_price' => 'numeric',
            'u_corporate_price' => 'numeric',
            'status'    => 'required',
        ];

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'update'])->withErrors($validation)->withInput();
        } else {
            $ingredient = ProductSize::find($attributes['size_id']);
            $ingredient->size_name = $attributes['size_name'];
            $ingredient->selling_price = $attributes['sell_price'];
            $ingredient->special_price = $attributes['sp_price'];
            $ingredient->special_price_from = $attributes['start_date'];
            $ingredient->special_price_to = $attributes['end_date'];
            $ingredient->wholesale_price = $attributes['u_wholesale_price'];
            $ingredient->corporate_price = $attributes['u_corporate_price'];
            $ingredient->updated_by = $userid;
            $ingredient->status = $attributes['status'];
            $ingredient->update();
            \LogActivity::addToLog('Update Product Size ' . $attributes['size_name']);
            return redirect()->back()->with('success', getNotify(2));
        }
    }

    public function destroy($id)
    {
        $unit = ProductSize::find($id);
        $unit->delete();
        \LogActivity::addToLog('Delete product size ' . $unit->size_name);
        return redirect()->back()->with('success', getNotify(3));
    }
}
