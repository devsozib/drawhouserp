<?php

namespace App\Http\Controllers\Library\General;

use Illuminate\Http\Request;
use App\Models\Library\General\Company;
use App\Http\Controllers\Controller;
use App\Models\Library\General\Supplier;
use Validator;
use Sentinel;

class SupplierController extends Controller
{
    public function index() 
    {
        if (getAccess('view')) {
            $companies = Company::where('C4S','Y')->orderBy('id','ASC')->get();
            $suppliers = Supplier::join('lib_company','lib_company.id','=','lib_suppliers.company_id')->orderBy('lib_suppliers.id','ASC')->select('lib_suppliers.id','lib_suppliers.name', 'lib_suppliers.phone', 'lib_suppliers.email', 'lib_suppliers.address', 'lib_suppliers.contact_person', 'lib_suppliers.cp_mobile', 'lib_company.Name as company_name','lib_suppliers.status','lib_company.id as company_id')->get();
            return view('library.general.suppliers.index', compact('companies','suppliers'));
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
                'name' => 'required',
                'company_id' => 'required',
                'Phone' => 'required|numeric|regex:/^[+]?[0-9]{6,20}$/',
                'Email' => 'required|max:255|unique:lib_suppliers,email',
                'Address' => 'required',
                'Contact_Person' => 'required',
                'cp_mobile' => 'required|numeric|regex:/^[+]?[0-9]{6,20}$/',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);

            if($validation->fails()) {               
                return redirect()->action('Library\General\SupplierController@index')->with(['error'=>getNotify(4), 'error_code'=>'Add'])->withErrors($validation)->withInput();
            }else{               
                $supplier = new Supplier();
                $supplier->name = $request->name;
                $supplier->company_id = $request->company_id;
                $supplier->phone = $request->Phone;
                $supplier->email = $request->Email;
                $supplier->address = $request->Address;
                $supplier->contact_person = $request->Contact_Person;
                $supplier->cp_mobile = $request->cp_mobile;
                $supplier->status = $request->status;
                $supplier->created_by = $userid;
                $supplier->save();
                \LogActivity::addToLog('Add supplier '.$attributes['name']);
                return redirect()->action('Library\General\SupplierController@index')->with('success',getNotify(1));
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
            $supplier =Supplier::find($id);
            $email = "";
            if($supplier->email == $request->Email){          
                $rules = [
                    'name' => 'required',
                    'company_id' => 'required',
                    'Phone' => 'required|numeric|regex:/^[+]?[0-9]{6,20}$/',
                    'Address' => 'required',
                    'Contact_Person' => 'required',
                    'cp_mobile' => 'required|numeric|regex:/^[+]?[0-9]{6,20}$/',
                    'status' => 'required',
                ];
                $email = $supplier->email;
            }else{               
                $rules = [
                    'name' => 'required',
                    'company_id' => 'required',
                    'Phone' => 'required|numeric|regex:/^[+]?[0-9]{6,20}$/',
                    'Email' => 'required|max:255|unique:lib_suppliers,email',
                    'Address' => 'required',
                    'Contact_Person' => 'required',
                    'cp_mobile' => 'required|numeric|regex:/^[+]?[0-9]{6,20}$/',
                    'status' => 'required',
                ];
                $email = $request->Email;
            }    
            $validation = Validator::make($attributes, $rules);
            if($validation->fails()) {
                return redirect()->action('Library\General\SupplierController@index')->with(['error'=>getNotify(4), 'error_code'=>'Add'])->withErrors($validation)->withInput();
            }else{            
                $supplier->name = $request->name;
                $supplier->company_id = $request->company_id;
                $supplier->phone = $request->Phone;
                $supplier->email = $email;
                $supplier->address = $request->Address;
                $supplier->contact_person = $request->Contact_Person;
                $supplier->cp_mobile = $request->cp_mobile;
                $supplier->status = $request->status;
                $supplier->updated_by = $userid;
                $supplier->update();
                \LogActivity::addToLog('Update supplier '.$attributes['name']);
                return redirect()->action('Library\General\SupplierController@index')->with('success',getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $supplier = Supplier::find($id);
            $supplier->deleted_by = $userid;
            $supplier->delete();

            \LogActivity::addToLog('Delete supplier '.$supplier->name);
            return redirect()->action('Library\General\SupplierController@index')->with('success',getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
