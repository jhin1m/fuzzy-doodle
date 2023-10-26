<h2 class="mb-3 block text-lg font-bold leading-[1rem]">{{ __('Comments') }} ({{ $comments->count() }})</h2>

<x-error :errors="$errors" />

<form method="POST" action="{{ route('comments.store') }}">
  @csrf
  <input type="hidden" name="type" value="{{ $type }}" />
  <input type="hidden" name="key" value="{{ $model->id }}" />
  <div class="relative">
    <x-input name="comment" class="w-full py-4" placeholder="{{ __('Add Comment...') }}" required />
    @include('comments.button')
  </div>
  <p class="mt-1 text-xs text-black !text-opacity-50 dark:text-white"><span id="comment-char">0</span>/500
    {{ __('Max') }}
  </p>
</form>

<div class="mt-5 flex flex-col gap-4">
  @foreach ($comments as $comment)
    <div class="flex flex-col gap-4">
      <div class="flex gap-3">
        @php
          $image_url = isset($comment->user_avatar) ? asset('storage/avatars/' . $comment->user_avatar) : asset('images/user/no-image.jpg');
        @endphp
        <img class="h-10 w-10 rounded-full border-[1px] border-solid border-black/5 object-cover object-top dark:border-none"
          src="{{ $image_url }}" alt="{{ $comment->user->username }}" />
        <div class="flex w-full flex-col gap-2">
          <div class="flex w-full flex-col gap-2 rounded-md border-[1px] border-black/10 px-5 py-3 pb-4 dark:border-white/10">
            @include('comments.header')
            @include('comments.body')
            @include('comments.footer')
          </div>
          @include('comments.reactions')
        </div>
      </div>
    </div>
  @endforeach
</div>

@auth
  <script>
    async function handleFormSubmission(form, type, formElement) {
      const formData = new FormData(form);
      formData.append("type", type);

      try {
        const response = await fetch(form.action, {
          method: form.method,
          body: formData,
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
        });

        if (response.ok) {
          const responseData = await response.json();
          const totalLikes = formElement.parentElement.querySelector('#total-likes');
          const likeBtn = formElement.parentElement.querySelector('#like-btn');
          const dislikeBtn = formElement.parentElement.querySelector('#dislike-btn');

          const toggleClasses = (element, toggleClass) => {
            element.classList.toggle("dark:fill-white", toggleClass);
            element.classList.toggle("fill-black", toggleClass);
          };

          const {
            type,
            toggle,
            likes_count,
            dislikes_count
          } = responseData || {};

          if (toggle) {
            toggleClasses(likeBtn, false);
            toggleClasses(dislikeBtn, false);
          } else {
            toggleClasses(dislikeBtn, type === "removing");
            toggleClasses(likeBtn, type === "adding");
          }

          if (type === "adding") {
            totalLikes.innerText = Number(totalLikes.innerText) + 1;
          } else if (type === "removing") {
            totalLikes.innerText = Number(totalLikes.innerText) - 1;
          }
        } else {
          console.error("Server returned an error:", response.statusText);
        }
      } catch (err) {
        console.error(err);
      }
    }

    const likeForms = document.querySelectorAll("#likeForm");
    const dislikeForms = document.querySelectorAll("#dislikeForm");

    likeForms?.forEach((likeForm) => {
      likeForm.addEventListener("submit", (e) => {
        e.preventDefault();
        handleFormSubmission(e.target, 1, likeForm);
      });
    });

    dislikeForms?.forEach((dislikeForm) => {
      dislikeForm.addEventListener("submit", (e) => {
        e.preventDefault();
        handleFormSubmission(e.target, 2, dislikeForm);
      });
    });
  </script>
@endauth
