declare var require: any, EpsilonWPUrls: any, wp: any, _: any;

/**
 * Epsilon Section Focus
 */
export class EpsilonSectionFocus {

  /**
   * Class constructor
   */
  public constructor() {
    const self = this;
    wp.customize.preview.bind( 'epsilon-section-focused', _.debounce( function( object: { index: number, closed: boolean } = { index: 0, closed: true } ) {
      if ( object.closed ) {
        return;
      }

      self.scrollTo( object.index );
    }, 300 ) );
  }

  /**
   * Scrolls into view
   * @param {number} index
   */
  public scrollTo( index: number = 0 ) {
    let selector = $( '[data-section="' + index + '"]' ),
        distance;

    distance = this.calculateOffsets( selector );

    $( 'html, body' ).animate( {
      scrollTop: distance
    }, 500 );
  }

  /**
   * Returns a number ( distance from top to div )
   * @param {JQuery} selector
   * @returns {number}
   */
  public calculateOffsets( selector: JQuery ) {
    let offset = selector.offset();

    if ( typeof offset !== 'undefined' && offset.hasOwnProperty( 'top' ) ) {
      return offset.top;
    }

    return 0;
  }
}
