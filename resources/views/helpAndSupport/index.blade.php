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
                        <h3 class="page-title">Help and Support</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Help and Support</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn bg-info" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filter -->
{{--            <form action="{{ route('admin_notification.index') }}" method="get">--}}
{{--                @csrf--}}
{{--                <div class="row filter-row">--}}
{{--                    <div class="col-sm-6 col-md-3">--}}
{{--                        <div class="form-group form-focus">--}}
{{--                            <input type="date" class="form-control" id="date" name="date" value="{{Request()->get('date')}}">--}}
{{--                            --}}{{--  <label class="focus-label">Date</label> --}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-sm-6 col-md-3">--}}
{{--                        <button type="submit" class="btn btn-success btn-block"> Search </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
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
                    <h4 style="color: dimgray"><i class="fa fa-list-alt"><strong> Question and Answer List</strong></i></h4>
                    <div class="table-responsive">
                        <h5><i class="fa fa-list-alt"></i> Total : <span>{{ $questionAns->count() ?? 0 }}</span></h5>
                        <table class="table table-striped custom-table datatable" id="DataTable">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($questionAns as $key=>$qa)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td hidden class="ids">{{ $qa->id }}</td>
                                    <td class="questions">{{ $qa->questions }}</td>
                                    <td class="ans"><textarea rows="2" class="form-control">{{$qa->ans}}</textarea></td>
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
{{--                        {{$questionAns->appends($_GET)->links()}}--}}
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
                        <h5 class="modal-title">Add New Question & Answer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('help_support.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Question <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="questions" value="" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Answer <span class="text-danger">*</span></label>
                                        <textarea name="ans" rows="4" class="form-control" required></textarea>
                                    </div>
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

        <!-- Edit User Modal -->
        <div id="edit" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Question & Answer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <form action="{{ route('help_support.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="e_id" value="">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Question <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="e_questions" name="questions" value="" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Answer <span class="text-danger">*</span></label>
                                        <textarea id="e_ans" name="ans" rows="4" class="form-control" required></textarea>
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
            $('#e_questions').val(_this.find('.questions').text());
            $('#e_ans').val(_this.find('.ans').text());

        });
    </script>
@endsection
