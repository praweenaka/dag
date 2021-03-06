<?php

session_start();







include_once("connectioni.php");

if ($_GET["Command"] == "search_item") {



    $ResponseXML = "";




    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><strong><font color=\"#FFFFFF\">Item No</font></strong></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Item Description</font></strong></td>
                               <td width=\"150\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Brand Name</font></strong></td>
                              <td width=\"150\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Stock In Hand</font></strong></td>
                             <td width=\"150\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Price</font></strong></td>
   							</tr>";


    $sql = "SELECT * from s_mas where stk_no <> ''";
    if ($_GET["mstatus"] == "itno") {
        $letters = $_GET['itno'];
        $sql .= " and STK_NO like  '$letters%'";
    } elseif ($_GET["mstatus"] == "itemname") {
        $letters = $_GET['itemname'];
        $sql .= " and DESCRIPT like  '$letters%'";
    } else {
        $letters = $_GET['itemname'];
        $sql .= " and DESCRIPT like  '$letters%'";
    }
    if ($_GET["checkbox"] == "true") {
        $sql .= " and QTYINHAND>0";
    }
    if ($_GET["brand"] != "All") {
        $sql .= " and BRAND_NAME ='" . $_GET["brand"] . "'";
    }
    $sql .= " order by STK_NO ";

    $sql = mysqli_query($GLOBALS['dbinv'], $sql);

    /* if ($_GET["checkbox"]=="true"){									
      if ($_GET["mstatus"]=="itno"){
      $letters = $_GET['itno'];

      $sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where STK_NO like  '$letters%' and QTYINHAND>0 order by STK_NO limit 500") or die(mysqli_error());

      } else if ($_GET["mstatus"]=="itemname"){
      $letters = $_GET['itemname'];

      $sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where DESCRIPT like  '$letters%' and QTYINHAND>0 order by STK_NO limit 500") or die(mysqli_error()) or die(mysqli_error());

      } else {

      $letters = $_GET['itemname'];

      $sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where DESCRIPT like  '$letters%' and QTYINHAND>0 order by STK_NO limit 500") or die(mysqli_error()) or die(mysqli_error());

      }

      } else {
      if ($_GET["mstatus"]=="itno"){
      $letters = $_GET['itno'];

      $sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where STK_NO like  '$letters%' order by STK_NO limit 500") or die(mysqli_error());

      } else if ($_GET["mstatus"]=="itemname"){
      $letters = $_GET['itemname'];

      $sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO limit 500") or die(mysqli_error()) or die(mysqli_error());

      } else {

      $letters = $_GET['itemname'];

      $sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO limit 500") or die(mysqli_error()) or die(mysqli_error());

      }
      } */

    while ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<tr>
                              <td onclick=\"itno('" . $row['STK_NO'] . "');\">" . $row['STK_NO'] . "</a></td>
                              <td onclick=\"itno('" . $row['STK_NO'] . "');\">" . $row['DESCRIPT'] . "</a></td>
							   <td onclick=\"itno('" . $row['STK_NO'] . "');\">" . $row['BRAND_NAME'] . "</a></td>
							   <td onclick=\"itno('" . $row['STK_NO'] . "');\">" . number_format($row['QTYINHAND'], 0, ".", ",") . "</a></td>
							    <td onclick=\"itno('" . $row['STK_NO'] . "');\">" . number_format($row['SELLING'], 2, ".", ",") . "</a></td>";



        $ResponseXML .= "</tr>";
    }

    $ResponseXML .= "   </table>";


    echo $ResponseXML;
    //}
}

