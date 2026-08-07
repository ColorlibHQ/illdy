# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

**Illdy** — a free one-page/multipurpose **WordPress theme** by Colorlib (not a static HTML template). Current stack is Bootstrap **3.3.6 CSS only** + jQuery + Owl Carousel 2, with Customizer controls built on **core WordPress APIs** plus five theme-owned control classes in `inc/customizer/controls/`.

The theme was previously built on a vendored copy of the **Epsilon Framework** (MachoThemes 1.2.2). It is **entirely removed** as of 2.2.0 — don't re-add it or reach for `Epsilon_*` classes. `inc/customizer/class-illdy-deprecated.php` and `inc/class-illdy-deprecated-onboarding.php` hold thin shims for the old public names so third-party code doesn't fatal; they are BC only, never a target for new code.

**Appearance → About Illdy** ([inc/admin/class-illdy-welcome.php](inc/admin/class-illdy-welcome.php)) is theme-owned and built on core admin markup — it keeps the original `illdy-welcome` slug so old bookmarks and Colorlib's docs links still resolve. Tabs: Getting Started, Recommended Plugins, Support, plus **Import Demo Content** contributed by Illdy Companion.

Tabs are extensible — `illdy_welcome_tabs` (filter, id => label) and `illdy_welcome_tab_{id}` (action, renders the body). An unrecognised `?tab=` falls back to the first tab rather than being used as a path, which is how the Epsilon version fataled.

