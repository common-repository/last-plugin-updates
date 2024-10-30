<?php
/*
Plugin Name: Last Plugin-Update
Plugin URI: http://wordpress.org/extend/plugins/last-plugin-updates/
Description: Shows a list of installed plugins and the date of their last update.
Version: 1.0.5
Author: Van Tien Bui
Author URI: http://tienbui.de
License: GPL2
*/


if ( is_admin() ) {
  load_plugin_textdomain('lpu', false, basename( dirname( __FILE__ ) ) . '/languages/' );

  add_action( 'wp_dashboard_setup', 'add_dashboard_lpu');

  function dashboard_output_lpu() {
    require plugin_dir_path(__FILE__).'magic.php';
  }

  function add_dashboard_lpu() {
    wp_add_dashboard_widget( 'dashboard_last_plugin_updates', __('Last Plugin-Updates', 'lpu'), 'dashboard_output_lpu', 'widget_control' );
  }

}

?>