$display_val = "";
if ($_GET["Command"] == "pass_itno") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $_GET['itno'] . "' ") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {


        $ResponseXML .= "<STK_NO><![CDATA[" . $row['STK_NO'] . "]]></STK_NO>";
        $ResponseXML .= "<DESCRIPT><![CDATA[" . $row['DESCRIPT'] . "]]></DESCRIPT>";
        $ResponseXML .= "<SELLING><![CDATA[" . $row['SELLING'] . "]]></SELLING>";
        $ResponseXML .= "<PART_NO><![CDATA[" . $row['PART_NO'] . "]]></PART_NO>";
        $ResponseXML .= "<qtyinhand><![CDATA[" . $row['QTYINHAND'] . "]]></qtyinhand>";
        $dt = date('Y-m-d', strtotime(date('Y-m-d') . ' - 90 days'));
        $sql1 = mysqli_query($GLOBALS['dbinv'], "Select sum(REC_QTY) as stk from s_purtrn where STK_NO='" . $row['STK_NO'] . "' and CANCEL='0' and SDATE>'" . $dt . "' ") or die(mysqli_error());
        $row1 = mysqli_fetch_array($sql1);

        $mnewstk = 0;
        $unsold = 0;
        if (is_null($row1["stk"]) == false) {
            $mnewstk = $row1["stk"];
        }

        if ($row["QTYINHAND"] > $row1["stk"]) {
            $unsold = $row["QTYINHAND"] - $mnewstk;
        }

        if ($row['active_t'] == "1") {
            $ResponseXML .= "<active_t><![CDATA[" . $row['active_t'] . "]]></active_t>";
        } else {
            $ResponseXML .= "<active_t><![CDATA[]]></active_t>";
        }

        $ResponseXML .= "<unsold><![CDATA[" . $unsold . "]]></unsold>";

        $ResponseXML .= "<SALE01><![CDATA[" . number_format($row['SALE01'], 0, ".", ",") . "]]></SALE01>";
        $ResponseXML .= "<SALE02><![CDATA[" . number_format($row['SALE02'], 0, ".", ",") . "]]></SALE02>";
        $ResponseXML .= "<SALE03><![CDATA[" . number_format($row['SALE03'], 0, ".", ",") . "]]></SALE03>";
        $ResponseXML .= "<SALE04><![CDATA[" . number_format($row['SALE04'], 0, ".", ",") . "]]></SALE04>";
        $ResponseXML .= "<SALE05><![CDATA[" . number_format($row['SALE05'], 0, ".", ",") . "]]></SALE05>";
        $ResponseXML .= "<SALE06><![CDATA[" . number_format($row['SALE06'], 0, ".", ",") . "]]></SALE06>";
        $ResponseXML .= "<SALE07><![CDATA[" . number_format($row['SALE07'], 0, ".", ",") . "]]></SALE07>";
        $ResponseXML .= "<SALE08><![CDATA[" . number_format($row['SALE08'], 0, ".", ",") . "]]></SALE08>";
        $ResponseXML .= "<SALE09><![CDATA[" . number_format($row['SALE09'], 0, ".", ",") . "]]></SALE09>";
        $ResponseXML .= "<SALE10><![CDATA[" . number_format($row['SALE10'], 0, ".", ",") . "]]></SALE10>";
        $ResponseXML .= "<SALE11><![CDATA[" . number_format($row['SALE11'], 0, ".", ",") . "]]></SALE11>";
        $ResponseXML .= "<SALE12><![CDATA[" . number_format($row['SALE12'], 0, ".", ",") . "]]></SALE12>";

        $avg = ($row['SALE01'] + $row['SALE02'] + $row['SALE03'] + $row['SALE04'] + $row['SALE05'] + $row['SALE06'] + $row['SALE07'] + $row['SALE08'] + $row['SALE09'] + $row['SALE10'] + $row['SALE11'] + $row['SALE12']) / 12;
        $avg = number_format($avg, 0, "", ",");

        $ResponseXML .= "<avg><![CDATA[" . $avg . "]]></avg>";

        $ResponseXML .= " <sales_table><![CDATA[ <table>
                                      <tr>
                                         <td width=\"122\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Department</font></td>
                                         <td width=\"101\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Stock</font></td>
										 <td width=\"101\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">AD</font></td>
                                      </tr>";

        $sql2 = mysqli_query($GLOBALS['dbinv'], "Select * from s_stomas") or die(mysqli_error());
        while ($row2 = mysqli_fetch_array($sql2)) {
            //echo "Select QTYINHAND from s_submas where STO_CODE='".$row2["CODE"]."' and STK_NO='".$row["STK_NO"]."'";
            $sql3 = mysqli_query($GLOBALS['dbinv'], "Select QTYINHAND from s_submas where STO_CODE='" . $row2["CODE"] . "' and STK_NO='" . $row["STK_NO"] . "'") or die(mysqli_error());
            if ($row3 = mysqli_fetch_array($sql3)) {

                if (number_format($row3["QTYINHAND"], 0, ".", ",") != 0) {
                    $ResponseXML .= "  <tr>
                                               	<td width=\"122\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">" . $row2["DESCRIPTION"] . "</font></td>
                                               	<td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\" align=right>" . number_format($row3["QTYINHAND"], 0, ".", ",") . "</font></td>";

                    $sql4 = mysqli_query($GLOBALS['dbinv'], "Select QTYINHAND from s_submas_ad where STO_CODE='" . $row2["CODE"] . "' and STK_NO='" . $row["STK_NO"] . "'") or die(mysqli_error());

                    if ($row4 = mysqli_fetch_array($sql4)) {

                        $ResponseXML .= "<td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\" align=right>" . number_format($row4["QTYINHAND"], 0, ".", ",") . "</font></td>";
                    } else {
                        $ResponseXML .= "<td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">0</font></td>";
                    }
                }
                $ResponseXML .= "</tr>";
            } else {
                /*  $ResponseXML .= "  <tr>
                  <td width=\"122\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">".$row2["DESCRIPTION"]."</font></td>
                  <td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">0</font></td>
                  <td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">0</font></td>
                  </tr>"; */
            }
        }

        $ResponseXML .= "   </table>]]></sales_table>";
    }
    display();

    //$ResponseXML .= display();

    $ResponseXML .= $GLOBALS[$display_val];

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

