=== Plugin Name ===
Contributors: hilflo
Tags: software, list, pad file
Requires at least: 3.4.1
Tested up to: 3.4
Stable tag: 1.02
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create article about software directly from pad file

== Description ==

This plugin make possible to create article about software with only a [pad file](http://pad.asp-software.org/) which is a xml file containing all data about a software.
You have just to enter a pad file url and the plugin grab all data needed to create an article whith :
*Long Description as post content
*short description as excerpt
*Software name as title
*software version
*Price
*OS supported
*Language supported
*Download url
*Order url
*Name and url to software editor
*Screenshot
*Earn money with regnow affiliate system

With this you have a special template if the post is a software post, rich snippet for software application enabled, a Top download widget

You can see a demo of a sofwtare post [here](http://www.allsoft.fr/spynomore-08-765/ "pad_article demo")

== Installation ==


1. Upload `pad_article` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Replace `<?php the_content; ?>` 
by 
<?php if(get_post_meta($id,'PAD_a_is_software',true) && get_post_meta($id,'PAD_a_is_software',true) == 1){ ?>
	<?php echo PAD_a_post_template($id); ?>
	<?php } else { ?>
		<?php the_content(); ?>
	<?php } ?>
in single.php

== Frequently Asked Questions ==


== Screenshots ==


== Changelog ==

1.01 Adding regnow affiliate system


== Upgrade Notice ==



== Arbitrary section ==


== A brief Markdown Example ==

