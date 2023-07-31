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
                        <h3 class="page-title">User Payment Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">User Payment Report</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- total amount -->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-money"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{ $total_payment ?? 0 }}</h3> <span>Total Amount</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /total amount -->

            <!-- Search Filter -->
            <form action="{{ route('user.payment_report.index') }}" method="get">
                @csrf
                <div class="row filter-row">
                    <input type="text" class="form-control d-none" id="user_id" name="user_id" value="{{ $user_id ?? ''}}">
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
                    <h4 style="color: dimgray"><i class="fa fa-list-alt"><strong> Payment List</strong></i></h4>
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable" id="DataTable">
                            <thead class="thead-light">
                            <tr>
                                <th># @if(!empty(Request()->get('page'))) Page: {{Request()->get('page')}} @else Page: 1 @endif</th>
                                <th>User Name</th>
                                <th>transaction No</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($payments as $key=>$payment )
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td hidden class="ids">{{ $payment->id }}</td>
                                    <td class="name">{{ $payment->user->name }}</td>
                                    <td class="transaction_id">{{ $payment->transaction_id }}</td>
                                    <td class="amount">{{ $payment->amount }}</td>
                                    <td>
                                        <span class="badge bg-inverse-warning">{{ $payment->status }}</span>
                                    </td>
                                    <td>
                                        @if($payment->date)
                                            {{date('d M Y', strtotime($payment->date))}}
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
                        {{$payments->appends($_GET)->links()}}
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