function display() {


    $sqlrsmas = mysqli_query($GLOBALS['dbinv'], "Select qtyinhand from s_mas where stk_no = '" . $_GET["itno"] . "'") or die(mysqli_error());
    $rowsmas = mysqli_fetch_array($sqlrsmas);

    $sqltrn = mysqli_query($GLOBALS['dbinv'], "select sum(qty) as qty from s_trn where sdate >= '" . $_GET["dte_from"] . "' and stk_no = '" . $_GET["itno"] . "' and ledindi <> 'INV' and ledindi <> 'GINI' and ledindi <> 'GINR' and ledindi <> 'IOU' and ledindi <> 'ARR' ") or die(mysqli_error());
    $rowstrn = mysqli_fetch_array($sqltrn);
    If (!Is_Null($rowstrn['qty'])) {
        $BAL = $rowstrn['qty'];
    }

    $sqltrn = mysqli_query($GLOBALS['dbinv'], "select sum(qty) as qty from s_trn where sdate >= '" . $_GET["dte_from"] . "' and stk_no = '" . $_GET["itno"] . "' and ledindi <> 'TRN' and ledindi <> 'GINI' and ledindi <> 'GINR' and ledindi <> 'IIN' and ledindi <> 'ARN' and ledindi <> 'GRN' ") or die(mysqli_error());
    $rowstrn = mysqli_fetch_array($sqltrn);
    If (!Is_Null($rowstrn['qty'])) {
        $BAL = $BAL - $rowstrn['qty'];
    }


    If ($BAL != $rowsmas['qtyinhand']) {
        $BAL = $BAL - $rowsmas['qtyinhand'];
    } else {
        $BAL = 0;
    }


    if ($_GET["department"] == "All") {

        $sql = mysqli_query($GLOBALS['dbinv'], "select * from s_trn where  ( SDATE <  '" . $_GET["dte_from"] . "') and STK_NO='" . $_GET["itno"] . "' and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY id") or die(mysqli_error());
    } else {

        $sql = mysqli_query($GLOBALS['dbinv'], "select * from s_trn where  ( SDATE <  '" . $_GET["dte_from"] . "') and STK_NO='" . $_GET["itno"] . "' and DEPARTMENT='" . $_GET["department"] . "' ORDER by id") or die(mysqli_error());
    }


    $M_BAL = 0;
    while ($row = mysqli_fetch_array($sql)) {

        //===stock out
        if (($row["LEDINDI"] == "INV") or ( $row["LEDINDI"] == "ORC") or ( $row["LEDINDI"] == "GINI") or ( $row["LEDINDI"] == "ARR") or ( $row["LEDINDI"] == "IOU")) {
            $M_BAL = $M_BAL - $row["QTY"];
        }

        //====stock in
        if (($row["LEDINDI"] == "ARN") or ( $row["LEDINDI"] == "GINR") or ( $row["LEDINDI"] == "CRN") or ( $row["LEDINDI"] == "GRN") or ( $row["LEDINDI"] == "IIN")) {
            $M_BAL = $M_BAL + $row["QTY"];
        }



        if ($_GET["department"] == "All") {
            if (($row["LEDINDI"] == "TRN") and ( intval($_GET["department"]) == 1)) {
                $M_BAL = $row["QTY"];
            }
        } else {
            if ($row["LEDINDI"] == "TRN") {
                $M_BAL = $row["QTY"];
            }
        }
    }
    $return_val = "<bin_table><![CDATA[ <table>";
    $return_val = "<bin_table><![CDATA[ <table>
						<tr>
                        	<td width=\"150\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
                            <td width=\"79\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
                            <td width=\"130\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Document Type</font></td>
                            <td width=\"70\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Stk In</font></td>
                            <td width=\"70\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Stk Out</font></td>
                            <td width=\"70\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Stk Bal</font></td>
                        </tr>";
    $return_val .= "<tr  bgcolor=\"#ffffff\">
	  						<td><font color=\"" . $fcolor . "\">OP Bal</font></td>
							<td><font color=\"" . $fcolor . "\">" . $_GET["dte_from"] . "</font></td>
							<td><font color=\"" . $fcolor . "\"></font></td>
							<td><font color=\"" . $fcolor . "\"></font></td>
							<td><font color=\"" . $fcolor . "\"></font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($M_BAL, 0, ".", ",") . "</font></td>
						</tr>	";



    if ($_GET["department"] == "All") {

        $sql = mysqli_query($GLOBALS['dbinv'], "select *from s_trn where  (SDATE >=  '" . $_GET["dte_from"] . "') and STK_NO='" . $_GET["itno"] . "'and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY sdate,id") or die(mysqli_error());
    } else {

        $sql = mysqli_query($GLOBALS['dbinv'], "select * from s_trn where (SDATE >= '" . $_GET["dte_from"] . "') and STK_NO='" . $_GET["itno"] . "' and (DEPARTMENT = '" . $_GET["department"] . "' or (department='01' and ledindi='TRN')) ORDER BY SDATE,id") or die(mysqli_error());
    }






    $i = 0;
    while ($row = mysqli_fetch_array($sql)) {


        $refno = $row["REFNO"];
        $sdate = $row["SDATE"];
        $doc_type = "";
        $fcolor = "";


        if ($row["LEDINDI"] == "INV") {
            $doc_type = "Sales Invoice";
            $fcolor = "#330066";
        }

        if ($row["LEDINDI"] == "ARN") {

            $sql1 = mysqli_query($GLOBALS['dbinv'], "select lcno from s_purmas where refno='" . $row["REFNO"] . "'") or die(mysqli_error());

            if ($row1 = mysqli_fetch_array($sql1)) {
                $doc_type = "LC No:" . $row1["lcno"];
            } else {
                $doc_type = "LC No:";
            }

            $fcolor = "#ff0000";
        }

        if (($row["LEDINDI"] == "GINI") or ( $row["LEDINDI"] == "GINR")) {
            $doc_type = "Internal Stock Transfers";
            $fcolor = "#003399";
        }

        if ($row["LEDINDI"] == "DGRN") {
            $doc_type = "Defective Return";
            $fcolor = "#66FF00";
        }

        if ($row["LEDINDI"] == "ARR") {
            $doc_type = "Purchase Return";
            $fcolor = "#CC3300";
        }

        if ($row["LEDINDI"] == "GRN") {
            $doc_type = "Sales Return";
            $fcolor = "#9900FF";
        }

        if ($row["LEDINDI"] == "IIN") {
            $doc_type = "Stock Adjestment IN";
            $fcolor = "#669966";
        }

        if ($row["LEDINDI"] == "IOU") {
            $doc_type = "Stock Adjestment OUT";
            $fcolor = "#CC6666";
        }

        if ($row["LEDINDI"] == "ORC") {
            $doc_type = "Order Confirmation";
            $fcolor = "#0099FF";
        }

        if ($row["LEDINDI"] == "TRN") {
            $doc_type = "Inventory";
            $fcolor = "#996600";
            $M_BAL = $row["QTY"];
            if ($_GET["department"] != "All" and $_GET["department"] != "01") {
                $M_BAL = 0;
            }
        }



        //==stock out
        $qty4 = "";
        if (($row["LEDINDI"] == "INV") or ( $row["LEDINDI"] == "ORC") or ( $row["LEDINDI"] == "GINI") or ( $row["LEDINDI"] == "ARR") or ( $row["LEDINDI"] == "IOU")) {
            $qty4 = $row["QTY"];
            $M_BAL = $M_BAL - $row["QTY"];
            ;
        }

        //===stock in
        $qty3 = "";
        if (($row["LEDINDI"] == "ARN") or ( $row["LEDINDI"] == "GINR") or ( $row["LEDINDI"] == "CRN") or ( $row["LEDINDI"] == "GRN") or ( $row["LEDINDI"] == "IIN")) {
            $qty3 = $row["QTY"];
            $M_BAL = $M_BAL + $row["QTY"];
        }
        $qty5 = $M_BAL;



        if ($row["LEDINDI"] == "INV") {
            $return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><a href=\"\" onClick=\"NewWindow('sales_inv_display.php?refno=" . $refno . "&trn_type=" . $row["LEDINDI"] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"><font color=\"" . $fcolor . "\">" . $refno . "</font></a></td>
							<td><font color=\"" . $fcolor . "\">" . $sdate . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $doc_type . "</font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($qty3, 0, ".", ",") . "</font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($qty4, 0, ".", ",") . "</font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($M_BAL, 0, ".", ",") . "</font></td>
						</tr>	";
        } else if (($row["LEDINDI"] == "DGRN") or ( $row["LEDINDI"] == "GRN")) {
            $return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><a href=\"\" onClick=\"NewWindow('grn_display.php?grn=" . $refno . "&trn_type=" . $row["LEDINDI"] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"><font color=\"" . $fcolor . "\">" . $refno . "</font></a></td>
							<td><font color=\"" . $fcolor . "\">" . $sdate . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $doc_type . "</font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($qty3, 0, ".", ",") . "</font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($qty4, 0, ".", ",") . "</font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($M_BAL, 0, ".", ",") . "</font></td>
						</tr>	";
        } else if (($row["LEDINDI"] == "GINR") or ( $row["LEDINDI"] == "GINI")) {
            $return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><font color=\"" . $fcolor . "\"><a href=\"\" onClick=\"NewWindow('gin_display.php?refno=" . $refno . "&trn_type=" . $row["LEDINDI"] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $refno . "</a></font></td>
							<td><font color=\"" . $fcolor . "\">" . $sdate . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $doc_type . "</font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($qty3, 0, ".", ",") . "</font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($qty4, 0, ".", ",") . "</font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($M_BAL, 0, ".", ",") . "</font></td>
						</tr>	";
        } else {
            $return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><font color=\"" . $fcolor . "\">" . $refno . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $sdate . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $doc_type . "</font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($qty3, 0, ".", ",") . "</font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($qty4, 0, ".", ",") . "</font></td>
							<td><font color=\"" . $fcolor . "\" align=right>" . number_format($M_BAL, 0, ".", ",") . "</font></td>
						</tr>	";
        }
        $i = $i + 1;
    }



    $i = 1;
    while ($i < 15) {
        $return_val .= "<tr >
	  						<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>	";
        $i = $i + 1;
    }
    $return_val .= "</table>]]></bin_table>";
    $return_val .= "<ord_table><![CDATA[ <table>";

//''=============================ORd=============

    $return_val .= "<ord_table><![CDATA[ <table>
						<tr>
                        	<td width=\"52\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
                            <td width=\"79\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ord Date</font></td>
                            <td width=\"130\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Schedule Date</font></td>
                            <td width=\"75\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                            <td width=\"119\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">LC No</font></td>
                            <td width=\"121\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Supplier</font></td>
                        </tr>";


    if ($_GET["department"] == "All") {

        $sql = mysqli_query($GLOBALS['dbinv'], "select * from vieword where  ( SDATE >=  '" . $_GET["dte_from"] . "')  and ORD_QTY > REC_QTY and  STK_NO='" . $_GET["itno"] . "' and cancel=0 ") or die(mysqli_error());
        //echo "select * from vieword where  ( SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and cancel=0 ";
        //$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_ordmas where  SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and cancel=0 ") or die(mysqli_error());
    } else {

        $sql = mysqli_query($GLOBALS['dbinv'], "select * from vieword where  ( SDATE >=  '" . $_GET["dte_from"] . "')  and ORD_QTY > REC_QTY and STK_NO='" . $_GET["itno"] . "' and DEP_CODE='" . $_GET["department"] . "' AND cancel=0 order by SDATE") or die(mysqli_error());
        //echo "select * from vieword where  ( SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEP_CODE='".$_GET["department"]."' AND cancel=0 order by SDATE";
    }
    while ($row = mysqli_fetch_array($sql)) {
        $return_val .= "<tr >
	  						<td>" . $row["REFNO"] . "</td>
							<td>" . $row["SDATE"] . "</td>
							<td>" . $row["S_date"] . "</td>
							<td>" . number_format(($row["ORD_QTY"] - $row["REC_QTY"]), 0, ".", ",") . "</td>
							<td>" . $row["LC_No"] . "</td>
							<td>" . $row["SUP_NAME"] . "</td>
						</tr>	";
    }
    $i = 1;
    while ($i < 15) {
        $return_val .= "<tr >
	  						<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>	";
        $i = $i + 1;
    }

    $return_val .= "</table>]]></ord_table>";
    $GLOBALS[$display_val] = $return_val;
    //return $return_val;
}

