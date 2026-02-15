@extends('layouts.admin')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h4 class="panel-title">{{ isset($data['chapter']) ? $data['chapter']->name : 'Добавление раздела' }}</h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ url('/admin/chapter') }}" method="post">
                {{ csrf_field() }}
                @if (isset($data['chapter']))
                    <input type="hidden" name="id" value="{{ $data['chapter']->id }}">
                @endif

                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('admin._image_block', [
                        'name' => 'main_image',
                        'head' => 'Главная картинка',
                        'preview' => isset($data['chapter']) ? '/images/slides/'.$data['chapter']->main_image : '',
                        'full' => isset($data['chapter']) ? '/images/slides/'.$data['chapter']->main_image : null,
                        'imagePart' => isset($data['chapter']) ? $data['chapter']->image_part : 50
                    ])

                    @include('admin._image_block', [
                        'name' => 'second_image',
                        'head' => 'Вторая картинка',
                        'preview' => isset($data['chapter']) && $data['chapter']->second_image ? '/images/slides/'.$data['chapter']->second_image : '',
                        'full' => isset($data['chapter']) && $data['chapter']->second_image ? '/images/slides/'.$data['chapter']->second_image : null
                    ])
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="panel-body">
                                @include('admin._input_block', [
                                    'label' => 'Название в меню',
                                    'name' => 'name',
                                    'type' => 'text',
                                    'max' => 100,
                                    'placeholder' => 'Название в меню',
                                    'value' => isset($data['chapter']) ? $data['chapter']->name : ''
                                ])

                                @include('admin._textarea_block', [
                                    'label' => 'Текст',
                                    'name' => 'content',
                                    'value' => isset($data['chapter']) ? $data['chapter']->content : '',
                                    'max' => 2000
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel-body">
                        @include('admin._checkbox_block', ['name' => 'active', 'checked' => isset($data['chapter']) ? $data['chapter']->active : true, 'label' => 'Раздел активен'])
                        @include('admin._checkbox_block', ['name' => 'on_menu', 'checked' => isset($data['chapter']) ? $data['chapter']->on_menu : true, 'label' => 'Показвать в меню'])
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
                </div>
            </form>
        </div>
    </div>
@endsection