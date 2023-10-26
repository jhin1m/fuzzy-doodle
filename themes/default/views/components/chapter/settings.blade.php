<div class="hidden" id="modal">
  <div class="fixed bottom-0 left-0 h-screen w-screen bg-black/70" id="modal-bg"></div>
  <div
    class="fixed left-1/2 top-1/2 flex w-[400px] max-w-[90vw] -translate-x-1/2 -translate-y-1/2 flex-col gap-5 rounded-md border-[1px] border-black/10 bg-white p-5 dark:bg-black">
    <div class="flex flex-col gap-1">
      <h3 class="text-lg font-bold">{{ __('Reading Settings') }}</h3>
      <p class="text-gray-400">{{ __('Set your preferred reading settings from the following') }}</p>
    </div>
    <div class="flex flex-col gap-3">
      <x-select id="reading-types" label="{{ __('Reading Type') }}" name="type" :options="[
          'long' => 'Long Strip',
          'single' => 'Single Page',
      ]"></x-select>
      <x-select id="chapter-width" label="{{ __('Chapter Width') }}" name="type" :options="[
          '768px' => '768px',
          '896px' => '896px',
          '1024px' => '1024px',
          '1152px' => '1152px',
          '1280px' => '1280px',
          '100vw' => __('Max'),
      ]"></x-select>
      <x-select id="chapter-scroll" label="{{ __('Scrolling by click size') }}" name="type" :options="[
          '500' => '500px',
          '1000' => '1000px',
          '1500' => '1500px',
          '2000' => '2000px',
          '2500' => '2500px',
          '3000' => '3000px',
      ]"></x-select>
    </div>
    <div class="flex gap-3">
      <x-primary-button class="w-full" id="reset-settings">{{ __('Reset') }}</x-primary-button>
      <x-primary-button class="w-full" id="save-settings">{{ __('Save') }}</x-primary-button>
    </div>
  </div>
</div>
@vite(['themes/' . config('theme.active') . '/js/chapter.js'])
