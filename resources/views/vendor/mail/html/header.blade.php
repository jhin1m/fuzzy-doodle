@props(['url'])
<tr>
  <td class="header">
    <a href="{{ $url }}" style="display: inline-block;">
      @php
        if (config('logo')) {
            $header = '<img src="' . asset('storage/site/' . basename(config('logo'))) . '" class="logo" alt="' . config('app.name') . '">';
        } else {
            $header = config('logo');
        }
      @endphp
      {!! $header !!}

    </a>
  </td>
</tr>
