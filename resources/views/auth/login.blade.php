@extends('layouts.auth')

@section('content')

<!-- Advanced login -->
<form method="POST" action="{{ url('/login') }}">
    {!! csrf_field() !!}
    <div class="panel panel-body login-form">
        <div class="text-center">
            <img src="/images/logo.jpg" />
            <h5 class="content-group-lg">{{ trans('auth.login_to_your_account') }} <small class="display-block">{!! trans('auth.login_head') !!}</small></h5>
        </div>

        @include('_input_block',['name' => 'email', 'type' => 'email', 'placeholder' => 'E-mail', 'icon' => 'icon-user'])
        @include('_input_block',['name' => 'password', 'type' => 'password', 'placeholder' => trans('auth.password'), 'icon' => 'icon-lock2'])

        <div class="form-group login-options">
            <div class="row">
                @include('admin._checkbox_block', ['name' => 'remember', 'checked' => true, 'label' => trans('auth.remember_me')])
<!--                <div class="col-sm-6 text-right">-->
<!--                    <a href="{{ url('/password/reset') }}">Забыли пароль?</a>-->
<!--                </div>-->
            </div>
        </div>

        <div class="form-group">
            @include('_button_block', ['type' => 'submit', 'mainClass' => 'bg-warning btn-block', 'text' => trans('content.enter'), 'icon' => 'icon-circle-right2 position-right'])
        </div>
    </div>
</form>
@endsection