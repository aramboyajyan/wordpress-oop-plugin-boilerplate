<!-- #boilerplate-sample-widget -->
<div id="boilerplate-sample-widget">

  <?php if (isset($title)): ?>
    <?php print $before_title . $title . $after_title; ?>
  <?php endif; ?>

  <?php if (isset($message)): ?>
    <p><?php print $message; ?></p>
  <?php endif; ?>

</div>
<!-- /#boilerplate-sample-widget -->
