<?php

namespace App\Http\Controllers;

use DB;
use Sentinel;
use App\Models\Menus;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\HRIS\Setup\Notes;
use App\Models\HRIS\Setup\NoteTag;
use Illuminate\Support\Facades\App;
use App\Models\Library\General\Room;
use Illuminate\Support\Facades\File;
use App\Models\HRIS\Setup\Department;
use App\Models\Library\General\Table;
use Intervention\Image\Facades\Image;
use App\Models\HRIS\Database\EmpEntry;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\Designation;
use App\Models\HRIS\Setup\JobAppraisal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Models\Frontend\Order\OrderItem;
use App\Models\Library\General\Customer;
use App\Models\Frontend\Order\OrderProcess;
use App\Models\Attendance\AttendanceApproval;
use App\Models\Library\General\PaymentMethod;
use App\Models\HRIS\Setup\TrainingParticipant;
use App\Models\Inventory\Procurement\Inventory;
use App\Models\Library\General\CustomerDiscount;
use App\Models\Library\general\DiscountCategory;
use App\Models\HRIS\Database\EmployeePerformance;
use App\Models\Library\ProductManagement\Product;
use App\Models\Inventory\Procurement\PurchaseMain;
use App\Models\Library\General\LibCustomerAddress;
use App\Models\Library\ProductManagement\Ingredient;
use App\Models\Library\ProductManagement\ProductIng;
use App\Models\Inventory\Procurement\RequisitionItem;
use App\Models\Inventory\Procurement\RequisitionMain;
use App\Models\Library\ProductManagement\ProductAdon;
use App\Models\Library\ProductManagement\ProductSize;
use App\Models\Inventory\Procurement\PurchaseOrderItem;
use App\Models\Library\ProductManagement\ProductOption;
use App\Models\HRIS\Database\EmployeePerformanceDetails;
use App\Models\HRIS\Setup\MeetingParticipant;
use App\Models\Library\ProductManagement\ProductAdonIng;
use App\Models\Library\ProductManagement\ProductOptnIng;
use App\Models\Library\ProductManagement\ProOptionTitle;
use App\Models\Library\ProductManagement\SubCatAddonIng;
use App\Models\Library\ProductManagement\ProductCategory;
use App\Models\Library\ProductManagement\IngredientCategory;
use App\Models\Library\ProductManagement\ProductSubCategory;
use App\Models\Library\ProductManagement\IngredientSubCategory;

