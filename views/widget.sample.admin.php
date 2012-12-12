<!-- #boilerplate-sample-widget-admin -->
<div id="boilerplate-sample-widget-admin" class="boilerplate-widget-wrapper">
  <p>
    <label for="<?php print $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
    <br/>
    <input type="text" class="widefat" value="<?php print esc_attr($instance['title']); ?>" id="<?php print $this->get_field_id('title'); ?>" name="<?php print $this->get_field_name('title'); ?>" />
  </p>
  <p>
    <label for="<?php print $this->get_field_id('message'); ?>"><?php _e('Message:'); ?></label>
    <br/>
    <textarea class="widefat" id="<?php print $this->get_field_name('message'); ?>" name="<?php print $this->get_field_name('message'); ?>"><?php print esc_attr($instance['message']); ?></textarea>
    <span class="boilerplate-widget-desc"><?php _e('Sample field description.'); ?></span>
  </p>
</div>
<!-- /#boilerplate-sample-widget-admin -->
