<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Sentinel;
use Illuminate\Http\Request;
use App\Models\Library\General\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\IngredientCategory;

class IngredientCategoryController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $hostCompanyId = getHostInfo()['id'];
            $companies = Company::where('id',getHostInfo()['id'])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $ingredientCategories = IngredientCategory::join('lib_company', 'lib_company.id', '=', 'lib_ing_categories.company_id')
            ->orderBy('lib_ing_categories.id', 'ASC')
            ->whereRaw('FIND_IN_SET(?, lib_ing_categories.company_id)', [getHostInfo()['id']])
            ->select('lib_ing_categories.id', 'lib_ing_categories.name', 'lib_company.Name as company_name', 'lib_ing_categories.status', 'lib_company.id as company_id')
            ->orderBy('lib_ing_categories.id','DESC')
            ->get();
            $ingredientCategoriesNotForYou = IngredientCategory::leftJoin('lib_company', 'lib_company.id', '=', 'lib_ing_categories.company_id')
            ->orderBy('lib_ing_categories.id', 'DESC')
            ->where(function ($query) use ($hostCompanyId) {
                $query->whereNull('lib_ing_categories.company_id')
                      ->orWhereRaw('FIND_IN_SET(?, lib_ing_categories.company_id) = 0', [$hostCompanyId]);
            })
            ->select('lib_ing_categories.id', 'lib_ing_categories.name', 'lib_company.Name as company_name', 'lib_ing_categories.status', 'lib_company.id as company_id')
            ->get();
            return view('library.product_management.ing_category.index', compact('companies', 'ingredientCategories','ingredientCategoriesNotForYou'));
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
                'ing_cat_id' => 'required',
                'company_id' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\ProductManagement\IngredientCategoryController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                
                $checkIngCategory = IngredientCategory::where('id',$attributes['ing_cat_id'])->first();
                if($checkIngCategory){
                    if($checkIngCategory->company_id == null){                                                              
                        $checkIngCategory->company_id = $attributes['company_id'];            
                        $checkIngCategory->save();
                        \LogActivity::addToLog('Add IngredientCategory ' .  $checkIngCategory->name);
                    }else{                                 
                        $existingCompanyIds = $checkIngCategory->company_id; 
                        $newCompanyId = getHostInfo()['id'];                                         
                        $existingCompanyIdsArray = explode(",", $existingCompanyIds);
                                           
                        if (!in_array($newCompanyId, $existingCompanyIdsArray)) {
                            $existingCompanyIdsArray[] = $newCompanyId;
                        }
    
                        $mergedCompanyIds = implode(",", array_unique($existingCompanyIdsArray));
                        
                        $checkIngCategory->company_id = $mergedCompanyIds;
                        $checkIngCategory->save();
                        \LogActivity::addToLog('Add IngredientCategory ' . $checkIngCategory->name);                    
                        
                    }
                }else{
                    $ingredientCategory = new IngredientCategory();
                    $ingredientCategory->name = $attributes['ing_cat_id'];             
                    $ingredientCategory->company_id = null;             
                    $ingredientCategory->status = $attributes['status'];
                    $ingredientCategory->created_by = $userid;
                    $ingredientCategory->save();
                    \LogActivity::addToLog('Update IngredientCategory ' . $ingredientCategory['name']);  
                }
               
                
                return redirect()->action('Library\ProductManagement\IngredientCategoryController@index')->with('success', getNotify(1));
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
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\ProductManagement\IngredientCategoryController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $ingredientCategory = IngredientCategory::find($id);
                $ingredientCategory->name = $attributes['name'];              
                $ingredientCategory->status = $attributes['status'];
                $ingredientCategory->updated_by = $userid;
                $ingredientCategory->update();
                \LogActivity::addToLog('Update IngredientCategory ' . $attributes['name']);
                return redirect()->action('Library\ProductManagement\IngredientCategoryController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (getAccess('delete')) {
            $IngredientCategory = IngredientCategory::find($id);

            $existingCompanyIds = $IngredientCategory->company_id;
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
            
            $IngredientCategory->company_id = $mergedCompanyIds;
            $IngredientCategory->save();
            
            \LogActivity::addToLog('Delete Ingredient Category ' . $IngredientCategory->name);
            return redirect()->action('Library\ProductManagement\IngredientCategoryController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
