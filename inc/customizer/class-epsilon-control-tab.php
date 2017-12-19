<?php

if ( ! class_exists( 'Epsilon_Control_Tab' ) ) {
	class Epsilon_Control_Tab extends WP_Customize_Control {
		public $type    = 'epsilon-tab';
		public $buttons = '';
		public function __construct( WP_Customize_Manager $manager, $id, array $args ) {
			parent::__construct( $manager, $id, $args );
		}
		public function to_json() {
			parent::to_json();
			$first             = true;
			$formatted_buttons = array();
			$all_fields        = array();
			foreach ( $this->buttons as $button ) {
				$fields = array();
				$active = isset( $button['active'] ) ? $button['active'] : false;
				if ( $active && $first ) {
					$first = false;
				} elseif ( $active && ! $first ) {
					$active = false;
				}

				$formatted_buttons[] = array(
					'name'   => $button['name'],
					'fields' => $button['fields'],
					'active' => $active,
				);
				$all_fields          = array_merge( $all_fields, $button['fields'] );
			}
			$this->json['buttons'] = $formatted_buttons;
			$this->json['fields']  = $all_fields;

		}

		public function content_template() {
	?>
			<div class="epsilon-tabs">
				<# if ( data.buttons ) { #>
					<div class="tabs">
						<# for (tab in data.buttons) { #>
							<a href="#" class="epsilon-tab <# if ( data.buttons[tab].active ) { #> active <# } #>" data-tab="{{ tab }}">{{ data.buttons[tab].name }}</a>
						<# } #>
					</div>

				<# } #>
			</div>
			<div class="epsilon-after-tab"><div></div></div>
		<?php
		}
	}
}// End if().
