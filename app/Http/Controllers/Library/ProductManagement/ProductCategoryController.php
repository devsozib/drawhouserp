<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Illuminate\Http\Request;
use App\Models\Library\General\Company;
use App\Http\Controllers\Controller;
use App\Models\Library\ProductManagement\ProductCategory;
use Illuminate\Support\Facades\Validator;
use Sentinel;

class ProductCategoryController extends Controller
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
            $companies = Company::where('id',getHostInfo()['id'])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $productCategories = ProductCategory::join('lib_company', 'lib_company.id', '=', 'lib_product_categories.company_id')->orderBy('lib_product_categories.id', 'ASC')
            ->whereRaw('FIND_IN_SET(?, lib_product_categories.company_id)', [getHostInfo()['id']])
            ->select('lib_product_categories.id', 'lib_product_categories.name', 'lib_company.Name as company_name', 'lib_product_categories.status', 'lib_company.id as company_id')->get();
            $productCatNotForYou = ProductCategory::leftJoin('lib_company', 'lib_company.id', '=', 'lib_product_categories.company_id')->orderBy('lib_product_categories.id', 'ASC')
            ->where(function ($query) use ($hostCompanyId) {
                $query->whereNull('lib_product_categories.company_id')
                      ->orWhereRaw('FIND_IN_SET(?, lib_product_categories.company_id) = 0', [$hostCompanyId]);
            })
            ->select('lib_product_categories.id', 'lib_product_categories.name', 'lib_company.Name as company_name', 'lib_product_categories.status', 'lib_company.id as company_id')->get();
            return view('library.product_management.pro_category.index', compact('companies', 'productCategories','productCatNotForYou'));
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
                'pro_cat_id' => 'required',
                'company_id' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\ProductManagement\productCategoryController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                
                $checkProductCategory = ProductCategory::where('id',$attributes['pro_cat_id'])->first();
                if($checkProductCategory){
                    if($checkProductCategory->company_id == null){                                                              
                        $checkProductCategory->company_id = $attributes['company_id'];            
                        $checkProductCategory->save();
                        \LogActivity::addToLog('Add ProductCategory ' .  $checkProductCategory->name);
                    }else{                                 
                        $existingCompanyIds = $checkProductCategory->company_id; 
                        $newCompanyId = getHostInfo()['id'];                                         
                        $existingCompanyIdsArray = explode(",", $existingCompanyIds);
                                           
                        if (!in_array($newCompanyId, $existingCompanyIdsArray)) {
                            $existingCompanyIdsArray[] = $newCompanyId;
                        }
    
                        $mergedCompanyIds = implode(",", array_unique($existingCompanyIdsArray));
                        
                        $checkProductCategory->company_id = $mergedCompanyIds;
                        $checkProductCategory->save();
                        \LogActivity::addToLog('Add ProductCategory ' . $checkProductCategory->name);                    
                        
                    }
                }else{
                    $productCategory = new ProductCategory();
                    $productCategory->name = $attributes['pro_cat_id'];             
                    $productCategory->company_id = null;             
                    $productCategory->status = $attributes['status'];
                    $productCategory->created_by = $userid;
                    $productCategory->save();
                    \LogActivity::addToLog('Update ProductCategory ' . $productCategory['name']);  
                }
               
                
                return redirect()->action('Library\ProductManagement\ProductCategoryController@index')->with('success', getNotify(1));
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
                return redirect()->action('Library\ProductManagement\ProductCategoryController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $ingredientCategory = ProductCategory::find($id);
                $ingredientCategory->name = $attributes['name'];              
                $ingredientCategory->status = $attributes['status'];
                $ingredientCategory->updated_by = $userid;
                $ingredientCategory->update();
                \LogActivity::addToLog('Update productCategory ' . $attributes['name']);
                return redirect()->action('Library\ProductManagement\ProductCategoryController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }


    public function destroy($id)
    {
         if (getAccess('delete')) {
            $productCategory = ProductCategory::find($id);

            $existingCompanyIds = $productCategory->company_id;
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
            
            $productCategory->company_id = $mergedCompanyIds;
            $productCategory->save();
            
            \LogActivity::addToLog('Delete product Category ' . $productCategory->name);
            return redirect()->action('Library\ProductManagement\ProductCategoryController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
