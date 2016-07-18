<?php
/*
Plugin Name: Post Populator
Plugin URI: http://www.autcsa.org.nz/
Description: Populate posts for testing purpose.
Version: 1.0.1
Author: Chad
Author URI: http://www.chadhao.com/
License: GPLv2 or later
*/

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

register_activation_hook( __FILE__, 'pp_activation' );
register_deactivation_hook( __FILE__, 'pp_deactivation' );

add_action( 'init', 'pp_init' );

function pp_activation() {

}

function pp_deactivation() {

}

function pp_init() {
	add_action( 'admin_menu', 'pp_load_menu' );
}

function pp_load_menu() {
	add_plugins_page( 'Post Populator', 'Populator', 'install_plugins', 'post_populator', 'pp_page');
}

function pp_message( $type, $msg ) {
	if ( $type == 'error' ) {
		echo '<div class="error"><p>' . $msg . '</p></div>';
	} else {
		echo '<div class="updated"><p>' . $msg . '</p></div>';
	}
}

function pp_display_message( $type, $msg ) {
	add_action( 'admin_notice', 'pp_message', 10, 2 );
	do_action( 'admin_notice', $type, $msg);
}

function pp_page() {

	if ( isset($_POST['post_amount']) ) {
		if ( intval( $_POST['post_amount'] ) < 1 ) {
			pp_display_message( 'error', 'Invalid amount!' );
		} else {
			$start_time = microtime(true);
			pp_populate( intval( $_POST['post_category'] ), intval( $_POST['post_amount'] ) );
			$end_time = microtime(true) - $start_time;
			pp_display_message( 'updated', 'Random posts populated! Exec time: ' . $end_time . 's.');
		}
	}

	$all_terms = get_terms( 'category', 'orderby=id&hide_empty=0' );
	echo '
		<div class="wrap">
		<h1>Post Populator</h1>
		<form name="pp_populator" id="pp_populator" method="post" action="' . esc_url( add_query_arg( array( 'page' => 'post_populator' ), admin_url( 'admin.php' ) ) ) . '">
		<table class="form-table">
		<tr><th scope="row"><label for="post_category">Cetegory</label></th>
		<td>
		<select name="post_category" id="post_category">
	';
	foreach ( $all_terms as $term ) {
		echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
	}
	echo '
		</select>
		</td>
		</tr>
		<tr><th scope="row"><label for="post_amount">Amount</label></th>
		<td><input name="post_amount" type="text" id="post_amount" value="0" class="regular-text" /></td>
		</tr>
		</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Populate!"  /></p>
		</form>
		</div>
	';
}

function pp_random_part( $len ) {
	$chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$result = '';
	for ($i = 0; $i < $len; $i++) {
		$result .= $chars[mt_rand(0, 61)];
	}
	return $result;
}

function pp_populate( $cat, $amount ) {
	for ($i = 0; $i < $amount; $i++) {
		$rand_post = pp_random_part(10) . '-' . pp_random_part(10) . '-' . pp_random_part(10);
		$post = array(
			'post_content'   => $rand_post,
			'post_name'      => $rand_post,
			'post_title'     => $rand_post,
			'post_status'    => 'publish',
			'ping_status'    => 'open',
			'post_category'  => array($cat)
		);
		wp_insert_post( $post );
	}
}

?>
