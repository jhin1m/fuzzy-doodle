export function initializeForms() {
  const forms = document.querySelectorAll("form");
  const logoutBtn = document.querySelector("#logout-button");

  forms.forEach((form) => {
    form.addEventListener("submit", (event) => {
      const submitButton = form.querySelector('button[type="submit"]');
      const btnText = form.querySelector('button[type="submit"] #btn-text');
      const btnLoader = form.querySelector('button[type="submit"] #btn-loader');
      const btnIcon = document.querySelector('button[type="submit"] #btn-icon');

      if (submitButton) {
        submitButton.disabled = true;
        submitButton?.classList.add("disabled:cursor-not-allowed");
      }

      btnLoader && btnLoader?.classList.remove("hidden");

      if (btnIcon) {
        btnLoader?.classList.add("!right[50%]");
        btnIcon?.classList.add("hidden");
      }
    });
  });

  if (logoutBtn) {
    logoutBtn?.addEventListener("click", function (e) {
      e.preventDefault();
      logoutBtn?.parentNode.submit();
    });
  }
}
