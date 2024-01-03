<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use App\Models\Frontend\Pokebowl;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Library\General\Customer;
use Illuminate\Support\Facades\Validator;
use App\Models\Frontend\Order\OrderProcess;
use App\Models\Frontend\Order\OrderItem;

class CustomerController extends Controller
{
    public function customerProfile(){
        $userid = Auth::guard('customer')->user()->id;
        $data = Pokebowl::where('c_id',$userid)->first();
        if($data){
            $data['protein'] = explode('@', $data['protein']);
            $data['rtoppings'] = explode('@', $data['rtoppings']);
            $data['ptoppings'] = explode('@', $data['ptoppings']);
            $data['flavours'] = explode('@', $data['flavours']);
        }



        // $orders = DB::table('fr_order_process as order')
        // ->join('fr_order_items as item', 'order.unique_order_id', '=', 'item.unique_order_id')
        // ->where('order.client_id', $userid)
        // ->select('order.id', 'order.unique_order_id', 'order.paid_amount', 'order.payment_method_id', 'item.id as item_id', 'item.product_id', 'item.product_size_id')
        // ->get()
        // ->groupBy('unique_order_id')
        // ->map(function ($groupedItems) {
        //     return (object)[
        //         'id' => $groupedItems->first()->id,
        //         'paid_amount' => $groupedItems->first()->paid_amount,
        //         'payment_method_id' => $groupedItems->first()->payment_method_id,
        //         'items' => $groupedItems->map(function ($item) {
        //             return (object)[
        //                 'id' => $item->item_id,
        //                 'product_id' => $item->product_id,
        //                 'product_size_id' => $item->product_size_id,
        //             ];
        //         }),
        //     ];
        // });


        // _print($orders);


        $orders = OrderProcess::where('client_id', $userid)->get();




        return view('frontend.profile',compact('data','orders'));
    }

    public function customerProfileEdit(Request $request){
        $userid = Auth::guard('customer')->user()->id;
        $attributes = $request->all();
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ];
        $customer = Customer::findOrFail($userid);

        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'update'])->withErrors($validation)->withInput();
        } else {
            $customer->name = $attributes['name'];
            $customer->email = $attributes['email'];
            $customer->phone = $attributes['phone'];
            $customer->update();
            return redirect()->back()->with('success', 'Profile Update Success');
        }
    }

    public function makeOwnPokeBowl(Request $request){
        // return $request;
         $userid = Auth::guard('customer')->user()->id;
         $pokebowl = $request->pokebowl;
         $base = $request->base;
         $protein = $request->protein;
         $rtoppings = $request->rtoppings;
         $ptoppings = $request->ptoppings;
         $flavours = $request->flavours;

         $totalPrice = 0;
         $extraProtinPrice = 0;
         $pToppingPrice = 0;
         if($pokebowl == 'hangry-one'){
            $totalPrice = 900;
            if(count($protein) != 1){
                    $extraProtin = count($protein) - 1;
                     $extraProtinPrice = 200*$extraProtin;
            }
            foreach($ptoppings as $top){
                $numeric_part = filter_var($top, FILTER_SANITIZE_NUMBER_INT);
                $pToppingPrice += $numeric_part;
            }
         }else{
            $totalPrice = 1050;
            if(count($protein) != 2){
                $extraProtin = count($protein) - 2;
                 $extraProtinPrice = 200*$extraProtin;
            }
            foreach($ptoppings as $top){
                $numeric_part = filter_var($top, FILTER_SANITIZE_NUMBER_INT);
                $pToppingPrice +=$numeric_part;
            }
         }
         $totalPPrice = $totalPrice+$extraProtinPrice+$pToppingPrice;


         $proteinString = implode('@', $protein);
         $rtoppingsString = implode('@', $rtoppings);
         $ptoppingsString = implode('@', $ptoppings);
         $flavoursString = implode('@', $flavours);

         $pokebowlName = $pokebowl;
         $pokebowl = new Pokebowl();
         $pokebowl->c_id  = $userid;
         $pokebowl->name  = $pokebowlName;
         $pokebowl->base  = $base;
         $pokebowl->protein  = $proteinString;
         $pokebowl->rtoppings  = $rtoppingsString;
         $pokebowl->ptoppings  = $ptoppingsString;
         $pokebowl->flavours  = $flavoursString;
         $pokebowl->total_price = $totalPPrice;
         $pokebowl->save();
         return redirect()->back()->with('psuccess', 'Your own pokebowl creation success');

    }


    public function updateOwnPokeBowl(Request $request, $id){


          $userid = Auth::guard('customer')->user()->id;
          $pokebowl = $request->pokebowl;
          $base = $request->base;
          $protein = $request->protein;
          $rtoppings = $request->rtoppings;
          $ptoppings = $request->ptoppings;
          $flavours = $request->flavours;

          $totalPrice = 0;
          $extraProtinPrice = 0;
          $pToppingPrice = 0;


          if($pokebowl == 'hangry-one'){
             $totalPrice = 900;
             if(count($protein) != 1){
                     $extraProtin = count($protein) - 1;
                      $extraProtinPrice = 200*$extraProtin;
             }
             foreach($ptoppings as $top){
                 $numeric_part = filter_var($top, FILTER_SANITIZE_NUMBER_INT);
                 $pToppingPrice += $numeric_part;
             }
          }else{
             $totalPrice = 1050;
             if(count($protein) != 2){
                 $extraProtin = count($protein) - 2;
                  $extraProtinPrice = 200*$extraProtin;
             }
             foreach($ptoppings as $top){
                 $numeric_part = filter_var($top, FILTER_SANITIZE_NUMBER_INT);
                 $pToppingPrice +=$numeric_part;
             }
          }
          $totalPPrice = $totalPrice+$extraProtinPrice+$pToppingPrice;


          $proteinString = implode('@', $protein);
          $rtoppingsString = implode('@', $rtoppings);
          $ptoppingsString = implode('@', $ptoppings);
          $flavoursString = implode('@', $flavours);
          $pokebowlName = $pokebowl;
        //Delete old pokebowl
          $pokebowl =  Pokebowl::findOrfail($id);
          $pokebowl->delate();
          $pokebowl->c_id  = $userid;
          $pokebowl->name  = $pokebowlName;
          $pokebowl->base  = $base;
          $pokebowl->protein  = $proteinString;
          $pokebowl->rtoppings  = $rtoppingsString;
          $pokebowl->ptoppings  = $ptoppingsString;
          $pokebowl->flavours  = $flavoursString;
          $pokebowl->total_price = $totalPPrice;
          $pokebowl->save();
          return redirect()->back()->with('psuccess', 'Your own pokebowl update success');
    }

}
