<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Illuminate\Http\Request;
use App\Models\Library\General\Company;
use App\Http\Controllers\Controller;
use App\Models\Library\ProductManagement\Ingredient;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\IngredientCategory;
use App\Models\Library\ProductManagement\IngredientSubCategory;
use App\Models\Library\ProductManagement\Unit;
use Sentinel;
use File;
use Image;

class IngredientController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $hostCompanyId = getHostInfo()['id'];
            $ingredients = Ingredient::join('lib_ing_categories', 'lib_ing_categories.id', '=', 'lib_ingredients.category_id')
                ->leftJoin('lib_ing_subcategories', 'lib_ing_subcategories.id', '=', 'lib_ingredients.subcategory_id')
                ->leftJoin('lib_company', 'lib_company.id', '=', 'lib_ingredients.company_id')
                ->join('lib_units', 'lib_units.id', '=', 'lib_ingredients.unit_id')
                ->whereRaw('FIND_IN_SET(?, lib_ingredients.company_id)', [getHostInfo()['id']])
                ->select(
                    'lib_ingredients.id',
                    'lib_ingredients.name',
                    'lib_ingredients.image',
                    'lib_ingredients.status',
                    'lib_ing_categories.name as cat_name',
                    'lib_ing_subcategories.name as sub_cat_name',
                    'lib_company.Name as company_name',
                    'lib_units.name as unit_name',
                )
                ->get();
            return view('library.product_management.ingredient.index', compact('ingredients'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }


    public function create()
    {
        if (getAccess('create')) {
            $hostCompanyId = getHostInfo()['id'];
            $units = Unit::where('status', '1')->orderBy('id', 'DESC')->get();
            $categories = IngredientCategory::whereRaw('FIND_IN_SET(?, lib_ing_categories.company_id)', [getHostInfo()['id']])->where('status', '1')->orderBy('id', 'DESC')->get();
            $companies = Company::where('id', getHostInfo()['id'])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $ingredientNotForYou = Ingredient::join('lib_ing_categories', 'lib_ing_categories.id', '=', 'lib_ingredients.category_id')
                ->leftJoin('lib_ing_subcategories', 'lib_ing_subcategories.id', '=', 'lib_ingredients.subcategory_id')
                ->leftJoin('lib_company', 'lib_company.id', '=', 'lib_ingredients.company_id')
                ->join('lib_units', 'lib_units.id', '=', 'lib_ingredients.unit_id')
                ->where(function ($query) use ($hostCompanyId) {
                    $query->whereNull('lib_ingredients.company_id')
                        ->orWhereRaw('FIND_IN_SET(?, lib_ingredients.company_id) = 0', [$hostCompanyId]);
                })
                ->select(
                    'lib_ingredients.id',
                    'lib_ingredients.name',
                    'lib_ingredients.image',
                    'lib_ingredients.status',
                    'lib_ing_categories.name as cat_name',
                    'lib_ing_subcategories.name as sub_cat_name',
                    'lib_company.Name as company_name',
                    'lib_units.name as unit_name',
                )
                ->get();
            return view('library.product_management.ingredient.create', compact('units', 'categories', 'companies', 'ingredientNotForYou'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }


    public function store(Request $request)
    {

        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            $rules = [
                'ing_id' => 'required',
                'company_id' => 'required',
                'in_category_select' => 'required',
                'in_sub_category_select' => 'required',
                'unit_id' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\ProductManagement\IngredientController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $checkIng = Ingredient::where('id', $attributes['ing_id'])->first();
                if ($checkIng) {
                    if ($checkIng->company_id == null) {
                        $checkIng->company_id = $attributes['company_id'];
                        $checkIng->save();
                        \LogActivity::addToLog('Add Ingredient ' .  $checkIng->name);
                    } else {
                        $existingCompanyIds = $checkIng->company_id;
                        $newCompanyId = getHostInfo()['id'];
                        $existingCompanyIdsArray = explode(",", $existingCompanyIds);

                        if (!in_array($newCompanyId, $existingCompanyIdsArray)) {
                            $existingCompanyIdsArray[] = $newCompanyId;
                        }

                        $mergedCompanyIds = implode(",", array_unique($existingCompanyIdsArray));

                        $checkIng->company_id = $mergedCompanyIds;
                        $checkIng->save();
                        \LogActivity::addToLog('Add Ingredient ' . $checkIng->name);
                    }
                } else {
                    $imageName = "";
                    if ($image = $request->file('image')) {
                        $destinationPath = 'public/ingredient_images/';
                        $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                        $upload_success = $image->move($destinationPath, $imageName);
                        if ($upload_success) {
                            Image::make($destinationPath . $imageName)->resize(320, 240)->save($destinationPath . $imageName);
                        }
                    } else {
                        $imageName = null;
                    }

                    $ingredient = new Ingredient;
                    $ingredient->name = $attributes['ing_id'];
                    $ingredient->category_id = $attributes['in_category_select'];
                    $ingredient->subcategory_id = $attributes['in_sub_category_select'];
                    $ingredient->unit_id = $attributes['unit_id'];
                    $ingredient->company_id = null;
                    $ingredient->created_by = $userid;
                    $ingredient->image = $imageName;
                    $ingredient->status = $attributes['status'];
                    $ingredient->notification_limit = 5000;
                    $ingredient->save();
                    \LogActivity::addToLog('Add Ingredient ' . $attributes['ing_id']);
                    return redirect()->action('Library\ProductManagement\IngredientController@create')->with('success', getNotify(1));
                }
                return redirect()->action('Library\ProductManagement\IngredientController@index')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function edit($id)
    {

        if (getAccess('edit')) {
            $id  = $id;
            $ingredient = Ingredient::findOrFail($id);
            $units = Unit::where('status', '1')->orderBy('id', 'DESC')->get();
            $categories =  IngredientCategory::whereRaw('FIND_IN_SET(?, lib_ing_categories.company_id)', [getHostInfo()['id']])->where('status', '1')->orderBy('id', 'DESC')->get();
            $cat_id = $ingredient->category_id;
            $subCategories = IngredientSubCategory::whereRaw('FIND_IN_SET(?, lib_ing_subcategories.company_id)', [getHostInfo()['id']])->where('status', '1')->where('category_id', $cat_id)->orderBy('id', 'DESC')->get();
            $companies = Company::where('id', getHostInfo()['id'])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            return view('library.product_management.ingredient.edit', compact('ingredient', 'units', 'categories', 'companies', 'subCategories'));
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
                'in_sub_category_select' => 'required',
                'unit_id' => 'required',
                'status' => 'required',
                // 'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\ProductManagement\IngredientController@edit', $id)->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $ingredient = Ingredient::findOrFail($id);
                $imageName = "";
                if ($image = $request->file('image')) {
                    unlink(public_path('ingredient_images/' . $ingredient->image));
                    $destinationPath = 'public/ingredient_images/';
                    $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $upload_success = $image->move($destinationPath, $imageName);
                    if ($upload_success) {
                        Image::make($destinationPath . $imageName)->resize(320, 240)->save($destinationPath . $imageName);
                    }
                } else {
                    $imageName = $ingredient->image;
                }

                $ingredient->name = $attributes['name'];
                $ingredient->category_id = $attributes['in_category_select'];
                $ingredient->subcategory_id = $attributes['in_sub_category_select'];
                $ingredient->unit_id = $attributes['unit_id'];
                $ingredient->company_id = $attributes['company_id'];
                $ingredient->updated_by = $userid;
                $ingredient->image = $imageName;
                $ingredient->status = $attributes['status'];
                $ingredient->notification_limit = 5000;
                $ingredient->update();
                \LogActivity::addToLog('Update Ingredient ' . $attributes['name']);
                return redirect()->action('Library\ProductManagement\IngredientController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {




            $userid = Sentinel::getUser()->id;

            $ingredient = Ingredient::find($id);

            $existingCompanyIds = $ingredient->company_id;
            $newCompanyId = getHostInfo()['id'];

            // Convert existing company IDs to an array
            $existingCompanyIdsArray = explode(",", $existingCompanyIds);

            // Remove the new company ID from the array, if it exists
            $key = array_search($newCompanyId, $existingCompanyIdsArray);
            if ($key !== false) {
                unset($existingCompanyIdsArray[$key]);
            }

            // Implode back to a comma-separated string
            $mergedCompanyIds = implode(",", $existingCompanyIdsArray);

            $ingredient->company_id = $mergedCompanyIds;
            $ingredient->save();

            \LogActivity::addToLog('Delete Ingredient Category ' . $ingredient->name);
            return redirect()->action('Library\ProductManagement\IngredientController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
