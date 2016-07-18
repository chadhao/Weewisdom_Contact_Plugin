<?php

class Activity_Admin
{
    const NONCE = 'activity_admin_key';

    private static $activity_admin_initialed = false;

    public static function activity_admin_init()
    {
        if (!self::$activity_admin_initialed) {
            self::activity_admin_init_hooks();
        }
    }

    public static function activity_admin_init_hooks()
    {
        self::$activity_admin_initialed = true;
        add_action('admin_menu', array('Activity_Admin', 'activity_admin_load_menu'));
    }

    public static function activity_admin_load_menu()
    {
        add_menu_page('活动列表', '活动', 'edit_posts', 'activity_admin', array('Activity_Admin', 'activity_admin_page'), 'dashicons-carrot', 6);
        add_submenu_page('activity_admin', '活动列表', '活动列表', 'edit_posts', 'activity_admin', array('Activity_Admin', 'activity_admin_page'));
        add_submenu_page('activity_admin', '活动设置', '活动设置', 'edit_posts', 'activity_admin_setting', array('Activity_Admin', 'activity_admin_setting'));
    }

    public static function activity_admin_page()
    {
        if (isset($_GET['action']) || isset($_GET['signup_action'])) {
            if ($_GET['action'] == 'activity_admin_setting') {
                self::activity_admin_setting();
            } elseif ($_GET['action'] == 'activity_admin_delete_post') {
                self::activity_admin_delete_post();
            } elseif ($_GET['action'] == 'activity_admin_post') {
                self::activity_admin_post($_GET['post_action']);
            } elseif ($_GET['action'] == 'activity_admin_process_post') {
                self::activity_admin_process_post();
            } elseif ($_GET['action'] == 'error_add_activity') {
                self::error_add_activity();
            } elseif ($_GET['signup_action'] == 'view') {
                Activity_Signup::activity_signup_list();
            } elseif ($_GET['signup_action'] == 'delete') {
                Activity_Signup::activity_signup_delete();
            } elseif ($_GET['signup_action'] == 'edit') {
                Activity_Signup::activity_signup_detail();
            } elseif ($_GET['signup_action'] == 'add') {
                Activity_Signup::activity_signup_detail();
            } elseif ($_GET['signup_action'] == 'process') {
                Activity_Signup::activity_signup_process_signup();
            }
        } else {
            self::activity_admin_display_activity();
        }
    }

    public static function activity_admin_get_url($action, $post_id = 0, $signup_id = 0)
    {
        if ($action == 'activity_admin_delete_post') {
            $args = array('page' => 'activity_admin', 'action' => $action, 'post_id' => $post_id, '_wpnonce' => wp_create_nonce(self::NONCE));
        } elseif ($action == 'activity_admin_signup_list') {
            $args = array('page' => 'activity_admin', 'signup_action' => 'view', 'post_id' => $post_id, '_wpnonce' => wp_create_nonce(self::NONCE));
        } elseif ($action == 'activity_admin_delete_signup') {
            $args = array('page' => 'activity_admin', 'signup_action' => 'delete', 'post_id' => $post_id, 'signup_id' => $signup_id, '_wpnonce' => wp_create_nonce(self::NONCE));
        } elseif ($action == 'activity_admin_edit_signup') {
            $args = array('page' => 'activity_admin', 'signup_action' => 'edit', 'post_id' => $post_id, 'signup_id' => $signup_id, '_wpnonce' => wp_create_nonce(self::NONCE));
        } elseif ($action == 'activity_admin_add_signup') {
            $args = array('page' => 'activity_admin', 'signup_action' => 'add', 'post_id' => $post_id, '_wpnonce' => wp_create_nonce(self::NONCE));
        } elseif ($action == 'activity_admin_process_signup') {
            $args = array('page' => 'activity_admin', 'signup_action' => 'process', '_wpnonce' => wp_create_nonce(self::NONCE));
        } elseif ($action == 'activity_admin_add_post') {
            $args = array('page' => 'activity_admin', 'action' => 'activity_admin_post', 'post_action' => 'add', '_wpnonce' => wp_create_nonce(self::NONCE));
        } elseif ($action == 'activity_admin_edit_post') {
            $args = array('page' => 'activity_admin', 'action' => 'activity_admin_post', 'post_action' => 'edit', 'post_id' => $post_id, '_wpnonce' => wp_create_nonce(self::NONCE));
        } else {
            $args = array('page' => 'activity_admin', 'action' => $action, '_wpnonce' => wp_create_nonce(self::NONCE));
        }
        $url = add_query_arg($args, admin_url('admin.php'));

        return $url;
    }

