<?php
/*
	Plugin Name: Notifications
*/

/**
 * NOTF_PLUGIN_PATH
 * @author Chris Reynolds
 * @since 1.0
 * this creates a global value for the plugin path we can use for the menu icons later
 */
define('NOTF_PLUGIN_PATH',WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)));

/**
 * Testimonials Post Type
 * @author Chris Reynolds
 * @link http://justintadlock.com/archives/2010/04/29/custom-post-types-in-wordpress
 * @since 1.0
 * create a custom post type for notifications
 */
function notf_post_type_notifications() {
	$labels = array(
		'name' => _x('Notifications', 'notifications'),
		'singular_name' => _x('Notification', 'notifications'),
		'add_new' => _x('Add New', 'notifications'),
		'add_new_item' => __('Add New Notification', 'nofifications'),
		'edit_item' => __('Edit Notification', 'nofifications'),
		'edit' => _x('Edit', 'notifications', 'nofifications'),
		'new_item' => __('New Notification', 'nofifications'),
		'view_item' => __('View Notification', 'nofifications'),
		'search_items' => __('Search Notifications', 'nofifications'),
		'not_found' =>  __('No notifications found', 'nofifications'),
		'not_found_in_trash' => __('No notifications found in Trash', 'nofifications'),
		'view' =>  __('View Notification', 'nofifications'),
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => false,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 15,
		'supports' => array( 'title' ),
		'exclude_from_search' => true
	);

	register_post_type( 'notf_notifications', $args );
}

/* add the custom post type */
add_action( 'init', 'notf_post_type_notifications', 0 );

/**
 * Change default title
 * Changes the default title on notification posts
 * @author Chris Reynolds
 * @since 0.1
 * @uses get_current_screen
 * @uses enter_title_here
 * @link http://wp-snippets.com/change-enter-title-here-text-for-custom-post-type/
 */
function notf_change_default_title( $title ){
     $screen = get_current_screen();
     if  ( 'notf_notifications' == $screen->post_type ) {
          $title = 'Enter notification text here';
     }
     return $title;
}
add_filter( 'enter_title_here', 'notf_change_default_title' );

function notf_message() {
	$args = array(
		'post_type' => 'notf_notifications',
		'posts_per_page' => 1,
		);
	$notifications = get_posts( $args );
	foreach ( $notifications as $notification ) {
		$notf_id = $notification->ID;
		$message = get_the_title( $notf_id );
	}
	return $message;
}

function notf_output_notification() {
	$wrapper_open = '<div class="notification">';
	$output = '<div class="notification">' . notf_message() . '</div>';
	if ( has_filter( 'notf_notification_filter' ) ) {
		$output = apply_filters( 'notf_notification_filter', $output, 10, 2 );
	}
	return $output;
}
function notf_display() {
	echo notf_output_notification();
}
add_action( 'body_open', 'notf_display' );

/*
function my_test_filter( $output ) {
	$output = '<span class="whoops-i-did-it-again" style="color: red;">'.notf_message().'</span>';
	return $output;
}
add_filter( 'notf_notification_filter', 'my_test_filter' );
*/

function notf_css() {
	if ( !is_admin() ) {
		wp_enqueue_style( 'notf-css', NOTF_PLUGIN_PATH . '/css/notf-css.css' );
	}
}
add_action( 'wp_head', 'notf_css' );
?>