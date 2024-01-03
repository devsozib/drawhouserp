<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Sentinel;
use App\Models\Library\ProductManagement\Unit;
use Illuminate\Http\Request;
use App\Models\Library\General\Company;
use App\Models\Library\ProductManagement\Product;
use App\Http\Controllers\Controller;
use App\Models\Library\ProductManagement\ProductCategory;
use App\Models\Library\ProductManagement\ProductSubCategory;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index()
    {
        if (getAccess('view')) {
            $hostCompanyId = getHostInfo()['id'];
            $products = Product::join('lib_product_categories', 'lib_product_categories.id', '=', 'lib_products.category_id')
                ->join('lib_company', 'lib_company.id', '=', 'lib_products.company_id')
                ->leftJoin('lib_product_subcategories', 'lib_product_subcategories.id', '=', 'lib_products.sub_category_id')
                ->select(
                    'lib_products.id',
                    'lib_products.sales_type',
                    'lib_products.name',
                    'lib_products.image',
                    'lib_products.status',
                    'lib_company.Name',
                    'lib_products.website_view',
                    'lib_products.chef_special',
                    'lib_products.featured',
                    'lib_products.slider',
                    'lib_product_categories.name as cat_name',
                    'lib_product_subcategories.name as sub_cat_name',
                )
                ->whereRaw('FIND_IN_SET(?, lib_products.company_id)', [getHostInfo()['id']])
                ->orderBy('lib_products.id', 'desc')
                ->get();
            return view('library.product_management.product.index', compact('products'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }


    public function create()
    {
        if (getAccess('create')) {
            $hostCompanyId = getHostInfo()['id'];
            $units = Unit::where('status', '1')->orderBy('id', 'DESC')->get();
            $categories = ProductCategory::whereRaw('FIND_IN_SET(?, lib_product_categories.company_id)', [getHostInfo()['id']])->where('company_id',getHostInfo()['id'])->where('status', '1')->orderBy('id', 'DESC')->get();
            $companies = Company::where('id',getHostInfo()['id'])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $productsNotForYou = Product::join('lib_product_categories', 'lib_product_categories.id', '=', 'lib_products.category_id')
                ->leftJoin('lib_company', 'lib_company.id', '=', 'lib_products.company_id')
                ->leftJoin('lib_product_subcategories', 'lib_product_subcategories.id', '=', 'lib_products.sub_category_id')
                ->select(
                    'lib_products.id',
                    'lib_products.sales_type',
                    'lib_products.name',
                    'lib_products.image',
                    'lib_products.status',
                    'lib_company.Name',
                    'lib_products.website_view',
                    'lib_products.chef_special',
                    'lib_products.featured',
                    'lib_products.slider',
                    'lib_product_categories.name as cat_name',
                    'lib_product_subcategories.name as sub_cat_name',
                )
                ->where(function ($query) use ($hostCompanyId) {
                    $query->whereNull('lib_products.company_id')
                          ->orWhereRaw('FIND_IN_SET(?, lib_products.company_id) = 0', [$hostCompanyId]);
                })
                ->orderBy('lib_products.id', 'desc')
                ->get();
            return view('library.product_management.product.create', compact('units', 'companies', 'categories','productsNotForYou'));
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
                'pro_id' => 'required',
                'company_id' => 'required',
                'pro_category_select' => 'required',
                'pro_sub_category_select' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\ProductManagement\ProductController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                
                $checkPro = Product::where('id',$attributes['pro_id'])->first();
                if($checkPro){
                    if($checkPro->company_id == null){                                                              
                        $checkPro->company_id = $attributes['company_id'];            
                        $checkPro->save();
                        \LogActivity::addToLog('Add Product ' .  $checkPro->name);
                    }else{                                 
                        $existingCompanyIds = $checkPro->company_id; 
                        $newCompanyId = getHostInfo()['id'];                                         
                        $existingCompanyIdsArray = explode(",", $existingCompanyIds);
                                           
                        if (!in_array($newCompanyId, $existingCompanyIdsArray)) {
                            $existingCompanyIdsArray[] = $newCompanyId;
                        }
    
                        $mergedCompanyIds = implode(",", array_unique($existingCompanyIdsArray));
                        
                        $checkPro->company_id = $mergedCompanyIds;
                        $checkPro->save();
                        \LogActivity::addToLog('Add Product ' . $checkPro->name);                    
                        
                    }
                }else{

                    $imageName = "";
                    if ($image = $request->file('image')) {
                        $destinationPath = 'public/product_images/';
                        $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                        $upload_success = $image->move($destinationPath, $imageName);
                        if ($upload_success) {
                            Image::make($destinationPath . $imageName)->resize(320, 240)->save($destinationPath . $imageName);
                        }
                    }else{
                        $imageName = null;
                    }
    
                    $product = new Product;
                    $addProductUniqueId = round(microtime(true) * 1000) . $userid;
                    $product->sales_type = implode(',',$attributes['sales_type']);
                    $product->name = $attributes['name'];
                    $product->unique_id = $addProductUniqueId;
                    $product->company_id = null;
                    $product->category_id = $attributes['pro_category_select'];
                    $product->sub_category_id = $attributes['pro_sub_category_select'];
                    $product->description = $attributes['description'];
                    $product->created_by = $userid;
                    $product->image = $imageName;
                    $product->status = $attributes['status'];
                    $product->save();
                    \LogActivity::addToLog('Add Product ' . $attributes['ing_id']);
                    return redirect()->action('Library\ProductManagement\ProductController@create')->with('success', getNotify(1));
                }                               
                return redirect()->action('Library\ProductManagement\ProductController@index')->with('success', getNotify(1));
        }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }



    public function edit($id)
    {
        if (getAccess('edit')) {
            $id = decrypt($id);
            $companies = Company::where('id',getHostInfo()['id'])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $product = Product::findOrFail($id);
            $categories = ProductCategory::whereRaw('FIND_IN_SET(?, lib_product_categories.company_id)', [getHostInfo()['id']])->where('company_id',getHostInfo()['id'])->where('status', '1')->orderBy('id', 'DESC')->get();
            $cat_id = $product->category_id;
            $subCategories = ProductSubCategory::where('status', '1')->where('category_id', $cat_id)->orderBy('id', 'DESC')->get();
            return view('library.product_management.product.edit', compact('product', 'categories', 'subCategories', 'companies'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }


    public function update(Request $request, $id)
    {
        // return $request->all();
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            $rules = [
                'name' => 'required',
                'pro_category_select' => 'required',
                // 'pro_sub_category_select' => 'required',
                'company_id' => 'required',
                'status' => 'required',
                'sales_type' => 'required',
                // 'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ];
            $product = Product::findOrFail($id);
            $imageName = "";
            if ($image = $request->file('image')) {
                unlink(public_path('product_images/' . $product->image));
                $destinationPath = 'public/product_images/';
                $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageName);
            } else {
                $imageName = $product->image;
            }

            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $product->sales_type = implode(',',$attributes['sales_type']);
                $product->name = $attributes['name'];
                $product->company_id = $attributes['company_id'];
                $product->category_id = $attributes['pro_category_select'];
                $product->sub_category_id = $attributes['pro_sub_category_select']??null;
                $product->description = $attributes['description'];
                $product->updated_by = $userid;
                $product->image = $imageName;
                $product->status = $attributes['status'];
                $product->update();
                \LogActivity::addToLog('Update product ' . $attributes['name']);
                return redirect()->action('Library\ProductManagement\ProductController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        // if (getAccess('delete')) {
        //     $userid = Sentinel::getUser()->id;
        //     $product = Product::findOrFail($id);
        //     // $product->deleted_by =  $userid;
        //     unlink(public_path('product_images/' . $product->image));
        //     $product->delete();
        //     \LogActivity::addToLog('Delete product ' . $product->name);
        //     return redirect()->action('Library\ProductManagement\ProductController@index')->with('success', getNotify(3));
        // } else {
        //     return redirect()->back()->with('warning', getNotify(5));
        // }

        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;

            $product = Product::find($id);

            $existingCompanyIds = $product->company_id;
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
            
            $product->company_id = $mergedCompanyIds;
            $product->save();
            
            \LogActivity::addToLog('Delete product Category ' . $product->name);
            return redirect()->action('Library\ProductManagement\ProductController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getProducts()
    {
        // $products =
    }
}
