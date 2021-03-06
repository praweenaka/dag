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
	$vatrate = 0.08;

	$ResponseXML = "";
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

if ($_GET["Command"] == "new_inv") {

	$_SESSION["print"] = 0;
	$_SESSION["save_sales_inv"] = 1;
	/*	$sql="Select CAS_INV_NO_m from invpara";
	 $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
	 $row = mysqli_fetch_array($result);
	 $tmpinvno="000000".$row["CAS_INV_NO_m"];
	 $lenth=strlen($tmpinvno);
	 $invno="INV".substr($tmpinvno, $lenth-7);
	 echo $invno;*/

	$sql = "select QTNNO from invpara";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	$row = mysqli_fetch_array($result);
	$tmpinvno = "000000" . $row["QTNNO"];
	$lenth = strlen($tmpinvno);
	//echo $tmpinvno;
	$invno = trim("QTN/ ") . substr($tmpinvno, $lenth - 7);
	$_SESSION["invno"] = $invno;

	$_SESSION["brand"] = "";

	$sql = "Select QTNNO from tmpinvpara";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	$row = mysqli_fetch_array($result);
	$_SESSION["tmp_no_quot"] = "QTN/" . $row["QTNNO"];

	$sql = "delete from tmp_quot_data where tmp_no='" . $_SESSION["tmp_no_quot"] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	$sql = "update tmp_quot_data set QTNNO=QTNNO+1";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	echo $invno;

}

if ($_GET["Command"] == "cancel_inv") {

	$sql = "update s_quomas set CANCELL = '1' where REF_NO = '" . trim($_GET["invno"]) . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	$sql = "update s_quotrn set CANCELL = '1' where REF_NO = '" . trim($_GET["invno"]) . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	echo "Deleted";
}

