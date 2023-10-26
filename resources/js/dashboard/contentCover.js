export function initializeContentCover() {
  const coverInput = document.querySelector("#cover");
  const coverPreview = document.querySelector("#cover-preview");
  const editor = document.querySelector(".tox-tinymce");

  if (coverInput) {
    coverInput.addEventListener("change", (e) => {
      if (e.target.files[0]) {
        coverPreview.src = URL.createObjectURL(e.target.files[0]);
      }
    });
  }
}
