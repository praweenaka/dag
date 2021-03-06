<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connectioni.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');
date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "setitem") {
    $sql_invpara = "SELECT * from invpara";
    $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
    $row_invpara = mysqli_fetch_array($result_invpara);

    $vatrate = $row_invpara["vatrate"] / 100;

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $sqlt = "SELECT * from s_mas where  STK_NO='" . $_GET["itemd_hidden"] . "'";
    $resultt = mysqli_query($GLOBALS['dbinv'], $sqlt);
    if ($row = mysqli_fetch_array($resultt)) {
        $ResponseXML .= "<STK_NO><![CDATA[" . $row['STK_NO'] . "]]></STK_NO>";
        $ResponseXML .= "<DESCRIPT><![CDATA[" . $row['DESCRIPT'] . "]]></DESCRIPT>";

        if ($_GET["vatmethod"] == "non") {
            $SELLING = $row['SELLING'];
        } else {
            $SELLING = $row['SELLING'] / ($vatrate + 1);
        }

        $ResponseXML .= "<SELLING><![CDATA[" . number_format($SELLING, 2, ".", ",") . "]]></SELLING>";

        $sql_qty = "select QTYINHAND from s_submas where STK_NO='" . $_GET['itemd_hidden'] . "' AND STO_CODE='" . $_GET["department"] . "'";
        $result_qty = mysqli_query($GLOBALS['dbinv'], $sql_qty);
        if ($row_qty = mysqli_fetch_array($result_qty)) {
            if (is_null($row_qty["QTYINHAND"]) == false) {
                $ResponseXML .= "<qtyinhand><![CDATA[" . $row_qty["QTYINHAND"] . "]]></qtyinhand>";
            } else {
                $ResponseXML .= "<qtyinhand><![CDATA[]]></qtyinhand>";
            }
        } else {
            $ResponseXML .= "<qtyinhand><![CDATA[]]></qtyinhand>";
        }
    }

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "chk_number") {
    $sql = "select * from vendor where CODE = '" . trim($_GET["txt_cuscode"]) . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        echo "included";
    } else {
        echo "no";
    }
}

if ($_GET["Command"] == "new_inv") {

    $_SESSION["print"] = 0;
    $_SESSION["save_sales_ord"] = 1;
    $_SESSION["brand"]="";
    $_SESSION["tbrsession"]="";
    $sql = "Select ORDNO from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["ORDNO"];
    $lenth = strlen($tmpinvno);
    $invno = trim("ORD/1/ ") . substr($tmpinvno, $lenth - 7);
    $_SESSION["invno"] = $invno;

    $sql = "Select ORD_NO from tmpinvpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $_SESSION["tmp_no_ord"] = "SALORD/" . $row["ORD_NO"];

    $sql1 = "delete from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

    $sql1 = "update tmpinvpara set ORD_NO=ORD_NO+1";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $_SESSION["tbrsession"] = " ";
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<txtdono><![CDATA[]]></txtdono>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "cancel_inv") {
    $sql = "select last_update from invpara  ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);

    $sqlinv = "select * from s_cusordmas where REF_NO='" . $_GET['salesord1'] . "'";
    $resultinv = mysqli_query($GLOBALS['dbinv'], $sqlinv);
    if ($rowinv = mysqli_fetch_array($resultinv)) {
        if (($rowinv["TOTPAY"] == 0) and ( $rowinv["SDATE"] > $row["last_update"])) {
            $sql2 = "update s_cusordmas set CANCELL='1' where REF_NO='" . $_GET['salesord1'] . "'";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);

            $sqltmp = "select * from tmp_ord_data where str_invno='" . $_GET['salesord1'] . "' ";
            $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);
            while ($rowtmp = mysqli_fetch_array($resulttmp)) {
                $sqlorddata = "update s_cusordtrn set CANCELL='1' where REF_NO='" . $_GET['salesord1'] . "'";
                $resultorddata = mysqli_query($GLOBALS['dbinv'], $sqlorddata);
            }
            echo "Canceled";
        } else {
            echo "Can't Cancel";
        }
    }
}

if ($_GET["Command"] == "chk_ad") {
    if ($_GET["chk"] == "false") {
        $chk = 0;
    } else {
        $chk = 1;
    }
    $sql = "update tmp_ord_data set ad='" . $chk . "' where id=" . $_GET["id"] . " and str_code='" . $_GET['itemcode'] . "' and tmp_no= '" . $_SESSION["tmp_no_ord"] . "'";
    echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
}

