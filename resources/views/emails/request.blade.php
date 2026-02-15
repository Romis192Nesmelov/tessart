@extends('layouts.mail')

@section('content')
    <h1>Запрос с сайта Tessart</h1>
    <h3>Сообщение от пользователя с</h3>
    <h4>Именем: {{ $creds['name'] }}</h4>
    <h4>E-mail: {{ $creds['email'] }}</h4>
    <h4>Телефоном: {{ $creds['phone'] }}</h4>

    <h3>Запрос:</h3>
    <p>{{ $creds['request'] }}</p>
@endsection