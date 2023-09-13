<?php
/*
 * Plugin Name:       Dash Board Widget
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rezwanul Haque
 * Author URI:        https://author.example.com/
 * Text Domain:      dash-board-widget
 */
if (!defined('ABSPATH')) {
   exit;
}

//? adding widget
add_action('wp_dashboard_setup', 'add_demo_widget');
function add_demo_widget()
{
   if (current_user_can('edit_dashboard')) {
      wp_add_dashboard_widget('rez_demo_widget', 'Dashboard Widget Demo By Rez', 'rez_demo_widget_output_callback', 'rez_demo_widget_configure_callback');
   } else {
      wp_add_dashboard_widget('rez_demo_widget', 'Dashboard Widget Demo By Rez', 'rez_demo_widget_output_callback');
   }
}

//? adding callback
function rez_demo_widget_output_callback()
{
   $number_of_posts = get_option('rez_demo_widget_nop', 5);
   $feeds = array(
      [
         'url' => 'http://localhost/addon_elementor/feed/',
         'items' =>  $number_of_posts,
         'show_summary' => 0,
         'show_author' => 0,
         'show_date' => 1
      ]
   );
   wp_dashboard_primary_output('rez_demo_widget', $feeds);
}

//? adding configure
function rez_demo_widget_configure_callback()
{
   $number_of_posts = get_option('rez_demo_widget_nop', 5);
   if (isset($_POST['dashboard-widget-nonce']) && wp_verify_nonce($_POST['dashboard-widget-nonce'], 'edit-dashboard-widget_rez_demo_widget')) {
      if (isset($_POST['rez_dbw_name']) && ($_POST['rez_dbw_name']) > 0) {
         $number_of_posts = sanitize_text_field($_POST['rez_dbw_name']);
         update_option("rez_demo_widget_nop", $number_of_posts);
      }
   }

?>
   <label>Number of Posts</label>
   <input type="text" name="rez_dbw_name" class="widefat" id="rez_dbw_name" value="<?php esc_attr_e($number_of_posts); ?>">
<?php
}
