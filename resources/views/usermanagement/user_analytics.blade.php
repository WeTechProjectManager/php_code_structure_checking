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
                        <h3 class="page-title">User Analytics</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">UserAnalytics</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- report -->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user-o"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$data['totalUser']}}</h3> <span>Total User</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user-o"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$data['active']}}</h3> <span>Active User</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user-o"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$data['inactive']}}</h3> <span>In-active User</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user-o"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$data['delete']}}</h3> <span>Deleted User</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user-o"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$data['online']}}</h3> <span>Online User</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user-o"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$data['offline']}}</h3> <span>Offline User</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user-o"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$data['real']}}</h3> <span>Real User</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user-o"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$data['fake']}}</h3> <span>Fake User</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user-o"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$data['new']}}</h3> <span>Today New User</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /report -->

        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->


@endsection
