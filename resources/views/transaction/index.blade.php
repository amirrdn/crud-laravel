@extends('layouts.app')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Transaction</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Transaction</li>
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
                            <h3 class="card-title">Transaction Index</h3>

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
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-primary" id="CreateTrans">Create</button>
                            </div>
                            <table class="table table-bordered table-hover" id="role-table">
                                <thead class="bg-primary">
                                    <tr>
                                        <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                        <th>No.</th>
                                        <th>Code Book</th>
                                        <th>Book Title</th>
                                        <th>Publication Years</th>
                                        <th>Author</th>
                                        <th>Decision</th>
                                        <th>Borrowed Date</th>
                                        <th>Date of Return</th>
                                        @if(\Auth::user()->is_admin == 1)
                                        <th>Borrower</th>
                                        @endif
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                            <button class="btn btn-danger btn-sm delete_all">Delete Checked</button>
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
            <h4 class="modal-title">Create Transaction</h4>
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
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
<script src="{{ asset('AdminLTE/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/transition.js') }}"></script>
<script src="{{ asset('js/collapse.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{ asset('AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

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
            url: '{!! route('ajaxTrasn') !!}',
            data: function (d) {
                d.owner         = $('input[name=owner]').val();
                d.account_name  = $('input[name=account_name]').val();
            }
        },
        columns: [
            {data: 'checkbox', name: 'checkbox',searchable: false, sortable : false},
            { "data": null,"sortable": false,searchable: false,
                render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'code_book', name: 'code_book'},
            {data: 'book_title', name: 'book_title',searchable: true, sortable : false},
            {data: 'book_publication', name: 'book_publication',searchable: true, sortable : false},
            {data: 'book_author', name: 'book_author',searchable: true, sortable : false},
            {data: 'decisions', name: 'decisions',searchable: true, sortable : false},
            {data: 'borrowed_date', name: 'borrowed_date',searchable: true, sortable : false},
            {data: 'date_of_return', name: 'date_of_return',searchable: true, sortable : false},
            @if(\Auth::user()->is_admin == 1)
            {data: 'name', name: 'name',searchable: true, sortable : false},
            @endif
            {data: 'action', name: 'action',searchable: true, sortable : false},
        ]
    });
    $('#example-select-all').click(function (e){
        var rows = $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    $(document).on('click', '.status', function(){
        var id = $(this).attr('id');
        var value = $(this).attr('value');

        $.ajax({
                url: '{{ route("updateStatus") }}',
                data: { id: id,value:value, _token: '{{csrf_token()}}' },
                type: 'post',
                dataType: "json",

                success: function (data) {
                    toastr.success('Success update');
                    t.ajax.reload()
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error('errors update');
                }
            });
    })
    $(document).on('click', '#CreateTrans',function() {
        CreatTran();
    });

	function CreatTran() {
        $("#role-table").busyLoad("show", {
                    spinner: "accordion",
                    color: "red",
                    background: "transparant",
                    textMargin: "3rem"
                });
		$('.modal-title').html("Create Transaction");
		$('#btn-cancel').html("Close");
		$('#btn-save').hide();
		$('.modal-body').load("{{ route('transactionForm') }}", function(){
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
                    toastr.success('Success insert transaction');
                    t.ajax.reload()
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.error('errors create transaction');
                $('#form .btn-primary').prop('disabled', false);
            }
        });
        return false;
    });

    $(document).on('click', '#editTrans',function() {
        var id = $(this).attr("value");
        EditTrans(id);
    });

	function EditTrans(id) {
        $("#role-table").busyLoad("show", {
                    spinner: "accordion",
                    color: "red",
                    background: "transparant",
                    textMargin: "3rem"
                });
		$('.modal-title').html("Edit Transaction");
		$('#btn-cancel').html("Close");
		$('#btn-save').hide();
		$('.modal-body').load("{{ url('borrowing-books-update/edit') }}/"+id, function(){
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
                    toastr.success('Success insert transaction');
                //$('table').DataTable().ajax.reload();
                    t.ajax.reload()
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.error('errors update transaction');
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
                url: '/borrowing-books/delete/'+id,
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
                url: '{{ route("destroytransarray") }}',
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


    $('#borrowed_date').datetimepicker({
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
    }
});
$('#date_of_return').datetimepicker({
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
    }
});

//$('.select2').select2();
$('#CreatBooks.datashow').css('display', 'none');
$('#CreatBooks.datashow1').css('display', 'none');
$('#CreatBooks.datashow2').css('display', 'none');
$('#CreatBooks.datashow3').css('display', 'none');
$('#CreatBooks button').css('display', 'none');
$('.select2').select2();
$(document).on("change", '#select2', function(e) { 
    var id = $(this).val();
    if(id != ''){
        $('#submit button').css('display', 'none !important');
    }
    $.ajax({
        type: 'get',
        url: '/borrowing-books-ajax/' + id,
        dataType: 'json',
        beforeSend: function () {},
        success: function (data) {
            if(id !== ''){
                $('#CreatBooks.datashow').css('display', 'block');
                $('#CreatBooks.datashow1').css('display', 'block');
                $('#CreatBooks.datashow2').css('display', 'block');
                $('#CreatBooks.datashow3').css('display', 'block');
                $('#CreatBooks button').css('display', 'block');
                $('select[name=book_publication]').val(data.book_publication);
            }else{
                $('#CreatBooks.datashow').css('display', 'none !important');
                $('#CreatBooks.datashow1').css('display', 'none !important');
                $('#CreatBooks.datashow2').css('display', 'none !important');
                $('#CreatBooks.datashow3').css('display', 'none !important');
                $('#CreatBooks button').css('display', 'none !important');
            }
        },
        complete: function (data) {},
    });
});
</script>
@endpush