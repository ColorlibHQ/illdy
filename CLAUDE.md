# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

**Illdy** — a free one-page/multipurpose **WordPress theme** by Colorlib (not a static HTML template). Current stack is Bootstrap **3.3.6** + jQuery + Owl Carousel 2, built on the vendored **Epsilon Framework** (MachoThemes) for its Customizer controls.

Front-page content is driven by **widgets**, not by the Customizer text fields — the widgets themselves live in the separate **Illdy Companion** plugin (guarded by `defined( 'ILLDY_COMPANION' )`). Without that plugin, front-page sections render hardcoded `the_widget()` demo content, and only for users with `edit_theme_options`.

This directory is **not a git repository**.

## Commands

There is no test suite and no lint config. All tooling is Grunt (`npm install` first):

```bash
npx grunt buildpot        # regenerate languages/illdy.pot via grunt-wp-i18n
npx grunt textdomain      # audit i18n calls; allowed domains: illdy, epsilon-framework
npx grunt mincss          # layout/css/*.css -> *.min.css (skips style-overrides.css)
npx grunt minjs           # layout/js/**/*.js -> *.min.js (skips jquery.fancybox.js)
npx grunt minimg          # imagemin over layout/images/
npx grunt allmin          # minimg + mincss + minjs
npx grunt build-archive   # produce illdy.zip (excludes node_modules, Gruntfile, package.json)
```

`grunt` with no task is a no-op. `build-archive` has `makepot` and `allmin` commented out — run them explicitly before packaging.

## Architecture

### Bootstrap order (`functions.php`)

`illdy_setup()` (on `after_setup_theme`) requires `inc/extras.php`, `inc/customizer/customizer.php`, `inc/jetpack.php`, the three `inc/components/*` output classes, and `inc/back-compatible.php`, then registers theme support, image sizes, and nav menus. Separately, the **bottom of the file** requires the Epsilon autoloader, `inc/class-mt-notify-system.php`, the welcome screen, and `inc/class-illdy.php` — which ends in `new Illdy()`. That constructor boots `Epsilon_Framework`, the color scheme, the welcome screen, and the "Recommended Actions" Customizer section.

### Front-page section pipeline

The front page is a reorderable stack. Three pieces must stay in sync:

| Concern | Location |
|---|---|
| Default order + stored order | `illdy_get_sections_position()` in [inc/customizer/customizer.php](inc/customizer/customizer.php) — theme_mod `illdy_frontpage_sections`, an array of **panel IDs** |
| Visibility toggle map | `illdy_sections_order()` in [inc/extras.php](inc/extras.php) — panel ID → `illdy_*_general_show` theme_mod |
| Panel ID → template map | `illdy_sections()` in [inc/extras.php](inc/extras.php) — renders `sections/front-page-{slug}.php` |

Customizer panel priority is derived from the same array via `illdy_get_section_position()`, so drag-and-drop reordering (AJAX action `wp_ajax_illdy_order_sections`) changes both the render order and the panel order. **Adding a section means editing all three maps plus creating `sections/front-page-*.php` and `inc/customizer/panels/*.php`.**

`front-page.php` only runs this pipeline when `show_on_front == 'page'`; otherwise it falls back to a blog loop.

### Customizer panels

`inc/customizer/panels/*.php` are plain includes pulled in from inside `illdy_customize_register()`, so `$wp_customize` is in scope at file top level. Each sets `$panel_id` / `$prefix = 'illdy'` and calls `add_setting` / `add_control` directly. Controls are Epsilon classes (`Epsilon_Control_Toggle`, `Epsilon_Control_Text_Editor`, `Epsilon_Control_Color_Picker`, …) plus theme-local ones in `inc/customizer/class-*.php`.

### Three parallel styling paths (easy to break)

