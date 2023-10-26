export function initializeNavbar() {
  const navBtn = document.querySelector("#nav-toggle");
  const navMenu = document.querySelector("#nav-menu");
  const parentElement = navBtn.parentElement.parentElement;
  let menuVisible = false;

  // Close the menu on page load
  closeMenu();

  navBtn.addEventListener("click", function (e) {
    e.preventDefault();

    if (menuVisible) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  function openMenu() {
    if (!menuVisible) {
      const menuWrapper = document.createElement("div");
      menuWrapper.classList.add(
        "sm:hidden",
        "container-app",
        "flex",
        "flex-col",
        "gap-3",
        "navbar"
      );
      menuWrapper.innerHTML = navMenu.innerHTML;
      parentElement.appendChild(menuWrapper);

      // Add event listeners to dropdown toggles
      const dropdownToggles = menuWrapper.querySelectorAll(
        '[data-toggle="dropdown"]'
      );
      dropdownToggles.forEach((toggle) => {
        const menu = toggle.nextElementSibling;
        toggle.addEventListener("click", function () {
          menu.classList.toggle("hidden");
        });
      });

      menuVisible = true;
    }
  }

  function closeMenu() {
    if (menuVisible) {
      parentElement.removeChild(parentElement.lastChild);
      menuVisible = false;
    }
  }
}
