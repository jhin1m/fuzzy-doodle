export function initializeDarkTheme() {
  const toggleBtn = document.querySelector('[data-toggle="dark"]');
  const editor = document.querySelector("#editor");
  const htmlClasses = document.documentElement.classList;

  if (toggleBtn) {
    let darkMode = localStorage.getItem("dark-mode");

    if (!darkMode) {
      if (htmlClasses.contains("dark")) {
        localStorage.setItem("dark-mode", "enabled");
      } else {
        localStorage.setItem("dark-mode", "disabled");
      }
    }

    function initializeTinyMCE(skin) {
      tinymce.remove();
      tinymce.init({
        selector: "textarea#editor",
        skin: skin,
        plugins:
          "searchreplace autolink directionality visualblocks visualchars image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap emoticons autosave",
        toolbar:
          "undo redo print spellcheckdialog formatpainter | blocks fontfamily fontsize | bold italic underline forecolor backcolor | link image | alignleft aligncenter alignright alignjustify lineheight | checklist bullist numlist indent outdent | removeformat",
      });
    }

    function enableDarkMode() {
      toggleBtn.innerHTML = getDarkModeIcon(true);
      if (htmlClasses.contains("light")) {
        htmlClasses.add("dark");
        htmlClasses.remove("light");
      }

      if (editor) {
        initializeTinyMCE("oxide-dark");
      }
      localStorage.setItem("dark-mode", "enabled");
    }

    function disableDarkMode() {
      toggleBtn.innerHTML = getDarkModeIcon(false);
      if (htmlClasses.contains("dark")) {
        htmlClasses.add("light");
        htmlClasses.remove("dark");
      }

      if (editor) {
        initializeTinyMCE("oxide");
      }
      localStorage.setItem("dark-mode", "disabled");
    }

    function getDarkModeIcon(enabled) {
      const iconColorClass = enabled ? "text-white hover:text-yellow-300" : "hover:text-gray-600";
      const iconPath = enabled
        ? '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />'
        : '<path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />';

      return (
        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 transition ' +
        iconColorClass +
        '">' +
        iconPath +
        "</svg>"
      );
    }

    function toggleDarkMode() {
      darkMode = localStorage.getItem("dark-mode");
      if (darkMode === "enabled") {
        disableDarkMode();
      } else if (darkMode === "disabled") {
        enableDarkMode();
      }
    }

    toggleBtn.addEventListener("click", toggleDarkMode);

    if (darkMode === "enabled") {
      enableDarkMode();
    } else if (darkMode === "disabled") {
      disableDarkMode();
    }
  }
}
