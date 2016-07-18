<?php
//remove activity posts from default posts list
function activity_admin_post_filter($wp_query)
{
    if (is_admin()) {
        if (strpos($_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php') !== false) {
            if (is_plugin_active('activity/activity.php')) {
                $activity_cat = intval(get_option('activity_category'));
                $wp_query->set('cat', -$activity_cat);
            }
        }
    }
}

add_action('pre_get_posts', 'activity_admin_post_filter');

//check if an activity post is added correctly
function activity_admin_post_category_check($post_id, $post, $update)
{
    if (is_admin()) {
        if (is_plugin_active('activity/activity.php')) {
            $post_cat = wp_get_post_categories($post_id);
            if (empty($post_cat)) {
                return;
            } else {
                $activity_cat = intval(get_option('activity_category'));
                $is_post_activity = in_array($activity_cat, $post_cat);
                if ($is_post_activity) {
                    if (strpos($_SERVER[ 'REQUEST_URI' ], '/wp-admin/admin.php?page=activity_admin') === false) {
                        $post_cat = array_diff($post_cat, array($activity_cat));
                        if (empty($post_cat)) {
                            $post_cat = array(1);
                        }
                        $post_data = array(
                          'ID' => $post_id,
                          'post_category' => $post_cat,
                        );
                        $post_update = wp_update_post($post_data);
                        header('Location: '.get_site_url().'/wp-admin/admin.php?page=activity_admin&action=error_add_activity');
                        exit();
                    }
                }
            }
        }
    }
}

add_action('save_post', 'activity_admin_post_category_check', 10, 3);
