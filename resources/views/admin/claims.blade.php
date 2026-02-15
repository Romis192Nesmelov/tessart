@extends('layouts.admin')

@section('content')
    @include('admin._modal_delete_block',['modalId' => 'delete-modal', 'function' => 'delete-claim', 'head' => 'Вы действительно хотите удалить эту заявку?'])
    {{ csrf_field() }}

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h3 class="panel-title">Заявки с сайта</h3>
        </div>
        <div class="panel-body">
            <table class="table datatable-basic table-items">
                <tr>
                    <th class="text-center">Имя</th>
                    <th class="text-center">E-mail</th>
                    <th class="text-center">Телефон</th>
                    <th class="text-center">Сообщение</th>
                    <th class="text-center">Дата заявки</th>
                    <th class="text-center">Удалить</th>
                </tr>
                @foreach ($data['claims'] as $claim)
                    <tr role="row" id="{{ 'claim_'.$claim->id }}">
                        <td class="text-center"><a href="/admin/claims/?id={{ $claim->id }}">{{ $claim->name }}</a></td>
                        <td class="text-center">{{ $claim->email }}</td>
                        <td class="text-center">{{ $claim->phone }}</td>
                        <td class="text-center">@include('admin._cropped_content_block',['croppingContent' => $claim->request, 'length' => 150])</td>
                        <td class="text-center">{{ $claim->created_at->format('d.m.Y') }}</td>
                        <td class="text-center delete"><span del-data="{{ $claim->id }}" modal-data="delete-modal" class="glyphicon glyphicon-remove-circle"></span></td>
                    </tr>
                @endforeach
            </table>
            {{ $data['claims']->render() }}
        </div>
    </div>
@endsection