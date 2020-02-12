<?php ob_start(); ?>
<div class="modal-body modal-delete" del-function="{{ $function }}" >
    <h3>{{ $head }}</h3>
</div>
<!-- Футер модального окна -->
<div class="modal-footer">
    @include('admin._button_block', ['type' => 'button', 'text' => 'Да', 'addClass' => 'delete-yes'])
    @include('admin._button_block', ['type' => 'button', 'text' => 'Нет', 'addAttr' => ['data-dismiss' => 'modal']])
</div>
@include('layouts._modal_block',['id' => $modalId, 'content' => ob_get_clean()])