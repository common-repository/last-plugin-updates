<link href='<?php echo plugins_url("style.css", __FILE__); ?>' rel='stylesheet' type='text/css'>
<script src='<?php echo plugins_url("moment.min.js", __FILE__); ?>' type='text/javascript'></script>
<?php include( 'magic.js.php');?>

<div class='loading'><?php echo __('Loading...', 'lpu');?></div>
<div class='head no-display'><?php echo __('Sort by', 'lpu');?>:
  <a class='plugin-name' data-sort-by='.plugin-name'><?php echo __('Plugin Name', 'lpu');?></a> | <a class='last-update' data-sort-by='.last-update'><?php echo __('Last Update', 'lpu');?></a>
</div>
<div class='plugins no-display'></div>
