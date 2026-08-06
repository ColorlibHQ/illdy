declare var wp: any;

import { EpsilonImageDimensions } from '../../controls/image-dimensions';

wp.customize.controlConstructor[ 'epsilon-image-dimensions' ] = wp.customize.Control.extend( {
  ready() {
    var control = this;
    new EpsilonImageDimensions( control );
  }
} );
