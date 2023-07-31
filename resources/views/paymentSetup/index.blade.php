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
                            <h3 class="page-title">Payment Setup</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Payment Setup</li>
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
                                    <div class="alert text-center" role="alert" style="background-color: #495057; color:white;">Payment Setup Form</div>
                                </div>
                            </div>
                        </div>
                        <!-- /Page Header -->
                        <form action="{{route('user.payment_setup.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>BDT Amount </label>
                                        <input name="amount_bdt" class="form-control" type="number" value="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Dollar Amount </label>
                                        <input name="amount_dollar" class="form-control" type="number" value="">
                                    </div>
                                </div>
                                <div class="col-sm-4 pt-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn submit-btn btn-info">Submit Now</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row pt-3">
                    <div class="col-sm-12">
                        <div class="alert text-center" role="alert" style="background-color: #495057; color:white;">Payment Setup List</div>
                    </div>
                </div>

                <!-- Search Filter -->
                <form action="{{ route('user.payment_setup.index') }}" method="get">
                    @csrf
                    <div class="row filter-row">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus">
                                <input type="number" class="form-control" name="amount_bdt" value="{{Request()->get('amount_bdt')}}">
                                 <label class="focus-label">BDT Amount</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus">
                                <input type="number" class="form-control" name="amount_dollar" value="{{Request()->get('amount_dollar')}}">
                                <label class="focus-label">Dollar Amount</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <button type="submit" class="btn btn-success btn-block"> Search </button>
                        </div>
                    </div>
                </form>
                <!-- /Search Filter -->

                <!-- table data -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <h5><i class="fa fa-list-alt"></i> Total : <span>{{ $total_paymentSetup ?? 0 }}</span></h5>
                            <table class="table table-striped custom-table datatable" id="DataTable">
                                <thead class="thead-light">
                                <tr>
                                    <th># @if(!empty(Request()->get('page'))) Page: {{Request()->get('page')}} @else Page: 1 @endif</th>
                                    <th>amount_bdt</th>
                                    <th>amount_dollar</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($paymentSetup as $key=>$ps )
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td hidden class="ids">{{ $ps->id }}</td>
                                        <td class="amount_bdt">{{ $ps->amount_bdt }}</td>
                                        <td class="amount_dollar">{{ $ps->amount_dollar }}</td>
                                        <td>
                                            @if($ps->created_at)
                                                {{date('d M Y', strtotime($ps->created_at))}}
                                            @endif
                                            @if($amount_duration[$key]['duration'])
                                                    to {{date('d M Y', strtotime($amount_duration[$key]['duration']))}}
                                                @else
                                                    to {{date('d M Y')}}
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
{{--                            {{$banners->appends($_GET)->links()}}--}}
                        </div>
                    </div>
                </div>
                <!-- /table data -->

            </div>
            <!-- /Page Content -->
        </div>
        <!-- /Page Wrapper -->
@endsection
