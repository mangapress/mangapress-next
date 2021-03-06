<?php
/**
 * MangaPress_Options class. Controls registering, fields, and sanitizing routines for
 * plugin options
 *
 * @package MangaPress_Next\MangaPress_Options
 * @author Jess Green <jgreen at psy-dreamer.com>
 * @version $Id$
 * @license GPL
 */
final class MangaPress_Options
{
    const OPTIONS_GROUP_NAME = 'mangapress_options';

    /**
     * Get default options
     * @return array
     */
    public static function get_default_options()
    {
        $options = self::options_fields();
        $defaults = [];
        foreach ($options as $section => $section_params) {
            $defaults[$section] = [];
            foreach ($section_params['fields'] as $option_name => $option_params) {
                if (!isset($option_params['default'])) continue;
                $defaults[$section][$option_name] = $option_params['default'];
            }
        }

        return $defaults;
    }


    /**
     * MangaPress_Options constructor.
     */
    public function __construct()
    {
        add_action('admin_init', array(__CLASS__, 'admin_init'));
    }


    /**
     * Initialize options
     */
    public static function admin_init()
    {
        if (defined('DOING_AJAX') && DOING_AJAX)
            return;

        register_setting(
            self::OPTIONS_GROUP_NAME,
            self::OPTIONS_GROUP_NAME,
            array(__CLASS__, 'sanitize_options')
        );

        self::register_sections();
        self::register_fields();
    }


    /**
     * Register option sections
     */
    private static function register_sections()
    {
        $sections = self::options_sections();

        foreach ($sections as $section => $params) {
            add_settings_section(
                self::OPTIONS_GROUP_NAME . "-{$section}",
                $params['title'],
                array(__CLASS__, 'section_output_cb'),
                self::OPTIONS_GROUP_NAME . "-{$section}"
            );
        }
    }

    private static function register_fields()
    {
        $field_sections = self::options_fields();

        foreach ($field_sections as $section => $section_params) {
            foreach ($section_params['fields'] as $field_name => $field_params) {
                add_settings_field(
                    "{$section}-options-{$field_params['id']}",
                    $field_params['title'],
                    $field_params['callback'],
                    "mangapress_options-{$section}",
                    "mangapress_options-{$section}",
                    array_merge(array('name' => $field_name, 'section' => $section), $field_params)
                );
            }
        }
    }


    /**
     * Output settings section
     * @param array $params Parameters passed from add_settings_section
     */
    public static function section_output_cb($params)
    {
        $section_id = explode('-', $params['id'])[1];
        $sections = self::options_sections();

        echo "<p>{$sections[$section_id]['description']}</p>";
    }


