<div class="slide slide{{ $data->id }}" data-slide="{{ str_slug($data->name) }}" data-menu="{{ $data->on_menu }}">
    <div class="text-block">
        @if ($data->second_image)
            <img src="{{ asset('images/slides/'.$data->second_image) }}" />
        @endif
        {!! $data->content !!}
    </div>
    <div class="image-block"><img src="{{ asset('images/slides/'.$data->main_image) }}" /></div>
    @if ($next)
        <a class="button bottom" data-slide="{{ $next }}"></a>
    @endif
</div>