class HelpersController extends Controller
{
    public function getMenus(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $result = Menus::orderBy('id', 'ASC')->where('ModuleID', $request->module_id)->where('Childable', 'Y')->where('C4S', 'Y')->pluck('Name', 'id');
            return response()->json($result);
        }
    }

    public function getSubCatIng(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $hostCompanyId = getHostInfo()['id'];
            $id =  $request->in_category_id;
            $subCategories = IngredientSubCategory::whereRaw('FIND_IN_SET(?, lib_ing_subcategories.company_id)', $hostCompanyId)->where('category_id', $id)->orderBy('id', 'DESC')->get();
            return response()->json($subCategories);
        }
    }

    public function getSubCatPro(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $id =  $request->pro_category_id;
            $subCategories = ProductSubCategory::where('category_id', $id)->orderBy('id', 'DESC')->get();
            return response()->json($subCategories);
        }
    }

    public function getSubCatAddonIng(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $addonId = $request->selectedAddonId;
            $ingredients = Ingredient::join('lib_units', 'lib_units.id', '=', 'lib_ingredients.unit_id')
                ->select('lib_ingredients.name', 'lib_ingredients.id', 'lib_units.name as unit_name')
                ->get();
            $adnIngs = SubCatAddonIng::join('lib_ingredients', 'lib_ingredients.id', '=', 'lib_subcatadnings.ing_id')
                ->join('lib_units', 'lib_units.id', '=', 'lib_ingredients.unit_id')
                ->select('lib_ingredients.id', 'lib_subcatadnings.id as adningid', 'lib_ingredients.name', 'lib_units.name as unit_name', 'lib_subcatadnings.amount')
                ->orderBy('lib_subcatadnings.id', 'DESC')
                ->where('lib_subcatadnings.subcat_adn_ing_id', $addonId)->get();

            if (count($adnIngs) > 0) {
                $html = '<thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Ingredient Name</th>
                                <th>Amount </th>
                                <th>Default Weight In</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                        <tbody>';
                $i = 1;
                foreach ($adnIngs as $item) {
                    $html .= '<tr>
                                <td>' . $i . '</td>
                                <td>' . $item->name . '</td>
                                <td>' . $item->amount . '</td>
                                <td>' . $item->unit_name . '</td>
                                <td>' . '<a href="' . route('sca_ing.delete', encrypt($item->adningid)) . '" class="btn-sm bg-gradient-danger"><i
                                class="fas fa-times"></i></a>' . '</td>
                                </tr>';
                    $i++;
                }
                $html .= '</tbody>';
            } else {
                $html = '<thead>
            <tr>
                <th>Sl No</th>
                <th>Ingredient Name</th>
                <th>Amount </th>
                <th>Default Weight In</th>
                <th>Option</th>
            </tr>
            </thead>
        <tbody>';
                $html .= '<tr>
                    <td colspan="7" class="text-center">' . "No Data Available" . '</td>

                    </tr>';

                $html .= '</tbody>';
            }


            return response()->json(
                [
                    $ingredients,
                    $html
                ]

            );
        }
    }

    public function changeWebStatus(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $id = $request->id;
            $type = $request->type;
            $product = Product::find($id);
            if ($type == 'show') {
                $product->website_view = '1';
                $product->update();
                \LogActivity::addToLog('Product Show on website ' . $id);
                return response()->json(['success' => 'Product Show on website']);
            } elseif ($type == 'hide') {
                $product->website_view = '0';
                $product->update();
                \LogActivity::addToLog('Product hide on website ' . $id);
                return response()->json(['success' => 'Product hide on website']);
            } elseif ($type == 'removechef') {
                $product->chef_special = '0';
                $product->update();
                \LogActivity::addToLog('Product Remove from chef special ' . $id);
                return response()->json(['success' => 'Product Remove from chef special']);
            } elseif ($type == 'addchef') {
                $product->chef_special = '1';
                $product->update();
                \LogActivity::addToLog('Product Add to chef special ' . $id);
                return response()->json(['success' => 'Product Add to chef special']);
            } elseif ($type == 'removef') {
                $product->featured = '0';
                $product->update();
                \LogActivity::addToLog('Product remove from featured ' . $id);
                return response()->json(['success' => 'Product remove from featured']);
            } elseif ($type == 'addf') {
                $product->featured = '1';
                $product->update();
                \LogActivity::addToLog('Product Add to featured ' . $id);
                return response()->json(['success' => 'Product Add to featured']);
            } elseif ($type == 'removeformboth') {
                $product->featured = '0';
                $product->chef_special = '0';
                $product->update();
                \LogActivity::addToLog('Product Remove from both ' . $id);
                return response()->json(['success' => 'Product Remove from both']);
            } elseif ($type == 'addtoboth') {
                $product->featured = '1';
                $product->chef_special = '1';
                $product->update();
                \LogActivity::addToLog('Product Remove from both ' . $id);
                return response()->json(['success' => 'Product Remove from both']);
            } elseif ($type == 'removeformslider') {
                $product->slider = '0';
                $product->update();
                \LogActivity::addToLog('Product Remove from slider ' . $id);
                return response()->json(['success' => 'Product Remove from slider']);
            } elseif ($type == 'addtoslider') {
                $product->slider = '1';
                $product->update();
                \LogActivity::addToLog('Product add to slider ' . $id);
                return response()->json(['success' => 'Product add to slider']);
            } else {
                return response()->json(['warning' => 'Something is problem']);
            }
        }
    }

    public function getProductIng(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $sizeId = $request->selectedSizeId;
            $productId = $request->productId;
            $product = Product::where('id', $productId)->first();
            $ingredients = Ingredient::join('lib_units', 'lib_units.id', '=', 'lib_ingredients.unit_id')
                ->select('lib_ingredients.name', 'lib_ingredients.id', 'lib_units.name as unit_name')
                ->where('lib_ingredients.company_id', $product->company_id)
                ->get();
            $proIngredients = ProductIng::join('lib_ingredients', 'lib_ingredients.id', '=', 'lib_product_ingredients.ing_id')
                ->join('lib_units', 'lib_units.id', '=', 'lib_ingredients.unit_id')
                ->select(
                    'lib_ingredients.id',
                    'lib_product_ingredients.id as proingid',
                    'lib_ingredients.name',
                    'lib_units.name as unit_name',
                    'lib_product_ingredients.ing_amount'
                )
                ->orderBy('lib_product_ingredients.id', 'DESC')
                ->where('lib_product_ingredients.product_size_id', $sizeId)
                ->where('lib_product_ingredients.product_id', $productId)
                ->get();

            if (count($proIngredients) > 0) {
                $html = '<thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Ingredient Name</th>
                                <th>Amount </th>
                                <th>Unit</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                        <tbody>';
                $i = 1;
                foreach ($proIngredients as $item) {
                    $html .= '<tr>
                                <td>' . $i . '</td>
                                <td>' . $item->name . '</td>
                                <td>' . $item->ing_amount . '</td>
                                <td>' . $item->unit_name . '</td>
                                <td>' . '<a href="' . route('producting.edit', $item->proingid) . '" class="btn-sm bg-gradient-info" title="Edit"><i
                                class="fas fa-edit"></i></a>' . '<a href="' . route('producting.delete', $item->proingid) . '" class="btn-sm bg-gradient-danger"><i
                                class="fas fa-times"></i></a>' . '</td>
                                </tr>';
                    $i++;
                }
                $html .= '</tbody>';
            } else {
                $html = '<thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Ingredient Name</th>
                        <th>Amount </th>
                        <th>Unit</th>
                        <th>Option</th>
                    </tr>
                    </thead>
                <tbody>';
                $html .= '<tr>
                    <td colspan="7" class="text-center">' . "No Data Available" . '</td>

                    </tr>';

                $html .= '</tbody>';
            }
            return response()->json([$ingredients, $html]);
        }
    }

    public function getProOptnTitle(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $sizeId = $request->selectedSizeId;
            $productId = $request->productId;
            $proIngredients = ProOptionTitle::join('lib_products', 'lib_products.id', '=', 'lib_product_option_titles.product_id')
                ->join('lib_product_sizes', 'lib_product_sizes.id', '=', 'lib_product_option_titles.product_size_id')
                ->select(
                    'lib_product_option_titles.id',
                    'lib_product_option_titles.title',
                    'lib_product_option_titles.status',
                    'lib_products.name',
                    'lib_product_option_titles.option_type',
                    'lib_product_sizes.size_name'
                )
                ->orderBy('lib_product_option_titles.id', 'DESC')
                ->where('lib_product_option_titles.product_size_id', $sizeId)
                ->where('lib_product_option_titles.product_id', $productId)
                ->get();

            if (count($proIngredients) > 0) {
                $html = '<thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Product Name</th>
                                <th>Product Size Name</th>
                                <th>Option Title</th>
                                <th>Option Type</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                        <tbody>';
                $i = 1;
                foreach ($proIngredients as $item) {
                    $html .= '<tr>
                                <td>' . $i . '</td>
                                <td>' . $item->name . '</td>
                                <td>' . $item->size_name . '</td>
                                <td>' . $item->title . '</td>
                                <td>' . $item->option_type . '</td>
                                <td>' . ($item->status == '1' ? "Active" : "Inactive") . '</td>
                                <td>' . '<a href="' . route('proopttitle.edit', $item->id) . '" class="btn-sm bg-gradient-info" title="Edit"><i
                                class="fas fa-edit"></i></a>' . '<a href="' . route('proopttitle.delete', $item->id) . '" class="btn-sm bg-gradient-danger"><i
                                class="fas fa-times"></i></a>' . '</td>
                                </tr>';
                    $i++;
                }
                $html .= '</tbody>';
            } else {
                $html = '<thead>
            <tr>
            <th>Sl No</th>
                <th>Product Name</th>
                <th>Product Size Name</th>
                <th>Option Title</th>
                <th>Option Type</th>
                <th>Status</th>
                <th>Option</th>
            </tr>
            </thead>
          <tbody>';
                $html .= '<tr>
                    <td colspan="7" class="text-center">' . "No Data Available" . '</td>

                    </tr>';

                $html .= '</tbody>';
            }
            return response()->json(
                [
                    $html

                ]

            );
        }
    }


    public function getProOptionTitle(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $sizeId = $request->selectedSizeId;
            $productId = $request->productId;
            $optionTitles = ProOptionTitle::where('product_id', $productId)->where('product_size_id', $sizeId)->get();

            return response()->json(
                [
                    $optionTitles,
                ]

            );
        }
    }
    public function getProOptions(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $productId = $request->productId;
            $option_title_id = $request->option_title_id;
            $proOptions = ProductOption::join('lib_product_option_titles', 'lib_product_option_titles.id', '=', 'lib_product_options.option_title_id')
                ->select(
                    'lib_product_options.id',
                    'lib_product_options.name',
                    'lib_product_options.image',
                    'lib_product_options.extra_price',
                    'lib_product_options.offer_price',
                    'lib_product_options.offer_money_from',
                    'lib_product_options.offer_money_to',
                    'lib_product_option_titles.title',
                    'lib_product_options.status',
                )
                ->orderBy('lib_product_options.id', 'DESC')
                ->where('lib_product_options.option_title_id', $option_title_id)
                ->where('lib_product_options.product_id', $productId)
                ->get();

            if (count($proOptions) > 0) {
                $html = '<thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Image</th>
                            <th>Option Name</th>
                            <th>Title Name</th>
                            <th>Extra Price</th>
                            <th>Offer Price</th>
                            <th>Offer Price Starts</th>
                            <th>Offer Price Ends</th>
                            <th>Status</th>
                            <th>Option</th>
                        </tr>
                            </thead>
                        <tbody>';
                $i = 1;
                foreach ($proOptions as $item) {
                    $html .= '<tr>
                <td>' . $i . '</td>
                <td><img style="width:100px" src="' . url('public/option_images', $item->image) . '"></td>
                <td>' . $item->name . '</td>
                <td>' . $item->title . '</td>
                <td>' . ($item->extra_price ? $item->extra_price : '0') . '</td>
                <td>' . ($item->offer_price ? $item->offer_price : '0') . '</td>
                <td>' . ($item->offer_money_from ? $item->offer_money_from : '0') . '</td>
                <td>' . ($item->offer_money_to ? $item->offer_money_to : '0') . '</td>
                <td>' . ($item->status == '1' ? "Active" : "Inactive") . '</td>
                <td>
                    <a href="' . route('prooption.edit', $item->id) . '" class="btn-sm bg-gradient-info" title="Edit"><i class="fas fa-edit"></i></a>
                    <a href="' . route('prooption.delete', $item->id) . '" class="btn-sm bg-gradient-danger"><i class="fas fa-times"></i></a>
                </td>
            </tr>';
                    $i++;
                }
                $html .= '</tbody>';
            } else {
                $html = '<thead>
            <tr>
                <tr>
                    <th>Sl No</th>
                    <th>Image</th>
                    <th>Option Name</th>
                    <th>Title Name</th>
                    <th>Extra Price</th>
                    <th>Offer Price</th>
                    <th>Offer Price Starts</th>
                    <th>Offer Price Ends</th>
                    <th>Status</th>
                    <th>Option</th>
                </tr>
            </tr>
            </thead>
          <tbody>';
                $html .= '<tr>
                    <td colspan="11" class="text-center">' . "No Data Available" . '</td>

                    </tr>';

                $html .= '</tbody>';
            }

            return response()->json(
                [
                    $html,
                ]

            );
        }
    }
    public function getProOptionIngData(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $sizeId = $request->selectedSizeId;
            $productId = $request->productId;
            $optionTitles = ProOptionTitle::where('product_id', $productId)->where('product_size_id', $sizeId)->get();
            $proOptions = ProductOption::where('product_id', $productId)->where('product_size_id', $sizeId)->get();
            $ingredients = Ingredient::join('lib_units', 'lib_units.id', '=', 'lib_ingredients.unit_id')
                ->select('lib_ingredients.name', 'lib_ingredients.id', 'lib_units.name as unit_name')
                ->get();

            $proOptionIngredients = ProductOptnIng::join('lib_ingredients', 'lib_ingredients.id', '=', 'lib_product_option_ings.ing_id')
                ->join('lib_units', 'lib_units.id', '=', 'lib_ingredients.unit_id')
                ->select(
                    'lib_ingredients.id',
                    'lib_product_option_ings.id as prooptioningid',
                    'lib_ingredients.name',
                    'lib_units.name as unit_name',
                    'lib_product_option_ings.amount'
                )
                ->orderBy('lib_product_option_ings.id', 'DESC')
                ->where('lib_product_option_ings.product_size_id', $sizeId)
                ->where('lib_product_option_ings.product_id', $productId)
                ->get();

            if (count($proOptionIngredients) > 0) {
                $html = '<thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Ingredient Name</th>
                                <th>Amount </th>
                                <th>Unit</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                        <tbody>';
                $i = 1;
                foreach ($proOptionIngredients as $item) {
                    $html .= '<tr>
                                <td>' . $i . '</td>
                                <td>' . $item->name . '</td>
                                <td>' . $item->amount . '</td>
                                <td>' . $item->unit_name . '</td>
                                <td>' . '<a href="' . route('prooptioning.edit', $item->prooptioningid) . '" class="btn-sm bg-gradient-info" title="Edit"><i
                                class="fas fa-edit"></i></a>' . '<a href="' . route('prooptioning.delete', $item->prooptioningid) . '" class="btn-sm bg-gradient-danger"><i
                                class="fas fa-times"></i></a>' . '</td>
                                </tr>';
                    $i++;
                }
                $html .= '</tbody>';
            } else {
                $html = '<thead>
            <tr>
                <th>Sl No</th>
                <th>Ingredient Name</th>
                <th>Amount </th>
                <th>Unit</th>
                <th>Option</th>
            </tr>
            </thead>
          <tbody>';
                $html .= '<tr>
                    <td colspan="7" class="text-center">' . "No Data Available" . '</td>

                    </tr>';

                $html .= '</tbody>';
            }
            return response()->json(
                [
                    $optionTitles,
                    $proOptions,
                    $ingredients,
                    $html
                ]

            );
        }
    }

    public function productAddonIng(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $addonId = $request->selectedAddonId;
            $ingredients = Ingredient::join('lib_units', 'lib_units.id', '=', 'lib_ingredients.unit_id')
                ->select('lib_ingredients.name', 'lib_ingredients.id', 'lib_units.name as unit_name')
                ->get();
            $adnIngs = ProductAdonIng::join('lib_ingredients', 'lib_ingredients.id', '=', 'lib_product_addon_ings.ing_id')
                ->join('lib_units', 'lib_units.id', '=', 'lib_ingredients.unit_id')
                ->select('lib_ingredients.id', 'lib_product_addon_ings.id as adningid', 'lib_ingredients.name', 'lib_units.name as unit_name', 'lib_product_addon_ings.amount')
                ->orderBy('lib_product_addon_ings.id', 'DESC')
                ->where('lib_product_addon_ings.pro_adn_id', $addonId)->get();

            if (count($adnIngs) > 0) {
                $html = '<thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Ingredient Name</th>
                            <th>Amount </th>
                            <th>Default Weight In</th>
                            <th>Option</th>
                        </tr>
                        </thead>
                    <tbody>';
                $i = 1;
                foreach ($adnIngs as $item) {
                    $html .= '<tr>
                            <td>' . $i . '</td>
                            <td>' . $item->name . '</td>
                            <td>' . $item->amount . '</td>
                            <td>' . $item->unit_name . '</td>
                            <td>' . '<a href="' . route('proaddoning.delete', $item->adningid) . '" class="btn-sm bg-gradient-danger"><i
                            class="fas fa-times"></i></a>' . '</td>
                            </tr>';
                    $i++;
                }
                $html .= '</tbody>';
            } else {
                $html = '<thead>
        <tr>
            <th>Sl No</th>
            <th>Ingredient Name</th>
            <th>Amount </th>
            <th>Default Weight In</th>
            <th>Option</th>
        </tr>
        </thead>
      <tbody>';
                $html .= '<tr>
                <td colspan="7" class="text-center">' . "No Data Available" . '</td>

                </tr>';

                $html .= '</tbody>';
            }


            return response()->json(
                [
                    $ingredients,
                    $html
                ]

            );
        }
    }

    public function getIngredient(Request $request)
    {
        if (Sentinel::getUser()->id) {
            //$result = Ingredient::orderBy('id', 'ASC')->where('company_id', $request->company_id)->where('status', '1')->pluck('name', 'id');
            /* $result = DB::table('lib_ingredients as ing')->orderBy('ing.id', 'ASC')->where('ing.company_id', $request->company_id)->where('ing.status','1')
            ->leftJoin('lib_units', 'lib_units.id', '=', 'ing.unit_id')
            ->select(DB::raw("CONCAT(ing.name,' (',lib_units.name,')') as full_name, ing.id"))->pluck('full_name', 'id'); */
            $result = DB::table('lib_ingredients as ing')
                ->leftJoin('lib_units', 'lib_units.id', '=', 'ing.unit_id')
                ->orderBy('ing.id', 'ASC')->where('ing.company_id', $request->company_id)
                ->select('ing.id', 'ing.name', 'lib_units.name as unit_name')->get();
            return response()->json($result);
        }
    }

    public function getAsset(Request $request)
    {
        if (Sentinel::getUser()->id) {
            //$result = Ingredient::orderBy('id', 'ASC')->where('company_id', $request->company_id)->where('status', '1')->pluck('name', 'id');
            /* $result = DB::table('lib_ingredients as ing')->orderBy('ing.id', 'ASC')->where('ing.company_id', $request->company_id)->where('ing.status','1')
            ->leftJoin('lib_units', 'lib_units.id', '=', 'ing.unit_id')
            ->select(DB::raw("CONCAT(ing.name,' (',lib_units.name,')') as full_name, ing.id"))->pluck('full_name', 'id'); */
            $result = DB::table('lib_asset_list as asset')
                ->leftJoin('lib_units', 'lib_units.id', '=', 'asset.unit_id')
                ->orderBy('asset.id', 'ASC')->where('asset.company_id', $request->company_id)
                ->select('asset.id', 'asset.name', 'lib_units.name as unit_name')->get();
            return response()->json($result);
        }
    }

    public function  getUnit(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $id =  $request->ing_id;
            $result = DB::table('lib_ingredients as ing')
                ->leftJoin('lib_units', 'lib_units.id', '=', 'ing.unit_id')
                ->where('ing.id', $id)
                ->select('ing.id', 'ing.name', 'lib_units.name as unit_name')->first();

            return response()->json($result);
        }
    }

    public function  getRequisition(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $id =  $request->company;
            $result = DB::table('inv_proc_requisition_main')
                ->whereIn('id', function ($query) {
                    $query->select('req_id')
                        ->from('inv_requisition_items');
                })
                ->where(function ($query) {
                    $query->where('inv_proc_requisition_main.status', '1')
                        ->whereNot('inv_proc_requisition_main.status', '3');
                })
                ->orWhere('inv_proc_requisition_main.status', '2')
                ->where('inv_proc_requisition_main.company_id', $id)
                ->orderBy('inv_proc_requisition_main.requisition_date', 'DESC')
                ->get();
            foreach ($result as $key => $item) {
                $item->req_date = \Carbon\Carbon::parse($item->requisition_date)->isoFormat('MMM Do YYYY');
                $result[$key] = $item;
            }
            return response()->json($result);
        }
    }

    public function getPurhaseId(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $id =  $request->company;
            $result = DB::table('inv_proc_isspurch_main')
                ->whereIn('id', function ($query) {
                    $query->select('purch_id')
                        ->from('inv_purchaseorder_items');
                })
                ->where('inv_proc_isspurch_main.company_id', $id)
                ->orderBy('po_date', 'desc')
                ->get();
            foreach ($result as $key => $item) {
                $item->po_date = \Carbon\Carbon::parse($item->po_date)->isoFormat('MMM Do YYYY');
                $result[$key] = $item;
            }
            return response()->json($result);
        }
    }

    public function getPurhaseItemInfo(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $id = $request->id;
            $itemInfo = DB::table('inv_purchaseorder_items as purchItems')
                ->join('lib_ingredients as ing', 'ing.id', '=', 'purchItems.ing_id')
                ->join('users', 'users.id', '=', 'purchItems.created_by')
                ->leftJoin('lib_units', 'lib_units.id', '=', 'ing.unit_id')
                ->where('purchItems.id', $id)
                ->select('purchItems.*', 'ing.name', 'lib_units.name as unit_name', 'users.first_name as f_name', 'users.last_name as l_name')->first();
            return response()->json($itemInfo);
        }
    }

    public function gateCheckPurchId(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $id =  $request->company;
            $result = DB::table('inv_proc_isspurch_main')
                ->whereIn('id', function ($query) {
                    $query->select('purch_id')
                        ->from('inv_purchaseorder_items')
                        ->where('gate_rcv_qty', '>', 0);
                })
                ->orderBy('po_date', 'desc')
                ->where('inv_proc_isspurch_main.company_id', $id)
                ->get();
            foreach ($result as $key => $item) {
                $item->po_date = \Carbon\Carbon::parse($item->po_date)->isoFormat('MMM Do YYYY');
                $result[$key] = $item;
            }
            return response()->json($result);
        }
    }

    public function getCategory(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $id = $request->company_id;
            $category = IngredientCategory::whereRaw('FIND_IN_SET(?, lib_ing_categories.company_id)', [getHostInfo()['id']])->where('status', '1')->get();
            return response()->json($category);
        }
    }

    public function updateApplicant(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $userid = Sentinel::getUser()->id;
            $empEntry = EmpEntry::where('id', $request->id)->first();
            $empEntry->status = $request->status;
            $empEntry->updatedBy = $userid;
            $empEntry->update();
            \LogActivity::addToLog('Update Applicant ' . $request->id);
            return response()->json(['success', 'Update Success']);
        }
    }

    public function assignInterviewer(Request $request)
    {
        // return $request;
        if (Sentinel::getUser()->id) {
            $userid = Sentinel::getUser()->id;
            $user = intval($request->user);
            $emp_id = intval($request->emp_id);
            $type = $request->type;
            $empEntry  = EmpEntry::where('id', $emp_id)->first();
            if ($type == 'first') {
                $empEntry->first_interviewer = $user;
                $empEntry->updatedBy =  $userid;
                $empEntry->update();
            } elseif ($type == 'second') {
                $empEntry->second_interviewer = $user;
                $empEntry->updatedBy =  $userid;
                $empEntry->update();
                \LogActivity::addToLog('Update Applicant ' . $request->id);
            } else {
                $empEntry->third_interviewer = $user;
                $empEntry->updatedBy =  $userid;
                $empEntry->update();
            }

            \LogActivity::addToLog('Update Applicant ' . $request->id . ' type ' . $type);
            return response()->json(['success', 'Update Success']);
        }
    }

    public function empAndJobAppraisal(Request $request)
    {

        if (Sentinel::getUser()->id) {
            $id = $request->deparmentId;
            if ($id == '1') {
                $emps = Employee::where('company_id', getHostInfo()['id'])->where('C4S', 'Y')->get();
            } else {
                $emps = Employee::where('company_id', getHostInfo()['id'])->where('DepartmentID', $id)->where('C4S', 'Y')->get();
            }
            $appraisals2 = JobAppraisal::where('department', $id)->where('part', '2')->get();
            $appraisals1 = JobAppraisal::where('part', '1')->get();
            $html1 = '<h5 class="mt-2"><strong>Part 1: General Work Habits and Attitude</strong></h5>';
            foreach ($appraisals1 as $index => $item) {
                $html1 .= '<div class="row">
                <div class="col-md-4 mt-2">
                    <label>' . $item->name . '</label>
                </div>
                <div class="col-md-8">
                    <div class="rating">
                        <input type="hidden" name="rating-' . $item->id . '" class="rating-input" value="">
                        <span class="star" data-value="1">&#9733;</span>
                        <span class="star" data-value="2">&#9733;</span>
                        <span class="star" data-value="3">&#9733;</span>
                        <span class="star" data-value="4">&#9733;</span>
                        <span class="star" data-value="5">&#9733;</span>
                    </div>
                </div>
            </div>';
            }
            $html2 = '<h5><strong>Part 2: Job Performance</strong></h5>';
            foreach ($appraisals2 as $index => $item) {
                $html2 .= '<div class="row">
                <div class="col-md-4 mt-2">
                    <label>' . $item->name . '</label>
                </div>
                <div class="col-md-8">
                    <div class="rating">
                        <input type="hidden" name="rating-' . $item->id . '" class="rating-input" value="">
                        <span class="star" data-value="1">&#9733;</span>
                        <span class="star" data-value="2">&#9733;</span>
                        <span class="star" data-value="3">&#9733;</span>
                        <span class="star" data-value="4">&#9733;</span>
                        <span class="star" data-value="5">&#9733;</span>
                    </div>
                </div>
            </div>';
            }
            return response()->json([$emps, $html1, $html2]);
        }
    }
    public function getempinfo(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $emp_id =  $request->emp_id;
            $emp = Employee::leftJoin('hr_database_employee_salary as salary', 'salary.EmployeeID', '=', 'hr_database_employee_basic.EmployeeID')->where('hr_database_employee_basic.EmployeeID', $emp_id)->select('hr_database_employee_basic.EmployeeID', 'salary.GrossSalary')->first();
            $lastPerformance = EmployeePerformance::where('EmployeeID', $emp_id)->orderBy('date', 'desc')->count();
            // $performanceDetails = '';
            // $totalCalulatedPerfomane = '';
            // if ($lastPerformance) {
            //     $performanceDetails = EmployeePerformanceDetails::where('performance_id', $lastPerformance->id)
            //         ->selectRaw('COUNT(*) as total_items, SUM(rating) as total_rating')
            //         ->first();
            //     $totalCalulatedPerfomane = EmployeePerformanceDetails::where('performance_id', $lastPerformance->id)->count();
            // }
            return response()->json([$emp,$lastPerformance]);
        }
    }

    public function getThana(Request $request)
    {
        if (Sentinel::getUser()->id) {
            if ($request->type == 'forForntend') {
                $tahana = DB::table('hr_setup_thanas')->where("DistrictID", $request->dist_id)->get();
                return response()->json($tahana);
            } else {
                $tahana = DB::table('hr_setup_thanas')->where("DistrictID", $request->dist_id)->pluck("Name", "id");
                return response()->json($tahana);
            }
        }
    }

    public function getDepartment(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $departments = Department::where('concern_id', $request->concern_id)->get();
            return response()->json($departments);
        }
    }
    public function getDesignation(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $departments = Designation::where('department_id', $request->department_id)->get();
            return response()->json($departments);
        }
    }

    public function getParticipant(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $deptId =  $request->department_id;
            $employees = Employee::where('DepartmentID', $deptId)->select('EmployeeID', 'Name')->get();
            return response()->json($employees);
        }
    }

    public function attendence(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $tr_id = $request->tr_id;
            $emp_id = $request->emp_id;

            $assignedEmployee = TrainingParticipant::where('training_id', $tr_id)->where('participant_id', $emp_id)->first();
            $message = "";
            if ($assignedEmployee->present == '1') {
                $assignedEmployee->present = '0';
                $assignedEmployee->update();
                $message = "success";
            } else {
                $assignedEmployee->present = '1';
                $assignedEmployee->update();
                $message = "success";
            }

            \LogActivity::addToLog('training attendance ' . $emp_id);
            return response()->json($message);
        }
    }

    public function meetingAttendence(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $meeting_id = $request->meeting_id;
            $emp_id = $request->emp_id;

            $assignedEmployee = MeetingParticipant::where('meeting_id', $meeting_id)->where('participant_id', $emp_id)->first();
            $message = "";
            if ($assignedEmployee->present == '1') {
                $assignedEmployee->present = '0';
                $assignedEmployee->update();
                $message = "success";
            } else {
                $assignedEmployee->present = '1';
                $assignedEmployee->update();
                $message = "success";
            }

            \LogActivity::addToLog('meeting attendance ' . $emp_id);
            return response()->json($message);
        }
    }

    public function notifications()
    {
        if (Sentinel::getUser()->id) {
            $data = 5;
            return response()->json($data);
        }
    }

    public function storeNotes(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $userid = Sentinel::getUser()->id;
            $note = new Notes();
            $note->company_id = getHostInfo()['id'];
            $note->user_id = $userid;
            $note->notes = $request->content;
            $note->save();
            $newNote = Notes::find($note->id);

            // Prepare the data to be sent as a JSON response
            $responseData = [
                'id' => $newNote->id,
                'notes' => $newNote->notes,
            ];

            \LogActivity::addToLog('add note');

            return response()->json($responseData);
        }
    }

    public function deleteNotes(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $userid = Sentinel::getUser()->id;
            $id =  $request->query('id');
            $note = Notes::where('id', $id)->where('user_id', $userid)->first();
            $noteTags = NoteTag::where('note_id', $id)->get();
            $note->delete();
            foreach ($noteTags as $noteTag) {
                $noteTag->delete();
            }
            return response()->json('success');
        }
    }

    public function getUsers(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $empid = Sentinel::getUser()->empid;
            $name =  $request->searchTerm;
            $matchedEmployees = Employee::where('name', 'LIKE', "%$name%")->where('company_id', getHostInfo()['id'])->whereNot('EmployeeID', $empid)->get();
            return response()->json($matchedEmployees);
        }
    }

    public function submitSelectedEmployees(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $noteID = $request->input('note_id');
            $selectedEmployees = json_decode($request->input('selected_employees'));
            foreach ($selectedEmployees as $employee) {
                $employeeId = $employee->id;

                // Check if the employee is already tagged on the same note
                $existingTag = NoteTag::where('note_id', $noteID)
                    ->where('emp_id', $employeeId)
                    ->first();

                if (!$existingTag) {
                    // Employee is not already tagged, so save the tag
                    $taggedEmployee = new NoteTag();
                    $taggedEmployee->note_id = $noteID;
                    $taggedEmployee->emp_id = $employeeId;
                    $taggedEmployee->save();

                    \LogActivity::addToLog('tag employee to note');
                }
            }
            return response()->json(['message' => 'Selected employees submitted successfully']);
        }
    }

    public function getProductSizes(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $sizes = ProductSize::where('product_id', $request->productId)->get();
            return response()->json($sizes->toArray());
        }
    }

    public function getProductOptinAndAddon(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $ProductOptions = ProductOption::where('product_size_id', $request->productSizeId)->get();
            $ProductAdon = ProductAdon::where('product_id', $request->productId)->get();
            $ProductOptions = $ProductOptions->toArray();
            $ProductAdon = $ProductAdon->toArray();

            return response()->json(['options' => $ProductOptions, 'addons' => $ProductAdon]);
        }
    }

    public function searchCustomer(Request $request)
    {
        // return $request->all();
        if (Sentinel::getUser()->id) {
            // $customer = Customer::where('status', '1');

            $customer = Customer::leftjoin('lib_customer_discount', function ($join) use ($request) {
                $join->on('lib_customers.id', '=', 'lib_customer_discount.customer_id')
                    ->where('lib_customer_discount.company_id', $request->concern);
            });

            if ($request->phone != "") {
                $customer = $customer->where('lib_customers.phone', 'like', '%' . $request->phone . '%');
            }
            if ($request->name != "") {
                $customer = $customer->Where('lib_customers.name', 'like', '%' . $request->name . '%');
            }
            $customer = $customer->select('lib_customers.*', 'lib_customer_discount.discount_category')->get();

            return response()->json($customer->toArray());
        }
    }

    public function addCustomer(Request $request)
    {
        if (Sentinel::getUser()->id) {
            if (Customer::where('phone', $request->phone)->first()) return "exist";

            $customer = new Customer;
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->save();

            \LogActivity::addToLog('add new customer from POS ' . $request->phone);

            return "added";
        }
    }

    public function getTableAndRooms(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $tables = Table::where('company_id', $request->companyId)->where('status', '1')->get();
            $rooms = Room::where('company_id', $request->companyId)->where('status', '1')->get();

            return response()->json(['tables' => $tables->toArray(), 'rooms' => $rooms->toArray()]);
        }
    }

    public function getServer(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $employees = Employee::where('company_id', $request->companyId)->get();

            return response()->json($employees->toArray());
        }
    }

    public function getCetegory(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $cetegories = ProductCategory::where('company_id', $request->companyId)->get();

            return response()->json($cetegories->toArray());
        }
    }

    public function getProduct(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $products = Product::where('company_id', $request->companyId)
                ->whereRaw("FIND_IN_SET(?, sales_type)", [$request->salesType])
                ->get();
            return response()->json($products->toArray());
        }
    }

    public function addProductToListFromPos(Request $request)
    {
        if (Sentinel::getUser()->id) {

            $data = $request->all();

            $product_list = Session::get('pos_added_product_list') ?? [];

            $keys = [$data['concern'], $data['salesType'], $data['tableOrRoom'], $data['table']];
            $current = &$product_list;
            foreach ($keys as $key) {
                $current = &$current[$key] ?? ($current[$key] = []);
            }
            $current['orderDetails'] ??= [];
            $current['items'] ??= [];
            $items = $current['items'];

            // _print($product_list);

            $flag = true;
            foreach ($items as $key => $item) {
                if ($data['product'] == $item['product'] && $data['size'] == $item['size'] && $data['option'] == $item['option'] && $data['addons'] == $item['addons']) {
                    $items[$key]['quantity'] *= 1;
                    $items[$key]['quantity'] += $data['quantity'] * 1;
                    $flag = false;
                    break;
                }
            }

            if ($flag) array_push($items, $data);
            $product_list[$data['concern']][$data['salesType']][$data['tableOrRoom']][$data['table']]['items'] = $items;
            Session::put('pos_added_product_list', $product_list);

            // return true;
        }
    }

    public function updateTableItemQuantity(Request $request)
    {
        if (Sentinel::getUser()->id) {

            $data = $request->all();
            $product_list  = Session::get('pos_added_product_list') ?? [];
            $keys = [$data['concern'], $data['salesType'], $data['tableOrRoom'], $data['table']];
            $current = &$product_list;
            foreach ($keys as $key) {
                $current = &$current[$key] ?? ($current[$key] = []);
            }
            $current['orderDetails'] ??= [];
            $current['items'] ??= [];
            $items = $current['items'];


            $items[$data['itemIndex']]['quantity'] = $data['quantity'];
            $product_list[$data['concern']][$data['salesType']][$data['tableOrRoom']][$data['table']]['items'] = $items;
            Session::put('pos_added_product_list', $product_list);

            // return true;
        }
    }

    public function removeTableItem(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $data = $request->all();
            $product_list  = Session::get('pos_added_product_list') ?? [];
            $keys = [$data['concern'], $data['salesType'], $data['tableOrRoom'], $data['table']];
            $current = &$product_list;
            foreach ($keys as $key) {
                $current = &$current[$key] ?? ($current[$key] = []);
            }
            $current['orderDetails'] ??= [];
            $current['items'] ??= [];
            $items = $current['items'];


            unset($items[$data['itemIndex']]);
            $product_list[$data['concern']][$data['salesType']][$data['tableOrRoom']][$data['table']]['items'] = $items;
            Session::put('pos_added_product_list', $product_list);
        }
    }

    public function getTableItems(Request $request)
    {
        if (Sentinel::getUser()->id) {

            // return 5/0;
            $data = $request->all();

            $product_list  = Session::get('pos_added_product_list') ?? [];


            $keys = [$data['concern'], $data['salesType'], $data['tableOrRoom'], $data['table']];
            $current = &$product_list;
            foreach ($keys as $key) {
                $current = &$current[$key] ?? ($current[$key] = []);
            }
            $current['orderDetails'] ??= [];
            $current['items'] ??= [];
            $items = $current['items'];
            $orderDetails = $current['orderDetails'];

            // _print($items);

            $isUpdate = false;
            $option_ids = array();
            $addon_ids = array();
            $orderID = null;
            if (isset($orderDetails['unique_id']) && $orderDetails['unique_id'] != "") {
                $isUpdate = true;
                $orderID = $orderDetails['unique_id'];
            }

            foreach ($items as $item) {
                // if (isset($item['unique_order_id']) && $item['unique_order_id'] != "") {
                //     $isUpdate = true;
                //     $orderID = $item['unique_order_id'];
                // }
                $option_ids = array_unique(array_merge($option_ids, explode(',', $item['option'])));
                $addon_ids = array_unique(array_merge($addon_ids, explode(',', $item['addons'])));
            }

            $orderObj = null;

            if ($isUpdate) {
                // $orderObj = OrderProcess::where('unique_order_id', $orderID)->first();
                $orderObj = OrderProcess::join('lib_customers', 'lib_customers.id', '=', 'fr_order_process.client_id')
                    ->leftJoin('lib_customer_addresses', 'lib_customer_addresses.id', '=', 'fr_order_process.delivery_address')
                    ->where('unique_order_id', $orderID)
                    ->select('fr_order_process.*', 'lib_customers.name as client_name', 'lib_customer_addresses.address_label', 'lib_customer_addresses.local_address')
                    ->first();


                if ($orderObj->invoice_status == 1 || $orderObj->order_status == 2) {
                    $items = $addon_ids = $option_ids = [];
                    $isUpdate = false;
                    $product_list[$data['concern']][$data['salesType']][$data['tableOrRoom']][$data['table']]['orderDetails'] = [];
                    $product_list[$data['concern']][$data['salesType']][$data['tableOrRoom']][$data['table']]['items'] = $items;
                    Session::put('pos_added_product_list', $product_list);
                }
            }

            $options = ProductOption::whereIn('id', $option_ids)->get();
            $addons = ProductAdon::whereIn('id', $addon_ids)->get();

            $option_prices = array();
            foreach ($options as $option) {
                $option_prices[$option->id] = getProductOptionPrice($option);
            }

            $addon_prices = array();
            foreach ($addons as $addon) {
                $addon_prices[$addon->id] = getProductAddonPrice($addon);
            }

            $table = $data['table'];
            $tableOrRoom = $data['tableOrRoom'];

            $tables = array();
            if ($tableOrRoom == 1) $tables = lib_table();
            if ($tableOrRoom == 2) $tables = lib_room();
            $products = lib_product();
            $sizes = lib_size();
            if ($data['salesType'] == 1) $prices = lib_price();
            if ($data['salesType'] == 2) $prices = lib_wholesale_price();
            if ($data['salesType'] == 3) $prices = lib_corporate_price();
            $options = lib_option();
            $addons = lib_addon();
            $paymentMethods = PaymentMethod::where('company_id', $data['concern'])->get();
            // $discountCategories = DiscountCategory::where('company_id', $data['concern'])->get();
            $discountCategories = DB::table('lib_discount_category')->where('company_id', $data['concern'])->get();

            // _print($items);

            $html  = (string)view('pos.template.selectedProductList', compact('tables', 'items', 'products', 'sizes', 'prices', 'options', 'addons', 'table', 'paymentMethods', 'option_prices', 'addon_prices', 'isUpdate', 'tableOrRoom', 'discountCategories'));
            return ['order' => $orderObj, 'html' => $html];
        }
    }

    public function getPaymentMethodSelectOption(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $paymentMethods = PaymentMethod::where('company_id', $request->concern)->get();
            $concern = $request->concern;
            $orderId = $request->orderId;
            $itemNumber = $request->itemNumber;
            $paidAmount = $request->paidAmount;

            return view('pos.template.selectOption', compact('paymentMethods', 'concern', 'orderId', 'itemNumber', 'paidAmount'));
        }
    }

    protected function savePosOrder(Request $request)
    {
        // return 5/0;
        // return $request->all();
        // _print($_REQUEST);

        if (Sentinel::getUser()->id) {

            $uniqueOrderId = round(microtime(true) * 1000) . $request->customer;
            $data = $request->all();

            $orderDeliveryAddress = null;
            $IsDelivered =  $request->isDelivered;
            if ($IsDelivered == "true") $IsDelivered = true;
            else if ($IsDelivered == "false") $IsDelivered = false;



            $product_list  = Session::get('pos_added_product_list') ?? [];
            $keys = [$data['concern'], $data['salesType'], $data['tableOrRoom'], $data['table']];
            $current = &$product_list;
            foreach ($keys as $key) {
                $current = &$current[$key] ?? ($current[$key] = []);
            }
            $current['orderDetails'] ??= [];
            $current['items'] ??= [];
            $items = $current['items'];
            $details = $current['orderDetails'];
            // _print($items);

            if ($IsDelivered) {
                $existAddressId = LibCustomerAddress::where('customer_id', $data['customer'])->pluck('id');
                $existAddressId = make_key_value($existAddressId);
                $addressObject = json_decode($request->addressData);

                $tData = [
                    'temp_id' => $addressObject->temp_id,
                    'address_id' => $addressObject->address_id,
                    'address' => $addressObject->address,
                    'address_specification' => $addressObject->address_specification,
                    'address_label' => $addressObject->address_label,
                ];

                $addressData = array();
                for ($i = 0; $i < count($tData['temp_id']); $i++) {
                    $addressData[$tData['temp_id'][$i]] = [
                        'update_id' => $tData['address_id'][$i],
                        'address' => $tData['address'][$i],
                        'specification' => $tData['address_specification'][$i],
                        'label' => $tData['address_label'][$i],
                    ];
                }

                foreach ($addressData as $key => $address) {
                    if ($address['update_id'] != null && $address['update_id'] != "") {
                        unset($existAddressId[$address['update_id']]);

                        $lib_address = LibCustomerAddress::where('id', $address['update_id'])->first();
                        $lib_address->address_label = $address['label'];
                        $lib_address->local_address = $address['address'];
                        $lib_address->address_specification = $address['specification'];
                        $lib_address->update();
                        \LogActivity::addToLog('Update customer address from POS ' . $data['customer']);
                    } else {
                        $lib_address = new LibCustomerAddress;
                        $lib_address->customer_id = $data['customer'];
                        $lib_address->address_label = $address['label'];
                        $lib_address->local_address = $address['address'];
                        $lib_address->address_specification = $address['specification'];
                        $lib_address->created_by = Sentinel::getUser()->id;
                        $lib_address->save();
                        $addressData[$key]['update_id'] = $lib_address->id;

                        \LogActivity::addToLog('Add customer address from POS ' . $data['customer']);
                    }
                }

                if ($data['selected_address_id']) {
                    $orderDeliveryAddress = $data['selected_address_id'];
                } else {
                    $orderDeliveryAddress = $addressData[$data['selected_address_temp_id']]['update_id'];
                }
            }


            if (count($items) == 0) {
                return [
                    'message' => "no_item",
                ];
            }

            if (isset($details['unique_id']) && $details['unique_id'] != "") {
                $orderProcess = OrderProcess::where('unique_order_id', $details['unique_id'])->first();
                if ($orderProcess->invoice_status == 1 || $orderProcess->order_status == 2) {
                    return [
                        'message' => "no_item",
                    ];
                }
                $uniqueOrderId = $details['unique_id'];

                // Update inventory
                $orderDetails = OrderItem::where('unique_order_id', $uniqueOrderId)->get();
                $alreadyUsedIngs = array();
                foreach ($orderDetails as $row) {
                    $productId = $row->product_id;
                    $sizeId = $row->product_size_id;
                    $quantity = $row->product_quantity;

                    $productIngs = ProductIng::where('product_id', $productId)->where('product_size_id', $sizeId)->get();
                    foreach ($productIngs as $productIng) {
                        if (!isset($alreadyUsedIngs[$productIng->ing_id])) $alreadyUsedIngs[$productIng->ing_id] = 0;
                        $alreadyUsedIngs[$productIng->ing_id] += ($productIng->ing_amount * $quantity);
                    }

                    $productOptnIngs = ProductOptnIng::whereIn('option_id', explode(',', $row->product_option_ids))->get();
                    foreach ($productOptnIngs as $productOptnIng) {
                        if (!isset($alreadyUsedIngs[$productOptnIng->ing_id])) $alreadyUsedIngs[$productOptnIng->ing_id] = 0;
                        $alreadyUsedIngs[$productOptnIng->ing_id] += ($productOptnIng->amount * $quantity);
                    }

                    $ProductAdonIngs = ProductAdonIng::whereIn('pro_adn_id', explode(',', $row->product_addon_ids))->get();
                    foreach ($ProductAdonIngs as $ProductAdonIng) {
                        if (!isset($alreadyUsedIngs[$ProductAdonIng->ing_id])) $alreadyUsedIngs[$ProductAdonIng->ing_id] = 0;
                        $alreadyUsedIngs[$ProductAdonIng->ing_id] += ($ProductAdonIng->amount * $quantity);
                    }

                }



                $productIngAmount = array();
                $productIngIds = array();

                foreach ($items as $item) {
                    $productId = $item['product'];
                    $sizeId = $item['size'];
                    $quantity = $item['quantity'];
                    $productIngs = ProductIng::where('product_id', $productId)->where('product_size_id', $sizeId)->get();
                    foreach ($productIngs as $productIng) {
                        if (!isset($productIngAmount[$productIng->ing_id])) $productIngAmount[$productIng->ing_id] = 0;
                        $productIngAmount[$productIng->ing_id] += ($productIng->ing_amount * $quantity);
                        $productIngIds[$productIng->ing_id] = $productIng->ing_id;
                    }

                    $productOptnIngs = ProductOptnIng::whereIn('option_id', explode(',', $item['option']))->get();
                    foreach ($productOptnIngs as $productOptnIng) {
                        if (!isset($productIngAmount[$productOptnIng->ing_id])) $productIngAmount[$productOptnIng->ing_id] = 0;
                        $productIngAmount[$productOptnIng->ing_id] += ($productOptnIng->amount * $quantity);
                        $productIngIds[$productOptnIng->ing_id] = $productOptnIng->ing_id;
                    }

                    $ProductAdonIngs = ProductAdonIng::whereIn('pro_adn_id', explode(',', $item['addons']))->get();
                    foreach ($ProductAdonIngs as $ProductAdonIng) {
                        if (!isset($productIngAmount[$ProductAdonIng->ing_id])) $productIngAmount[$ProductAdonIng->ing_id] = 0;
                        $productIngAmount[$ProductAdonIng->ing_id] += ($ProductAdonIng->amount * $quantity);
                        $productIngIds[$ProductAdonIng->ing_id] = $ProductAdonIng->ing_id;
                    }
                }

                $productIngNams = array();
                $ingredients = Ingredient::whereIn('id', $productIngIds)->get();
                foreach ($ingredients as $ingredient) {
                    $productIngNams[$ingredient->id] = $ingredient->name;
                }


                $invetoryStock = Inventory::whereIn('item_id', $productIngIds)->pluck('stock', 'item_id');

                $stockNeed = array();
                $flag = true;
                foreach ($productIngIds as $productIngId) {
                    $extra = isset($alreadyUsedIngs[$productIngId]) ? $alreadyUsedIngs[$productIngId] : 0;
                    if ($productIngAmount[$productIngId] > ($invetoryStock[$productIngId] + $extra)) {
                        $stockNeed[$productIngId] = $productIngAmount[$productIngId] - ($invetoryStock[$productIngId] + $extra);
                        $flag = false;
                    }
                }


                if (!$flag) return [
                    'message' => false,
                    'stockNeed' => $stockNeed,
                    'productIngNams' => $productIngNams,
                ];

                foreach ($productIngIds as $productIngId) {
                    $invetory = Inventory::where('item_id', $productIngId)->first();
                    $invetory->stock -= $productIngAmount[$productIngId];
                    $invetory->update();
                }

                foreach ($alreadyUsedIngs as $key => $alreadyUsedIng) {
                    $invetory = Inventory::where('item_id', $key)->first();
                    $invetory->stock += $alreadyUsedIng;
                    $invetory->update();
                }

                \LogActivity::addToLog('Update Inventory from POS item_ids = ' . implode(',', $productIngIds) . implode(',', $alreadyUsedIngs));

                // End Update inventory


                $orderDetails = OrderItem::where('unique_order_id', $uniqueOrderId)->delete();
                \LogActivity::addToLog('Remove order item from POS ' . $uniqueOrderId);
            } else {

                // Update inventory
                $productIngAmount = array();
                $productIngIds = array();
                foreach ($items as $item) {
                    $productId = $item['product'];
                    $sizeId = $item['size'];
                    $quantity = $item['quantity'];
                    $productIngs = ProductIng::where('product_id', $productId)->where('product_size_id', $sizeId)->get();
                    foreach ($productIngs as $productIng) {
                        if (!isset($productIngAmount[$productIng->ing_id])) $productIngAmount[$productIng->ing_id] = 0;
                        $productIngAmount[$productIng->ing_id] += ($productIng->ing_amount * $quantity);
                        $productIngIds[$productIng->ing_id] = $productIng->ing_id;
                    }

                    $productOptnIngs = ProductOptnIng::whereIn('option_id', explode(',', $item['option']))->get();
                    foreach ($productOptnIngs as $productOptnIng) {
                        if (!isset($productIngAmount[$productOptnIng->ing_id])) $productIngAmount[$productOptnIng->ing_id] = 0;
                        $productIngAmount[$productOptnIng->ing_id] += ($productOptnIng->amount * $quantity);
                        $productIngIds[$productOptnIng->ing_id] = $productOptnIng->ing_id;
                    }

                    $ProductAdonIngs = ProductAdonIng::whereIn('pro_adn_id', explode(',', $item['addons']))->get();
                    foreach ($ProductAdonIngs as $ProductAdonIng) {
                        if (!isset($productIngAmount[$ProductAdonIng->ing_id])) $productIngAmount[$ProductAdonIng->ing_id] = 0;
                        $productIngAmount[$ProductAdonIng->ing_id] += ($ProductAdonIng->amount * $quantity);
                        $productIngIds[$ProductAdonIng->ing_id] = $ProductAdonIng->ing_id;
                    }
                }


                $productIngNams = array();
                $ingredients = Ingredient::whereIn('id', $productIngIds)->get();
                foreach ($ingredients as $ingredient) {
                    $productIngNams[$ingredient->id] = $ingredient->name;
                }


                $invetoryStock = Inventory::whereIn('item_id', $productIngIds)->pluck('stock', 'item_id');

                $stockNeed = array();
                $flag = true;
                foreach ($productIngIds as $productIngId) {
                    if ($productIngAmount[$productIngId] > $invetoryStock[$productIngId]) {
                        $flag = false;
                        $stockNeed[$productIngId] = $productIngAmount[$productIngId] - $invetoryStock[$productIngId];
                    }
                }

                if (!$flag) return [
                    'message' => false,
                    'stockNeed' => $stockNeed,
                    'productIngNams' => $productIngNams,
                ];

                foreach ($productIngIds as $productIngId) {
                    $invetory = Inventory::where('item_id', $productIngId)->first();
                    $invetory->stock -= $productIngAmount[$productIngId];
                    $invetory->update();
                    \LogActivity::addToLog('Update Inventory from POS ' . $invetory->id);
                }

                // End Update inventory


                $orderProcess = new OrderProcess;
            }

            $orderProcess->order_from = "pos";
            $orderProcess->sales_type = $request->salesType;
            $orderProcess->isDelivered = $IsDelivered ? 1 : 0;
            $orderProcess->dineIn_place = $request->tableOrRoom;
            $orderProcess->table_id = $IsDelivered ? 0 : $request->table;
            $orderProcess->branch_id = $request->concern;
            $orderProcess->client_id = $request->customer;
            $orderProcess->unique_order_id = $uniqueOrderId;
            $orderProcess->total_items = count($items);
            $orderProcess->basic_total_bill = $request->subTotal;
            $orderProcess->service_charge = $request->serviceCharge;
            $orderProcess->tax = $request->vat;
            $orderProcess->discount_category = $request->discountCategory;
            $orderProcess->discount_amount = $request->discountAmount;
            $orderProcess->total_bill = $request->grandTotal;
            $orderProcess->paid_amount = $request->shownBill;
            $orderProcess->delivery_charge = $request->deliveryCharge;
            $orderProcess->delivery_address = $orderDeliveryAddress;
            $orderProcess->dineIn_person = $request->dineInPerson;

            $orderProcess->payment_status = 1;
            $orderProcess->save();

            \LogActivity::addToLog('Save order from POS ' . $uniqueOrderId);


            foreach ($items as $item) {

                $basePrice = getProductPriceFromSizeId($item['size']);

                $options = ProductOption::whereIn('id', explode(',', $item['option']))->get();
                $addons = ProductAdon::whereIn('id', explode(',', $item['addons']))->get();

                $option_ids = array();
                $option_prices = array();
                $addon_ids = array();
                $addon_prices = array();

                foreach ($options as $option) {
                    $option_ids[] = $option->id;
                    $option_prices[] = getProductOptionPrice($option);
                }

                foreach ($addons as $addon) {
                    $addon_ids[] = $addon->id;
                    $addon_prices[] = getProductAddonPrice($addon);
                }

                $orderItem = new OrderItem;

                $orderItem->branch_id = $request->concern;
                $orderItem->unique_order_id = $uniqueOrderId;
                $orderItem->product_id = $item['product'];
                $orderItem->product_size_id = $item['size'];

                $orderItem->product_quantity = $item['quantity'];
                $orderItem->product_total_price = $basePrice * $item['quantity'];
                $orderItem->product_unit_price = $basePrice;
                $orderItem->product_option_ids = implode(',', $option_ids);
                $orderItem->product_option_prices = implode(',', $option_prices);
                $orderItem->total_option_price = array_sum($option_prices);
                $orderItem->product_addon_ids = implode(',', $addon_ids);
                $orderItem->product_addon_prices = implode(',', $addon_prices);
                $orderItem->total_addon_price = array_sum($addon_prices);
                $orderItem->save();
            }

            \LogActivity::addToLog('save order item from POS ' . $uniqueOrderId);

            $product_list[$data['concern']][$data['salesType']][$data['tableOrRoom']][$data['table']]['orderDetails'] = [];
            $product_list[$data['concern']][$data['salesType']][$data['tableOrRoom']][$data['table']]['items'] = [];
            Session::put('pos_added_product_list', $product_list);

            return [
                'message' => "success",
            ];
        }
    }

    public function addKotComment(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $id =  $request->id;
            $data =  $request->data;
            $order = OrderProcess::where('unique_order_id', $id)->first();
            $order->kot_comment = $data;
            $order->save();
            \LogActivity::addToLog('Add KOT comment from POS' . $request->id . '  ' . $data);
            return "success";
        }
    }

    public function imageUpload(Request $request)
    {
        if (Sentinel::getUser()->id) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $newImageName = $request->userid . '.' . $image->getClientOriginalExtension();

                $imgPath = 'public/profiles/';
                $image->move($imgPath, $newImageName);

                return response()->json([
                    "success" => true,
                    "message" => "successfully",
                    "data" => $newImageName,
                ]);
            }
        }
    }

    function getClassNamespace($contents)
    {
        if (Sentinel::getUser()->id) {
            if (preg_match('/namespace\s+([^;]+);/', $contents, $matches)) {
                return $matches[1];
            }
            return '';
        }
    }

    function getModelObject($modelName)
    {
        if (Sentinel::getUser()->id) {
            $files = File::allFiles(app_path());
            $models = [];
            foreach ($files as $file) {
                $contents = file_get_contents($file);
                if (preg_match('/class\s+(\w+)\s+extends\s+Model/', $contents, $matches)) {
                    $className = $matches[1];
                    $namespace = $this->getClassNamespace($contents);
                    $fullyQualifiedClassName = $namespace . '\\' . $className;
                    $models[$className] = $fullyQualifiedClassName;
                }
            }
            if (isset($models[$modelName])) return new $models[$modelName];
            else return null;
        }
    }

    public function updateColumnValue(Request $request)
    {
        if (Sentinel::getUser()->id) {
            $model = $this->getModelObject($request->modelName);
            $id = $request->rowId;
            $column = $request->columnName;
            $value = $request->value;
            if ($model) {
                $model = $model->find($request->rowId);
                $model->$column = $value;
                $model->update();
                \LogActivity::addToLog('Update model ' . $request->modelName . ' id ' . $id);
                return true;
            } else return false;
        }
    }

    public function updatePosOrder(Request $request)
    {
        // return 5/0;
        // return $request->all();
        $orders = OrderProcess::join('lib_customers', 'lib_customers.id', '=', 'fr_order_process.client_id')
            ->leftJoin('lib_customer_addresses', 'lib_customer_addresses.id', '=', 'fr_order_process.delivery_address')
            ->where('unique_order_id', $request->uniqueId)
            ->select('fr_order_process.*', 'lib_customers.name as client_name', 'lib_customer_addresses.address_label', 'lib_customer_addresses.local_address')
            ->first();
        $orderDetails = OrderItem::where('unique_order_id', $request->uniqueId)->get();

        // return $orderDetails->toArray();

        $items = array();
        foreach ($orderDetails as $orderItem) {
            $items[] = [
                'sales_type' => $orderItem->sales_type,
                'concern' => $orderItem->branch_id,
                'isDelivered' => $orders->isDelivered,
                'tableOrRoom' => $orders->dineIn_place,
                'table' => $orders->table_id,
                'product' => $orderItem->product_id,
                'size' => $orderItem->product_size_id,
                'option' => $orderItem->product_option_ids,
                'addons' => $orderItem->product_addon_ids,
                'quantity' => $orderItem->product_quantity,
                'unique_order_id' => $request->uniqueId,
            ];
        }

        $customerDiscount = Customer::leftjoin('lib_customer_discount', function ($join) use ($request) {
            $join->on('lib_customers.id', '=', 'lib_customer_discount.customer_id')
                ->where('lib_customer_discount.company_id', $request->concern);
        })
            ->where('lib_customers.id', $orders->client_id)
            ->select('lib_customers.*', 'lib_customer_discount.discount_category')
            ->first();

        if ($customerDiscount) {
            $orders->discount_category = $customerDiscount->discount_category;
        }

        $product_list  = Session::get('pos_added_product_list') ?? [];
        $product_list[$orders->branch_id][$orders->sales_type][$orders->dineIn_place][$orders->table_id]['orderDetails']['unique_id'] = $orders->unique_order_id;
        $product_list[$orders->branch_id][$orders->sales_type][$orders->dineIn_place][$orders->table_id]['items'] = $items;

        Session::put('pos_added_product_list', $product_list);

        return $orders->toArray();
    }

    public function cancelPosOrder(Request $request)
    {

        $product_list  = Session::get('pos_added_product_list') ?? [];

        $product_list[$request->concern][$request->salesType][$request->tableOrRoom][$request->table]['orderDetails'] = [];
        $product_list[$request->concern][$request->salesType][$request->tableOrRoom][$request->table]['items'] = [];

        Session::put('pos_added_product_list', $product_list);
    }

    public function makeOrderComplimentary(Request $request)
    {
        $orderProcess = OrderProcess::where('unique_order_id', $request->uniqueId)->first();
        $orderProcess->isComplimentary = 1;
        $orderProcess->order_status = 2;
        $orderProcess->save();
        \LogActivity::addToLog('Make a order Complimentory' . $request->uniqueId);
    }

    public function getBookedTables(Request $request)
    {

        // Session::put('pos_added_product_list',[]);
        $product_list  = Session::get('pos_added_product_list') ?? [];

        $salesTypeData = isset($product_list[$request->concern]) ? $product_list[$request->concern] : [];

        $updatedTableids = array();
        foreach ($salesTypeData as $tableOrRoomData) {
            $tableData = isset($tableOrRoomData[1]) ? $tableOrRoomData[1] : [];
            foreach ($tableData as $table => $order) {
                if ($table > 0) {
                    if (isset($order['orderDetails']['unique_id']) && $order['orderDetails']['unique_id'] != "") {
                        $updatedTableids[$table] = $table;
                    }
                }
            }
        }






        $today = date("Y-m-d");
        $orders = OrderProcess::where('branch_id', $request->concern)
            ->where("order_status", '!=', 2)
            ->where("isDelivered", '==', 0)
            ->where("dineIn_place", '=', 1)
            ->whereDate('order_time', '>=', $today)
            ->whereDate('order_time', '<=', $today)
            ->where('order_from', 'pos')
            ->whereNotIn('table_id', $updatedTableids)
            ->pluck('table_id');


        return $orders;
    }


    public function getCustomerAddress(Request $request)
    {
        $customerId =  $request->customerId;
        $customerAddresses = LibCustomerAddress::where('customer_id', $customerId)->where('status', 1)->get();

        $addresses  = (string)view("pos.template.customerAddress", compact('customerAddresses'));
        $addressCount = count($customerAddresses);

        return ["addresses" => $addresses, "addressCount" => $addressCount];
    }

    public function getCustomerProfile(Request $request)
    {
        // $customer = Customer::find($request->customerId);
        $customer = Customer::leftjoin('lib_customer_discount', function ($join) use ($request) {
            $join->on('lib_customers.id', '=', 'lib_customer_discount.customer_id')
                ->where('lib_customer_discount.company_id', $request->concern);
        })
            ->where('lib_customers.id', $request->customerId)
            ->select('lib_customers.*', 'lib_customer_discount.discount_category')
            ->first();

        // _print($request->customerId);


        // $discountCategories = DiscountCategory::where('company_id', gethostinfo()['id'])->get();
        $discountCategories = DB::table('lib_discount_category')->where('company_id', gethostinfo()['id'])->get();
        // $selectedAmount = DiscountCategory::where('id', $customer->discount_category)->first();
        $selectedAmount = DB::table('lib_discount_category')->where('id', $customer->discount_category)->first();
        if ($selectedAmount) {
            $selectedAmount = $selectedAmount->amount . ($selectedAmount->discount_type == 2 ? '%' : '');
        }
        return view('pos.template.customerProfileContent', compact('customer', 'discountCategories', 'selectedAmount'));
    }


    public function addfeedback(Request $request)
    {
        $empid = Sentinel::getUser()->empid;
        if ($request->type == 'statusUpdate') {
            $feedback = Feedback::where('id', $request->id)->first();
            $feedback->updated_by = $empid;
            $feedback->status = $request->status;
            $feedback->update();
            \LogActivity::addToLog('Update feedbac ' . $request->id);
            return response()->json(['status' => 'success']);
        } else {
            $attributes = $request->all();
            $imageName = "";
            if ($image = $request->file('feedbackFIle')) {
                $destinationPath = 'public/feedbacks/';
                $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $upload_success = $image->move($destinationPath, $imageName);
            } else {
                $imageName = null;
            }
            $feedback = new Feedback();
            $feedback->feedbackTitle = $attributes['feedbackTitle'];
            $feedback->feedbackDescription = $attributes['feedbackDescription'];
            $feedback->created_by = $empid;
            $feedback->feedbackFIle = $imageName;
            $feedback->status = '0';
            $feedback->save();
            \LogActivity::addToLog('Add feedback ' . $attributes['feedbackTitle']);
            return redirect()->back()->with('success', getNotify(1));
        }
    }

    public function setDiscountToCustomer(Request $request)
    {
        // $customer = Customer::find($request->customer);
        // $customer->discount_category = $request->discount;
        // $customer->update();
        if ($request->discount > 0) {
            $customerDiscount = CustomerDiscount::where('company_id', $request->concern)->where('customer_id', $request->customer)->first();
            if ($customerDiscount) {
                $customerDiscount->discount_category = $request->discount;
                $customerDiscount->update();
            } else {
                $customerDiscount = new CustomerDiscount;
                $customerDiscount->company_id = $request->concern;
                $customerDiscount->customer_id = $request->customer;
                $customerDiscount->discount_category = $request->discount;
                $customerDiscount->save();
            }
            \LogActivity::addToLog('Add customer discount ' . $request->customer);
        }



        $customer = Customer::leftjoin('lib_customer_discount', function ($join) use ($request) {
            $join->on('lib_customers.id', '=', 'lib_customer_discount.customer_id')
                ->where('lib_customer_discount.company_id', $request->concern);
        })
            ->where('lib_customers.id', $request->customer)
            ->select('lib_customers.*', 'lib_customer_discount.discount_category')
            ->first();

        return $customer;
    }
}
