=== Illdy ===

Contributors: Colorlib
Tags: blog, entertainment, portfolio, custom-header, custom-logo, custom-menu, featured-images, footer-widgets, threaded-comments, translation-ready, theme-options

Requires at least: 5.8
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 2.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Illdy is a free premium one page WordPress theme.

== Installation ==
	
1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

= License =
Illdy WordPress theme, Copyright (C) 2015 Colorlib.com
Illdy WordPress theme is licensed under the GNU General Public License v2 or later,
matching the License header in style.css.

Unless otherwise specified, all the theme files, scripts and images are licensed under GNU General Public License.
The exceptions to this license are as follows:

* Bootstrap v3.3.6 (https://getbootstrap.com):
    Copyright 2011-2014 Twitter, Inc.
    Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)

* Images:
	All images are from Pxhere(	https://pxhere.com/	) and Stocksnap( https://stocksnap.io	)
	License under Creative Commons Zero.


	https://pxhere.com/en/photo/146431


	Sources for images used:
		https://pxhere.com/en/photo/775198
        https://stocksnap.io/photo/coffee-latte-KSXYWXNBTA
        https://pxhere.com/en/photo/1364696
        https://pxhere.com/en/photo/147868
        https://pxhere.com/en/photo/730845
        https://pxhere.com/en/photo/722541
        https://pxhere.com/en/photo/722807
        https://pxhere.com/en/photo/693860
        https://pxhere.com/en/photo/1067952
        https://stocksnap.io/photo/shirt-tshirt-PLFB4I53U4
        https://pxhere.com/en/photo/667247
        https://pxhere.com/en/photo/1587291
        https://pxhere.com/en/photo/956553
        https://pxhere.com/en/photo/1258788
        https://pxhere.com/en/photo/1260525
        https://pxhere.com/en/photo/1238378
        https://pxhere.com/en/photo/1260525


* Font Awesome:
	License: SIL OFL 1.1
	URL: http://scripts.sil.org/OFL

* Google Fonts:
	Source Sans Pro (https://www.google.com/fonts/specimen/Source+Sans+Pro)
	License under SIL Open Font License, 1.1
	Copyright © Paul D. Hunt (https://plus.google.com/108888178732927400671/about)

* owl-carousel.js (http://www.owlcarousel.owlgraphic.com/):
	Copyright 2013 Bartosz Wojciechowski
	License under The MIT License (MIT)

* count-to.js (https://github.com/mhuggins/jquery-countTo):
	Copyright Matt Huggins
	License under MIT license.

* jquery.visible.js (http://teamdf.com/jquery-plugins/license/):
	Copyright 2012 Digital Fusion, Sam Sehnert
	Licensed under the MIT license.

* Sticky Plugin v1.0.4 for jQuery (http://stickyjs.com/):
	Copyright Anthony Garand
	Licensed under the MIT license.

* parallax.js v1.4.2 (http://pixelcog.github.io/parallax.js/):
	Copyright 2016 PixelCog, Inc.
	Licensed under the MIT license (https://github.com/pixelcog/parallax.js/blob/master/LICENSE)

* Pace (https://github.com/CodeByZach/pace):
	Copyright HubSpot, Inc.
	Licensed under the MIT license.

* fancyBox (http://fancyapps.com/fancybox/):
	Copyright 2018 fancyApps
	Licensed under GPLv3 for open source use.

== Changelog ==

= 2.2.0 =
Modernisation release for WordPress 7 / PHP 8.5. See CHANGELOG.txt for the full
list; the headlines are:

* Boots with zero PHP notices, warnings or deprecations on WordPress 7.0 / PHP 8.5,
  where the previous release emitted six.
* Removed the vendored Epsilon Framework entirely — 2.5 MB and 8,644 lines of
  third-party PHP replaced by core WordPress APIs and a small set of theme-owned
  Customizer controls. Every setting keeps its existing name, so no customisation
  is lost on update.
* Removed Bootstrap 3's JavaScript, which was never initialised by any template and
  carries CVE-2016-10735, CVE-2018-14041, CVE-2018-14042 and CVE-2019-8331.
* Fixed an unauthenticated AJAX endpoint that wrote unvalidated POST data into a
  theme mod, and 13 calls to an undefined function that made every Customizer
  selective refresh a fatal error.
* Rebuilt the About Illdy screen on core admin markup, with Getting Started,
  Recommended Plugins and Support tabs.
* Accessibility: the search form has a real label, and its icon-only submit button
  has an accessible name.
* Performance: front-page-only libraries load only where they are used, assets are
  minified and versioned, and Google Fonts are requested with display=swap.

= 2.1.10 =
See CHANGELOG.txt.
