<?php
/**
 * Window Calculator
 *
 * @package           WindowCalculator
 * @author            Pavel Gutsol (tg: @pguczol)
 * @copyright         2020 Pavel Gutsol
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Window Calculator
 * Plugin URI:        https://github.com/pguczol23/window-clc
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Pavel Gutsol (tg: @pguczol)
 * Author URI:        https://github.com/pguczol23/
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

function window_clc_setup_post_type_() {

}
add_action( 'init', 'window_clc_setup_post_type_' );


function window_clc_activate_() {
    global $wpdb;
    global $jal_db_version;

    $charset_collate = $wpdb->get_charset_collate();

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $table_name = $wpdb->prefix . "window_clc";
    $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		type tinyint(9) NOT NULL,
		pod_value tinytext NOT NULL,
		mon_value tinytext NOT NULL,
		option_name tinytext NOT NULL,
		option_value tinytext NOT NULL,
		main_image_id mediumint(9) NULL,
		image_id mediumint(9) NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
    dbDelta( $sql );

    $wpdb->insert($table_name, [
        'type' => 1,
        'option_name' => 'Глухое 700*1400',
        'option_value' => 2907,
        'pod_value' => 360,
        'mon_value' => 1200,
    ]);
    $wpdb->insert($table_name, [
        'type' => 2,
        'option_name' => 'Глухое 700*1400',
        'option_value' => 2537,
        'pod_value' => 360,
        'mon_value' => 1200,
    ]);

    $wpdb->insert($table_name, [
        'type' => 1,
        'option_name' => 'Одностворчатое 700*1400',
        'option_value' => 4751,
        'pod_value' => 360,
        'mon_value' => 1200,
    ]);
    $wpdb->insert($table_name, [
        'type' => 2,
        'option_name' => 'Одностворчатое 700*1400',
        'option_value' => 4359,
        'pod_value' => 360,
        'mon_value' => 1200,
    ]);

    $wpdb->insert($table_name, [
        'type' => 1,
        'option_name' => 'Двухстворчатое 1300*1400',
        'option_value' => 7113,
        'pod_value' => 600,
        'mon_value' => 1600,
    ]);
    $wpdb->insert($table_name, [
        'type' => 2,
        'option_name' => 'Двухстворчатое 1300*1400',
        'option_value' => 6434,
        'pod_value' => 600,
        'mon_value' => 1600,
    ]);

    $wpdb->insert($table_name, [
        'type' => 1,
        'option_name' => 'Трехстворчатое 2100*1400',
        'option_value' => 10210,
        'pod_value' => 900,
        'mon_value' => 1800,
    ]);
    $wpdb->insert($table_name, [
        'type' => 2,
        'option_name' => 'Трехстворчатое 2100*1400',
        'option_value' => 9206,
        'pod_value' => 900,
        'mon_value' => 1800,
    ]);

    $wpdb->insert($table_name, [
        'type' => 1,
        'option_name' => 'Балконный блок. Окно 1300*1400. Дверь 700*200',
        'option_value' => 11433,
        'pod_value' => 900,
        'mon_value' => 2000,
    ]);
    $wpdb->insert($table_name, [
        'type' => 2,
        'option_name' => 'Балконный блок. Окно 1300*1400. Дверь 700*200',
        'option_value' => 10209,
        'pod_value' => 900,
        'mon_value' => 2000,
    ]);

    add_option( 'jal_db_version', $jal_db_version );
}
register_activation_hook( __FILE__, 'window_clc_activate_' );


function window_clc_deactivate_() {
    global $wpdb;

    $table_name = $wpdb->prefix . "window_clc";

    $wpdb->query("DROP TABLE $table_name");
}
register_deactivation_hook( __FILE__, 'window_clc_deactivate_' );

define( 'WINDOW_CLC__NAME', "window-clc");
define( 'WINDOW_CLC__PLUGIN_DIR', plugin_dir_path( __FILE__ ));

//add_action( 'init', array( 'WindowCalculator', 'init' ) );

if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
    require_once( WINDOW_CLC__PLUGIN_DIR . 'class.window-clc-admin.php' );
    add_action( 'init', array( 'WindowClc_Admin', 'init' ) );
}

add_action( 'admin_enqueue_scripts', 'window_clc_include_js' );
function window_clc_include_js() {
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
    wp_enqueue_script( 'window_clc_include_js',plugins_url( WINDOW_CLC__NAME . "/inc/admin_.js", WINDOW_CLC__PLUGIN_DIR ), array( 'jquery' ) );
}