1. **Server render** — `illdy_jumbotron_css()`, `illdy_about_css()`, `illdy_projects_css()`, etc. in [inc/extras.php](inc/extras.php), all echoed by `illdy_output_sections_css()` on `wp_head` priority 99.
2. **Customizer live preview** — Handlebars templates printed by `illdy_print_customizer_templates()` on `wp_footer` (only when `is_customize_preview()`), in [inc/customizer/customizer.php](inc/customizer/customizer.php). These *duplicate* the rules from path 1.
3. **Color scheme** — [layout/css/style-overrides.css](layout/css/style-overrides.css) is a **printf template**, not valid CSS: `%1$s`…`%5$s` map in order to `epsilon_accent_color`, `epsilon_secondary_accent_color`, `epsilon_text_color`, `epsilon_contrast_color`, `epsilon_hover_color`, registered in `Illdy::init_color_scheme()` and consumed by `Epsilon_Color_Scheme::load_css_overrides()`.

Any new color/background Customizer option must be added to **both** path 1 and path 2, or the live preview will diverge from the published front end.

### Header / jumbotron

[header.php](header.php) builds the inline `style` attribute for `#header` itself (background image, parallax `background-attachment`, iOS Safari fallback) and switches jumbotron variant on theme_mod `illdy_jumbotron_background_type` (`image` | `video` | `slider`), delegating to `sections/front-page-header-video.php` or `-header-slider.php`, then always `-bottom-header.php`. Video mode enqueues core `wp-custom-header` with settings from `illdy_get_video_settings()`.

### Template hooks

Custom actions available to templates and the companion plugin: `illdy_above_content_after_header`, `illdy_after_content_above_footer` (pagination attached in `functions.php`), `illdy_single_entry_meta`, `illdy_archive_meta_content`, `illdy_single_after_content`. The last three are fired into by the singleton output classes in `inc/components/` (entry-meta, author-box, related-posts), each hooked on `wp_loaded`.

### Vendored: Epsilon Framework

`inc/libraries/epsilon-framework/` is third-party (MachoThemes v1.2.2) with its own `package.json`, `webpack.config.js`, `tsconfig.json`, and TypeScript sources under `assets/vendors/`. Treat as vendored — don't hand-edit its compiled `assets/js/*.js`, and prefer working around it rather than patching it.

## Gotchas

- **`layout/scss/` is stale and is NOT the source of the shipped CSS.** The live stylesheet is `layout/css/main.css` (3214 lines); `layout/scss/main.scss` (2295 lines) has diverged — e.g. `.illdy-top` and all `:focus-within` rules exist only in the CSS. Edit `layout/css/main.css` directly; recompiling the SCSS over it would silently drop work.
- **`layout/css/style-overrides.css` must never be minified or treated as real CSS** — it's the printf template above. `Gruntfile.js` already excludes it from `cssmin`.
- **Version strings are out of sync across four files**: `style.css` 2.1.10, `readme.txt` 2.1.10, `package.json` 2.1.1, and the `wp_enqueue_*` cache-busting args in `functions.php` are `'2.1.9'`. Update all of them together on release.
- `functions.php` enqueues **`scripts.js` unminified** while its siblings load `.min.js`. Regenerating minified files with `grunt minjs` won't change what's served for that handle.
- `layout/js/stickyjs/jquery.min.js` is a stray bundled jQuery copy; the theme relies on WordPress core's jQuery everywhere.
- Front-page sidebars (`front-page-about-sidebar`, `front-page-projects-sidebar`, …) are special: `Illdy::remove_specific_widget()` strips `illdy_home_parallax` widgets from every *other* sidebar. Override with the `illdy_remove_custom_widgets` filter.
- `languages/` currently ships `.po`/`.mo` for fr_FR and pt_BR plus `illdy.po`, but **no `.pot`** — run `grunt buildpot` if translators need one.
- `inc/back-compatible.php` runs migrations of old theme_mods on every load, keyed off `wp_get_theme()->version` comparisons. Bumping the version in `style.css` can re-trigger or newly trigger these blocks.
