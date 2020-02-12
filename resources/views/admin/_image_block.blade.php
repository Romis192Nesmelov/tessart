<div class="col-md-{{ isset($col) && $col ? $col : 3 }} col-sm-{{ isset($col) && $col ? $col : 3 }} col-xs-12">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $head }}</h3>
        </div>
        <div class="panel-body edit-image-preview">
            @if (isset($preview) && $preview)
                @if (isset($full) && $full)
                    <a class="img-preview" href="{{ $full }}">
                @endif
                    <img src="{{ $preview.'?'.md5(rand(1,100000)*time()) }}" />
                @if (isset($preview) && $preview)
                    </a>
                @endif
            @else
                <img src="{{ asset('images/placeholder.jpg') }}" />
            @endif
            @include('admin._input_file_block', ['label' => '', 'name' => isset($name) && $name ? $name : 'image'])

            @if (isset($imagePart))
                @include('admin._input_block', [
                    'label' => 'Доля картинки в %',
                    'name' => 'image_part',
                    'type' => 'number',
                    'min' => 10,
                    'max' => 70,
                    'placeholder' => 'Доля картинки в %',
                    'value' => $imagePart
                ])
            @endif
        </div>
    </div>
</div>