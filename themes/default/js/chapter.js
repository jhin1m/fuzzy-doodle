document.addEventListener("DOMContentLoaded", function () {
  const chapterImages = document.querySelectorAll(".chapter-image");
  const chapterWidthSelectors = document.querySelectorAll("#chapter-width");
  const chapterContainer = document.querySelector("#chapter-container");
  const chapterScrollSelector = document.querySelector("#chapter-scroll");
  const toggleChapterSettings = document.querySelector("#chapter-modal");
  const readingTypes = document.querySelectorAll("#reading-types");
  const modalBg = document.querySelector("#modal-bg");
  const modal = document.querySelector("#modal");
  const resetBtn = document.querySelector("#reset-settings");
  const saveBtn = document.querySelector("#save-settings");

  // Retrieve user settings from localStorage if available
  const savedWidth = localStorage.getItem("chapterWidth");
  const savedScrollValue = localStorage.getItem("chapterScrollValue");
  const savedReadingType = localStorage.getItem("readingType");

  function resetSettings() {
    localStorage.removeItem("chapterWidth");
    localStorage.removeItem("chapterScrollValue");
    localStorage.removeItem("readingType");

    chapterWidthSelectors.forEach((selector) => (selector.value = "768px"));
    readingTypes.forEach((type) => (type.value = "long"));
    chapterScrollSelector.value = "500";

    handleChapterWidthChange("768px");
    handleChapterScrollChange(500);
    handleLongReading();
  }

  function handleChapterWidthChange(value) {
    chapterContainer.style.maxWidth = value;
    chapterWidthSelectors.forEach((selector) => (selector.value = value));

    // Save user's pick in local storage
    localStorage.setItem("chapterWidth", value);
  }

  function handleChapterScrollChange(value) {
    localStorage.setItem("chapterScrollValue", value);

    chapterImages.forEach((image) => {
      image.addEventListener("click", dynamicImageClickHandler);
    });
  }

  function dynamicImageClickHandler(e) {
    e.preventDefault();
    const value = Number(chapterScrollSelector.value) ? Number(chapterScrollSelector.value) : 500;
    scrollWindowBy(value);
  }

  function singleChapterHandler(e) {
    e.preventDefault();
    let currentImage = document.querySelector(`[data-id="${e.target.dataset.id}"]`);
    let nextImage = document.querySelector(`[data-id="${Number(e.target.dataset.id) + 1}"]`);

    if (nextImage) {
      currentImage.classList.add("hidden");
      nextImage.classList.remove("hidden");
    }
  }

  function handleReadingTypeChange(value) {
    const defaultTypes = ["single", "double", "long"];
    if (defaultTypes.includes(value)) {
      switch (value) {
        case "long":
          handleLongReading();
          break;

        case "single":
          handleSingleReading();
          break;

        default:
          handleLongReading();
          break;
      }
    }
  }

  function handleLongReading() {
    localStorage.setItem("readingType", "long");

    chapterImages?.forEach((chapterImage) => {
      chapterImage.classList?.remove("hidden");

      chapterImage.removeEventListener("click", singleChapterHandler);
      chapterImage.addEventListener("click", dynamicImageClickHandler);
    });

    readingTypes.forEach((type) => (type.value = "long"));
  }

  function handleSingleReading() {
    localStorage.setItem("readingType", "single");

    chapterImages?.forEach((chapterImage) => {
      if (chapterImage.dataset.id != 0) {
        chapterImage.classList?.add("hidden");
      }

      chapterImage.removeEventListener("click", dynamicImageClickHandler);
      chapterImage.addEventListener("click", singleChapterHandler);
    });

    readingTypes.forEach((type) => (type.value = "single"));
  }

  function scrollWindowBy(value) {
    window.scroll(0, window.scrollY + value);
  }

  if (resetBtn) {
    resetBtn.addEventListener("click", (e) => {
      e.preventDefault();
      resetSettings();
    });
  }

  if (savedWidth) {
    handleChapterWidthChange(savedWidth);
  }

  if (savedScrollValue) {
    chapterScrollSelector.value = savedScrollValue;
    handleChapterScrollChange(Number(savedScrollValue));
  } else {
    chapterImages.forEach((image) => {
      image.addEventListener("click", dynamicImageClickHandler);
    });
  }

  if (savedReadingType) {
    handleReadingTypeChange(savedReadingType);
  }

  modalBg.addEventListener("click", (e) => {
    modal.classList?.toggle("hidden");
  });

  saveBtn.addEventListener("click", (e) => {
    e.preventDefault();
    modal.classList?.toggle("hidden");
  });

  if (readingTypes) {
    readingTypes.forEach((readingType) => {
      readingType.addEventListener("change", (e) => {
        e.preventDefault();
        handleReadingTypeChange(e.target.value);
      });
    });
  }

  if (toggleChapterSettings) {
    toggleChapterSettings.addEventListener("click", (e) => {
      e.preventDefault();
      modal.classList?.toggle("hidden");
    });
  }

  chapterWidthSelectors.forEach((chapterWidthSelector) => {
    chapterWidthSelector.addEventListener("change", (e) => {
      e.preventDefault();
      handleChapterWidthChange(e.target.value);
    });
  });

  if (chapterScrollSelector) {
    chapterScrollSelector.addEventListener("change", (e) => {
      e.preventDefault();
      const selectedValue = e.target.value;
      handleChapterScrollChange(Number(selectedValue));
    });
  }
});
