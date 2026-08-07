# Releasing Illdy

Illdy ships to the [WordPress.org theme directory](https://wordpress.org/themes/illdy/)
as a zip uploaded through a web form. There is no SVN step for themes — the directory
imports the upload into its own repository for you.

Current version: **2.2.0** (WordPress 7.0, PHP 7.4+).

## Before you build

Version lives in three places and they must agree. `ILLDY_VERSION` is derived from
`style.css`, so that file is the source of truth:

| File | Field |
|---|---|
| `style.css` | `Version:` |
| `readme.txt` | `Stable tag:` |
| `package.json` | `version` |

Then, in order:

1. **Update the changelog.** `CHANGELOG.txt` carries the full detail; `readme.txt` has
   a `== Changelog ==` section with the headline items. Both are read by humans — the
   directory shows the readme one on the theme page.
2. **Regenerate the translation template** if any string changed:
   ```bash
   wp i18n make-pot . languages/illdy.pot --domain=illdy \
     --exclude=node_modules,layout/js,inc/customizer/assets
   ```
   It must finish with no `Warning:` lines. A warning means a string with placeholders
   has no `translators:` comment, which leaves translators guessing what `%1$s` is.
3. **Regenerate minified assets if you edited a source file.** The theme enqueues the
   `.min` versions, so an edit to `layout/css/main.css` or `layout/js/scripts.js` is
   invisible until you do:
   ```bash
   npx clean-css-cli@5 -O1 -o layout/css/main.min.css layout/css/main.css
   npx terser@5 layout/js/scripts.js -c -m -o layout/js/scripts.min.js
   ```
   Use clean-css `-O1`. `-O2` restructures rules and can shift the cascade.
4. **Run Theme Check.** This is the same tool the directory runs. Install the
   [Theme Check](https://wordpress.org/plugins/theme-check/) plugin, activate the
   theme, and run it from Tools → Theme Check. **REQUIRED and WARNING must both be
   zero.** RECOMMENDED items are advisory — see "Known recommendations" below.

## Build

```bash
bin/build-release.sh
```

Produces `dist/illdy.zip`: a single top-level `illdy/` directory, which is what the
upload form expects. The script fails if any hidden file ends up in the build, since
the directory rejects those.

What is deliberately excluded, and why:

| Excluded | Reason |
|---|---|
| `node_modules/`, `Gruntfile.js`, `package*.json` | build tooling, not theme code |
| `bin/`, `dist/` | this script and its own output |
| `CLAUDE.md`, `.claude/` | working notes |
| `.git`, `.gitignore`, dotfiles | the directory rejects hidden files |
| `layout/scss/` | **not** the source of the shipped CSS — see below |
| `*.map` | source maps point at files that are not shipped |

`layout/scss/` has diverged from `layout/css/main.css`, which is the real stylesheet:
`.illdy-top` and every `:focus-within` rule exist only in the CSS. Shipping the SCSS
invites someone to recompile it over the live stylesheet and silently lose that work.
WordPress.org requires the *source* of minified files, and that requirement is met —
`layout/css/main.css` and `layout/js/*.js` are the unminified originals and they do
ship.

## Upload

1. Go to <https://wordpress.org/themes/upload/>.
2. Upload `dist/illdy.zip`.
3. The automated checks run immediately. A theme update with no new files usually
   passes without human review; anything flagged comes back by email.

Uploading a version that already exists is rejected, so bump `style.css` first.

## Git

```bash
git tag -a v2.2.0 -m "Illdy 2.2.0"
git push origin main --tags     # once a remote is configured
```

There is no remote configured in this working copy. To publish to GitHub:

```bash
git remote add origin git@github.com:ColorlibHQ/illdy.git
git push -u origin main --tags
gh release create v2.2.0 dist/illdy.zip --notes-file <(sed -n '/^### V 2.2.0/,/^### V 2.1.10/p' CHANGELOG.txt)
```

## Known recommendations

Theme Check reports six RECOMMENDED items on 2.2.0, all of them block-editor
features the theme does not implement:

- `register_block_pattern`, `register_block_style`
- `add_theme_support( 'wp-block-styles' )`, `'align-wide'`, `'responsive-embeds'`
- `add_theme_support( 'custom-background' )`

None block a release. They are left alone deliberately: `wp-block-styles`,
`align-wide` and `responsive-embeds` all change how existing post content renders, and
2.2.0 is a modernisation release whose whole guarantee is that nothing about the front
end changes. They are worth doing — as their own release, with the visual diff that
implies.

`custom-background` would collide with the theme's own per-section background options.

## What 2.2.0 verified

Recorded here so the next release knows what "no regression" was measured against, not
assumed:

- A database with **205 customised theme mods** was diffed before and after the
  upgrade: 0 lost, 0 added, 0 changed, and a byte-identical rendered front page.
- The theme boots with **zero PHP notices, warnings or deprecations** on
  WordPress 7.0.3 / PHP 8.5.6.
- Front page, Customizer, Widgets, About Illdy and the dashboard each report **0 JS
  errors and 0 failed requests**.
- Theme Check: **PASS, 0 REQUIRED, 0 WARNING**.
- The built zip was installed in place of the working copy and re-verified, so the
  artifact is what was tested, not a close relative of it.
