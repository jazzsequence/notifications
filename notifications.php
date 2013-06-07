<?php
/*
	Plugin Name: Notifications
	Plugin URI: http://museumthemes.com/notifications/
	Description: Easy, customizable notifications for your WordPress site
	Version: 1.1
	Author: Chris Reynolds
	Author URI: http://jazzsequence.com
	License: GPL3
*/

/**
 * Path definitions
 * @author Chris Reynolds
 * @since 1.0
 * creates some global values for the plugin path we can use for the menu icons and other things later
 */
define('NOTF_PLUGIN_PATH',WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)));
define('NOTF_PLUGIN_DIR',WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__), "", plugin_basename(__FILE__)));

/**
 * Notifications Post Type
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
		'supports' => array( 'title' ),
		'exclude_from_search' => true
	);

	register_post_type( 'notf_notifications', $args );
}
add_action( 'init', 'notf_post_type_notifications', 0 );

/**
 * Settings init
 * @since 1.0
 * @uses register_setting
 * @author Chris Reynolds
 * initializes the options
 */
function notf_settings_init() {
	register_setting( 'notf_settings', 'notf_settings', 'notf_validate_settings' );
}
add_action( 'admin_init', 'notf_settings_init' );

/**
 * Add options page
 * @since 1.0
 * @uses add_submenu_page
 * @author Chris Reynolds
 * adds the options page under the Notifications post type
 */
function notf_add_options_page() {
	$page = add_submenu_page( 'edit.php?post_type=notf_notifications', __( 'Notifications Options', 'notifications' ), __( 'Options', 'notifications' ), 'administrator', 'notf_settings', 'notf_settings_page' );
}
add_action( 'admin_menu', 'notf_add_options_page' );

/**
 * Notifications settings page
 * @since 1.0
 * @uses notf_do_options
 * @author Chris Reynolds
 * renders the actual options page
 */
