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
                        <h3 class="page-title">Marketer Commission Paid</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Marketer Commission Paid</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn bg-info" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Payment Now</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- marketer info -->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body" style="background-color: #fbfbaf">
                            <p>
                                <u>Marketer Info :</u><br>
                            {{ $marketer->name}} <br>
                            {{ $marketer->email}} <br>
                            {{ $marketer->phone ?? ''}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-money"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{ $total_paid_amount ?? 0 }}</h3> <span> Total Paid Amount</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /marketer info -->

            <!-- Search Filter -->
            <form action="{{ route('marketer.commission_payment.index') }}" method="get">
                @csrf
                <div class="row filter-row">
                    <input type="text" class="form-control d-none" id="marketer_id" name="marketer_id" value="{{ $marketer_id }}">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <input type="date" class="form-control" id="date" name="date" value="{{Request()->get('date')}}">
                            {{--  <label class="focus-label">Date</label> --}}
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
                    <h4 style="color: dimgray"><i class="fa fa-list-alt"><strong> Paid Amount List</strong></i></h4>
                    <div class="table-responsive">
                        <h4><i class="fa fa-list-alt"></i> Total List : <span>{{ $marketerCommissionPayments->count() ?? 0 }}</span></h4>
                        <table class="table table-striped custom-table datatable" id="DataTable">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Marketer</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($marketerCommissionPayments as $key=>$marketerCommissionPayment )
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td hidden class="ids">{{ $marketerCommissionPayment->id }}</td>
                                    <td class="marketer">{{ $marketerCommissionPayment->marketer->name }} ({{ $marketerCommissionPayment->marketer->phone ?? "" }})</td>
                                    <td class="amount">{{ $marketerCommissionPayment->amount }}</td>
                                    <td class="payment_method">{{ $marketerCommissionPayment->payment_method }}</td>

                                    <td>
                                        @if($marketerCommissionPayment->created_at)
                                            {{date('d M Y', strtotime($marketerCommissionPayment->created_at))}}
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
{{--                        {{$marketerCommissionPayments->appends($_GET)->links()}}--}}
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
                        <h5 class="modal-title">Add New Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('marketer.commission_payment.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="text" class="form-control d-none" id="marketer_id" name="marketer_id" value="{{ $marketer->id }}" required>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Marketer</label>
                                        <input type="text" class="form-control" name="marketer" value="{{$marketer->name}} ({{$marketer->phone ?? ""}})" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Amount <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="amount" value="" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Payment Method  <span class="text-danger">*</span></label>
                                    <select class="select" name="payment_method" id="payment_method" required>
                                        <option selected disabled> --Select --</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Bank">Bank</option>
                                        <option value="Bkash">Bkash</option>
                                        <option value="Nagad">Nagad</option>
                                    </select>
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
