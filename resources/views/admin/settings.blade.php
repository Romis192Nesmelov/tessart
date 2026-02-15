@extends('layouts.admin')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-body">
            <div class="panel-heading">
                <h3 class="panel-title">Общие настройки</h3>
            </div>
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ url('/admin/settings') }}" method="post">
                {{ csrf_field() }}
                <div class="col-md-4 col-sm-4 col-xs-12">
                    @include('admin._input_block', [
                        'label' => 'Префикс',
                        'name' => 'main_phone_prefix',
                        'type' => 'text',
                        'placeholder' => '___',
                        'value' => Settings::getMainSettings()->main_phone_prefix
                    ])
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    @include('admin._input_block', [
                        'label' => 'Телефон',
                        'name' => 'main_phone',
                        'type' => 'text',
                        'placeholder' => '___-__-__',
                        'value' => Settings::getMainSettings()->main_phone
                    ])
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('admin._input_block', [
                        'label' => 'E-mail для коррепоненции',
                        'name' => 'main_email',
                        'type' => 'email',
                        'placeholder' => 'E-mail',
                        'value' => Settings::getMainSettings()->main_email
                    ])
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
                </div>
            </form>
        </div>
    </div>
@endsection