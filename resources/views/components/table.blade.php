@props(['headings', 'contents', 'edit' => null, 'delete' => null])

<x-table.wrapper>
  <table class="min-w-full">
    <x-table.head :headings="$headings" />
    <x-table.body :contents="$contents" :headings="count($headings)" />
  </table>
</x-table.wrapper>
