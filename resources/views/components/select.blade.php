@props(['label' => null, 'name' => null, 'class' => null, 'selected' => null, 'options' => [], 'multiple' => false])

@if ($label)
  <div class="flex w-full flex-col gap-3">
    <x-label :title="$label" />
@endif

<select @if ($name) name="{{ $name }}" @endif class="input {{ $class }}" {{ $attributes }}
  @if ($multiple) multiple @endif>
  @foreach ($options as $optionValue => $optionLabel)
    <option class="option" value="{{ $optionValue }}"
      @if (is_array($selected) && in_array($optionValue, $selected)) selected @elseif ($selected == $optionValue) selected @endif>
      {{ $optionLabel }}</option>
  @endforeach
</select>

@if ($label)
  </div>
@endif
