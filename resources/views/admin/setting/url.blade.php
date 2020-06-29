@extends('admin.layouts.master')
@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item">{{__('words.setting')}}</li>
                <li class="breadcrumb-item active">Url</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-route"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Url</h1>
                    <small>GameLog Urls</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body card-fill">
                    <div class="float-right">
                        <button type="button" class="btn btn-sm btn-primary float-right mt-2 mt-md-2" id="btn-add-url"><i class="fas fa-route mr-2"></i>{{__('words.add_new')}}</button>
                    </div>
                    <div class="row justify-content-center mt-2">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="thead-colored thead-primary">
                            <tr class="bg-blue">
                                <th style="width:40px">#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Third Options</th>
                                <th>Login Url</th>
                                <th>{{__('words.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td class="name">{{ $item->name }}</td>
                                    <td class="username">{{ $item->username }}</td>
                                    <td class="password">{{ $item->password }}</td>
                                    <td class="third_option">{{ $item->third_option ? : 'No options'  }}</td>
                                    <td class="login_url" data-id=" {{ $item->login_url }} ">
                                        <a href="{{ $item->login_url }}" onclick="window.open(this.href, 'newwindow', 'width=800, height=500'); return false;" alt="google">
                                            <p>login</p>
                                        </a>
                                    </td>
                                    <td class="py-1">
                                        <a href="#" class="btn btn-sm btn-primary btn-icon mr-1 btn-edit-url" data-id="{{$item->id}}" data-toggle="tooltip" title="{{__('words.edit')}}"><i class="fa fa-edit"></i></a>
                                        <a href="{{route('admin.game_url.delete', $item->id)}}" class="btn btn-sm btn-danger btn-icon mr-1 btn-confirm" data-toggle="tooltip" title="{{__('words.delete')}}"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
    </div>
    <div class="modal fade" id="addUrlModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Url</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="create_url_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Site Name <span class="text-danger">*</span></label>
                            <input class="form-control name" type="text" name="name" placeholder="Site name" required />
                            <span class="invalid-feedback username_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.username')}} <span class="text-danger">*</span></label>
                            <input class="form-control username" type="text" name="username" placeholder="{{__('words.username')}}" required />
                            <span class="invalid-feedback username_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password<span class="text-danger">*</span></label>
                            <input class="form-control password" type="text" name="password" placeholder="password" />
                            <span class="invalid-feedback name_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Third Options</label>
                            <input class="form-control third_option" type="text" name="third_option" placeholder="Third option" />
                            <span class="invalid-feedback phone_number_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Login Url <span class="text-danger">*</span></label>
                            <input type="text" name="login_url" class="form-control login_url" placeholder="login url" required>
                            <span class="invalid-feedback rate_error">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit"><i class="fas fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUrlModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Url</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="edit_url_form" method="post">
                    @csrf
                    <input type="hidden" name="id" class="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Site Name <span class="text-danger">*</span></label>
                            <input class="form-control name" type="text" name="name" placeholder="Site name" required />
                            <span class="invalid-feedback username_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.username')}} <span class="text-danger">*</span></label>
                            <input class="form-control username" type="text" name="username" placeholder="{{__('words.username')}}" required />
                            <span class="invalid-feedback username_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password<span class="text-danger">*</span></label>
                            <input class="form-control password" type="text" name="password" placeholder="password" />
                            <span class="invalid-feedback name_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Third Options</label>
                            <input class="form-control third_option" type="text" name="third_option" placeholder="Third options" />
                            <span class="invalid-feedback phone_number_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Login Url <span class="text-danger">*</span></label>
                            <input type="text" name="login_url" class="form-control login_url" placeholder="login url" required>
                            <span class="invalid-feedback rate_error">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit"><i class="fas fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $("#btn-add-url").click(function(){
                $("#create_agent_form input.form-control").val('');
                $("#create_agent_form .invalid-feedback strong").text('');
                $("#addUrlModal").modal();
            });

            $("#create_url_form .btn-submit").click(function(){
                $(".page-loader-wrapper").fadeIn();
                $.ajax({
                    url: "{{route('admin.game_url.create')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#create_url_form').serialize(),
                    success : function(response) {
                        $(".page-loader-wrapper").fadeOut();
                        if(response.status.msg == 'success') {
                            swal({
                                    title: response.data,
                                    type: "success",
                                    confirmButtonColor: "#007BFF",
                                    confirmButtonText: "OK",
                                },
                                function(){
                                    window.location.reload();
                                });
                        }
                        else if(response.status.msg == 'error') {
                            let messages = response.data;
                        }
                    },
                    error: function(response) {
                        $(".page-loader-wrapper").fadeOut();
                        swal("{{__('words.something_went_wrong')}}", '', "error");
                        console.log(response)
                    }
                });
            });

            $(".btn-edit-url").click(function(){
                let id = $(this).data("id");
                let name = $(this).parents('tr').find(".name").text().trim();
                let username = $(this).parents('tr').find(".username").text().trim();
                let password = $(this).parents('tr').find(".password").text().trim();
                let third_option = $(this).parents('tr').find(".third_option").text().trim();
                let login_url = $(this).parents('tr').find(".login_url").data('id');


                $("#edit_url_form .id").val(id);
                $("#edit_url_form .name").val(name);
                $("#edit_url_form .username").val(username);
                $("#edit_url_form .password").val(password);
                $("#edit_url_form .third_option").val(third_option);
                $("#edit_url_form .login_url").val(login_url);

                $("#editUrlModal").modal();
            });

            $("#edit_url_form .btn-submit").click(function(){
                $(".page-loader-wrapper").fadeIn();
                $.ajax({
                    url: "{{route('admin.game_url.update')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#edit_url_form').serialize(),
                    success : function(response) {
                        $(".page-loader-wrapper").fadeOut();
                        if(response.status.msg == 'success') {
                            swal({
                                    title: response.data,
                                    type: "success",
                                    confirmButtonColor: "#007BFF",
                                    confirmButtonText: "OK",
                                },
                                function(){
                                    window.location.reload();
                                });
                        }
                        else if(response.status.msg == 'error') {

                            let messages = response.data;
                            console.log(response);
                        }
                    },
                    error: function(response) {
                        $(".page-loader-wrapper").fadeOut();
                        swal("{{__('words.something_went_wrong')}}", '', 'error')
                        console.log(response)
                    }
                });
            });



            $("#pagesize").change(function(){
                $("#pagesize_form").submit();
            });
        });
    </script>
@endsection
