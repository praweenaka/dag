<?php

session_start();
include_once("connectioni.php");
////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////


if ($_GET["Command"] == "new_inv") {

    include_once("connectioni.php");
}


if ($_GET["Command"] == "cancel_inv") {
    $sql = "select last_update from invpara  ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);

    //mysql_query("BEGIN");  
    $sql1 = "delete from stk_take_mas where ref_no ='" . trim($_GET['refno']) . "' ";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

    $sql1 = "delete from stk_take where REF_NO ='" . trim($_GET['refno']) . "' ";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

    $sql1 = "delete from tmp_stk_take where REF_NO ='" . trim($_GET['refno']) . "' ";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);


    //mysql_query("COMMIT");  

    echo "Canceled";
}



if ($_GET["Command"] == "add_tmp") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $mcount = 0;

    //$sql="delete from tmp_ord_data where tmp_no='".$_SESSION["tmp_no_ord"]."' and str_code='".$_GET['itemcode']."' ";
    //echo $sql;
    //$ResponseXML .= $sql;
    //$result =mysqli_query($GLOBALS['dbinv'],$sql);
    //echo $_GET['rate'];
    //echo $_GET['qty'];
    //$sql="delete from tmp_stk_take_undelever  where REF_NO='".$_GET['refno']."'";
    //$result =mysqli_query($GLOBALS['dbinv'],$sql);	

    $rate = str_replace(",", "", $_GET["rate"]);
    $qty = str_replace(",", "", $_GET["qty"]);

    $sql_brand = "select * from s_mas where STK_NO='" . $_GET['itemcode'] . "'";
    $result_brand = mysqli_query($GLOBALS['dbinv'], $sql_brand);
    $row_brand = mysqli_fetch_array($result_brand);

    // $sql="delete from tmp_stk_take where STK_NO='".$_GET['itemcode']."'";
    // $ResponseXML .= $sql;
    // $result =mysqli_query($GLOBALS['dbinv'],$sql);	

    // $sql123="delete from tmp_stk_take where STK_NO='".$_GET['itemcode']."' and REF_NO ='" . $_GET['refno'] . "'";
    // // $ResponseXML .= $sql;
    // $result123 =mysqli_query($GLOBALS['dbinv'],$sql123);  

    if ($_GET["damage"] == "") {
        $damage = 0;
    } else {
        $damage = $_GET["damage"];
    }

    $sql = "Insert into tmp_stk_take (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, QTY, damage, BRAND, COST)values 
			('" . $_GET['refno'] . "', '" . date("Y-m-d") . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', '" . $_GET['part_no'] . "', " . $qty . ", " . $damage . ", '" . $row_brand["BRAND_NAME"] . "', " . $rate . ") ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);


    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Damage</font></td>							 
                            </tr>";


    $sql = "Select * from tmp_stk_take where REF_NO='" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td >" . $row['STK_NO'] . "</a></td>
							 <td >" . $row['DESCRIPT'] . "</a></td>
							 <td >" . $row['PART_NO'] . "</a></td>
							 <td >" . number_format($row['cost'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['QTY'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['damage'], 2, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['STK_NO'] . "  name=" . $row['STK_NO'] . " onClick=\"del_item('" . $row['STK_NO'] . "');\"></td>";
    }
    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";




    echo $ResponseXML;
}



if ($_GET["Command"] == "delete_inv") {
    $sql = "select * from S_CUSORDMAS where REF_NO= '" . trim($_GET["salesord1"]) . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $sql1 = "UPDATE S_CUSORDMAS SET S_CUSORDMAS.CANCELL = '1' WHERE (((S_CUSORDMAS.REF_NO)='" . trim($_GET["salesord1"]) . "'))";

        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql1 = "UPDATE S_CUSORDTRN SET S_CUSORDTRN.CANCELL = '1' WHERE (((S_CUSORDTRN.REF_NO)='" . trim($_GET["salesord1"]) . "'))";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }
    echo "Canceled";
}


if ($_GET["Command"] == "del_item") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_stk_take where REF_NO='" . $_GET['refno'] . "' and STK_NO='" . $_GET['itemcode'] . "' ";
    //echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              							 
                            </tr>";


    $sql = "Select * from tmp_stk_take where REF_NO='" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td >" . $row['STK_NO'] . "</a></td>
							 <td >" . $row['DESCRIPT'] . "</a></td>
							 <td >" . $row['PART_NO'] . "</a></td>
							 <td >" . number_format($row['cost'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['QTY'], 2, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['STK_NO'] . "  name=" . $row['STK_NO'] . " onClick=\"del_item('" . $row['STK_NO'] . "');\"></td>";
    }
    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";




    echo $ResponseXML;
}