    public static function activity_admin_term_exists($term)
    {
        $all_terms = get_terms('category', 'orderby=id&hide_empty=0');
        foreach ($all_terms as $a_term) {
            if ($a_term->term_id == $term) {
                return true;
            }
        }

        return false;
    }

    public static function activity_admin_message($type, $msg)
    {
        if ($type == 'error') {
            echo '<div class="error"><p>'.$msg.'</p></div>';
        } else {
            echo '<div class="updated"><p>'.$msg.'</p></div>';
        }
    }

    public static function activity_admin_display_message($type, $msg)
    {
        add_action('admin_notice', array('Activity_Admin', 'activity_admin_message'), 10, 2);
        do_action('admin_notice', $type, $msg);
    }

    public static function activity_admin_display_activity()
    {
        Activity::activity_view('activity_admin_list');
    }

    public static function activity_admin_setting()
    {
        if (isset($_GET['_wpnonce'])) {
            if (wp_verify_nonce($_GET['_wpnonce'], self::NONCE) && isset($_POST['activity_category']) && self::activity_admin_term_exists($_POST['activity_category'])) {
                update_option('activity_category', $_POST['activity_category']);
                self::activity_admin_display_message('updated', '活动分类更新成功！');
            } else {
                self::activity_admin_display_message('error', '非法请求！');
            }
        }

        Activity::activity_view('activity_admin_setting');
    }

    public static function activity_admin_delete_post()
    {
        if (!isset($_GET['post_id']) || !wp_verify_nonce($_GET['_wpnonce'], self::NONCE)) {
            self::activity_admin_display_message('error', '非法请求！');
        } else {
            $the_post = get_post(intval($_GET['post_id']));
            if (!empty($the_post)) {
                global $wpdb;
                $table_name = $wpdb->prefix.'activity_meta';
                $signup_delete = Activity_Signup::activity_signup_delete_all(intval($_GET['post_id']));
                $actiity_meta_delete = $wpdb->delete($table_name, array('post_id' => intval($_GET['post_id'])));
                $post_deleted = wp_delete_post(intval($_GET['post_id']), true);
                if (!is_bool($post_deleted) && !empty($signup_delete) && !empty($actiity_meta_delete)) {
                    self::activity_admin_display_message('updated', '活动删除成功！');
                } else {
                    self::activity_admin_display_message('error', '删除活动失败！');
                }
            } else {
                self::activity_admin_display_message('error', '非法请求！');
            }
        }

        Activity::activity_view('activity_admin_list');
    }

    public static function activity_admin_post($post_action)
    {
        if (!wp_verify_nonce($_GET['_wpnonce'], self::NONCE) || ($post_action != 'add' && $post_action != 'edit')) {
            self::activity_admin_display_message('error', '非法请求！');
            Activity::activity_view('activity_admin_list');
        } else {
            Activity::activity_view('activity_admin_post');
        }
    }

    public static function activity_admin_get_post_meta($post_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix.'activity_meta';
        $result = $wpdb->get_row("SELECT * FROM $table_name WHERE post_id = $post_id");

        return $result;
    }

    private static function activity_admin_is_field_empty()
    {
        foreach ($_POST as $key => $value) {
            if ($key == 'poster' || $key == 'fee_member' || $key == 'fee_nonmember' || $key == 'max_capacity') {
                continue;
            }
            if (empty($value)) {
                return true;
            }
        }

        return false;
    }

    private static function activity_admin_process_post_data_array()
    {
        $data_array = array();
        $is_new = $_POST['is_new'] == 1 ? true : false;
        foreach ($_POST as $key => $value) {
            if (($key == 'fee_member' || $key == 'fee_nonmember' || $key == 'max_capacity') && empty(intval($value))) {
                $data_array[$key] = 0;
                continue;
            }
            $data_array[$key] = $value;
        }

        unset($data_array['is_new']);
        if ($is_new) {
            unset($data_array['post_id']);
        }

        $activity_time = $data_array['activity_date'].' '.$data_array['activity_time'];
        $signup_time = $data_array['signup_date'].' '.$data_array['signup_time'];
        unset($data_array['activity_date']);
        unset($data_array['activity_time']);
        unset($data_array['signup_date']);
        unset($data_array['signup_time']);
        $data_array['activity_time'] = $activity_time;
        $data_array['signup_time'] = $signup_time;

        return $data_array;
    }

