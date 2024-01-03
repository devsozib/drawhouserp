<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\SubCatAddonIng;
use App\Models\Library\ProductManagement\Ingredient;
use App\Models\Library\ProductManagement\SubCategoryAddon;
use App\Models\Library\ProductManagement\ProductSubCategory;

class ScaIngController extends Controller
{
    public function index($id)
    {
        $id = decrypt($id);
        $subCategory = ProductSubCategory::findOrFail($id);
        $subCategoryAddons = SubCategoryAddon::where('sub_category_id', $subCategory->id)->orderBy('id', 'DESC')->get();
        return view('library.product_management.addon.sca_ing.index', compact('subCategory', 'subCategoryAddons'));
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
            $checkExistIng = SubCatAddonIng::where('sub_cat_id', $attributes['sub_cat_id'])->where('subcat_adn_ing_id', $attributes['addonId'])->where('ing_id', $attributes['ingredient_id'])->first();
            if (!$checkExistIng) {
                $ingredient = new SubCatAddonIng;
                $ingredient->sub_cat_id = $attributes['sub_cat_id'];
                $ingredient->subcat_adn_ing_id = $attributes['addonId'];
                $ingredient->ing_id = $attributes['ingredient_id'];
                $ingredient->amount = $attributes['amount'];
                $ingredient->created_by = $userid;
                $ingredient->save();
                \LogActivity::addToLog('Add Sub Category Addon ingredient' . 'Sub Category Addon Ingredient');
                return redirect()->back()->with('success', getNotify(1));
            } else {
                return redirect()->back()->with('warning', getNotify(6));
            }
        }
    }

    public function destroy($id)
    {
        $id = $id;
        $subCatAddonIng = SubCatAddonIng::find($id);
        $subCatAddonIng->delete();
        \LogActivity::addToLog('Sub Category Addon Ingredient delete' . 'Sub Category Addon Ingredient delete');
        return redirect()->back()->with('success', getNotify(3));
    }
}
