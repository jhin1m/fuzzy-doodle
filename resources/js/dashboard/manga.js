import TomSelect from "tom-select";

new TomSelect("#input-tags", {
  plugins: {
    remove_button: {
      title: "Remove this item",
    },
    restore_on_backspace: {},
  },

  persist: false,
  createOnBlur: true,
  create: true,
  onItemAdd: function () {
    this.setTextboxValue("");
    this.refreshOptions();
  },
});
