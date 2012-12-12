<?php

/**
 * @file
 * Sample page with a setup user list class.
 *
 * Created by: Topsitemakers
 * http://www.topsitemakers.com/
 */

// Create an instance of our user list class.
$user_table = new Boilerplate_List_Users();
// Fetch, prepare and sort.
$user_table->prepare_items();
?>
<div class="wrap">
  
  <div id="icon-users" class="icon32"><br></div>

  <h2><?php print __('User List Page'); ?></h2>
  <p><?php print __('Page description.'); ?></p>

  <!-- #boilerplate-users-table -->
  <form id="boilerplate-users-table" method="get">
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
    <?php $user_table->display() ?>
  </form>
  <!-- /#boilerplate-users-table -->

</div>
