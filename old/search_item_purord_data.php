<?php

/*
  include_once("connectioni.php");
  include_once("DBConnector.php");
  $letters = $_GET['letters'];

  $sql="SELECT * FROM mast_family where name like '".$letters."%'";
  $result =mysqli_query($GLOBALS['dbinv'],$sql) ;


  while($row = mysqli_fetch_array($result))
  {

  echo $row["name"];

  }

 */


session_start();


include_once("connectioni.php");

if ($_GET["Command"] == "search_item") {

//	if(isset($_GET['itemname'])){
//		$letters = $_GET['itemname'];
    //$letters = $_GET['letters'];
//		$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
//	$res = mysqli_query($GLOBALS['dbinv'],"SELECT * FROM mast_family where name like '".$letters."%'") or die(mysqli_error());
    //$res = mysqli_query($GLOBALS['dbinv'],"SELECT distinct trn_involved.str_name FROM trn_involved where str_name like '".$letters."%'") or die(mysqli_error());
    //SELECT * FROM occupation_details where str_first_name like 'k%'
//echo $res;

    $ResponseXML .= "";
    //$ResponseXML .= "<invdetails>";



    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Item No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Item Description</font></td>
							  <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Stock In Hand</font></td>
                             
   							</tr>";


    if ($_GET["mstatus"] == "itno") {
        $letters = $_GET['itno'];
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $letters);
        if (isset($_SESSION["brand"]) == true) {
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_mas where STK_NO like  '$letters%' and BRAND_NAME='" . $_SESSION["brand"] . "' order by STK_NO limit 50") or die(mysqli_error());
        } else {
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_mas where STK_NO like  '$letters%' order by STK_NO limit 50") or die(mysqli_error());
        }
    } else if ($_GET["mstatus"] == "itemname") {
        $letters = $_GET['itemname'];
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $letters);
        if (isset($_SESSION["brand"]) == true) {
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_mas where DESCRIPT like  '$letters%' and BRAND_NAME='" . $_SESSION["brand"] . "' order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    } else {

        $letters = $_GET['itemname'];
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $letters);
        if (isset($_SESSION["brand"]) == true) {
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_mas where DESCRIPT like  '$letters%' and BRAND_NAME='" . $_SESSION["brand"] . "' order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    }


    while ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<tr>
                              <td bgcolor=\"#222222\" onclick=\"itno('" . $row['STK_NO'] . "');\">" . $row['STK_NO'] . "</a></td>
                              <td bgcolor=\"#222222\" onclick=\"itno('" . $row['STK_NO'] . "');\">" . $row['DESCRIPT'] . "</a></td>";

        $department = $_SESSION["department"];

        $sql1 = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $row['STK_NO'] . "' AND STO_CODE='" . $department . "'") or die(mysqli_error()) or die(mysqli_error());
        if ($row1 = mysqli_fetch_array($sql1)) {
            $ResponseXML .= "<td bgcolor=\"#222222\" onclick=\"itno('" . $row['STK_NO'] . "');\">" . $row1['QTYINHAND'] . "</a></td>";
        }

        $ResponseXML .= "</tr>";
    }

    $ResponseXML .= "   </table>";


    echo $ResponseXML;
    //}
}

if ($_GET["Command"] == "search_inv") {

    $ResponseXML .= "";
    //$ResponseXML .= "<invdetails>";



    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Order No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Supplier</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Order Date</font></td>
                             
   							</tr>";

    if ($_GET["mstatus"] == "invno") {
        $letters = $_GET['invno'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        //$letters="/".$letters;
        //$a="SELECT * from s_salma where REF_NO like  '$letters%'";
        //echo $a;
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_ordmas where cancel='0' and REFNO like  '$letters%' order by S_date desc  limit 50") or die(mysqli_error());
    } else if ($_GET["mstatus"] == "customername") {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_ordmas where cancel='0' and SUP_NAME like  '$letters%' order by S_date desc  limit 50") or die(mysqli_error()) or die(mysqli_error());
    } else {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_ordmas where cancel='0' and SUP_NAME like  '$letters%' order by S_date desc  limit 50") or die(mysqli_error()) or die(mysqli_error());
    }



    while ($row = mysqli_fetch_array($sql)) {
        $REF_NO = $row['REF_NO'];
        $stname = "inv_mast";
        $ResponseXML .= "<tr>
                           	  <td onclick=\"purord('" . $row['REFNO'] . "', '" . $_GET['stname'] . "');\">" . $row['REFNO'] . "</a></td>
                              <td onclick=\"purord('" . $row['REFNO'] . "', '" . $_GET['stname'] . "');\">" . $row['SUP_NAME'] . "</a></td>
                              <td onclick=\"purord('" . $row['REFNO'] . "', '" . $_GET['stname'] . "');\">" . $row['S_date'] . "</a></td>
                                                        	
                            </tr>";
    }

    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}


if ($_GET["Command"] == "pass_itno") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    if ($_GET["brand"] != "") {
        //echo "Select * from s_mas where STK_NO='".$_GET['itno']."' and BRAND_NAME='".$_GET["brand"]."'";
        $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $_GET['itno'] . "' and BRAND_NAME='" . $_GET["brand"] . "'") or die(mysqli_error());
    } else {
        $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $_GET['itno'] . "'") or die(mysqli_error());
    }

    if ($row = mysqli_fetch_array($sql)) {



        $ResponseXML .= "<str_code><![CDATA[" . $row['STK_NO'] . "]]></str_code>";
        $ResponseXML .= "<str_description><![CDATA[" . $row['DESCRIPT'] . "]]></str_description>";
        $ResponseXML .= "<str_partno><![CDATA[" . $row['PART_NO'] . "]]></str_partno>";
        //$ResponseXML .= "<str_selpri><![CDATA[".$row['SELLING']."]]></str_selpri>";
    }




    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_assignbrand") {
    $_SESSION["brand"] = $_GET["brand"];
    $_SESSION["department"] = $_GET["department"];
}
?>
