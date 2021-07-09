@extends('frontend.master')
@section('header_css')
<link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
<style>
.StripeElement {
box-sizing: border-box;
height: 40px;
padding: 10px 12px;
border: 1px solid transparent;
border-radius: 4px;
background-color: white;
box-shadow: 0 1px 3px 0 #e6ebf1;
-webkit-transition: box-shadow 150ms ease;
transition: box-shadow 150ms ease;
}
.StripeElement--focus {
box-shadow: 0 1px 3px 0 #cfd7df;
}
.StripeElement--invalid {
border-color: #fa755a;
}
.StripeElement--webkit-autofill {
background-color: #fefde5 !important;
}
</style>
@section('content')
<div class="breadcumb-area bg-img-4 ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Checkout</h2>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><span>Checkout</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="checkout-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-form form-style">
                    <h3>Billing Details</h3>
                    <form class="payment-form" action="{{ route('CheckoutPost') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <p>Full Name *</p>
                                <input type="text" name="full_name" placeholder="Enter Your Full Name">
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Company Name (Optional)</p>
                                <input type="text" name="company_name" placeholder="Enter Your Company Name">
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Email Address *</p>
                                <input type="email" name="email" placeholder="Enter Your Valid Email Address">
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Phone No. *</p>
                                <input type="number" name="phone" placeholder="Enter Phone Number">
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Country *</p>
                                <select id="country_id" name="country_id">
                                    <option >Select a country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>State/Country *</p>
                                <select id="state_country" name="state_id">
                                    
                                </select>
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Town/City *</p>
                                <select id="city_id" name="city_id">
                                    
                                </select>
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Postcode/ZIP</p>
                                <input type="text" name="zipcode" placeholder="Enter Your zipCode">
                            </div>
                            <div class="col-12">
                                <p>Your Address *</p>
                                <input type="text" name="address" placeholder="Enter Your Address">
                            </div>
                            
                            {{-- shipping different --}}
                            <div class="col-12">
                                <input value="1" id="toggle2" name="checkbox" type="checkbox">
                                <label class="fontsize" for="toggle2">Ship to a different address?</label>
                                <div class="row" id="open2">
                                    <div class=" col-12">
                                        <p>Full Name</p>
                                        <input id="s_f_name" name="s_f_name" type="text">
                                    </div>
                                    <div class="col-12">
                                        <p>Company Name</p>
                                        <input id="s_c_name" name="s_c_name" type="text">
                                    </div>
                                    <div class="col-12">
                                        <p>Address</p>
                                        <input type="text" name="s_address" placeholder="Street address">
                                    </div>
                                    <div class="col-12">
                                        <p>Country</p>
                                        <select id="s_country" name="s_country">
                                            <option value="1">Select a country</option>
                                            <option value="2">bangladesh</option>
                                            <option value="3">Algeria</option>
                                            <option value="4">Afghanistan</option>
                                            <option value="5">Ghana</option>
                                            <option value="6">Albania</option>
                                            <option value="7">Bahrain</option>
                                            <option value="8">Colombia</option>
                                            <option value="9">Dominican Republic</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <p>State / Country </p>
                                        <select id="s_state_country" name="s_state_country">
                                            <option value="1">Select a country</option>
                                            <option value="2">bangladesh</option>
                                            <option value="3">Algeria</option>
                                            <option value="4">Afghanistan</option>
                                            <option value="5">Ghana</option>
                                            <option value="6">Albania</option>
                                            <option value="7">Bahrain</option>
                                            <option value="8">Colombia</option>
                                            <option value="9">Dominican Republic</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <p>Town / City </p>
                                        <select id="s_city" name="s_city">
                                            <option value="1">Select a country</option>
                                            <option value="2">bangladesh</option>
                                            <option value="3">Algeria</option>
                                            <option value="4">Afghanistan</option>
                                            <option value="5">Ghana</option>
                                            <option value="6">Albania</option>
                                            <option value="7">Bahrain</option>
                                            <option value="8">Colombia</option>
                                            <option value="9">Dominican Republic</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <p>Postcode / Zip </p>
                                        <input id="s_zip" name="s_zip" type="text" placeholder="Postcode / Zip">
                                    </div>
                                    <div class="col-12">
                                        <p>Email Address </p>
                                        <input id="s_email" name="s_email" type="email">
                                    </div>
                                    <div class="col-12">
                                        <p>Phone </p>
                                        <input id="s_phone" name="s_phone" type="text" placeholder="Phone Number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p>Order Notes </p>
                                <textarea name="notes" placeholder="Notes about Your Order, e.g.Special Note for Delivery"></textarea>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="order-area">
                    <h3>Your Order</h3>
                    @php
                      $sub_total = 0;
                    @endphp
                    <ul class="total-cost">
                        @foreach ($cart as $cart_item)
                        @php
                        $cart_values = App\Models\ProductAttribute::where('product_id' , $cart_item->product_id)->where('color_id' , $cart_item->color_id)->where('size_id' , $cart_item->size_id)->first(); 
                        @endphp
                        <li>{{ $cart_item->product->title }}<span class="pull-right">{{ $cart_values->price }} * {{ $cart_item->quantity }}</span></li>
                        @endforeach
                        <li>Subtotal <span class="pull-right"><strong>
                            @php
                            $sub_total += ($cart_values->price * $cart_item->quantity);
                            @endphp
                        </strong></span></li>
                        <li>Shipping <span class="pull-right">Free</span></li>
                        <li>Total<span class="pull-right"> ৳ {{ $cart_values->price * $cart_item->quantity }}</span></li>
                    </ul>
                    <ul class="payment-method">
                        <li>
                            <input id="bank" name="payment" value="bank" type="radio">
                            <label for="bank">Direct Bank Transfer</label>
                        </li>
                        <li>
                            <input id="paypal" name="payment" value="paypal" type="radio">
                            <label for="paypal">Paypal</label>
                        </li>
                        <li>
                            <input id="card" name="payment" value="card" type="radio">
                            <label for="card">Credit Card</label>
                            <div id="cardclass">
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                                              
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>
                        </li>
                        <li>
                            <input id="delivery" name="payment" value="cash" type="radio">
                            <label for="delivery">Cash on Delivery</label>
                        </li>
                    </ul>
                    <button>Place Order</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_js')
