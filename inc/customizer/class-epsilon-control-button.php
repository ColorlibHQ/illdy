<?php

if ( ! class_exists( 'Epsilon_Control_Button' ) ) {
	class Epsilon_Control_Button extends WP_Customize_Control {
		public $type       = 'epsilon-button';
		public $text       = '';
		public $section_id = '';
		public $icon       = '';
		public function __construct( WP_Customize_Manager $manager, $id, array $args ) {
			parent::__construct( $manager, $id, $args );
		}
		public function to_json() {
			parent::to_json();
			$this->json['text']       = $this->text;
			$this->json['section_id'] = $this->section_id;
			$this->json['icon']       = $this->icon;
		}

		public function content_template() {
	?>
			<div class="epsilon-button">
				<# if ( data.section_id ) { #>
					<a href="#" class="epsilon-button" data-section="{{ data.section_id }}">
						<# if ( data.icon ) { #>
							<span class="dashicons {{ data.icon }}"></span>
						<# } #>
						{{ data.text }}</a>
				<# } #>
			</div>
		<?php
		}
	}
}
