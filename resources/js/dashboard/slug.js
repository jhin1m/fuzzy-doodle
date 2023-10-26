export function initializeSlugAutoComplete() {
  const titleInput = document.querySelector("#title");
  const slugInput = document.querySelector("#slug");

  if (titleInput && slugInput) {
    titleInput.addEventListener("input", function () {
      const title = titleInput.value.trim();
      const slug = title
        .replace(/[^\w\s-]/g, "") // Remove special characters except whitespace and hyphens
        .replace(/\s+/g, "-") // Replace whitespace with hyphens
        .replace(/-+$/, ""); // Remove trailing hyphens
      slugInput.value = slug.toLowerCase();
    });
  }
}