if ($_GET["Command"] == "add_tmp") {

	$department = $_GET["department"];

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	$sql = "delete from tmp_quot_data where str_code='" . $_GET['itemcode'] . "' and tmp_no='" . $_SESSION["tmp_no_quot"] . "' ";
	//$ResponseXML .= $sql;
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	//echo $_GET['rate'];
	//echo $_GET['qty'];
	$rate = str_replace(",", "", $_GET["rate"]);
	$qty = str_replace(",", "", $_GET["qty"]);
	$discount = str_replace(",", "", $_GET["discount"]);
	$subtotal = str_replace(",", "", $_GET["subtotal"]);

	$sql = "Insert into tmp_quot_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, tmp_no)values 
			('" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', " . $rate . ", " . $qty . ", " . $_GET["discountper"] . ", " . $discount . ", " . $subtotal . ", '" . $_GET['brand'] . "', '" . $_SESSION["tmp_no_quot"] . "') ";
	//$ResponseXML .= $sql;
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  
                            </tr>";

	$i = 1;
	$sql = "Select * from tmp_quot_data where tmp_no='" . $_SESSION["tmp_no_quot"] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {

		$code = "code" . $i;
		$itemd = "itemd" . $i;
		$rate = "rate" . $i;
		$qty = "qty" . $i;
		$discountper = "discountper" . $i;
		$subtotal = "subtotal" . $i;
		$discount = "discount" . $i;

		$ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  disabled = \"disabled\"  class=\"text_purchase3\" name=\"" . $rate . "\" id=\"" . $rate . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" /></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $qty . "\" id=\"" . $qty . "\" size=\"15\"  value=\"" . number_format($row['cur_qty'], 0, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . number_format($_GET["discountper"], 2, ".", ",") . "</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>
							 
							
						
							
							 
                            </tr>";
		$i = $i + 1;
	}

	$ResponseXML .= "   </table>]]></sales_table>";

	$ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

	$sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_quot_data where tmp_no='" . $_SESSION["tmp_no_quot"] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	$row = mysqli_fetch_array($result);
	$ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
	$ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

	$vatrate = 0.08;

	if ($_GET["vatmethod"] == "vat") {
		$tax = $row['tot_sub'] * $vatrate;
		$taxf = number_format($tax, 2, ".", ",");

		$ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
		$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";

		$invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
		$ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";

	} else if ($_GET["vatmethod"] == "svat") {
		$tax = $row['tot_sub'] * $vatrate;
		$taxf = number_format($tax, 2, ".", ",");

		$ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
		$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";

		$invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
		$ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";

	} else if ($_GET["vatmethod"] == "evat") {
		$tax = $row['tot_sub'] * $vatrate;
		$taxf = number_format($tax, 2, ".", ",");

		$ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
		$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";

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

	$department = $_GET["department"];

	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";

	$sql = "delete from tmp_inv_data where str_code='" . $_GET['itemcode'] . "' and tmp_no='" . $_SESSION["tmp_no_salinv"] . "' ";
	//$ResponseXML .= $sql;
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	//echo $_GET['rate'];
	//echo $_GET['qty'];
	$rate = str_replace(",", "", $_GET["rate"]);
	$qty = str_replace(",", "", $_GET["qty"]);
	$discount = str_replace(",", "", $_GET["discount"]);
	$subtotal = str_replace(",", "", $_GET["subtotal"]);

	$sql = "Insert into tmp_inv_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, tmp_no)values 
			('" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', " . $rate . ", " . $qty . ", " . $_GET["discountper"] . ", " . $discount . ", " . $subtotal . ", '" . $_GET['brand'] . "', '" . $_SESSION["tmp_no_salinv"] . "') ";
	//echo $sql;
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  
                            </tr>";

	$i = 1;
	$sql = "Select * from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {

		$code = "code" . $i;
		$itemd = "itemd" . $i;
		$rate = "rate" . $i;
		$qty = "qty" . $i;
		$discountper = "discountper" . $i;
		$subtotal = "subtotal" . $i;
		$discount = "discount" . $i;

		$ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $rate . "\" id=\"" . $rate . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" /></td>
							  <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $qty . "\" id=\"" . $qty . "\" size=\"15\"  value=\"" . number_format($row['cur_qty'], 0, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . number_format($_GET["discountper"], 2, ".", ",") . "</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>
							 
							
						
							
							 
                            </tr>";
		$i = $i + 1;
	}

	$ResponseXML .= "   </table>]]></sales_table>";

	$ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

	$sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	$row = mysqli_fetch_array($result);
	$ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
	$ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

	$vatrate = 0.12;

	if ($_GET["vatmethod"] == "vat") {
		$tax = $row['tot_sub'] * $vatrate;
		$taxf = number_format($tax, 2, ".", ",");

		$ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
		$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";

		$invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
		$ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";

	} else if ($_GET["vatmethod"] == "svat") {
		$tax = $row['tot_sub'] * $vatrate;
		$taxf = number_format($tax, 2, ".", ",");

		$ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
		$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";

		$invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
		$ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";

	} else if ($_GET["vatmethod"] == "evat") {
		$tax = $row['tot_sub'] * $vatrate;
		$taxf = number_format($tax, 2, ".", ",");

		$ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
		$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";

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

	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";

	$sql = "delete from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "' ";
	//$ResponseXML .= $sql;
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	//echo $_GET['rate'];
	//echo $_GET['qty'];

	$i = 1;
	while ($_GET["item_count"] > $i) {

		$code = "code" . $i;
		$itemd = "itemd" . $i;
		$discountper = "discountper" . $i;
		$srate = "rate" . $i;
		$rate = str_replace(",", "", $_GET[$srate]);
		$sqty = "qty" . $i;
		$qty = str_replace(",", "", $_GET[$sqty]);
		$sdiscount = "discount" . $i;
		$discount = str_replace(",", "", $_GET[$sdiscount]);
		$ssubtotal = "subtotal" . $i;
		$subtotal = str_replace(",", "", $_GET[$ssubtotal]);

		$sql = "Insert into tmp_inv_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, tmp_no)values 
			('" . $_GET['invno'] . "', '" . $_GET[$code] . "', '" . $_GET[$itemd] . "', " . $rate . ", " . $qty . ", " . $_GET[$discountper] . ", " . $discount . ", " . $subtotal . ", '" . $_GET['brand'] . "', '" . $_SESSION["tmp_no_salinv"] . "') ";
		//echo $sql;
		$result = mysqli_query($GLOBALS['dbinv'], $sql);
		$i = $i + 1;
	}
	$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  
                            </tr>";

	$i = 1;
	$sql = "Select * from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {

		$code = "code" . $i;
		$itemd = "itemd" . $i;
		$rate = "rate" . $i;
		$qty = "qty" . $i;
		$discountper = "discountper" . $i;
		$subtotal = "subtotal" . $i;
		$discount = "discount" . $i;

		$ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $rate . "\" id=\"" . $rate . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" /></td>
							  <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $qty . "\" id=\"" . $qty . "\" size=\"15\"  value=\"" . number_format($row['cur_qty'], 0, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . number_format($row["dis_per"], 2, ".", ",") . "</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>
							 
							
						
							
							 
                            </tr>";
		$i = $i + 1;
	}

	$ResponseXML .= "   </table>]]></sales_table>";

	$ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

	$sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	$row = mysqli_fetch_array($result);
	$ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
	$ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

	$vatrate = 0.12;

	if ($_GET["vatmethod"] == "vat") {
		$tax = $row['tot_sub'] * $vatrate;
		$taxf = number_format($tax, 2, ".", ",");

		$ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
		$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";

		$invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
		$ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";

	} else if ($_GET["vatmethod"] == "svat") {
		$tax = $row['tot_sub'] * $vatrate;
		$taxf = number_format($tax, 2, ".", ",");

		$ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
		$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";

		$invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
		$ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";

	} else if ($_GET["vatmethod"] == "evat") {
		$tax = $row['tot_sub'] * $vatrate;
		$taxf = number_format($tax, 2, ".", ",");

		$ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
		$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";

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
	include_once ("connectioni.php");

	$sqlqty = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $_GET["it_code"] . "' AND STO_CODE='" . $_GET["department"] . "'") or die(mysqli_error());
	if ($rowqty = mysqli_fetch_array($sqlqty)) {
		$qty = $rowqty['QTYINHAND'];
	} else {
		$qty = 0;
	}
	echo $qty;
}

if ($_GET["Command"] == "setord") {

	include_once ("connectioni.php");

	$len = strlen($_GET["salesord1"]);
	$need = substr($_GET["salesord1"], $len - 7, $len);
	$salesord1 = trim("ORD/ ") . $_GET["salesrep"] . trim(" / ") . $need;

	$_SESSION["custno"] = $_GET['custno'];
	$_SESSION["brand"] = $_GET["brand"];
	$_SESSION["department"] = $_GET["department"];

	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	$cuscode = $_GET["custno"];
	$salesrep = $_GET["salesrep"];
	$brand = $_GET["brand"];

	//		$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";

	//Call SETLIMIT ====================================================================

	/*	$sql = mysqli_query($GLOBALS['dbinv'],"DROP VIEW view_s_salma") or die(mysqli_error());
	 $sql = mysqli_query($GLOBALS['dbinv'],"CREATE VIEW view_s_salma
	 AS
	 SELECT     s_salma.*, brand_mas.class AS class
	 FROM         brand_mas RIGHT OUTER JOIN
	 s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysqli_error());*/

	$OutpDAMT = 0;
	$OutREtAmt = 0;
	$OutInvAmt = 0;
	$InvClass = "";

	$sqlclass = mysqli_query($GLOBALS['dbinv'], "select class from brand_mas where barnd_name='" . trim($brand) . "'") or die(mysqli_error());
	if ($rowclass = mysqli_fetch_array($sqlclass)) {
		if (is_null($rowclass["class"]) == false) {
			$InvClass = $rowclass["class"];
		}
	}

	$sqloutinv = mysqli_query($GLOBALS['dbinv'], "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and SAL_EX='" . trim($salesrep) . "' and class='" . $InvClass . "'") or die(mysqli_error());
	if ($rowoutinv = mysqli_fetch_array($sqloutinv)) {
		if (is_null($rowoutinv["totout"]) == false) {
			$OutInvAmt = $rowoutinv["totout"];
		}
	}

	$sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_invcheq WHERE che_date>'" . date("d-m-Y") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . trim($salesrep) . "'") or die(mysqli_error());
	while ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {

		$sqlsttr = mysqli_query($GLOBALS['dbinv'], "select * from s_sttr where ST_REFNO='" . trim($rowinvcheq["refno"]) . "' and ST_CHNO ='" . trim($rowinvcheq["cheque_no"]) . "'") or die(mysqli_error());
		while ($rowsttr = mysqli_fetch_array($sqlsttr)) {
			$sqlview_s_salma = mysqli_query($GLOBALS['dbinv'], "select class from view_s_salma where REF_NO='" . trim($rowsttr["ST_INVONO"]) . "'") or die(mysqli_error());
			if ($rowview_s_salma = mysqli_fetch_array($sqlview_s_salma)) {

				if (trim($rowview_s_salma["class"]) == $InvClass) {
					$OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
				}
			}
		}
	}

	$pend_ret_set = 0;

	$sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'" . date("d-m-Y") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
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

	$ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutREtAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutpDAMT, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";

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

		if (is_null($rowbr_trn["CAT"]) == false) {
			$cuscat = trim($rowbr_trn["CAT"]);
			if ($cuscat == "A") { $m = 2.5;
			}
			if ($cuscat == "B") { $m = 2.5;
			}
			if ($cuscat == "C") { $m = 1;
			}
			if ($cuscat == "D") { $m = 0;
			}

			$txt_crelimi = 0;
			$txt_crebal = 0;
			$txt_crelimi = number_format($crLmt, 2, ".", ",");
			//$crebal=$crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
			$txt_crebal = $crLmt * $m - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
			$crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;

			//$txt_crebal = number_format($crebal, "2", ".", ",");
		} else {
			$txt_crelimi = 0;
			$txt_crebal = 0;
		}
		$creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;

	}
	$ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
	$ResponseXML .= "<txt_crebal><![CDATA[" . number_format($txt_crebal, "2", ".", ",") . "]]></txt_crebal>";

	$ResponseXML .= "<creditbalance><![CDATA[" . number_format($txt_crebal, "2", ".", ",") . "]]></creditbalance>";

	$ResponseXML .= "</salesdetails>";
	echo $ResponseXML;

}

if ($_GET["Command"] == "del_item") {

	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";

	$sql = "delete from tmp_inv_data where str_code='" . $_GET['code'] . "' and str_invno='" . $_GET['invno'] . "' ";

	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";

	$sql = "Select * from tmp_inv_data where str_invno='" . $_GET['invno'] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {
		$ResponseXML .= "<tr>
                              
                             <td >" . $row['str_code'] . "</a></td>
							 <td>" . $row['str_description'] . "</a></td>
							 <td >" . $row['cur_rate'] . "</a></td>
							 <td  >" . $row['cur_qty'] . "</a></td>
							 <td  >" . $row['cur_discount'] . "</a></td>
							 <td  >" . $row['cur_subtot'] . "</a></td>
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>";

		include_once ("connectioni.php");

		$sqlqty = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'") or die(mysqli_error());
		if ($rowqty = mysqli_fetch_array($sqlqty)) {
			$qty = $rowqty['QTYINHAND'];
		} else {
			$qty = 0;
		}

		$ResponseXML .= "<td  >" . $qty . "</a></td>
                            </tr>";
	}

	$ResponseXML .= "   </table>]]></sales_table>";

	$sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where str_invno='" . $_GET['invno'] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	$row = mysqli_fetch_array($result);
	$ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
	$ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

	$vatrate = 0.12;

	if ($_GET["vatmethod"] == "vat") {
		$tax = $row['tot_sub'] * $vatrate;
		$taxf = number_format($tax, 2, ".", ",");

		$ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
		$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";

		$invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
		$ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";

	} else if ($_GET["vatmethod"] == "svat") {
		$tax = $row['tot_sub'] * $vatrate;
		$taxf = number_format($tax, 2, ".", ",");

		$ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
		$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";

		$invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
		$ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";

	} else if ($_GET["vatmethod"] == "evat") {
		$tax = $row['tot_sub'] * $vatrate;
		$taxf = number_format($tax, 2, ".", ",");

		$ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
		$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";

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

if ($_GET["Command"] == "save_item") {

	$_SESSION["brand"] = "";

	$sql = "select QTNNO from invpara";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	$row = mysqli_fetch_array($result);
	$tmpinvno = "000000" . $row["QTNNO"];
	$lenth = strlen($tmpinvno);
	//echo $tmpinvno;
	$invno = trim("QTN/ ") . substr($tmpinvno, $lenth - 7);

	$sql = "delete from s_quomas where REF_NO='" . $invno . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	$vat = "";
	if (($_GET["vatmethod"] == "vat") or ($_GET["vatmethod"] == "svat") or ($_GET["vatmethod"] == "evat")) {
		$vat = "1";
	} else {
		$vat = "0";
	}

	if ($_GET["Check1"] == "true") { $chk1 = "1";
	}
	if ($_GET["Check2"] == "true") { $chk2 = "1";
	}
	if ($_GET["Check3"] == "true") { $chk3 = "1";
	}
	if ($_GET["Check4"] == "true") { $chk4 = "1";
	}
	if ($_GET["Check5"] == "true") { $chk5 = "1";
	}
	if ($_GET["Check6"] == "true") { $chk6 = "1";
	}
	if ($_GET["Check7"] == "true") { $chk7 = "1";
	}

	if ($_GET["Check1"] == "false") {
		 $chk1 = "0";
	}
	
	if ($_GET["Check2"] == "false") {
		 $chk2 = "0";
	}
	
	if ($_GET["Check3"] == "false") {
		 $chk3 = "0";
	}
	
	if ($_GET["Check4"] == "false") {
		 $chk4 = "0";
	}
	
	if ($_GET["Check5"] == "false") {
		 $chk5 = "0";
	}
	
	if ($_GET["Check6"] == "false") {
		 $chk6 = "0";
	}
	
	if ($_GET["Check7"] == "false") {
		 $chk7 = "0";
	}

	if ($_GET["Combo1"] == "Type") {
		$Warranty = trim($_GET["txt_warranty"]);
	} else {
		$Warranty = trim($_GET["Combo1"]);
	}

	$totdiscount = str_replace(",", "", $_GET["totdiscount"]);
	$invtot = str_replace(",", "", $_GET["invtot"]);
	$subtot = str_replace(",", "", $_GET["subtot"]);
	$tax = str_replace(",", "", $_GET["tax"]);

	$sql = "insert s_quomas (REF_NO, SDATE, C_CODE, CUS_NAME, GROUPS, VAT, TYPE, DISCOU, AMOUNT, GRAND_TOT, DEPARTMENT, SAL_EX, BTT, REMARK, Perform, Chk1, chk2, chk3, chk4, chk5, chk6, chk7, warranty, delivery, pay_type, validity, Country) values
	 ('" . $invno . "', '" . $_GET["invdate"] . "', '" . $_GET["customercode"] . "', '" . $_GET["customername"] . "', '" . $_GET["COM_GROUPS"] . "', '" . $vat . "', '" . $_GET["paymethod"] . "', " . $totdiscount . ", " . $subtot . ", " . $invtot . ", '" . $_GET["department"] . "', '" . $_GET["salesrep"] . "', " . $tax . ", '" . $_GET["TXTREMARK"] . "', '" . $_GET["txt_milage"] . "', " . $chk1 . ", " . $chk2 . ", " . $chk3 . ", " . $chk4 . ", " . $chk5 . ", " . $chk6 . ", " . $chk7 . ", '" . $Warranty . "', '" . $_GET["txt_deldays"] . "', '" . $_GET["txt_paytype"] . "', '" . $_GET["txt_validity"] . "', '" . $_GET["txt_country"] . "')";
	 
	
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	$sqltmp1 = "select * from tmp_quot_data where tmp_no='" . $_SESSION["tmp_no_quot"] . "'";
	$resulttmp1 = mysqli_query($GLOBALS['dbinv'], $sqltmp1);
	while ($rowtmp1 = mysqli_fetch_array($resulttmp1)) {

		$mvat = 8;

		$dis = $rowtmp1["cur_rate"] * $rowtmp1["cur_qty"] * $rowtmp1["dis_per"] * 0.01;

		$sql = "Insert into s_quotrn (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, COST, PRICE, QTY, DEPARTMENT, DIS_per, DIS_rs, REP, TAX_PER, BRAND, VAT) values('" . trim($invno) . "', '" . $_GET["invdate"] . "','" . $rowtmp1["str_code"] . "','" . $rowtmp1["str_description"] . "', '', 0, " . $rowtmp1["cur_rate"] . "," . $rowtmp1["cur_qty"] . ",'" . $_GET["department"] . "'," . $rowtmp1["dis_per"] . "," . $dis . ",'" . trim($_GET["salesrep"]) . "', '" . $mvat . "','" . $_GET["brand"] . "','" . $vat . "')";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);

		//====update stock==========================================================
	}

	$sql = "update invpara set QTNNO=QTNNO+1";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	echo "Saved";

}

if ($_GET["Command"] == "check_print") {
	$sql_para = "select * from invpara";
	$result_para = mysqli_query($GLOBALS['dbinv'], $sql_para);
	$row_para = mysqli_fetch_array($result_para);

	$sql = "SELECT * from view_quomas_quotrn_s_mas where REF_NO= '" . trim($_GET["invno"]) . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {

	}

	if (vatmethod == "non") {
		$txtvatstatus = "Exclusive Of The VAT";
		//m_Report.Text2.Suppress = True

	} else {
		$txtvatstatus = "Inclusive Of The VAT";
		$Text14 = "Vat No =" . $row_para["VAT"];
	}
	$txtdes = $TXTREMARK;
	$txthead = "QUOTATION FOR " . trim($COM_GROUPS);

	$Text1 = $_GET["txt_cusname"];
	$txtad = $_GET["txt_cusadd"];

	if ($_GET["Check1"] == 1) { $Text15 = "Warranty = " . $_GET["Combo1"];
	}
	if ($_GET["Check2"] == 1) {
		$Text16 = $_GET["Check2"];
	} else {
		$Text16 = "Delivery  = Import and Supply within" . trim($_GET["txt_deldays"]);
	}
	if ($_GET["Check4"] == 1) { $Text17 = trim($_GET["Check4"]) . " " . trim($_GET["txt_paytype"]);
	}
	if ($_GET["Check5"] == 1) { $Text18 = trim($_GET["Check5"]) . " " . trim($_GET["txt_validity"]);
	}
	if ($_GET["Check6"] == 1) { $txtcounry = "Country Of Orgin = " . $_GET["txt_country"];
	}
	if ($_GET["Check7"] == 1) { $Text24 = trim($_GET["Check7"]) . " " . trim($_GET["txt_milage"]);
	}
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
	 $result =mysqli_query($GLOBALS['dbinv'],$sql) ;

	 $sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
	 $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
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

	 echo "Tempory limit updated";*/

}
?>