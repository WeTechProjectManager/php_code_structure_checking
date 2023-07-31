@extends('layouts.master')
@section('content')

    {{-- message --}}
    {!! Toastr::message() !!}
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Content -->
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Privacy Policy</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Privacy Policy</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                        </div>
                    </div><hr>
                </div>


                <!-- /Page Header -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- Page Header -->
                        <div class="page-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert text-center" role="alert" style="background-color: #495057; color:white;">Privacy Policy</div>
                                </div>
                            </div>
                        </div>
                        <!-- /Page Header -->
                        <form action="{{route('privacy_policy.update')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Title </label>
                                        <input name="title" class="form-control" type="text" value="{{$privacyPolicy->title ?? ''}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" rows="6" name="description">{{$privacyPolicy->description ?? ''}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn submit-btn btn-success">Submit Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
        <!-- /Page Wrapper -->
@endsection
