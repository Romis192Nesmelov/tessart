@extends('layouts.admin')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h4 class="panel-title">Сообщение от {{ $data['claim']->created_at->format('d.m.Y') }}</h4>
        </div>
        <div class="panel-body">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <h3>Имя: {{ $data['claim']->name }}</h3>
                        <h3>E-mail: <a href="mailto:{{ $data['claim']->email }}">{{ $data['claim']->email }}</a></h3>
                        <h3>Телефон: <a href="tel:{{ str_replace(['(',')','-'],'',$data['claim']->phone) }}">{{ $data['claim']->phone }}</a></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-sm-4 col-xs-12">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <h3>Содержание:</h3>
                        <p>{{ $data['claim']->request }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-4 col-xs-12">
                <a href="/admin/claims">@include('admin._button_block', ['type' => 'button', 'icon' => 'icon-backward', 'text' => trans('admin_content.return_back'), 'addClass' => 'pull-right'])</a>
            </div>
        </div>
    </div>
@endsection