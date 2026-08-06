import { EpsilonPageChanger } from '../../controls/page-changer';

declare var wp: any;

wp.customize.controlConstructor[ 'epsilon-page-changer' ] = wp.customize.Control.extend( {
  ready() {
    var control: any = this;
    new EpsilonPageChanger( control );
  }
} );
