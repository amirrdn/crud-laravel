@if(\Route::currentRouteName() == 'create')

    <meta name="_token" content="{{ csrf_token() }}" />
    {{ method_field('post') }}
    {!! Form::open(['autocomplete'=> 'off','method' => 'POST','route' => ['storebooks'], 'id'=> 'form','role' => 'form', 'data-toggle' => 'validator', 'novalidate' => 'true', 'enctype' => 'multipart/form-data'])  !!}
        {{ csrf_field() }}
<?php $title       = 'Submit' ;?>
@else
{!! Form::model($books, ['method' => 'POST','route' => ['updatebooks', $books->id], 'id'=> 'formUpdate','role' => 'form', 'data-toggle' => 'validator', 'novalidate' => 'true', 'enctype' => 'multipart/form-data'])  !!}
<?php $title       = 'Update' ;?>
@endif
<div class="has-feedback form-group{{ $errors->has('book_title')?" is-invalid":"" }} ">
    <label>Code Books:</label>
    {{ Form::text('code_book',$code, ['class' => 'form-control', 'readonly' => 'readonly']) }}
    <span class="invalid-feedback error-code_book" role="alert"></span>
</div>
<div class="has-feedback form-group{{ $errors->has('book_title')?" is-invalid":"" }} ">
    <label>Book Title:</label>
    {!! Form::text('book_title', null, array('required' => 'required', 'autofocus' => 'autofocus','placeholder' => 'Book Title','class' => 'form-control')) !!}
    <span class="invalid-feedback error-book_title" role="alert"></span>
</div>
<div class="has-feedback form-group{{ $errors->has('book_publication')?" is-invalid":"" }}">
    <label>Publication Year :</label>
    {!! Form::selectRange('book_publication', 2000, 2015, $book_publication,array('required','class'=>'form-control')) !!}
    <span class="invalid-feedback error-book_publication" role="alert"></span>
</div>
<div class="has-feedback form-group{{ $errors->has('book_author')?" is-invalid":"" }}">
    <label>Book Author</label>
    {!! Form::select('book_author', array('Ismail' => 'Ismail','Yusuf' => 'Yusuf','Rusli' => 'Rusli'), $book_author,array('required','class'=>'form-control')) !!}
    <span class="invalid-feedback error-book_author" role="alert"></span>
</div>
<div class="has-feedback form-group{{ $errors->has('stock')?" is-invalid":"" }}">
    <label>Stock</label>
    {!! Form::selectRange('stock', 1, 100, $stock,array('required','class'=>'form-control')) !!}
    <span class="invalid-feedback error-stock" role="alert"></span>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-block btn-primary">{{ $title }}</button>
</div>
{!! Form::close() !!}
@push('stylesheets')
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
@endpush
@push('scripts')
<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/transition.js') }}"></script>
<script src="{{ asset('js/collapse.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{ asset('AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script type="text/javascript">
$('#reservationdate').datetimepicker({
    icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }
            });
</script>
@endpush