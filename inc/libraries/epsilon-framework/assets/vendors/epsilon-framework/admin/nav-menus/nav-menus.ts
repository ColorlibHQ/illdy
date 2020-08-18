/**
 * Epsilon Nav Menu Class
 */
export class EpsilonNavMenus {
  /**
   * Nav Menu Api
   * @type {null}
   */
  public api: null | any;
  public context: JQuery;

  /**
   * Constructor
   * @param api
   */
  public constructor( api: any ) {
    this.api = api;
    this.context = jQuery( '#epsilon-section-navigation-menu' );
    this.handleEvents();
  }

  public handleEvents() {
    jQuery( '#submit-epsilon-section' ).on( 'click', ( evt: JQueryEventConstructor ) => {
      const self = this;
      const object = {
        label: this.context.find( '#epsilon-section-label' ).val(),
        value: this.context.find( '#epsilon-section-id' ).val()
      };

      evt.preventDefault();

      this.context.find( '.spinner' ).addClass( 'is-active' );

      this.api.addItemToMenu( {
        '-1': {
          'menu-item-type': 'custom',
          'menu-item-extra': 'epsilon-frontpage-section',
          'menu-item-url': '#' + object.value,
          'menu-item-section': object.value,
          'menu-item-title': object.label
        }
      }, self.api.addMenuItemToBottom, self.menuAdded );
    } );
  }

  public menuAdded() {
    const div = jQuery( '#epsilon-section-navigation-menu' );
    div.find( '.spinner' ).removeClass( 'is-active' );
    div.find( '#epsilon-section-navigation-menu #epsilon-section-id' ).val( 0 ).blur();
    div.find( '#epsilon-section-navigation-menu #epsilon-section-label' ).val( '' ).blur();
  }
}
