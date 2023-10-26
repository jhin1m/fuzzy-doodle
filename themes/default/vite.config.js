import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/js/app.js",
        "resources/js/dashboard.js",
        "resources/js/app/closeAds.js",
        "resources/js/app/dropDown.js",
        "resources/js/app/darkToggle.js",
        "resources/js/app/formsBtn.js",
        "resources/js/dashboard/ads.js",
        "resources/js/dashboard/bulkUpload.js",
        "resources/js/dashboard/chapterUpload.js",
        "resources/js/dashboard/deleteModal.js",
        "resources/js/dashboard/manga.js",
        "resources/js/dashboard/navbar.js",
        "resources/js/dashboard/slug.js",
        "resources/js/dashboard/tablesFilter.js",
        "resources/js/dashboard/tomSelect.js",
        "resources/css/app.css",
        "resources/css/dropzone.css",
        "resources/css/editor.css",
        "resources/css/tom-select.css",
        "themes/default/css/app.css",
        "themes/default/js/app.js",
        "themes/default/js/chapter.js",
      ],
      // buildDirectory: "default",
    }),

    {
      name: "blade",
      handleHotUpdate({ file, server }) {
        if (file.endsWith(".blade.php")) {
          server.ws.send({
            type: "full-reload",
            path: "*",
          });
        }
      },
    },
  ],
  resolve: {
    alias: {
      "@": "/themes/default/js",
    },
  },
  css: {
    postcss: {
      plugins: [
        require("tailwindcss")({
          config: path.resolve(__dirname, "tailwind.config.js"),
        }),
      ],
    },
  },
});
