@extends('backend.master')
@section('product_active')
    active
@endsection
@section('content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
      <span class="breadcrumb-item active">Add New Product</span>
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
    <form action ="{{ route('ProductPost') }}" method ="POST" enctype = "multipart/form-data">
            @csrf
        <div class="form-layout">
          <div class="row mg-b-25">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
              <div class="form-group">
                <label for="title" class="form-control-label">Product Name: <span class="tx-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Ex:Product Name" id="title">
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
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="Ex:Slug Name" id="slug">
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
                      <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
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
                        <option value="{{ $item->id }}">{{ $item->category_name }}</option>
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
                    <div id="dynamic-field-1" class="form-group dynamic-field">
                      <div class="row">
                        <div class="col-lg-3">
                          <label for="color_name" class="font-weight-bold">Color <span class="tx-danger">*</span></label>
                          <select class="form-control @error('color_name') is-invalid @enderror"" name="color_name[]" id="color_name">
                            <option value>Select Color</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                            @endforeach
                        </select>
                        </div>
                        @error('color_name')
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @enderror
                          {{-- <input type="text" id="field" class="form-control" name="color[]" /> --}}
                        <div class="col-lg-3">
                          <label for="size_name" class="font-weight-bold">Size <span class="tx-danger">*</span></label>
                          <select class="form-control @error('size_name') is-invalid @enderror"" name="size_name[]" id="size_name">
                            <option value>Select Size</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                            @endforeach
                        </select>
                        </div>
                        @error('size_name')
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @enderror
                          {{-- <input type="text" id="field" class="form-control" name="size[]" />
                        </div> --}}
                        <div class="col-lg-3">
                          <label for="price" class="font-weight-bold">Price <span class="tx-danger">*</span></label>
                          <input type="number" id="price" placeholder="Price" class="form-control" name="prices[]" />
                        </div>
                        @error('price')
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @enderror
                        <div class="col-lg-3">
                          <label for="quantity" class="font-weight-bold">Quantity <span class="tx-danger">*</span></label>
                          <input type="number" id="quantity" placeholder="Quantity" class="form-control" name="quantity[]" />
                        </div>
                        @error('quantity')
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @enderror
                      </div>
                    </div>
                    <div class="clearfix mt-4 mb-4">
                      <button type="button" id="add-button" class="btn btn-secondary float-left text-uppercase shadow-sm"><i class="fa fa-plus fa-fw"></i> Add</button>
                      <button type="button" id="remove-button" class="btn btn-secondary float-left text-uppercase ml-1" disabled="disabled"><i class="fa fa-minus fa-fw"></i> Remove</button>
                  </div>
                <div class="form-group">
                    <label for="price" class="form-control-label">Product Price: <span class="tx-danger">*</span></label>
                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="Ex:Product Price 500" id="price">
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
                    <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" value="{{ old('thumbnail') }}" onchange="document.getElementById('adimage_id').src = window.URL.createObjectURL(this.files[0])">
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
                  <div>
                    <img style = "border: 3px solid #000; padding: 5px" width="200" src="" id="adimage_id" alt="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="image" class="form-control-label">Product Image (Recommended Image Size 300 * 300): <span class="tx-danger">*</span></label>
                  <input type="file"  id="images" name="image[]" onchange="preview_images();" multiple class="form-control @error('image') is-invalid @enderror" id="image_preview" value="{{ old('image') }}"/>
              </div>
              @error('image')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ $message }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @enderror
              <div class="form-group">
                <label for="image" class="form-control-label">Preview Image: <span class="tx-danger">*</span></label>
                <div class="row" id="image_preview"></div>
              </div>
                <div class="form-group">
                    <label for="summery" class="form-control-label">Product Summery: <span class="tx-danger">*</span></label>
                    <textarea name="summery" id="summery" class="form-control @error('summery') is-invalid @enderror" placeholder="Enter Product Summery" value="{{ old('summery') }}"></textarea>
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
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Product Description" value="{{ old('description') }}"></textarea>
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
            <div class="col-lg-1"></div>
          </div><!-- row -->
          <div class="form-layout-footer text-center">
            <button type="submit" class="btn btn-info mg-r-5 text-center" style = "cursor: pointer">Add Product</button>
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
  <script>
    function openWindow(){
      window.open("{{ route('CategoryAdd') }}?add=N", "myWindow", 'width=1000, height=500');
      window.close();
    }
  </script>
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
    <script>
      function preview_images() 
      {
      var total_file=document.getElementById("images").files.length;
      for(var i=0;i<total_file;i++)
      {
        $('#image_preview').append("<div class='col-md-3'><img width=100 class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
      }
      }
    </script>
    <script>
      var buttonAdd = $("#add-button");
      var buttonRemove = $("#remove-button");
      var className = ".dynamic-field";
      var count = 0;
      var field = "";
      var maxFields = "";

      function totalFields() {
        return $(className).length;
      }

      function addNewField() {
        count = totalFields() + 1;
        field = $("#dynamic-field-1").clone();
        field.attr("id", "dynamic-field-" + count);
        field.children("label").text("Field " + count);
        field.find("input").val("");
        $(className + ":last").after($(field));
      }

      function removeLastField() {
        if (totalFields() > 1) {
          $(className + ":last").remove();
        }
      }

      function enableButtonRemove() {
        if (totalFields() === 2) {
          buttonRemove.removeAttr("disabled");
          buttonRemove.addClass("shadow-sm");
        }
      }

      function disableButtonRemove() {
        if (totalFields() === 1) {
          buttonRemove.attr("disabled", "disabled");
          buttonRemove.removeClass("shadow-sm");
        }
      }

      function disableButtonAdd() {
        if (totalFields() === maxFields) {
          buttonAdd.attr("disabled", "disabled");
          buttonAdd.removeClass("shadow-sm");
        }
      }

      function enableButtonAdd() {
        if (totalFields() === (maxFields - 1)) {
          buttonAdd.removeAttr("disabled");
          buttonAdd.addClass("shadow-sm");
        }
      }

      buttonAdd.click(function() {
        addNewField();
        enableButtonRemove();
        disableButtonAdd();
      });

      buttonRemove.click(function() {
        removeLastField();
        disableButtonRemove();
        enableButtonAdd();
      });
    </script>
  @endsection