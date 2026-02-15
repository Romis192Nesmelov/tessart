<?php ob_start(); ?>
<form class="form-horizontal" action="/feedback" method="post">
    {{ csrf_field() }}
    <div class="modal-body">
        @include('_input_block', [
            'addClass' => 'valid',
            'name' => 'name',
            'type' => 'text',
            'placeholder' => trans('content.please_enter_your_name'),
            'icon' => 'icon-user',
            'useAjax' => true,
        ])

        @include('_input_block', [
            'addClass' => 'valid',
            'name' => 'email',
            'type' => 'email',
            'placeholder' => trans('content.please_enter_your_email'),
            'icon' => 'icon-envelop4',
            'useAjax' => true,
        ])

        @include('_input_block', [
            'addClass' => 'valid',
            'name' => 'phone',
            'type' => 'tel',
            'placeholder' => '+7(___)___-__-__',
            'icon' => 'icon-phone',
            'useAjax' => true,
        ])
        <p class="description">{{ trans('content.feedback_limit') }}</p>
        @include('_textarea_block', ['name' => 'request', 'addClass' => 'feedback', 'value' => '', 'simple' => true, 'useAjax' => true])
        @include('layouts._agree_block')
    </div>
    <div class="modal-footer">
        @include('_button_block', ['type' => 'submit', 'text' => trans('content.send'), 'disabled' => true])
    </div>
</form>

<?php $content = ob_get_clean(); ?>
@include('layouts._modal_block',['id' => 'feedback_modal', 'title' => trans('content.send_request'), 'content' => $content, 'addClass' => isset($addClass) ? $addClass : null])