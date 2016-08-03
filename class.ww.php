<?php

class WW_Module
{
    const NONCE = 'ww_admin_key';

    public static function ww_activation()
    {
        self::ww_init_database();
    }

    public static function ww_init()
    {
        add_action('admin_menu', array('WW_Module', 'ww_load_menu'));
    }

    public static function ww_deactivation()
    {
    }


    //enquiry action fucntions
    public static function ww_update_enquiry()
    {
        global $wpdb;
        $wpdb->update('wp_ww_enquiry',
            array('name' => 'Taku', 'phone' => '0112233445', 'center_id' => 1, 'is_contacted' => true),
            array('enq_id' => 1),
            array('%s', '%s', '%d', '%d')
            );
    }

    public static function ww_add_enquiry()
    {
        global $wpdb;
        $wpdb->insert('wp_ww_enquiry',
            array('name' => 'Pokemon', 'email' => 'pk@nintendo.com', 'phone' => '0223456789', 'center_id' => 2, 'is_contacted' => false),
            array('%s', '%s', '%s', '%d', '%d')
            );
    }

    public static function ww_del_enquiry()
    {
        global $wpdb;
        $wpdb->delete('wp_ww_enquiry', array('enq_id' => 1));
    }

    public static function ww_get_enquiry()
    {
        global $wpdb;
        $result = $wpdb->get_results('SELECT * FROM wp_ww_enquiry;');
        var_dump($result);
    }



    //center action functions
    public static function ww_update_center()
    {
        global $wpdb;
        $wpdb->update('wp_ww_center',
            array('name' => 'good', 'phone' => '00000000000'),
            array('center_id' => 1),
            array('%s', '%s')
            );
    }

    public static function ww_center_manage()
    {
        
        if($_GET['action'])
        {   
            //add center routings
            if ($_GET['action'] == "add_center") {
                self::ww_add_center();
            }

            if ($_GET['action'] == "show_add") {
                self::ww_view('add_center');
            }

            //del center routings
            if ($_GET['action'] == 'del_center')
            {
                self::ww_del_center();
            }

            //update center routings
            if($_GET['action'] == 'update_center')
            {
                self::ww_update_center();
            }
        }
        else{
            self::ww_view('list_center');
        }
    }

    public static function ww_get_center()
    {
        global $wpdb;
        $result = $wpdb->get_results('SELECT * FROM wp_ww_center');
        return $result;
    }

    public static function ww_add_center()
    {
        global $wpdb;
        $input = array('name' => $_POST["name"], 'email' => $_POST["email"], 'address' => $_POST["address"], 'phone' => $_POST["phone"]);
        $wpdb->insert('wp_ww_center',
           array('name' => $input['name'], 'email' => $input['email'], 'phone' => $input['phone'], 'address' => $input['address']),
           array('%s', '%s', '%s', '%s'));
           self::ww_view('list_center');
    }

    public static function ww_del_center()
    {
        if (!isset($_GET['center_id']) || !wp_verify_nonce($_GET['_wpnonce'], self::NONCE)) {
            self::ww_display_message('error', 'Illegal request！');
        } else {
            $center_id = $_GET['center_id'];
            if($center_id){
                global $wpdb;
                $wpdb->delete('wp_ww_center', array('center_id' => $center_id));
                self::ww_display_message('updated', 'Deletion Succeed');
            }else {
                self::ww_display_message('error', 'Deletion Failed!');
            }
        }
        self::ww_view('list_center');
    }

    
    public static function ww_update_center()
    {
        if (!isset($_GET['center_id']) || !wp_verify_nonce($_GET['_wpnonce'], self::NONCE)) {
            self::ww_display_message('error', 'Illegal request！');
        } else {
            $center_id = $_GET['center_id'];
            if($center_id){
                var_dump($center_id);
            }else {
                self::ww_display_message('error', 'Deletion Failed!');
            }
        }
        self::ww_view('list_center');
    }
    


