<?php

class WW_Module
{

    public static function ww_init()
    {
        add_action('admin_menu', array('WW_Module', 'ww_load_menu'));
    }

    public static function ww_activation()
    {
        self::ww_init_database();

    }

    public static function ww_deactivation()
    {

    }

    public static function ww_update_enquiry($method)
    {

    }

    public static function ww_update_center()
    {
        global $wpdb;

        switch($method)
        {
            case "show":
                $result = $wpdb->get_results( "SELECT * FROM wp_ww_center;" );
                var_dump($result);
                break;

            case "delete":
            break;

            case "add":
            break;

        }
    }


    public static function ww_uninstall()
    {
    }

    public static function ww_load_menu()   
    {
        add_menu_page('WeeManager', 'WeeManager', 'edit_pages', 'Wee_Menu', array('WW_Module', 'ww_update_center'), 'dashicons-smiley', 2);
        add_submenu_page('Wee_Menu', 'WeeCenter', 'WeeCenter', 'edit_pages', 'Wee_Menu', array('WW_Module', 'ww_update_center("show")'));
        add_submenu_page('Wee_Menu', 'WeeEnquiry', 'WeeEnquiry', 'edit_pages', 'SubWeeEnquiry', array('WW_Module', 'ww_update_enquiry'));
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
        $ww_table_name_enquiry = $wpdb->prefix.'ww_enquiry';
        $ww_charset_collate = $wpdb->get_charset_collate();

        $ww_center_sql = "CREATE TABLE $ww_table_name_center (
        center_id int(5) unsigned NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(15) NOT NULL,
        address varchar(255) NOT NULL,
        scale int(10),
        current int(10),
        CONSTRAINT pk_center_id PRIMARY KEY (center_id)
        ) $ww_charset_collate;";

        $ww_enquiry_sql = "CREATE TABLE $ww_table_name_enquiry (
        enq_id int(10) unsigned NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(15) NOT NULL,
        address varchar(255) NOT NULL,
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
