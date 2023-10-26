export function initializeAds() {
  const adTypeSelect = document.querySelector("#ad-type");
  const adBannerDiv = document.querySelector("#ad-banner");
  const adScriptDiv = document.querySelector("#ad-script");

  if (adTypeSelect) {
    function handleAdTypeChange() {
      if (adTypeSelect.value === "banner") {
        adBannerDiv.classList.remove("hidden");
        adScriptDiv.classList.add("hidden");
      } else {
        adBannerDiv.classList.add("hidden");
        adScriptDiv.classList.remove("hidden");
      }
    }

    handleAdTypeChange();

    adTypeSelect.addEventListener("change", handleAdTypeChange);
  }
}
