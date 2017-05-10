<?php
/**
 * Created by Fernalia.
 * Contact : fernalia.h@gmail.com
 * User: Ferna
 * Date: 10/05/2017
 * Time: 10:44
 */

include "connect.php";

function make_query(){
    $order_column  = array("emp_no", "birth_date", "first_name", "last_name", "gender", "hire_date");

    $sql = "SELECT emp_no, birth_date, first_name, last_name, gender, hire_date FROM employees";
    if(isset($_POST["search"]["value"])){
        $sql = $sql . " WHERE emp_no LIKE '%".$_POST["search"]["value"]."%'";
        $sql = $sql . " or birth_date LIKE '%".$_POST["search"]["value"]."%'";
        $sql = $sql . " or first_name LIKE '%".$_POST["search"]["value"]."%'";
        $sql = $sql . " or last_name LIKE '%".$_POST["search"]["value"]."%'";
        $sql = $sql . " or gender LIKE '%".$_POST["search"]["value"]."%'";
        $sql = $sql . " or hire_date LIKE '%".$_POST["search"]["value"]."%'";
    }

    if(isset($_POST["order"])){
        $sql = $sql . " ORDER BY " . $order_column[$_POST['order']['0']['column']] . " " . $_POST['order']['0']['dir'];
    } else{
        $sql = $sql . " ORDER BY emp_no ASC";
    }

    return $sql;
}

function make_datatables(){
    $sql = make_query();
    if($_POST["length"] != -1){
        $sql = $sql . " LIMIT " . $_POST["start"] . ", " . $_POST["length"];
    }

    $query = mysql_query($sql);
    return $query;
}

function get_flltered_data(){
    $sql   = make_query();
    $query = mysql_query($sql);
    return mysql_num_rows($query);
}

function get_all_data(){
    $sql   = "SELECT * FROM employees";
    $query = mysql_query($sql);
    return mysql_num_rows($query);
}

$fetch_data = make_datatables();
$data = array();

$i = 1;
while($row = mysql_fetch_array($fetch_data)){
    $sub_array = array();

    $sub_array[] = $row['emp_no'];
    $sub_array[] = $row['birth_date'];
    $sub_array[] = $row['first_name'];
    $sub_array[] = $row['last_name'];
    $sub_array[] = $row['gender'];
    $sub_array[] = $row['hire_date'];
            
    $data[] = $sub_array;
}

$output = array(
    "draw"            => intval($_REQUEST["draw"]),
    "recordsTotal"    => get_all_data(),
    "recordsFiltered" => get_flltered_data(),
    "data"            => $data
);

echo json_encode($output);