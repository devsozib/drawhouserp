<?php

namespace App\Http\Controllers\Library\general;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Library\General\Company;
use App\Models\Library\general\DiscountCategory;
use Carbon\Carbon;
use DB;

use Input;
use Sentinel;
use Validator;

class DiscountCategoryController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $comp_arr = Company::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Name', 'id');
            // $categories = DiscountCategory::orderBy('id', 'ASC')->get();
            $categories = DB::table('lib_discount_category')->get();

            // return $categories->toArray();

            return view('library.general.discount.index', compact('categories', 'comp_arr'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'company_id' => 'required',
                'category_name' => 'required|max:100',
                'status' => 'required',
                'discount_type' => 'required|numeric',
                'amount' => 'required|numeric',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                // $discountCategory = new DiscountCategory();
                // $discountCategory->created_by = $userid;
                // $discountCategory->fill($attributes)->save();

                $data = [
                    'created_by' => $userid,
                    'company_id' => $request->company_id,
                    'category_name' => $request->category_name,
                    'discount_type' => $request->discount_type,
                    'amount' => $request->amount,
                    'status' => $request->status,
                ];
                DB::table('lib_discount_category')->insert($data);

                $comp = Company::findOrFail($attributes['company_id'])->Name;

                \LogActivity::addToLog('Add discount category: ' . $attributes['category_name'] . ' and Company: ' . $comp);
                return redirect()->back()->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request, $id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'company_id' => 'required',
                'category_name' => 'required|max:100',
                'status' => 'required',
                'discount_type' => 'required|numeric',
                'amount' => 'required|numeric',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                // $user = DiscountCategory::find($id);
                // $user->updated_by = $userid;
                // $user->updated_at = Carbon::now();
                // $user->fill($attributes)->save();

                DB::table('lib_discount_category')->where('id', $id)->update([
                    'update_by' => $userid,
                    'updated_at' => now(),
                    'company_id' => $request->company_id,
                    'category_name' => $request->category_name,
                    'discount_type' => $request->discount_type,
                    'amount' => $request->amount,
                    'status' => $request->status,
                ]);

                $comp = Company::findOrFail($attributes['company_id'])->Name;

                \LogActivity::addToLog('Update discount category: ' . $attributes['category_name'] . ' and Company: ' . $comp);
                return redirect()->back()->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            // $user = DiscountCategory::find($id);
            $user = DB::table('lib_discount_category')->find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Table ' . $user['category_name']);
            return redirect()->back()->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