    private static function activity_admin_insert_post($data)
    {
        global $wpdb;
        $table_name = $wpdb->prefix.'activity_meta';
        $post_meta = array(
            'post_id' => 0,
            'location' => $data['location'],
            'member_fee' => $data['fee_member'],
            'nonmember_fee' => $data['fee_nonmember'],
            'signup_time' => $data['signup_time'],
            'signup_method' => $data['signup_method'],
            'max_capacity' => $data['max_capacity'],
            'activity_time' => $data['activity_time'],
            'poster' => $data['poster'],
        );
        if (!$wpdb->insert($table_name, $post_meta)) {
            unset($post_meta);

            return false;
        } else {
            $activity_cat = intval(get_option('activity_category'));
            $activity_slug = 'activity'.date('ymdHis');
            $post_data = array(
                'post_content' => $data['activity_detail'],
                'post_name' => $activity_slug,
                'post_title' => $data['title'],
                'post_status' => 'publish',
                'ping_status' => 'open',
                'post_category' => array($activity_cat),
            );
            $post_insert = wp_insert_post($post_data);
            unset($post_data);
            if ($post_insert == 0) {
                $wpdb->delete($table_name, array('post_id' => 0));

                return false;
            } else {
                $wpdb->update($table_name, array('post_id' => $post_insert), array('post_id' => 0));

                return true;
            }
        }
    }

    private static function activity_admin_update_post($data)
    {
        $current_post_data = get_post(intval($data['post_id']));
        $post_data = array(
            'ID' => intval($data['post_id']),
            'post_content' => $data['activity_detail'],
            'post_title' => $data['title'],
        );
        $post_update = wp_update_post($post_data);
        unset($post_data);

        if ($post_update == 0) {
            return false;
        } else {
            global $wpdb;
            $table_name = $wpdb->prefix.'activity_meta';
            $post_meta = array(
                'location' => $data['location'],
                'member_fee' => $data['fee_member'],
                'nonmember_fee' => $data['fee_nonmember'],
                'signup_time' => $data['signup_time'],
                'signup_method' => $data['signup_method'],
                'max_capacity' => $data['max_capacity'],
                'activity_time' => $data['activity_time'],
                'poster' => $data['poster'],
            );
            $post_meta_where = array('post_id' => intval($data['post_id']));
            if ($wpdb->update($table_name, $post_meta, $post_meta_where) === false) {
                wp_update_post($current_post_data);
                unset($post_meta);
                unset($post_meta_where);

                return false;
            }
        }

        return true;
    }

    public static function activity_admin_process_post()
    {
        if (self::activity_admin_is_field_empty()) {
            echo '<script type="text/javascript">alert("除活动海报、收费和最大人数外，其他项目均为必填！\n请检查表单是否填写完整！"); window.history.back();</script>';
        } else {
            if (wp_verify_nonce($_GET['_wpnonce'], self::NONCE) && $_POST['is_new'] == 1) {
                if (self::activity_admin_insert_post(self::activity_admin_process_post_data_array())) {
                    self::activity_admin_display_message('updated', '活动添加成功！');
                } else {
                    self::activity_admin_display_message('error', '活动添加失败！');
                }
            } elseif (wp_verify_nonce($_GET['_wpnonce'], self::NONCE) && $_POST['is_new'] == -1) {
                if (self::activity_admin_update_post(self::activity_admin_process_post_data_array())) {
                    self::activity_admin_display_message('updated', '活动编辑成功！');
                } else {
                    self::activity_admin_display_message('error', '活动编辑失败！');
                }
            } else {
                self::activity_admin_display_message('error', '非法请求！');
            }
            Activity::activity_view('activity_admin_list');
        }
    }

    public static function error_add_activity()
    {
        self::activity_admin_display_message('error', '请通过活动插件添加/编辑活动！');
        Activity::activity_view('activity_admin_list');
    }

    public static function activity_admin_get_capacity($post_id = 0)
    {
        if ($post_id == 0) {
            return 0;
        }
        global $wpdb;
        $table_name = $wpdb->prefix.'activity_meta';
        $count = $wpdb->get_var("SELECT max_capacity FROM $table_name WHERE post_id = $post_id");

        return is_null($count) ? 0 : intval($count);
    }
}
