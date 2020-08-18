declare var wp: any;

wp.customize.controlConstructor[ 'epsilon-toggle' ] = wp.customize.Control.extend( {
  ready() {
    var control = this;

    control.container.on( 'change', 'input.onoffswitch-checkbox', ( e: Event ) => {
          control.setting.set( jQuery( e.target ).prop( 'checked' ) );
        }
    );
  }
} );
