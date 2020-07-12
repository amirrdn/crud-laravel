@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Advanced Form</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Advanced Form</li>
                </ol>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Date picker</h3>
                            </div>
                            <div class="card-body">
                                <meta name="_token" content="{{ csrf_token() }}" />
                                {{ method_field('post') }}
                                {!! Form::open(['autocomplete'=> 'off','method' => 'POST','route' => ['inserttransactionsection'], 'id'=> 'form','role' => 'form', 'data-toggle' => 'validator', 'novalidate' => 'true', 'enctype' => 'multipart/form-data'])  !!}
                                {{ csrf_field() }}
                                @include('transaction.form')
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
@stop
@push('stylesheets')
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/transition.js') }}"></script>
<script src="{{ asset('js/collapse.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{ asset('AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script type="text/javascript">
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
$('#datashow').css('display', 'none');
$('#datashow1').css('display', 'none');
$('#datashow2').css('display', 'none');
$('#datashow3').css('display', 'none');
$('#submit').css('display', 'none');
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
                $('#datashow').css('display', 'block');
                $('#datashow1').css('display', 'block');
                $('#datashow2').css('display', 'block');
                $('#datashow3').css('display', 'block');
                $('#submit').css('display', 'block');
                $('select[name=book_publication]').val(data.book_publication);
            }else{
                $('#datashow').css('display', 'none !important');
                $('#datashow1').css('display', 'none !important');
                $('#datashow2').css('display', 'none !important');
                $('#datashow3').css('display', 'none !important');
                $('#submit button').css('display', 'none !important');
            }
        },
        complete: function (data) {},
    });
});
</script>
@endpush

