@extends('backend.master')
@section('product_active')
    active
@endsection
@section('content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
      <span class="breadcrumb-item active">Update Product</span>
    </nav>

    <div class="sl-pagebody">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Wow!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
      <div class="card pd-20 pd-sm-40">
    <form action ="{{ route('ProductUpdate') }}" method ="POST" enctype = "multipart/form-data">
            @csrf
        <div class="form-layout">
          <div class="row mg-b-25">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <div class="form-group">
                <label for="title" class="form-control-label">Product Name: <span class="tx-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $product->title ?? old('title') }}" placeholder="Ex:Product Name" id="title">
                </div>
                @error('title')
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @enderror
                <div class="form-group">
                    <label for="slug" class="form-control-label">Product Slug: <span class="tx-danger">*</span></label>
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ $product->slug ?? old('slug') }}" placeholder="Ex:Slug Name" id="slug">
                </div>
                @error('slug')
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @enderror
                <div class="form-group">
                  <label for="brand_id" class="form-control-label">Brand Name: <span class="tx-danger">*</span></label>
              <select class="form-control @error('brand_id') is-invalid @enderror"" name="brand_id" id="brand_id">
                  <option value>Select Brand</option>
                  @foreach ($brands as $brand)
                      <option
                      @if ($product->brand_id == $brand->id)
                      selected
                      @endif
                      value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                  @endforeach
              </select>
              </div>
              @error('brand_id')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ $message }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @enderror
                <div class="form-group">
                    <label for="category_id" class="form-control-label">Category Name: <span class="tx-danger">*</span></label>
                <select class="form-control @error('category_id') is-invalid @enderror"" name="category_id" id="category_id">
                    <option value>Select Category</option>
                    @foreach ($categories as $item)
                        <option
                        @if ($product->category_id == $item->id)
                        selected
                        @endif
                        value="{{ $item->id }}">{{ $item->category_name }}</option>
                    @endforeach
                </select>
                </div>
                @error('category_id')
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @enderror
                <div class="form-group">
                    <label for="subcategory_id" class="form-control-label">SubCategory Name: <span class="tx-danger">*</span></label>
                <select class="form-control @error('subcategory_id') is-invalid @enderror"" name="subcategory_id" id="subcategory_id">
                  @foreach ($subcategories as $sitem)
                  <option
                  @if ($product->subcategory_id == $sitem->id)
                  selected
                  @endif
                  value="{{ $sitem->id }}">{{ $sitem->subcategory_name }}</option>
                  @endforeach
                </select>
                </div>
                @error('subcategory_id')
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @enderror
                <div class="form-group">
                    <label for="price" class="form-control-label">Product Price: <span class="tx-danger">*</span></label>
                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ $product->price ?? old('price') }}" placeholder="Ex:Product Price 500" id="price">
                </div>
                @error('price')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="thumbnail" class="form-control-label">Product Thumbnail (Recommended Image Size 300 * 300): <span class="tx-danger">*</span></label>
                    <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" value="{{ old('thumbnail') }}" onchange="document.getElementById('image_id').src = window.URL.createObjectURL(this.files[0])">
                </div>
                @error('thumbnail')
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @enderror
                <div class="form-group">
                  <label for="thumbnail" class="form-control-label">Preview Thumbnail: <span class="tx-danger">*</span></label>
                  <div >
                    <img style = "border: 3px solid #000; padding: 5px" width="200" src="{{ asset('images/'.$product->created_at->format('Y/m/').$product->id.'/'.$product->thumbnail) }}" id="image_id" alt="{{ $product->title }}">
                  </div>
                </div>
                <div class="form-group">
                    <label for="summery" class="form-control-label">Product Summery: <span class="tx-danger">*</span></label>
                    <textarea name="summery" id="summery" class="form-control @error('summery') is-invalid @enderror" placeholder="Enter Product Summery">{{ $product->summery ?? old('summery') }}</textarea>
                </div>
                @error('summery')
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @enderror
                <div class="form-group">
                    <label for="description" class="form-control-label">Product Description: <span class="tx-danger">*</span></label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Product Description">{{ $product->description ?? old('description') }}</textarea>
                </div>
                @error('description')
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @enderror
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-3"></div>
          </div><!-- row -->
          <div class="form-layout-footer text-center">
            <button type="submit" class="btn btn-info mg-r-5 text-center" style = "cursor: pointer">Update Product</button>
          </div><!-- form-layout-footer -->
        </div><!-- form-layout -->
    </form>
      </div><!-- card -->

    </div><!-- sl-pagebody -->
    <footer class="sl-footer">
      <div class="footer-left">
        <div class="mg-b-2">Copyright &copy; 2017. Starlight. All Rights Reserved.</div>
        <div>Made by ThemePixels.</div>
      </div>
      <div class="footer-right d-flex align-items-center">
        <span class="tx-uppercase mg-r-10">Share:</span>
        <a target="_blank" class="pd-x-5" href="https://www.facebook.com/sharer/sharer.php?u=http%3A//themepixels.me/starlight"><i class="fa fa-facebook tx-20"></i></a>
        <a target="_blank" class="pd-x-5" href="https://twitter.com/home?status=Starlight,%20your%20best%20choice%20for%20premium%20quality%20admin%20template%20from%20Bootstrap.%20Get%20it%20now%20at%20http%3A//themepixels.me/starlight"><i class="fa fa-twitter tx-20"></i></a>
      </div>
    </footer>
  </div><!-- sl-mainpanel -->
  <!-- ########## END: MAIN PANEL ########## -->
  @endsection
  @section('footer_js')
    <script>
        $('#title').keyup(function() {
        $('#slug').val($(this).val().toLowerCase().split(',').join('').replace(/\s/g,"-"));
        });

        $('#category_id').change(function(){
            let category_id = $(this).val()
            if(category_id){
                $.ajax({
                    type : "GET",
                    url : "{{ url('admin/get-subcat-api/') }}/"+ category_id,
                    success : function(e){
                        if(e){
                            $('#subcategory_id').empty();
                            $('#subcategory_id').append('<option value>Select SubCategory</option>');
                            $.each(e, function(key, value){
                                $('#subcategory_id').append('<option value = "'+value.id+'">'+value.subcategory_name+'</option>');
                            })
                        }else{
                            $('#subcategory_id').empty();
                        }
                    }
                })
            }else{
                $('#subcategory_id').empty();
            }
        })
    </script>  
  @endsection