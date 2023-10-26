@props(['user'])

<div class="hidden lg:block lg:w-1/4">
  <p class="mb-3 block text-lg font-bold leading-[1rem]">{{ __('Uploader') }}</p>
  <div class="flex gap-3">
    <img class="h-16 w-16 shrink-0 rounded-md object-cover" alt="{{ $user->username }}"
      src="{{ $user->avatar ? asset('storage/avatars/' . $user->avatar) : asset('images/user/no-image.jpg') }}" />
    <div>
      <p class="text-base font-bold">{{ $user->username }}</p>
      <p class="text-xs font-medium leading-4 text-gray-400">{{ $user->description ?? '-' }}</p>
    </div>
  </div>
</div>
