@extends('backend.master')
@section('brand_active')
    active
@endsection
@section('content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
      <span class="breadcrumb-item active">Add New Product Brand</span>
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
    <form action="{{ route('ProductBrandPost') }}" method="POST">
            @csrf
        <div class="form-layout">
          <div class="row mg-b-25">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="brand_name" class="form-control-label">Brand Name: <span class="tx-danger">*</span></label>
                <input type="text" name="brand_name" class="form-control @error('brand_name') is-invalid @enderror" value="{{ old('brand_name') }}" placeholder="Ex:Brand Name" id="brand_name">
              </div>
                  @error('brand_name')
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
              <div class="form-group">
                <label for="slug" class="form-control-label">Brand Slug: <span class="tx-danger">*</span></label>
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
            </div><!-- col-4 -->
            <div class="col-lg-3"></div>
          </div><!-- row -->
          <div class="form-layout-footer text-center">
            <button type="submit" class="btn btn-info mg-r-5 text-center" style = "cursor: pointer">Add Brand</button>
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
        $('#brand_name').keyup(function() {
        $('#slug').val($(this).val().toLowerCase().split(',').join('').replace(/\s/g,"-"));
        });
    </script>
  @endsection