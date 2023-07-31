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
                        <h3 class="page-title">Marketer Commission Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Marketer Commission Report</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- total amount -->
            <div class="row">
                @if($marketerInfo)
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body" style="background-color: #fbfbaf">
                            <p>
                                Marketer Info <hr><br>
                                {{ $marketerInfo->name}} <br>
                                {{ $marketerInfo->email}} <br>
                                {{ $marketerInfo->phone ?? ''}}
                            </p>
                        </div>
                    </div>
                </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <div class="card-body bg-warning"> <span class="dash-widget-icon"><i class="fa fa-money"></i></span>
                                <div class="dash-widget-info">
                                    <h3>
                                        @if($total_marketer_commission)
                                            {{ $total_marketer_commission - $total_marketer_commission_paid }}
                                        @else
                                            0
                                        @endif
                                    </h3>
                                    <span> Wallet</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-money"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{ $total_marketer_commission_paid ?? 0 }}</h3> <span> Commission Paid</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-money"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{ $total_marketer_commission ?? 0 }}</h3> <span> Commission Received</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /total amount  -->

            <!-- Search Filter -->
            <form action="{{ route('marketer.commission_report.index') }}" method="get">
                @csrf
                <div class="row filter-row">
                    <input type="text" class="form-control d-none" id="marketer_id" name="marketer_id" value="{{ $marketer_id ?? ''}}">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <input type="date" class="form-control" id="date" name="date" value="{{Request()->get('date')}}">
                            {{--  <label class="focus-label">Date</label> --}}
                        </div>
                    </div>
{{--                    <div class="col-sm-6 col-md-3">--}}
{{--                        <div class="form-group form-focus">--}}
{{--                            <input type="text" class="form-control" id="paid_status" name="paid_status" value="{{Request()->get('paid_status')}}">--}}
{{--                            <label class="focus-label">paid/unpaid</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
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
                    <h4 style="color: dimgray"><i class="fa fa-list-alt"><strong> Commission List</strong></i></h4>
                    <div class="table-responsive">
                        <h5><i class="fa fa-list-alt"></i> Total List : <span>{{ $total_list_count ?? 0 }}</span></h5>
                        <table class="table table-striped custom-table datatable" id="DataTable">
                            <thead class="thead-light">
                            <tr>
                                <th># @if(!empty(Request()->get('page'))) Page: {{Request()->get('page')}} @else Page: 1 @endif</th>
                                <th>Marketer Name</th>
                                <th>Transaction No</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($marketer_commissions as $key=>$marketer_commission )
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td hidden class="ids">{{ $marketer_commission->id }}</td>
                                    <td class="name">{{ $marketer_commission->marketer->name }}</td>
                                    <td class="transaction_id">{{ $marketer_commission->transaction_id }}</td>
                                    <td class="amount">{{ $marketer_commission->amount }}</td>
                                    <td>
                                        <span class="badge bg-inverse-info">{{ $marketer_commission->status }}</span>
                                    </td>
                                    <td>
                                        @if($marketer_commission->created_at)
                                            {{date('d M Y', strtotime($marketer_commission->created_at))}}
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
                        {{$marketer_commissions->appends($_GET)->links()}}
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
