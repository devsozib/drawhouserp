<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Sentinel;
use App\Http\Controllers\Controller;
use App\Models\Library\ProductManagement\Product;
use App\Models\Library\ProductManagement\ProductAdon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductAdonController extends Controller
{
    public function index($id)
    {
        $product = Product::findOrFail($id);
        $productAddons = ProductAdon::where('product_id', $product->id)->orderBy('id', 'DESC')->get();
        return view('library.product_management.addon.product_addon.index', compact('product', 'productAddons'));
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
            $destinationPath = 'public/product_addon_images/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
        } else {
            $imageName = NULL;
        }

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->route('proaddon.index', $attributes['product_id'])->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
        } else {
            $ingredient = new ProductAdon;
            $ingredient->product_id = $attributes['product_id'];
            $ingredient->name = $attributes['addon_name'];
            $ingredient->extra_money_added = $attributes['ex_price'];
            $ingredient->offer_money_added = $attributes['off_price'];
            $ingredient->offer_money_from = $attributes['start_date'];
            $ingredient->offer_money_to = $attributes['end_date'];
            $ingredient->image = $imageName;
            $ingredient->created_by = $userid;
            $ingredient->status = $attributes['status'];
            $ingredient->save();
            \LogActivity::addToLog('Add Product Addon ' . $attributes['addon_name']);
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
        $ingredient = ProductAdon::findOrFail($addon_id);
        $imageName = "";
        if ($image = $request->file('u_image')) {
            if ($ingredient->image) {
                unlink(public_path('product_addon_images/' . $ingredient->image));
                $destinationPath = 'public/product_addon_images/';
                $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageName);
            } else {
                $destinationPath = 'public/product_addon_images/';
                $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageName);
            }
        } else {
            $imageName = $ingredient->image;
        }

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Update'])->withErrors($validation)->withInput();
        } else {
            $ingredient->product_id = $attributes['product_id'];
            $ingredient->name = $attributes['name'];
            $ingredient->extra_money_added = $attributes['ex_price'];
            $ingredient->offer_money_added = $attributes['off_price'];
            $ingredient->offer_money_from = $attributes['start_date'];
            $ingredient->offer_money_to = $attributes['end_date'];
            $ingredient->image = $imageName;
            $ingredient->updated_by = $userid;
            $ingredient->status = $attributes['status'];
            $ingredient->update();
            \LogActivity::addToLog('Update Sub Category Addon ' . $attributes['name']);
            return redirect()->back()->with('success', getNotify(2));
        }
    }

    public function destroy(Request $request)
    {
        $unit = ProductAdon::find($request->addon_id);
        if ($unit->image) {
            unlink(public_path('product_addon_images/' . $unit->image));
            $unit->delete();
        } else {
            $unit->delete();
        }
        \LogActivity::addToLog('Delete Product Addon ' . $unit->name);
        return redirect()->back()->with('success', getNotify(3));
    }
}
