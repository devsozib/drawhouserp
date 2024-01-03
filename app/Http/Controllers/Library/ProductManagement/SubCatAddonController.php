<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\SubCategoryAddon;
use App\Models\Library\ProductManagement\ProductSubCategory;

class SubCatAddonController extends Controller
{
    public function index($cat_id)
    {
        $subCategory = ProductSubCategory::findOrFail($cat_id);
        $subCategoryAddons = SubCategoryAddon::where('sub_category_id', $subCategory->id)->orderBy('id', 'DESC')->get();
        return view('library.product_management.addon.sub_cat_addon.index', compact('subCategory', 'subCategoryAddons'));
    }

    public function store(Request $request)
    {
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        // return $attributes;
        $rules = [
            'addon_name' => 'required',
            'ex_price' => 'required',
            'status'    => 'required',
            // 'image' => 'required',
        ];
        $imageName = "";
        if ($image = $request->file('image')) {
            $destinationPath = 'public/addon_images/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
        } else {
            $imageName = "";
        }

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->route('sca.index', $attributes['sub_cat_id'])->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
        } else {
            $ingredient = new SubCategoryAddon;
            $ingredient->sub_category_id = $attributes['sub_cat_id'];
            $ingredient->name = $attributes['addon_name'];
            $ingredient->extra_money_added = $attributes['ex_price'];
            $ingredient->offer_money_added = $attributes['off_price'];
            $ingredient->offer_money_from = $attributes['start_price'];
            $ingredient->offer_money_to = $attributes['end_date'];
            $ingredient->image = $imageName;
            $ingredient->created_by = $userid;
            $ingredient->status = $attributes['status'];
            $ingredient->save();
            \LogActivity::addToLog('Add Sub Category Addon ' . $attributes['addon_name']);
            return redirect()->back()->with('success', getNotify(1));
        }
    }


    public function update(Request $request)
    {
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        $addon_id = $attributes['addon_id'];
        $rules = [
            'name' => 'required',
            'ex_price' => 'required',
            'status'    => 'required'
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
        $ingredient = SubCategoryAddon::findOrFail($addon_id);
        $imageName = "";
        if ($image = $request->file('image')) {
            unlink(public_path('addon_images/' . $ingredient->image));
            $destinationPath = 'public/ingredient_images/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
        } else {
            $imageName = $ingredient->image;
        }

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
        } else {
            $ingredient->sub_category_id = $attributes['sub_cat_id'];
            $ingredient->name = $attributes['name'];
            $ingredient->extra_money_added = $attributes['ex_price'];
            $ingredient->offer_money_added = $attributes['off_price'];
            $ingredient->offer_money_from = $attributes['start_price'];
            $ingredient->offer_money_to = $attributes['end_date'];
            $ingredient->image = $imageName;
            $ingredient->updated_by = $userid;
            $ingredient->status = $attributes['status'];
            $ingredient->update();
            \LogActivity::addToLog('Update Sub Category Addon ' . $attributes['name']);
            return redirect()->back()->with('success', getNotify(2));
        }
    }

    public function destroy($size_id)
    {
        $unit = SubCategoryAddon::find($size_id);
        if ($unit->image) {
            unlink(public_path('addon_images/' . $unit->image));
            $unit->delete();
        } else {
            $unit->delete();
        }
        \LogActivity::addToLog('Delete SubCategory Addon ' . $unit->name);
        return redirect()->back()->with('success', getNotify(3));
    }
}