/* if ($_GET["Command"]=="pass_bincard"){
  header('Content-Type: text/xml');
  echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

  $ResponseXML = "";
  $ResponseXML .= "<salesdetails>";


  //echo "Select * from s_mas where STK_NO='".$_GET['itno']."' and BRAND_NAME='".$_GET["brand"]."'";
  $sql = mysqli_query($GLOBALS['dbinv'],"Select * from s_trn where SDATE= STK_NO='".$_GET['itno']."' ") or die(mysqli_error());
  if($row = mysqli_fetch_array($sql)){


  $ResponseXML .= "<STK_NO><![CDATA[".$row['STK_NO']."]]></STK_NO>";


  } */



if ($_GET["Command"] == "pass_itno1") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    //echo "Select * from s_mas where STK_NO='".$_GET['itno']."' and BRAND_NAME='".$_GET["brand"]."'";
    //$_SESSION['itno']=$_GET['itno'];
    //echo "Select * from s_mas where STK_NO='".$_SESSION['itno']."'";
    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $_GET['itno'] . "' ") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {


        $ResponseXML .= "<STK_NO><![CDATA[" . $row['STK_NO'] . "]]></STK_NO>";
        $ResponseXML .= "<DESCRIPT><![CDATA[" . $row['DESCRIPT'] . "]]></DESCRIPT>";
        $ResponseXML .= "<SELLING><![CDATA[" . $row['SELLING'] . "]]></SELLING>";
        $ResponseXML .= "<PART_NO><![CDATA[" . $row['PART_NO'] . "]]></PART_NO>";

        $dt = date('Y-m-d', strtotime(date('Y-m-d') . ' - 90 days'));
        $sql1 = mysqli_query($GLOBALS['dbinv'], "Select sum(REC_QTY) as stk from s_purtrn where STK_NO='" . $row['STK_NO'] . "' and CANCEL='0' and SDATE>'" . $dt . "' ") or die(mysqli_error());
        $row1 = mysqli_fetch_array($sql1);

        $mnewstk = 0;
        if (is_null($row1["stk"]) == false) {
            $mnewstk = $row1["stk"];
        }

        if ($row["QTYINHAND"] > $row1["stk"]) {
            $unsold = $row["QTYINHAND"] - $row1["stk"];
        }

        $ResponseXML .= "<unsold><![CDATA[" . $unsold . "]]></unsold>";

        $ResponseXML .= "<SALE01><![CDATA[" . number_format($row['SALE01'], 0, ".", ",") . "]]></SALE01>";
        $ResponseXML .= "<SALE02><![CDATA[" . number_format($row['SALE02'], 0, ".", ",") . "]]></SALE02>";
        $ResponseXML .= "<SALE03><![CDATA[" . number_format($row['SALE03'], 0, ".", ",") . "]]></SALE03>";
        $ResponseXML .= "<SALE04><![CDATA[" . number_format($row['SALE04'], 0, ".", ",") . "]]></SALE04>";
        $ResponseXML .= "<SALE05><![CDATA[" . number_format($row['SALE05'], 0, ".", ",") . "]]></SALE05>";
        $ResponseXML .= "<SALE06><![CDATA[" . number_format($row['SALE06'], 0, ".", ",") . "]]></SALE06>";
        $ResponseXML .= "<SALE07><![CDATA[" . number_format($row['SALE07'], 0, ".", ",") . "]]></SALE07>";
        $ResponseXML .= "<SALE08><![CDATA[" . number_format($row['SALE08'], 0, ".", ",") . "]]></SALE08>";
        $ResponseXML .= "<SALE09><![CDATA[" . number_format($row['SALE09'], 0, ".", ",") . "]]></SALE09>";
        $ResponseXML .= "<SALE10><![CDATA[" . number_format($row['SALE10'], 0, ".", ",") . "]]></SALE10>";
        $ResponseXML .= "<SALE11><![CDATA[" . number_format($row['SALE11'], 0, ".", ",") . "]]></SALE11>";
        $ResponseXML .= "<SALE12><![CDATA[" . number_format($row['SALE12'], 0, ".", ",") . "]]></SALE12>";

        $avg = ($row['SALE01'] + $row['SALE02'] + $row['SALE03'] + $row['SALE04'] + $row['SALE05'] + $row['SALE06'] + $row['SALE07'] + $row['SALE08'] + $row['SALE09'] + $row['SALE10'] + $row['SALE11'] + $row['SALE12']) / 12;
        $avg = number_format($avg, 0, "", ",");

        $ResponseXML .= "<avg><![CDATA[" . $avg . "]]></avg>";

        $ResponseXML .= " <sales_table><![CDATA[ <table>
                                      <tr>
                                         <td width=\"122\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Department</font></td>
                                         <td width=\"101\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Stock</font></td>
										 <td width=\"101\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">AD</font></td>
                                      </tr>";

        $sql2 = mysqli_query($GLOBALS['dbinv'], "Select * from s_stomas") or die(mysqli_error());
        while ($row2 = mysqli_fetch_array($sql2)) {
            //echo "Select QTYINHAND from s_submas where STO_CODE='".$row2["CODE"]."' and STK_NO='".$row["STK_NO"]."'";
            $sql3 = mysqli_query($GLOBALS['dbinv'], "Select QTYINHAND from s_submas where STO_CODE='" . $row2["CODE"] . "' and STK_NO='" . $row["STK_NO"] . "'") or die(mysqli_error());
            if ($row3 = mysqli_fetch_array($sql3)) {
                $ResponseXML .= "  <tr>
                                               	<td width=\"122\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">" . $row2["DESCRIPTION"] . "</font></td>
                                               	<td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">" . number_format($row3["QTYINHAND"], 0, ".", ",") . "</font></td>";
                if ($row4 = mysqli_fetch_array($sql4)) {

                    $ResponseXML .= "<td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">" . number_format($row4["QTYINHAND"], 0, ".", ",") . "</font></td>";
                } else {
                    $ResponseXML .= "<td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">0</font></td>";
                }

                $ResponseXML .= "</tr>";
            } else {
                $ResponseXML .= "  <tr>
                                               	<td width=\"122\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">" . $row2["DESCRIPTION"] . "</font></td>
                                               	<td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">0</font></td>
												<td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">0</font></td>
                                               </tr>";
            }
        }

        $ResponseXML .= "   </table>]]></sales_table>";
    }
    display1();

    //$ResponseXML .= display();

    $ResponseXML .= $GLOBALS[$display_val];

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

