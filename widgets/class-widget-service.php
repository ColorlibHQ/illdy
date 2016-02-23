<?php
class Illdy_Widget_Service extends WP_Widget {

    /**
    * Register widget with WordPress.
    */
    function __construct() {
        parent::__construct( 'illdy_service', __( '[Illdy] - Service', 'illdy' ), array( 'description' => __( 'Add this widget in "Front page - Services Sidebar".', 'illdy' ), ) );
    }

    /**
    * Front-end display of widget.
    *
    * @see WP_Widget::widget()
    *
    * @param array $args     Widget arguments.
    * @param array $instance Saved values from database.
    */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $title = ( !empty( $instance['title'] ) ? esc_html( $instance['title'] ) : '' );
        $icon = ( !empty( $instance['icon'] ) ? esc_attr( $instance['icon'] ) : '' );
        $entry = ( !empty( $instance['entry'] ) ? esc_textarea( $instance['entry'] ) : '' );
        $color = ( !empty( $instance['color'] ) ? esc_attr( $instance['color'] ) : '' );

        $output = '';

        $output .= '<div class="service" data-service-color="'. $color .'">';
            $output .= '<div class="service-icon">';
                  $output .= '<i class="fa '. $icon .'"></i>';
            $output .= '</div><!--/.service-icon-->';
            $output .= '<div class="service-title">';
                  $output .= $title;
            $output .= '</div><!--/.service-title-->';
            $output .= '<div class="service-entry">';
                $output .= $entry;
            $output .= '</div><!--/.service-entry-->';
        $output .= '</div><!--/.service-->';

        echo $output;

