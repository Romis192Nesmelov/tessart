@extends('layouts.admin')

@section('content')
    @include('admin._modal_delete_block',['modalId' => 'delete-modal-chapter', 'function' => 'delete-chapter', 'head' => 'Вы действительно хотите удалить этот раздел?'])
    {{ csrf_field() }}
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h3 class="panel-title">Разделы лендинга</h3>
        </div>
        <div class="panel-body">
            <table class="table datatable-basic table-items">
                <tr>
                    <th class="text-center">id</th>
                    <th class="text-center">Картинка</th>
                    <th class="text-center">Название в меню</th>
                    <th class="text-center">Содержание</th>
                    <th class="text-center">Раздел активен</th>
                    <th class="text-center">Удалить</th>
                </tr>
                @foreach ($data['chapters'] as $chapter)
                    <tr role="row" id="{{ 'chapter_'.$chapter->id }}">
                        <td class="id">{{ $chapter->id }}</td>
                        <td class="image"><a class="img-preview" href="{{ asset('images/slides/'.$chapter->main_image) }}"><img src="{{ asset('images/slides/'.$chapter->main_image) }}" /></a></td>
                        <td class="text-center head"><a href="/admin/chapters/?id={{ $chapter->id }}">{{ $chapter->name }}</a></td>
                        <td class="text-left">@include('admin._cropped_content_block', ['croppingContent' => $chapter->content, 'length' => 350])</td>
                        <td class="text-center">@include('admin._status_block', ['status' => $chapter->active, 'trueLabel' => 'Раздел активен', 'falseLabel' => 'Раздел не активен'])</td>
                        <td class="text-center delete"><span del-data="{{ $chapter->id }}" modal-data="delete-modal-chapter" class="glyphicon glyphicon-remove-circle"></span></td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="panel-body">
            @include('admin._add_button_block',['href' => 'chapters/add', 'text' => 'Добавить раздел'])
        </div>
    </div>
@endsection