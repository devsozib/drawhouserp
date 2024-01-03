<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Illuminate\Http\Request;
use App\Models\Library\General\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\IngredientCategory;
use App\Models\Library\ProductManagement\IngredientSubCategory;
use Sentinel;

class IngredientSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (getAccess('view')) {
            $hostCompanyId = getHostInfo()['id'];
            $companies = Company::where('id', getHostInfo()['id'])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $categories = IngredientCategory::whereRaw('FIND_IN_SET(?, lib_ing_categories.company_id)', [getHostInfo()['id']])->where('status', '1')->get();
            $ingredientSubCategories =  IngredientSubCategory::join('lib_company', 'lib_company.id', '=', 'lib_ing_subcategories.company_id')
                ->join('lib_ing_categories', 'lib_ing_subcategories.category_id', '=', 'lib_ing_categories.id')
                ->orderBy('lib_ing_subcategories.id', 'ASC')
                ->whereRaw('FIND_IN_SET(?, lib_ing_subcategories.company_id)', [getHostInfo()['id']])
                ->select(
                    'lib_ing_subcategories.id',
                    'lib_ing_subcategories.name',
                    'lib_ing_subcategories.status',
                    'lib_ing_categories.name as parent_category',
                    'lib_ing_categories.id as parent_category_id',
                    'lib_company.Name as company_name',
                    'lib_company.id as company_id',
                    'lib_ing_subcategories.category_id'
                )->get();

            $ingredientSubCategoriesNotForYou =  IngredientSubCategory::leftJoin('lib_company', 'lib_company.id', '=', 'lib_ing_subcategories.company_id')
                ->join('lib_ing_categories', 'lib_ing_subcategories.category_id', '=', 'lib_ing_categories.id')
                ->orderBy('lib_ing_subcategories.id', 'ASC')
                ->where(function ($query) use ($hostCompanyId) {
                    $query->whereNull('lib_ing_subcategories.company_id')
                        ->orWhereRaw('FIND_IN_SET(?, lib_ing_subcategories.company_id) = 0', [$hostCompanyId]);
                })
                ->select(
                    'lib_ing_subcategories.id',
                    'lib_ing_subcategories.name',
                    'lib_ing_subcategories.status',
                    'lib_ing_categories.name as parent_category',
                    'lib_ing_categories.id as parent_category_id',
                    'lib_company.Name as company_name',
                    'lib_company.id as company_id'
                )->get();

            return view('library.product_management.ing_subcategory.index', compact('companies', 'ingredientSubCategories', 'ingredientSubCategoriesNotForYou', 'categories'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            return $attributes = $request->all();
            $rules = [
                'ing_sub_cat_id' => 'required',
                'category_id' => 'required',
                'company_id' => 'required',
                'status' => 'required',
            ];

            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\ProductManagement\IngredientSubCategoryController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {

                $ingredientSubCategory = IngredientSubCategory::where('id', $attributes['ing_sub_cat_id'])->first();
                if ($ingredientSubCategory) {
                    if ($ingredientSubCategory->company_id == null) {
                        $ingredientSubCategory->company_id = $attributes['company_id'];
                        $ingredientSubCategory->save();
                        \LogActivity::addToLog('Add IngredientSubCategory ' .  $ingredientSubCategory->name);
                    } else {
                        $existingCompanyIds = $ingredientSubCategory->company_id;
                        $newCompanyId = getHostInfo()['id'];
                        $existingCompanyIdsArray = explode(",", $existingCompanyIds);

                        if (!in_array($newCompanyId, $existingCompanyIdsArray)) {
                            $existingCompanyIdsArray[] = $newCompanyId;
                        }

                        $mergedCompanyIds = implode(",", array_unique($existingCompanyIdsArray));

                        $ingredientSubCategory->company_id = $mergedCompanyIds;
                        $ingredientSubCategory->save();
                        \LogActivity::addToLog('Add IngredientSubCategory ' . $ingredientSubCategory->name);
                    }
                } else {
                    $ingredientSubCategory = new IngredientCategory();
                    $ingredientSubCategory->category_id = $attributes['category_id'];
                    $ingredientSubCategory->name = $attributes['ing_cat_id'];
                    $ingredientSubCategory->company_id = null;
                    $ingredientSubCategory->status = $attributes['status'];
                    $ingredientSubCategory->created_by = $userid;
                    $ingredientSubCategory->save();
                    \LogActivity::addToLog('Add IngredientCategory ' . $ingredientSubCategory['name']);
                }
                return redirect()->action('Library\ProductManagement\IngredientSubCategoryController@index')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }


    public function update(Request $request, $id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            $rules = [
                'name' => 'required',
                'category_id' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\ProductManagement\IngredientSubCategoryController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $ingredientSubCategory = IngredientSubCategory::find($id);
                $ingredientSubCategory->category_id =  $attributes['category_id'];
                $ingredientSubCategory->name = $attributes['name'];
                $ingredientSubCategory->status = $attributes['status'];
                $ingredientSubCategory->updated_by = $userid;
                $ingredientSubCategory->update();
                \LogActivity::addToLog('Update ingredientSubCategory ' . $attributes['name']);
                return redirect()->action('Library\ProductManagement\IngredientSubCategoryController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }


    public function destroy($id)
    {
        if (getAccess('delete')) {
            $ingredientCategory = IngredientSubCategory::find($id);

            $existingCompanyIds = $ingredientCategory->company_id;
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

            $ingredientCategory->company_id = $mergedCompanyIds;
            $ingredientCategory->save();

            \LogActivity::addToLog('Delete Ingredient sub Category ' . $ingredientCategory->name);
            return redirect()->action('Library\ProductManagement\IngredientSubCategoryController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
