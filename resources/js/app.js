import { initializeDarkTheme } from "./app/darkToggle.js";
import { initializeForms } from "./app/formsBtn.js";
import { initializeDropdowns } from "./app/dropDown";
import { initializeCloseAds } from "./app/closeAds.js";

document.addEventListener("DOMContentLoaded", function () {
  initializeDarkTheme();
  initializeForms();
  initializeDropdowns();
  initializeCloseAds();
});
