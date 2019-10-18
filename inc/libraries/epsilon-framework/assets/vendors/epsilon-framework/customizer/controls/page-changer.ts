/**
 * Epsilon Page Changer
 */
export class EpsilonPageChanger {
  /**
   *
   */
  public control: { container: JQuery, params: { value: number, id: string }, pages: Array<Array<{}>> };

  /**
   * Basic Constructor
   *
   * @param control
   */
  public constructor( control: { container: JQuery, params: { value: number, id: string }, pages: Array<Array<{}>> } ) {
    this.control = control;

    this.startSelectize();
    this.handleEvents();
  }

  /**
   * Initiate the selectize library
   */
  public startSelectize() {
    /**
     * Instantiate the selectize javascript plugin
     * and the input type number
     */
    try {
      this.control.container.find( 'select' ).selectize();
    }
    catch ( err ) {
      /**
       * In case the selectize plugin is not loaded, raise an error
       */
      console.warn( 'selectize not yet loaded' );
    }
  }

  /**
   * Handle menu change
   */
  public handleEvents() {
    this.control.container.on( 'change', 'select', ( event: JQueryEventConstructor ) => {
      wp.customize.previewer.previewUrl.set( jQuery( event.target ).val() );
    } );
  }
}