function display1() {


    if ($_GET["department"] == "All") {

        $sql = mysqli_query($GLOBALS['dbinv'], "select * from s_trn where  ( SDATE <  '" . $_GET["dte_from"] . "') and STK_NO='" . $_GET["itno"] . "' and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE") or die(mysqli_error());
        //echo "select * from s_trn where  ( SDATE <  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE";
    } else {

        $sql = mysqli_query($GLOBALS['dbinv'], "select * from s_trn where  ( SDATE <  '" . $_GET["dte_from"] . "') and STK_NO='" . $_GET["itno"] . "' and DEPARTMENT='" . $_GET["department"] . "' ORDER by SDATE") or die(mysqli_error());
        //echo "select * from s_trn where  ( SDATE <  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEPARTMENT='".$_GET["department"]."' ORDER by SDATE";
    }


    $M_BAL = 0;
    while ($row = mysqli_fetch_array($sql)) {

        //===stock out
        if (($row["LEDINDI"] == "INV") or ( $row["LEDINDI"] == "ORC") or ( $row["LEDINDI"] == "GINI") or ( $row["LEDINDI"] == "ARR") or ( $row["LEDINDI"] == "IOU")) {
            $M_BAL = $M_BAL - $row["QTY"];
        }

        //====stock in
        if (($row["LEDINDI"] == "ARN") or ( $row["LEDINDI"] == "GINR") or ( $row["LEDINDI"] == "CRN") or ( $row["LEDINDI"] == "GRN") or ( $row["LEDINDI"] == "IIN")) {
            $M_BAL = $M_BAL + $row["QTY"];
        }

        if ($_GET["department"] == "All") {
            if (($row["LEDINDI"] == "TRN") and ( intval($_GET["department"]) == 1)) {
                $M_BAL = $row["QTY"];
            }
        } else {
            if ($row["LEDINDI"] == "TRN") {
                $M_BAL = $row["QTY"];
            }
        }
    }

    $return_val = "<bin_table><![CDATA[ <table>
						<tr>
                        	<td width=\"150\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
                            <td width=\"79\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
                            <td width=\"130\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Document Type</font></td>
                            <td width=\"70\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Stk In</font></td>
                            <td width=\"70\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Stk Out</font></td>
                            <td width=\"70\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Stk Bal</font></td>
                        </tr>";

    $return_val .= "<tr  bgcolor=\"#ffffff\">
	  						<td><font color=\"" . $fcolor . "\">OP Bal</font></td>
							<td><font color=\"" . $fcolor . "\">" . $_GET["dte_from"] . "</font></td>
							<td><font color=\"" . $fcolor . "\"></font></td>
							<td><font color=\"" . $fcolor . "\"></font></td>
							<td><font color=\"" . $fcolor . "\"></font></td>
							<td><font color=\"" . $fcolor . "\">" . number_format($M_BAL, 0, ".", ",") . "</font></td>
						</tr>	";
    /*  $return_val .= "<tr bgcolor=\"#000000\">
      <td>Op Bal</td>
      <td>Date</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>".$M_BAL."</td>"; */

//'..............................................................................................................
    /* if rsusercon!dev = 0 Then
      If com_dep.Text = "All" Then
      sql = "select *from s_trn where  dev <= '" & rsusercon!dev & "' and  ( sDATE >=  '" & dtpFdate & "' )and STK_NO='" & Trim(txtFItCode.Text) & "'and LEDINDI<>'GINR' and LEDINDI<>'GINI' and LEDINDI<>'VGI'and LEDINDI<>'VGR' )  ORDER BY sdate"
      Else
      sql = "select *from s_trn where  dev <= '" & rsusercon!dev & "' and ( sDATE >=  '" & dtpFdate & "' )and STK_NO='" & Trim(txtFItCode.Text) & "' and DEPARTMENT='" & Trim(Left(com_dep, 5)) & "'ORDER by sdate"
      End If
      Else */
    if ($_GET["department"] == "All") {

        $sql = mysqli_query($GLOBALS['dbinv'], "select *from s_trn where  (SDATE >=  '" . $_GET["dte_from"] . "') and STK_NO='" . $_GET["itno"] . "'and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE") or die(mysqli_error());
        //	echo "select *from s_trn where  (SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."'and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE";
    } else {

        $sql = mysqli_query($GLOBALS['dbinv'], "select * from s_trn where (SDATE >= '" . $_GET["dte_from"] . "') and STK_NO='" . $_GET["itno"] . "' and DEPARTMENT = '" . $_GET["department"] . "' ORDER BY SDATE") or die(mysqli_error());
        //echo "select * from s_trn where (SDATE >= '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEPARTMENT = '".$_GET["department"]."' ORDER BY SDATE";
    }
    //End If





    $i = 0;
    while ($row = mysqli_fetch_array($sql)) {
        /*  if ($_GET["department"] == "All"){
          while($row1 = mysqli_fetch_array($sql)){
          if (($row1["LEDINDI"] == "TRN") and (intval($row1["DEPARTMENT"]) > 1)){
          rdPrBin.MoveNext
          } else {
          break;
          }
          }
          } */
        //  If rdPrBin.EOF Then Exit Do


        $refno = $row["REFNO"];
        $sdate = $row["SDATE"];
        $doc_type = "";
        $fcolor = "";


        if ($row["LEDINDI"] == "INV") {
            $doc_type = "Sales Invoice";
            $fcolor = "#330066";
        }
        //echo "select lcno from s_purmas where refno='".$row["REFNO"]."'";
        if ($row["LEDINDI"] == "ARN") {

            $sql1 = mysqli_query($GLOBALS['dbinv'], "select lcno from s_purmas where refno='" . $row["REFNO"] . "'") or die(mysqli_error());

            if ($row1 = mysqli_fetch_array($sql1)) {
                $doc_type = "LC No:" . $row1["lcno"];
            } else {
                $doc_type = "LC No:";
            }

            $fcolor = "#FF0000";
        }

        if (($row["LEDINDI"] == "GINI") or ( $row["LEDINDI"] == "GINR")) {
            $doc_type = "Internal Stock Transfers";
            $fcolor = "#003399";
        }

        if ($row["LEDINDI"] == "DGRN") {
            $doc_type = "Defective Return";
            $fcolor = "#66FF00";
        }

        if ($row["LEDINDI"] == "ARR") {
            $doc_type = "Purchase Return";
            $fcolor = "#33CCFF";
        }

        if ($row["LEDINDI"] == "GRN") {
            $doc_type = "Sales Return";
            $fcolor = "#9900FF";
        }

        if ($row["LEDINDI"] == "IIN") {
            $doc_type = "Stock Adjestment IN";
            $fcolor = "#669966";
        }

        if ($row["LEDINDI"] == "IOU") {
            $doc_type = "Stock Adjestment OUT";
            $fcolor = "#CC6666";
        }

        if ($row["LEDINDI"] == "ORC") {
            $doc_type = "Order Confirmation";
            $fcolor = "#0099FF";
        }

        if ($row["LEDINDI"] == "TRN") {
            $doc_type = "Inventory";
            $fcolor = "#996600";
            $M_BAL = $row["QTY"];
        }


        //==stock out
        $qty4 = "";
        if (($row["LEDINDI"] == "INV") or ( $row["LEDINDI"] == "ORC") or ( $row["LEDINDI"] == "GINI") or ( $row["LEDINDI"] == "ARR") or ( $row["LEDINDI"] == "IOU")) {
            $qty4 = $row["QTY"];
            $M_BAL = $M_BAL - $row["QTY"];
            ;
        }

        //===stock in
        $qty3 = "";
        if (($row["LEDINDI"] == "ARN") or ( $row["LEDINDI"] == "GINR") or ( $row["LEDINDI"] == "CRN") or ( $row["LEDINDI"] == "GRN") or ( $row["LEDINDI"] == "IIN")) {
            $qty3 = $row["QTY"];
            $M_BAL = $M_BAL + $row["QTY"];
        }
        $qty5 = $M_BAL;

        /* 	$return_val .= "<tr  bgcolor=\"#ffffff\">
          <td><font color=\"".$fcolor."\">".$refno."</font></td>
          <td><font color=\"".$fcolor."\">".$sdate."</font></td>
          <td><font color=\"".$fcolor."\">".$doc_type."</font></td>
          <td><font color=\"".$fcolor."\">".number_format($qty3, 0, ".", ",")."</font></td>
          <td><font color=\"".$fcolor."\">".number_format($qty4, 0, ".", ",")."</font></td>
          <td><font color=\"".$fcolor."\">".number_format($M_BAL, 0, ".", ",")."</font></td>
          </tr>	"; */

        if ($row["LEDINDI"] == "INV") {
            $return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><a href=\"\" onClick=\"NewWindow('sales_inv_display.php?refno=" . $refno . "&trn_type=" . $row["LEDINDI"] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"><font color=\"" . $fcolor . "\">" . $refno . "</font></a></td>
							<td><font color=\"" . $fcolor . "\">" . $sdate . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $doc_type . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $qty3 . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $qty4 . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $M_BAL . "</font></td>
						</tr>	";
        } else if (($row["LEDINDI"] == "DGRN") or ( $row["LEDINDI"] == "GRN")) {
            $return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><a href=\"\" onClick=\"NewWindow('grn_display.php?grn=" . $refno . "&trn_type=" . $row["LEDINDI"] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"><font color=\"" . $fcolor . "\">" . $refno . "</font></a></td>
							<td><font color=\"" . $fcolor . "\">" . $sdate . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $doc_type . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $qty3 . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $qty4 . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $M_BAL . "</font></td>
						</tr>	";
        } else if (($row["LEDINDI"] == "GINR") or ( $row["LEDINDI"] == "GINI")) {
            $return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><font color=\"" . $fcolor . "\"><a href=\"\" onClick=\"NewWindow('gin_display.php?refno=" . $refno . "&trn_type=" . $row["LEDINDI"] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $refno . "</a></font></td>
							<td><font color=\"" . $fcolor . "\">" . $sdate . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $doc_type . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $qty3 . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $qty4 . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $M_BAL . "</font></td>
						</tr>	";
        } else {
            $return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><font color=\"" . $fcolor . "\">" . $refno . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $sdate . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $doc_type . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $qty3 . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $qty4 . "</font></td>
							<td><font color=\"" . $fcolor . "\">" . $M_BAL . "</font></td>
						</tr>	";
        }

        $i = $i + 1;
    }

    $return_val .= "   </table>]]></bin_table>";


//''=============================ORd=============

    $return_val .= "<ord_table><![CDATA[ <table>
						<tr>
                        	<td width=\"52\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
                            <td width=\"79\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ord Date</font></td>
                            <td width=\"130\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Schedule Date</font></td>
                            <td width=\"75\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                            <td width=\"119\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">LC No</font></td>
                            <td width=\"121\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Supplier</font></td>
                        </tr>";


    if ($_GET["department"] == "All") {

        $sql = mysqli_query($GLOBALS['dbinv'], "select * from vieword where  ( SDATE >=  '" . $_GET["dte_from"] . "')  and ORD_QTY > REC_QTY and  STK_NO='" . $_GET["itno"] . "' and cancel=0 ") or die(mysqli_error());
        //echo "select * from vieword where  ( SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and cancel=0 ";
        //$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_ordmas where  SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and cancel=0 ") or die(mysqli_error());
    } else {

        $sql = mysqli_query($GLOBALS['dbinv'], "select * from vieword where  ( SDATE >=  '" . $_GET["dte_from"] . "')  and ORD_QTY > REC_QTY and STK_NO='" . $_GET["itno"] . "' and DEP_CODE='" . $_GET["department"] . "' AND cancel=0 order by SDATE") or die(mysqli_error());
        //echo "select * from vieword where  ( SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEP_CODE='".$_GET["department"]."' AND cancel=0 order by SDATE";
    }
    while ($row = mysqli_fetch_array($sql)) {
        $return_val .= "<tr >
	  						<td>" . $row["REFNO"] . "</td>
							<td>" . $row["SDATE"] . "</td>
							<td>" . $row["S_date"] . "</td>
							<td>" . number_format(($row["ORD_QTY"] - $row["REC_QTY"]), 0, ".", ",") . "</td>
							<td>" . $row["LC_No"] . "</td>
							<td>" . $row["SUP_NAME"] . "</td>
						</tr>	";
    }

    $return_val .= "   </table>]]></ord_table>";
    $GLOBALS[$display_val] = $return_val;
    //return $return_val;
}

