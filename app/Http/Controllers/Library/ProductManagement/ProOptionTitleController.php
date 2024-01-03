<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\Product;
use App\Models\Library\ProductManagement\ProductSize;
use App\Models\Library\ProductManagement\ProOptionTitle;


class ProOptionTitleController extends Controller
{
    public function index($proId)
    {
        $id =  $proId;
        $product = Product::findOrFail($id);
        $sizes = ProductSize::where('product_id', $product->id)->orderBy('id', 'DESC')->get();
        return view('library.product_management.addon.product_optn_title.index', compact('product', 'sizes'));
    }

    public function store(Request $request)
    {
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        // return $attributes;
        $rules = [
            'sizeId' => 'required',
            'title_name' => 'required',
            'option_type' => 'required',
            'status' => 'required',
        ];

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
        } else {

            $ingredient = new ProOptionTitle;
            $ingredient->product_id = $attributes['product_id'];
            $ingredient->product_size_id = $attributes['sizeId'];
            $ingredient->title = $attributes['title_name'];
            $ingredient->option_type = $attributes['option_type'];
            $ingredient->free_option_limit = 2;
            $ingredient->status =  $attributes['status'];
            $ingredient->created_by = $userid;
            $ingredient->save();
            \LogActivity::addToLog('Add product option title' . $attributes['title_name']);
            return redirect()->back()->with('success', getNotify(1));
        }
    }
    public function edit($id)
    {
        $proOptnTitle = ProOptionTitle::join('lib_products', 'lib_products.id', '=', 'lib_product_option_titles.product_id')
            ->join('lib_product_sizes', 'lib_product_sizes.id', '=', 'lib_product_option_titles.product_size_id')
            ->select(
                'lib_product_option_titles.id',
                'lib_product_option_titles.title',
                'lib_product_option_titles.status',
                'lib_products.name',
                'lib_product_option_titles.option_type',
                'lib_product_sizes.size_name'
            )
            ->where('lib_product_option_titles.id', $id)
            ->first();

        return view('library.product_management.addon.product_optn_title.edit', compact('proOptnTitle'));
    }

    public function update(Request $request)
    {
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        // return $attributes;
        $rules = [
            'title_name' => 'required',
            'option_type' => 'required',
            'status' => 'required',
        ];

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Update'])->withErrors($validation)->withInput();
        } else {

            $ingredient = ProOptionTitle::findOrFail($attributes['title_id']);
            $ingredient->title = $attributes['title_name'];
            $ingredient->option_type = $attributes['option_type'];
            $ingredient->status =  $attributes['status'];
            $ingredient->updated_by = $userid;
            $ingredient->update();
            \LogActivity::addToLog('Update product option title' . $attributes['title_name']);
            return redirect()->route('proopttitle.index', $ingredient->product_id)->with('success', getNotify(1));
        }
    }

    public function destroy($id)
    {
        $id = $id;
        $subCatAddonIng = ProOptionTitle::find($id);
        $subCatAddonIng->delete();
        \LogActivity::addToLog('Product option title delete' . $subCatAddonIng->title);
        return redirect()->back()->with('success', getNotify(3));
    }
}
