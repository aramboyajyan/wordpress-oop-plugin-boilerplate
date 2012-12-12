<?php

/**
 * @file
 * Birthday notification widget class.
 *
 * Created by: Topsitemakers
 * http://www.topsitemakers.com/
 */

class Boilerplate_Sample_Widget extends WP_Widget {
  
  /**
   * Define the widget.
   */
  function __construct() {
    $this->WP_Widget('boilerplate-sample-widget', __('Sample Widget'), array(
      'classname' => 'boilerplate-sample-widget',
      'description' => __('Widget placeholder.'),
    ), array(
      'width' => 300,
      'height' => 350,
      'id_base' => 'boilerplate-sample-widget',
    ));
  }

  /**
   * Render the widget.
   */
  public function widget($args, $instance) {
    // Get everything as separate variables.
    extract($args);
    // Output any additional markup before the widget.
    print $before_widget;
    // Prepare the variables used in the widget.
    $title = apply_filters('widget_title', empty($instance['title']) ? __('Widget Name') : $instance['title'], $instance, $this->id_base);
    $message = $instance['message'];
    include(plugin_dir_path(__FILE__) . '/../views/widget.sample.php');
    // Output any additional markup after the widget.
    print $after_widget;
  }

  /**
   * Update widget settings.
   */
  public function update($new_instance, $old_instance){ 
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['message'] = strip_tags($new_instance['message']);
    return $instance;
  }

  /**
   * Display widget admin settings form.
   */
  public function form($instance) {
    $instance = wp_parse_args((array) $instance, array(
      'title' => __('Default Widget Title'),
      'message' => __('Default widget message.'),
    ));
    // Display the admin form.
    include(plugin_dir_path(__FILE__) . '/../views/widget.sample.admin.php');  
  }

}
