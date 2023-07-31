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
                        <h3 class="page-title">Marketer</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Marketer</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn bg-info" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add Marketer</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filter -->
            <form action="{{ route('marketer') }}" method="get">
                @csrf
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="email" name="email" value="{{Request()->get('email')}}">
                            <label class="focus-label">Email</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button type="sumit" class="btn btn-success btn-block"> Search </button>
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
                    <h4 style="color: dimgray"><i class="fa fa-list-alt"><strong> Marketer List</strong></i></h4>
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable" id="DataTable">
                            <thead class="thead-light">
                            <tr>
                                <th># @if(!empty(Request()->get('page'))) Page: {{Request()->get('page')}} @else Page: 1 @endif</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($marketers as $key=>$marketer )
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        {{--   <span hidden class="image">{{ $user->avatar}}</span>--}}
                                        <h2 class="table-avatar">
{{--                                            <a href="#" class="avatar"><img src="{{ URL::to('/assets/img/user.jpg') }}" alt=""></a>--}}
                                            <a href="#" class="name">{{ $marketer->name }}</a>
                                        </h2>
                                    </td>
                                    <td hidden class="ids">{{ $marketer->id }}</td>
                                    <td class="email">{{ $marketer->email }}</td>
                                    <td class="phone_number">@if(!empty($marketer->phone)){{ $marketer->phone }}@else N/A @endif</td>
                                    <td class="gender">{{$marketer->gender ?? ''}}</td>
                                    <td>
                                        <span class="badge bg-inverse-warning role_name">{{ $marketer->type }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown action-label">
                                            @if ($marketer->status=='active')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                    <span class="statuss">{{ $marketer->status }}</span>
                                                </a>
                                            @elseif ($marketer->status=='inactive')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-info"></i>
                                                    <span class="statuss">{{ $marketer->status }}</span>
                                                </a>
                                            @elseif ($marketer->status=='delete')
                                                <a class="btn btn-danger btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-info"></i>
                                                    <span class="statuss">{{ $marketer->status }}</span>
                                                </a>
                                            @elseif ($marketer->status=='')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                    <span class="statuss">N/A</span>
                                                </a>
                                            @endif

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#">
                                                    <i class="fa fa-dot-circle-o text-success"></i> Active
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fa fa-dot-circle-o text-warning"></i> Inactive
                                                </a>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-right">
                                        <a class=" userUpdate" data-toggle="modal" data-target="#edit_user"><button class="btn btn-warning btn-sm btn-block mb-1">Edit</button></a>
                                        <a href="{{route('marketer.commission_report.index',$marketer->id)}}" target="_blank"><button class="btn btn-success btn-sm btn-block mb-1">Wallet</button></a>
                                        <a href="{{route('marketer.commission_payment.index',$marketer->id)}}" target="_blank"><button class="btn btn-info btn-sm btn-block mb-1">Payment & History</button></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row pt-3 pl-3">
                    <div class="col-md-12">
                        {{$marketers->appends($_GET)->links()}}
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add User Modal -->
        <div id="add_user" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Marketer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('marketer.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <input class="form-control " type="text" id="" name="name" value="{{ old('name') }}" placeholder="Enter Name" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Email Address <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" id="" name="email" placeholder="Enter Email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input class="form-control" type="tel" id="" name="phone" placeholder="Enter Phone">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Type  <span class="text-danger">*</span></label>
                                    <select class="select" name="role_name" id="role_name" required>
                                        <option selected value="Marketer">Marketer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password  <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                        <input type="checkbox" onclick="passwordShow()">Show Password
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Repeat Password  <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Choose Repeat Password" required>
                                    <input type="checkbox" onclick="repetPasswordShow()">Show Password
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Status  <span class="text-danger">*</span></label>
                                    <select class="select" name="status" id="status" required>
                                        <option selected disabled> --Select --</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">InActive</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label>Gender  <span class="text-danger">*</span></label>
                                    <select class="select" name="gender" id="gender" required>
                                        <option selected disabled> --Select --</option>
                                        <option value="male">male</option>
                                        <option value="female">female</option>
                                    </select>
                                </div>
                                {{--                                <div class="col-sm-6">--}}
                                {{--                                    <label>Photo</label>--}}
                                {{--                                    <input class="form-control" type="file" id="image" name="image">--}}
                                {{--                                </div>--}}
                            </div>

                            <div class="submit-section">
                                <button type="submit" class="btn submit-btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add User Modal -->

        <!-- Edit User Modal -->
        <div id="edit_user" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Marketer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <form action="{{ route('marketer.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="e_id" value="">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" id="e_name" value="" required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="email" id="e_email" value="" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Type <span class="text-danger">*</span></label>
                                    <select class="select" name="role_name" id="e_role_name">
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input class="form-control" type="text" id="e_phone_number" name="phone" placeholder="Enter Phone">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select class="select" name="status" id="e_status">
                                        <option selected disabled> --Select --</option>
                                        <option value="active">active</option>
                                        <option value="inactive">inactive</option>
                                        <option value="delete">delete</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label>New Password </label>
                                    <input type="password" class="form-control" id="newPassword" name="password" placeholder="Enter new password">
                                    <input type="checkbox" onclick="newPasswordShow()">Show Password
                                </div>

                            </div>
                            <br>
                            <div class="submit-section">
                                <button type="submit" class="btn submit-btn btn-success">Update now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Modal -->

    </div>
    <!-- /Page Wrapper -->

@endsection

@section('script')
        {{--        <script>--}}
        {{--            $('#DataTable').DataTable();--}}
        {{--        </script>--}}
        {{-- update js --}}
        <script>
            $(document).on('click','.userUpdate',function()
            {
                var _this = $(this).parents('tr');
                $('#e_id').val(_this.find('.ids').text());
                $('#e_name').val(_this.find('.name').text());
                $('#e_email').val(_this.find('.email').text());
                $('#e_phone_number').val(_this.find('.phone_number').text());
                $('#e_image').val(_this.find('.image').text());

                var name_role = (_this.find(".role_name").text());
                var _option = '<option selected value="' + name_role+ '">' + _this.find('.role_name').text() + '</option>'
                $( _option).appendTo("#e_role_name");

                var statuss = (_this.find(".statuss").text());
                var _option = '<option selected value="' +statuss+ '">' + _this.find('.statuss').text() + '</option>'
                $( _option).appendTo("#e_status");

            });
        </script>
        {{-- delete js --}}
        <script>
            // $(document).on('click','.userDelete',function()
            // {
            //     var _this = $(this).parents('tr');
            //     $('.e_id').val(_this.find('.ids').text());
            //     $('.e_avatar').val(_this.find('.image').text());
            // });
        </script>

        <!-- password show -->
        <script>
            function passwordShow() {
                var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }

            function repetPasswordShow() {
                var x = document.getElementById("password_confirmation");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
            newPasswordShow
            function newPasswordShow() {
                var x = document.getElementById("newPassword");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }

        </script>


@endsection
