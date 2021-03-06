<?php

session_start();

require_once ("connectioni.php");
require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

 
 if ($_GET["Command"] == "update_list") {
    $ResponseXML = "";
    $ResponseXML .= "<table class=\"table\">
	            <tr>
                        <th width=\"121\">Item No</th>
                        <th width=\"424\"> Item Description </th>
                        
                        <th width=\"121\">Brand</th>  
                        <th width=\"121\">Amount</th>  
                        <th width=\"121\">QTY In Hand</th>  
                    </tr>";


    $sql = "SELECT * from s_mas where stk_no <> ''";
    if ($_GET['refno'] != "") {
        $sql .= " and stk_no like '%" . $_GET['refno'] . "%'";
    }
    if ($_GET['cusname'] != "") {
        $sql .= " and DESCRIPT like '%" . $_GET['cusname'] . "%'";
    }   
     if ($_GET['chk_stock'] == "1") {
        $sql .= " and qtyinhand >0";
    }
    if ($_GET['chk_stockall'] == "0") {
        $sql .= " and active='1'";
    }
    if ($_GET['cmbbrand'] != "All") {
        $sql .= " and BRAND_NAME ='" . $_SESSION["brand"]  . "'";
    }
    $stname = $_GET['stname'];

    $sql .= " ORDER BY stk_no limit 50";
 
    foreach ($conn->query($sql) as $row) {
        $cuscode = $row["STK_NO"];


        $ResponseXML .= "<tr>               
                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['STK_NO'] . "</a></td>
                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['DESCRIPT'] . "</a></td>
                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['BRAND_NAME'] . "</a></td>
                               <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['SELLING'] . "</a></td>
                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['QTYINHAND'] . "</a></td>
                            </tr>";
    }
    $ResponseXML .= "</table>";
    echo $ResponseXML;
}
?>