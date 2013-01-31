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
define('NOTF_PLUGIN_DIR',WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__), "", plugin_basename(__FILE__)));

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

function notf_settings_init() {
	register_setting( 'notf_settings', 'notf_settings', 'notf_validate_settings' );
}
add_action( 'admin_init', 'notf_settings_init' );

function notf_add_options_page() {
	$page = add_submenu_page( 'edit.php?post_type=notf_notifications', __( 'Notifications Options', 'notifications' ), __( 'Options', 'notifications' ), 'administrator', 'notf_settings', 'notf_settings_page' );
}
add_action( 'admin_menu', 'notf_add_options_page' );

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

function notf_styles() {
	$notf_styles = array(
		'default' => array(
			'label' => __( 'Default', 'notifications' ),
			'value' => 'default'
		),
		'alert' => array(
			'label' => __( 'Alert!', 'notifications' ),
			'value' => 'alert'
		),
		'warning' => array(
			'label' => __( 'Something bad', 'notifications' ),
			'value' => 'warning'
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
			'label' => __( 'None', 'notifications' )
			'value' => null
		)
	);
	return $notf_styles;
}

function notf_defaults() {
	$notf_defaults = array(
		'style' => 'default',
		'css' => null,
		'class' => null
	);
	return $notf_defaults;
}

function notf_validate_settings( $input ) {
	if ( !array_key_exists( $input['style'], notf_styles() ) )
		$input['style'] = $input['style'];

	$input['class'] = wp_filter_nohtml_kses( $input['class'] );
	$input['css'] = wp_filter_nohtml_kses( $input['css'] );

	return $input;
}
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
	$defaults = notf_defaults();
	$options = get_option( 'notf_settings', $defaults );
	if ( $options['class'] ) {
		$custom_class = $options['class'];
	} else {
		$custom_class = $defaults['class'];
	}
	if ( !$options['css'] || $options['css'] == '' || $options['css'] == '/* add your custom css here */' ) {
		if ( $options['style'] ) {
			$style = $options['style'];
		} else {
			$style = $defaults['style'];
		}
	} else {
		$style = null;
	}

	$output = "<div class=\"notification $custom_class $style\">" . notf_message() . "</div>";

	if ( has_filter( 'notf_notification_filter' ) ) {
		$output = apply_filters( 'notf_notification_filter', $output, 10, 2 );
	}
	return $output;
}

function notf_custom_css_output() {
	$defaults = notf_defaults();
	$options = get_option( 'notf_settings', $defaults );
	if ( !empty( $options['css'] ) || $options['css'] == '' || $options['css'] == '/* add your custom css here */' ) {
		$output = '<style type="text/css" media="print,screen">';
		$output .= sanitize_text_field( $options['css'] );
		$output .= '</style>';
		echo $output;
	}
}
add_action( 'wp_head', 'notf_custom_css_output' );

function notf_display() {
	echo notf_output_notification();
}
add_action( 'body_open', 'notf_display' );

/*
// this is an example filter for the notification output
// you can use this to build your own filter and change the output of the notifications
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