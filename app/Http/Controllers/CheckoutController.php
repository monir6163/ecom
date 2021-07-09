<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Billing;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\ProductAttribute;
use App\Models\shipping;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe;
//paypal
use URL;
use Session;
use Redirect;
use Input;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;

class CheckoutController extends Controller
{
    private $_api_context;
    function __construct()
    {
        $this->middleware('auth');
        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }
    function Checkout(Request $request){
        $old_cookie = $request->cookie('cookie_id');
        $carts = Cart::where('cookie_id' , $old_cookie)->get();
        return view('frontend.pages.checkout' , [
            'countries' => Country::orderBy('name' , 'asc')->get(),
            'cart' => $carts
        ]);
    }

    function CheckoutPost(Request $request){

        $checkbox = $request->checkbox ?? 1;

        if ($request->payment == 'bank') {
            $billings = new Billing;
            $billings->user_id = Auth::id();
            $billings->full_name = $request->full_name;
            $billings->company_name = $request->company_name;
            $billings->email = $request->email;
            $billings->phone = $request->phone;
            $billings->address = $request->address;
            $billings->country_id = $request->country_id;
            $billings->city_id = $request->city_id ?? 1;
            $billings->state_id = $request->state_id ?? 1;
            $billings->zipcode = $request->zipcode;
            $billings->notes = $request->notes;
            $billings->payment_type = $request->payment;
            $billings->different_shipping = $checkbox;
            $billings->save();

            if($checkbox == 2){
                $shippings = new shipping;
                $shippings->user_id = Auth::id();
                $shippings->billing_id = $billings->id;
                $shippings->full_name = $request->s_f_name;
                $shippings->company_name = $request->s_c_name;
                $shippings->email = $request->s_email;
                $shippings->phone = $request->s_phone;
                $shippings->address = $request->s_address;
                $shippings->country_id = $request->s_country;
                $shippings->city_id = $request->s_city ?? 1;
                $shippings->zipcode = $request->s_zip;
                $shippings->state_id = $request->s_state_country;
                $shippings->save();
            }
        }
        elseif ($request->payment == 'paypal') {
            $billings = new Billing;
            $billings->user_id = Auth::id();
            $billings->full_name = $request->full_name;
            $billings->company_name = $request->company_name;
            $billings->email = $request->email;
            $billings->phone = $request->phone;
            $billings->address = $request->address;
            $billings->country_id = $request->country_id;
            $billings->city_id = $request->city_id ?? 1;
            $billings->state_id = $request->state_id ?? 1;
            $billings->zipcode = $request->zipcode;
            $billings->cupon = $request->cupon;
            $billings->tottal_price = $request->tottal_price;
            $billings->notes = $request->notes;
            $billings->payment_type = $request->payment;
            $billings->different_shipping = $checkbox;
            $billings->save();

            if($checkbox == 2){
                $shippings = new shipping;
                $shippings->user_id = Auth::id();
                $shippings->billing_id = $billings->id;
                $shippings->full_name = $request->s_f_name;
                $shippings->company_name = $request->s_c_name;
                $shippings->email = $request->s_email;
                $shippings->phone = $request->s_phone;
                $shippings->address = $request->s_address;
                $shippings->country_id = $request->s_country;
                $shippings->city_id = $request->s_city ?? 1;
                $shippings->zipcode = $request->s_zip;
                $shippings->state_id = $request->s_state_country;
                $shippings->save();
            }
            $old_cookie = $request->cookie('cookie_id');
            $carts = Cart::where('cookie_id' , $old_cookie)->get();
            $total = 0;
            $i = 0;
            session(['billing_id' =>  $billings->id]);
                foreach($carts as $cart){
                    // echo $cart->product_id;
                    $price = ProductAttribute::where('product_id',$cart->product_id)->where('size_id',$cart->size_id)->where('color_id', $cart->color_id)->first()->price;
                    $order = new Order;
                    $order->billing_id = $billings->id;
                    $order->user_id = Auth::id();
                    $order->product_id = $cart->product_id;
                    $order->color_id = $cart->color_id;
                    $order->size_id = $cart->size_id;
                    $order->product_price = $price;
                    $order->product_quantity = $cart->quantity;
                    $order->save();
                    $order = Order::with('product')->where('billing_id', $billings->id)->get();
                    Mail::to([Auth::user()->email, 'monirhossain6163@gmail.com'])->send(new OrderShipped($order));
                    return "mail send Successfully";
                    $total += $cart->quantity * $price;
            
                    $item_1[$i] = new Item();

                    $item_1[$i]->setName($cart->product->title)
                        ->setCurrency('USD')
                        ->setQuantity($cart->quantity)
                        ->setPrice($price);
                    $i++;
                }
                $payer = new Payer();
                $payer->setPaymentMethod('paypal');
    
                $item_list = new ItemList();
                $item_list->setItems($item_1);
    
                $amount = new Amount();
                $amount->setCurrency('USD')
                    ->setTotal($total);

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Enter Your transaction description');

            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(route('PayPalStatus'))
                ->setCancelUrl(route('PayPalStatus'));

            $payment = new Payment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));            
            try {
                $payment->create($this->_api_context);
            } catch (\PayPal\Exception\PPConnectionException $ex) {
                if (\Config::get('app.debug')) {
                    \Session::put('error','Connection timeout');
                    return "paywithpaypal";                
                } else {
                    \Session::put('error','Some error occur, sorry for inconvenient');
                    return "errorpaywithpaypal";                
                }
            }

