import TomSelect from "tom-select";

export function initializeSelection() {
  const tomSelect = document.querySelector("#tom-select");
  if (tomSelect) {
    new TomSelect("#tom-select", {
      create: false,
    });
  }

  document.querySelector(".ts-wrapper")?.classList.remove("hidden");
}
