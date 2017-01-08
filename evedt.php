<?php
/*
Plugin Name: Eve Donation Tracker Plugin
Description: Adds Widget for evedt
*/
/* Start Adding Functions Below this Line */

// Creating the widget 
class evedt_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'evedt_widget', 

// Widget name will appear in UI
__('Eve Donation Tracker', 'ch_n1b_evedt'), 

// Widget description
array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'ch_n1b_evedt' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
echo __( 'Hello, World!', 'ch_n1b_evedt' );
?>

Blibediblabedi
<div>
	<span class="evedt-donator-name"></span>
	<span class="evedt-donator-amount"></span>
</div>

<script>
jQuery(function(){
	var $ = jQuery;
	console.log("EVEDT FTW!");
	$.ajax({
		url: '/api/donations',
		success: function(donations){
			$('.evedt-donator-name').text(donations[0].characterName);
			$('.evedt-donator-amount').text(donations[0].amount);
		}
	})
})
</script>
<?php
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'ch_n1b_evedt' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function evedt_load_widget() {
	register_widget( 'evedt_widget' );
}
add_action( 'widgets_init', 'evedt_load_widget' );

/* Stop Adding Functions Below this Line */
?>
