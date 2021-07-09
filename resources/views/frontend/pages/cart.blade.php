@extends('frontend.master')
@section('cart')
    active
@endsection
@section('title')
    {{ __('Shopping Cart Page') }}
@endsection
@section('content')
<div class="breadcumb-area bg-img-4 ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Shopping Cart</h2>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><span>Shopping Cart</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cart-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('CartUpdate') }}" method="POST">
                    @csrf
                    <table class="table-responsive cart-wrap">
                        <thead>
                            <tr>
                                <th class="images">Image</th>
                                <th class="product">Product</th>
                                <th class="ptice">Price</th>
                                <th class="ptice">Color</th>
                                <th class="ptice">Size</th>
                                <th class="quantity">Quantity</th>
                                <th class="total">Total</th>
                                <th class="remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sub_total = 0;
                            @endphp
                            @foreach ($carts as $cart_item)
                            <input type="hidden" name="cart_id[]" value="{{ $cart_item->id }}">
                            <tr>
                                @php
                                   $cart_values = App\Models\ProductAttribute::where('product_id' , $cart_item->product_id)->where('color_id' , $cart_item->color_id)->where('size_id' , $cart_item->size_id)->first(); 
                                @endphp
                                <td class="images"><img src="{{ asset('images/'.$cart_item->product->created_at->format('Y/m/').$cart_item->product_id.'/'.$cart_item->product->thumbnail) }}" alt="{{ $cart_item->product->title }}"></td>
                                <td class="product"><a href="{{ route('SingleProduct' , $cart_item->product->slug) }}">{{ $cart_item->product->title }}</a></td>
                                <td class="ptice unit_price{{ $cart_item->id }}" data-unit{{ $cart_item->id }}="{{ $cart_values->price }}">{{ $cart_values->price }} </td>
                                <td class="ptice">@isset($cart_item->color){{ $cart_item->color->color_name}} @else N/A                                  
                                @endisset</td>
                                <td class="ptice">@isset($cart_item->size){{ $cart_item->size->size_name}} @else N/A                                  
                                @endisset</td>
                                <td class="quantity cart-plus-minus">
                                    <input type="text" class="qty_quantity{{ $cart_item->id }}" name="quantity[]" value="{{ $cart_item->quantity }}">
                                    
                                    <div class="dec qtybutton qtyminus{{ $cart_item->id }}">-</div>
                                    <div class="inc qtybutton qtyplus{{ $cart_item->id }}">+</div>
                              </td>
                              @php
                                  $sub_total += ($cart_values->price * $cart_item->quantity);
                              @endphp
                                <td class="total"> <span>৳ </span> <span class="selectall total_unit{{ $cart_item->id }}">{{ $cart_values->price * $cart_item->quantity }}</span></td>
                                <td class="remove"><i class="fa fa-times"></i></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row mt-60">
                        <div class="col-xl-4 col-lg-5 col-md-6 ">
                            <div class="cartcupon-wrap">
                                <ul class="d-flex">
                                    <li>
                                        <button>Update Cart</button>
                                    </li>
                                    <li><a href="{{ route('Shop') }}">Continue Shopping</a></li>
                                </ul>
                                <h3>Cupon</h3>
                                <p>Enter Your Cupon Code if You Have One</p>
                                @if (session('ivalid'))
                                    <div class="alert alert-danger out">
                                        {{ session('ivalid') }}
                                    </div>
                                @endif
                                <style>
                                .cupon-wrap span {
                                    width: 150px;
                                    height: 45px;
                                    position: absolute;
                                    right: 0;
                                    top: 0;
                                    background: #ef4836;
                                    color: #fff;
                                    text-transform: uppercase;
                                    border: none;
                                    padding: 12px !important;
                                }
                                </style>
                                <div class="cupon-wrap">
                                    <input type="text" class="cupon" placeholder="Cupon Code" value="{{ $cupon ?? old('cupon') }}">
                                    <span id="cupon">Apply Cupon</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 offset-xl-5 col-lg-4 offset-lg-3 col-md-6">
                            <div class="cart-total text-right">
                                <h3>Cart Totals</h3>
                                <ul>
                                    <li><span class="pull-left">Subtotal </span><span class="total_price">৳ {{ $sub_total }}</span></li>

                                    @isset($discount_type)
                                        
                                    <li>
                                        <span class="pull-left">Discount ({{ $discount_type == 1 ? '%' : '৳' }}) </span>

                                        <span class="total_price"> {{ $discount_amount ?? "" }} {{ $discount_type == 1 ? '%' : '৳' }}</span>
                                    </li>

                                    @endisset

                                    <li><span class="pull-left"> Total </span> ৳
                                    @if ($discount_type == 1)
                                        @if ($min_amount <= $sub_total)
                                        {{ $sub_total - $sub_total * ($discount_amount / 100) }}
                                            @else
                                            {{ $sub_total }}
                                        @endif
                                    @else
                                            @if ($min_amount <= $sub_total)
                                            {{ $sub_total - $discount_amount }}
                                            @else
                                            {{ $sub_total }}
                                            @endif
                                    @endif
                                    </li>
                                </ul>
                                <a href="{{ route('Checkout') }}">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_js')
<script>
    $(".out").fadeOut(3000);
    $('#cupon').click(function(){
        var cupon = $('.cupon').val();
        window.location.href = "{{ url('cart') }}/"+cupon;
    })
    /*-----------------------
       cart-plus-minus-button
     -------------------------*/
    $(".qtybutton").on("click", function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find("input").val(newVal);
    });
    @foreach ($carts as $cart_item)
    $('.qtyminus{{ $cart_item->id }}').click(function(){
        let qty_quantity = $('.qty_quantity{{ $cart_item->id }}').val();
        let unit_price = $('.unit_price{{ $cart_item->id }}').attr('data-unit{{ $cart_item->id }}');
        $('.total_unit{{ $cart_item->id }}').html(qty_quantity*unit_price);
        let minus_sub_total = (qty_quantity*unit_price);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"{{ url('ajax/cart/update') }}",
            method:'post',
            data:{
                id:'{{ $cart_item->id }}',
                qty:qty_quantity
            }
        });
        let c = document.querySelectorAll('.selectall');
        let arr = Array.from(c);
        let sum = 0;
        arr.map(item=>{
            sum += parseInt(item.innerHTML);
            $('.total_price').html('৳ ' + sum);
        })
    })
    $('.qtyplus{{ $cart_item->id }}').click(function(){
        let qty_quantity = $('.qty_quantity{{ $cart_item->id }}').val();
        let unit_price = $('.unit_price{{ $cart_item->id }}').attr('data-unit{{ $cart_item->id }}');
        $('.total_unit{{ $cart_item->id }}').html(qty_quantity*unit_price);
        let plus_sub_total = (qty_quantity*unit_price);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"{{ url('ajax/cart/update') }}",
            method:'post',
            data:{
                id:'{{ $cart_item->id }}',
                qty:qty_quantity
            }
        });
        let c = document.querySelectorAll('.selectall');
        let arr = Array.from(c);
        let sum = 0;
        arr.map(item=>{
            sum += parseInt(item.innerHTML);
            $('.total_price').html('৳ ' + sum);
        })
    })
    @endforeach
</script>
@endsection