            foreach($payment->getLinks() as $link) {
                if($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }
            
            Session::put('paypal_payment_id', $payment->getId());

            if(isset($redirect_url)) {            
                return Redirect::away($redirect_url);
            }

            \Session::put('error','Unknown error occurred');
            return "paywithpaypal OK";
        }
        elseif ($request->payment == 'card') {

            $billings = new Billing;
            $billings->user_id = Auth::id();
            $billings->full_name = $request->full_name;
            $billings->company_name = $request->company_name;
            $billings->email = $request->email;
            $billings->phone = $request->phone;
            $billings->address = $request->address;
            $billings->country_id = $request->country_id;
            $billings->city_id = $request->city_id ?? 1;
            $billings->state_id = $request->state_id ?? 1;
            $billings->zipcode = $request->zipcode;
            $billings->cupon = $request->cupon;
            $billings->tottal_price = $request->tottal_price;
            $billings->notes = $request->notes;
            $billings->payment_type = $request->payment;
            $billings->different_shipping = $checkbox;
            $billings->save();

            if($checkbox == 2){
                $shippings = new shipping;
                $shippings->user_id = Auth::id();
                $shippings->billing_id = $billings->id;
                $shippings->full_name = $request->s_f_name;
                $shippings->company_name = $request->s_c_name;
                $shippings->email = $request->s_email;
                $shippings->phone = $request->s_phone;
                $shippings->address = $request->s_address;
                $shippings->country_id = $request->s_country;
                $shippings->city_id = $request->s_city ?? 1;
                $shippings->zipcode = $request->s_zip;
                $shippings->state_id = $request->s_state_country;
                $shippings->save();
            }

            $old_cookie = $request->cookie('cookie_id');
            $carts = Cart::where('cookie_id' , $old_cookie)->get();
            $total = 0;
                foreach($carts as $cart){
                    // echo $cart->product_id;
                    $price = ProductAttribute::where('product_id',$cart->product_id)->where('size_id',$cart->size_id)->where('color_id', $cart->color_id)->first()->price;
                    $order = new Order;
                    $order->billing_id = $billings->id;
                    $order->user_id = Auth::id();
                    $order->product_id = $cart->product_id;
                    $order->color_id = $cart->color_id;
                    $order->size_id = $cart->size_id;
                    $order->product_price = $price;
                    $order->product_quantity = $cart->quantity;
                    $order->save();
                    $total += $cart->quantity * $price;
                }

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $charge = Stripe\Charge::create ([
                
                "amount" => $total * 100,

                "currency" => "usd",

                "source" => $request->stripeToken,

                "description" => "Test payment from ES WEB DEV 2001" 
                
            ]);
            $pay_status = Billing::findOrFail($billings->id);
            $pay_status->tottal_price = $total;
            $pay_status->payment_status = 2;
            $pay_status->save();
        }
        elseif ($request->payment == 'cash') {
            return "cash";
        }
        else{
            return back()->with('payment slect' , 'Please Select Payment Getway');
        }
    }

    function GetState($id){

        $states = State::where('country_id' , $id)->get();
        return response()->json($states);
    }

    function GetCity($id){

        $cites = City::where('state_id' , $id)->get();
        return response()->json($cites);
    }

    public function PayPalStatus(Request $request)
    {        
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            \Session::put('error','Payment failed');
            return "Payment failed 1";
        }
        $payment = Payment::get($payment_id, $this->_api_context);        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));        
        $result = $payment->execute($execution, $this->_api_context);
        
        if ($result->getState() == 'approved') {         
            \Session::put('success','Payment success !!');

            $billing_id = session('billing_id');

            $orders = Order::where('billing_id', $billing_id)->get();

            foreach($orders as $order){
                $pa = ProductAttribute::where('product_id', $order->product_id)->where('color_id', $order->color_id)->where('size_id', $order->size_id)->first();
                $pa->decrement('quantity', $order->product_quantity);
                $pa->save();
            }
            return "Payment success !!";
        }

        \Session::put('error','Payment failed !!');
		return "Payment failed !!";
    }
}
