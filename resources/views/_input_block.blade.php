<div class="form-group has-feedback has-feedback-left {{ $errors && $errors->has($name) ? 'has-error' : '' }}">
    @if (isset($label) && $label)
        <label class="control-label col-md-12 text-semibold">{{ $label }}</label>
    @endif
    <div {{ (isset($label) && $label) ? 'class=col-md-11' : '' }}>
        <input {{ !isset($icon) || !$icon ? 'style=padding-left:10px' : '' }} {{ isset($min) && $min ? 'min='.$min : '' }} {{ isset($max) && $max ? 'max='.$max : '' }} name="{{ $name }}" type="{{ $type }}" class="form-control {{ isset($addClass) ? $addClass : '' }}" placeholder="{{ isset($placeholder) && $placeholder ? $placeholder : '' }}" value="{{ isset($value) && !count($errors) ? $value : old($name) }}">
        @if (isset($icon) && $icon)
            <div class="form-control-feedback">
                <i class={{ $icon }} text-muted"></i>
            </div>
        @endif
        @if ( ($errors && $errors->has($name)) || (isset($useAjax) && $useAjax))
            <span class="help-block error {{ $name }}">{{ $errors->first($name) }}</span>
        @endif
    </div>
</div>