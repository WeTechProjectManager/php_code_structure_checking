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
                        <h3 class="page-title">Increase View</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Increase View</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn bg-info" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Add</a>
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
                <div class="col-md-12">
                    <h4 style="color: dimgray"><i class="fa fa-list-alt"><strong> Increase View Setup List</strong></i></h4>
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable" id="DataTable">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Minute From</th>
                                <th>Minute To</th>
                                <th>View</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($datas as $key=>$data )
                                <tr>
                                    <td>{{$key+1}}</td>

                                    <td hidden class="ids">{{ $data->id }}</td>
                                    <td class="from">{{ $data->from }}</td>
                                    <td class="to">{{ $data->to }}</td>
                                    <td class="view">{{ $data->view }}</td>

                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item Update" data-toggle="modal" data-id="'.$data->id.'" data-target="#edit"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row pt-3 pl-3">
                    <div class="col-md-12">
{{--                        {{$marketers->appends($_GET)->links()}}--}}
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add User Modal -->
        <div id="add" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Increase View Time </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('post.store_increaseViewSetup') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Minute From <span class="text-danger">*</span></label>
                                        <input class="form-control " type="number" id="" name="from" value="" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Minute To <span class="text-danger">*</span></label>
                                    <input class="form-control " type="number" id="" name="to" value="" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>View <span class="text-danger">*</span></label>
                                        <input class="form-control " type="number" id="" name="view" value="" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                </div>
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
        <div id="edit" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Setup</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <form action="{{ route('post.update_increaseViewSetup') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="e_id" value="">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Minute From <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="from" id="e_from" value="" required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Minute To <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="to" id="e_to" value="" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>View <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="view" id="e_view" value="" required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                </div>
                            </div>

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
    @section('script')
        <script>
            $(document).on('click','.Update',function()
            {
                var _this = $(this).parents('tr');
                $('#e_id').val(_this.find('.ids').text());
                $('#e_from').val(_this.find('.from').text());
                $('#e_to').val(_this.find('.to').text());
                $('#e_view').val(_this.find('.view').text());
            });
        </script>

    @endsection

@endsection
