<?php

$widgets = get_option( 'dashboard_widget_options' );
$widget_id = 'dashboard_last_plugin_updates';

$plugins = get_plugins();
$slugs = get_slugs_odp( $plugins );

function get_slugs_odp( $plugins ) {
  $return = array();
  foreach ($plugins as $key => $val) {
    list ($t1, $t2) = explode('/', plugin_basename( $key ));
    array_push($return, $t1 );
  }
  return $return;
}

include('html.inc');

?>