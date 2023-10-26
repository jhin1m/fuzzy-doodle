// import "./bootstrap";
import "lazysizes";
import "animate.css";

document.addEventListener("DOMContentLoaded", function () {
  const searchLink = document.querySelector("#search-link");
  const searchLinkPhone = document.querySelector("#search-link-phone");
  const navSearch = document.querySelector("#nav-search");
  const commentInput = document.querySelector('input[name="comment"]');
  const commentCharCount = document.querySelector("#comment-char");
  const showChapters = document.querySelector("#showChapters");
  const showInfo = document.querySelector("#showInfo");
  const chaptersList = document.querySelector("#chapters-list");
  const commentsList = document.querySelector("#comments-list");
  const sliderMangas = document.querySelector("#home-slider");
  const popularCards = document.querySelectorAll("#popular-cards");
  const latestCards = document.querySelectorAll("#latest-cards");
  const suggestedMangas = document.querySelector("#suggested-mangas");
  const chapterSelect = document.querySelectorAll("#chapter-select");
  const contentDescription = document.querySelector("#description");
  const showMoreBtn = document.querySelector("#show-more");
  const sliderContainer = document.querySelector("#slider-container");
  const navBar = document.querySelector("#navbar");
  const navLinks = document.querySelectorAll(".nav-link");
  const cardLoaders = document.querySelectorAll("#card-loader");
  const cardReals = document.querySelectorAll("#card-real");

  if (sliderContainer) {
    // Fix a bug caused by scrollbar width on slider
    function adjustSliderContainerMargin() {
      if (sliderContainer) {
        let scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
        let marginValue = `calc((100% - 100vw - ${scrollBarWidth}px) / 2)`;

        // Determine the direction and adjust margin accordingly
        if (document.documentElement.dir === "rtl") {
          sliderContainer.style.marginRight = marginValue;
          sliderContainer.style.marginLeft = ""; // Clear marginLeft
        } else {
          sliderContainer.style.marginLeft = marginValue;
          sliderContainer.style.marginRight = ""; // Clear marginRight
        }
      }
    }

    adjustSliderContainerMargin();
    window.addEventListener("resize", adjustSliderContainerMargin);

    // Fix navbar colors, search Input
    if (navBar) {
      navBar.classList?.add("sm:text-white");
      if (navLinks) {
        navLinks.forEach((navLink) => {
          navLink.classList?.add("hover:!bg-black/80");
        });
      }
    }

    const searchInput = document.querySelector("#search-input");
    searchInput.classList?.add("sm:bg-[#191919]", "sm:placeholder:text-white/50");

    if (typeof searchType !== "undefined") {
      searchType.classList?.add("sm:bg-[#191919]");
    }
  }

  if (contentDescription) {
    let cdHtml = contentDescription.innerHTML;
    if (cdHtml.length > 500) {
      const fullDescription = cdHtml;
      const truncatedDescription = cdHtml.substring(0, 500);
      contentDescription.innerHTML = truncatedDescription;

      showMoreBtn.classList.remove("hidden");

      showMoreBtn.addEventListener("click", () => {
        contentDescription.innerHTML = fullDescription;
        showMoreBtn.classList.add("hidden");
      });
    }
  }

  if (chapterSelect) {
    chapterSelect.forEach((select) => {
      select.addEventListener("change", function (e) {
        e.preventDefault();
        const selectedOption = select.options[select.selectedIndex];

        const currentURL = window.location.href;
        const regex = /\/\d+(\.\d+)?$/; // Match the last part after the last slash
        const updatedURL = currentURL.replace(regex, "/" + selectedOption.textContent.trim());

        window.location.href = updatedURL;
      });
    });
  }

  const toggleNavSearch = (e) => {
    e.preventDefault();

    // animate first, then hide
    if (navSearch?.classList.contains("block")) {
      navSearch?.classList.add("animate__fadeOutUp");
      navSearch?.classList.remove("animate__fadeInDown");

      setTimeout(() => {
        navSearch?.classList.remove("block");
        navSearch?.classList.add("hidden");
      }, 600);
    }

    // Display first, then animate
    if (navSearch?.classList.contains("hidden")) {
      navSearch?.classList.remove("hidden");
      navSearch?.classList.add("block");

      navSearch?.classList.add("animate__fadeInDown");
      navSearch?.classList.remove("animate__fadeOutUp");
    }
  };

  if (searchLink) {
    searchLink.addEventListener("click", toggleNavSearch);
  }

  if (searchLinkPhone) {
    searchLinkPhone.addEventListener("click", toggleNavSearch);
  }

  if (commentInput && commentCharCount) {
    commentInput.addEventListener("keyup", function (e) {
      const length = e.target.value.length;
      commentCharCount.innerHTML = length;
    });
  }

  if (showChapters && showInfo && chaptersList && commentsList) {
    showChapters.addEventListener("click", function (e) {
      e.preventDefault();
      chaptersList?.classList.remove("hidden");
      commentsList?.classList.add("hidden");
      showChapters?.classList.add("tab-active");
      showInfo?.classList.remove("tab-active");
    });

    showInfo.addEventListener("click", function (e) {
      e.preventDefault();
      chaptersList?.classList.add("hidden");
      commentsList?.classList.remove("hidden");
      showChapters?.classList.remove("tab-active");
      showInfo?.classList.add("tab-active");
    });
  }

  function initializeSwiper(containerSelector, breakpoints) {
    // console.log(containerSelector);
    const swiperEl = containerSelector;
    swiperEl.style.display = "block";

    Object.assign(swiperEl, {
      spaceBetween: 10,
      breakpoints,
    });

    swiperEl.initialize();
  }

  const swipterSettings = {
    0: { slidesPerView: 3, spaceBetween: 10 },
    640: { slidesPerView: 4 },
    768: { slidesPerView: 6 },
    1200: { slidesPerView: 10 },
  };

  if (sliderMangas) {
    initializeSwiper(sliderMangas, {
      0: {
        slidesPerView: 1,
        spaceBetween: 0,
      },
    });
  }

  if (popularCards) {
    popularCards.forEach((popularCard) => {
      initializeSwiper(popularCard, swipterSettings);
    });
  }

  if (latestCards) {
    latestCards.forEach((latestCard) => {
      initializeSwiper(latestCard, swipterSettings);
    });
  }

  if (suggestedMangas) {
    initializeSwiper("#suggested-mangas", {
      0: { slidesPerView: 3, spaceBetween: 10 },
      640: { slidesPerView: 4 },
      768: { slidesPerView: 6 },
      1200: { slidesPerView: 8 },
    });
    suggestedMangas?.classList.remove("!hidden");
  }

  if (cardLoaders) {
    cardLoaders.forEach((cardLoader) => {
      cardLoader.remove();
    });

    cardReals.forEach((cardReal) => {
      cardReal.classList?.remove("hidden");
    });
  }
});
