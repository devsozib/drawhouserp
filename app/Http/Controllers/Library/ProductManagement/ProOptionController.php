<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\Product;
use App\Models\Library\ProductManagement\ProductSize;
use App\Models\Library\ProductManagement\ProductOption;
use App\Models\Library\ProductManagement\ProOptionTitle;

class ProOptionController extends Controller
{
    public function index($proId)
    {
        $id =  $proId;
        $product = Product::findOrFail($id);
        $sizes = ProductSize::where('product_id', $product->id)->orderBy('id', 'DESC')->get();
        return view('library.product_management.addon.product_option.index', compact('product', 'sizes'));
    }

    public function store(Request $request)
    {
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        // return $attributes;
        $rules = [
            'sizeId' => 'required',
            'option_title_id' => 'required',
            'name' => 'required',
            'status' => 'required',
        ];

        if ($image = $request->file('image')) {
            $destinationPath = 'public/option_images/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
        }

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
        } else {
            $ingredient = new ProductOption;
            $ingredient->product_id = $attributes['product_id'];
            $ingredient->product_size_id = $attributes['sizeId'];
            $ingredient->option_title_id = $attributes['option_title_id'];
            $ingredient->name = $attributes['name'];
            $ingredient->extra_price = $attributes['ex_price'];
            $ingredient->offer_price = $attributes['off_price'];
            $ingredient->offer_money_from =  $attributes['start_date'];
            $ingredient->offer_money_to = $attributes['end_date'];
            $ingredient->image = $imageName;
            $ingredient->status =  $attributes['status'];
            $ingredient->created_by = $userid;
            $ingredient->save();
            \LogActivity::addToLog('Add product option' . $attributes['name']);
            return redirect()->back()->with('success', getNotify(1));
        }
    }

    public function edit($id)
    {
        $proOption = ProductOption::join('lib_product_option_titles', 'lib_product_option_titles.id', '=', 'lib_product_options.option_title_id')
            ->join('lib_products', 'lib_products.id', '=', 'lib_product_options.product_id')
            ->join('lib_product_sizes', 'lib_product_sizes.id', '=', 'lib_product_options.product_size_id')
            ->select(
                'lib_product_options.id',
                'lib_product_options.name',
                'lib_product_options.image',
                'lib_products.name as product_name',
                'lib_product_sizes.size_name',
                'lib_product_options.extra_price',
                'lib_product_options.offer_price',
                'lib_product_options.offer_money_from',
                'lib_product_options.offer_money_to',
                'lib_product_option_titles.title',
                'lib_product_options.status',
            )
            ->orderBy('lib_product_options.id', 'DESC')
            ->where('lib_product_options.id', $id)
            ->first();

        return view('library.product_management.addon.product_option.edit', compact('proOption'));
    }

    public function update(Request $request)
    {
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        // return $attributes;
        $rules = [
            'name' => 'required',
            'status' => 'required',
        ];

        $ingredient = ProductOption::findOrFail($attributes['pro_option_id']);
        $imageName = "";
        if ($image = $request->file('image')) {
            unlink(public_path('option_images/' . $ingredient->image));
            $destinationPath = 'public/option_images/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
        } else {
            $imageName = $ingredient->image;
        }

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Update'])->withErrors($validation)->withInput();
        } else {
            $ingredient->name = $attributes['name'];
            $ingredient->extra_price = $attributes['ex_price'];
            $ingredient->offer_price = $attributes['off_price'];
            $ingredient->offer_money_from =  $attributes['start_date'];
            $ingredient->offer_money_to = $attributes['end_date'];
            $ingredient->image = $imageName;
            $ingredient->status =  $attributes['status'];
            $ingredient->updated_by = $userid;
            $ingredient->update();
            \LogActivity::addToLog('Update product option' . $attributes['name']);
            return redirect()->route('prooption.indx', $ingredient->product_id)->with('success', getNotify(1));
        }
    }

    public function destroy($id)
    {
        $unit = ProductOption::find($id);
        unlink(public_path('option_images/' . $unit->image));
        $unit->delete();
        \LogActivity::addToLog('Delete option ' . $unit->name);
        return redirect()->back()->with('success', getNotify(3));
    }
}
