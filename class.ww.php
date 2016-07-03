<?php

class WW_Management
{

    public static function ww_init()
    {
        /*
        add_action('admin_post_activity_signup', array('Activity_Signup', 'activity_signup_frontend_add'));
        add_action('admin_post_nopriv_activity_signup', array('Activity_Signup', 'activity_signup_frontend_add'));
        if (!self::$activity_initialed) {
            self::activity_init_hooks();
        }
        */
    }

    public static function ww_activation()
    {
        self::ww_init_database();
        add_action('admin_menu', 'ww_load_menu');
    }

    public static function ww_deactivation()
    {
        
    }

    public static function ww_update_student()
    {

    }

    public static function ww_update_center()
    {

    }

    public static function ww_test()
    {
        //echo "Hello";
    }

    public static function ww_uninstall()
    {
    }

    public static function ww_load_menu()   
    {
        add_menu_page('WeeManager', 'WeeManager', 'manage_options', 'Wee_Menu');
        //add_menu_page('WeeManage', 'WeeManager', 'WeeManager', 'list_users');
        //add_submenu_page('WeeStudent', 'WeeStudent', 'WeeStudent', 'edit_posts');
    }

    /**
     * Determining if required table exists.
     *
     * @global type $wpdb
     *
     * @return bool
     */
    /*
    private static function activity_is_table_created( $activity_table_name ) {
        global $wpdb;
        $activity_table_dbname = DB_NAME;
        $activity_table_sql = "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$activity_table_dbname' AND table_name = '$activity_table_name'";
        $activity_table_count = $wpdb->get_var( $activity_table_sql );

        if ( $activity_table_count > 0 ) {
            return true;
        }
        return false;
    }
    */

    /**
     * Initialize plugin database.
     */
    private static function ww_init_database()
    {
        global $wpdb;
        $ww_table_name_center = $wpdb->prefix.'ww_center';
        $ww_table_name_student = $wpdb->prefix.'ww_student';
        $ww_charset_collate = $wpdb->get_charset_collate();
        //

        $ww_center_sql = "CREATE TABLE $ww_table_name_center (
			center_id int(5) unsigned NOT NULL AUTO_INCREMENT,
			name varchar(255) NOT NULL,
			email varchar(255) NOT NULL,
			phone varchar(15) NOT NULL,
            address varchar(255) NOT NULL,
            scale int(10),
            current int(10),
            is_full boolean DEFAULT false NOT NULL,
			CONSTRAINT pk_center_id PRIMARY KEY (center_id)
		) $ww_charset_collate;";

         $ww_student_sql = "CREATE TABLE $ww_table_name_student (
            std_id int(10) unsigned NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            phone varchar(15) NOT NULL,
            address varchar(255) NOT NULL,
            age int(5),
            gender boolean DEFAULT false NOT NULL, /*false = male, true = female*/
            /*
            homebase_id,
            exchange_id,
            */
            center_id int(5) unsigned,
            is_enrolled boolean DEFAULT false NOT NULL,
            CONSTRAINT pk_std_id PRIMARY KEY (std_id),
            CONSTRAINT fk_center_id FOREIGN KEY (center_id) REFERENCES ".$ww_table_name_center."(center_id)
        ) $ww_charset_collate;";

        require_once ABSPATH.'wp-admin/includes/upgrade.php';
        dbDelta($ww_center_sql);
        dbDelta($ww_student_sql);

    }

    /**
     * Initialize wordpress hooks.
     */
    private static function ww_init_hooks()
    {
    }

    /*
    public static function ww_view($file_name)
    {
        include ACTIVITY__PLUGIN_DIR.'views/'.$file_name.'.php';
    }
    */
}