        echo $args['after_widget'];
    }

    private function get_fontawesome_icons() {
        $icons = array(
            'fa-adjust' => 'fa-adjust',
            'fa-adn' => 'fa-adn',
            'fa-align-center' => 'fa-align-center',
            'fa-align-justify' => 'fa-align-justify',
            'fa-align-left' => 'fa-align-left',
            'fa-align-right' => 'fa-align-right',
            'fa-ambulance' => 'fa-ambulance',
            'fa-anchor' => 'fa-anchor',
            'fa-android' => 'fa-android',
            'fa-angellist' => 'fa-angellist',
            'fa-angle-double-down' => 'fa-angle-double-down',
            'fa-angle-double-left' => 'fa-angle-double-left',
            'fa-angle-double-right' => 'fa-angle-double-right',
            'fa-angle-double-up' => 'fa-angle-double-up',
            'fa-angle-down' => 'fa-angle-down',
            'fa-angle-left' => 'fa-angle-left',
            'fa-angle-right' => 'fa-angle-right',
            'fa-angle-up' => 'fa-angle-up',
            'fa-apple' => 'fa-apple',
            'fa-archive' => 'fa-archive',
            'fa-area-chart' => 'fa-area-chart',
            'fa-arrow-circle-down' => 'fa-arrow-circle-down',
            'fa-arrow-circle-left' => 'fa-arrow-circle-left',
            'fa-arrow-circle-o-down' => 'fa-arrow-circle-o-down',
            'fa-arrow-circle-o-left' => 'fa-arrow-circle-o-left',
            'fa-arrow-circle-o-right' => 'fa-arrow-circle-o-right',
            'fa-arrow-circle-o-up' => 'fa-arrow-circle-o-up',
            'fa-arrow-circle-right' => 'fa-arrow-circle-right',
            'fa-arrow-circle-up' => 'fa-arrow-circle-up',
            'fa-arrow-down' => 'fa-arrow-down',
            'fa-arrow-left' => 'fa-arrow-left',
            'fa-arrow-right' => 'fa-arrow-right',
            'fa-arrow-up' => 'fa-arrow-up',
            'fa-arrows' => 'fa-arrows',
            'fa-arrows-alt' => 'fa-arrows-alt',
            'fa-arrows-h' => 'fa-arrows-h',
            'fa-arrows-v' => 'fa-arrows-v',
            'fa-asterisk' => 'fa-asterisk',
            'fa-at' => 'fa-at',
            'fa-automobile(alias)' => 'fa-automobile(alias)',
            'fa-backward' => 'fa-backward',
            'fa-ban' => 'fa-ban',
            'fa-bank(alias)' => 'fa-bank(alias)',
            'fa-bar-chart' => 'fa-bar-chart',
            'fa-bar-chart-o(alias)' => 'fa-bar-chart-o(alias)',
            'fa-barcode' => 'fa-barcode',
            'fa-bars' => 'fa-bars',
            'fa-bed' => 'fa-bed',
            'fa-beer' => 'fa-beer',
            'fa-behance' => 'fa-behance',
            'fa-behance-square' => 'fa-behance-square',
            'fa-bell' => 'fa-bell',
            'fa-bell-o' => 'fa-bell-o',
            'fa-bell-slash' => 'fa-bell-slash',
            'fa-bell-slash-o' => 'fa-bell-slash-o',
            'fa-bicycle' => 'fa-bicycle',
            'fa-binoculars' => 'fa-binoculars',
            'fa-birthday-cake' => 'fa-birthday-cake',
            'fa-bitbucket' => 'fa-bitbucket',
            'fa-bitbucket-square' => 'fa-bitbucket-square',
            'fa-bitcoin(alias)' => 'fa-bitcoin(alias)',
            'fa-bold' => 'fa-bold',
            'fa-bolt' => 'fa-bolt',
            'fa-bomb' => 'fa-bomb',
            'fa-book' => 'fa-book',
            'fa-bookmark' => 'fa-bookmark',
            'fa-bookmark-o' => 'fa-bookmark-o',
            'fa-briefcase' => 'fa-briefcase',
            'fa-btc' => 'fa-btc',
            'fa-bug' => 'fa-bug',
            'fa-building' => 'fa-building',
            'fa-building-o' => 'fa-building-o',
            'fa-bullhorn' => 'fa-bullhorn',
            'fa-bullseye' => 'fa-bullseye',
            'fa-bus' => 'fa-bus',
            'fa-buysellads' => 'fa-buysellads',
            'fa-cab(alias)' => 'fa-cab(alias)',
            'fa-calculator' => 'fa-calculator',
            'fa-calendar' => 'fa-calendar',
            'fa-calendar-o' => 'fa-calendar-o',
            'fa-camera' => 'fa-camera',
            'fa-camera-retro' => 'fa-camera-retro',
            'fa-car' => 'fa-car',
            'fa-caret-down' => 'fa-caret-down',
            'fa-caret-left' => 'fa-caret-left',
            'fa-caret-right' => 'fa-caret-right',
            'fa-caret-square-o-down' => 'fa-caret-square-o-down',
            'fa-caret-square-o-left' => 'fa-caret-square-o-left',
            'fa-caret-square-o-right' => 'fa-caret-square-o-right',
            'fa-caret-square-o-up' => 'fa-caret-square-o-up',
            'fa-caret-up' => 'fa-caret-up',
            'fa-cart-arrow-down' => 'fa-cart-arrow-down',
            'fa-cart-plus' => 'fa-cart-plus',
            'fa-cc' => 'fa-cc',
            'fa-cc-amex' => 'fa-cc-amex',
            'fa-cc-discover' => 'fa-cc-discover',
            'fa-cc-mastercard' => 'fa-cc-mastercard',
            'fa-cc-paypal' => 'fa-cc-paypal',
            'fa-cc-stripe' => 'fa-cc-stripe',
            'fa-cc-visa' => 'fa-cc-visa',
            'fa-certificate' => 'fa-certificate',
            'fa-chain(alias)' => 'fa-chain(alias)',
            'fa-chain-broken' => 'fa-chain-broken',
            'fa-check' => 'fa-check',
            'fa-check-circle' => 'fa-check-circle',
            'fa-check-circle-o' => 'fa-check-circle-o',
            'fa-check-square' => 'fa-check-square',
            'fa-check-square-o' => 'fa-check-square-o',
            'fa-chevron-circle-down' => 'fa-chevron-circle-down',
            'fa-chevron-circle-left' => 'fa-chevron-circle-left',
            'fa-chevron-circle-right' => 'fa-chevron-circle-right',
            'fa-chevron-circle-up' => 'fa-chevron-circle-up',
            'fa-chevron-down' => 'fa-chevron-down',
            'fa-chevron-left' => 'fa-chevron-left',
            'fa-chevron-right' => 'fa-chevron-right',
            'fa-chevron-up' => 'fa-chevron-up',
            'fa-child' => 'fa-child',
            'fa-circle' => 'fa-circle',
            'fa-circle-o' => 'fa-circle-o',
            'fa-circle-o-notch' => 'fa-circle-o-notch',
            'fa-circle-thin' => 'fa-circle-thin',
            'fa-clipboard' => 'fa-clipboard',
            'fa-clock-o' => 'fa-clock-o',
            'fa-close(alias)' => 'fa-close(alias)',
            'fa-cloud' => 'fa-cloud',
            'fa-cloud-download' => 'fa-cloud-download',
            'fa-cloud-upload' => 'fa-cloud-upload',
            'fa-cny(alias)' => 'fa-cny(alias)',
            'fa-code' => 'fa-code',
            'fa-code-fork' => 'fa-code-fork',
            'fa-codepen' => 'fa-codepen',
            'fa-coffee' => 'fa-coffee',
            'fa-cog' => 'fa-cog',
            'fa-cogs' => 'fa-cogs',
            'fa-columns' => 'fa-columns',
            'fa-comment' => 'fa-comment',
            'fa-comment-o' => 'fa-comment-o',
            'fa-comments' => 'fa-comments',
            'fa-comments-o' => 'fa-comments-o',
            'fa-compass' => 'fa-compass',
            'fa-compress' => 'fa-compress',
            'fa-connectdevelop' => 'fa-connectdevelop',
            'fa-copy(alias)' => 'fa-copy(alias)',
            'fa-copyright' => 'fa-copyright',
            'fa-credit-card' => 'fa-credit-card',
            'fa-crop' => 'fa-crop',
            'fa-crosshairs' => 'fa-crosshairs',
            'fa-css3' => 'fa-css3',
            'fa-cube' => 'fa-cube',
            'fa-cubes' => 'fa-cubes',
            'fa-cut(alias)' => 'fa-cut(alias)',
            'fa-cutlery' => 'fa-cutlery',
            'fa-dashboard(alias)' => 'fa-dashboard(alias)',
            'fa-dashcube' => 'fa-dashcube',
            'fa-database' => 'fa-database',
            'fa-dedent(alias)' => 'fa-dedent(alias)',
            'fa-delicious' => 'fa-delicious',
            'fa-desktop' => 'fa-desktop',
            'fa-deviantart' => 'fa-deviantart',
            'fa-diamond' => 'fa-diamond',
            'fa-digg' => 'fa-digg',
            'fa-dollar(alias)' => 'fa-dollar(alias)',
            'fa-dot-circle-o' => 'fa-dot-circle-o',
            'fa-download' => 'fa-download',
            'fa-dribbble' => 'fa-dribbble',
            'fa-dropbox' => 'fa-dropbox',
            'fa-drupal' => 'fa-drupal',
            'fa-edit(alias)' => 'fa-edit(alias)',
            'fa-eject' => 'fa-eject',
            'fa-ellipsis-h' => 'fa-ellipsis-h',
            'fa-ellipsis-v' => 'fa-ellipsis-v',
            'fa-empire' => 'fa-empire',
            'fa-envelope' => 'fa-envelope',
            'fa-envelope-o' => 'fa-envelope-o',
            'fa-envelope-square' => 'fa-envelope-square',
            'fa-eraser' => 'fa-eraser',
            'fa-eur' => 'fa-eur',
            'fa-euro(alias)' => 'fa-euro(alias)',
            'fa-exchange' => 'fa-exchange',
            'fa-exclamation' => 'fa-exclamation',
            'fa-exclamation-circle' => 'fa-exclamation-circle',
            'fa-exclamation-triangle' => 'fa-exclamation-triangle',
            'fa-expand' => 'fa-expand',
            'fa-external-link' => 'fa-external-link',
            'fa-external-link-square' => 'fa-external-link-square',
            'fa-eye' => 'fa-eye',
            'fa-eye-slash' => 'fa-eye-slash',
            'fa-eyedropper' => 'fa-eyedropper',
            'fa-facebook' => 'fa-facebook',
            'fa-facebook-f(alias)' => 'fa-facebook-f(alias)',
            'fa-facebook-official' => 'fa-facebook-official',
            'fa-facebook-square' => 'fa-facebook-square',
            'fa-fast-backward' => 'fa-fast-backward',
            'fa-fast-forward' => 'fa-fast-forward',
            'fa-fax' => 'fa-fax',
            'fa-female' => 'fa-female',
            'fa-fighter-jet' => 'fa-fighter-jet',
            'fa-file' => 'fa-file',
            'fa-file-archive-o' => 'fa-file-archive-o',
            'fa-file-audio-o' => 'fa-file-audio-o',
            'fa-file-code-o' => 'fa-file-code-o',
            'fa-file-excel-o' => 'fa-file-excel-o',
            'fa-file-image-o' => 'fa-file-image-o',
            'fa-file-movie-o(alias)' => 'fa-file-movie-o(alias)',
            'fa-file-o' => 'fa-file-o',
            'fa-file-pdf-o' => 'fa-file-pdf-o',
            'fa-file-photo-o(alias)' => 'fa-file-photo-o(alias)',
            'fa-file-picture-o(alias)' => 'fa-file-picture-o(alias)',
            'fa-file-powerpoint-o' => 'fa-file-powerpoint-o',
            'fa-file-sound-o(alias)' => 'fa-file-sound-o(alias)',
            'fa-file-text' => 'fa-file-text',
            'fa-file-text-o' => 'fa-file-text-o',
            'fa-file-video-o' => 'fa-file-video-o',
            'fa-file-word-o' => 'fa-file-word-o',
            'fa-file-zip-o(alias)' => 'fa-file-zip-o(alias)',
            'fa-files-o' => 'fa-files-o',
            'fa-film' => 'fa-film',
            'fa-filter' => 'fa-filter',
            'fa-fire' => 'fa-fire',
            'fa-fire-extinguisher' => 'fa-fire-extinguisher',
            'fa-flag' => 'fa-flag',
            'fa-flag-checkered' => 'fa-flag-checkered',
            'fa-flag-o' => 'fa-flag-o',
            'fa-flash(alias)' => 'fa-flash(alias)',
            'fa-flask' => 'fa-flask',
            'fa-flickr' => 'fa-flickr',
            'fa-floppy-o' => 'fa-floppy-o',
            'fa-folder' => 'fa-folder',
            'fa-folder-o' => 'fa-folder-o',
            'fa-folder-open' => 'fa-folder-open',
            'fa-folder-open-o' => 'fa-folder-open-o',
            'fa-font' => 'fa-font',
            'fa-forumbee' => 'fa-forumbee',
            'fa-forward' => 'fa-forward',
            'fa-foursquare' => 'fa-foursquare',
            'fa-frown-o' => 'fa-frown-o',
            'fa-futbol-o' => 'fa-futbol-o',
            'fa-gamepad' => 'fa-gamepad',
            'fa-gavel' => 'fa-gavel',
            'fa-gbp' => 'fa-gbp',
            'fa-ge(alias)' => 'fa-ge(alias)',
            'fa-gear(alias)' => 'fa-gear(alias)',
            'fa-gears(alias)' => 'fa-gears(alias)',
            'fa-genderless(alias)' => 'fa-genderless(alias)',
            'fa-gift' => 'fa-gift',
            'fa-git' => 'fa-git',
            'fa-git-square' => 'fa-git-square',
            'fa-github' => 'fa-github',
            'fa-github-alt' => 'fa-github-alt',
            'fa-github-square' => 'fa-github-square',
            'fa-gittip(alias)' => 'fa-gittip(alias)',
            'fa-glass' => 'fa-glass',
            'fa-globe' => 'fa-globe',
            'fa-google' => 'fa-google',
            'fa-google-plus' => 'fa-google-plus',
            'fa-google-plus-square' => 'fa-google-plus-square',
            'fa-google-wallet' => 'fa-google-wallet',
            'fa-graduation-cap' => 'fa-graduation-cap',
            'fa-gratipay' => 'fa-gratipay',
            'fa-group(alias)' => 'fa-group(alias)',
            'fa-h-square' => 'fa-h-square',
            'fa-hacker-news' => 'fa-hacker-news',
            'fa-hand-o-down' => 'fa-hand-o-down',
            'fa-hand-o-left' => 'fa-hand-o-left',
            'fa-hand-o-right' => 'fa-hand-o-right',
            'fa-hand-o-up' => 'fa-hand-o-up',
            'fa-hdd-o' => 'fa-hdd-o',
            'fa-header' => 'fa-header',
            'fa-headphones' => 'fa-headphones',
            'fa-heart' => 'fa-heart',
            'fa-heart-o' => 'fa-heart-o',
            'fa-heartbeat' => 'fa-heartbeat',
            'fa-history' => 'fa-history',
            'fa-home' => 'fa-home',
            'fa-hospital-o' => 'fa-hospital-o',
            'fa-hotel(alias)' => 'fa-hotel(alias)',
            'fa-html5' => 'fa-html5',
            'fa-ils' => 'fa-ils',
            'fa-image(alias)' => 'fa-image(alias)',
            'fa-inbox' => 'fa-inbox',
            'fa-indent' => 'fa-indent',
            'fa-info' => 'fa-info',
            'fa-info-circle' => 'fa-info-circle',
            'fa-inr' => 'fa-inr',
            'fa-instagram' => 'fa-instagram',
            'fa-institution(alias)' => 'fa-institution(alias)',
            'fa-ioxhost' => 'fa-ioxhost',
            'fa-italic' => 'fa-italic',
            'fa-joomla' => 'fa-joomla',
            'fa-jpy' => 'fa-jpy',
            'fa-jsfiddle' => 'fa-jsfiddle',
            'fa-key' => 'fa-key',
            'fa-keyboard-o' => 'fa-keyboard-o',
            'fa-krw' => 'fa-krw',
            'fa-language' => 'fa-language',
            'fa-laptop' => 'fa-laptop',
            'fa-lastfm' => 'fa-lastfm',
            'fa-lastfm-square' => 'fa-lastfm-square',
            'fa-leaf' => 'fa-leaf',
            'fa-leanpub' => 'fa-leanpub',
            'fa-legal(alias)' => 'fa-legal(alias)',
            'fa-lemon-o' => 'fa-lemon-o',
            'fa-level-down' => 'fa-level-down',
            'fa-level-up' => 'fa-level-up',
            'fa-life-bouy(alias)' => 'fa-life-bouy(alias)',
            'fa-life-buoy(alias)' => 'fa-life-buoy(alias)',
            'fa-life-ring' => 'fa-life-ring',
            'fa-life-saver(alias)' => 'fa-life-saver(alias)',
            'fa-lightbulb-o' => 'fa-lightbulb-o',
            'fa-line-chart' => 'fa-line-chart',
            'fa-link' => 'fa-link',
            'fa-linkedin' => 'fa-linkedin',
            'fa-linkedin-square' => 'fa-linkedin-square',
            'fa-linux' => 'fa-linux',
            'fa-list' => 'fa-list',
            'fa-list-alt' => 'fa-list-alt',
            'fa-list-ol' => 'fa-list-ol',
            'fa-list-ul' => 'fa-list-ul',
            'fa-location-arrow' => 'fa-location-arrow',
            'fa-lock' => 'fa-lock',
            'fa-long-arrow-down' => 'fa-long-arrow-down',
            'fa-long-arrow-left' => 'fa-long-arrow-left',
            'fa-long-arrow-right' => 'fa-long-arrow-right',
            'fa-long-arrow-up' => 'fa-long-arrow-up',
            'fa-magic' => 'fa-magic',
            'fa-magnet' => 'fa-magnet',
            'fa-mail-forward(alias)' => 'fa-mail-forward(alias)',
            'fa-mail-reply(alias)' => 'fa-mail-reply(alias)',
            'fa-mail-reply-all(alias)' => 'fa-mail-reply-all(alias)',
            'fa-male' => 'fa-male',
            'fa-map-marker' => 'fa-map-marker',
            'fa-mars' => 'fa-mars',
            'fa-mars-double' => 'fa-mars-double',
            'fa-mars-stroke' => 'fa-mars-stroke',
            'fa-mars-stroke-h' => 'fa-mars-stroke-h',
            'fa-mars-stroke-v' => 'fa-mars-stroke-v',
            'fa-maxcdn' => 'fa-maxcdn',
            'fa-meanpath' => 'fa-meanpath',
            'fa-medium' => 'fa-medium',
            'fa-medkit' => 'fa-medkit',
            'fa-meh-o' => 'fa-meh-o',
            'fa-mercury' => 'fa-mercury',
            'fa-microphone' => 'fa-microphone',
            'fa-microphone-slash' => 'fa-microphone-slash',
            'fa-minus' => 'fa-minus',
            'fa-minus-circle' => 'fa-minus-circle',
            'fa-minus-square' => 'fa-minus-square',
            'fa-minus-square-o' => 'fa-minus-square-o',
            'fa-mobile' => 'fa-mobile',
            'fa-mobile-phone(alias)' => 'fa-mobile-phone(alias)',
            'fa-money' => 'fa-money',
            'fa-moon-o' => 'fa-moon-o',
            'fa-mortar-board(alias)' => 'fa-mortar-board(alias)',
            'fa-motorcycle' => 'fa-motorcycle',
            'fa-music' => 'fa-music',
            'fa-navicon(alias)' => 'fa-navicon(alias)',
            'fa-neuter' => 'fa-neuter',
            'fa-newspaper-o' => 'fa-newspaper-o',
            'fa-openid' => 'fa-openid',
            'fa-outdent' => 'fa-outdent',
            'fa-pagelines' => 'fa-pagelines',
            'fa-paint-brush' => 'fa-paint-brush',
            'fa-paper-plane' => 'fa-paper-plane',
            'fa-paper-plane-o' => 'fa-paper-plane-o',
            'fa-paperclip' => 'fa-paperclip',
            'fa-paragraph' => 'fa-paragraph',
            'fa-paste(alias)' => 'fa-paste(alias)',
            'fa-pause' => 'fa-pause',
            'fa-paw' => 'fa-paw',
            'fa-paypal' => 'fa-paypal',
            'fa-pencil' => 'fa-pencil',
            'fa-pencil-square' => 'fa-pencil-square',
            'fa-pencil-square-o' => 'fa-pencil-square-o',
            'fa-phone' => 'fa-phone',
            'fa-phone-square' => 'fa-phone-square',
            'fa-photo(alias)' => 'fa-photo(alias)',
            'fa-picture-o' => 'fa-picture-o',
            'fa-pie-chart' => 'fa-pie-chart',
            'fa-pied-piper' => 'fa-pied-piper',
            'fa-pied-piper-alt' => 'fa-pied-piper-alt',
            'fa-pinterest' => 'fa-pinterest',
            'fa-pinterest-p' => 'fa-pinterest-p',
            'fa-pinterest-square' => 'fa-pinterest-square',
            'fa-plane' => 'fa-plane',
            'fa-play' => 'fa-play',
            'fa-play-circle' => 'fa-play-circle',
            'fa-play-circle-o' => 'fa-play-circle-o',
            'fa-plug' => 'fa-plug',
            'fa-plus' => 'fa-plus',
            'fa-plus-circle' => 'fa-plus-circle',
            'fa-plus-square' => 'fa-plus-square',
            'fa-plus-square-o' => 'fa-plus-square-o',
            'fa-power-off' => 'fa-power-off',
            'fa-print' => 'fa-print',
            'fa-puzzle-piece' => 'fa-puzzle-piece',
            'fa-qq' => 'fa-qq',
            'fa-qrcode' => 'fa-qrcode',
            'fa-question' => 'fa-question',
            'fa-question-circle' => 'fa-question-circle',
            'fa-quote-left' => 'fa-quote-left',
            'fa-quote-right' => 'fa-quote-right',
            'fa-ra(alias)' => 'fa-ra(alias)',
            'fa-random' => 'fa-random',
            'fa-rebel' => 'fa-rebel',
            'fa-recycle' => 'fa-recycle',
            'fa-reddit' => 'fa-reddit',
            'fa-reddit-square' => 'fa-reddit-square',
            'fa-refresh' => 'fa-refresh',
            'fa-remove(alias)' => 'fa-remove(alias)',
            'fa-renren' => 'fa-renren',
            'fa-reorder(alias)' => 'fa-reorder(alias)',
            'fa-repeat' => 'fa-repeat',
            'fa-reply' => 'fa-reply',
            'fa-reply-all' => 'fa-reply-all',
            'fa-retweet' => 'fa-retweet',
            'fa-rmb(alias)' => 'fa-rmb(alias)',
            'fa-road' => 'fa-road',
            'fa-rocket' => 'fa-rocket',
            'fa-rotate-left(alias)' => 'fa-rotate-left(alias)',
            'fa-rotate-right(alias)' => 'fa-rotate-right(alias)',
            'fa-rouble(alias)' => 'fa-rouble(alias)',
            'fa-rss' => 'fa-rss',
            'fa-rss-square' => 'fa-rss-square',
            'fa-rub' => 'fa-rub',
            'fa-ruble(alias)' => 'fa-ruble(alias)',
            'fa-rupee(alias)' => 'fa-rupee(alias)',
            'fa-save(alias)' => 'fa-save(alias)',
            'fa-scissors' => 'fa-scissors',
            'fa-search' => 'fa-search',
            'fa-search-minus' => 'fa-search-minus',
            'fa-search-plus' => 'fa-search-plus',
            'fa-sellsy' => 'fa-sellsy',
            'fa-send(alias)' => 'fa-send(alias)',
            'fa-send-o(alias)' => 'fa-send-o(alias)',
            'fa-server' => 'fa-server',
            'fa-share' => 'fa-share',
            'fa-share-alt' => 'fa-share-alt',
            'fa-share-alt-square' => 'fa-share-alt-square',
            'fa-share-square' => 'fa-share-square',
            'fa-share-square-o' => 'fa-share-square-o',
            'fa-shekel(alias)' => 'fa-shekel(alias)',
            'fa-sheqel(alias)' => 'fa-sheqel(alias)',
            'fa-shield' => 'fa-shield',
            'fa-ship' => 'fa-ship',
            'fa-shirtsinbulk' => 'fa-shirtsinbulk',
            'fa-shopping-cart' => 'fa-shopping-cart',
            'fa-sign-in' => 'fa-sign-in',
            'fa-sign-out' => 'fa-sign-out',
            'fa-signal' => 'fa-signal',
            'fa-simplybuilt' => 'fa-simplybuilt',
            'fa-sitemap' => 'fa-sitemap',
            'fa-skyatlas' => 'fa-skyatlas',
            'fa-skype' => 'fa-skype',
            'fa-slack' => 'fa-slack',
            'fa-sliders' => 'fa-sliders',
            'fa-slideshare' => 'fa-slideshare',
            'fa-smile-o' => 'fa-smile-o',
            'fa-soccer-ball-o(alias)' => 'fa-soccer-ball-o(alias)',
            'fa-sort' => 'fa-sort',
            'fa-sort-alpha-asc' => 'fa-sort-alpha-asc',
            'fa-sort-alpha-desc' => 'fa-sort-alpha-desc',
            'fa-sort-amount-asc' => 'fa-sort-amount-asc',
            'fa-sort-amount-desc' => 'fa-sort-amount-desc',
            'fa-sort-asc' => 'fa-sort-asc',
            'fa-sort-desc' => 'fa-sort-desc',
            'fa-sort-down(alias)' => 'fa-sort-down(alias)',
            'fa-sort-numeric-asc' => 'fa-sort-numeric-asc',
            'fa-sort-numeric-desc' => 'fa-sort-numeric-desc',
            'fa-sort-up(alias)' => 'fa-sort-up(alias)',
            'fa-soundcloud' => 'fa-soundcloud',
            'fa-space-shuttle' => 'fa-space-shuttle',
            'fa-spinner' => 'fa-spinner',
            'fa-spoon' => 'fa-spoon',
            'fa-spotify' => 'fa-spotify',
            'fa-square' => 'fa-square',
            'fa-square-o' => 'fa-square-o',
            'fa-stack-exchange' => 'fa-stack-exchange',
            'fa-stack-overflow' => 'fa-stack-overflow',
            'fa-star' => 'fa-star',
            'fa-star-half' => 'fa-star-half',
            'fa-star-half-empty(alias)' => 'fa-star-half-empty(alias)',
            'fa-star-half-full(alias)' => 'fa-star-half-full(alias)',
            'fa-star-half-o' => 'fa-star-half-o',
            'fa-star-o' => 'fa-star-o',
            'fa-steam' => 'fa-steam',
            'fa-steam-square' => 'fa-steam-square',
            'fa-step-backward' => 'fa-step-backward',
            'fa-step-forward' => 'fa-step-forward',
            'fa-stethoscope' => 'fa-stethoscope',
            'fa-stop' => 'fa-stop',
            'fa-street-view' => 'fa-street-view',
            'fa-strikethrough' => 'fa-strikethrough',
            'fa-stumbleupon' => 'fa-stumbleupon',
            'fa-stumbleupon-circle' => 'fa-stumbleupon-circle',
            'fa-subscript' => 'fa-subscript',
            'fa-subway' => 'fa-subway',
            'fa-suitcase' => 'fa-suitcase',
            'fa-sun-o' => 'fa-sun-o',
            'fa-superscript' => 'fa-superscript',
            'fa-support(alias)' => 'fa-support(alias)',
            'fa-table' => 'fa-table',
            'fa-tablet' => 'fa-tablet',
            'fa-tachometer' => 'fa-tachometer',
            'fa-tag' => 'fa-tag',
            'fa-tags' => 'fa-tags',
            'fa-tasks' => 'fa-tasks',
            'fa-taxi' => 'fa-taxi',
            'fa-tencent-weibo' => 'fa-tencent-weibo',
            'fa-terminal' => 'fa-terminal',
            'fa-text-height' => 'fa-text-height',
            'fa-text-width' => 'fa-text-width',
            'fa-th' => 'fa-th',
            'fa-th-large' => 'fa-th-large',
            'fa-th-list' => 'fa-th-list',
            'fa-thumb-tack' => 'fa-thumb-tack',
            'fa-thumbs-down' => 'fa-thumbs-down',
            'fa-thumbs-o-down' => 'fa-thumbs-o-down',
            'fa-thumbs-o-up' => 'fa-thumbs-o-up',
            'fa-thumbs-up' => 'fa-thumbs-up',
            'fa-ticket' => 'fa-ticket',
            'fa-times' => 'fa-times',
            'fa-times-circle' => 'fa-times-circle',
            'fa-times-circle-o' => 'fa-times-circle-o',
            'fa-tint' => 'fa-tint',
            'fa-toggle-down(alias)' => 'fa-toggle-down(alias)',
            'fa-toggle-left(alias)' => 'fa-toggle-left(alias)',
            'fa-toggle-off' => 'fa-toggle-off',
            'fa-toggle-on' => 'fa-toggle-on',
            'fa-toggle-right(alias)' => 'fa-toggle-right(alias)',
            'fa-toggle-up(alias)' => 'fa-toggle-up(alias)',
            'fa-train' => 'fa-train',
            'fa-transgender' => 'fa-transgender',
            'fa-transgender-alt' => 'fa-transgender-alt',
            'fa-trash' => 'fa-trash',
            'fa-trash-o' => 'fa-trash-o',
            'fa-tree' => 'fa-tree',
            'fa-trello' => 'fa-trello',
            'fa-trophy' => 'fa-trophy',
            'fa-truck' => 'fa-truck',
            'fa-try' => 'fa-try',
            'fa-tty' => 'fa-tty',
            'fa-tumblr' => 'fa-tumblr',
            'fa-tumblr-square' => 'fa-tumblr-square',
            'fa-turkish-lira(alias)' => 'fa-turkish-lira(alias)',
            'fa-twitch' => 'fa-twitch',
            'fa-twitter' => 'fa-twitter',
            'fa-twitter-square' => 'fa-twitter-square',
            'fa-umbrella' => 'fa-umbrella',
            'fa-underline' => 'fa-underline',
            'fa-undo' => 'fa-undo',
            'fa-university' => 'fa-university',
            'fa-unlink(alias)' => 'fa-unlink(alias)',
            'fa-unlock' => 'fa-unlock',
            'fa-unlock-alt' => 'fa-unlock-alt',
            'fa-unsorted(alias)' => 'fa-unsorted(alias)',
            'fa-upload' => 'fa-upload',
            'fa-usd' => 'fa-usd',
            'fa-user' => 'fa-user',
            'fa-user-md' => 'fa-user-md',
            'fa-user-plus' => 'fa-user-plus',
            'fa-user-secret' => 'fa-user-secret',
            'fa-user-times' => 'fa-user-times',
            'fa-users' => 'fa-users',
            'fa-venus' => 'fa-venus',
            'fa-venus-double' => 'fa-venus-double',
            'fa-venus-mars' => 'fa-venus-mars',
            'fa-viacoin' => 'fa-viacoin',
            'fa-video-camera' => 'fa-video-camera',
            'fa-vimeo-square' => 'fa-vimeo-square',
            'fa-vine' => 'fa-vine',
            'fa-vk' => 'fa-vk',
            'fa-volume-down' => 'fa-volume-down',
            'fa-volume-off' => 'fa-volume-off',
            'fa-volume-up' => 'fa-volume-up',
            'fa-warning(alias)' => 'fa-warning(alias)',
            'fa-wechat(alias)' => 'fa-wechat(alias)',
            'fa-weibo' => 'fa-weibo',
            'fa-weixin' => 'fa-weixin',
            'fa-whatsapp' => 'fa-whatsapp',
            'fa-wheelchair' => 'fa-wheelchair',
            'fa-wifi' => 'fa-wifi',
            'fa-windows' => 'fa-windows',
            'fa-won(alias)' => 'fa-won(alias)',
            'fa-wordpress' => 'fa-wordpress',
            'fa-wrench' => 'fa-wrench',
            'fa-xing' => 'fa-xing',
            'fa-xing-square' => 'fa-xing-square',
            'fa-yahoo' => 'fa-yahoo',
            'fa-yelp' => 'fa-yelp',
            'fa-yen(alias)' => 'fa-yen(alias)',
            'fa-youtube' => 'fa-youtube',
            'fa-youtube-play' => 'fa-youtube-play',
            'fa-youtube-square' => 'fa-youtube-square'
        );

        foreach( $icons as $icon ) {
              $all_icons[$icon] = $icon;
        }

        return $all_icons;
    }

    /**
    * Back-end widget form.
    *
    * @see WP_Widget::form()
    *
    * @param array $instance Previously saved values from database.
    */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : __( '[Illdy] - Skill', 'illdy' );
        $icon = !empty( $instance['icon'] ) ? sanitize_text_field( $instance['icon'] ) : '';
        $entry = !empty( $instance['entry'] ) ? esc_textarea( $instance['entry'] ) : '';
        $color = !empty( $instance['color'] ) ? esc_attr( $instance['color'] ) : '';

        $get_fontawesome_icons = $this->get_fontawesome_icons();
        ?>

        <script type="text/javascript">
              //<![CDATA[
              jQuery(document).ready(function() {
                  jQuery(' .cw-color-picker' ).each(function(){
                      var $this = jQuery(this), id = $this.attr('rel');
                      $this.farbtastic('#' + id);
                  });
              });
              //]]>   
        </script>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'icon' ); ?>"><?php _e( 'Icon:', 'illdy' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>">
                <option value="all-font-awesome-icons"><?php _e( 'All Font Awesome Icons', 'illdy' ); ?></option>
                <?php foreach( $get_fontawesome_icons as $key => $get_fontawesome_icon ): ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $icon, $key ); ?>><?php echo esc_html( $get_fontawesome_icon ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'entry' ); ?>"><?php _e( 'Entry:', 'illdy' ); ?></label>
            <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'entry' ); ?>" name="<?php echo $this->get_field_name( 'entry' ); ?>"><?php echo esc_textarea( $entry ); ?></textarea></p>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php _e( 'Color:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text" value="<?php if( $color ): echo esc_attr( $color ); else: echo '#000000'; endif; ?>" />
            <div class="cw-color-picker" rel="<?php echo $this->get_field_id( 'color' ); ?>"></div>
        </p>
    <?php 
    }

    /**
    * Sanitize widget form values as they are saved.
    *
    * @see WP_Widget::update()
    *
    * @param array $new_instance Values just sent to be saved.
    * @param array $old_instance Previously saved values from database.
    *
    * @return array Updated safe values to be saved.
    */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? esc_html( $new_instance['title'] ) : '';
        $instance['icon'] = ( !empty( $new_instance['icon'] ) ? sanitize_text_field( $new_instance['icon'] ) : '' );
        $instance['entry'] = ( !empty( $new_instance['entry'] ) ? esc_textarea( $new_instance['entry'] ) : '' );
        $instance['color'] = ( !empty( $new_instance['color'] ) ? esc_html( $new_instance['color'] ) : '' );

        return $instance;
    }

}

add_action( 'widgets_init', 'illdy_register_widget_service' );
function illdy_register_widget_service () {
    register_widget( 'Illdy_Widget_Service' );
}

add_action( 'admin_print_scripts-widgets.php', 'illdy_enqueue_script_farbtastic_service' );
function illdy_enqueue_script_farbtastic_service() {
    wp_enqueue_script( 'farbtastic' );
}

add_action( 'admin_print_styles-widgets.php', 'illd_enqueue_style_farbtastic_service' );
function illd_enqueue_style_farbtastic_service() {
    wp_enqueue_style( 'farbtastic' );
}