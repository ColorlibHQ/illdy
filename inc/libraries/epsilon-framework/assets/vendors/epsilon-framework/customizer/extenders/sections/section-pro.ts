declare var wp: any;
/**
 * Pro Section Constructor
 */
wp.customize.sectionConstructor[ 'epsilon-section-pro' ] = wp.customize.Section.extend( {
  attachEvents() {
  },
  isContextuallyActive() {
    return true;
  }
} );
