<?php
/*
Plugin Name: WW_Management
Plugin URI: http://465.co.nz/
Description: This is the Activity plugin developed specially for Wee Wisdom.
Version: 0.1
Author: Arris, Rick, Teddy, Chad
License: GPLv2
Text Domain: WW
*/

// This file should not be called directly
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define('WW_Management_URL', plugin_dir_url(__FILE__));
define('WW_Management_DIR', plugin_dir_path(__FILE__));

register_activation_hook(__FILE__, array('WW_Management', 'ww_activation'));
register_deactivation_hook(__FILE__, array('WW_Management', 'ww_deactivation'));

//require_once WW_Management_DIR.'class.ww.php';
//require_once ACTIVITY__PLUGIN_DIR.'class.activity-signup.php';
if(is_admin)
{
	require_once WW_Management_DIR.'class.ww.php';
	add_action('admin_menu', array('WW_Management', 'ww_load_menu'));
}
//add_action(array('WW_Management', 'ww_load_menu'));



// Code blow enables debug message output during plugin activation.
// add_action('activated_plugin', 'my_save_error');
// function my_save_error()
// {
//     file_put_contents(ACTIVITY__PLUGIN_DIR.'error_activation.html', ob_get_contents());
// }
