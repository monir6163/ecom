@extends('backend.master')
@section('product_active')
    active
@endsection
@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
      <span class="breadcrumb-item active text-capitalize">{{ $last ?? "N/A" }}</span>
    </nav>

    <div class="sl-pagebody">
      <h5 class="text-center">All Product ({{ $product_count }})</h5>
        <div class="row row-sm mg-t-20">
          <div class="col-xl-12">
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
              <a href="{{ route('ProductAdd') }}" class="btn btn-pink" style = "float: right">Add New Product <i class="fa fa-plus"></i></a>
              <br>
              @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Wow!</strong> {{ session('success') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              @endif
              @if(session('delete'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Wow!</strong> {{ session('delete') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              @endif
              <form action="{{ url('admin/subcategory/multidelete') }}" method="POST">
                @csrf
                CheckAll <input type="checkbox" id="checkAll" value="checkAll">
                <button type="submit" class="btn btn-danger">Delete All</button>
                <div class="table-responsive">
                    <table class="table table-bordered table-primary mg-b-0" id="datatable1">
                      <thead>
                        <th class="text-center">All</th>
                        <th class="text-center">SL</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Brand</th>
                        <th class="text-center">Cat-Name</th>
                        <th class="text-center">SubCatName</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Created</th>
                        <th class="text-center">Updated</th>
                        <th class="text-center">Action</th>
                      </thead>
                      <tbody>
                        @foreach($products as $key => $data)
                          <tr class="text-center">
                            <td><input type="checkbox" name="delete[]" value="{{ $data->id }}"></td>
                            {{-- <td>{{ $products->firstItem() + $key }}</td> --}}
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $data->title }}</td>
                            <td>{{ $data->brand_list->brand_name ?? 'N/A' }}</td>
                            <td>{{ $data->category->category_name ?? 'N/A' }}</td>
                            <td>{{ $data->subcategory->subcategory_name ?? 'N/A' }}</td>
                            <td>{{ $data->price }}</td>
                            <td><a download href="{{ asset('images/'.$data->created_at->format('Y/m/').$data->id.'/'.$data->thumbnail) }}"><img width = 50 src="{{ asset('images/'.$data->created_at->format('Y/m/').$data->id.'/'.$data->thumbnail) }}" alt="{{ $data->title }}"></a></td>
                            <td>{{ $data->created_at != null ? $data->created_at->diffForHumans() : 'N/A' }}</td>
                            <td>{{ $data->updated_at != null ? $data->updated_at->diffForHumans() : 'N/A' }}</td>
                            <td>
                                <a class="btn btn-outline-info" href="{{ route('ProductEdit', $data->id) }}">Edit</a>
                                <a class="btn btn-outline-danger" href="{{ url('admin/subcategory-delete/') }}/{{ $data->id }}">Delete</a>
                            </td>
                          </tr>
                        @endforeach
                        </form>
                      </tbody>
                    </table>
                    {{-- {{ $products->links() }} --}}
                  </div><!-- table-responsive -->
            </div><!-- card -->
          </div><!-- col-6 -->
        </div><!-- row -->
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
  </div>
@endsection