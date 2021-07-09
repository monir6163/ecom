@extends('backend.master')
@section('cupon_active')
    active
@endsection
@section('content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
      <span class="breadcrumb-item active">All Product Cupon List</span>
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
      <div class="row">
          <div class="col-lg-8">
            <div class="card pd-10 ">
                <h3 class="text-center">Cupon List</h3>
                {{-- @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Wow!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif --}}
                @if(session('delete'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Wow!</strong> {{ session('delete') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                  <div class="table-responsive">
                      <table class="table table-bordered table-primary">
                        
                        <thead>
                          <th class="text-center">SL</th>
                          <th class="text-center">Name</th>
                          <th class="text-center">Code</th>
                          <th class="text-center">Type</th>
                          <th class="text-center">Discount</th>
                          <th class="text-center">Min</th>
                          <th class="text-center">End</th>
                          <th class="text-center">Created</th>
                          <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                           @foreach($cupons as $key => $cupon)
                            <tr class="text-center">
                              {{-- <td><input type="checkbox" name="delete[]" value="{{ $data->id }}"></td> --}}
                              {{-- <td>{{ $categories->firstItem() + $key }}</td> --}}
                              <td>{{ $loop->index + 1 }}</td>
                              <td>{{ $cupon->name }}</td>
                              <td>{{ $cupon->code }}</td>
                              <td>{{ $cupon->discount_type == 1 ? '%' : 'TK' }}</td>
                              <td>{{ $cupon->discount_amount }}{{ $cupon->discount_type == 1 ? '%' : 'TK' }}</td>
                              <td>{{ $cupon->min_amount }}</td>
                              <td>{{ $cupon->end_validity }}</td>
                              <td>{{ $cupon->created_at != null ? $cupon->created_at->diffForHumans() : 'N/A' }}</td>
                              {{-- <td>{{ $cupon->updated_at != null ? $cupon->updated_at->diffForHumans() : 'N/A' }}</td> --}}
                              <td>
                                  <a class="btn btn-outline-info" href="{{ url('admin/category-edit') }}/{{ $cupon->id }}">Edit</a>
                                  <a class="btn btn-outline-danger" href="{{ url('admin/category-delete') }}/{{ $cupon->id }}">Delete</a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{-- {{ $categories->links() }} --}}
                    </div><!-- table-responsive -->
              </div><!-- card -->
          </div>
          <div class="col-lg-4">
            <div class="card pd-20">
                <form action="{{ route('CuponPost') }}" method="POST">
                        @csrf
                    <div class="form-layout">
                          <div class="form-group">
                            <label for="name" class="form-control-label">Cupon Name: <span class="tx-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ex:Cupon Name" id="name">
                          </div>
                              @error('name')
                              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              @enderror
                          <div class="form-group">
                            <label for="code" class="form-control-label">Cupon code: <span class="tx-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ Str::random(10) }}" placeholder="Ex:Cupon code">
                        </div>
                        @error('code')
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @enderror
                        <div class="form-group">
                            <label for="start_validity" class="form-control-label">Start Cupon Time: <span class="tx-danger">*</span></label>
                            <input type="date" name="start_validity" class="form-control @error('start_validity') is-invalid @enderror" value="{{ old('start_validity') }}" placeholder="Ex:Start Cupon Time">
                        </div>
                        @error('start_validity')
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @enderror
                        <div class="form-group">
                            <label for="end_validity" class="form-control-label">End Cupon Time: <span class="tx-danger">*</span></label>
                            <input type="date" name="end_validity" class="form-control @error('end_validity') is-invalid @enderror" value="{{ old('end_validity') }}" placeholder="Ex:End Cupon Time">
                        </div>
                        @error('end_validity')
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @enderror
                        <div class="form-group">
                            <label for="discount_type" class="form-control-label">Discount Type: <span class="tx-danger">*</span></label>
                            <select name="discount_type" id="" class="form-control @error('discount_type') is-invalid @enderror">
                                <option value>Select Type</option>
                                <option value="1">%</option>
                                <option value="2">Tk</option>
                            </select>
                            {{-- <input type="text" name="discount_type" class="form-control @error('discount_type') is-invalid @enderror" value="{{ old('discount_type') }}" placeholder="Ex:End Cupon Time"> --}}
                        </div>
                        @error('discount_type')
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @enderror
                        <div class="form-group">
                            <label for="discount_amount" class="form-control-label">Discount: <span class="tx-danger">*</span></label>
                            <input type="text" name="discount_amount" class="form-control @error('discount_amount') is-invalid @enderror" value="{{ old('discount_amount') }}" placeholder="Ex:Discount Price 50">
                        </div>
                        @error('discount_amount')
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @enderror
                        <div class="form-group">
                            <label for="min_amount" class="form-control-label">Min Order Price: <span class="tx-danger">*</span></label>
                            <input type="text" name="min_amount" class="form-control @error('min_amount') is-invalid @enderror" value="{{ old('min_amount') }}" placeholder="Ex:Min Order Price 500">
                        </div>
                        @error('min_amount')
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @enderror
                      <div class="form-layout-footer text-center">
                        <button type="submit" class="btn btn-info mg-r-5 text-center" style = "cursor: pointer">Add Cupon</button>
                      </div><!-- form-layout-footer -->
                    </div><!-- form-layout -->
                </form>
                  </div><!-- card -->
          </div>
      </div>

    </div><!-- sl-pagebody -->
    <?php
  if (!isset($_GET['add'])) {?>
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
    <?php } 
    ?>
  </div><!-- sl-mainpanel -->
  <!-- ########## END: MAIN PANEL ########## -->
  @endsection

  @section('footer_js')
    <script>
        $('#category_name').keyup(function() {
        $('#slug').val($(this).val().toLowerCase().split(',').join('').replace(/\s/g,"-"));
        });
    </script>
  @endsection