=== wp-wave-shortcodes ===
Contributors: josh23french
Donate link: http://blog.jfrench.co.cc/
Tags: google, wave, social, shortcode
Requires at least: 2.7
Tested up to: 2.9
Stable tag: 1.1

Gives you a shortcode to embed a Wave in your WordPress page/post.

== Installation ==

1. Upload the `wp-wave-shortcodes` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[wave id=""]` in your posts/pages (see the FAQs for more options)

== Frequently Asked Questions ==

= Is there an easier way to embed a Wave? =
Kind of... There is a button to press above the edit box, but it still lets you change all of the options.

= What options does the shortcode support? =
The shortcode supports the id attribute which is required, plus the width and height of the div that it embeds, plus all of the options that are available to setUIConfig in the wave embed API.

Attributes:

*   id*(Required)*
*   width
*   height
*   bgcolor
*   color
*   font
*   fontsize

= What embedding waves from ______? =

Yeah. About that. I don't have an official Wave account yet, so how could I possibly begin to test with other Wave servers? No, but really - if you can get me an account on the Wave server you want to see supported(and preferably supports Google's embed API), send me an e-mail or something.

== Changelog ==

= 1.1 =
* Fixed some issues that make it impossible for anyone to embed anything...
* Fixed the media embed form

= 1.0 =
* Initial Release
