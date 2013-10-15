=== Notifications ===
Contributors: jazzs3quence
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=AWM2TG3D4HYQ6
Requires at least: 3.0
Tested up to: 3.6.1
Stable tag: 1.1.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Easy, customizable notifications for your WordPress site

== Description ==

How many times have you needed to display a notice across your site? Too many, if you ask me. I wrote this plugin because many of the notification bar plugins out there leave much to be desired. Either there are too many options or not enough or not the ones that I want. Plus, it's not easy to create a notice -- you have to go to some crazy screen and set options unique to that plugin.

This plugin uses custom post types, so notifications are set up like mini-posts that we all know and love. Multiple controls, as well as a built-in filter, enable developers and casual users alike to easily customize the notification bar to your heart's content.

**Update:** This plugin now supports the [Theme Hook Alliance](https://github.com/zamoose/themehookalliance) `tha_body_top` action. If you are using the `body_open` action in your child theme, please change this to `tha_body_top`, e.g.

`do_action( 'tha_body_top' );`

= Usage =

Notifications looks for the `body_open` hook. This hook  was first [proposed on Trac](http://core.trac.wordpress.org/ticket/12563#comment:10) by [Andrew Nacin](https://twitter.com/nacin) as a way to hook into an action that fires immediately after the `<body>` tag in the code.

Want to filter the output to customize how the notification gets displayed? Use the `notf_notification_filter` filter in your plugin or theme, like this:

`
     function my_test_filter( $output ) {
     	$output = '<span class="whoops-i-did-it-again" style="color: red;">'.notf_message().'</span>';
     	return $output;
     }
     add_filter( 'notf_notification_filter', 'my_test_filter' );
`

**Important:** Use the `notf_message` function in your filter to return the actual notification.

== Installation ==

1. Upload the plugin via FTP or the plugin uploader to your `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. If your theme does not natively support the `body_open` hook, open your `header.php` and add the following immediately after the `<body>` tag:

`<?php do_action( 'tha_body_top' ); ?>`

== Screenshots ==

= 17 different pre-made styles =

1. Default style

2. Something cool

3. Metallic

4. Any color, as long as it's gray

5. A real hot one

6. Getting warmer

7. Lemon

8. Orange

9. Plain Jane

10. Press'd!

11. Another admin bar

12. Tax Return

13. Bright idea

14. Alert!

15. Something bad

16. You should know…

17. Success!!

18. No styles

== Changelog ==

= 1.1.2 =

* Updates support for [Theme Hook Alliance](https://github.com/zamoose/themehookalliance) action hook instead of arbitrary, theme-specific hooks.

= 1.1.1 =

* fixes validation _doing_it_wrong()

= 1.1 =

* added sticky option, to stick the notification to the top of the page, rather than scrolling with the page.

= 1.0.1 =

* removes menu order (can conflict with other post types with same menu order)

= 1.0 =

* first public release

== Upgrade Notice ==

= 1.1.2 =
**Please update your themes to support the new `tha_body_top` action!**

`<?php do_action( 'tha_body_top' ); ?>