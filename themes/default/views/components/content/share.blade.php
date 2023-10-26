@props(['link'])
<div class="flex gap-1 md:gap-2">
  <x-share.facebook link="https://www.facebook.com/sharer/sharer.php?u={{ $link }}" />
  <x-share.twitter link="https://twitter.com/intent/tweet?url={{ $link }}" />
  <x-share.pinterest link="https://www.pinterest.com/pin/create/button?url={{ $link }}" />
  <x-share.whatsapp link="whatsapp://send?text={{ $link }}" />
</div>
