<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Library\General\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerAuthController extends Controller
{
    public function registration(Request $request)
    {
        $formdata = array(
            'clientName'     => $request->input('clientName'),
            'clientMobile'   => $request->input('clientMobile'),
            'clientEmail'    => $request->input('clientEmail'),
            'clientPassword' => $request->input('clientPassword'),
        );

        $rules = array(
            'clientName'     => 'required|min:6',
            'clientMobile'   => 'required',
            'clientEmail'    => 'email',
            'clientPassword' => 'required|min:6',
        );

        $validation = Validator::make($formdata, $rules);

        if ($validation->fails()) {
            return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
        } else {
             $user = Customer::where('email', $request->input('clientEmail'))
            ->orWhere('phone', $request->input('clientMobile'))
            ->first();

            $customer = Customer::where('email', $formdata['clientEmail'])
            ->orWhere('phone', $formdata['clientMobile'])
            ->first();

            if (!$customer) {
                $customer = Customer::create([
                    'name'     => $formdata['clientName'],
                    'phone'    => $formdata['clientMobile'],
                    'email'    => $formdata['clientEmail'],
                    'password' => bcrypt($formdata['clientPassword']),
                    'status'   => '1',
                ]);
            } else {
                $customer->update([
                    'name'     => $formdata['clientName'],
                    'email'    => $formdata['clientEmail'],
                    'password' => bcrypt($formdata['clientPassword']),
                    'status'   => '1',
                ]);
            }


            Auth::guard('customer')->login($customer);
            return redirect()->route('frontend');
        }


    }

    public function login(Request $request)
    {
        $inputValue = $request->input('email_or_mobile');
        $password = $request->input('password');

        // Attempt to find the user based on email or phone
        $user = Customer::where('email', $inputValue)
                        ->orWhere('phone', $inputValue)
                        ->first();

        if ($user && Hash::check($password, $user->password)) {
            // Passwords match, log in the user
            Auth::guard('customer')->login($user);
            $routeName = "frontend";
            if($request->returnRoute){
                $routeName = $request->returnRoute;
            }
            return redirect()->route($routeName); // Successful login
        }else{
            // If the login attempt fails, return an error message
            return redirect()->back()->withErrors(['login_error' => 'Invalid credentials']);
        }


    }
    public function showRegistrationForm()
    {
        if (Auth::guard('empuser')->check()) {
            return redirect()->route('careers');
        }
        return view('hris.database.empuser.register');
    }



    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect()->route('frontend');
    }





}
