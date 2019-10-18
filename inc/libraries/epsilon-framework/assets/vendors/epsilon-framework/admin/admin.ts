declare var require: any;
declare var wpNavMenu: any;
declare var wp: any;
import * as $ from 'jquery';

import { EpsilonNotices } from './notices/notices';
import { EpsilonNavMenus } from './nav-menus/nav-menus';

jQuery( document ).ready( function() {
  let notices = new EpsilonNotices();
  notices.init();

  if ( typeof wpNavMenu !== 'undefined' ) {
    new EpsilonNavMenus( wpNavMenu );
  }
} );
