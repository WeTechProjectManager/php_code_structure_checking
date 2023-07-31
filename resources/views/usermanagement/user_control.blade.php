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
                        <h3 class="page-title">User Management (Real User)</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Real Users</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add User</a>
                    </div>
                </div>
            </div>
			<!-- /Page Header -->

            <!-- Search Filter -->
            <form action="{{ route('userManagement') }}" method="get">
                @csrf
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="name" name="name" value="{{ Request()->get('name') }}">
                            <label class="focus-label">Name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="email" name="email" value="{{ Request()->get('email') }}">
                            <label class="focus-label">Email</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ Request()->get('phone') }}">
                            <label class="focus-label">Phone</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <input type="text" class="form-control" id="gender" name="gender" value="{{ Request()->get('gender') }}">
                            <label class="focus-label">Gender</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="status" name="status" value="{{ Request()->get('status') }}">
                            <label class="focus-label">Status</label>
                        </div>
                    </div>
{{--                    <div class="col-sm-6 col-md-3">--}}
{{--                        <div class="form-group form-focus">--}}
{{--                            <input type="text" class="form-control" id="realFake_status" name="realFake_status" value="{{ Request()->get('realFake_status') }}">--}}
{{--                            <label class="focus-label">Real/Fake</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <input type="text" class="form-control" id="login_status" name="login_status" value="{{ Request()->get('login_status') }}">
                            <label class="focus-label">Online/offline</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button type="submit" class="btn btn-success btn-block"> Search </button>
                    </div>
                </div>
            </form><br>
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
                    <h4 style="color: dimgray"><i class="fa fa-list-alt"><strong> Real User List</strong></i></h4>
                    <div class="table-responsive">
                        <h4><i class="fa fa-user"></i> User found : <span>{{ $total ?? 0 }}</span></h4>
                        <table class="table table-striped custom-table datatable" id="DataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th># @if(!empty(Request()->get('page'))) Page: {{Request()->get('page')}} @else Page: 1 @endif</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Type/Role</th>
                                    <th>Status</th>
                                    <th>Real/Fake</th>
                                    <th>Online/Offline</th>
                                    <th>LastActveTime</th>
                                    <th>Posts</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $key=>$user )
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        {{--   <span hidden class="image">{{ $user->avatar}}</span>--}}
                                        <h2 class="table-avatar">
                                            <a href="#" class="avatar"><img src="{{ asset('assets/user') }}/{{$user->image}}" alt=""></a>
                                            <a href="#" class="name">{{ $user->name }}</a>
                                        </h2>
                                    </td>
                                    <td hidden class="ids">{{ $user->id }}</td>
                                    {{--  <td class="id">{{ $user->rec_id }}</td>--}}
                                    <td class="email">{{ $user->email }}</td>
                                    <td class="phone_number">@if(!empty($user->phone)){{ $user->phone }}@else N/A @endif</td>
                                    <td class="gender">{{$user->gender ?? ''}}</td>
                                    <td>
                                        @if ($user->type=='Admin')
                                            <span class="badge bg-inverse-danger role_name">{{ $user->type }}</span>
                                        @elseif ($user->type=='SuperAdmin')
                                            <span class="badge bg-inverse-success role_name">{{ $user->type }}</span>
                                        @elseif ($user->type=='User')
                                            <span class="badge bg-inverse-info role_name">{{ $user->type }}</span>
                                        @elseif ($user->type=='Manager')
                                            <span class="badge bg-inverse-info role_name">{{ $user->type }}</span>
                                        @else
                                            <span class="badge bg-inverse-warning role_name">{{ $user->type }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown action-label">
                                            @if ($user->status=='active')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                    <span class="statuss">{{ $user->status }}</span>
                                                </a>
                                                @elseif ($user->status=='inactive')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-info"></i>
                                                    <span class="statuss">{{ $user->status }}</span>
                                                </a>
                                            @elseif ($user->status=='delete')
                                                <a class="btn btn-danger btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-info"></i>
                                                    <span class="statuss">{{ $user->status }}</span>
                                                </a>
                                                @elseif ($user->status=='')
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
                                    <td class="realFake_status">
                                        @if(!empty($user->realFake_status) && $user->realFake_status == 'real')
                                            <span class="badge bg-inverse-success ">{{$user->realFake_status}}</span>
                                        @else
                                            <span class="badge bg-inverse-danger ">{{$user->realFake_status}}</span>
                                        @endif
                                    </td>
                                    <td class="login_status">
                                        @if(!empty($user->login_status) && $user->login_status == 'online')
                                            <span class="btn btn-success btn-sm">{{$user->login_status}}</span>
                                        @else
                                            <span class="btn btn-warning btn-sm">{{$user->login_status}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($user->updated_at)->diffForHumans() }}
                                        {{--    \Carbon\Carbon::parse($pet->date_birth)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days'); --}}
                                    </td>
                                    <td>{{ $user->totalPost->count() }}</td>
                                    <td class="text-right">
                                        <a href="{{route('user.profile',$user->id)}}" target="_blank"><button class="btn btn-info btn-sm btn-block mb-1">Profile</button></a>
                                        <a class=" userUpdate" data-toggle="modal" data-target="#edit_user"><button class="btn btn-warning btn-sm btn-block mb-1">Edit</button></a>
                                        <a href="{{route('user.payment_report.index',$user->id)}}" target="_blank"><button class="btn btn-success btn-sm btn-block mb-1">Payment Report</button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row pt-3 pl-3">
                    <div class="col-md-12">
                        {{$result->appends($_GET)->links()}}
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
                        <h5 class="modal-title">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('user/add/save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="" name="name" value="{{ old('name') }}" placeholder="Enter Name" required>
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
                                    <label>Type/Role  <span class="text-danger">*</span></label>
                                    <select class="select" name="role_name" id="role_name" required>
                                        <option selected disabled> --Select --</option>
                                        <option value="User">User</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password  <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" value="" placeholder="Enter Password" required />
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
                                    <label>Real/Fake User  <span class="text-danger">*</span></label>
                                    <select class="select" name="realFake_status" id="realFake_status" required>
                                        <option selected disabled> --Select --</option>
                                        <option value="real">real</option>
                                        <option value="fake">fake</option>
                                    </select>
                                </div>
{{--                                <div class="col-sm-6">--}}
{{--                                    <label>Photo</label>--}}
{{--                                    <input class="form-control" type="file" id="image" name="image">--}}
{{--                                </div>--}}
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Gender  <span class="text-danger">*</span></label>
                                    <select class="select" name="gender" id="gender" required>
                                        <option selected disabled> --Select --</option>
                                        <option value="male">male</option>
                                        <option value="female">female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
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
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
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
                                    <input class="form-control" type="text" name="email" id="e_email" value=""/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Type/Role <span class="text-danger">*</span></label>
                                    <select class="select" name="role_name" id="e_role_name">
                                        <option value="User">User</option>
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
                                    <div class="form-group">
                                        <label>New Password </label>
                                        <input type="password" class="form-control" id="newPassword" name="password" placeholder="Enter new password">
                                        <input type="checkbox" onclick="newPasswordShow()">Show Password
                                    </div>
                                </div>
                                <div class="col-sm-6">
{{--                                    <label>Photo</label>--}}
{{--                                    <input class="form-control" type="file" id="image" name="images">--}}
{{--                                    <input type="hidden" name="hidden_image" id="e_image" value="">--}}
                                </div>
                            </div>
                            <br>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Salary Modal -->

        <!-- Delete User Modal -->
{{--        <div class="modal custom-modal fade" id="delete_user" role="dialog">--}}
{{--            <div class="modal-dialog modal-dialog-centered">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="form-header">--}}
{{--                            <h3>Delete User</h3>--}}
{{--                            <p>Are you sure want to delete?</p>--}}
{{--                        </div>--}}
{{--                        <div class="modal-btn delete-action">--}}
{{--                            <form action="{{ route('user/delete') }}" method="POST">--}}
{{--                                @csrf--}}
{{--                                <input type="hidden" name="id" class="e_id" value="">--}}
{{--                                <input type="hidden" name="avatar" class="e_avatar" value="">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-6">--}}
{{--                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-6">--}}
{{--                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- /Delete User Modal -->
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