function notf_settings_page() {
	if ( !isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	require_once( NOTF_PLUGIN_DIR . '/inc/option-setup.php' );
	?>
	<div class="wrap">
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved', 'notifications' ); ?></strong></p></div>
		<?php endif; ?>
		<div id="icon-edit" class="icon32 icon32-posts-notf_notifications"><br></div>
		<h2><?php _e( 'Notifications Options', 'notifications' ); ?></h2>
		<div id="poststuff" class="metabox-holder">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<form method="post" action="options.php">
						<?php settings_fields( 'notf_settings' ); ?>
						<?php notf_do_options(); ?>
						<p class="submit">
							<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'notifications' ); ?>" />
							<input type="hidden" name="notf-settings-submit" value="Y" />
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Notifications styles
 * @since 1.0
 * @author Chris Reynolds
 * options array for styles
 */
function notf_styles() {
	$notf_styles = array(
		'default' => array(
			'label' => __( 'Default', 'notifications' ),
			'value' => 'default'
		),
		'cool' => array(
			'label' => __( 'Something cool', 'notifications' ),
			'value' => 'cool'
		),
		'metallic' => array(
			'label' => __( 'Metallic', 'notifications' ),
			'value' => 'metallic'
		),
		'gray' => array(
			'label' => __( 'Any color, as long as it\'s gray', 'notifications' ),
			'value' => 'gray'
		),
		'hot' => array(
			'label' => __( 'A real hot one', 'notifications' ),
			'value' => 'hot'
		),
		'warm' => array(
			'label' => __( 'Getting warmer', 'notifications' ),
			'value' => 'warm'
		),
		'lemon' => array(
			'label' => __( 'Lemon', 'notifications' ),
			'value' => 'lemon'
		),
		'orange' => array(
			'label' => __( 'Orange', 'notifications' ),
			'value' => 'orange'
		),
		'plain' => array(
			'label' => __( 'Plain Jane', 'notifications' ),
			'value' => 'plain'
		),
		'pressed' => array(
			'label' => __( 'Press\'d!', 'notifications' ),
			'value' => 'pressed'
		),
		'admin' => array(
			'label' => __( 'Another admin bar', 'notifications' ),
			'value' => 'admin'
		),
		'tax' => array(
			'label' => __( 'Tax Return', 'notifications' ),
			'value' => 'tax'
		),
		'idea' => array(
			'label' => __( 'Bright Idea', 'notifications' ),
			'value' => 'idea'
		),
		'alert' => array(
			'label' => __( 'Alert!', 'notifications' ),
			'value' => 'alert'
		),
		'warning' => array(
			'label' => __( 'Something bad', 'notifications' ),
			'value' => 'error'
		),
		'info' => array(
			'label' => __( 'You should know...', 'notifications' ),
			'value' => 'info'
		),
		'success' => array(
			'label' => __( 'Success!!', 'notifications' ),
			'value' => 'success'
		),
		'none' => array(
			'label' => __( 'None', 'notifications' ),
			'value' => null
		)
	);
	return $notf_styles;
}

/**
 * Notifications defaults
 * @since 1.0
 * @author Chris Reynolds
 * default options
 */
function notf_defaults() {
	$notf_defaults = array(
		'style' => 'default',
		'css' => null,
		'class' => null,
		'sticky' => false
	);
	return $notf_defaults;
}

/**
 * Validate settings
 * @since 1.0
 * @uses wp_filter_nohtml_kses
 * @author Chris Reynolds
 * escapes any bad data
 */
function notf_validate_settings( $input ) {
	if ( !array_key_exists( $input['style'], notf_styles() ) )
		$input['style'] = $input['style'];

	if ( isset($input['sticky']) )
		$input['sticky'] = wp_filter_nohtml_kses( $input['sticky'] );
	$input['class'] = wp_filter_nohtml_kses( $input['class'] );
	$input['css'] = wp_filter_nohtml_kses( $input['css'] );

	return $input;
}
/**
 * Change default title
 * @since 1.0
 * @uses get_current_screen
 * @author Chris Reynolds
 * @link http://wp-snippets.com/change-enter-title-here-text-for-custom-post-type/
 * Changes the default title on notification posts
 */
function notf_change_default_title( $title ){
     $screen = get_current_screen();
     if  ( 'notf_notifications' == $screen->post_type ) {
          $title = 'Enter notification text here';
     }
     return $title;
}
add_filter( 'enter_title_here', 'notf_change_default_title' );

/**
 * Remove permalink
 * @since 1.0
 * @uses get_sample_permalink_html
 * @uses get_post_type
 * @author Chris Reynolds
 * @link http://wordpress.stackexchange.com/questions/31627/removing-edit-permalink-view-custom-post-type-areas
 * @link http://hitchhackerguide.com/2011/02/12/get_sample_permalink_html/
 * this removes the permalink and view post from notifications, but not anything else
 */
function notf_remove_permalink($return, $id, $new_title, $new_slug){
	global $post;
	if ( 'notf_notifications' != get_post_type( $post->ID ) ) {
		return $return;
	}
}
add_filter('get_sample_permalink_html', 'notf_remove_permalink', '',4);

/**
 * Notification message
 * @since 1.0
 * @uses get_posts
 * @author Chris Reynolds
 * returns the most recent notification
 */
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

/**
 * Output notification
 * @since 1.0
 * @uses get_option
 * @uses notf_defaults
 * @uses notf_message
 * @uses apply_filters
 * returns the full notification message and formatting
 */
function notf_output_notification() {
	$defaults = notf_defaults();
	$options = get_option( 'notf_settings', $defaults );
	if ( $options['class'] ) {
		$custom_class = $options['class'];
	} else {
		$custom_class = $defaults['class'];
	}
	$style = null;
	if ( $options['style'] )
		$style = $options['style'];

	$output = "<div class=\"notification $custom_class $style\">" . notf_message() . "</div>";

	if ( has_filter( 'notf_notification_filter' ) ) {
		$output = apply_filters( 'notf_notification_filter', $output, 10, 2 );
	}
	return $output;
}

/**
 * Custom CSS
 * @since 1.0
 * @uses get_option
 * @uses notf_defaults
 * @author Chris Reynolds
 * outputs the custom CSS if any exists
 */
function notf_custom_css_output() {
	$defaults = notf_defaults();
	$options = get_option( 'notf_settings', $defaults );
	if ( array_key_exists( 'sticky', $options ) || !empty( $options['css'] ) || $options['css'] == '' || $options['css'] == '/* add your custom css here */' ) {
		$output = '<style type="text/css" media="print,screen">';
		if ( array_key_exists( 'sticky', $options ) ) {
			/* if the notification is sticky, stick it */
			$output .= '.notification { position: fixed; top: 0; }';
			$output .= '.logged-in .notification { top: 28px; }';
		}
		$output .= sanitize_text_field( $options['css'] );
		$output .= '</style>';
		echo $output;
	}
}
add_action( 'wp_head', 'notf_custom_css_output' );

/**
 * Notification CSS
 * @since 1.0
 * @uses wp_enqueue_style
 * @author Chris Reynolds
 * enqueues notf-css.css
 */

function notf_css() {
	if ( !is_admin() ) {
		wp_enqueue_style( 'notf-css', NOTF_PLUGIN_PATH . '/css/notf-css.css' );
	}
}
add_action( 'wp_head', 'notf_css' );

/**
 * Display notification
 * @since 1.0
 * @uses notf_output_notification
 * @author Chris Reynolds
 * hooks notification into the body_open action and displays the notification
 */
function notf_display() {
	echo notf_output_notification();
}
add_action( 'body_open', 'notf_display' );

/**
 * Notification icons
 * deals with the custom icons for the notifications pages
 * @since 1.0
 * @uses admin_head
 * @author Chris Reynolds
 */
function notf_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-notf_notifications .wp-menu-image {
			background: url(<?php echo NOTF_PLUGIN_PATH; ?>/img/notification16.png) no-repeat 6px 6px !important;
			opacity: 0.4;
			filter:alpha(opacity=40); /* For IE8 and earlier */
        }
		#menu-posts-notf_notifications:hover .wp-menu-image {
			background: url(<?php echo NOTF_PLUGIN_PATH; ?>/img/notification16.png) no-repeat 6px 6px !important;
			opacity: 1.0;
			filter:alpha(opacity=100);
        }
		#menu-posts-notf_notifications.wp-has-current-submenu .wp-menu-image {
			background: url(<?php echo NOTF_PLUGIN_PATH; ?>/img/notification16-inv.png) no-repeat 6px 6px !important;
			opacity: 1.0;
			filter:alpha(opacity=100);
		}
		#icon-edit.icon32-posts-notf_notifications { background: url(<?php echo NOTF_PLUGIN_PATH; ?>/img/notification32.png) no-repeat!important; }
    </style>
<?php
}
add_action( 'admin_head', 'notf_icons' );

/*
// this is an example filter for the notification output
// you can use this to build your own filter and change the output of the notifications
function my_test_filter( $output ) {
	$output = '<span class="whoops-i-did-it-again" style="color: red;">'.notf_message().'</span>';
	return $output;
}
add_filter( 'notf_notification_filter', 'my_test_filter' );
*/