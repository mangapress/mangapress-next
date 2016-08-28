<?php
/**
 * @package Manga_Press_NEXT
 * @version $Id$
 * @author Jessica Green <jgreen@psy-dreamer.com>
 */
/*
 Plugin Name: Manga+Press NEXT Comic Manager
 Plugin URI: http://www.manga-press.com/
 Description: Turns WordPress into a full-featured Webcomic Manager. Be sure to visit <a href="http://www.manga-press.com/">Manga+Press</a> for more info.
 Version: 0.0.1
 Author: Jess Green
 Author URI: http://www.jesgreen.com
 Text Domain: mangapress-next
 Domain Path: /languages
*/
/*
 * (c) 2016 Jessica C Green
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

$plugin_folder = plugin_basename(dirname(__FILE__));

if (!defined('MP_VERSION'))
    define('MP_VERSION', '0.0.1');

if (!defined('MP_FOLDER'))
    define('MP_FOLDER', $plugin_folder);

if (!defined('MP_ABSPATH'))
    define('MP_ABSPATH', plugin_dir_path(__FILE__));

if (!defined('MP_URLPATH'))
    define('MP_URLPATH', plugin_dir_url(__FILE__));

if (!defined('MP_LANG'))
    define('MP_LANG', $plugin_folder . '/languages');

if (!defined('MP_DOMAIN'))
    define('MP_DOMAIN', 'mangapress');

require_once MP_ABSPATH . 'mangapress-options.php';
require_once MP_ABSPATH . 'mangapress-posts.php';
require_once MP_ABSPATH . 'mangapress-bootstrap.php';
require_once MP_ABSPATH . 'mangapress-install.php';

$install = MangaPress_Install::get_instance();

register_activation_hook(__FILE__, array($install, 'do_activate'));
register_deactivation_hook(__FILE__, array($install, 'do_deactivate'));
