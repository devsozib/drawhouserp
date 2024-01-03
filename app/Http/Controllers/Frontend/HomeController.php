<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Library\ProductManagement\Product;
use App\Models\Library\ProductManagement\ProductAdon;
use App\Models\Library\ProductManagement\ProductSize;
use App\Models\Library\ProductManagement\ProductOption;
use App\Models\Library\ProductManagement\ProOptionTitle;
use App\Models\Library\General\LibCustomerAddress;
use App\Models\Library\ProductManagement\ProductCategory;
use App\Models\Library\ProductManagement\ProductSubCategory;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
            ->select(
                'lib_products.*',
                'lib_product_categories.name as cat_name',
                'lib_product_subcategories.name as sub_cat_name',
                'lib_product_sizes.selling_price',
            )
            ->get();
        return view('frontend.index', compact('chefSpecials', 'features', 'sliders'));
    }

    public function productDetails($id)
    {
        $id = decrypt($id);
        $product = Product::findOrFail($id);
        $productSizes = ProductSize::where('product_id', $product->id)->get();
        $productTitle = ProOptionTitle::where('product_id', $product->id)->get();

         $optionsByProductId = DB::table('lib_product_options')
            ->join('lib_product_option_titles', 'lib_product_option_titles.id', '=', 'lib_product_options.option_title_id')
            ->where('lib_product_options.product_id', $id)
            ->select('lib_product_option_titles.title','lib_product_option_titles.option_type',  'lib_product_options.name','lib_product_options.image','lib_product_options.extra_price','lib_product_options.id','lib_product_options.offer_price','lib_product_options.offer_money_from','lib_product_options.offer_money_to')
            ->where('lib_product_options.status','1')
            ->get();
        $productOptions = array();
        foreach($optionsByProductId as $row){
            $productOptions[$row->title][] = $row;
        }

        $productAddons = ProductAdon::where('product_id',$id)->where('status','1')->get();



        return view('frontend.product_details', compact('product', 'productSizes','productOptions','productAddons','id'));
    }

    public function addToCart(Request $request){
        $cartItem = [
            "productId" => $request->input('productId'),
            "productSizeId" => $request->input('productSizeId'),
            "productOptionIds" => $request->input('productOptionIds'),
            "productAddonIds" => $request->input('productAddonIds'),
            "productQuantity" => $request->productQuntity,
        ];

        // Retrieve the current cart from the session or create an empty cart if it doesn't exist
        $cart = Session::get('cart', []);

        // Generate a unique identifier for the cart item
        $uniqueIdentifier = md5(serialize($cartItem));

        // Store the cart item in the cart session using the unique identifier as the key
        $cart[$uniqueIdentifier] = $cartItem;

        // Update the cart session
        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Item added to cart successfully');
    }

    public function removeToCart(Request $request){
       // Retrieve data from the AJAX request
    $productId = $request->input('productId');
    $productSizeId = $request->input('productSizeId');
    $productOptionIds = $request->input('productOptionIds');
    $productAddonIds = $request->input('productAddonIds');
    $key = $request->input('key');

    // Retrieve the current cart data from the session
    $cartData = Session::get('cart', []);
    unset($cartData[$key]);

    // Update the cart data in the session
    Session::put('cart', $cartData);

    // Return a success response or updated cart section
    return response()->json(['message' => 'Item removed from cart']);
        }

 public function updateQty(Request $request){
    // return $request;
     // Get the cart item key and new quantity from the request
     $cartItemKey = $request->input('cartkey');
     $newQuantity = $request->input('productQuantity');

     // Retrieve the current cart data from the session
     $cartData = session('cart', []);

     // Check if the cart item exists in the cart data
     if (array_key_exists($cartItemKey, $cartData)) {
         // Update the quantity for the specific item
         $cartData[$cartItemKey]['productQuantity'] = $newQuantity;

         // Save the updated cart data back into the session
         session(['cart' => $cartData]);

         // Return a response indicating success
         return response()->json(['message' => 'Quantity updated successfully'], 200);
     }

     // Return a response indicating failure (e.g., item not found in cart)
     return response()->json(['message' => 'Item not found in cart'], 404);
 }

 public function cart(){

    return view('frontend.cart');
 }

 public function checkout() {
    // return cartItems();
    $customer_id = 0;
    if(Auth::guard('customer')->check())
        $customer_id = Auth::guard('customer')->user()->id;

   $customerAddresses = LibCustomerAddress::where('customer_id', $customer_id )->where('status',1)->get();

   return view('frontend.checkout' , compact('customerAddresses'));
 }

 public function menu($id = null, $subcat = null){
    $categories = ProductCategory::where('status', '1')->get();
    $subcategories = [];
    $products = Product::join('lib_product_categories', 'lib_product_categories.id', '=', 'lib_products.category_id')
        ->join('lib_company', 'lib_company.id', '=', 'lib_products.company_id')
        ->leftJoin('lib_product_subcategories', 'lib_product_subcategories.id', '=', 'lib_products.sub_category_id')
        ->leftJoin('lib_product_sizes', 'lib_product_sizes.product_id', '=', 'lib_products.id')
        ->where('lib_products.website_view', '1')
        ->where('lib_products.status', '1');

    if ($id !== null && $subcat==null) {
        $products->where('lib_products.category_id', $id);
        $subcategories = ProductSubCategory::where('category_id', $id)->get();
    }
    if($id !== null && $subcat!==null){
        $products->where('lib_products.category_id', $id)->where('sub_category_id',$subcat);
        $subcategories = ProductSubCategory::where('category_id', $id)->get();
    }
    $products = $products->select(
            'lib_products.*',
            'lib_product_categories.name as cat_name',
            'lib_product_subcategories.name as sub_cat_name',
            'lib_product_sizes.selling_price'
        )
        ->orderBy('lib_products.id', 'desc')
        ->distinct('lib_products.id')
        ->get();

    return view('frontend.menu', compact('categories', 'products', 'subcategories', 'id','subcat'));
 }

}
