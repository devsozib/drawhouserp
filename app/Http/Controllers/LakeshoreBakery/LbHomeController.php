<?php

namespace App\Http\Controllers\LakeshoreBakery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Library\ProductManagement\Product;

class LbHomeController extends Controller
{
    public function index()
    {
        // return View('map');

        $chefSpecials = Product::join('lib_product_categories', 'lib_product_categories.id', '=', 'lib_products.category_id')
            ->join('lib_company', 'lib_company.id', '=', 'lib_products.company_id')
            ->leftJoin('lib_product_subcategories', 'lib_product_subcategories.id', '=', 'lib_products.sub_category_id')
            ->leftJoin('lib_product_sizes', 'lib_product_sizes.product_id', '=', 'lib_products.id')
            ->where('lib_products.chef_special', '1')
            ->where('lib_products.website_view', '1')
            ->whereRaw('FIND_IN_SET(?, lib_products.company_id)', [2])
            ->select(
                'lib_products.*',
                'lib_product_categories.name as cat_name',
                'lib_product_subcategories.name as sub_cat_name',
                'lib_product_sizes.selling_price',
            )
            ->distinct('lib_products.id')
            ->get();
        $features = Product::join('lib_product_categories', 'lib_product_categories.id', '=', 'lib_products.category_id')
            ->join('lib_company', 'lib_company.id', '=', 'lib_products.company_id')
            ->leftJoin('lib_product_subcategories', 'lib_product_subcategories.id', '=', 'lib_products.sub_category_id')
            ->leftJoin('lib_product_sizes', 'lib_product_sizes.product_id', '=', 'lib_products.id')
            ->where('lib_products.featured', '1')
            ->where('lib_products.website_view', '1')
            ->whereRaw('FIND_IN_SET(?, lib_products.company_id)', [2])
            ->select(
                'lib_products.*',
                'lib_product_categories.name as cat_name',
                'lib_product_subcategories.name as sub_cat_name',
                'lib_product_sizes.selling_price',
            )
            ->get();
        $sliders = Product::join('lib_product_categories', 'lib_product_categories.id', '=', 'lib_products.category_id')
            ->join('lib_company', 'lib_company.id', '=', 'lib_products.company_id')
            ->leftJoin('lib_product_subcategories', 'lib_product_subcategories.id', '=', 'lib_products.sub_category_id')
            ->leftJoin('lib_product_sizes', 'lib_product_sizes.product_id', '=', 'lib_products.id')
            ->where('lib_products.slider', '1')
            ->where('lib_products.website_view', '1')
            ->whereRaw('FIND_IN_SET(?, lib_products.company_id)', [2])
            ->select(
                'lib_products.*',
                'lib_product_categories.name as cat_name',
                'lib_product_subcategories.name as sub_cat_name',
                'lib_product_sizes.selling_price',
            )
            ->get();
        return view('lakeshore_bakery.index', compact('chefSpecials', 'features', 'sliders'));
    }

    public function productDetails($id){

        return view('lakeshore_bakery.product-details');
    } 
}
