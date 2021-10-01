 <?php
/*
 * DataTables server-side processing script implementing Ajax calls by WordPress.
 *
*/
if (!defined('ABSPATH')) {
    echo "Access Denied";
}
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '\wp-load.php');
include(plugin_dir_path(__FILE__) . '/database_connection.php');

    global $wpdb;
    global $table_name_ip, $table_name_pages;
    $table_name_ip = $wpdb->prefix . "client_ip";
    $table_name_pages =  $wpdb->prefix . "pages_history";


    ## Read value
    $request = $_REQUEST;
    $draw = $request['draw'];
    $start = $request['start'];
    $rowperpage = $request['length']; // Rows display per page
    $columnIndex = $request['order'][0]['column']; // Column index
    $columnName = $request['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $request['order'][0]['dir']; // asc or desc
    $searchValue = mysqli_real_escape_string($con, $request['search']['value']); // Search value
    ## Date search value
    $searchByFromdate = mysqli_real_escape_string($con, $request['searchByFromdate']);
    $searchByTodate = mysqli_real_escape_string($con, $request['searchByTodate']);

    if ($request['length'] == -1) {
        $sql_length = "SELECT $table_name_ip.id,ip,country,city,longitude,latitude,$table_name_pages.visited_page, $table_name_pages.time_stamp FROM $table_name_ip JOIN $table_name_pages";
        $rowperpage = mysqli_num_rows(mysqli_query($con, $sql_length));
    }

    ## Search
    ## Total number of records without filtering
    $sel = mysqli_query($con, "SELECT COUNT(id) as allcount from $table_name_pages");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];



    if (!empty($searchValue) && empty($searchByFromdate)  && empty($searchByTodate)) {

        ## Total number of record with filtering
        $sql_count_filter = "SELECT COUNT($table_name_pages.id) as allcountfilter from $table_name_pages JOIN $table_name_ip WHERE $table_name_ip.id = $table_name_pages.client_id AND( $table_name_ip.ip like '%" . $searchValue . "%' OR country like '%" . $searchValue . "%' OR city like '%" . $searchValue . "%' OR $table_name_ip.id like '%" . $searchValue . "%' OR visited_page like '%" . $searchValue . "%' OR time_stamp like '%" . $searchValue . "%')";
        $sel1 = mysqli_query($con, $sql_count_filter);
        $records2 = mysqli_fetch_assoc($sel1);
        $totalRecordwithFilter = $records2['allcountfilter'];

        ## Fetch records
        $fetch_records = "SELECT $table_name_ip.id,ip,country,city,longitude,latitude,$table_name_pages.visited_page, $table_name_pages.time_stamp FROM $table_name_ip JOIN $table_name_pages WHERE $table_name_ip.id = $table_name_pages.client_id AND( $table_name_ip.ip like '%" . $searchValue . "%' OR country like '%" . $searchValue . "%' OR city like '%" . $searchValue . "%' OR $table_name_ip.id like '%" . $searchValue . "%' OR visited_page like '%" . $searchValue . "%' OR time_stamp like '%" . $searchValue . "%') order by " . $columnName . " " . $columnSortOrder . " limit " . $start . "," . $rowperpage;
        $showRecord = mysqli_query($con, $fetch_records);
    } else if (empty($searchValue) && empty($searchByFromdate)  && empty($searchByTodate)) {
        ## Total number of record with Filtering
        $sel1 = mysqli_query($con, "SELECT COUNT(id) as allcountfilter from $table_name_pages");
        $records2 = mysqli_fetch_assoc($sel1);
        $totalRecordwithFilter = $records2['allcountfilter'];

        ## Fetch records without Filtering.
        $fetch_records = "SELECT $table_name_ip.id,ip,country,city,longitude,latitude,$table_name_pages.visited_page, $table_name_pages.time_stamp FROM $table_name_ip JOIN $table_name_pages order by " . $columnName . " " . $columnSortOrder . " limit " . $start . "," . $rowperpage;
        $showRecord = mysqli_query($con, $fetch_records);
    } else
    if (empty($searchValue) && !empty($searchByFromdate)  && !empty($searchByTodate)) {
        ## Total number of record with Filtering
        $sql_filt = mysqli_query($con, "SELECT count($table_name_ip.id) as allcountfilter FROM $table_name_ip JOIN $table_name_pages WHERE $table_name_ip.id = $table_name_pages.client_id AND ($table_name_pages.time_stamp >= '$searchByFromdate' AND $table_name_pages.time_stamp <= '$searchByTodate')");
        $records2 = mysqli_fetch_assoc($sql_filt);
        $totalRecordwithFilter = $records2['allcountfilter'];


        $fetch_records = "SELECT $table_name_ip.id,ip,country,city,longitude,latitude,$table_name_pages.visited_page, $table_name_pages.time_stamp FROM $table_name_ip JOIN $table_name_pages WHERE $table_name_ip.id = $table_name_pages.client_id AND ($table_name_pages.time_stamp >= '$searchByFromdate' AND $table_name_pages.time_stamp <= '$searchByTodate') order by " . $columnName . " " . $columnSortOrder . " limit " . $start . "," . $rowperpage;
        // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $showRecord = mysqli_query($con, $fetch_records);
    }


    $data = array();
    while ($rowx = mysqli_fetch_assoc($showRecord)) {
        $data[] = array(
            "id" => $rowx['id'],
            "ip" => $rowx['ip'],
            "country" => $rowx['country'],
            "city" => strval($rowx['city']),
            "longitude" => $rowx['longitude'],
            "latitude" => $rowx['latitude'],
            "visited_page" => $rowx['visited_page'],
            "time_stamp" => $rowx['time_stamp']

        );
    }


    ## Response
    $response = array(
        "draw" => intval($request['draw']),
        "iTotalRecords" => intval($totalRecords),
        "iTotalDisplayRecords" => intval($totalRecordwithFilter),
        "aaData" => $data
    );

    echo json_encode($response);
    wp_die();
    ?>
