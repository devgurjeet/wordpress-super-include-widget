<?php
/*
Plugin Name: Super Include Widget
Plugin URI: https://github.com/devgurjeet/wordpress-super-include-widget
Description: This plugin allow users to include external file using wordpress widget.
Version: 1.0.0
Author: Gurjeet Singh
Author URI: https://github.com/devgurjeet/wordpress-super-include-widget
License:
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class SI_Widget extends WP_Widget{

	//** Consntructor **//
	function __construct() {		
		
		parent::__construct(
		// Base ID of your widget
		'si_widget',

		// Widget name will appear in UI
		__('Super Include Widget', 'si_widget_domain'), 

		// Widget description
		array( 'description' => __( 'Widget for including external Files', 'si_widget_domain' ), ) );

		//** Action to register Widget. **//
		add_action( 'widgets_init', array(&$this, 'aw_load_widget') );
		
	}


	function AddFeed( $attr  ){
		$AddFilePath = 	$attr['AddFilePath'];
		echo '<div class="si_widget_block">';			
			echo $structure;
			include $AddFilePath;
		echo "</div>";
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {

		apply_filters( 'widget_title', $instance['AddFilePath'] );		
		// before and after widget arguments are defined by themes
		$AddFilePath 			= 	$instance['AddFilePath'];
		$args['AddFilePath'] 	=	$AddFilePath;

		$this->addFeed($args);
	}

		
	// Widget Backend 
	public function form( $instance ) {
		// Widget admin form
		$AddFilePath = $instance['AddFilePath'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'AddFilePath' ); ?>"><?php _e( 'File Path:' ); ?></label> 		
			<input class="widefat" id="<?php echo $this->get_field_id( 'AddFilePath' ); ?>" name="<?php echo $this->get_field_name( 'AddFilePath' ); ?>" type="text" value="<?php echo esc_attr( $AddFilePath ); ?>" />
		</p>
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['AddFilePath'] = ( ! empty( $new_instance['AddFilePath'] ) ) ? strip_tags( $new_instance['AddFilePath'] ) : '';	

		return $instance;
	}

	// Register and load the widget
	function aw_load_widget() {
		register_widget( 'SI_Widget' );
	}

}//** Class ends here. **//



$SI_Widget = new SI_Widget;

?>