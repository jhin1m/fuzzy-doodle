export function initializeCloseAds() {
  const adsBtns = document.querySelectorAll("#close-ad");

  if (adsBtns) {
    adsBtns.forEach((adsBtn) => {
      adsBtn.addEventListener("click", (e) => {
        e.preventDefault();
        adsBtn.parentNode.remove(); // remove it from the DOM to reduce the size
      });
    });
  }
}
