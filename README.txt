=== Email Templates ===
Contributors: timersys
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=K4T6L69EV9G2Q
Tags: email templates, email template, html email, email template, template, better emails, wp better emails, wp email templates, html emails, postman, wp smtp, woocommerce, easy digital downloads
Requires at least: 4.0
Tested up to: 5.3
Stable tag: 1.3.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Send beautiful emails with the WordPress Email Templates plugin
== Description ==

Send beautiful emails with the WordPress Email Templates plugin. Choose your template style, add a logo or some text, change colors, edit footer and start sending nice emails in WordPress.

Email Template plugin uses Customizer to make it easier. Preview your changes or send a test email with just a few clicks. **Requires WordPress 4.0.0**

Compatible with : [Post SMTP](https://wordpress.org/plugins/post-smtp/), [WP SMTP](https://wordpress.org/plugins/wp-smtp/), [Easy WP SMTP](https://wordpress.org/plugins/easy-wp-smtp/), [Easy SMTP Mail](https://wordpress.org/plugins/webriti-smtp-mail/), [Mailgun](https://wordpress.org/plugins/mailgun/), [Sengrid](https://wordpress.org/plugins/sendgrid-email-delivery-simplified/)

= Help with translations =

Send your translations to [Transifex](https://www.transifex.com/projects/p/wp-email-templates/)

= Currently Available in: =
*   English
*   Spanish
*   French
*   Chinese
*   Portuguese
*   Dutch
*   Persian
*   Russian
*   German

= Collaborate in Github = - [https://github.com/timersys/wordpress-email-templates](https://github.com/timersys/wordpress-email-templates)



Thanks to @eliorivero for sharing some customizer tips for plugins :)

== Installation ==

1. Upload the plugin in /wp-admin/plugin-install.php
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Click on Appearance -> "Email Templates" to start editing

== Frequently Asked Questions ==

= How to add a custom template? =

Copy the templates folder into your theme , then in functions.php add the following:

`add_filter(‘mailtpl/customizer_template’, function(){
    return get_stylesheet_directory() . “/admin/templates/default.php”;
});`

== Screenshots ==

1. Editing a template
2. Email received
3. Another example

== Changelog ==

= 1.3.1.2 =
* Fixed css width
* new filter for default message

= 1.3.1.1 =
* Only filter non html messages
* Fixed bug introduced on 1.3.1

= 1.3.1 =
* Security fix to prevent html injection
* Filter attributes for images

= 1.3 =
* Instead of multiple filters we now just modify wp_mail to make plugin more compatible
with transactional mail plugins

= 1.2.2.3 =
* Fixed issue with maxwith not working on certain installs.

= 1.2.2.2 =
* Fixed issue with boxed layout

= 1.2.2.1 =
* Text domain update

= 1.2.2 =
* Added image support in header text
* Fixed issue with spaces on gravity forms ( gravity plugin needs to be >= 2.2.1.5 )

= 1.2.1 =
* Added shortcode support in header/footer
* Header text now it's used for alt image when using images
* Fixed bug where image was not responsive on mobile devices

= 1.2 =
* Added custom css support on template section
* Added link color in body section
* Updated templates with changes above
* Mailgun / sengrid integration

= 1.1.4 =

* Added body size to template section
* Leaving emtpty from name & from email will let you use other plugins settings now
* Logo alt text is now site description by default
* Removed other panels showing on email templates customizer
* Removed email templates panel from normal customizer

= 1.1.3.1 =
* Fixed woocommerce preview link

= 1.1.3 =
* Fixed bug with some links missing or not clickable
* Added more languages and updated some
* Added more action hooks for devs

= 1.1.2.1 =
* Remove "powered by" by default
* Updated languages

= 1.1.2 =
* Fixed bug with powered by still showing on some mail clients
* Added new languages

= 1.1.1 =
* Added Postman SMTP compatibility
* Added WP SMTP compatibility
* Added Easy WP SMTP compatibility
* Added Easy SMTP Mail compatibility

= 1.1 =
* Fixed bug with wpmandrill
* Added chinese, spanish and portuguese languages
* Added new font size control
* WooCommerce Integration
* Easy Digital Downloads Integration
* Added Email body settings

= 1.0.2 =

* Fixed email link on retrieve password emails from WP

= 1.0.1 =

* Bug - Template is cached to avoid issues when sending multiple emails
* Added fallback text email for non html email clients and to improve inbox hits
* Added site url to the logo/text logo in header
* Fixed some typos in descriptions
* Added Emails templates menu using add_submenu_page


= 1.0 =
* First release
