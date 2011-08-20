=== Jigoshop Custom Payment Gateway ===
Contributors: griffinjt
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JMZ2X8NK26X4N
Tags: jigoshop, cart, checkout, ecommerce, shop, payment, gateway
Requires at least: 3.2
Tested up to: 3.2.1

This plugin adds a simple custom payment gateway similar to the "Cheque" gateway that can be molded for your projects.

== Description ==

The "Cheque" payment gateway could actually be quite useful, but it is limiting because you cannot customize it. This plugin adds a new payment gateway similar to the "Cheque" payment gateway but with a bunch of filters for customization. You can customize any part of the text, the icon displayed beside the gateway on the Checkout page, the default order status when using this gateway, etc.

This plugin is useful if you need to do some sort of client billing or let the client handle the payment processing on their end. It has a business-t-business mindset.

= Available Filters =

The following is a list of available filters for you to use in your theme's functions.php file:

*tgm_jigoshop_custom_gateway_title
*tgm_jigoshop_custom_gateway_description
*tgm_jigshop_enable_custom_gateway_title
*tgm_jigoshop_method_tooltip_description
*tgm_jigoshop_method_tooltip_title
*tgm_jigoshop_message_tooltip_description
*tgm_jigoshop_message_tooltip_title
*tgm_jigoshop_order_update_status

There are also 2 action hooks that can be used: **tgm_jigoshop_payment_fields** and **tgm_jigoshop_thankyou_page**.

This plugin was created by [Thomas Griffin](http://thomasgriffinmedia.com/ "Thomas Griffin Media").

== Installation ==

1. Upload the `jigoshop-custom-payment-gateway` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to `Jigoshop > Settings > Payment Gateways` to see your new payment gateway.

== Changelog ==

= 1.0 =
* Initial release.