=== Manga+Press Comic Manager ===
Contributors: ArdathkSheyna
Donate link: http://www.manga-press.com/
Tags: webcomics, online comics
Requires at least: 4.7
Tested up to: 4.7
Stable tag: 0.0.1
License: GPLv2

Manga+Press NEXT is a webcomic management system for WordPress.

== Description ==

Manga+Press is a webcomic managment system for WordPress. Manga+Press uses WordPress posts, pages and categories to help you keep track of your comic posts. Manga+Press also includes its own custom template tags to help make creating themes easier.


== Changelog ==
= 0.0.1 =
   * 0.0.1
      * Initial development version


== Installation ==

1. Unpack the .zip file onto your hard drive.

2. Upload the `mangapress` folder to the `/wp-content/plugins/` directory.

3. Activate the plugin through the 'Plugins' menu in WordPress

4. Create two new pages; these pages will be your latest comic and comic archives pages. Label them something like 'Latest Comic'
and 'Past Comics' or whatever, as long as it makes sense to you.

6. Click on the Manga+Press Options tab under Settings and go to Basic Manga+Press Options, and set Latest Comic Page, and Comic
Archive Page to your two newly created pages.


== Frequently Asked Questions ==

*I'm using the bundled theme for TwentyEleven, -Twelve, or -Thirteen but the Custom CSS and/or Insert Navigation options have no effect? Or they add a second navigation bar*

This is because the navigation for the comics is built into the theme. Using a different theme or overriding the default theme's template will allow you to use the options. (however, see [issue #17](https://github.com/jesgs/mangapress/issues/17) for additional issues)

*Does Manga+Press work on WordPress Multi-site?*

Yes, it does. However, a few steps must be taken to make Manga+Press' child-themes available to your network. See the question below on the steps to take to enable the child-themes on Multisite.

*The bundled themes aren't available in WordPress Multi-site. What's going on?*

This is because the plugin hasn't been activated for the entire MS network. In order for the child-themes to be available, Manga+Press must be available to the entire network. This can be done by going to **Network Admin > Plugins** and clicking the _Network Activate_ link for Manga+Press. Once this is done, then both the parent- and child-themes need to made available to the network as well. This can be accomplished by going to **Network Admin > Themes**, selecting the themes in question, choosing **Bulk Actions > Network Enable**, and then clicking **Apply**.

*Is Manga+Press responsive?*

Not by itself. However, Manga+Press doesn't really output markup other than the comic navigation. Responsiveness depends on the theme that is being used. The themes bundled with Manga+Press — the TwentyEleven thru TwentyFourteen child-themes — all have some level of responsiveness that is dependent on their parent themes.

*Is Manga+Press compatible with Advanced Custom Fields*

Yes, it is! Manga+Press is simply a stripped down custom post-type with a custom Featured Image meta-box. Like any other post-type, you can add a new field group using ACF — however, you _will_ have to configure your theme to display these custom fields.

*Is Manga+Press compatible with the WPML plugin?*

I have never had the chance to test Manga+Press with the WPML plugin so I can't really guarantee compatibility. Since Manga+Press works like a standard WordPress post, and WPML _is_ compatible with custom post-types, this shouldn't be a problem.

*Do you take feature requests?*

I do take feature requests, but I also judge each request on the basis of how well the new feature fits into Manga+Press' current functionality and also how feasible the new feature is to implement into Manga+Press' core.


== Screenshots ==


== Credits ==

(c) Jessica C. Green

Found a bug? Or did you find a bug and figure out a fix? Visit http://www.manga-press.com/ or email me at support@manga-press.com. Please include screenshots, WordPress version, a list of any other plugins you might have installed, or code (if you figured out a fix). Be as detailed as possible.

For updates, you can visit http://www.manga-press.com/

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