    /**
     * Helper function for creating default options fields.
     *
     * @return array
     */
    public static function options_fields()
    {
        /*
         * Section
         *      |_ Option
         *              |_ Option Setting
         */
        $options = array(
            'basic' => array(
                'title'       => __('Basic Options', MP_DOMAIN),
                'description' => __('This section sets the &ldquo;Latest-&rdquo; and &ldquo;Comic Archive&rdquo; pages, number of comics per page, and grouping comics together by category.', MP_DOMAIN),
                'fields' => [
                    'group_comics'      => array(
                        'id'    => 'group-comics',
                        'type'  => 'checkbox',
                        'title' => __('Group Comics', MP_DOMAIN),
                        'valid' => 'boolean',
                        'description' => __('Group comics by category. This option will ignore the parent category, and group according to the child-category.', MP_DOMAIN),
                        'default' => false,
                        'callback' => array(__CLASS__, 'settings_field_cb'),
                    ),
                    'group_by_parent'      => array(
                        'id'    => 'group-by-parent',
                        'type'  => 'checkbox',
                        'title' => __('Use Parent Category', MP_DOMAIN),
                        'valid' => 'boolean',
                        'description' => __('Group comics by top-most parent category. Use this option if you have sub-categories but want your navigation to function using the parent category.', MP_DOMAIN),
                        'default'     => false,
                        'callback'    => array(__CLASS__, 'settings_field_cb'),
                    ),
                    'latestcomic_page'  => array(
                        'id'    => 'latest-comic-page',
                        'type'  => 'select',
                        'title' => __('Latest Comic Page', MP_DOMAIN),
                        'value' => array(
                            'no_val' => __('Select a Page', MP_DOMAIN),
                        ),
                        'valid' => 'array',
                        'default'  => 0,
                        'callback' => array(__CLASS__, 'basic_page_dropdowns_cb'),
                    ),
                    'comicarchive_page' => array(
                        'id'    => 'archive-page',
                        'type'  => 'select',
                        'title' => __('Comic Archive Page', MP_DOMAIN),
                        'value' => array(
                            'no_val' => __('Select a Page', MP_DOMAIN),
                        ),
                        'valid' => 'array',
                        'default' => 0,
                        'callback' => array(__CLASS__, 'basic_page_dropdowns_cb'),
                    ),
                ]
            ),
            'comic_page' => array(
                'title'       => __('Comic Page Options', MP_DOMAIN),
                'description' => __('Handles image sizing options for comic pages. Thumbnail support may need to be enabled for some features to work properly. If page- or thumbnail sizes are changed, then a plugin such as Regenerate Thumbnails may be used to create the new thumbnails.', MP_DOMAIN),
                'fields' => [
                    'generate_comic_page' => array(
                        'id'    => 'generate-page',
                        'type'  => 'checkbox',
                        'title'       => __('Generate Comic Page', MP_DOMAIN),
                        'description' => __('Generate a comic page based on values below.', MP_DOMAIN),
                        'valid'       => 'boolean',
                        'default'     => 1,
                        'callback' => array(__CLASS__, 'settings_field_cb'),
                    ),
                    'comic_page_width'    => array(
                        'id'    => 'page-width',
                        'type'  => 'text',
                        'title'   => __('Comic Page Width', MP_DOMAIN),
                        'valid'   => '/[0-9]/',
                        'default' => 600,
                        'callback' => array(__CLASS__, 'settings_field_cb'),
                    ),
                    'comic_page_height'   => array(
                        'id'    => 'page-height',
                        'type'  => 'text',
                        'title'   => __('Comic Page Height', MP_DOMAIN),
                        'valid'   => '/[0-9]/',
                        'default' => 1000,
                        'callback' => array(__CLASS__, 'settings_field_cb'),
                    ),
                ]
            ),
            'nav' => array(
                'title'       => __('Navigation Options', MP_DOMAIN),
                'description' => __('Options for comic navigation. Whether to have navigation automatically inserted on comic pages, or to enable/disable default comic navigation CSS.', MP_DOMAIN),
                'fields' => [
                    'nav_css'    => array(
                        'id'     => 'navigation-css',
                        'title'  => __('Navigation CSS', MP_DOMAIN),
                        'description' => __('Defaults to Custom CSS. Use Default CSS if you do not wish to create a child-theme.', MP_DOMAIN),
                        'type'   => 'select',
                        'value'  => array(
                            'custom_css' => __('Custom CSS', MP_DOMAIN),
                            'default_css' => __('Default CSS', MP_DOMAIN),
                        ),
                        'valid'   => 'array',
                        'default' => 'custom_css',
                        'callback' => array(__CLASS__, 'settings_field_cb'),
                    ),
                    'display_css' => array(
                        'id'       => 'display',
                        'title'    => false,
                        'callback' => array(__CLASS__, 'navigation_css_display_cb'),
                    )
                ],
            ),
        );

        /**
         * mangapress_options_fields
         * This filter modify Manga+Press' option fields
         *
         * @param array $options Manga+Press options array to be modified
         * @return array
         */
        return apply_filters('mangapress_options_fields', $options);
    }


    /**
     * Helper function for setting default options sections.
     *
     * @return array
     */
    public static function options_sections()
    {
        $sections = [];
        $options = self::options_fields();
        foreach ($options as $section => $section_params) {
            $sections[$section] = [
                'title' => $section_params['title'],
                'description' => $section_params['description'],
            ];
        }

        /**
         * mangapress_options_sections
         * This filter modify Manga+Press' option sections
         *
         * @param array $sections Manga+Press sections array to be modified
         * @return array
         */
        return apply_filters('mangapress_options_sections', $sections);
    }


    /**
     * Outputs a settings field
     * @param array $params Parameters used to output field
     */
    public static function settings_field_cb($params)
    {
        $type = $params['type'];
        $callback = "MangaPress\Fields\\{$type}_field_cb";

        if (function_exists($callback)) {
            $callback($params);
        }
    }


    public static function navigation_css_display_cb()
    {

    }


    public static function basic_page_dropdowns_cb($params)
    {
        $description = \MangaPress\Fields\output_description($params);
        $pages = get_posts(['post_type' => 'page', 'post_status' => 'publish']);
        $select = "<select>\r\n";
        $select .= "\t<option value='{" . key($params['value']) . "}'>{$params['value']['no_val']}</option>\r\n";
        foreach ($pages as $page) {
            // TODO sanitize post_name and post_title
            $select .= "\t<option value='{$page->post_name}'>{$page->post_title}</option>\r\n";
        }
        $select .= "</select>\r\n";

        echo $select . $description;
    }


    /**
     * Sanitize options before saving to database
     *
     * @param array $options Array of options to be sanitized
     * @return array
     */
    public static function sanitize_options($options)
    {
        return $options;
    }
}