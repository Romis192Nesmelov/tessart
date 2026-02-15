@extends('layouts.mail')

@section('content')
    <h4>{{ trans('content.message_from_user', ['name' => $creds['name']]) }}</h4>
    <h4>{{ trans('content.with_email', ['email' => $creds['email']]) }}</h4>
    <h4>{{ $creds['phone'] ? trans('content.with_phone', ['phone' => $creds['phone']]) : trans('content.not_set') }}</h4>
    <p>{{ $creds['content'] }}</p>
@endsection