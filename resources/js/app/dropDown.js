import { initializeDeleteModals } from "../dashboard/deleteModal";

export function initializeDropdowns() {
  const dropdownButtons = document.querySelectorAll('[data-toggle="dropdown"]');
  const debounceDelay = 100; // Set the debounce delay as per your needs

  const adjustMenuPosition = (button, menu) => {
    const buttonRect = button.getBoundingClientRect();
    const menuHeight = menu.offsetHeight;
    const menuWidth = menu.offsetWidth;

    let top = buttonRect.bottom + window.scrollY;
    let left;

    const spaceLeft = buttonRect.left;
    const spaceRight = window.innerWidth - buttonRect.right;

    if (spaceLeft >= spaceRight) {
      // More space on the right, position menu at the right side of the button
      left = buttonRect.right - menuWidth;
    } else {
      // More space on the left, position menu at the left side of the button
      left = buttonRect.left;
    }

    // Check if the menu is going beyond the bottom of the screen
    if (top + menuHeight > window.innerHeight + window.scrollY) {
      top = buttonRect.top - menuHeight + window.scrollY;
    }

    // Check if the menu is going beyond the left or right side of the screen
    if (left < 0) {
      left = 0;
    } else if (left + menuWidth > window.innerWidth) {
      left = window.innerWidth - menuWidth;
    }

    menu.style.top = `${top}px`;
    menu.style.left = `${left}px`;
    menu.style.width = `${menuWidth}px`;
    menu.style.zIndex = `99999`;
  };

  const hideAllMenus = () => {
    document.querySelectorAll(".cloned-menu").forEach((menu) => {
      menu.classList.add("hidden");
    });

    // Remove the cloned menu if it exists
    const existingClonedMenu = document.querySelector(".cloned-menu");
    if (existingClonedMenu) {
      existingClonedMenu.remove();
    }
  };

  const attachLogoutFunctionality = (clonedMenu) => {
    const logoutBtn = clonedMenu.querySelector("#logout-button");

    if (logoutBtn) {
      logoutBtn.addEventListener("click", function (e) {
        e.preventDefault();
        logoutBtn.parentNode.submit();
      });
    }
  };

  const toggleMenu = (button) => {
    const menu = button.nextElementSibling;
    let clonedMenu = null;

    const existingClonedMenu = document.querySelector(".cloned-menu");
    if (existingClonedMenu) {
      hideAllMenus();
    } else {
      if (menu && menu.classList.contains("hidden")) {
        // If the menu is hidden, show it and adjust its position
        hideAllMenus();
        menu.classList.remove("hidden");
        adjustMenuPosition(button, menu);

        // Clone the menu and insert it at the end of the DOM
        clonedMenu = menu.cloneNode(true);
        clonedMenu.id = ""; // Remove the ID to avoid duplicate IDs
        clonedMenu.classList.add("cloned-menu");
        document.body.appendChild(clonedMenu);

        //
        initializeDeleteModals();

        // Attach logout functionality to the cloned menu
        attachLogoutFunctionality(clonedMenu);

        // Hide the main menu
        menu.classList.add("hidden");
      }
    }
  };

  dropdownButtons.forEach((button) => {
    button.addEventListener("click", (e) => {
      e.preventDefault();
      toggleMenu(button);
    });
  });

  document.addEventListener("click", (e) => {
    // const menu = e.target.closest(".dropdown-menu");
    if (!e.target.closest('[data-toggle="dropdown"]')) {
      hideAllMenus();
    }
  });

  // Debounce the handleResize function to avoid excessive calculations during rapid resizing
  let resizeTimer;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(hideAllMenus, debounceDelay);
  });
}
