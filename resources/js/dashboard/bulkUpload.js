import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

document.addEventListener("DOMContentLoaded", () => {
  const submitBtn = document.querySelector("#submit-chapter");
  const contentId = document.querySelector("[name='content_id']");

  let completedFiles = 0;

  const dropzone = new Dropzone("#dropzone", {
    url: uploadUrl,
    paramName: "file",
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": csrfToken,
    },
    chunking: true,
    forceChunking: true,
    chunkSize: 10000000, // Set your desired chunk size in bytes
    parallelChunkUploads: true,
    retryChunks: true,
    retryChunksLimit: 3,
    maxFilesize: 16384, // Set your desired maximum file size in megabytes
    acceptedFiles: ".zip",
    autoProcessQueue: true,
    uploadMultiple: false,
    maxFiles: 1,
    success: function (file, response) {
      file.previewElement.dataset.name = response.filename;
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
    let fileName;

    dropzone.files.forEach((file) => {
      fileName = file.previewElement.dataset.name;
    });

    try {
      const response = await fetch(postUrl, {
        method: "POST",
        body: JSON.stringify({
          file: fileName,
          manga_id: contentId.value,
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
});
