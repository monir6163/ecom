@extends('frontend.master')
@section('title')
 {{ __('Shop Page') }}   
@endsection
@section('shop')
    active
@endsection
@section('content')
<div class="breadcumb-area bg-img-4 ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Shop Page</h2>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><span>Shop</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-area pt-100">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="product-menu">
                    <ul class="nav justify-content-center">
                        <li>
                            <a class="active" data-toggle="tab" href="#all">All product</a>
                        </li>
                        @foreach ($categories as $p_cat)
                        <li>
                            <a data-toggle="tab" href="#chair{{ $p_cat->id }}">{{ $p_cat->category_name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="all">
                <ul class="row">
                    @foreach ($all_products as $all_pro)
                    <li class="col-xl-3 col-lg-4 col-sm-6 col-12">
                        <div class="product-wrap">
                            <div class="product-img">
                                <span>Sale</span>
                                <img src="{{ asset('images/'.$all_pro->created_at->format('Y/m/').$all_pro->id.'/'.$all_pro->thumbnail) }}" alt="{{ $all_pro->title }}">
                                <div class="product-icon flex-style">
                                    <ul>
                                        <li><a data-toggle="modal" data-target="#AllModal{{ $all_pro->id }}" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="wishlist.html"><i class="fa fa-heart"></i></a></li>
                                        <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{ route('SingleProduct' , $all_pro->slug) }}">{{ $all_pro->title }}</a></h3>
                                <p class="pull-left">৳ {{ $all_pro->price }}

                                </p>
                                <ul class="pull-right d-flex">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star-half-o"></i></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <!-- Modal area start -->
                    <div class="modal fade" id="AllModal{{ $all_pro->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="modal-body d-flex">
                                    <div class="product-single-img w-50">
                                        <img src="{{ asset('images/'.$all_pro->created_at->format('Y/m/').$all_pro->id.'/'.$all_pro->thumbnail) }}" alt="{{ $all_pro->title }}">
                                    </div>
                                    <div class="product-single-content w-50">
                                        <h3>{{ $all_pro->title }}</h3>
                                        <div class="rating-wrap fix">
                                            <span class="pull-left">৳ {{ $all_pro->price }} </span>
                                            <ul class="rating pull-right">
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li>(05 Customar Review)</li>
                                            </ul>
                                        </div>
                                        <p>{{ $all_pro->summery }}</p>
                                        <ul class="input-style">
                                            <li class="quantity cart-plus-minus">
                                                <input type="text" value="1" />
                                            </li>
                                            <li><a href="cart.html">Add to Cart</a></li>
                                        </ul>
                                        <ul class="cetagory">
                                            <li>Categories:</li>
                                            <li><a href="#">{{ $all_pro->category->category_name }}</a></li>,
                                            <li>SubCategories:</li>
                                            <li><a href="#">{{ $all_pro->subcategory->subcategory_name }}</a></li>
                                        </ul>
                                        <ul class="socil-icon">
                                            <li>Share :</li>
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              <!-- Modal area start -->
                    @endforeach
                    {{-- <li class="col-xl-3 col-lg-4 col-sm-6 col-12  moreload" style="display: none;">
                        <div class="product-wrap">
                            <div class="product-img">
                                <span>Sale</span>
                                <img src="assets/images/product/5.jpg" alt="">
                                <div class="product-icon flex-style">
                                    <ul>
                                        <li><a data-toggle="modal" data-target="#exampleModalCenter" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="wishlist.html"><i class="fa fa-heart"></i></a></li>
                                        <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="single-product.html">Pure Nature Product</a></h3>
                                <p class="pull-left">$125

                                </p>
                                <ul class="pull-right d-flex">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star-half-o"></i></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 text-center">
                        <a class="loadmore-btn" href="javascript:void(0);">Load More</a>
                    </li> --}}
                </ul>
            </div>
            @foreach ($categories as $p_cat)
            <div class="tab-pane" id="chair{{ $p_cat->id }}">
                <ul class="row">
                    @foreach ($p_cat->product as $cat_pro)
                    <li class="col-xl-3 col-lg-4 col-sm-6 col-12">
                        <div class="product-wrap">
                            <div class="product-img">
                                <span>Sale</span>
                                <img src="{{ asset('images/'.$cat_pro->created_at->format('Y/m/').$cat_pro->id.'/'.$cat_pro->thumbnail) }}" alt="{{ $cat_pro->title }}">
                                <div class="product-icon flex-style">
                                    <ul>
                                        <li><a data-toggle="modal" data-target="#catmodal{{ $cat_pro->id }}" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="wishlist.html"><i class="fa fa-heart"></i></a></li>
                                        <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{ route('SingleProduct' , $cat_pro->slug) }}">{{ $cat_pro->title }}</a></h3>
                                <p class="pull-left">৳ {{ $cat_pro->price }}

                                </p>
                                <ul class="pull-right d-flex">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star-half-o"></i></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <!-- Modal area start -->
                    <div class="modal fade" id="catmodal{{ $cat_pro->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="modal-body d-flex">
                                    <div class="product-single-img w-50">
                                        <img src="{{ asset('images/'.$cat_pro->created_at->format('Y/m/').$cat_pro->id.'/'.$cat_pro->thumbnail) }}" alt="{{ $cat_pro->title }}">
                                    </div>
                                    <div class="product-single-content w-50">
                                        <h3>{{ $cat_pro->title }}</h3>
                                        <div class="rating-wrap fix">
                                            <span class="pull-left">৳ {{ $cat_pro->price }} </span>
                                            <ul class="rating pull-right">
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li>(05 Customar Review)</li>
                                            </ul>
                                        </div>
                                        <p>{{ $cat_pro->summery }}</p>
                                        <ul class="input-style">
                                            <li class="quantity cart-plus-minus">
                                                <input type="text" value="1" />
                                            </li>
                                            <li><a href="cart.html">Add to Cart</a></li>
                                        </ul>
                                        <ul class="cetagory">
                                            <li>Categories:</li>
                                            <li><a href="#">{{ $cat_pro->category->category_name }}</a></li>,
                                            <li>SubCategories:</li>
                                            <li><a href="#">{{ $cat_pro->subcategory->subcategory_name }}</a></li>
                                        </ul>
                                        <ul class="socil-icon">
                                            <li>Share :</li>
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              <!-- Modal area start -->
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection