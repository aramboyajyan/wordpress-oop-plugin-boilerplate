<?php

/**
 * @file
 * Boilerplate WordPress plugin.
 *
 * Created by: Topsitemakers
 * http://www.topsitemakers.com/
 */

/**
 * Plugin name: OOP Boilerplate
 * Author: Topsitemakers
 * Author URI: http://www.topsitemakers.com/
 * Description: Custom plugin boilerplate.
 * Version: 1.0
 *
 * Plugin and custom plugin framework created by Topsitemakers
 * http://www.topsitemakers.com/
 */

// Sanity check.
if (!defined('ABSPATH')) die('Direct access is not allowed.');

// Helper functions.
require dirname(__FILE__) . '/includes/helper-functions.php';

// Constant variables used in the plugin.
require dirname(__FILE__) . '/includes/constants.php';

// User list table class.
require dirname(__FILE__) . '/includes/class.user-list.php';

// Widgets.
require dirname(__FILE__) . '/includes/widget.sample.php';

/**
 * Main plugin class.
 */
class Boilerplate {

  // Plugin name; to be used throughout this class
  // Has to be the same as the plugin folder name.
  var $namespace = 'boilerplate';

  /**
   * Constructor.
   */
  function __construct() {
    // Localization.
    load_plugin_textdomain($this->namespace . '-locale', FALSE, dirname(plugin_basename(__FILE__)) . '/lang');
    // Actions.
    add_action('init', array(&$this, 'init'));
    add_action('admin_init', array(&$this, 'admin_init'));
    add_action('admin_menu', array(&$this, 'admin_menu'));
    add_action('wp_ajax_nopriv_boilerplate_ajax', array(&$this, 'ajax'));
    add_action('wp_ajax_boilerplate_ajax', array(&$this, 'ajax'));
    add_action($this->namespace . '_execute_cron', array(&$this, 'cron'));
    // Filters.
    add_filter('cron_schedules', array(&$this, 'cron_schedules'));
    // Registers.
    register_activation_hook(__FILE__, array(&$this, 'install'));
    // Shortcodes.
    add_shortcode('boilerplate', array(&$this, 'shortcode_boilerplate'));
    // Widgets.
    add_action('widgets_init', array(&$this, 'widgets'));
  }

  /**
   * Plugin installation.
   */
  public function install() {

    global $wpdb;
    
    // Define table names.
    $table_name_sample   = $wpdb->prefix . 'boilerplate_sample';
    
    // Check if the tables already exist.
    if ($wpdb->get_var("SHOW TABLES LIKE '" . $table_name_sample . "'") != $table_name_sample) {
      // Table SQL
      $table_sample = "CREATE TABLE " . $table_name_sample . "(
                        sid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        time INT NOT NULL,
                        text VARCHAR(8) NOT NULL);";
      
      // Get the upgrade PHP and create the tables.
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($table_sample);
    }
    
    // Setup default values of the variables.
    add_option(BOILERPLATE_SHORTNAME . 'sample_variable', '0');

  }

  /**
   * Front-end init.
   */
  public function init() {
    
    // Front-end styles.
    wp_enqueue_style($this->namespace . '-style', plugins_url($this->namespace . '/assets/css/front.css'));
    // Front-end scripts.
    wp_enqueue_script($this->namespace . '-script', plugins_url($this->namespace . '/assets/js/front.js'), array('jquery'));
    
    // Hook our cron.
    if (!wp_next_scheduled($this->namespace . '_execute_cron')) {
      wp_schedule_event(current_time('timestamp'), 'every_minute', $this->namespace . '_execute_cron');
    }

  }

  /**
   * Admin init.
   */
  public function admin_init() {

    // Admin styles.
    wp_enqueue_style($this->namespace . '-style-admin', plugins_url($this->namespace . '/assets/css/admin.css'));
    wp_enqueue_style('thickbox');
    // Admin scripts.
    wp_enqueue_script($this->namespace . '-script-admin', plugins_url($this->namespace . '/assets/js/admin.js'), array('jquery'));
    wp_enqueue_script('media-upload');

  }

  /**
   * Cron callback.
   */
  public function cron() {
    
    global $wpdb;

    // 

  }

  /**
   * Custom cron scheduled time.
   */
  public function cron_schedules() {

    return array(
      'every_minute' => array(
        'interval' => 60,
        'display' => __('Every minute'),
      ),
    );

  }

  /**
   * Define links for administrators.
   */
  public function admin_menu() {

    // Main settings page.
    add_menu_page(__('Boilerplate'), __('Boilerplate'), 'manage_options', $this->namespace . '/admin-pages/options.php');
    
    // Subpages.
    add_submenu_page($this->namespace . '/admin-pages/options.php', __('Options'), __('Options'), 'manage_options', $this->namespace . '/admin-pages/options.php');
    add_submenu_page($this->namespace . '/admin-pages/options.php', __('Subpage'), __('Subpage'), 'manage_options', $this->namespace . '/admin-pages/subpage.php');

  }

  /**
   * AJAX callback.
   */
  public function ajax() {
    
    // Check if the nonces match.
    if (!wp_verify_nonce($_POST['nonce'], $this->namespace . '-post-nonce')) die('Disallowed action.');

    // Check the operation.
    $op = filter_input(INPUT_POST, 'op', FILTER_SANITIZE_STRING);
    if (!$op) die('Disallowed operation.');

    // Perform the actions.
    global $wpdb;
    switch ($op) {

      // Sample AJAX callback action.
      case 'settings':
        break;

      // Default handler.
      default:
        die('Disallowed action.');
        break;

    }

    // Required by WP.
    exit;

  }

  /**
   * Register custom widgets.
   */
  public function widgets() {
    register_widget('Boilerplate_Sample_Widget');
  }

  /**
   * Custom shortcode.
   */
  public function shortcode_boilerplate($atts) {
    extract(shortcode_atts(array(
      'attribute' => 'value',
    ), $atts));
    return 'attribute = "' . $attribute . '"';
  }

}

// Initiate our plugin.
new Boilerplate();
