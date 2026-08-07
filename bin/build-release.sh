#!/usr/bin/env bash
#
# Builds the WordPress.org upload zip for the Illdy theme.
#
# Produces dist/illdy.zip containing a single top-level illdy/ directory, which is
# what the theme upload form expects.
#
# Usage:  bin/build-release.sh [output-dir]
#
set -euo pipefail

THEME_SLUG="illdy"
ROOT="$( cd "$( dirname "${BASH_SOURCE[0]}" )/.." && pwd )"
OUT="${1:-$ROOT/dist}"
STAGE="$( mktemp -d )"
trap 'rm -rf "$STAGE"' EXIT

VERSION="$( sed -n 's/^Version:[[:space:]]*//p' "$ROOT/style.css" | head -1 | tr -d '\r' )"

if [ -z "$VERSION" ]; then
	echo "Could not read Version from style.css" >&2
	exit 1
fi

echo "Building $THEME_SLUG $VERSION"

mkdir -p "$OUT" "$STAGE/$THEME_SLUG"

# What ships. Everything not listed here is theme source that WordPress.org expects
# to be present, including the unminified CSS and JS behind every .min file.
#
#   .git, .gitignore   version control
#   node_modules       build-time only
#   .sass-cache        build artefact
#   Gruntfile.js       build tooling
#   package*.json      build tooling
#   CLAUDE.md, .claude working notes, not part of the theme
#   bin/               this script
#   dist/              previous builds
#   layout/scss        NOT the source of the shipped CSS. layout/css/main.css is, and
#                      the SCSS has diverged from it; shipping it invites someone to
#                      recompile over the real stylesheet. See CLAUDE.md.
#   *.map              source maps reference files that are not shipped
#   .DS_Store          macOS noise
rsync -a \
	--exclude '.git' \
	--exclude '.gitignore' \
	--exclude '.github' \
	--exclude 'node_modules' \
	--exclude '.sass-cache' \
	--exclude 'Gruntfile.js' \
	--exclude 'package.json' \
	--exclude 'package-lock.json' \
	--exclude 'CLAUDE.md' \
	--exclude '.claude' \
	--exclude 'bin' \
	--exclude 'dist' \
	--exclude 'layout/scss' \
	--exclude '*.map' \
	--exclude '.DS_Store' \
	"$ROOT/" "$STAGE/$THEME_SLUG/"

# Refuse to ship anything hidden: WordPress.org flags dotfiles.
if find "$STAGE/$THEME_SLUG" -name '.*' -not -name '.' | grep -q .; then
	echo "Hidden files present in the build:" >&2
	find "$STAGE/$THEME_SLUG" -name '.*' -not -name '.' >&2
	exit 1
fi

ZIP="$OUT/$THEME_SLUG.zip"
rm -f "$ZIP"
( cd "$STAGE" && zip -rq "$ZIP" "$THEME_SLUG" -x '*.DS_Store' )

echo
echo "  $ZIP"
echo "  $( du -h "$ZIP" | cut -f1 )  $( unzip -l "$ZIP" | tail -1 | awk '{print $2}' ) files"
echo
echo "Upload at https://wordpress.org/themes/upload/"
