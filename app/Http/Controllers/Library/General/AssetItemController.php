<?php

namespace App\Http\Controllers\Library\General;

use Illuminate\Http\Request;
use App\Models\Library\General\Company;
use App\Http\Controllers\Controller;
use App\Models\Library\General\AssetItem;
use App\Models\Library\Product\Ingredient;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\IngredientCategory;
use App\Models\Library\ProductManagement\IngredientSubCategory;
use App\Models\Library\ProductManagement\Unit;
use Sentinel;

class AssetItemController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $assetitems = AssetItem::join('lib_ing_categories', 'lib_ing_categories.id', '=', 'lib_asset_list.category_id')
                // ->leftJoin('lib_ing_subcategories','lib_ing_subcategories.id','=','lib_ingredients.subcategory_id')
                ->join('lib_company', 'lib_company.id', '=', 'lib_asset_list.company_id')
                ->join('lib_units', 'lib_units.id', '=', 'lib_asset_list.unit_id')
                ->select(
                    'lib_asset_list.id',
                    'lib_asset_list.name',
                    'lib_asset_list.image',
                    'lib_asset_list.status',
                    'lib_ing_categories.name as cat_name',
                    'lib_company.Name as company_name',
                    'lib_units.name as unit_name',
                )
                ->get();
            return view('library.general.asset_item.index', compact('assetitems'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }


    public function create()
    {
        if (getAccess('create')) {
            $units = Unit::where('status', '1')->orderBy('id', 'DESC')->get();
            $categories = IngredientCategory::where('status', '1')->orderBy('id', 'DESC')->get();
            $companies = Company::where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            return view('library.general.asset_item.create', compact('units', 'categories', 'companies'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }


    public function store(Request $request)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            // return $attributes;
            $rules = [
                'name' => 'required',
                'company_id' => 'required',
                'in_category_select' => 'required',
                'unit_id' => 'required',
                'status' => 'required',
                // 'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ];

            if ($image = $request->file('image')) {
                $destinationPath = 'public/assetItem_images/';
                $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageName);
            }

            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\General\AssetItemController@create')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $assetitem = new AssetItem();
                $assetitem->name = $attributes['name'];
                $assetitem->category_id = $attributes['in_category_select'];
                $assetitem->unit_id = $attributes['unit_id'];
                $assetitem->company_id = $attributes['company_id'];
                $assetitem->created_by = $userid;
                $assetitem->image = $imageName;
                $assetitem->status = $attributes['status'];
                $assetitem->save();
                \LogActivity::addToLog('Add Asset Item ' . $attributes['name']);
                return redirect()->action('Library\General\AssetItemController@create')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function edit($id)
    {

        if (getAccess('edit')) {
            $id = decrypt($id);
            $assetitem = AssetItem::findOrFail($id);
            $units = Unit::where('status', '1')->orderBy('id', 'DESC')->get();
            $categories = IngredientCategory::where('status', '1')->orderBy('id', 'DESC')->get();
            $cat_id = $assetitem->category_id;
            $companies = Company::where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            return view('library.general.asset_item.edit', compact('assetitem', 'units', 'categories', 'companies'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request, $id)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            // return $attributes;
            $rules = [
                'name' => 'required',
                'company_id' => 'required',
                'in_category_select' => 'required',
                'unit_id' => 'required',
                'status' => 'required',
                // 'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ];
            $assetitem = AssetItem::findOrFail($id);
            $imageName = "";
            if ($image = $request->file('image')) {
                $destinationPath = 'public/assetItem_images/';
                $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageName);
            } else {
                $imageName = $assetitem->image;
            }

            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\General\AssetItemController@edit')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $assetitem->name = $attributes['name'];
                $assetitem->category_id = $attributes['in_category_select'];
                $assetitem->unit_id = $attributes['unit_id'];
                $assetitem->company_id = $attributes['company_id'];
                $assetitem->updated_by = $userid;
                $assetitem->image = $imageName;
                $assetitem->status = $attributes['status'];
                $assetitem->update();
                \LogActivity::addToLog('Update Ingredient ' . $attributes['name']);
                return redirect()->action('Library\General\AssetItemController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $assetitem = AssetItem::findOrFail($id);
            unlink(public_path('assetItem_images/' . $assetitem->image));
            $assetitem->delete();
            \LogActivity::addToLog('Delete Asset Item ' . $assetitem->name);
            return redirect()->action('Library\General\AssetItemController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
