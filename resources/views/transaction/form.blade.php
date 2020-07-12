@if(\Route::currentRouteName() == 'transactionForm')

    <meta name="_token" content="{{ csrf_token() }}" />
    {{ method_field('post') }}
    {!! Form::open(['autocomplete'=> 'off','method' => 'POST','route' => ['inserttransactionsection'], 'id'=> 'form','role' => 'form', 'data-toggle' => 'validator', 'novalidate' => 'true', 'enctype' => 'multipart/form-data'])  !!}
        {{ csrf_field() }}
<?php $title       = 'Submit' ;?>
@else
{!! Form::model($trans, ['method' => 'POST','route' => ['updatetrans', $trans->id], 'id'=> 'formUpdate','role' => 'form', 'data-toggle' => 'validator', 'novalidate' => 'true', 'enctype' => 'multipart/form-data'])  !!}
<?php $title       = 'Update' ;?>
@endif
<div class="row">
    <div class="col-md-6">
        <div class="has-feedback form-group{{ $errors->has('book_author')?" is-invalid":"" }}">
            <label>Book Title</label>
            <select class="form-control select2" id="select2" name="book_id" style="width: 100%;">
                <option>Books Title</option>
                     @if($books->count())
                    @foreach($books as $bcb)
                    @if(\Route::currentRouteName() == 'transactionForm')
                    <option value="{{ $bcb->id }}" >{{ $bcb->book_title }}</option>
                    @else
                    <option value="{{ $bcb->id }}" {{ $trans->book_id == $bcb->id ? 'selected="selected"' : '' }}>{{ $bcb->book_title }}</option>
                    @endif
                    @endforeach
                    @endif
            </select>
            <span class="invalid-feedback error-book_author" role="alert"></span>
        </div>
        <div class="datashow">
            <div class="has-feedback form-group{{ $errors->has('book_publication')?" is-invalid":"" }}">
                <label>Publication Year :</label>
                {!! Form::selectRange('book_publication', 2000, 2015, $book_publication,array('required','class'=>'form-control', 'readonly' => 'readonly')) !!}
                <span class="invalid-feedback error-book_publication" role="alert"></span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="datashow1">
            <div class="has-feedback form-group{{ $errors->has('book_author')?" is-invalid":"" }}">
                <label>Book Author</label>
                {!! Form::select('book_author', array('Ismail' => 'Ismail','Yusuf' => 'Yusuf','Rusli' => 'Rusli'), $book_author,array('required','class'=>'form-control', 'readonly' => 'readonly')) !!}
                <span class="invalid-feedback error-book_author" role="alert"></span>
            </div>
            <div class="has-feedback form-group{{ $errors->has('stock')?" is-invalid":"" }}">
                <label>Stock</label>
                {!! Form::selectRange('stock', 1, 100, $stock,array('required','class'=>'form-control', 'readonly' => 'readonly')) !!}
                <span class="invalid-feedback error-stock" role="alert"></span>
            </div>
        </div>
    </div>
    <div class="col-md-6 datashow2">
        <div class="has-feedback form-group{{ $errors->has('borrowed_date')?" is-invalid":"" }}">
            <label>Borrowed Date:</label>
            <div class="input-group date" id="borrowed_date" data-target-input="nearest">
                {{ Form::text('borrowed_date',$borrowed_date, ['class' => 'form-control datetimepicker-input', 'data-target' => '#borrowed_date']) }}
                <div class="input-group-append" data-target="#borrowed_date" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            <span class="invalid-feedback error-borrowed_date" role="alert"></span>
        </div>
    </div>
    <div class="col-md-6 datashow3">
        <div class="has-feedback form-group{{ $errors->has('date_of_return')?" is-invalid":"" }}">
            <label>Date Of Return:</label>
            <div class="input-group date" id="date_of_return" data-target-input="nearest">
                {{ Form::text('date_of_return',$date_of_return, ['class' => 'form-control datetimepicker-input', 'data-target' => '#date_of_return']) }}
                <div class="input-group-append" data-target="#date_of_return" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            <span class="invalid-feedback error-date_of_return" role="alert"></span>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-block btn-primary" id="submit">{{ $title }}</button>
</div>