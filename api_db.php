<?php
if (!defined('ABSPATH')) {
    echo " Access Denied";
}
ob_start();
// Check And Create API Table
global $wpdb;
$table_name = $wpdb->prefix . "api_table";
    //check if table already Exists//
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name(
        id INT NOT NULL AUTO_INCREMENT,
        api_key_value VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)) ENGINE = InnoDB;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }else { if ($_SERVER["REQUEST_METHOD"] == "POST") { // don't active unless it's a POST Request
    $IPDATA = $_POST["api_key"];
    $IPDATA_KEY = strval($IPDATA);
    if ($IPDATA_KEY != null) {
        $success = $wpdb->query($wpdb->prepare("INSERT INTO $table_name(api_key_value) VALUES (%s)", $IPDATA_KEY));
        header('Location:admin.php?page=ipdata');
        die();
    }
}}
ob_end_flush();?>