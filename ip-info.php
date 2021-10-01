<?php
/*
   Plugin Name: IP-INFO GEO Location
   Description: This plugin allows you to save all the visitor's IP address and get their location info by IP .
   Version: 1.0.0
   Author: Raad Kasem.
   Requires PHP:      7.2
   License:           GPL v2 or later
   License URI:       https://www.gnu.org/licenses/gpl-2.0.html
  */

if (!defined('ABSPATH')) {
    echo "Access Denied";
}
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php');
include(plugin_dir_path(__FILE__) . '/database_connection.php');
register_activation_hook(__FILE__, 'create_db');
include(plugin_dir_path(__FILE__) . '/api_db.php');


// Create an admin Side Menu  to Control entered APi Key
add_action("admin_menu", "ipdata_plugin");
function ipdata_plugin()
{
    add_menu_page(
        "IPData API",
        "IPData API",
        "manage_options", // Admin Role
        "ipdata", // slug
        "ipdata_options", // callback func
        "dashicons-networking",
        2 // it's Order on the List.
    );
    add_submenu_page(
        "ipdata",
        "API Key",
        "API Key",
        "manage_options",
        "apikey",
        "insertApiForm"
    );
}
function insertApiForm()
{   // check if the user is Admin
    if (!current_user_can('manage_options')) {
        wp_die(__("you don't have the permission to access this page"));
    } else {
?>
        <!-- create a Form (text input) for APi Key -->
        <hr>
        <div style="text-align:center; display:block; float:left">
            <figure>
                <img src="<?php echo plugin_dir_url(__FILE__) . "raad-logo.png"; ?>" alt="BY Raad" style="width: 215px; height:180px;">
                <figcaption><b><a href="https://github.com/raadkasem">GitHub: Raad Kasem</a></b></figcaption>
            </figure>
        </div>
        <br />
        <div style="margin-top: 60px;
                margin-bottom: 50px;">
            <form action="api_db.php" method="POST" style="float: right;margin-right: 20%;">
                <input type="text" maxlength="255" size="70" name="api_key" placeholder="Enter Api Key Here..">
                <input type="submit" value="Save To Database" style="color: white; background-color:#fa5a5a;
            display: inline-block ;
            padding: 10px 20px;
            border: 1px  solid rgba(0, 0, 0, 0.20);
            border-bottom-color: rgba(0, 0, 0, 0.35);
            text-shadow: 0 1px 0 rgb(0 0 0 /15%);
            box-shadow: 0 1px rgb(255 255 255 / 35%) inset, 0 2px 0 -1px rgb(0 0 0 /13%), 0 3px 0 -1px rgb(0 0 0 /8%), 0 3px 13px -1px rgb(0 0 0 /21%);
            border-radius: 10px;
            text-decoration: none;">
            </form>
        </div><?php
            }
        }

        add_action('admin_enqueue_scripts', 'wpdocs_selectively_enqueue_admin_script');
        function wpdocs_selectively_enqueue_admin_script($hook)
        {
            // $var = get_current_screen();
            // print_r($var);
            if ($hook != 'toplevel_page_ipdata')
                return;
            wp_register_style('boot_css', plugins_url('assets/bootstrap.css', __FILE__));
            wp_enqueue_style('boot_css');
            wp_register_script('jQuery_js', plugins_url('assets/jquery.js', __FILE__));
            wp_enqueue_script('jQuery_js');
            wp_register_script('boot_js', plugins_url('assets/bootstrap.js', __FILE__));
            wp_enqueue_script('boot_js');
            wp_register_style('jquery_data_css', plugins_url('assets/jquery.dataTables.css', __FILE__));
            wp_enqueue_style('jquery_data_css');
            wp_register_script('jquery_data_js', plugins_url('assets/jquery.dataTables.js', __FILE__), array('jQuery_js'));
            wp_enqueue_script('jquery_data_js');
            wp_register_script('popper', plugins_url('assets/popper.js', __FILE__));
            wp_enqueue_script('popper');
            wp_register_script('moment.min', plugins_url('assets/moment.min.js', __FILE__));
            wp_enqueue_script('moment.min');
            wp_register_script('dataTables.dateTime.min', plugins_url('assets/dataTables.dateTime.min.js', __FILE__));
            wp_enqueue_script('dataTables.dateTime.min');
            wp_register_style('dataTables.dateTime.min_css', plugins_url('assets/dataTables.dateTime.min.css', __FILE__));
            wp_enqueue_style('dataTables.dateTime.min_css');
            wp_register_script('dataTables.buttons.min', plugins_url('assets/dataTables.buttons.min.js', __FILE__));
            wp_enqueue_script('dataTables.buttons.min');
            wp_register_script('buttons.html5.min', plugins_url('assets/buttons.html5.min.js', __FILE__));
            wp_enqueue_script('buttons.html5.min');
            wp_register_script('buttons.print.min', plugins_url('assets/buttons.print.min.js', __FILE__));
            wp_enqueue_script('buttons.print.min');
            wp_register_script('jszip.min', plugins_url('assets/jszip.min.js', __FILE__));
            wp_enqueue_script('jszip.min');
            wp_register_script('jquery.dataTables.min_js', plugins_url('assets/jquery.dataTables.min.js', __FILE__));
            wp_enqueue_script('jquery.dataTables.min_js');
            wp_register_style('jquery.dataTables.min_css', plugins_url('assets/jquery.dataTables.min.css', __FILE__));
            wp_enqueue_style('jquery.dataTables.min_css');
            wp_register_script('dataTables.select.min', plugins_url('assets/dataTables.select.min.js', __FILE__));
            wp_enqueue_script('dataTables.select.min');
            wp_register_style('select.dataTables.min', plugins_url('assets/select.dataTables.min.css', __FILE__));
            wp_enqueue_style('select.dataTables.min');
            wp_register_style('buttons.dataTables.min', plugins_url('assets/buttons.dataTables.min.css', __FILE__));
            wp_enqueue_style('buttons.dataTables.min');
            wp_register_style('bootstrap-datetimepicker.min', plugins_url('assets/bootstrap-datetimepicker.min.css', __FILE__));
            wp_enqueue_style('bootstrap-datetimepicker.min');
            wp_register_script('bootstrap-datetimepicker.min-js', plugins_url('assets/bootstrap-datetimepicker.min.js', __FILE__));
            wp_enqueue_script('bootstrap-datetimepicker.min-js');
            wp_register_style('jquery-ui.min-css', plugins_url('assets/jquery-ui.min.css', __FILE__));
            wp_enqueue_style('jquery-ui.min-css');
            wp_register_script('jquery-ui.min-js', plugins_url('assets/jquery-ui.min.js', __FILE__));
            wp_enqueue_script('jquery-ui.min-js');
            wp_register_script('ajax_req', plugins_url('assets/scriptselect.js', __FILE__), array('jQuery_js'));
            wp_localize_script(
                'ajax_req',
                'ajax_object',
                array('ajax_url' => admin_url('admin-ajax.php'))
            );
            wp_enqueue_script('ajax_req');
            wp_register_style('myStyle', plugins_url('assets/myStyle.css', __FILE__));
            wp_enqueue_style('myStyle');
        }

        /// Check and Create a database for collecting IP addresses.
        global $wpdb;
        global $table_name_ip, $table_name_pages;
        $table_name_ip = $wpdb->prefix . "client_ip";
        $table_name_pages =  $wpdb->prefix . "pages_history";

        // Initialize when the plugin activated
        function create_db()
        {
            global $wpdb;
            global $table_name_ip, $table_name_pages;
            if ($wpdb->get_var("SHOW TABLES LIKE '$table_name_ip'") != $table_name_ip) {
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                $query_ip = "CREATE TABLE $table_name_ip(
                            `id` INT NOT NULL AUTO_INCREMENT,
                            `ip` VARCHAR(255) NOT NULL UNIQUE,
                            `region` VARCHAR(255),
                            `city` VARCHAR(255),
                            `country` VARCHAR(255) NOT NULL,
                            `longitude` VARCHAR(255) NOT NULL,
                            `latitude` VARCHAR(255) NOT NULL,
                            PRIMARY KEY (`id`)) ENGINE = INNODB;";
                dbDelta($query_ip);
            }
            if ($wpdb->get_var("SHOW TABLES LIKE '$table_name_pages'") != $table_name_pages) {
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                $query_pages = "CREATE TABLE $table_name_pages(
                                `id` INT NOT NULL AUTO_INCREMENT,
                                `client_id` INT NOT NULL,
                                `visited_page` VARCHAR(255) NOT NULL,
                                `time_stamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                PRIMARY KEY(`id`),
                                CONSTRAINT pk_link_IP FOREIGN KEY (`client_id`) REFERENCES $table_name_ip(`id`) ON DELETE CASCADE ON UPDATE CASCADE
                            ) ENGINE = INNODB;";
                dbDelta($query_pages);
            }
        }

        function ipdata_options()
        {
            global $table_name_ip, $table_name_pages, $wpdb;
            $table_name_ip = $wpdb->prefix . "client_ip";
            // check if the user is Admin
            if (!current_user_can('manage_options')) {
                wp_die(__("you don't have the permission to access this page"));
            } else {
                ?>
        
        <div class="container">
            <div class="row header" style="text-align:center;">
                <h3></h3>
            </div><?php
                    global $wpdb;
                    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name_ip'") != $table_name_ip) {
                        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name_pages'") != $table_name_pages) {
                            create_db($table_name_ip, $table_name_pages);
                        }
                    }

                    ?>
            <hr style="height: 10px;">

            </br>
            <div class="stage">
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                    <div class="layer"></div>
                </div>
           
            <div class="row" style="float: right;margin-top: -25px;">
                <div style="margin-left: 10px;margin-right: 20px;">
                    <input type="text" name="from_date" id="start_date" class="form-control dateFilter" placeholder="From Date" />
                </div>
                <div style="margin-left: 10px;">
                    <input type="text" name="to_date" id="end_date" class="form-control dateFilter" placeholder="To Date" />
                </div>
                <div class="col-md-2">
                    <input type="button" name="search" id="btn_search" value="Filter" class="btn btn-primary" style="padding: .2rem .75rem!important; width: 85px;" />
                </div>
            </div>
            </br>
            <hr style="height: 10px;">
            <br /><br />
            <div class="table-responsive">
                <table id='ipTable' class='display dataTable' style="text-align: center;">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="20%">IP Address</th>
                            <th width="14%">Country</th>
                            <th width="10%">City</th>
                            <th width="7%">Longitude</th>
                            <th width="7%">Latitude</th>
                            <th width="16%">Visited Pages</th>
                            <th width="20%">Visit Time</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
<?php
            } // End : Else
        } // End :  function ipdata_options

        // /*
        //  * DataTables server-side processing script.
        //  *
        // */
        if (!function_exists('ajax_hundler_admin')) {
            add_action("wp_ajax_ajax_hundler_admin", "ajax_hundler_admin");
            // add_action( "wp_ajax_nopriv_ajax_hundler_admin", "ajax_hundler_admin" );
            function ajax_hundler_admin()
            {
                global $wpdb;
                include_once plugin_dir_path(__FILE__) . './process.php';
                //   wp_die( );
            }
        }
        // Get IP Address
        if (!function_exists('getClientIP')) {
            function getClientIP()
            {
                if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                };
                foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
                    if (array_key_exists($key, $_SERVER)) {
                        foreach (explode(',', $_SERVER[$key]) as $ip) {
                            $ip = trim($ip);
                            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                                $ip =  getenv($ip);
                            };
                            return $ip == "::1" ? "8.8.8.8" : $ip;
                        };
                    };
                };
                return false;
            };
        };

        function check_for_ip($ip)
        {
            global $wpdb, $host, $user, $password, $dbname;
            $con2 = mysqli_connect($host, $user, $password, $dbname);
            $table_name_ip = $wpdb->prefix . "client_ip";
            mysqli_real_escape_string($con2, $ip);
            $sql1 = "SELECT * FROM $table_name_ip WHERE $table_name_ip.ip= '$ip'"; // SQL with parameters
            $stmt1 = $con2->query($sql1);
            $results_1 = $con2->affected_rows;
            $results_ip = mysqli_affected_rows($con2);
            if ($con2->affected_rows > 0) {
                return true;
            } else {
                return false;
            }
        }
        if (!is_admin() && (!wp_doing_ajax() || (( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX )))) {
            add_action('wp_head', 'getIP_insertToDB');
        }

        function getIP_insertToDB()
        {
            global $wpdb, $con, $host, $user, $password, $dbname;
            global $table_name_ip, $table_name_pages, $IP, $con;
            $table_name_ip = $wpdb->prefix . "client_ip";
            $table_name_pages =  $wpdb->prefix . "pages_history";
            $IP = getClientIP();

            // Start: Get IPData API KEY from DATABASE
            $table_name_api = $wpdb->prefix . "api_table";
            $api_id = 1;
            $sql = "SELECT api_key_value FROM $table_name_api WHERE id=?"; // SQL with parameters
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $api_id);
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            $IPDATA_KEY = $result->fetch_row()[0] ?? false;
            $IPDATA_KEY_STR =  strval($IPDATA_KEY);

            // Start: if IP already exists in DB don't make an IPDATA Request, Else Get IP DAta Info
            $check_ip_exist = check_for_ip($IP);

            // Get Current Page Object.
            $page_object = get_queried_object();
            if (!empty($page_object->post_name)) {
                $current_url = ucfirst($page_object->post_name);
            } else if(is_front_page()){
                $current_url = "Front Page";
            }

            $con3 = mysqli_connect($host, $user, $password, $dbname);
            if ($IPDATA_KEY != null &&  $check_ip_exist === FALSE) {
                $IPDATA_KEY_STR = "?api-key=" . strval($IPDATA_KEY);
                $api_url = "https://api.ipdata.co/" . $IP . $IPDATA_KEY_STR;
                $api_get_contents = file_get_contents($api_url);
                $ipInfo = json_decode($api_get_contents);

                $sql_insert = "INSERT INTO $table_name_ip(ip,region,city,country,longitude,latitude) VALUES('$ipInfo->ip', '$ipInfo->region', '$ipInfo->city', '$ipInfo->country_name', '$ipInfo->longitude', '$ipInfo->latitude')";

                if (mysqli_query($con3, $sql_insert) == TRUE) {
                    $insertId = mysqli_insert_id($con3);
                    $sql_insert_page = "INSERT INTO $table_name_pages(visited_page,client_id) VALUES('$current_url', $insertId )";
                    mysqli_query($con3, $sql_insert_page);
                } else echo " ";
            } else if ($check_ip_exist === TRUE) {
                global $ipInfo, $IP;
                $con3 = mysqli_connect($host, $user, $password, $dbname);
                $table_name_ip = $wpdb->prefix . "client_ip";
                $table_name_pages =  $wpdb->prefix . "pages_history";

                mysqli_real_escape_string($con3, $IP);
                $sql_insert_update = "INSERT INTO $table_name_pages(visited_page,client_id) VALUES('$current_url',(SELECT id from $table_name_ip WHERE ip='" . strval($IP) . "'))";
                mysqli_query($con3, $sql_insert_update);
            }
        } ?>