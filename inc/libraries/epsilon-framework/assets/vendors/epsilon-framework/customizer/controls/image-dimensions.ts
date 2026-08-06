declare var EpsilonWPUrls: any;
declare var wp: any;
declare var _: any;

/**
 * Epsilon Image Dimensions
 */
export class EpsilonImageDimensions {
  /**
   * Control instance
   * @type {null}
   */
  public control: any = null;
  /**
   * Related controls
   * @type {null}
   */
  public linkedControl: any = null;

  /**
   * Value to be saved in the database
   * @type {{}}
   */
  public value: any = {
    width: null,
    height: null,
    ratio: true,
    linked_control: '',
  };

  /**
   * Calculated ratio for the loaded image
   */
  public imageSizes: {
    width: number,
    height: number,
  } = {
    width: 0,
    height: 0,
  };

  /**
   * Has image
   */
  public hasImage: boolean = false;
  /**
   * Expose api to this instance
   */
  public api: any = wp.customize;

  /**
   * Control constructor
   *
   * @param control
   */
  public constructor( control: any ) {
    this.control = control;
    this.value.linked_control = control.params.linkedControl;
    this.mergeValues();

    this.linkedControl = this.api.control( control.params.linkedControl );
    this.setLinkedControlSpecs();

    this.init();
  }

  /**
   * Init function
   */
  public init() {
    /**
     * Handle events
     */
    this.handleInputChanges();
    this.handleAspectRatio();

    /**
     * Bind event on the linked control change
     */
    this.linkedControl.setting.bind( 'change', () => {
      this.linkedControlChanged();
    } );
  }

  /**
   * Merge already set values
   */
  public mergeValues() {
    return jQuery.extend( this.value, this.control.params.value );
  }

  /**
   * Verify the linked control specs and update our object
   */
  public setLinkedControlSpecs() {
    this.imageSizes = {
      width: 0,
      height: 0,
    };

    this.hasImage = typeof this.linkedControl.params.attachment !== 'undefined';
    if ( this.hasImage ) {
      this.imageSizes = {
        width: this.linkedControl.params.attachment.width,
        height: this.linkedControl.params.attachment.height,
      };
    }
  }

  /**
   * Toggle aspect ratio
   */
  public handleAspectRatio() {
    this.control.container.find( 'input[type="checkbox"]' ).on( 'change', ( event: JQueryEventConstructor ) => {
      this.value.ratio = jQuery( event.target ).prop( 'checked' );
      this.saveData();
    } );
  }

  /**
   * Handles changes inside the
   */
  public handleInputChanges() {
    this.control.container.find( 'input[type="text"]' ).on( 'keyup', _.debounce( ( element: JQueryEventConstructor ) => {
      let key = jQuery( element.target ).attr( 'data-type' ),
          val = jQuery( element.target ).val();

      if ( typeof key === 'undefined' ) {
        return;
      }

      if ( typeof val === 'string' ) {
        val = parseInt( val );
      }

      this.setDimension( key, val );
    }, 200 ) );
  }

  /**
   * Linked control change should update inputs
   */
  public linkedControlChanged() {
    if ( typeof this.linkedControl.params.attachment === 'undefined' ) {
      return;
    }

    this.setLinkedControlSpecs();

    this.control.container.find( 'input[data-type="width"]' ).val( this.linkedControl.params.attachment.width ).change();
    this.control.container.find( 'input[data-type="height"]' ).val( this.linkedControl.params.attachment.height ).change();
  }

  /**
   * Sets dimension for the image
   *
   * @param {String} key
   * @param {Number} val
   */
  public setDimension( key: String | any, val: Number | any ) {
    if ( typeof key === 'undefined' ) {
      return;
    }

    if ( ! this.value.hasOwnProperty( key ) ) {
      return;
    }

    this.value[ key ] = val;

    if ( this.value.ratio ) {
      this.calculateRatio( key );
    }

    this.saveData();
  }

  /**
   * Calculates ratio
   */
  public calculateRatio( key: any ) {

    switch ( key ) {
      case 'width' :
        // height = user width * original height / original width
        this.value.height = Math.ceil( this.value.width * this.linkedControl.params.attachment.height / this.linkedControl.params.attachment.width );

        this.control.container.find( 'input[data-type="height"]' ).val( this.value.height );
        break;
      default:
        // width = user height * original width / original height
        this.value.width = Math.ceil( this.value.height * this.linkedControl.params.attachment.width / this.linkedControl.params.attachment.height );
        this.control.container.find( 'input[data-type="width"]' ).val( this.value.width );
        break;
    }

  }

  /**
   * Saves data in the customizer
   */
  public saveData() {
    this.control.setting( JSON.stringify( this.value ) );
  }
}
