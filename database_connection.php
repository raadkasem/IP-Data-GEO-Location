<?php
if (!defined('ABSPATH')) {
  echo "Access Denied";
}
global $wpdb;
$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname =  strval($wpdb->dbname); /* Database name */


//Only for Debugging:
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$con = mysqli_connect($host, $user, $password,$dbname);
$con2 = mysqli_connect($host, $user, $password,$dbname);
$con3 = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}