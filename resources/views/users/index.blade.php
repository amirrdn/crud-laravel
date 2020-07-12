@extends('layouts.app')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Users Index</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if(\Auth::user()->is_admin == 1)
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-primary" id="CreateUser">Create</button>
                            </div>
                            <table class="table table-bordered table-hover" id="role-table">
                                <thead class="bg-primary">
                                    <tr>
                                        <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                            <button class="btn btn-danger btn-sm delete_all">Delete Checked</button>
                            @else
                             You don't have permission !!
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<div class="modal fade" id="CreatBooks" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
        <div class="modal-header bg-indigo color-palette">
            <h4 class="modal-title">Create Books</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
			<div class="modal-body" id="ModalContent"></div>
			<div class="modal-footer" id="ModalFooter"></div>
		</div>
	</div>
</div>
@stop
@push('stylesheets')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<style>
.invalid-feedback {
    display: block;
}
</style>
@endpush
@push('scripts')
<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json'
        });
        
    });
    var t = $('#role-table').DataTable({
        'searching'     : true,
        'responsive'    : true,
        "paging"        : true,
        "lengthChange"  : false,
        "searching"     : false,
        "ordering"      : true,
        "info"          : true,
        "autoWidth"     : false,
        "responsive"    : true,
        "columnDefs"    : [ {
            "searchable": false,
            "orderable" : false
        } ],
        "order"         : [[ 1, 'asc' ]],
        processing: true,
        serverSide: true,
        ajax: {
            url: '{!! route('ajaxUser') !!}'
        },
        columns: [
            {data: 'checkbox', name: 'checkbox',searchable: false, sortable : false},
            { "data": null,"sortable": false,searchable: false,
                render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'created_at', name: 'created_at',searchable: true, sortable : false},
            {data: 'action', name: 'action',searchable: true, sortable : false},
        ]
    });
    $('#example-select-all').click(function (e){
        var rows = $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    $(document).on('click', '#CreateUser',function() {
        CreateUsers();
    });

	function CreateUsers() {
        $("#role-table").busyLoad("show", {
                    spinner: "accordion",
                    color: "red",
                    background: "transparant",
                    textMargin: "3rem"
                });
		$('.modal-title').html("Create Users");
		$('#btn-cancel').html("Close");
		$('#btn-save').hide();
		$('.modal-body').load("{{ route('userscreate') }}", function(){
            $('#CreatBooks').modal(
                $("#role-table").busyLoad("hide", {
                    spinner: "accordion",
                    color: "red",
                    background: "brown"
                }),    
                {show:true});
            
        });        
    }

    $(document).on('submit', '#form',function(e) {
        event.preventDefault();
        var post_url = $(this).attr("action");
        var request_method = $(this).attr("method");
        var form_data = new FormData(this);
        e.preventDefault();

        $.ajax({
            url : post_url,
            type: request_method,
            data : form_data,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#form").busyLoad("hide", {
                    spinner: "accordion",
                    color: "red",
                    background: "brown"
                }),    
                $('#form .btn-primary').prop('disabled', true);
            },
            success: function(data){
                $('#form .is-invalid').removeClass('is-invalid');
                $('#form .showfeed').empty();

                if (data.fail) {
                    for (control in data.errors) {
                        toastr.error('errors '+data.errors[control]);
                        $('#form select[name=' + control + ']').addClass('invalid-feedback');
                        $('#form select[name=' + control + ']').focus();
                        $('#form input[name=' + control + ']').addClass('invalid-feedback');
                        $('#form input[name=' + control + ']').focus();
                        $('#form .error-' + control).addClass('showfeed')
                        $('#form .error-' + control).html(data.errors[control]);
                        $('#form .btn-primary').prop('disabled', false);
                    }
                } else {
                    $('#form .btn-primary').prop('disabled', false);
                    $('#CreatBooks').modal('hide');
                    $('.modal-backdrop').css('display', 'none');
                    toastr.success('Success insert users');
                    t.ajax.reload()
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.error('errors create users');
                $('#form .btn-primary').prop('disabled', false);
            }
        });
        return false;
    });

    $(document).on('click', '#editUsers',function() {
        var id = $(this).attr("value");
        EditUser(id);
    });

	function EditUser(id) {
        $("#role-table").busyLoad("show", {
                    spinner: "accordion",
                    color: "red",
                    background: "transparant",
                    textMargin: "3rem"
                });
		$('.modal-title').html("Edit Books");
		$('#btn-cancel').html("Close");
		$('#btn-save').hide();
		$('.modal-body').load("{{ url('users-edit') }}/"+id, function(){
            $('#CreatBooks').modal(
                $("#role-table").busyLoad("hide", {
                    spinner: "accordion",
                    color: "red",
                    background: "brown"
                }),    
                {show:true});
            
        });        
    }
    $(document).on('submit', '#formUpdate',function(e) {
        event.preventDefault();
        var post_url = $(this).attr("action");
        var request_method = $(this).attr("method");
        var form_data = new FormData(this);
        e.preventDefault();

        $.ajax({
            url : post_url,
            type: request_method,
            data : form_data,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#formUpdate").busyLoad("hide", {
                    spinner: "accordion",
                    color: "red",
                    background: "brown"
                }),    
                $('#formUpdate .btn-primary').prop('disabled', true);
            },
            success: function(data){
                $('#formUpdate .is-invalid').removeClass('is-invalid');
                $('#formUpdate .showfeed').empty();

                if (data.fail) {
                    for (control in data.errors) {
                        toastr.error('errors '+data.errors[control]);
                        $('#formUpdate select[name=' + control + ']').addClass('invalid-feedback');
                        $('#formUpdate select[name=' + control + ']').focus();
                        $('#formUpdate input[name=' + control + ']').addClass('invalid-feedback');
                        $('#formUpdate input[name=' + control + ']').focus();
                        $('#formUpdate .error-' + control).addClass('showfeed')
                        $('#formUpdate .error-' + control).html(data.errors[control]);
                        $('#formUpdate .btn-primary').prop('disabled', false);
                    }
                } else {
                    $('#formUpdate .btn-primary').prop('disabled', false);
                    $('#CreatBooks').modal('hide');
                    $('.modal-backdrop').css('display', 'none');
                    toastr.success('Success insert users');
                //$('table').DataTable().ajax.reload();
                    t.ajax.reload()
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.error('errors update users');
                $('#form .btn-primary').prop('disabled', false);
            }
        });
        return false;
    });
    $(document).on('click','#role-table #delete',function(id){
        var id= $(this).val();

        swal({
            title: "Are you sure?",
            //text: "You will not be able to recover this imaginary file!",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete!",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (!isConfirm) return;
            $.ajax({
                url: '/users-delete/'+id,
                type: 'get',
                data: {_token: '{{csrf_token()}}' },
                dataType: 'json',
                success: function () {
                    t.ajax.reload()
                    swal("Done!", "It was succesfully delete!", "success");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal("Error delete!", "Please try again", "error");
                }
            });
        });
    });
    $(document).on('click','.delete_all',function(){
        var allVals = [];
        $(':checkbox:checked').each(function(i){
            allVals[i] = $(this).val();
        });
        if(allVals.length <=0){
            alert("Please select row.");
        }else{
            var join_selected_values = allVals.join(",");
            swal({
            title: "Are you sure?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete!",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (!isConfirm) return;
            $.ajax({
                url: '{{ route("destroyarrayusers") }}',
                data: { id: join_selected_values, _token: '{{csrf_token()}}' },
                type: 'post',
                dataType: "json",

                success: function (data) {
                    swal("Done!", "It was succesfully delete!", "success");
                    t.ajax.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal("Error delete!", "Please try again", "error");
                }
            });
        });
        }
    });
</script>
@endpush