import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

document.addEventListener("DOMContentLoaded", () => {
  const submitBtn = document.querySelector("#submit-chapter");
  const mangaTitle = document.querySelector("[name='title']");
  const mangaId = document.querySelector("[name='manga_id']");
  const chapterNumber = document.querySelector("[name='chapter_number']");
  let completedFiles = 0;

  const dropzone = new Dropzone("#dropzone", {
    url: uploadUrl,
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": csrfToken,
    },
    autoProcessQueue: true,
    parallelUploads: 1,
    addRemoveLinks: true,
    acceptedFiles: "image/*,.zip",
    success: function (file, response) {
      file.previewElement.dataset.image = response.filename;
    },
    error: function (file, errorMessage) {
      console.error(errorMessage);
    },
  });

  dropzone.on("sending", (file, xhr) => {
    const dropzoneOnLoad = xhr.onload;
    xhr.onload = function (e) {
      dropzoneOnLoad(e);
    };
  });

  dropzone.on("complete", async (file) => {
    completedFiles++;

    if (completedFiles === dropzone.files.length) {
      submitBtn.disabled = false;
      submitBtn.addEventListener("click", handleSubmit);
    }
  });

  const handleSubmit = async (e) => {
    e.preventDefault();

    let filesList = [];
    dropzone.files.forEach((file) => {
      filesList.push(file.previewElement.dataset.image);
    });

    try {
      const response = await fetch(postUrl, {
        method: "POST",
        body: JSON.stringify({
          title: mangaTitle.value,
          manga_id: mangaId.value,
          chapter_number: chapterNumber.value,
          files: filesList,
        }),
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken,
        },
      });

      const data = await response.json();
      if (data.success || data.error) {
        window.location.href = urlRedirect;
      }
    } catch (error) {
      console.error(error);
    }
  };

  dropzone.on("removedfile", handleRemovedFile);

  async function handleRemovedFile(file) {
    try {
      await fetch(uploadUrl, {
        method: "DELETE",
        body: JSON.stringify({
          filename: file.previewElement.dataset.image,
        }),
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken,
        },
      });
    } catch (error) {
      console.error(error);
    }
  }
});
