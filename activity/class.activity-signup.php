<?php

class Activity_Signup
{
    public static function activity_signup_count($post_id = 0)
    {
        if ($post_id == 0) {
            return 0;
        }
        global $wpdb;
        $table_name = $wpdb->prefix.'activity_signup';
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE activity_id = $post_id");

        return is_null($count) ? 0 : intval($count);
    }

    public static function activity_signup_get_list($post_id = 0)
    {
        if ($post_id == 0) {
            return 0;
        }
        global $wpdb;
        $table_name = $wpdb->prefix.'activity_signup';
        $signup_list = $wpdb->get_results("SELECT * FROM $table_name WHERE activity_id = $post_id");

        return $signup_list;
    }

    public static function activity_signup_list()
    {
        Activity::activity_view('activity_admin_signup_list');
    }

    public static function activity_signup_get_signup($signup_id = 0)
    {
        if ($signup_id == 0) {
            return 0;
        }
        global $wpdb;
        $table_name = $wpdb->prefix.'activity_signup';
        $signup = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $signup_id");

        return $signup;
    }

    public static function activity_signup_delete_all($post_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix.'activity_signup';

        return $wpdb->delete($table_name, array('activity_id' => $post_id));
    }

    public static function activity_signup_delete()
    {
        if (!isset($_GET['signup_id']) || $_GET['signup_id'] == 0) {
            return 0;
        }
        $signup_id = intval($_GET['signup_id']);
        global $wpdb;
        $table_name = $wpdb->prefix.'activity_signup';
        if ($wpdb->get_var("SELECT activity_id FROM $table_name WHERE id = $signup_id") == $_GET['post_id']) {
            if ($wpdb->delete($table_name, array('id' => $signup_id))) {
                Activity_Admin::activity_admin_display_message('updated', '报名删除成功！');
            } else {
                Activity_Admin::activity_admin_display_message('error', '报名删除失败！');
            }
        } else {
            Activity_Admin::activity_admin_display_message('error', '非法请求！');
        }
        Activity::activity_view('activity_admin_signup_list');
    }

    public static function activity_signup_detail()
    {
        Activity::activity_view('activity_admin_signup');
    }

    private static function activity_signup_is_field_empty()
    {
        foreach ($_POST as $key => $value) {
            if ($key == 'fullname' || $key == 'phone') {
                if (empty($value)) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function activity_signup_process_signup()
    {
        if (self::activity_signup_is_field_empty()) {
            echo '<script type="text/javascript">alert("姓名与电话为必填项目！\n请检查表单是否填写完整！"); window.history.back();</script>';
        } else {
            if (isset($_POST['frontend']) && $_POST['frontend'] == 1) {
                if (self::activity_signup_add(self::activity_singup_prepare_data())) {
                    header('Location: '.get_site_url().'//activity_signup_success');
                } else {
                    header('Location: '.get_site_url().'//activity_signup_error');
                }
                exit();
            } elseif (wp_verify_nonce($_GET['_wpnonce'], Activity_Admin::NONCE) && $_POST['is_new'] == 1) {
                if (self::activity_signup_add(self::activity_singup_prepare_data())) {
                    Activity_Admin::activity_admin_display_message('updated', '活动参与人信息添加成功！');
                } else {
                    Activity_Admin::activity_admin_display_message('error', '活动参与人信息添加失败！');
                }
            } elseif (wp_verify_nonce($_GET['_wpnonce'], Activity_Admin::NONCE) && $_POST['is_new'] == -1) {
                if (self::activity_signup_edit(self::activity_singup_prepare_data())) {
                    Activity_Admin::activity_admin_display_message('updated', '活动参与人信息编辑成功！');
                } else {
                    Activity_Admin::activity_admin_display_message('error', '活动参与人信息编辑失败！');
                }
            } else {
                echo '<script type="text/javascript">alert("非法请求！"); </script>';
            }
            Activity::activity_view('activity_admin_list');
        }
    }

    private static function activity_singup_prepare_data()
    {
        $data = array();
        if (intval($_POST['is_new']) == -1) {
            $data['signup_id'] = intval($_POST['signup_id']);
        }
        $data['activity_id'] = intval($_POST['post_id']);
        $data['name'] = $_POST['fullname'];
        $data['email'] = $_POST['email'];
        $data['phone'] = $_POST['phone'];
        $data['fee_paid'] = isset($_POST['fee_paid']) ? 1 : 0;
        $data['is_aut_student'] = isset($_POST['is_aut_student']) ? 1 : 0;
        $data['is_autcsa_member'] = isset($_POST['is_autcsa_member']) ? 1 : 0;
        $data['time'] = date('Y-m-d H:i:s');

        return $data;
    }

    private static function activity_signup_validate_data($data, $add = false)
    {
        if (!is_numeric($data['phone']) || strlen($data['phone']) > 15) {
            return false;
        }
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        global $wpdb;
        $table_name = $wpdb->prefix.'activity_signup';
        $phone_exist = $wpdb->get_var("SELECT id FROM $table_name WHERE activity_id=".$data['activity_id']." AND phone='".$data['phone']."'") ? true : false;
        if ($add && $phone_exist) {
            return false;
        }

        return true;
    }

    private static function activity_signup_edit($data)
    {
        if (!self::activity_signup_validate_data($data)) {
            return false;
        }
        $signup_id = $data['signup_id'];
        unset($data['signup_id']);
        global $wpdb;
        $table_name = $wpdb->prefix.'activity_signup';
        $where_cond = array('id' => $signup_id);

        return ($wpdb->update($table_name, $data, $where_cond) === false) ? false : true;
    }

    private static function activity_signup_add($data)
    {
        if (!self::activity_signup_validate_data($data, true)) {
            return false;
        }
        global $wpdb;
        $table_name = $wpdb->prefix.'activity_signup';

        return $wpdb->insert($table_name, $data);
    }

    public static function activity_signup_frontend_add()
    {
        self::activity_signup_process_signup();
    }
}
