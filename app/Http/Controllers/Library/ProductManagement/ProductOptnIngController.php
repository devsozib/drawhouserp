<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\Product;
use App\Models\Library\ProductManagement\ProductSize;
use App\Models\Library\ProductManagement\ProductOptnIng;

class ProductOptnIngController extends Controller
{
    public function index($proId)
    {
        $id =  $proId;
        $product = Product::findOrFail($id);
        $sizes = ProductSize::where('product_id', $product->id)->orderBy('id', 'DESC')->get();
        return view('library.product_management.addon.product_optn_ing.index', compact('product', 'sizes'));
    }

    public function store(Request $request)
    {
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        // return $attributes;
        $rules = [
            'sizeId' => 'required',
            'option_title_id' => 'required',
            'option_id' => 'required',
            'ingredient_id' => 'required',
            'amount' => 'required',
        ];

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
        } else {
            $checkExistIng = ProductOptnIng::where('product_id', $attributes['product_id'])->where('product_size_id', $attributes['sizeId'])->where('option_title_id', $attributes['option_title_id'])->where('option_id', $attributes['option_id'])->where('ing_id', $attributes['ingredient_id'])->first();
            if (!$checkExistIng) {
                $ingredient = new ProductOptnIng;
                $ingredient->product_id = $attributes['product_id'];
                $ingredient->product_size_id = $attributes['sizeId'];
                $ingredient->option_title_id = $attributes['option_title_id'];
                $ingredient->option_id = $attributes['option_id'];
                $ingredient->ing_id = $attributes['ingredient_id'];
                $ingredient->amount = $attributes['amount'];
                $ingredient->created_by = $userid;
                $ingredient->save();
                \LogActivity::addToLog('Add product option ingredient' . 'Add product option ingredient');
                return redirect()->back()->with('success', getNotify(1));
            } else {
                return redirect()->back()->with('warning', getNotify(6));
            }
        }
    }

    public function edit($id)
    {
        $productOptnIng = ProductOptnIng::join('lib_ingredients', 'lib_ingredients.id', '=', 'lib_product_option_ings.ing_id')
            ->join('lib_products', 'lib_product_option_ings.product_id', '=', 'lib_products.id')
            ->join('lib_product_sizes', 'lib_product_option_ings.product_size_id', '=', 'lib_product_sizes.id')
            ->join('lib_product_options', 'lib_product_option_ings.option_id', '=', 'lib_product_options.id')
            ->join('lib_product_option_titles', 'lib_product_option_ings.option_title_id', '=', 'lib_product_option_titles.id')
            ->select(
                'lib_product_option_ings.id',
                'lib_product_option_ings.amount',
                'lib_products.name as product_name',
                'lib_ingredients.name as ing_name',
                'lib_product_sizes.size_name',
                'lib_product_options.name as option_name',
                'lib_product_option_titles.title'
            )
            ->where('lib_product_option_ings.id', $id)
            ->first();

        return view('library.product_management.addon.product_optn_ing.edit', compact('productOptnIng'));
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
            $ingredient = ProductOptnIng::find($attributes['ing_id']);
            $ingredient->amount = $attributes['amount'];
            $ingredient->updated_by = $userid;
            $ingredient->update();
            \LogActivity::addToLog('Update Product option ing ' . 'update product option ingredient');
            return redirect()->route('prooptioning.indx', $ingredient->id)->with('success', getNotify(2));
        }
    }

    public function destroy($id)
    {
        $id = $id;
        $subCatAddonIng = ProductOptnIng::find($id);
        $subCatAddonIng->delete();
        \LogActivity::addToLog('Product Ingredient delete' . 'Product Ingredient delete');
        return redirect()->back()->with('success', getNotify(3));
    }
}
