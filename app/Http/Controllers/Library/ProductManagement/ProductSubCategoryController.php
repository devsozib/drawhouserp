<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Illuminate\Http\Request;
use App\Models\Library\General\Company;
use App\Http\Controllers\Controller;
use App\Models\Library\ProductManagement\ProductCategory;
use Illuminate\Support\Facades\Validator;
use App\Models\Library\ProductManagement\ProductSubCategory;
use Sentinel;

class ProductSubCategoryController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $hostCompanyId = getHostInfo()['id'];
            $companies = Company::where('id',getHostInfo()['id'])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $productCategories = ProductCategory::whereRaw('FIND_IN_SET(?, lib_product_categories.company_id)', [getHostInfo()['id']])->where('status', '1')->orderBy('id', 'DESC')->get();
            $productSubCategories = ProductSubCategory::whereRaw('FIND_IN_SET(?, lib_product_subcategories.company_id)', [getHostInfo()['id']])->join('lib_company', 'lib_company.id', '=', 'lib_product_subcategories.company_id')
                ->join('lib_product_categories', 'lib_product_subcategories.category_id', '=', 'lib_product_categories.id')
                ->orderBy('lib_product_subcategories.id', 'ASC')
                ->select(
                    'lib_product_subcategories.id',
                    'lib_product_subcategories.name',
                    'lib_product_subcategories.status',
                    'lib_product_categories.name as parent_category',
                    'lib_product_categories.id as parent_category_id',
                    'lib_company.Name as company_name',
                    'lib_company.id as company_id'
                )->get();
                $productSubCatNotForYou = ProductSubCategory::leftJoin('lib_company', 'lib_company.id', '=', 'lib_product_subcategories.company_id')
                ->join('lib_product_categories', 'lib_product_subcategories.category_id', '=', 'lib_product_categories.id')
                ->orderBy('lib_product_subcategories.id', 'ASC')
                ->where(function ($query) use ($hostCompanyId) {
                    $query->whereNull('lib_product_subcategories.company_id')
                          ->orWhereRaw('FIND_IN_SET(?, lib_product_subcategories.company_id) = 0', [$hostCompanyId]);
                })
                ->select(
                    'lib_product_subcategories.id',
                    'lib_product_subcategories.name',
                    'lib_product_subcategories.status',
                    'lib_product_categories.name as parent_category',
                    'lib_product_categories.id as parent_category_id',
                    'lib_company.Name as company_name',
                    'lib_company.id as company_id'
                )->get();
            return view('library.product_management.pro_subcategory.index', compact('companies', 'productCategories', 'productSubCategories','productSubCatNotForYou'));
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
                'pro_sub_cat_id' => 'required',
                'category_id' => 'required',
                'company_id' => 'required',
                'status' => 'required',
            ];

            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\ProductManagement\ProductSubCategoryController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                            
                $productSubCategory = ProductSubCategory::where('id',$attributes['pro_sub_cat_id'])->first();
                if($productSubCategory){
                    if($productSubCategory->company_id == null){                                                              
                        $productSubCategory->company_id = $attributes['company_id'];            
                        $productSubCategory->save();
                        \LogActivity::addToLog('Add productSubCategory ' .  $productSubCategory->name);
                    }else{                                 
                        $existingCompanyIds = $productSubCategory->company_id; 
                        $newCompanyId = getHostInfo()['id'];                                         
                        $existingCompanyIdsArray = explode(",", $existingCompanyIds);
                                        
                        if (!in_array($newCompanyId, $existingCompanyIdsArray)) {
                            $existingCompanyIdsArray[] = $newCompanyId;
                        }
    
                        $mergedCompanyIds = implode(",", array_unique($existingCompanyIdsArray));
                        
                        $productSubCategory->company_id = $mergedCompanyIds;
                        $productSubCategory->save();
                        \LogActivity::addToLog('Add productSubCategory ' . $productSubCategory->name);                                            
                    }
                }else{
                    $productSubCategory = new ProductSubCategory();
                    $productSubCategory->category_id = $attributes['category_id'];             
                    $productSubCategory->name = $attributes['pro_sub_cat_id'];             
                    $productSubCategory->company_id = null;             
                    $productSubCategory->status = $attributes['status'];
                    $productSubCategory->created_by = $userid;
                    $productSubCategory->save();
                    \LogActivity::addToLog('Add productSubCategory ' . $productSubCategory['name']);  
                }
                return redirect()->action('Library\ProductManagement\ProductSubCategoryController@index')->with('success', getNotify(1));
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
                'company_id' => 'required',
                'status' => 'required',
            ];

            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\ProductManagement\ProductSubCategoryController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $productSubCategory = ProductSubCategory::find($id);
                $productSubCategory->name =  $attributes['name'];
                $productSubCategory->category_id =  $attributes['category_id'];
                $productSubCategory->company_id =   $attributes['company_id'];
                $productSubCategory->updated_by =   $userid;
                $productSubCategory->status = $attributes['status'];
                $productSubCategory->update();
                \LogActivity::addToLog('Update productSubCategory ' . $attributes['name']);
                return redirect()->action('Library\ProductManagement\ProductSubCategoryController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        
        if (getAccess('delete')) {
            $productSubCategory = ProductSubCategory::find($id);

            $existingCompanyIds = $productSubCategory->company_id;
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
            
            $productSubCategory->company_id = $mergedCompanyIds;
            $productSubCategory->save();
            
            \LogActivity::addToLog('Delete Ingredient productSubCategory ' . $productSubCategory->name);
            return redirect()->action('Library\ProductManagement\ProductSubCategoryController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
