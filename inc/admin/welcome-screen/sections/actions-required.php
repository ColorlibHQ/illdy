<?php
/**
 * Actions required
 */
?>

<div id="actions_required" class="illdy-tab-pane">

    <h1><?php esc_html_e( 'Actions recommend to make this theme look like in the demo.' ,'illdy' ); ?></h1>

    <!-- NEWS -->
    <hr />

	<?php
	global $illdy_required_actions;

	if( !empty($illdy_required_actions) ):

		/* illdy_show_required_actions is an array of true/false for each required action that was dismissed */
		$illdy_show_required_actions = get_option("illdy_show_required_actions");
		$action_number = 1;
		foreach( $illdy_required_actions as $illdy_required_action_key => $illdy_required_action_value ):
			if(@$illdy_show_required_actions[$illdy_required_action_value['id']] === false) continue;
			if(@$illdy_required_action_value['check']) continue;
			?>
			<div class="illdy-action-required-box">
				<span class="dashicons dashicons-no-alt illdy-dismiss-required-action" id="<?php echo $illdy_required_action_value['id']; ?>"></span>
				<h4><?php echo $action_number; ?>. <?php if( !empty($illdy_required_action_value['title']) ): echo $illdy_required_action_value['title']; endif; ?></h4>
				<p><?php if( !empty($illdy_required_action_value['description']) ): echo $illdy_required_action_value['description']; endif; ?></p>
				<?php
					if( !empty($illdy_required_action_value['plugin_slug']) ):
						?><p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin='.$illdy_required_action_value['plugin_slug'] ), 'install-plugin_'.$illdy_required_action_value['plugin_slug'] ) ); ?>" class="button button-primary"><?php if( !empty($illdy_required_action_value['title']) ): echo $illdy_required_action_value['title']; endif; ?></a></p><?php
					endif;
				?>

				<hr />
			</div>
			<?php
			$action_number ++;
		endforeach;
	endif;

	$nr_actions_required = 0;

	/* get number of required actions */
	if( get_option('illdy_show_required_actions') ):
		$illdy_show_required_actions = get_option('illdy_show_required_actions');
	else:
		$illdy_show_required_actions = array();
	endif;

	if( !empty($illdy_required_actions) ):
		foreach( $illdy_required_actions as $illdy_required_action_value ):
			if(( !isset( $illdy_required_action_value['check'] ) || ( isset( $illdy_required_action_value['check'] ) && ( $illdy_required_action_value['check'] == false ) ) ) && ((isset($illdy_show_required_actions[$illdy_required_action_value['id']]) && ($illdy_show_required_actions[$illdy_required_action_value['id']] == true)) || !isset($illdy_show_required_actions[$illdy_required_action_value['id']]) )) :
				$nr_actions_required++;
			endif;
		endforeach;
	endif;

	if( $nr_actions_required == 0 ):
		echo '<p>'.__( 'Hooray! There are no required actions for you right now.','illdy' ).'</p>';
	endif;
	?>

</div>
