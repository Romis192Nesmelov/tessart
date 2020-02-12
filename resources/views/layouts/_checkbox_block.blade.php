<div class="col-md-{{ isset($col) && $col ? $col : '12' }} {{ isset($addClass) && $addClass ? $addClass : '' }}">
    <label class="checkbox-inline">
        <input class="styled" type="checkbox" name="{{ $name }}" {{ isset($checked) && $checked ? 'checked=checked' : '' }}><span class="check-box-label">{{ $label }}</span>
    </label>
</div>