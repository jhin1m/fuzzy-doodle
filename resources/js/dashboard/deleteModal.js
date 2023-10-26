export function initializeDeleteModals() {
  const deleteBtns = document.querySelectorAll('[data-toggle="delete"]');

  deleteBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      var link = e.target.href;
      showModal(link); // Pass the delete button link to showModal function
    });
  });

  function showModal(link) {
    const modalBackground = createModalElement();
    const modalContent = createModalContent(link);

    modalBackground.addEventListener("click", hideModal); // Clicking on the modal background will close the modal

    modalContent.addEventListener("click", (e) => {
      e.stopPropagation(); // Prevent clicks on modal content from bubbling to the background
    });

    modalBackground.appendChild(modalContent);
    document.documentElement.appendChild(modalBackground);
  }

  function createModalElement() {
    const modalBackground = document.createElement("div");
    modalBackground.id = "modal-background";
    modalBackground.className =
      "fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm cursor-pointer"; // Add cursor-pointer class here
    return modalBackground;
  }

  function createModalContent(link) {
    const modalContent = document.createElement("div");
    modalContent.className =
      "mx-3 sm:mx-0 cursor-auto text-sm border-[1px] border-black/10 bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-auto dark:border-white/10 dark:bg-[#09090b]";

    const modalMessage = createModalMessage();
    const modalSubMsg = createModalSubMessage();
    const btnsContainer = createModalButtons(link);

    modalContent.appendChild(modalMessage);
    modalContent.appendChild(modalSubMsg);
    modalContent.appendChild(btnsContainer);
    return modalContent;
  }

  function createModalMessage() {
    const modalMessage = document.createElement("h3");
    modalMessage.className = "font-bold text-lg text-gray-800 dark:text-white";
    modalMessage.textContent = "Are you sure you want to delete?";
    return modalMessage;
  }

  function createModalSubMessage() {
    const modalSubMsg = document.createElement("p");
    modalSubMsg.className = "text-gray-400 mt-2";
    modalSubMsg.textContent =
      "This action cannot be undone. This will permanently delete your account and remove your data from our servers.";
    return modalSubMsg;
  }

  function createModalButtons(link) {
    const btnsContainer = document.createElement("div");
    btnsContainer.className = "flex gap-3 justify-end mt-6";

    const cancelButton = createCancelButton();
    const primaryButton = createPrimaryButton(link);

    btnsContainer.appendChild(primaryButton);
    btnsContainer.appendChild(cancelButton);
    return btnsContainer;
  }

  function createCancelButton() {
    const cancelButton = document.createElement("button");
    cancelButton.type = "button";
    cancelButton.className =
      "px-6 py-2 bg-transparent text-black border-[1px] border-black/10 hover:bg-black/10 text-black rounded-md font-medium dark:border-white/10 dark:hover:bg-white/10 dark:text-white";
    cancelButton.textContent = "Cancel";
    cancelButton.addEventListener("click", hideModal);
    return cancelButton;
  }

  function createPrimaryButton(link) {
    const primaryButton = document.createElement("a");
    primaryButton.href = link;
    primaryButton.className =
      "px-6 py-2 bg-[#09090b] hover:bg-[#09090b]/90 text-white rounded-md font-medium dark:bg-white dark:text-black dark:hover:bg-white/90";
    primaryButton.textContent = "Submit";
    primaryButton.addEventListener("click", hideModal);
    return primaryButton;
  }

  function hideModal() {
    const modalBackground = document.getElementById("modal-background");
    if (modalBackground) {
      modalBackground.remove();
    }
  }
}
