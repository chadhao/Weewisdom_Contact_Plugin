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


    public static function ww_update_enquiry()
    {
        global $wpdb;
        $wpdb->update
        ('wp_ww_enquiry', 
            array( 'name' =>'Taku', 'phone' => '0112233445', 'center_id'=> 1, 'is_contacted' => TRUE), 
            array( 'enq_id' => 1 ), 
            array( '%s', '%s', '%d', '%d')
        );
    }

    public static function ww_add_enquiry()
    {
        global $wpdb;
        $wpdb->insert
        ('wp_ww_enquiry',
            array('name'=>'Pokemon', 'email'=>'pk@nintendo.com', 'phone'=>'0223456789', 'center_id'=> 2, 'is_contacted'=>FALSE),
            array('%s','%s','%s', '%d','%d')
        );
    }

    public static function ww_del_enquiry()
    {
        global $wpdb;
        $wpdb->delete('wp_ww_enquiry', array( 'enq_id' => 1 ) );
    }

    public static function ww_show_enquiry()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_ww_enquiry;");
        var_dump($result);
    }




    public static function ww_update_center()
    {   
        global $wpdb;
        $wpdb->update
        ('wp_ww_center', 
            array( 'name' =>'good', 'phone' => '00000000000'), 
            array( 'center_id' => 1 ), 
            array( '%s', '%s')
        );
    }

    public static function ww_add_center()
    {
        global $wpdb;
        $wpdb->insert
        ('wp_ww_center',
            array('name'=>'Joke', 'email'=>'abs@123.com', 'phone'=>'0222221111', 'address'=>'123 symond street'),
            array('%s','%s','%s','%s')
        );

    }

    public static function ww_del_center()
    {
        global $wpdb;
        $wpdb->delete('wp_ww_center', array( 'center_id' => 1 ));
    }

    public static function ww_show_center()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_ww_center;");
        var_dump($result);

    }


    public static function ww_uninstall()
    {
    }

    public static function ww_load_menu()   
    {
        add_menu_page('WeeManager', 'WeeManager', 'edit_pages', 'Wee_Menu', array('WW_Module', 'ww_update_center'), 'dashicons-smiley', 2);
        add_submenu_page('Wee_Menu', 'WeeCenter', 'WeeCenter', 'edit_pages', 'Wee_Menu', array('WW_Module', 'ww_show_center'));
        add_submenu_page('Wee_Menu', 'WeeEnquiry', 'WeeEnquiry', 'edit_pages', 'SubWeeEnquiry', array('WW_Module', 'ww_del_center'));
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
        address varchar(255) NOT NULL,
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