    //initialize admin menu
    public static function ww_load_menu()
    {
        add_menu_page('WeeManager', 'WeeManager', 'edit_pages', 'cen_action', array('WW_Module', 'ww_center_manage'), 'dashicons-smiley', 2);
        add_submenu_page('cen_action', 'WeeCenter', 'WeeCenter', 'edit_pages', 'cen_action', array('WW_Module', 'ww_center_manage'));
        add_submenu_page('cen_action', 'WeeEnquiry', 'WeeEnquiry', 'edit_pages', 'enq_action', array('WW_Module', 'ww_get_center_id'));
    }


    public static function ww_manage_get_url($action, $center_id = 0)
    {
        //default menu page
        if (!$action)
        {
            $args = array('page' => 'cen_action');
        }

        //add center pages
        if ($action == 'add_center') {
            $args = array('page' => 'cen_action', 'action' => $action, '_wpnonce' => wp_create_nonce(self::NONCE));
        }
        if ($action == 'show_add') {
            $args = array('page' => 'cen_action', 'action' => $action, '_wpnonce' => wp_create_nonce(self::NONCE));
        }

        //delete center pages
        if ($action == 'del_center') {
            $args = array('page' => 'cen_action', 'action' => $action, 'center_id' => $center_id, '_wpnonce' => wp_create_nonce(self::NONCE));
        }

        //update center pages
        if ($action == 'update_center') {
            $args = array('page' => 'cen_action', 'action' => $action, 'center_id' => $center_id, '_wpnonce' => wp_create_nonce(self::NONCE));
        }
        

        $url = add_query_arg($args, admin_url('admin.php'));

        return $url;
    }

    /**
     * Initialize plugin database.
     */
    private static function ww_init_database()
    {
        global $wpdb;
        $ww_table_name_center = $wpdb->prefix.'ww_center';
        $ww_table_name_enquiry = $wpdb->prefix.'ww_enquiry';
        $ww_charset_collate = $wpdb->get_charset_collate();

        $ww_center_sql = "CREATE TABLE $ww_table_name_center (
        center_id int(5) unsigned NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(15) NOT NULL,
        address varchar(255) NOT NULL,
        CONSTRAINT pk_center_id PRIMARY KEY (center_id)
        ) $ww_charset_collate;";

        $ww_enquiry_sql = "CREATE TABLE $ww_table_name_enquiry (
        enq_id int(10) unsigned NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(15) NOT NULL,
        /*
        homebase_id,
        exchange_id,
        */
        center_id int(5) unsigned,
        is_contacted boolean DEFAULT false NOT NULL,
        CONSTRAINT pk_enq_id PRIMARY KEY (enq_id),
        CONSTRAINT fk_center_id FOREIGN KEY (center_id) REFERENCES ".$ww_table_name_center."(center_id)
        ) $ww_charset_collate;";

        require_once ABSPATH.'wp-admin/includes/upgrade.php';
        dbDelta($ww_center_sql);
        dbDelta($ww_enquiry_sql);
    }

    //instruction display functions
    public static function ww_message($type, $msg)
    {
        if ($type == 'error') {
            echo '<div class="error"><p>'.$msg.'</p></div>';
        } else {
            echo '<div class="updated"><p>'.$msg.'</p></div>';
        }
    }
    
    public static function ww_display_message($type, $msg)
    {
        add_action('admin_notice', array('WW_Module', 'ww_message'), 10, 2);
        do_action('admin_notice', $type, $msg);
    }

    //view loading function
    public static function ww_view($file_name)
    {
        include WW_Management_DIR.'views/'.$file_name.'.php';
    }

    /**
     * Initialize wordpress hooks.
     */
    private static function ww_init_hooks()
    {
    }

    public static function ww_uninstall()
    {
    }

    /*
    public static function ww_del_center($name)
    {
        global $wpdb;
        $idToDel = self::ww_get_center_id($name);
        $wpdb->delete('wp_ww_center', array('center_id' => $idToDel));
        self::ww_view('list_center');
    }

    private static function ww_get_center_id($name)
    {
        global $wpdb;
        $id = $wpdb->get_var("SELECT center_id FROM wp_ww_center WHERE name = '".$name."'");
        return $id;
    }
    */

    
}
