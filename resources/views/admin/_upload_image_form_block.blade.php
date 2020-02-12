<div class="col-md-3 col-sm-3 col-xs-12">
    <form class="form-horizontal" enctype="multipart/form-data" action="{{ url('/admin/'.$uri) }}" method="post">
        {{ csrf_field() }}
        @if (isset($parentId))
            <input type="hidden" name="parent_id" value="{{ $parentId }}">
        @endif
        @include('admin._image_block', ['col' => 12])
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('admin._button_block', ['type' => 'submit', 'icon' => 'icon-file-upload2', 'text' => trans('admin_content.upload'), 'addClass' => 'pull-right'])
        </div>
    </form>
</div>