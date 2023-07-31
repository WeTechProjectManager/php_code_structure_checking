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
                        <h3 class="page-title">Default Comment Setup</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Default Comment Setup</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn bg-info" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Add Comment</a>
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
                    <h4 style="color: dimgray"><i class="fa fa-list-alt"><strong> Default Comment List</strong></i></h4>
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable" id="DataTable">
                            <thead class="thead-light">
                            <tr>
                                <th># @if(!empty(Request()->get('page'))) Page: {{Request()->get('page')}} @else Page: 1 @endif</th>
                                <th>Comment</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($defaultComment as $key=>$comment )
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td hidden class="ids">{{ $comment->id }}</td>
                                    <td class="comment">{{ $comment->comment }}</td>
                                    <td class="text-right">
                                        <a class="Update" data-toggle="modal" data-target="#edit"><button class="btn btn-warning btn-sm">Edit</button></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row pt-3 pl-3">
                    <div class="col-md-12">
{{--                        {{$defaultComment->appends($_GET)->links()}}--}}
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
                        <h5 class="modal-title">Add New Comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('defaultComment.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Comment <span class="text-danger">*</span></label>
                                        <input class="form-control " type="text" id="" name="comment" value="" placeholder="Enter Comment" required>
                                    </div>
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
                        <h5 class="modal-title">Edit Comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <form action="{{ route('defaultComment.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="e_id" value="">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Comment <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="comment" id="e_comment" value="" required />
                                    </div>
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

    <script>
        $(document).on('click','.Update',function()
        {
            var _this = $(this).parents('tr');
            $('#e_id').val(_this.find('.ids').text());
            $('#e_comment').val(_this.find('.comment').text());

        });
    </script>




@endsection
