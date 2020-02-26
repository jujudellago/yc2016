<?php
/**
 * One Click Installer
 *
 * @package One Click Installer
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 * @author Oxygenna.com
 */

class OxygennaPackageInstall
{
    public $id;
    private $maps;
    private $install_runs;
    private $current_run;
    private $current_item_log;
    private $installed_items;

    public static function instance($id)
    {
        $instance = get_option($id, null);
        if (null === $instance) {
            $instance = new self($id);
        }
        return $instance;
    }

    public function __construct($id)
    {
        $this->id = $id;
        $this->install_runs = array();
        $this->maps = array();
        $this->current_run = null;
        $this->current_item_log = null;
        $this->installed_items = array();
    }

    public function save()
    {
        update_option($this->id, $this);
    }

    public function start_install_run()
    {
        $this->current_run = new stdClass();
        $this->current_run->id = uniqid();
        $this->current_run->log = array();

        $this->save();

        return $this->current_run;
    }

    public function end_install_run()
    {
        if (null !== $this->current_run) {
            // create run results
            $results = new stdClass();
            $results->counts = array(
                OXY_IMPORT_EXISTS => 0,
                OXY_IMPORT_OK => 0,
                OXY_IMPORT_FAIL => 0
            );
            $results->list = array();

            // count results
            foreach ($this->current_run->log as $log) {
                switch($log->status) {
                    case OXY_IMPORT_OK:
                        $log->class = 'ok';
                        $log->icon = 'yes';
                        break;
                    case OXY_IMPORT_EXISTS:
                        $log->class = 'warning';
                        $log->icon = 'minus';
                        break;
                    case OXY_IMPORT_FAIL:
                        $log->class = 'fail';
                        $log->icon = 'no';
                        break;
                }
                $results->list[] = $log;
                $results->counts[$log->status]++;
            }

            $this->current_run->results = $results;
            $this->install_runs[] = $this->current_run;
            $this->current_run = null;

            $this->save();
        } else {
            $results = end($this->install_runs)->results;
        }

        return $results;
    }

    public function open_item_log($title, $type)
    {
        $this->current_item_log = new stdClass();
        $this->current_item_log->title = $title;
        $this->current_item_log->type = $type;
        $this->current_item_log->status = OXY_IMPORT_FAIL;
        $this->current_item_log->timestamp = time();
        $this->current_item_log->messages = array();
    }

    public function add_log_message($message)
    {
        $log_message = new stdClass();
        $log_message->message = $message;

        $this->current_item_log->messages[] = $log_message;
    }

    public function set_log_status($status)
    {
        $this->current_item_log->status = $status;
    }

    public function close_item_log()
    {
        $this->current_run->log[] = $this->current_item_log;
        $this->current_item_log = null;
        $this->save();
    }

    public function item_created($type, $id)
    {
        $new_item = new stdClass();
        $new_item->type = $type;
        $new_item->id = $id;

        $this->installed_items[] = $new_item;
    }

    public function get_installed_items()
    {
        return $this->installed_items;
    }

    public function add_to_map($map_name, $old_value, $new_value)
    {
        if (!isset($this->maps[$map_name])) {
            $this->maps[$map_name] = array();
        }

        if (is_int($new_value)) {
            $new_value = (int) $new_value;
        }

        $this->maps[$map_name][$old_value] = $new_value;

        return $this->maps;
    }

    public function lookup_map($map_name, $old_value)
    {
        if (isset($this->maps[$map_name]) && isset($this->maps[$map_name][$old_value])) {
            return $this->maps[$map_name][$old_value];
        } else {
            return false;
        }
    }

    public function get_install_package()
    {
        // get packages available from theme
        $packages = apply_filters('oxy_one_click_import_packages', array());
        $found_package = null;
        foreach ($packages as &$package_item) {
            if ($package_item['id'] === $this->id) {
                $found_package = $package_item;
            }
        }
        return $found_package;
    }

    public function remove_item($item)
    {
        $remove_success = false;
        switch($item->type) {
            case 'nav_menu':
                $remove_success = !is_wp_error(wp_delete_nav_menu($item->id));
                break;
            case 'nav_menu_item':
                // should be picked up by remove nav menu ^
                $remove_success = true;
                break;
            case 'attachment':
                $remove_success = wp_delete_attachment($item->id, true) !== false;
                break;
            case 'revslider':
                if (class_exists('RevSliderSlider')) {
                    $revslider = new RevSliderSlider();
                    $revslider->id = $item->id;
                    try {
                        $remove_success = $revslider->delete_slider();
                        $remove_success = true;
                    } catch (Exception $e) {
                        $remove_success = false;
                    }
                }
                break;
            case 'widget':
                // remove widget from sidebar
                $sidebars_widgets = get_option('sidebars_widgets');
                if (isset($sidebars_widgets[$item->id['widget_area']])) {
                    foreach ($sidebars_widgets[$item->id['widget_area']] as $count => $widget_id) {
                        if ($widget_id === $item->id['widget_id']) {
                            unset($sidebars_widgets[$item->id['widget_area']][$count]);
                        }
                    }
                }
                update_option('sidebars_widgets', $sidebars_widgets);
                // remove widget
                $widget_options = get_option('widget_' . $item->id['type']);
                unset($widget_options[$item->id['count']]);
                update_option('widget_' . $item->id['type'], $widget_options);
                $remove_success = true;
                break;
            default:
                $remove_success = wp_delete_post($item->id, true) !== false;
                break;
        }

        return $remove_success;
    }
}
