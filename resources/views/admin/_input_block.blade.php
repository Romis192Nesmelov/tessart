<div class="form-group has-feedback has-feedback-left {{ isset($addClass) ? $addClass : '' }} {{ $errors && $errors->has($name) ? 'has-error' : '' }}">
    @if (isset($label) && $label)
        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-semibold">{{ $label }}</label>
    @endif
    <input {{ !isset($icon) || !$icon ? 'style=padding-left:10px' : '' }} {{ isset($min) ? 'min='.$min : '' }} {{ isset($max) && $max ? 'max='.$max : '' }} name="{{ $name }}" type="{{ $type }}" class="form-control" placeholder="{{ isset($placeholder) && $placeholder ? $placeholder : '' }}" value="{!! isset($value) && !count($errors) ? $value : old($name) !!}">
    @if (isset($icon) && $icon)
        <div class="form-control-feedback">
            <i class="{{ $icon }}"></i>
        </div>
    @endif
    @if ( ($errors && $errors->has($name)) || (isset($useAjax) && $useAjax))
        <span class="help-block error {{ $name }}">{!! $errors->first($name) !!}</span>
    @endif
</div>