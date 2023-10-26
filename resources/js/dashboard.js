import { tablesFilters } from "./dashboard/tablesFilter";
import { initializeAds } from "./dashboard/ads";
import { initializeNavbar } from "./dashboard/navbar";
import { initializeSelection } from "./dashboard/tomSelect";
import { initializeSlugAutoComplete } from "./dashboard/slug";
import { initializeDeleteModals } from "./dashboard/deleteModal";
import { initializeContentCover } from "./dashboard/contentCover";

document.addEventListener("DOMContentLoaded", function () {
  initializeNavbar();
  tablesFilters();
  initializeAds();
  initializeSelection();
  initializeSlugAutoComplete();
  initializeDeleteModals();
  initializeContentCover();
});
