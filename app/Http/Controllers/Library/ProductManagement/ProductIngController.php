<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Library\ProductManagement\Ingredient;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\Product;
use App\Models\Library\ProductManagement\ProductIng;
use App\Models\Library\ProductManagement\ProductSize;

class ProductIngController extends Controller
{
    public function index($id)
    {
        $product = Product::findOrFail($id);
        $sizes = ProductSize::where('product_id', $product->id)->orderBy('id', 'DESC')->get();
        return view('library.product_management.addon.product_ing.index', compact('product', 'sizes'));
    }
    public function store(Request $request)
    {
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        // return $attributes;
        $rules = [
            'sizeId' => 'required',
            'ingredient_id' => 'required',
            'amount' => 'required',
        ];

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
        } else {
            $checkExistIng = ProductIng::where('product_id', $attributes['product_id'])->where('product_size_id', $attributes['sizeId'])->where('ing_id', $attributes['ingredient_id'])->first();
            if (!$checkExistIng) {
                $ingredient = new ProductIng;
                $ingredient->product_id = $attributes['product_id'];
                $ingredient->product_size_id = $attributes['sizeId'];
                $ingredient->ing_id = $attributes['ingredient_id'];
                $ingredient->ing_amount = $attributes['amount'];
                $ingredient->created_by = $userid;
                $ingredient->save();
                \LogActivity::addToLog('Add product ingredient' . 'Product ingredient add');
                return redirect()->back()->with('success', getNotify(1));
            } else {
                return redirect()->back()->with('warning', getNotify(6));
            }
        }
    }

    public function edit($id)
    {
        $productIng = ProductIng::join('lib_ingredients', 'lib_ingredients.id', '=', 'lib_product_ingredients.ing_id')
            ->join('lib_products', 'lib_product_ingredients.product_id', '=', 'lib_products.id')
            ->join('lib_product_sizes', 'lib_product_ingredients.product_size_id', '=', 'lib_product_sizes.id')
            ->select(
                'lib_product_ingredients.id',
                'lib_product_ingredients.ing_amount',
                'lib_products.name as product_name',
                'lib_ingredients.name as ing_name',
                'lib_product_sizes.size_name',
            )
            ->where('lib_product_ingredients.id', $id)
            ->first();

        return view('library.product_management.addon.product_ing.edit', compact('productIng'));
    }

    public function update(Request $request)
    {
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        // return $attributes;
        $rules = [
            'amount' => 'required',
        ];

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'update'])->withErrors($validation)->withInput();
        } else {
            $ingredient = ProductIng::find($attributes['ing_id']);
            $ingredient->ing_amount = $attributes['amount'];
            $ingredient->updated_by = $userid;
            $ingredient->update();
            \LogActivity::addToLog('Update Product ing ' . 'update product ingredient');
            return redirect()->route('producting.index', $ingredient->id)->with('success', getNotify(2));
        }
    }

    public function destroy($id)
    {
        $id = $id;
        $subCatAddonIng = ProductIng::find($id);
        $subCatAddonIng->delete();
        \LogActivity::addToLog('Product Ingredient delete' . 'Product Ingredient delete');
        return redirect()->back()->with('success', getNotify(3));
    }
}