The Recommended Plugins tab emits core's `.plugin-card` markup inside `#plugin-filter` and enqueues core's `plugin-install`/`updates` scripts, so Install/Activate run through `wp.updates` — **the theme ships no JS and owns no nonce for this**. `Illdy_Plugin_State` ([inc/admin/class-illdy-plugin-state.php](inc/admin/class-illdy-plugin-state.php)) resolves install/active state and caches `plugins_api()` in a transient (12 h; failures cached 1 h so an offline site doesn't retry every load).

What is **not** coming back: Recommended Actions (the dismissable checklist that wrote its own option), the PRO licence/EDD updater, and the admin notice that nagged on every screen.

Targets WordPress 7 / PHP 8.5; verified to boot with zero PHP notices, warnings or deprecations on WP 7.0.2 / PHP 8.5.6. Bootstrap's **JavaScript is deliberately not loaded** — no template emits a `data-toggle`/`data-target`/`data-ride`/`data-dismiss`/`data-slide` attribute, so no Bootstrap plugin was ever initialised, and every published Bootstrap 3 CVE lives in that code. Don't re-add it; if you need a Bootstrap JS component, add the specific behaviour in `layout/js/scripts.js` instead.

Front-page content is driven by **widgets**, not by the Customizer text fields — the widgets themselves live in the separate **Illdy Companion** plugin (guarded by `defined( 'ILLDY_COMPANION' )`). Without that plugin, front-page sections render hardcoded `the_widget()` demo content, and only for users with `edit_theme_options`.

This directory is **not a git repository**.

## Commands

There is no test suite and no lint config. All tooling is Grunt (`npm install` first):

```bash
npx grunt buildpot        # regenerate languages/illdy.pot via grunt-wp-i18n
npx grunt textdomain      # audit i18n calls; allowed domain: illdy
npx grunt mincss          # layout/css/*.css -> *.min.css (skips style-overrides.css)
npx grunt minjs           # layout/js/**/*.js -> *.min.js (skips jquery.fancybox.js)
npx grunt minimg          # imagemin over layout/images/
npx grunt allmin          # minimg + mincss + minjs
npx grunt build-archive   # produce illdy.zip (excludes node_modules, Gruntfile, package.json)
```

`grunt` with no task is a no-op. `build-archive` has `makepot` and `allmin` commented out — run them explicitly before packaging.

## Architecture

### Bootstrap order (`functions.php`)

`illdy_setup()` (on `after_setup_theme`, priority 10) requires `inc/extras.php`, `inc/customizer/customizer.php`, `inc/jetpack.php`, the three `inc/components/*` output classes, and `inc/back-compatible.php`, then registers theme support, image sizes, and nav menus. The **bottom of the file** requires `inc/customizer/class-illdy-color-scheme.php`, `inc/class-illdy-deprecated-onboarding.php`, and `inc/class-illdy.php`.

**Timing is load-bearing** — this ordering exists to satisfy WordPress 6.7+'s just-in-time translation rules:

| When | What |
|---|---|
| file parse | hooks registered only — **no `__()` may run here** |
| `after_setup_theme` 10 | `illdy_setup()` calls `load_theme_textdomain()` *before* any translated string |
| `after_setup_theme` 15 | `illdy_boot()` → `new Illdy()` → colour scheme (its field labels are translated) |
| `customize_register` 11 | `illdy_customize_register()` — see the note in `customizer.php` before changing this |

Anything that calls `__()` must not move earlier, or WP 6.7+ emits `_load_textdomain_just_in_time was called incorrectly` for the `illdy` domain.

The `illdy_required_actions` filter is **gone** along with the recommended-actions list that consumed it. Illdy Companion no longer hooks it.

### Front-page section pipeline

The front page is a reorderable stack. Three pieces must stay in sync:

| Concern | Location |
|---|---|
| Canonical id list / allowlist | `illdy_get_default_sections()` in [inc/customizer/customizer.php](inc/customizer/customizer.php) |
| Stored order (validated on read) | `illdy_get_sections_position()` in [inc/customizer/customizer.php](inc/customizer/customizer.php) — theme_mod `illdy_frontpage_sections`, an array of **panel IDs** |
| Visibility toggle map | `illdy_sections_order()` in [inc/extras.php](inc/extras.php) — panel ID → `illdy_*_general_show` theme_mod |
| Panel ID → template map | `illdy_sections()` in [inc/extras.php](inc/extras.php) — renders `sections/front-page-{slug}.php` |

`illdy_get_default_sections()` is both the shipped order **and** the allowlist used by the reorder AJAX endpoint and by `illdy_get_sections_position()`. An id missing from it is silently dropped everywhere, so add new sections there first.

Customizer panel priority is derived from the same array via `illdy_get_section_position()`, so drag-and-drop reordering (AJAX action `wp_ajax_illdy_order_sections`) changes both the render order and the panel order. **Adding a section means editing all three maps plus creating `sections/front-page-*.php` and `inc/customizer/panels/*.php`.**

`front-page.php` only runs this pipeline when `show_on_front == 'page'`; otherwise it falls back to a blog loop.

### Customizer panels

`inc/customizer/panels/*.php` are plain includes pulled in from inside `illdy_customize_register()`, so `$wp_customize` is in scope at file top level. Each sets `$panel_id` / `$prefix = 'illdy'` and calls `add_setting` / `add_control` directly.

Controls are core types wherever core has one — `checkbox` (was Epsilon's toggle), `range` (was its slider), `select`, `textarea`, `WP_Customize_Color_Control`, `WP_Customize_Image_Control` — plus five theme-owned classes in `inc/customizer/controls/` for the things core lacks:

| Class | Purpose |
|---|---|
| `Illdy_Control_Text_Editor` | TinyMCE via `wp_enqueue_editor()` |
| `Illdy_Control_Color_Scheme` | the palette picker; writes the five `epsilon_*_color` mods |
| `Illdy_Control_Repeater` | jumbotron slides; stores JSON in one setting |
| `Illdy_Control_Tab` / `Illdy_Control_Button` | panel chrome, no stored value |

plus `Illdy_Section_Pro` in `inc/customizer/sections/`. `Illdy_Control_Tab` and `Illdy_Control_Button` need `register_control_type()`; `Illdy_Section_Pro` calls `register_section_type()` in its own constructor. **Skip that and the JS template is never printed and the control silently vanishes.**

### Three parallel styling paths (easy to break)

1. **Server render** — `illdy_jumbotron_css()`, `illdy_about_css()`, `illdy_projects_css()`, etc. in [inc/extras.php](inc/extras.php), all echoed by `illdy_output_sections_css()` on `wp_head` priority 99.
2. **Customizer live preview** — Handlebars templates printed by `illdy_print_customizer_templates()` on `wp_footer` (only when `is_customize_preview()`), in [inc/customizer/customizer.php](inc/customizer/customizer.php). These *duplicate* the rules from path 1.
3. **Color scheme** — [layout/css/style-overrides.css](layout/css/style-overrides.css) is a **printf template**, not valid CSS: `%1$s`…`%5$s` map in order to `epsilon_accent_color`, `epsilon_secondary_accent_color`, `epsilon_text_color`, `epsilon_contrast_color`, `epsilon_hover_color`, registered in `Illdy::init_color_scheme()` and consumed by `Illdy_Color_Scheme::load_css_overrides()`. The setting ids keep their `epsilon_` prefix deliberately — they are what existing sites have stored, and renaming them would drop every customer's colours.

Any new color/background Customizer option must be added to **both** path 1 and path 2, or the live preview will diverge from the published front end.

Path 1 emits one `<style>` per section and the id **must** stay `illdy-<section>-section-css` — the previewer resolves its target by building that exact string (`inc/customizer/assets/js/illdy-customizer-live-preview.js`). Two blocks previously shared `illdy-about-section-css`, so About edits overwrote the jumbotron's CSS. Outside the Customizer preview, sections with no rules are skipped entirely; inside it every id is emitted even when empty so the previewer always finds its element.

### Header / jumbotron

[header.php](header.php) builds the inline `style` attribute for `#header` itself (background image, parallax `background-attachment`, iOS Safari fallback) and switches jumbotron variant on theme_mod `illdy_jumbotron_background_type` (`image` | `video` | `slider`), delegating to `sections/front-page-header-video.php` or `-header-slider.php`, then always `-bottom-header.php`. Video mode enqueues core `wp-custom-header` with settings from `illdy_get_video_settings()`.

### Template hooks

Custom actions available to templates and the companion plugin: `illdy_above_content_after_header`, `illdy_after_content_above_footer` (pagination attached in `functions.php`), `illdy_single_entry_meta`, `illdy_archive_meta_content`, `illdy_single_after_content`. The last three are fired into by the singleton output classes in `inc/components/` (entry-meta, author-box, related-posts), each hooked on `wp_loaded`.

### Demo content import (lives in the plugin)

Illdy Companion owns the logic and the endpoint; the theme only provides the tab to render into. `Illdy_Companion_Importer_Page` hooks `illdy_welcome_tabs` and renders on `illdy_welcome_tab_import`, and handles `wp_ajax_illdy_companion_import_demo` (own nonce + `manage_options`), calling `Illdy_Companion_Import_Data::process_sample_content()`. Step names from the request are intersected with `get_import_steps()` — never call a method named by request data.

Two things to know before touching it:

- **It defers its wiring to `after_setup_theme`.** Plugins load *before* themes, so `class_exists( 'Illdy_Welcome' )` is false at plugin-parse time. Checking there would always fall through to the standalone-page fallback.
- **It falls back to its own Appearance page** when the theme offers no About screen (older Illdy, or a child theme that removed it), so the importer is never unreachable.

The import **overwrites** theme mods and front-page widgets, which is why the panel warns and the JS confirms first. `inc/libraries/` no longer exists; there is nothing vendored in the theme.

## Gotchas

- **The theme opts out of the block widget editor** — `remove_theme_support( 'widgets-block-editor' )` in `illdy_setup()`. Core adds that support on `after_setup_theme` priority **1** and documents it as themes' opt-out point; `illdy_setup()` runs at 10, so the ordering is intentional, not luck. Don't remove it: the Companion's widget forms are jQuery-driven (icon picker, media frame, TinyMCE), and the block screen renders them as Legacy Widget blocks — a rendered *preview* instead of the form, with the theme's front-end CSS bleeding in and the widgets' admin scripts never running. A site can still opt back in with `add_filter( 'use_widgets_block_editor', '__return_true' )`.
- **Send people to the Customizer, not `widgets.php`.** The front page is a stack of widget areas, so the Widgets screen lists them out of order, named by section, with no preview. `Illdy_Widgets_Admin::panel_url()` deep-links into the Front Page Sections panel (`autofocus[panel]`); use it rather than hardcoding a Customizer URL. The Widgets screen still works and carries a pointer to that panel — core UI is not removed.
- **The theme serves the `.min` assets, so edits to a source file are invisible until you regenerate it.** `functions.php` enqueues `main.min.css`, `custom.min.css`, `bootstrap.min.css`, `plugins.min.js` and `scripts.min.js`. After editing any of those sources run `npx grunt mincss` / `npx grunt minjs`, or directly:

  ```bash
  npx clean-css-cli@5 -O1 -o layout/css/main.min.css layout/css/main.css
  npx terser@5 layout/js/scripts.js -c -m -o layout/js/scripts.min.js
  ```

  Use clean-css `-O1`; `-O2` restructures rules and can shift the cascade.
- **`layout/scss/` is stale and is NOT the source of the shipped CSS.** The live stylesheet is `layout/css/main.css`; `layout/scss/main.scss` has diverged — `.illdy-top` and all `:focus-within` rules exist only in the CSS. Edit `layout/css/main.css` directly; recompiling the SCSS over it would silently drop work.
- **`layout/css/style-overrides.css` must never be minified or treated as real CSS** — it's the printf template above. `Gruntfile.js` already excludes it from `cssmin`.
- **CSS files use CRLF line endings.** Tools that rewrite them must preserve that, or the diff becomes the whole file.
- Version lives in `style.css` and is read once into the **`ILLDY_VERSION`** constant, which every enqueue uses for cache busting. On release bump `style.css`, `readme.txt` and `package.json` together; nothing else hard-codes a version.
- Front-page-only libraries (Owl Carousel, countTo, jQuery Visible, parallax, jQuery UI progress bar) load only when `illdy_needs_front_page_assets()` is true. If you surface Illdy Companion widgets outside the front page, return true from the **`illdy_needs_front_page_assets`** filter. `plugins.js` feature-detects each library, so a missing one degrades silently rather than throwing.
- Front-page sidebars (`front-page-about-sidebar`, `front-page-projects-sidebar`, …) are special: `Illdy::remove_specific_widget()` strips `illdy_home_parallax` widgets from every *other* sidebar. Override with the `illdy_remove_custom_widgets` filter.
- `languages/` currently ships `.po`/`.mo` for fr_FR and pt_BR plus `illdy.po`, but **no `.pot`** — run `grunt buildpot` if translators need one.
- `inc/back-compatible.php` runs migrations of old theme_mods on every load, keyed off `wp_get_theme()->version` comparisons. Bumping the version in `style.css` can re-trigger or newly trigger these blocks.
