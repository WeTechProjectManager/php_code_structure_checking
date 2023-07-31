@extends('layouts.master')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Banner Ad</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Banner Ad</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn bg-info" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Add Banner</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filter -->
            <form action="{{ route('banner_ad.index') }}" method="get">
                @csrf
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <input type="date" class="form-control" id="date" name="date" value="{{Request()->get('date')}}">
                            {{--                            <label class="focus-label">Date</label>--}}
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button type="submit" class="btn btn-success btn-block"> Search </button>
                    </div>
                </div>
            </form>
            <!-- /Search Filter -->

            <!-- error message -->
            @if(count($errors) > 0 )
                <div class="row p-3">
                    <div class="col-sm-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul class="p-0 m-0" style="list-style: none;">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            <!-- /error message -->

            {{-- message --}}
            {!! Toastr::message() !!}

            <div class="row">
                <div class="col-md-12">
                    <h4 style="color: dimgray"><i class="fa fa-list-alt"><strong> Banner Ad List</strong></i></h4>
                    <div class="table-responsive">
                        <h5><i class="fa fa-list-alt"></i> Total : <span>{{ $total_banner ?? 0 }}</span></h5>
                        <table class="table table-striped custom-table datatable" id="DataTable">
                            <thead class="thead-light">
                            <tr>
                                <th># @if(!empty(Request()->get('page'))) Page: {{Request()->get('page')}} @else Page: 1 @endif</th>
                                <th>Banner</th>
                                <th>Description</th>
                                <th>Show Second</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($banners as $key=>$banner )
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td hidden class="ids">{{ $banner->id }}</td>
                                    <td class="image">
                                        <img style="width: 200px;height: 100px" src="{{ asset('upload/adBanner') }}/{{$banner->image}}" alt="">
                                    </td>
                                    <td class="description">{{ $banner->description }}</td>
                                    <td class="second">{{ $banner->second }}</td>
                                    <td>
                                        @if($banner->created_at)
                                            {{date('d M Y', strtotime($banner->created_at))}}
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row pt-3 pl-3">
                    <div class="col-md-12">
                        {{$banners->appends($_GET)->links()}}
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Modal -->
        <div id="add" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Banner</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('banner_ad.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" rows="4" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Banner Image <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" id="" name="image" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Show Second</label>
                                        <input class="form-control" type="number" id="" name="second" value="" >
                                    </div>
                                </div>
                            </div>

                            <div class="submit-section">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Modal -->

    </div>
    <!-- /Page Wrapper -->

@endsection

@section('script')

@endsection
