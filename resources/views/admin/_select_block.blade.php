<div class="{{ isset($addClass) ? $addClass : '' }} form-group has-feedback {{ $errors && $errors->has($name) ? 'has-error' : '' }}">
    <label class="control-label col-md-12 text-semibold">{{ $label }}</label>
    <div class="col-md-12">
        <select name="{{ $name }}" class="form-control">
            @if (is_array($values))
                @foreach ($values as $value => $options)
                    <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>{{ $options }}</option>
                @endforeach
            @else
                @foreach ($values as $value)
                    <option value="{{ $value->id }}" {{ $value->id == $selected ? 'selected' : '' }}>{{ $value->name }}</option>
                @endforeach
            @endif
        </select>

        @if ($errors && $errors->has($name))
            <div class="form-control-feedback">
                <i class="icon-cancel-circle2"></i>
            </div>
            <span class="help-block">{{ $errors->first($name) }}</span>
        @endif

    </div>
</div>