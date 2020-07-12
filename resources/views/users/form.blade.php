@if(\Route::currentRouteName() == 'userscreate')

    <meta name="_token" content="{{ csrf_token() }}" />
    {{ method_field('post') }}
    {!! Form::open(['autocomplete'=> 'off','method' => 'POST','route' => ['userstore'], 'id'=> 'form','role' => 'form', 'data-toggle' => 'validator', 'novalidate' => 'true', 'enctype' => 'multipart/form-data'])  !!}
        {{ csrf_field() }}
<?php $title       = 'Submit' ;?>
@else
{!! Form::model($users, ['method' => 'POST','route' => ['updateusers', $users->id], 'id'=> 'formUpdate','role' => 'form', 'data-toggle' => 'validator', 'novalidate' => 'true', 'enctype' => 'multipart/form-data'])  !!}
<?php $title       = 'Update' ;?>
@endif

<div class="has-feedback form-group{{ $errors->has('name')?" is-invalid":"" }} ">
    <label>Name:</label>
    {{ Form::text('name',$names, ['class' => 'form-control']) }}
    <span class="invalid-feedback error-name" role="alert"></span>
</div>
<div class="has-feedback form-group{{ $errors->has('email')?" is-invalid":"" }} ">
    <label>Email:</label>
    {{ Form::email('email',$email, ['class' => 'form-control']) }}
    <span class="invalid-feedback error-email" role="alert"></span>
</div>
<div class="has-feedback form-group{{ $errors->has('password')?" is-invalid":"" }} ">
    <label>Password:</label>
    {{ Form::input('password','password',$password, ['class' => 'form-control']) }}
    <span class="invalid-feedback error-password" role="alert"></span>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-block btn-primary">{{ $title }}</button>
</div>