<?php
/**
 * BBPress actions
 *
 * @package Omega
 * @subpackage BBPress
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.14.0
 */

define('OXY_BBPRESS_DIR', OXY_THEME_DIR . 'bbpress/');
define('OXY_BBPRESS_URI', OXY_THEME_URI . 'bbpress/');

abstract class OxygennaBBPress
{
    protected $options_file = null;
    protected function __construct($options_file)
    {
        $this->options_file = $options_file;
        // register a bbpress sidebar
        add_action('widgets_init', array(&$this, 'widgets_init'));

        if (is_admin()) {
            add_action('init', array(&$this, 'init'));
        } else {
            // make sure bbpress doesnt load stylesheets
            add_filter('bbp_default_styles', array(&$this, 'deregister_default_styles'), 10, 1);

            // load our stylesheets
            add_action('bbp_enqueue_scripts', array(&$this, 'bbp_enqueue_scripts'), 15);

            // fix breadcrumbs to use bootstrap
            add_filter('bbp_after_get_breadcrumb_parse_args', array(&$this, 'bootstrap_breadcrumbs'), 10, 1);

            // fix subscription link to use bootstrap button
            add_filter('bbp_get_forum_subscribe_link', array(&$this, 'bbp_get_forum_subscribe_link'), 10, 2);
            add_filter('bbp_get_topic_subscribe_link', array(&$this, 'bbp_get_forum_subscribe_link'), 10, 2);

            // fix favourite link to use bootstrap button
            add_filter('bbp_get_user_favorites_link', array(&$this, 'bbp_get_user_favorites_link'), 10, 2);

            // bootstrap description messages
            add_filter('bbp_after_get_single_forum_description_parse_args', array(&$this, 'bootstrap_info_alerts'), 10, 1);
            add_filter('bbp_after_get_single_topic_description_parse_args', array(&$this, 'bootstrap_info_alerts'), 10, 1);

            // bootstrap select boxes
            add_filter('bbp_get_dropdown', array(&$this, 'bbp_get_dropdown'), 10, 2);
            add_filter('bbp_get_form_topic_type_dropdown', array(&$this, 'bbp_get_form_topic_type_dropdown'), 10, 2);
            add_filter('bbp_get_form_topic_status_dropdown', array(&$this, 'bbp_get_form_topic_type_dropdown'), 10, 2);

            // add button class to links in reply footer
            add_filter('bbp_topic_admin_links', array(&$this, 'bbp_topic_admin_links'), 10, 2);
            add_filter('bbp_reply_admin_links', array(&$this, 'bbp_topic_admin_links'), 10, 2);

            // change pagination to return array
            add_filter('bbp_topic_pagination', array(&$this, 'pagination_to_array'), 10, 1);
            add_filter('bbp_replies_pagination', array(&$this, 'pagination_to_array'), 10, 1);
            add_filter('bbp_search_results_pagination', array(&$this, 'pagination_to_array'), 10, 1);
            // then style pagination
            add_filter('bbp_get_forum_pagination_links', array(&$this, 'format_pagination_links'), 10, 1);
            add_filter('bbp_get_topic_pagination_links', array(&$this, 'format_pagination_links'), 10, 1);
            add_filter('bbp_get_search_pagination_links', array(&$this, 'format_pagination_links'), 10, 1);

            // style tag list
            add_filter('bbp_after_get_topic_tag_list_parse_args', array(&$this, 'bootstrap_style_tags'), 10, 1);

            // theme styling hooks
            add_filter('oxy-bbpress-global-top', array(&$this, 'global_page_top_section'), 10, 1);
            add_filter('oxy-bbpress-global-bottom', array(&$this, 'global_page_bottom_section'), 10, 1);

            // add header - higher priority means it will go above section ^
            add_filter('oxy-bbpress-global-top', array(&$this, 'global_page_header'), 5, 1);
        }
    }

    public function init()
    {
        include $this->options_file;
    }