if ($_GET["Command"] == "pass_assignbrand") {
    $_SESSION["brand"] = $_GET["brand"];
    $_SESSION["department"] = $_GET["department"];
}


if ($_GET["Command"] == "search_item_simple") {



    $ResponseXML = "";




    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><strong><font color=\"#FFFFFF\">Item No</font></strong></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Item Description</font></strong></td>
                               <td width=\"150\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Brand Name</font></strong></td>
                              <td width=\"150\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Stock In Hand</font></strong></td>
                             <td width=\"150\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Price</font></strong></td>
   							</tr>";

    if ($_GET["checkbox"] == "true") {
        if ($_GET["mstatus"] == "itno") {
            $letters = $_GET['itno'];

            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_mas where STK_NO like  '$letters%' and QTYINHAND>0 order by STK_NO limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "itemname") {
            $letters = $_GET['itemname'];

            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_mas where DESCRIPT like  '$letters%' and QTYINHAND>0 order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {

            $letters = $_GET['itemname'];

            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_mas where DESCRIPT like  '$letters%' and QTYINHAND>0 order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    } else {
        if ($_GET["mstatus"] == "itno") {
            $letters = $_GET['itno'];

            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_mas where STK_NO like  '$letters%' order by STK_NO limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "itemname") {
            $letters = $_GET['itemname'];

            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {

            $letters = $_GET['itemname'];

            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    }

    while ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<tr>
                              <td onclick=\"itnoSimple('" . $row['STK_NO'] . "');\">" . $row['STK_NO'] . "</a></td>
                              <td onclick=\"itnoSimple('" . $row['STK_NO'] . "');\">" . $row['DESCRIPT'] . "</a></td>
							   <td onclick=\"itnoSimple('" . $row['STK_NO'] . "');\">" . $row['BRAND_NAME'] . "</a></td>
							   <td onclick=\"itnoSimple('" . $row['STK_NO'] . "');\">" . number_format($row['QTYINHAND'], 0, ".", ",") . "</a></td>
							    <td onclick=\"itnoSimple('" . $row['STK_NO'] . "');\">" . number_format($row['SELLING'], 2, ".", ",") . "</a></td>";



        $ResponseXML .= "</tr>";
    }

    $ResponseXML .= "   </table>";


    echo $ResponseXML;
    //}
}



if ($_GET["Command"] == "pass_itno_simple") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $_GET['itno'] . "' ") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<STK_NO><![CDATA[" . $row['STK_NO'] . "]]></STK_NO>";
    }
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


mysqli_close($GLOBALS['dbinv']);
mysqli_close($GLOBALS['dbacc']);
?>
