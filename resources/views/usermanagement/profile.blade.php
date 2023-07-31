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
                        <h3 class="page-title">User Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

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
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            @if($user->image)
                            <img class="card-img-top " style="display: block;margin-left: auto;margin-right: auto;width: 80%;" src="{{asset('assets/user')}}/{{$user->image ?? ''}}" alt="Post Image">
                            @else
                                <img class="card-img-top " style="display: block;margin-left: auto;margin-right: auto;width: 100%;" src="{{asset('assets/user/user.jpg')}}" alt="Post Image">
                            @endif
                        </div>
                        <div class="col-md-12 pt-2" style="background-color: #e9ecef">
                            <h4>Name : {{$user->name}}</h4>
                            <h5>Email : {{$user->email}}</h5>
                            <h5>Phone : {{$user->phone ?? ''}}</h5>
                            <h5>Gender : {{$user->gender ?? ''}}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <h4 style="color: dimgray"><i class="fa fa-list-alt"><strong> Posts </strong></i></h4>
                    <div class="row">
                        @php
                            use Illuminate\Support\Str;
                        @endphp
                        @foreach($posts as $key=>$post)
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="">
                                            <img class="card-img-top avatar"  src="{{ asset('assets/user') }}/{{$post->user->image ?? ''}}" alt="User" />
                                            {{$post->user->name}}
                                        </p>
                                        <p class="card-text">
                                            <span style="color: gray">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span><br>
                                                {{$post->description ?? ''}}
{{--                                            @if($post->description)--}}
{{--                                                {{  Str::limit($post->description, 90 , ' ...') }}--}}
{{--                                            @endif--}}
                                        </p>
                                    </div>
                                    <img class="card-img-top" style="display: block;margin-left: auto;margin-right: auto;width: 100%;" src="{{asset('upload/post')}}/{{$post->image ?? ''}}" alt="Post Image">

                                    <div class="card-footer">
                                        <div class="row text-center">
                                            <div class="col-md-6 text-blue"> {{$post->number_of_like->count()}} Like</div>
                                            <div class="col-md-6 text-black-50"> {{$post->view}} view</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row pt-3 pl-3">
                    <div class="col-md-12">
                        {{--    {{$posts->appends($_GET)->links()}}--}}
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->


    </div>
    <!-- /Page Wrapper -->

@endsection

@section('script')


@endsection


