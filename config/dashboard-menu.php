<?php

return [
  [
    "route" => "dashboard.index",
    "label" => "Dashboard",
    "permission" => "view_dashboard",
  ],
  [
    "label" => "Content",
    "permission" => "view_mangas",
    "dropdown" => [
      [
        "route" => "dashboard.mangas.index",
        "label" => "Mangas List",
        "permission" => "view_mangas",
      ],
      [
        "route" => "dashboard.chapters.index",
        "label" => "Chapters List",
        "permission" => "view_chapters",
      ],
      [
        "route" => "dashboard.comments.index",
        "label" => "Comments",
        "permission" => "view_comments",
      ],
      [
        "route" => "dashboard.genres.index",
        "label" => "Genres",
        "permission" => "view_taxonomies",
      ],
      [
        "route" => "dashboard.mangas_types.index",
        "label" => "Types",
        "permission" => "view_taxonomies",
      ],
      [
        "route" => "dashboard.mangas_status.index",
        "label" => "Statuses",
        "permission" => "view_taxonomies",
      ],
    ],
  ],
  [
    "route" => "dashboard.plugins.index",
    "label" => "Plugins",
    "permission" => "view_plugins",
  ],
  [
    "route" => "dashboard.pages.index",
    "label" => "Pages",
    "permission" => "view_pages",
  ],
  [
    "label" => "Users",
    "permission" => "view_users",
    "dropdown" => [
      [
        "route" => "dashboard.users.index",
        "label" => "Users",
        "permission" => "view_users",
      ],
      [
        "route" => "dashboard.roles.index",
        "label" => "Roles",
        "permission" => "view_roles",
      ],
    ],
  ],
  [
    "label" => "Settings",
    "permission" => "view_settings",
    "dropdown" => [
      [
        "route" => "dashboard.settings.index_site",
        "label" => "Site Settings",
        "permission" => "view_settings",
      ],
      [
        "route" => "dashboard.settings.index_mail",
        "label" => "Mail Settings",
        "permission" => "view_settings",
      ],
      [
        "route" => "dashboard.settings.index_seo",
        "label" => "Seo Settings",
        "permission" => "view_settings",
      ],
      [
        "route" => "dashboard.settings.index_upload",
        "label" => "Upload Settings",
        "permission" => "view_settings",
      ],
      [
        "route" => "dashboard.settings.index_theme",
        "label" => "Theme Settings",
        "permission" => "view_settings",
      ],
      [
        "route" => "dashboard.ads.index",
        "label" => "Ads Settings",
        "permission" => "view_settings",
      ],
      [
        "route" => "dashboard.settings.clear_cache",
        "label" => "Clear Cache",
        "permission" => "view_settings",
      ],
    ],
  ],
];