    public function widgets_init()
    {
        global $oxy_theme;
        $oxy_theme->register_sidebar('BBPress Sidebar', 'Used on all BBPress Pages', '', 'bbpress-sidebar');
    }

    public function deregister_default_styles($styles)
    {
        return array();
    }

    public function bbp_enqueue_scripts()
    {
        wp_enqueue_style('oxy-bbpress', OXY_BBPRESS_URI . 'assets/css/bbpress.css');
    }

    public function bootstrap_breadcrumbs($args)
    {
        $args['before'] = '<ol class="breadcrumb">';
        $args['after'] = '</ol>';
        $args['crumb_before'] = '<li>';
        $args['crumb_after'] = '</li>';
        $args['sep'] = '<span></span>';
        return $args;
    }

    public function bbp_get_forum_subscribe_link($retval, $r)
    {
        return str_replace('class="subscription-toggle"', 'class="subscription-toggle btn btn-primary btn-xs pull-right"', $retval);
    }

    public function bbp_get_user_favorites_link($retval, $r)
    {
        return str_replace('class="favorite-toggle"', 'class="favorite-toggle btn btn-primary btn-xs pull-right"', $retval);
    }

    public function bootstrap_info_alerts($args)
    {
        // replace before and after with bootstrap
        $args['before'] = '<div class="alert alert-info">';
        $args['after']  = '</div>';

        return $args;
    }

    public function bbp_get_dropdown($retval, $r)
    {
        $retval = str_replace('<select', '<select class="form-control"', $retval);
        return $retval;
    }

    public function bbp_get_form_topic_type_dropdown($retval, $r)
    {
        $retval = str_replace('<select', '<select class="form-control"', $retval);
        return $retval;
    }

    public function bbp_topic_admin_links($links, $id)
    {
        foreach ($links as &$link) {
            $link = str_replace('class="', 'class="btn btn-primary btn-xs ', $link);
        }
        return $links;
    }

    public function pagination_to_array($args)
    {
        $args['type']  = 'array';
        return $args;
    }

    public function format_pagination_links($pagination_links)
    {
        if (!empty($pagination_links)) {
            $retval = '<ul class="pagination">';
            foreach ($pagination_links as $link) {
                $li_class = strpos($link, 'href') === false ? 'disabled' : 'active';
                $retval .= '<li class="' . $li_class . '">' . $link . '</li>';
            }
            $retval .= '</ul>';
            return $retval;
        }
    }

    public function global_page_top_section()
    {
        bbp_get_template_part( '/partials/global-bbpress/global-page-top', oxy_get_option('bbpress_style'));
    }

    public function global_page_bottom_section()
    {
        bbp_get_template_part('/partials/global-bbpress/global-page-bottom', oxy_get_option('bbpress_style'));
    }

    abstract public function global_page_header();


    public function bootstrap_style_tags($args)
    {
        $args['before'] = '<div class="bbp-topic-tags"><p><small>' . esc_html__('Tagged', 'omega-td') . '</small>';

        return $args;
    }

    protected function get_page_header_title()
    {
        global $oxy_theme_options;
        if (bbp_is_forum_archive()) {
            return $oxy_theme_options['bbpress_header_forums'];
        } else if (bbp_is_topic_archive()) {
            return $oxy_theme_options['bbpress_header_topics'];
        } else if (bbp_is_single_view()) {
            return bbp_get_view_title();
        } else if (bbp_is_single_forum()) {
            return bbp_get_forum_title();
        } else if (bbp_is_single_topic()) {
            return bbp_get_topic_title();
        } else if (bbp_is_topic_tag()) {
            return __('Tag: ', 'omega-td') . bbp_get_topic_tag_name();
        } else if (bbp_is_single_reply()) {
            return bbp_get_reply_title();
        } else if (bbp_is_topic_tag_edit()) {
            return __('Edit', 'omega-td');
        } else if (bbp_is_search()) {
            return bbp_get_search_title();
        } else if (bbp_is_single_user()) {
            return bbp_get_displayed_user_field('display_name');
        } else {
            return get_the_title();
        }
    }
}
