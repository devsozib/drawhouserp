<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\Product;
use App\Models\Library\ProductManagement\ProductAdon;
use App\Models\Library\ProductManagement\ProductAdonIng;
use App\Models\Library\ProductManagement\SubCatAddonIng;

class ProductAdnIngController extends Controller
{
    public function index($id)
    {
        $product = Product::findOrFail($id);
        $productAddons = ProductAdon::where('product_id', $product->id)->orderBy('id', 'DESC')->get();
        return view('library.product_management.addon.product_adn_ings.index', compact('product', 'productAddons'));
    }

    public function store(Request $request)
    {
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        // return $attributes;
        $rules = [
            'addonId' => 'required',
            'ingredient_id' => 'required',
            'amount' => 'required',
        ];

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
        } else {
            $checkExistIng = ProductAdonIng::where('product_id', $attributes['product_id'])->where('pro_adn_id', $attributes['addonId'])->where('ing_id', $attributes['ingredient_id'])->first();
            if (!$checkExistIng) {
                $ingredient = new ProductAdonIng;
                $ingredient->product_id = $attributes['product_id'];
                $ingredient->pro_adn_id = $attributes['addonId'];
                $ingredient->ing_id = $attributes['ingredient_id'];
                $ingredient->amount = $attributes['amount'];
                $ingredient->created_by = $userid;
                $ingredient->save();
                \LogActivity::addToLog('Add Product Addon ingredient' . 'Product Addon Ingredient');
                return redirect()->back()->with('success', getNotify(1));
            } else {
                return redirect()->back()->with('warning', getNotify(6));
            }
        }
    }




    public function destroy($id)
    {
        $id = $id;
        $subCatAddonIng = ProductAdonIng::find($id);
        $subCatAddonIng->delete();
        \LogActivity::addToLog('Product Addon Ingredient delete' . 'Product Addon Ingredient delete');
        return redirect()->back()->with('success', getNotify(3));
    }
}
