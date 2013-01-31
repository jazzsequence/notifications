#Notifications

Easy, customizable notifications for your WordPress site

##Description

How many times have you needed to display a notice across your site? Too many, if you ask me. I wrote this plugin because many of the notification bar plugins out there leave much to be desired. Either there are too many options or not enough or not the ones that I want. Plus, it's not easy to create a notice -- you have to go to some crazy screen and set options unique to that plugin.

This plugin uses custom post types, so notifications are set up like mini-posts that we all know and love. Multiple controls, as well as a built-in filter, enable developers and casual users alike to easily customize the notification bar to your heart's content.

##Usage

Notifications looks for the `body_open` hook. This hook  was first [proposed on Trac](http://core.trac.wordpress.org/ticket/12563#comment:10) by [Andrew Nacin](https://twitter.com/nacin) as a way to hook into an action that fires immediately after the `<body>` tag in the code.

Want to filter the output to customize how the notification gets displayed? Use the `notf_notification_filter` filter in your plugin or theme, like this:

     function my_test_filter( $output ) {
     	$output = '<span class="whoops-i-did-it-again" style="color: red;">'.notf_message().'</span>';
     	return $output;
     }
     add_filter( 'notf_notification_filter', 'my_test_filter' );
     
**Important:** Use the `notf_message` function in your filter to return the actual notification.

##Installation

1. Upload the plugin via FTP or the plugin uploader to your `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. If your theme does not natively support the `body_open` hook, open your `header.php` and add the following immediately after the `<body>` tag:

`     <?php do_action( 'body_open' ); ?>`

##Changelog

###1.0
* first public release