if ($_GET["Command"] == "add_tmp") {

    $department = $_GET["department"];

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $rate = str_replace(",", "", $_GET["rate"]);
    $actual_selling = str_replace(",", "", $_GET["actual_selling"]);

    $qty = str_replace(",", "", $_GET["qty"]);
    $discount = str_replace(",", "", $_GET["discount"]);
    $subtotal = str_replace(",", "", $_GET["subtotal"]);


    $ad = "0";
    $swich="ON";
    $sqltmpord = "select * from  tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "' ";   
    $resulttmpord = mysqli_query($GLOBALS['dbinv'], $sqltmpord);
    while ($row_tmpord = mysqli_fetch_array($resulttmpord)) {  
      if($_GET['brand']!=$row_tmpord['brand']){ 
         
         $swich="OFF";
      } else{
        if($_GET['tbrcheck']!=$row_tmpord['tbr']){
          $swich="OFF";
        }
      }
    }
   
     if($swich=="ON"){
        $ResponseXML .= "<dupbrand><![CDATA[]]></dupbrand>";
        $sql = "Insert into tmp_ord_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, actual_selling, brand, tmp_no,tbr)values 
          ('" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', " . $rate . ", " . $qty . ", " . $_GET["discountper"] . ", " . $discount . ", " . $subtotal . ", " . $actual_selling . ", '" . $_GET['brand'] . "', '" . $_SESSION["tmp_no_ord"] . "', '" . $_GET['tbrcheck'] . "') ";

       $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if (!$result) {
            echo mysqli_error($GLOBALS['dbinv']);
        }   

      }else{
         $ResponseXML .= "<dupbrand><![CDATA[" . 'Different Brand Enterd..' . "]]></dupbrand>"; 
      }

      
     
    //$ResponseXML .= $sql;
    
    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"50\"  background=\"\" ><font color=\"#FFFFFF\">ID</font></td>
							  <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate With VAT</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							  <td></td>
							  <td width=\"70\">Qty In Hand</td>
							   <td width=\"70\">Avg</td>
                            </tr>";

    $i = 1;
    $sql = "Select * from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $id = "id" . $i;
        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $rate = "rate" . $i;
        $actual_selling = "actual_selling" . $i;
        $qty = "qty" . $i;
        $discountper = "discountper" . $i;
        $subtotal = "subtotal" . $i;
        $discount = "discount" . $i;
        $ad = "ad" . $i;

        $sql_mas = "Select * from s_mas where STK_NO='" . $row['str_code'] . "'";
        $result_mas = mysqli_query($GLOBALS['dbinv'], $sql_mas);
        $row_mas = mysqli_fetch_array($result_mas);
        
        $dt = date('Y-m-d', strtotime(date('Y-m-d') . ' - 90 days'));

        $sql1 = "Select sum(REC_QTY) as stk from s_purtrn where STK_NO='" . $row['str_code'] . "' and CANCEL='0' and SDATE>'" . $dt . "' "; 
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        $row1 = mysqli_fetch_array($result1); 

        $mnewstk = 0;
        $unsold = 0;
        if (is_null($row1["stk"]) == false) {
            $mnewstk = $row1["stk"];
        }

        if ($row_mas["QTYINHAND"] > $row1["stk"]) {
            $unsold = $row_mas["QTYINHAND"] - $mnewstk;
        }
//        echo $rowmas["QTYINHAND"].'/'.$row1["stk"];
        $bgcolour = "";

        if ($unsold > 0) {
            $bgcolour = "yellow";
        }
//        echo $unsold;
        $ResponseXML .= "<tr>                              
                            <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $id . "'>" . $row['id'] . "</div></td>
                             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>";
                            if ($bgcolour == "") {
                                $ResponseXML .= "<td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row_mas["DESCRIPT"] . "</div></td>";
                            } else {
                                $ResponseXML .= "<td style=\"background-color:green\"  onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row_mas["DESCRIPT"] . "</div></td>";
                            }
        $ResponseXML .= "<td align = right onClick = \"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $rate . "\" id=\"" . $rate . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" /></td>
                              <td align=right ><input type=\"text\"  class=\"text_purchase3\" name=\"" . $actual_selling . "\" id=\"" . $actual_selling . "\" size=\"15\"  value=\"" . number_format($row['actual_selling'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"   /></td>
                             <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $qty . "\" id=\"" . $qty . "\" size=\"15\"  value=\"" . number_format($row['cur_qty'], 0, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" />    </td>
                             <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . $_GET["discountper"] . "</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>

                             <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>

                             <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['id'] . "');\"></td>";

        // include_once("connectioni.php");
        $sqlqty = "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'";
        $resultqty = mysqli_query($GLOBALS['dbinv'], $sqlqty);


        if ($rowqty = mysqli_fetch_array($resultqty)) {
            $qty = number_format($rowqty['QTYINHAND'], 0, ".", ",");
        } else {
            $qty = 0;
        }

        $ResponseXML .= "<td  >" . $qty . "</td>";

        /* $mdate1 = "";
          $mdate2 = "";

          $date1 = date('Y-m-d');
          $date2 = date('Y-m-d');
          $mqty1 = 0;
          $mqty2 = 0;
          $mdate1 = "";
          $mdate2 = "";
          $sql = "select sdate from battry_inv where rep='" . trim($_GET["rep"]) . "' and c_code='" . trim($_GET["c_code"]) . "' group by sdate order by sdate desc limit 2";
          $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
          while ($row1 = mysqli_fetch_array($result1)) {

          $sql = "select qty from battry_inv where rep='" . trim($_GET["rep"]) . "' and c_code='" . trim($_GET["c_code"]) . "' and stk_no = '" .  $row['str_code'] . "' and sdate = '" . $row1['sdate'] . "'";
          $result2 = mysqli_query($GLOBALS['dbinv'], $sql);
          ($row2 = mysqli_fetch_array($result2));
          if ($mdate1 != "" and $mdate2 == "") {
          $mdate2 = $row1['sdate'];
          $mqty2 = $row2['qty'];
          }

          if ($mdate1 == "") {
          $mdate1 = $row1['sdate'];
          $mqty1 = $row2['qty'];
          }
          }

          if ($mdate1 == "") {
          $mdate1 = $date1;
          }
          if ($mdate2 == "") {
          $mdate2 = $date2;
          }

          $sql = "select sum(qty) as qty from view_salma_invo_smas where sal_ex='" . trim($_GET["rep"]) . "' and c_code='" . trim($_GET["c_code"]) . "' and stk_no = '" . $row['str_code'] . "' and deli_Date>'" . $mdate2 . "' and deli_Date<'" . $mdate1 . "'";
          $result2 = mysqli_query($GLOBALS['dbinv'], $sql);
          if ($row2 = mysqli_fetch_array($result2)) {
          $mqty =  (($row2['qty'] + $mqty2) - ($mqty1));
          }
          $diff = abs(strtotime($mdate2) - strtotime($mdate1));
          $days = floor($diff / (60 * 60 * 24));

          $diff = abs(strtotime(date("Y-m-d")) - strtotime($mdate1));
          $days1 = floor($diff / (60 * 60 * 24));

          $mavg = $mqty / $days; */

        $mavg = 0;  //$mavg *$days1;

        $ResponseXML .= "<td  >" . number_format($mavg, 0, ".", ",") . "</td></tr>";


        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

    $sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

    $sql_invpara = "SELECT * from invpara";
    $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
    $row_invpara = mysqli_fetch_array($result_invpara);

    $vatrate = $row_invpara["vatrate"] / 100;

    if ($_GET["vatmethod"] == "vat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $strvatrate = "Tax (VAT " . $row_invpara["vatrate"] . "%)";
        $ResponseXML .= "<taxname><![CDATA[" . $strvatrate . "]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $strvatrate = "Tax (SVAT " . $row_invpara["vatrate"] . "%)";
        $ResponseXML .= "<taxname><![CDATA[" . $strvatrate . "]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $strvatrate = "Tax (EVAT " . $row_invpara["vatrate"] . "%)";
        $ResponseXML .= "<taxname><![CDATA[" . $strvatrate . "]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "non") {
        //$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
        $ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";

        $invtot = number_format($row['tot_sub'], 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    }

    $ResponseXML .= " </salesdetails>";

    //	}

    echo $ResponseXML;
}

if ($_GET["Command"] == "add_tmp_edit_rate") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $department = $_GET["department"];

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    //$sql="delete from tmp_ord_data where id='".$_GET['id']."' and str_code='".$_GET['itemcode']."' and tmp_no='".$_SESSION["tmp_no_ord"]."' ";
    //$result =mysqli_query($GLOBALS['dbinv'],$sql) ;
    //echo $_GET['rate'];
    //echo $_GET['qty'];
    $rate = str_replace(",", "", $_GET["rate"]);
    $actual_selling = str_replace(",", "", $_GET["actual_selling"]);
    $qty = str_replace(",", "", $_GET["qty"]);
    $discount = str_replace(",", "", $_GET["discount"]);
    $subtotal = str_replace(",", "", $_GET["subtotal"]);

    //$sql="Insert into tmp_ord_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, tmp_no, actual_selling)values
    //('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.", '".$_GET['brand']."', '".$_SESSION["tmp_no_ord"]."', ".$actual_selling.") ";

    $sql = "update tmp_ord_data set cur_rate=" . $rate . ", cur_qty=" . $qty . ", dis_per=" . $_GET["discountper"] . ", cur_discount=" . $discount . ", cur_subtot=" . $subtotal . ", actual_selling=" . $actual_selling . " where id='" . $_GET['id'] . "'";
    //('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', , , , , , , '".$_SESSION["tmp_no_ord"]."', ) ";
    //echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"50\"  background=\"\" ><font color=\"#FFFFFF\">ID</font></td>
							  <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate With VAT</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							  <td></td>
							  <td width=\"50\"  background=\"\"><font color=\"#FFFFFF\">AD</font></td>
							  <td width=\"70\">Qty In Hand</td>
                            </tr>";

    $i = 1;
    $sql = "Select * from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "' order by id";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $id = "id" . $i;
        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $rate = "rate" . $i;
        $actual_selling = "actual_selling" . $i;
        $qty = "qty" . $i;
        $discountper = "discountper" . $i;
        $subtotal = "subtotal" . $i;
        $discount = "discount" . $i;
        $ad = "ad" . $i;

        $ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $id . "'>" . $row['id'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $rate . "\" id=\"" . $rate . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\" disabled onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" /></td>
							 <td align=right ><input type=\"text\"  class=\"text_purchase3\" name=\"" . $actual_selling . "\" id=\"" . $actual_selling . "\" size=\"15\"  value=\"" . number_format($row['actual_selling'], 2, ".", ",") . "\" onblur=\"calc1_table('" . $i . "');\" /></td>
							  <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $qty . "\" id=\"" . $qty . "\" size=\"15\"  value=\"" . number_format($row['cur_qty'], 0, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . number_format($_GET["discountper"], 6, ".", ",") . "</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>";
        // <td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>
        $ResponseXML .= " <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['id'] . "');\"></td>";

        //include_once("connectioni.php");
        $sqlqty = "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'";
        $resultqty = mysqli_query($GLOBALS['dbinv'], $sqlqty);

        if ($rowqty = mysqli_fetch_array($resultqty)) {
            $qty = number_format($rowqty['QTYINHAND'], 0, ".", ",");
        } else {
            $qty = 0;
        }

        /* 	if ($row['ad']=="1"){
          $ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."' checked></td>";
          } else {
          $ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>";
          } */

        $ResponseXML .= "<td  >" . $qty . "</td>
						
							
							 
                            </tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

    $sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

    $sql_invpara = "SELECT * from invpara";
    $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
    $row_invpara = mysqli_fetch_array($result_invpara);

    $vatrate = $row_invpara["vatrate"] / 100;

    if ($_GET["vatmethod"] == "vat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $strvatrate = "Tax (VAT " . $row_invpara["vatrate"] . "%)";
        $ResponseXML .= "<taxname><![CDATA[" . $strvatrate . "]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $strvatrate = "Tax (SVAT " . $row_invpara["vatrate"] . "%)";
        $ResponseXML .= "<taxname><![CDATA[" . $strvatrate . "]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $strvatrate = "Tax (EVAT " . $row_invpara["vatrate"] . "%)";
        $ResponseXML .= "<taxname><![CDATA[" . $strvatrate . "]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "non") {
        //$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
        $ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";

        $invtot = number_format($row['tot_sub'], 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    }

    $ResponseXML .= " </salesdetails>";

    //	}

    echo $ResponseXML;
}

if ($_GET["Command"] == "add_tmp_edit_discount") {

    $department = $_GET["department"];

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    //$sql="delete from tmp_ord_data where tmp_no='".$_SESSION["tmp_no_ord"]."' ";
    //$ResponseXML .= $sql;
    //$result =mysqli_query($GLOBALS['dbinv'],$sql) ;
    //echo $_GET['rate'];
    //echo $_GET['qty'];
    //echo "count :".$_GET["item_count"];
    $i = 1;
    while ($_GET["item_count"] > $i) {

        $id = "id" . $i;
        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $discountper = "discountper" . $i;
        $srate = "rate" . $i;
        $rate = str_replace(",", "", $_GET[$srate]);

        $sactual_selling = "actual_selling" . $i;
        $actual_selling = str_replace(",", "", $_GET[$sactual_selling]);

        $sqty = "qty" . $i;
        $qty = str_replace(",", "", $_GET[$sqty]);
        $sdiscount = "discount" . $i;
        $discount = str_replace(",", "", $_GET[$sdiscount]);
        $ssubtotal = "subtotal" . $i;
        $subtotal = str_replace(",", "", $_GET[$ssubtotal]);
        $ad = "ad" . $i;

        if ($_GET[$ad] == "true") {
            $ad_val = "1";
        } else {
            $ad_val = "0";
        }

        //$sql="Insert into tmp_ord_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, actual_selling, tmp_no, ad)values
        //('".$_GET['invno']."', '".$_GET[$code]."', '".$_GET[$itemd]."', ".$rate.", ".$qty.", ".$_GET[$discountper].", ".$discount.", ".$subtotal.", '".$_GET['brand']."', '".$actual_selling."', '".$_SESSION["tmp_no_ord"]."', '".$ad_val."') ";

        $sql = "update tmp_ord_data set cur_rate=" . $rate . ", cur_qty=" . $qty . ", dis_per=" . $_GET[$discountper] . ", cur_discount=" . $discount . ", cur_subtot=" . $subtotal . ", actual_selling='" . $actual_selling . "', ad='" . $ad_val . "' where id=" . $_GET[$id];
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $i = $i + 1;
    }
    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"50\"  background=\"\" ><font color=\"#FFFFFF\">ID</font></td>
							  <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate With VAT</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							  <td></td>
							  <td width=\"70\">Qty In Hand</td>
							  
                            </tr>";

    $i = 1;
    $sql = "Select * from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "' order by id";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $id = "id" . $i;
        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $rate = "rate" . $i;
        $actual_selling = "actual_selling" . $i;
        $qty = "qty" . $i;
        $discountper = "discountper" . $i;
        $subtotal = "subtotal" . $i;
        $discount = "discount" . $i;
        $ad = "ad" . $i;

        $ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $id . "'>" . $row['id'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $rate . "\" id=\"" . $rate . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"  disabled onkeypress=\"keyset('credper',event);\" /></td>
							 <td align=right ><input type=\"text\"  class=\"text_purchase3\" name=\"" . $actual_selling . "\" id=\"" . $actual_selling . "\" size=\"15\"  value=\"" . number_format($row['actual_selling'], 2, ".", ",") . "\" onblur=\"calc1_table('" . $i . "');\"  /></td>
							  <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $qty . "\" id=\"" . $qty . "\" size=\"15\"  value=\"" . number_format($row['cur_qty'], 0, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . number_format($row["dis_per"], 6, ".", ",") . "</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>";
        // <td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>
        $ResponseXML .= " <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['id'] . "');\"></td>";

        //include_once("connectioni.php");
        $sqlqty = "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'";
        $resultqty = mysqli_query($GLOBALS['dbinv'], $sqlqty);

        // $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
        if ($rowqty = mysqli_fetch_array($resultqty)) {
            $qty = number_format($rowqty['QTYINHAND'], 0, ".", ",");
        } else {
            $qty = 0;
        }

        /* if ($row['ad']=="1"){
          $ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."' checked></td>";
          } else {
          $ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>";
          } */

        $ResponseXML .= "<td  >" . $qty . "</td>
							
							 
                            </tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

    $sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

    $sql_invpara = "SELECT * from invpara";
    $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
    $row_invpara = mysqli_fetch_array($result_invpara);

    $vatrate = $row_invpara["vatrate"] / 100;

    if ($_GET["vatmethod"] == "vat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $strvatrate = "Tax (VAT " . $row_invpara["vatrate"] . "%)";
        $ResponseXML .= "<taxname><![CDATA[" . $strvatrate . "]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $strvatrate = "Tax (SVAT " . $row_invpara["vatrate"] . "%)";
        $ResponseXML .= "<taxname><![CDATA[" . $strvatrate . "]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $strvatrate = "Tax (EVAT " . $row_invpara["vatrate"] . "%)";
        $ResponseXML .= "<taxname><![CDATA[" . $strvatrate . "]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "non") {
        //$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
        $ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";

        $invtot = number_format($row['tot_sub'], 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    }

    $ResponseXML .= " </salesdetails>";

    //	}

    echo $ResponseXML;
}

if ($_GET["Command"] == "disp_qty") {
    //include_once("connectioni.php");

    $sqlqty = "select QTYINHAND from s_submas where STK_NO='" . $_GET["it_code"] . "' AND STO_CODE='" . $_GET["department"] . "'";
    $resultqty = mysqli_query($GLOBALS['dbinv'], $sqlqty);

    //$sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$_GET["it_code"]."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
    if ($rowqty = mysqli_fetch_array($resultqty)) {
        $qty = $rowqty['QTYINHAND'];
    } else {
        $qty = 0;
    }
    echo $qty;
}

if ($_GET["Command"] == "setord") {

    $sql = "Select ORDNO from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["ORDNO"];
    $lenth = strlen($tmpinvno);
    $invno = trim("ORD/") . $_GET["salesrep"] . "/" . substr($tmpinvno, $lenth - 7);
    $_SESSION["invno"] = $invno;

    include_once ("connectioni.php");

    $_SESSION["custno"] = $_GET['custno'];
    $_SESSION["brand"] = $_GET["brand"];
    $_SESSION["department"] = $_GET["department"];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<txtdono><![CDATA[]]></txtdono>";

    $cuscode = $_GET["custno"];
    $salesrep = $_GET["salesrep"];
    $brand = $_GET["brand"];


    $OutpDAMT = 0;
    $OutREtAmt = 0;
    $OutInvAmt = 0;
    $InvClass = "";

    $sqlclass = mysqli_query($GLOBALS['dbinv'], "select class,dis,barnd_name from brand_mas where barnd_name='" . trim($brand) . "'") or die(mysqli_error());
    if ($rowclass = mysqli_fetch_array($sqlclass)) {
        if (is_null($rowclass["class"]) == false) {
            $InvClass = $rowclass["class"];
        }
         
        if($rowclass['barnd_name']=="PRESA" ){  
            $chktbr="OK";
            $ResponseXML .= "<tbrcheck><![CDATA[" . $chktbr . "]]></tbrcheck>"; 
            if($_SESSION["tbrsession"]=="ok"){ 
                $ResponseXML .= "<txt_dis><![CDATA[" . 0.00 . "]]></txt_dis>";
            }else{
                $ResponseXML .= "<txt_dis><![CDATA[" . $rowclass["dis"] . "]]></txt_dis>";
            }
            
        }else{
             $chktbr="NOT";
             $_SESSION["tbrsession"]=" ";
            $ResponseXML .= "<tbrcheck><![CDATA[" . $chktbr . "]]></tbrcheck>"; 
            $ResponseXML .= "<txt_dis><![CDATA[" . $rowclass["dis"] . "]]></txt_dis>";
        }
        
    }

    $sqloutinv = mysqli_query($GLOBALS['dbinv'], "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and SAL_EX='" . trim($salesrep) . "' and class='" . $InvClass . "'") or die(mysqli_error());
    if ($rowoutinv = mysqli_fetch_array($sqloutinv)) {
        if (is_null($rowoutinv["totout"]) == false) {
            $OutInvAmt = $rowoutinv["totout"];
        }
    }

    //$sqlinvcheq = mysqli_query($GLOBALS['dbinv'],"SELECT * FROM s_invcheq WHERE che_date>'".$_GET["invdate"]."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salesrep)."'") or die(mysqli_error());
    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as che_amount FROM s_invcheq WHERE che_date>'" . $_GET["invdate"] . "' AND cus_code='" . trim($cuscode) . "' and sal_ex='" . trim($salesrep) . "'") or die(mysqli_error());


    while ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {


        $OutpDAMT = $OutpDAMT + $rowinvcheq["che_amount"];
    }

    $pend_ret_set = 0;

    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'" . $_GET["invdate"] . "' AND cus_code='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
    if ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {
        if (is_null($rowinvcheq["che_amount"]) == false) {
            $pend_ret_set = $rowinvcheq["che_amount"];
        }
    }

    $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='" . trim($salesrep) . "'") or die(mysqli_error());
    if ($rowcheq = mysqli_fetch_array($sqlcheq)) {
        if (is_null($rowcheq["tot"]) == false) {
            $OutREtAmt = $rowcheq["tot"];
        } else {
            $OutREtAmt = 0;
        }
    }

    $d = date("Y-m-d");

    $date = date('Y-m-d', strtotime($d . ' -60 days'));

    $sql_rssal = mysqli_query($GLOBALS['dbinv'], "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE = '" . trim($cuscode) . "' and (SDATE < '" . $date . "') and GRAND_TOT - TOTPAY > 1 and CANCELL = '0'") or die(mysqli_error());

    if ($row_rssal = mysqli_fetch_array($sql_rssal)) {

        if (is_null($row_rssal["out1"]) == false) {
            $rtxover60 = number_format($row_rssal["out1"], 2, ".", ",");
        }
    }

    $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutREtAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutpDAMT, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Over 60 Outstandings\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . $rtxover60 . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";

    $ResponseXML .= "<OutInvAmt><![CDATA[" . $OutInvAmt . "]]></OutInvAmt>";
    $ResponseXML .= "<OutREtAmt><![CDATA[" . $OutREtAmt . "]]></OutREtAmt>";
    $ResponseXML .= "<OutpDAMT><![CDATA[" . $OutpDAMT . "]]></OutpDAMT>";

    //echo "select * from br_trn where Rep='".trim($salesrep)."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'";
    $txt_crelimi = 0;
    $txt_crebal = 0;
    $crebal = 0;
    //echo "select * from br_trn where Rep='" . trim($salesrep) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($cuscode) . "'";
    $sqlbr_trn = mysqli_query($GLOBALS['dbinv'], "select * from br_trn where Rep='" . trim($salesrep) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($cuscode) . "'") or die(mysqli_error());

    if ($rowbr_trn = mysqli_fetch_array($sqlbr_trn)) {

        if (is_null($rowbr_trn["credit_lim"]) == false) {
            $crLmt = $rowbr_trn["credit_lim"];
        } else {
            $crLmt = 0;
        }

        if (is_null($rowbr_trn["tmpLmt"]) == false) {
            $tmpLmt = $rowbr_trn["tmpLmt"];
        } else {
            $tmpLmt = 0;
        }

        if (is_null($rowbr_trn["tmpLmt"]) == false) {
            if ($rowbr_trn["Day"] == date("Y-m-d")) {
                $tmpLmt = $rowbr_trn["tmpLmt"];
            } else {

                $sql_invcls = mysqli_query($GLOBALS['dbinv'], "select * from brand_mas where barnd_name='" . trim($_GET["brand"]) . "'") or die(mysqli_error());
                if ($row_invcls = mysqli_fetch_array($sql_invcls)) {
                    $sql_upbr = mysqli_query($GLOBALS['dbinv'], "update br_trn set tmpLmt= '0'   where cus_code='" . trim($cuscode) . "' and brand='" . trim($row_invcls["class"]) . "' and Rep='" . trim($salesrep) . "'") or die(mysqli_error());
                }
                $tmpLmt = 0;
            }
        } else {
            $tmpLmt = 0;
        }

        //echo "cat ".$rowbr_trn["CAT"];
        if (is_null($rowbr_trn["CAT"]) == false) {
            $cuscat = trim($rowbr_trn["CAT"]);
            if ($cuscat == "A") {
                $m = 2.5;
            }
            if ($cuscat == "B") {
                $m = 2.5;
            }
            if ($cuscat == "C") {
                $m = 1;
            }
            if ($cuscat == "D") {
                $m = 0;
            }

            $txt_crelimi = 0;
            $txt_crebal = 0;
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
            //$crebal=$crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            //$txt_crebal = $crLmt * $m  - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            //$txt_crebal = number_format($crebal, "2", ".", ",");
        } else {
            $txt_crelimi = 0;
            $txt_crebal = 0;
        }

        $crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;


        $txt_crebal = $crLmt * $m - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
        $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
    }



    $invqty = 0;
    $rtnqty = 0;
    $Mon = date("m", strtotime(date("Y-m-d")));
    $Yer = date("Y", strtotime(date("Y-m-d")));
    $sql_inv = "Select sum(Qty) as totQty from viewinv where  Cus_CODE = '" . trim($cuscode) . "' and s_Brand = '" . trim($_GET["brand"]) . "' and month(SDATE) = '" . $Mon . "' and year(SDATE) = '" . $Yer . "' and cancel_m = '0' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352'  and stk_no <> 'A0797' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'L0531' AND stk_no <> 'T3520' AND stk_no <> 'T3522' and stk_no <> 'A0356' and price <> 0  and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and stk_no <> 'AL004' and stk_no <> 'AL005' and stk_no <> 'AL006' and stk_no <> 'AL007' and stk_no <> 'AL008' and stk_no <> 'AL009'  and stk_no <> 'A0356' and stk_no <> 'AL011'  and dis_per <> 100";
    $sql_grn = " Select sum(Qty) as totQty from viewcrntrn where  C_CODE = '" . trim($cuscode) . "' and Brand = '" . trim($_GET["brand"]) . "' and month(SDATE) = '" . $Mon . "' and year(SDATE) = '" . $Yer . "' and cancell = '0' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0797' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'L0531' AND stk_no <> 'T3520' AND stk_no <> 'T3522' and stk_no <> 'A0356'  and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and stk_no <> 'AL004' and stk_no <> 'AL005' and stk_no <> 'AL006' and stk_no <> 'AL007' and stk_no <> 'AL008' and stk_no <> 'AL009' and stk_no <> 'A0356' and stk_no <> 'AL011'";
    $res_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
    if ($row_inv = mysqli_fetch_array($res_inv)) {
        if (!is_null($row_inv['totQty'])) {
            $invqty = $row_inv['totQty'];
        }
    }
    $res_grn = mysqli_query($GLOBALS['dbinv'], $sql_grn);
    if ($row_grn = mysqli_fetch_array($res_grn)) {
        if (!is_null($row_grn['totQty'])) {
            $rtnqty = $row_grn['totQty'];
        }
    }


    $netqty = $invqty - $rtnqty;

    $ResponseXML .= "<netqty><![CDATA[" . $netqty . "]]></netqty>";


    
    $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
    $ResponseXML .= "<txt_crebal><![CDATA[" . number_format($txt_crebal, "2", ".", ",") . "]]></txt_crebal>";
    $ResponseXML .= "<creditbalance><![CDATA[" . number_format($txt_crebal, "2", ".", ",") . "]]></creditbalance>";
    $ResponseXML .= "<crebal><![CDATA[" . number_format($crebal, "2", ".", ",") . "]]></crebal>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "to_wd") {
    $sqlt = "update s_cusordmas set Forward='WD', Result='P' where REF_NO ='" . $_GET['salesord1'] . "'";
    $resultt = mysqli_query($GLOBALS['dbinv'], $sqlt);
}

if ($_GET["Command"] == "del_item") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = "delete from tmp_ord_data where id='" . $_GET['code'] . "' and tmp_no='" . $_SESSION["tmp_no_ord"] . "'";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"50\"  background=\"\" ><font color=\"#FFFFFF\">ID</font></td>
							  <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate With VAT</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							  <td></td>
							  <td width=\"70\">Qty In Hand</td>
							  
                            </tr>";

    $i = 1;
    $sql = "Select * from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $id = "id" . $i;
        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $rate = "rate" . $i;
        $actual_selling = "actual_selling" . $i;
        $qty = "qty" . $i;
        $discountper = "discountper" . $i;
        $subtotal = "subtotal" . $i;
        $discount = "discount" . $i;
        $ad = "ad" . $i;

        $ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $id . "'>" . $row['id'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $rate . "\" id=\"" . $rate . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" /></td>
							  <td align=right ><input type=\"text\"  class=\"text_purchase3\" name=\"" . $actual_selling . "\" id=\"" . $actual_selling . "\" size=\"15\"  value=\"" . number_format($row['actual_selling'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"   /></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $qty . "\" id=\"" . $qty . "\" size=\"15\"  value=\"" . number_format($row['cur_qty'], 0, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . $row["dis_per"] . "</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>
							
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['id'] . "');\"></td>";

        // include_once("connectioni.php");
        $sqlqty = "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'";
        $resultqty = mysqli_query($GLOBALS['dbinv'], $sqlqty);

        // $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
        if ($rowqty = mysqli_fetch_array($resultqty)) {
            $qty = number_format($rowqty['QTYINHAND'], 0, ".", ",");
        } else {
            $qty = 0;
        }

        /* if ($row['ad']=="1"){
          $ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."' checked></td>";
          } else {
          $ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>";
          } */

        $ResponseXML .= "<td  >" . $qty . "</td>
						
							
							 
                            </tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

    $sql_invpara = "SELECT * from invpara";
    $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
    $row_invpara = mysqli_fetch_array($result_invpara);

    $vatrate = $row_invpara["vatrate"] / 100;

    if ($_GET["vatmethod"] == "vat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $strvatrate = "Tax (VAT " . $row_invpara["vatrate"] . "%)";
        $ResponseXML .= "<taxname><![CDATA[" . $strvatrate . "]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $strvatrate = "Tax (SVAT " . $row_invpara["vatrate"] . "%)";
        $ResponseXML .= "<taxname><![CDATA[" . $strvatrate . "]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $strvatrate = "Tax (EVAT " . $row_invpara["vatrate"] . "%)";
        $ResponseXML .= "<taxname><![CDATA[" . $strvatrate . "]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "non") {
        //$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
        $ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";

        $invtot = number_format($row['tot_sub'], 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    }

    $ResponseXML .= " </salesdetails>";

    //	}

    echo $ResponseXML;
}

if ($_GET["Command"] == "save_item_ord") {

    //	$_SESSION["CURRENT_DOC"] = 1;      //document ID
    //$_SESSION["VIEW_DOC"] = false ;     //view current document
    //	$_SESSION["FEED_DOC"] = true;       //save  current document
    //	$_GET["MOD_DOC"] = false  ;         //delete   current document
    //	$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
    //	$_GET["PRICE_EDIT"] = false ;       //edit selling price
    //	$_GET["CHECK_USER"] = false ;       //check user permission again

    if ($_SESSION["save_sales_ord"] == 1) {

        $_SESSION["salesord1"] = $_GET['salesord1'];
        //$_SESSION["brand"]="";

        $sql = "Select ORDNO from invpara";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $tmpinvno = "000000" . $row["ORDNO"];
        $lenth = strlen($tmpinvno);
        $invno = trim("ORD/") . $_GET["salesrep"] . "/" . substr($tmpinvno, $lenth - 7);
        $_SESSION["invno"] = $invno;

        $sql = "delete from s_cusordmas where REF_NO='" . $invno . "' ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        // Insert s_salma ============================================================

        $sql = "Select * from vendor where CODE='" . $_GET['customercode'] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $cusname = $row["NAME"];

        $sql = "select * from vender_sub where c_code = '" . $_GET["c_subcode"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row = mysqli_fetch_array($result)) {

            $cusname = $row['c_name'];
        }


        $totdiscount = str_replace(",", "", $_GET["totdiscount"]);
        $subtot = str_replace(",", "", $_GET["subtot"]);
        $invtot = str_replace(",", "", $_GET["invtot"]);
        $tax = str_replace(",", "", $_GET["tax"]);

        if ($_GET["discount_org1"] == '') {
            $discount1 = 0;
        } else {
            $discount1 = $_GET["discount_org1"];
        }
        if ($_GET["discount_org2"] == '') {
            $discount2 = 0;
        } else {
            $discount2 = $_GET["discount_org2"];
        }
        if ($_GET["discount_org3"] == '') {
            $discount3 = 0;
        } else {
            $discount3 = $_GET["discount_org3"];
        }

        if ($_GET["vatmethod"] == "non") {
            $vatmethod = 0;
        } else if ($_GET["vatmethod"] == "vat") {
            $vatmethod = 1;
        } else if ($_GET["vatmethod"] == "svat") {
            $vatmethod = 2;
        } else if ($_GET["vatmethod"] == "evat") {
            $vatmethod = 3;
        }

        $invtot = str_replace(",", "", $_GET["invtot"]);
        $balance = str_replace(",", "", $_GET["balance"]);
        $creditlimit = str_replace(",", "", $_GET["creditlimit"]);

        $tmpsubtot = 0;
        $tot_dis_per = 0;

        $sqltmp = "select * from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "' order by id";
        $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);
        while ($rowtmp = mysqli_fetch_array($resulttmp)) {

            $dis_per = $rowtmp["cur_rate"] * $rowtmp["cur_qty"] * $rowtmp["dis_per"] * 0.01;

            $tot_dis_per = $tot_dis_per + $dis_per;

            $tmpsubtot = $tmpsubtot + (($rowtmp["cur_rate"] * $rowtmp["cur_qty"]) - $dis_per);
        }

        $vat = "";
        if (($_GET["vatmethod"] == "vat") or ( $_GET["vatmethod"] == "svat") or ( $_GET["vatmethod"] == "evat")) {
            $vat = "1";
        } else {
            $vat = "0";
        }

        $sql_invpara = "SELECT * from invpara";
        $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
        $row_invpara = mysqli_fetch_array($result_invpara);

        if ($vat == "1") {
            $vat_value = $tmpsubtot * $row_invpara["vatrate"] / 100;
        } else {
            $vat_value = 0;
        }
        //echo $tmpsubtot."/".$vat_value." / ";
        $grand_tot = $tmpsubtot + $vat_value;

        $form_subtot = str_replace(",", "", $_GET["subtot"]);
        //echo $form_subtot."/".$tmpsubtot;
        if (number_format($form_subtot, 0, ".", "") != number_format($tmpsubtot, 0, ".", "")) {
            if (number_format($form_subtot, 1, ".", "") != number_format($tmpsubtot, 1, ".", "")) {
                if (number_format($form_subtot, 2, ".", "") != number_format($tmpsubtot, 2, ".", "")) {
                    exit("err1");
                }
            }
        }

        $form_disc = str_replace(",", "", $_GET["totdiscount"]);
        //echo $form_disc."/".$tot_dis_per." - ";
        //echo number_format($form_disc, 0, ".", "")."/".number_format($tot_dis_per, 0, ".", "")." - ";
        //echo number_format($form_disc, 1, ".", "")."/".number_format($tot_dis_per, 1, ".", "")." - ";
        //echo number_format($form_disc, 2, ".", "")."/".number_format($tot_dis_per, 2, ".", "");
        if (number_format($form_disc, 0, ".", "") != number_format($tot_dis_per, 0, ".", "")) {
            if (number_format($form_disc, 1, ".", "") != number_format($tot_dis_per, 1, ".", "")) {
                if (number_format($form_disc, 2, ".", "") != number_format($tot_dis_per, 2, ".", "")) {
                    exit("err2");
                }
            }
        }

        $form_tax = str_replace(",", "", $_GET["tax"]);
        //echo $form_tax."/".$vat_value;
        if (number_format($form_tax, 0, ".", "") != number_format($vat_value, 0, ".", "")) {
            if (number_format($form_tax, 1, ".", "") != number_format($vat_value, 1, ".", "")) {
                if (number_format($form_tax, 2, ".", "") != number_format($vat_value, 2, ".", "")) {
                    exit("err3");
                }
            }
        }

        $form_invtot = str_replace(",", "", $_GET["invtot"]);
        //echo $form_invtot."/".$grand_tot;
        //echo number_format($form_invtot, 2, ".", "")."/".number_format($grand_tot, 2, ".", "");
        if (number_format($form_invtot, 0, ".", "") != number_format($grand_tot, 0, ".", "")) {
            if (number_format($form_invtot, 1, ".", "") != number_format($grand_tot, 1, ".", "")) {
                if (number_format($form_invtot, 2, ".", "") != number_format($grand_tot, 2, ".", "")) {
                    exit("err4");
                }
            }
        }

        $sub = 0;

        $sqltmp = "select * from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "' order by id";
        //echo $sqltmp;
        $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);
        while ($rowtmp = mysqli_fetch_array($resulttmp)) {

            $sub = $sub + (($rowtmp["actual_selling"] - $rowtmp["cur_rate"]) * $rowtmp["cur_qty"]);
        }

        $mqty = 0;
        $sqltmp = "select * from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "' order by id";
        //echo $sqltmp;
        $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);
        while ($rowtmp = mysqli_fetch_array($resulttmp)) {

            $mqty = $mqty + ($rowtmp["cur_qty"]);
        }
        if ($mqty == 0) {
            exit("err6");
        }


        $calsub = $sub * (100 - $discount1) / 100;

        if ($vatmethod == 0) {
            if ($calsub != 0) {
                exit("err5");
            }

            if ($tax != 0) {
                exit("err5");
            }
        }



        if ($balance < $invtot) {
            $ex_lim = $invtot - $balance;
        } else {
            $ex_lim = 0;

            $sql_over60 = "select SDATE from  s_salma where Accname != 'NON STOCK' and  C_CODE='" . trim($_GET['customercode']) . "' and GRAND_TOT-TOTPAY >1 and CANCELL=0  order by SDATE limit 1";
            $result_over60 = mysqli_query($GLOBALS['dbinv'], $sql_over60);
            if ($row_over60 = mysqli_fetch_array($result_over60)) {
                $diff = abs(strtotime($_GET["invdate"]) - strtotime($row_over60["SDATE"]));
                $mdays = floor($diff / (60 * 60 * 24));
                if ($mdays > 75) {
                    $ex_lim = 1;
                }
            }

            $sql_ret = "Select *  from s_cheq where CR_CHEVAL-PAID>10 and CR_FLAG='0' and CR_C_CODE='" . trim($_GET['customercode']) . "'";
            $result_ret = mysqli_query($GLOBALS['dbinv'], $sql_ret);
            if ($row_ret = mysqli_fetch_array($result_ret)) {
                $ex_lim = 1;
            }
        }

        if ($_GET["vatmethod"] == "non") {
            $vatmethod = 0;
        } else if ($_GET["vatmethod"] == "vat") {
            $vatmethod = 1;
        } else if ($_GET["vatmethod"] == "svat") {
            $vatmethod = 2;
        } else if ($_GET["vatmethod"] == "evat") {
            $vatmethod = 3;
        }


        If ($ex_lim == 0) {
            $result = "OK";
        } Else {
            $result = "P";
        }

        $sql = "Insert into s_cusordmas(REF_NO, TRN_TYPE, SDATE, C_CODE, BRAND, CUS_NAME, VAT, TYPE, DISCOU, AMOUNT, GRAND_TOT, DIS, DIS1, DIS2,  DEPARTMENT, SAL_EX, VAT_VAL, CANCELL, DEV, REQ_DATE, INVNO, tmp_no, Limit_need, Forward, GST, DUMMY_VAL, DIS_RUP, CASH, TOTPAY, ORD_NO, ORD_DA, SETTLED, TOTPAY1, DES_CAT, REMARK, BTT, Account, Accname, Costcenter, RET_AMO, comm, approveby, Result, Rejectby,c_code1) values('" . $invno . "', 'INV', '" . $_GET["invdate"] . "', '" . $_GET["customercode"] . "', '" . $_GET["brand"] . "', '" . $cusname . "', 	'" . $vatmethod . "', '" . $_GET["paymethod"] . "', " . $totdiscount . ", " . $subtot . ", " . $invtot . ", " . $discount1 . ", " . $discount2 . ", " . $discount3 . ",  '" . $_GET['department'] . "', '" . $_GET["salesrep"] . "', " . $tax . ", '0', '" . $_SESSION['dev'] . "', '" . $_GET["invdate"] . "', '0', '" . $_SESSION["tmp_no_ord"] . "', " . $ex_lim . ", 'MM', 0, 0, 0, 0, 0, '', '" . $_GET["invdate"] . "', '', 0, '', '', 0, '', '', '', 0, 0, 0, '" . $result . "', '0','" . $_GET['c_subcode'] . "')";
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql = "delete from s_cusordtrn where REF_NO='" . $invno . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sqltmp = "select * from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "' order by id";
        //echo $sqltmp;
        $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);
        while ($rowtmp = mysqli_fetch_array($resulttmp)) {
            $sqlcost = "select * from s_mas where STK_NO='" . $rowtmp["str_code"] . "' and BRAND_NAME='" . $_GET["brand"] . "'";
            //echo $sqlcost;
            $resultcost = mysqli_query($GLOBALS['dbinv'], $sqlcost);
            $rowcost = mysqli_fetch_array($resultcost);

            $sql = "insert into s_cusordtrn (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, COST, PRICE, QTY, DEPARTMENT, DIS_per, DIS_rs, REP, TAX_PER, BRAND, CANCELL, tmp_no, UNIT, ret_qty, DEV, c_code, stk, inv_qty) values('" . trim($invno) . "','" . $_GET["invdate"] . "', '" . trim($rowtmp["str_code"]) . "','" . trim($rowtmp["str_description"]) . "', ''," . $rowcost["COST"] . "," . $rowtmp["cur_rate"] . "," . $rowtmp["cur_qty"] . ",'" . trim($_GET["department"]) . "'," . $rowtmp["dis_per"] . "," . $rowtmp["cur_discount"] . ",'" . trim($_GET["salesrep"]) . "','" . $row_invpara["vatrate"] . "','" . trim($rowcost["BRAND_NAME"]) . "', '0',  '" . $_SESSION["tmp_no_ord"] . "', 'ORD', 0, '', '', 0," . $rowtmp["cur_qty"] . ")";
            //echo $sql;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
        }

        $sql = "delete  from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "' ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        //====creditor file ================================================

        $sql = "Insert into s_led(REF_NO, SDATE, C_CODE, amount, flag, department) values ('" . $invno . "', '" . $_GET["invdate"] . "', '" . $_GET["customercode"] . "', " . $invtot . ", 'INV', '" . $_GET["department"] . "')";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql = "update invpara set ORDNO=ORDNO+1";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);


        $sql = "update s_quomas1 set ORD_NO='" . $invno . "' where ref_no='" . $_GET["salesord2"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);


        $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $invno . "', '" . $_SESSION["CURRENT_USER"] . "', 'Order', 'SAVE', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $result = mysqli_query($GLOBALS['dbinv'], $sql2);


        $_SESSION["print"] = 1;
        $_SESSION["save_sales_ord"] = 0;

        $ResponseXML .= "";
        $ResponseXML .= "<salesdetails>";
        $ResponseXML .= "<Saved><![CDATA[Saved]]></Saved>";
        $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
        $ResponseXML .= "<company><![CDATA[" . $_SESSION['company'] . "]]></company>";
        $ResponseXML .= "</salesdetails>";
    } else {
        $ResponseXML .= "";
        $ResponseXML .= "<salesdetails>";
        $ResponseXML .= "<Saved><![CDATA[Can't Save]]></Saved>";
        $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
        $ResponseXML .= "<company><![CDATA[" . $_SESSION['company'] . "]]></company>";
        $ResponseXML .= "</salesdetails>";
    }

    echo $ResponseXML;
}


if ($_GET["Command"] == "check_print") {

    echo $_SESSION["print"];
}

if ($_GET["Command"] == "tbrsession") {
    
    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";
    $_SESSION["tbrsession"] = $_GET["tbrcheck"];

    $sqlclass = mysqli_query($GLOBALS['dbinv'], "select class,dis,barnd_name from brand_mas where barnd_name='" . trim($_GET["brand"]) . "'") or die(mysqli_error());
    if ($rowclass = mysqli_fetch_array($sqlclass)) {
        
        if($rowclass['barnd_name']=="PRESA" ){ 
             
            if($_SESSION["tbrsession"]=="ok"){ 
                $ResponseXML .= "<txt_dis><![CDATA[" . 0.00 . "]]></txt_dis>";
            }else{
                $ResponseXML .= "<txt_dis><![CDATA[" . $rowclass["dis"] . "]]></txt_dis>";
            }
            
        }else{ 
            $ResponseXML .= "<txt_dis><![CDATA[" . $rowclass["dis"] . "]]></txt_dis>";
        }
        
    }
            
    
    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
 
    
}

mysqli_close($GLOBALS['dbinv']);
?>