if ($_GET["Command"] == "find_inv") {

    require_once("config.inc.php");
    require_once("DBConnector.php");
    $db = new DBConnector();



    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $mcount = 0;

    //$sql="delete from tmp_ord_data where tmp_no='".$_SESSION["tmp_no_ord"]."' and str_code='".$_GET['itemcode']."' ";
    //echo $sql;
    //$ResponseXML .= $sql;
    //$result =mysqli_query($GLOBALS['dbinv'],$sql);
    //echo $_GET['rate'];
    //echo $_GET['qty'];
    //$sql="delete from tmp_stk_take_undelever  where REF_NO='".$_GET['refno']."'";
    //$result =mysqli_query($GLOBALS['dbinv'],$sql);	

    $sql = "delete from tmp_stk_take where REF_NO='" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);


    $sql = "select * from stk_take where REF_NO='" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $sql1 = "Insert into tmp_stk_take (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, QTY, damage, BRAND, COST)values 
			('" . $row["REF_NO"] . "', '" . $row["SDATE"] . "', '" . $row["STK_NO"] . "', '" . $row["DESCRIPT"] . "', '" . $row['PART_NO'] . "', " . $row["QTY"] . ", " . $row["damage"] . ", '" . $row["BRAND"] . "', " . $row["COST"] . ") ";


        //echo $sql1;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              							 
                            </tr>";


    $sql = "Select * from tmp_stk_take where REF_NO='" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td >" . $row['STK_NO'] . "</a></td>
							 <td >" . $row['DESCRIPT'] . "</a></td>
							 <td >" . $row['PART_NO'] . "</a></td>
							 <td >" . number_format($row['cost'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['QTY'], 2, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['STK_NO'] . "  name=" . $row['STK_NO'] . " onClick=\"del_item('" . $row['STK_NO'] . "');\"></td>";
    }


    $ResponseXML .= "   </table>]]></sales_table>";

    $sql = "select * from stk_take_mas where ref_no='" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);

    $ResponseXML .= "<location><![CDATA[" . $row["location"] . "]]></location>";
    $ResponseXML .= " </salesdetails>";




    echo $ResponseXML;
}


if ($_GET["Command"] == "save_item") {


    //	$_SESSION["CURRENT_DOC"] = 1;      //document ID
    //$_SESSION["VIEW_DOC"] = false ;     //view current document
    //	$_SESSION["FEED_DOC"] = true;       //save  current document
    //	$_GET["MOD_DOC"] = false  ;         //delete   current document
    //	$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
    //	$_GET["PRICE_EDIT"] = false ;       //edit selling price
    //	$_GET["CHECK_USER"] = false ;       //check user permission again





    $sql = "Select *  from stk_take_mas where ref_no ='" . trim($_GET['refno']) . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {

        $sql1 = "delete from stk_take_mas where ref_no ='" . trim($_GET['refno']) . "' ";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql1 = "delete from stk_take where REF_NO ='" . trim($_GET['refno']) . "' ";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }

    //mysql_query("BEGIN");  

    $sql1 = "Insert into stk_take_mas (ref_no, sdate, location) values('" . trim($_GET['refno']) . "', '" . date("Y-m-d") . "', '" . $_GET["location"] . "')";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);


    $sql = "Select *  from tmp_stk_take where REF_NO ='" . trim($_GET['refno']) . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $sql1 = "Insert into stk_take (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, QTY, damage, BRAND, COST) values('" . trim($row["REF_NO"]) . "', '" . date("Y-m-d") . "', '" . trim($row["STK_NO"]) . "','" . trim($row["DESCRIPT"]) . "','" . trim($row["PART_NO"]) . "'," . $row["QTY"] . "," . $row["damage"] . ",'" . trim($row["BRAND"]) . "'," . $row["COST"] . ")";
        //echo $sql1;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }

    $sql = "delete  from tmp_stk_take where REF_NO ='" . trim($_GET['refno']) . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    //mysql_query("COMMIT");  


    echo "Saved";
}

if ($_GET["Command"] == "check_print") {

    echo $_SESSION["print"];
}


if ($_GET["Command"] == "tmp_crelimit") {
    echo "abc";
    $crLmt = 0;
    $cat = "";

    $rep = trim(substr($_GET["Com_rep1"], 0, 5));

    $sql = "select * from br_trn where rep='" . $rep . "' and cus_code='" . trim($_GET["txt_cuscode"]) . "' and brand='" . trim($_GET["cmbbrand1"]) . "'";
    echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $crLmt = $row["credit_lim"];
        If (is_null($row["cat"]) == false) {
            $cat = trim($row["cat"]);
        } else {
            $crLmt = 0;
        }
    }
    /* 	
      $_SESSION["CURRENT_DOC"] = 66     //document ID
      //$_SESSION["VIEW_DOC"] = true      //  view current document
      $_SESSION["FEED_DOC"] = true      //  save  current document
      //$_SESSION["MOD_DOC"] = true       //   delete   current document
      //$_SESSION["PRINT_DOC"] = true     // get additional print   of  current document
      //$_SESSION["PRICE_EDIT"]= true     // edit selling price
      $_SESSION["CHECK_USER"] = true    // check user permission again
      $crLmt = $crLmt;
      setlocale(LC_MONETARY, "en_US");
      $CrTmpLmt = number_format($_GET["txt_tmeplimit"], 2, ".", ",");

      $REFNO = trim($_GET["txt_cuscode"]) ;

      $AUTH_USER="tmpuser";

      $sql = "insert into tmpCrLmt (sdate, stime, username, tmpLmt, class, rep, cuscode, crLmt, cat) values
      ('".date("Y-m-d")."','".date("H:i:s", time())."' ,'".$AUTH_USER."',".$CrTmpLmt." ,'".trim($_GET["cmbbrand1"])."','".$rep."','".trim($_GET["txt_cuscode"])."',".$crLmt.",'".$cat"' )";
      $result =mysqli_query($GLOBALS['dbinv'],$sql);

      $sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
      $result =mysqli_query($GLOBALS['dbinv'],$sql);
      if ($row = mysqli_fetch_array($result)) {
      $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
      $resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);

      } else {

      $sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
      $resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);

      //	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
      }

      If ($_GET["Check1"] == 1) {
      $sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
      $resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
      } else {
      $sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
      $resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
      }

      echo "Tempory limit updated"; */
}
?>