<script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
$('#country_id').change(function(){
var countryID = $(this).val();    
if(countryID){
    $.ajax({
        type:"GET",
        url:"{{url('api/get-state-list')}}/"+countryID,
        success:function(res){               
        if(res){
            $("#state_country").empty();
            $("#state_country").append('<option>Select State</option>');
            $.each(res,function(key,value){
                $("#state_country").append('<option value="'+value.id+'">'+value.name+'</option>');
            });
        
        }else{
            $("#state_country").empty();
        }
        }
    });
}else{
    $("#state_country").empty();
    $("#city_id").empty();
}      
});
$('#state_country').on('change',function(){
var stateID = $(this).val();    
if(stateID){
    $.ajax({
        type:"GET",
        url:"{{url('api/get-city-list')}}/"+stateID,
        success:function(res){               
        if(res){
            $("#city_id").empty();
            $("#city_id").append('<option>Select City</option>');
            $.each(res,function(key,value){
                $("#city_id").append('<option value="'+value.id+'">'+value.name+'</option>');
            });
        
        }else{
            $("#city_id").empty();
        }
        }
    });
}else{
    $("#city_id").empty();
}
    
});
$(document).ready(function() {
    $('#country_id , #state_country , #city_id').select2();
});
</script>
<script>
    $(document).ready(function(){
        $('#paypal').on('click', function(){
            $('#cardclass').hide();
            $(".payment-form").attr("id" , "");
        })
        $('#card').on('click', function(){
            $('#cardclass').show();
            $(".payment-form").attr("id" , "payment-form");
// $(".payment-form").attr("id" , "payment-form");
var stripe = Stripe('pk_test_51ImuNwEWcspB5Pfyygtb9uwF2II64zAYm1SU2rq9dSG6JBo8a4wqmhbFcAakleDkOUIup7EFrxeHEdMS30lNmrwH009j5KNsNQ');
// Create an instance of Elements.
var elements = stripe.elements();
// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
    color: '#aab7c4'
    }
},
invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
}
};
// Create an instance of the card Element.
var card = elements.create('card', {style: style});
// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');
// Handle real-time validation errors from the card Element.
card.on('change', function(event) {
var displayError = document.getElementById('card-errors');
if (event.error) {
    displayError.textContent = event.error.message;
} else {
    displayError.textContent = '';
}
});
// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
event.preventDefault();
stripe.createToken(card).then(function(result) {
    if (result.error) {
    // Inform the user if there was an error.
    var errorElement = document.getElementById('card-errors');
    errorElement.textContent = result.error.message;
    } else {
    // Send the token to your server.
    stripeTokenHandler(result.token);
    }
});
});
// Submit the form with the token ID.
function stripeTokenHandler(token) {
// Insert the token ID into the form so it gets submitted to the server
var form = document.getElementById('payment-form');
var hiddenInput = document.createElement('input');
hiddenInput.setAttribute('type', 'hidden');
hiddenInput.setAttribute('name', 'stripeToken');
hiddenInput.setAttribute('value', token.id);
form.appendChild(hiddenInput);
// Submit the form
form.submit();
}
})
})
</script>
@endsection