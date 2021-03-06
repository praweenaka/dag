<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("connectioni.php");
	
	
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	 date_default_timezone_set('Asia/Colombo'); 
		
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
		
		
		
		if($_GET["Command"]=="setitem")
		{
			$sql_invpara="SELECT * from invpara";
			$result_invpara =mysqli_query($GLOBALS['dbinv'],$sql_invpara);
			$row_invpara = mysqli_fetch_array($result_invpara);
				
			$vatrate=$row_invpara["vatrate"]/100;
				
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			$sqlt="SELECT * from s_mas where  STK_NO='".$_GET["itemd_hidden"]."'";
			$resultt =mysqli_query($GLOBALS['dbinv'],$sqlt) ; 
			if ($row = mysqli_fetch_array($resultt)){
				$ResponseXML .= "<STK_NO><![CDATA[".$row['STK_NO']."]]></STK_NO>";
				$ResponseXML .= "<DESCRIPT><![CDATA[".$row['DESCRIPT']."]]></DESCRIPT>";
								
				if ($_GET["vatmethod"]=="non"){
					$SELLING=$row['SELLING'];
				} else {
					$SELLING=$row['SELLING']/($vatrate+1);
				}
				
				$ResponseXML .= "<SELLING><![CDATA[".number_format($SELLING, 2, ".", ",")."]]></SELLING>";
				
				$sql_qty = "select QTYINHAND from s_submas where STK_NO='".$_GET['itemd_hidden']."' AND STO_CODE='".$_GET["department"]."'";
				$result_qty =mysqli_query($GLOBALS['dbinv'],$sql_qty);
				if ($row_qty = mysqli_fetch_array($result_qty)){
						if (is_null($row_qty["QTYINHAND"])==false){
							$ResponseXML .= "<qtyinhand><![CDATA[".$row_qty["QTYINHAND"]."]]></qtyinhand>";
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
		
		if($_GET["Command"]=="add_address")
		{
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;
			
			
	/*		$sql="Select * from tmp_army_no where edu= '".$_GET['edu']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			if($row = mysqli_fetch_array($result)){
				$ResponseXML .= "exist";
				
				
				
			}	else {*/
			
		//	$ResponseXML .= "";
			//$ResponseXML .= "<ArmyDetails>";
			
		/*	$sql1="Select * from mas_educational_qualifications where str_Educational_Qualification= '".$_GET['edu']."'";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			$row1 = mysqli_fetch_array($result1);
			$ResponseXML .=  $row1["int_Educational_Qulifications"];*/
			
			$sqlt="Select * from customer_mast where id ='".$_GET['customerid']."'";
			
			$resultt =mysqli_query($GLOBALS['dbinv'],$sqlt) ; 
			if ($rowt = mysqli_fetch_array($resultt)){
				echo $rowt["str_address"];
			}
			
			
				
			
	}
	
	
	
 if ($_GET["Command"]=="chk_number"){
 	$sql="select * from vendor where CODE = '".trim($_GET["txt_cuscode"])."'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	if($row = mysqli_fetch_array($result)){
		echo "included";
	} else { 
		echo "no";
	}
 }
 
 		
		if($_GET["Command"]=="new_inv")
		{
			
			$_SESSION["print"]=0;
			$_SESSION["save_sales_ord"]=1;
			//$_SESSION["brand"]="";
			
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
		/*	$sql="Select SPINV, CRE_INV_NO, CAS_INV_NO from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			//echo $tmpinvno;
			$invno=trim("CRI/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["invno"]=$invno;*/
			
			$sql="Select AD_NO from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["AD_NO"];
			$lenth=strlen($tmpinvno);
			$invno=trim("AD/1/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["invno"]=$invno;
			
			$sql="Select AD_NO from tmpinvpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$_SESSION["tmp_no_ad"]="AD/".$row["AD_NO"];
			
			$sql1="delete from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."'";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			
			$sql1="update tmpinvpara set AD_NO=AD_NO+1";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 

			header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			$ResponseXML .= "<invno><![CDATA[".$invno."]]></invno>";
			$ResponseXML .= "<txtdono><![CDATA[]]></txtdono>";
			
			$ResponseXML .= "</salesdetails>";
			echo $ResponseXML;	
		
		}
	
	
	if($_GET["Command"]=="cancel_inv")
	{
	
	
		$sqlinv1="select * from s_admas where REF_NO='".$_GET['salesord1']."'";
		$resultinv1 =mysqli_query($GLOBALS['dbinv'],$sqlinv1);
		if ($rowinv1 = mysqli_fetch_array($resultinv1))
		{
			$sqlinv="update s_admas set CANCELL='1' where REF_NO='".$_GET['salesord1']."'";
			$resultinv =mysqli_query($GLOBALS['dbinv'],$sqlinv);
	
			$sqlinv="update s_adtrn set CANCELL='1' where REF_NO='".$_GET['salesord1']."'";
			$resultinv =mysqli_query($GLOBALS['dbinv'],$sqlinv);
		
			echo "Canceled";
		} else {
			echo "Can't Cancel";
		}
		
	}
	
	
	if($_GET["Command"]=="chk_ad")
		{
			if ($_GET["chk"]=="false"){
				$chk=0;
			} else {
				$chk=1;
			}
			$sql="update tmp_ad_data set ad='".$chk."' where id=".$_GET["id"]." and str_code='".$_GET['itemcode']."' and tmp_no= '".$_SESSION["tmp_no_ad"]."'";
			echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
		}
		
		
	if($_GET["Command"]=="add_tmp")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			//echo $_SESSION["tmp_no_ad"];
			
			//$sql="delete from tmp_ad_data where str_code='".$_GET['itemcode']."' and tmp_no='".$_SESSION["tmp_no_ad"]."' ";
			//$ResponseXML .= $sql;
			//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			$rate=str_replace(",", "", $_GET["rate"]);
			$actual_selling=str_replace(",", "", $_GET["actual_selling"]);
			
			$qty=str_replace(",", "", $_GET["qty"]);
			$discount=str_replace(",", "", $_GET["discount"]);
			$subtotal=str_replace(",", "", $_GET["subtotal"]);
			
			if ($_GET['ad']=="true"){
				$ad="1";
			} else {
				$ad="0";
			}
			$sql="Insert into tmp_ad_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, actual_selling, brand, tmp_no)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.", ".$actual_selling.", '".$_GET['brand']."', '".$_SESSION["tmp_no_ad"]."') ";
			
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
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
							
			$i=1;
			$sql="Select * from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
				
				$id="id".$i;
				$code="code".$i;
				$itemd="itemd".$i;
				$rate="rate".$i;
				$actual_selling="actual_selling".$i;
				$qty="qty".$i;			
				$discountper="discountper".$i;			
				$subtotal="subtotal".$i;	
				$discount="discount".$i;	
				$ad="ad".$i;	
					
				$sql_mas="Select * from s_mas where STK_NO='".$row['str_code']."'";
				$result_mas =mysqli_query($GLOBALS['dbinv'],$sql_mas);	
				$row_mas = mysqli_fetch_array($result_mas);
					
						
             	$ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$id."'>".$row['id']."</div></td>
							 <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$code."'>".$row['str_code']."</div></td>
							 <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$itemd."'>".$row_mas["DESCRIPT"]."</div></td>
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><input type=\"text\"  class=\"text_purchase3\" name=\"".$rate."\" id=\"".$rate."\" size=\"15\"  value=\"".number_format($row['cur_rate'], 2, ".", ",")."\"  onblur=\"calc1_table('".$i."');\"  onkeypress=\"keyset('credper',event);\" /></td>
							  <td align=right ><input type=\"text\"  class=\"text_purchase3\" name=\"".$actual_selling."\" id=\"".$actual_selling."\" size=\"15\"  value=\"".number_format($row['actual_selling'], 2, ".", ",")."\"  onblur=\"calc1_table('".$i."');\"   /></td>
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><input type=\"text\"  class=\"text_purchase3\" name=\"".$qty."\" id=\"".$qty."\" size=\"15\"  value=\"".number_format($row['cur_qty'], 0, ".", ",")."\"  onblur=\"calc1_table('".$i."');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$discountper."'>".$_GET["discountper"]."</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"".$discount."\" id=\"".$discount."\" size=\"15\"  value=\"".number_format($row['cur_rate'], 2, ".", ",")."\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$subtotal."'>".number_format($row['cur_subtot'], 2, ".", ",")."</div></td>
							
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['id']."');\"></td>";
							 
							// include_once("connectioni.php");
							$sqlqty="select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'";
							$resultqty =mysqli_query($GLOBALS['dbinv'],$sqlqty);	
				
							// $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
					if($rowqty = mysqli_fetch_array($resultqty)){
						$qty=number_format($rowqty['QTYINHAND'], 0, ".", ",");
					} else {
						$qty=0;
					}	
					
					/*if ($row['ad']=="1"){
						$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."' checked></td>";
					} else {
						$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>";
					}*/
							
						
							$ResponseXML .= "<td  >".$qty."</td>
						
							
							 
                            </tr>";
					$i=$i+1;		
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= "<item_count><![CDATA[".$i."]]></item_count>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$sql_invpara="SELECT * from invpara";
				$result_invpara =mysqli_query($GLOBALS['dbinv'],$sql_invpara);
				$row_invpara = mysqli_fetch_array($result_invpara);
			
				$vatrate=$row_invpara["vatrate"]/100;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$strvatrate="Tax (VAT ".$row_invpara["vatrate"]."%)";
					$ResponseXML .= "<taxname><![CDATA[".$strvatrate."]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$strvatrate="Tax (SVAT ".$row_invpara["vatrate"]."%)";
					$ResponseXML .= "<taxname><![CDATA[".$strvatrate."]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$strvatrate="Tax (EVAT ".$row_invpara["vatrate"]."%)";
					$ResponseXML .= "<taxname><![CDATA[".$strvatrate."]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="non"){
					//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
					$ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";
					
					$invtot=number_format($row['tot_sub'], 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
				}
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	if($_GET["Command"]=="add_tmp_edit_rate")
		{
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			//$sql="delete from tmp_ad_data where id='".$_GET['id']."' and str_code='".$_GET['itemcode']."' and tmp_no='".$_SESSION["tmp_no_ad"]."' ";
			
			//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			$rate=str_replace(",", "", $_GET["rate"]);
			$actual_selling=str_replace(",", "", $_GET["actual_selling"]);
			$qty=str_replace(",", "", $_GET["qty"]);
			$discount=str_replace(",", "", $_GET["discount"]);
			$subtotal=str_replace(",", "", $_GET["subtotal"]);
			
			
			//$sql="Insert into tmp_ad_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, tmp_no, actual_selling)values 
			//('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.", '".$_GET['brand']."', '".$_SESSION["tmp_no_ad"]."', ".$actual_selling.") ";
			
			$sql="update tmp_ad_data set cur_rate=".$rate.", cur_qty=".$qty.", dis_per=".$_GET["discountper"].", cur_discount=".$discount.", cur_subtot=".$subtotal.", actual_selling=".$actual_selling." where id='".$_GET['id']."'";
			//('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', , , , , , , '".$_SESSION["tmp_no_ad"]."', ) ";
			//echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
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
							
			$i=1;
			$sql="Select * from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."' order by id";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
				
				$id="id".$i;
				$code="code".$i;
				$itemd="itemd".$i;
				$rate="rate".$i;
				$actual_selling="actual_selling".$i;
				$qty="qty".$i;			
				$discountper="discountper".$i;			
				$subtotal="subtotal".$i;	
				$discount="discount".$i;	
				$ad="ad".$i;	
						
             	$ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$id."'>".$row['id']."</div></td>
							 <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$code."'>".$row['str_code']."</div></td>
							 <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$itemd."'>".$row['str_description']."</div></td>
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><input type=\"text\"  class=\"text_purchase3\" name=\"".$rate."\" id=\"".$rate."\" size=\"15\"  value=\"".number_format($row['cur_rate'], 2, ".", ",")."\" disabled onblur=\"calc1_table('".$i."');\"  onkeypress=\"keyset('credper',event);\" /></td>
							 <td align=right ><input type=\"text\"  class=\"text_purchase3\" name=\"".$actual_selling."\" id=\"".$actual_selling."\" size=\"15\"  value=\"".number_format($row['actual_selling'], 2, ".", ",")."\" onblur=\"calc1_table('".$i."');\" /></td>
							  <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><input type=\"text\"  class=\"text_purchase3\" name=\"".$qty."\" id=\"".$qty."\" size=\"15\"  value=\"".number_format($row['cur_qty'], 0, ".", ",")."\"  onblur=\"calc1_table('".$i."');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$discountper."'>".number_format($_GET["discountper"], 6, ".", ",")."</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"".$discount."\" id=\"".$discount."\" size=\"15\"  value=\"".number_format($row['cur_rate'], 2, ".", ",")."\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$subtotal."'>".number_format($row['cur_subtot'], 2, ".", ",")."</div></td>";
							// <td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>
							$ResponseXML .= " <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['id']."');\"></td>";
							 
							//include_once("connectioni.php");
							$sqlqty="select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'";
							$resultqty =mysqli_query($GLOBALS['dbinv'],$sqlqty);	
							
							
					if($rowqty = mysqli_fetch_array($resultqty)){
						$qty=number_format($rowqty['QTYINHAND'], 0, ".", ",");
					} else {
						$qty=0;
					}	
					
				/*	if ($row['ad']=="1"){
						$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."' checked></td>";
					} else {
						$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>";
					}*/
							
						
							$ResponseXML .= "<td  >".$qty."</td>
						
							
							 
                            </tr>";
					$i=$i+1;		
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= "<item_count><![CDATA[".$i."]]></item_count>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$sql_invpara="SELECT * from invpara";
				$result_invpara =mysqli_query($GLOBALS['dbinv'],$sql_invpara);
				$row_invpara = mysqli_fetch_array($result_invpara);
				
				$vatrate=$row_invpara["vatrate"]/100;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$strvatrate="Tax (VAT ".$row_invpara["vatrate"]."%)";
					$ResponseXML .= "<taxname><![CDATA[".$strvatrate."]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$strvatrate="Tax (SVAT ".$row_invpara["vatrate"]."%)";
					$ResponseXML .= "<taxname><![CDATA[".$strvatrate."]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$strvatrate="Tax (EVAT ".$row_invpara["vatrate"]."%)";
					$ResponseXML .= "<taxname><![CDATA[".$strvatrate."]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="non"){
					//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
					$ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";
					
					$invtot=number_format($row['tot_sub'], 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
				}
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	
	if($_GET["Command"]=="add_tmp_edit_discount")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			//$sql="delete from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."' ";
			//$ResponseXML .= $sql;
			//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
		//echo "count :".$_GET["item_count"];
		$i=1;
		while ($_GET["item_count"]>$i){	
		
			
			$id="id".$i;
			$code="code".$i;
			$itemd="itemd".$i;	
			$discountper="discountper".$i;
			$srate="rate".$i;
			$rate=str_replace(",", "", $_GET[$srate]);
			
			$sactual_selling="actual_selling".$i;
			$actual_selling=str_replace(",", "", $_GET[$sactual_selling]);
			
			$sqty="qty".$i;
			$qty=str_replace(",", "", $_GET[$sqty]);
			$sdiscount="discount".$i;
			$discount=str_replace(",", "", $_GET[$sdiscount]);
			$ssubtotal="subtotal".$i;
			$subtotal=str_replace(",", "", $_GET[$ssubtotal]);
			$ad="ad".$i;
			
			if ($_GET[$ad]=="true"){
				$ad_val="1";
			} else {
				$ad_val="0";
			}
			
			//$sql="Insert into tmp_ad_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, actual_selling, tmp_no, ad)values 
			//('".$_GET['invno']."', '".$_GET[$code]."', '".$_GET[$itemd]."', ".$rate.", ".$qty.", ".$_GET[$discountper].", ".$discount.", ".$subtotal.", '".$_GET['brand']."', '".$actual_selling."', '".$_SESSION["tmp_no_ad"]."', '".$ad_val."') ";
			
			$sql="update tmp_ad_data set cur_rate=".$rate.", cur_qty=".$qty.", dis_per=".$_GET[$discountper].", cur_discount=".$discount.", cur_subtot=".$subtotal.", actual_selling='".$actual_selling."', ad='".$ad_val."' where id=".$_GET[$id];
			//echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			 $i=$i+1;
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
							
			$i=1;
			$sql="Select * from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."' order by id";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
				
				$id="id".$i;
				$code="code".$i;
				$itemd="itemd".$i;
				$rate="rate".$i;
				$actual_selling="actual_selling".$i;
				$qty="qty".$i;			
				$discountper="discountper".$i;			
				$subtotal="subtotal".$i;	
				$discount="discount".$i;	
				$ad="ad".$i;
						
             	$ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$id."'>".$row['id']."</div></td>
							 <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$code."'>".$row['str_code']."</div></td>
							 <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$itemd."'>".$row['str_description']."</div></td>
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><input type=\"text\"  class=\"text_purchase3\" name=\"".$rate."\" id=\"".$rate."\" size=\"15\"  value=\"".number_format($row['cur_rate'], 2, ".", ",")."\"  disabled onkeypress=\"keyset('credper',event);\" /></td>
							 <td align=right ><input type=\"text\"  class=\"text_purchase3\" name=\"".$actual_selling."\" id=\"".$actual_selling."\" size=\"15\"  value=\"".number_format($row['actual_selling'], 2, ".", ",")."\" onblur=\"calc1_table('".$i."');\"  /></td>
							  <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><input type=\"text\"  class=\"text_purchase3\" name=\"".$qty."\" id=\"".$qty."\" size=\"15\"  value=\"".number_format($row['cur_qty'], 0, ".", ",")."\"  onblur=\"calc1_table('".$i."');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$discountper."'>".number_format($row["dis_per"], 6, ".", ",")."</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"".$discount."\" id=\"".$discount."\" size=\"15\"  value=\"".number_format($row['cur_rate'], 2, ".", ",")."\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$subtotal."'>".number_format($row['cur_subtot'], 2, ".", ",")."</div></td>";
							// <td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>
							$ResponseXML .= " <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['id']."');\"></td>";
							 
							
						//include_once("connectioni.php");
						$sqlqty="select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'";
						$resultqty =mysqli_query($GLOBALS['dbinv'],$sqlqty);	
								
							// $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
					if($rowqty = mysqli_fetch_array($resultqty)){
						$qty=number_format($rowqty['QTYINHAND'], 0, ".", ",");
					} else {
						$qty=0;
					}	
					
					/*if ($row['ad']=="1"){
						$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."' checked></td>";
					} else {
						$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>";
					}*/
							
						
							$ResponseXML .= "<td  >".$qty."</td>
							
							 
                            </tr>";
					$i=$i+1;		
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= "<item_count><![CDATA[".$i."]]></item_count>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$sql_invpara="SELECT * from invpara";
				$result_invpara =mysqli_query($GLOBALS['dbinv'],$sql_invpara);
				$row_invpara = mysqli_fetch_array($result_invpara);
				
				$vatrate=$row_invpara["vatrate"]/100;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$strvatrate="Tax (VAT ".$row_invpara["vatrate"]."%)";
					$ResponseXML .= "<taxname><![CDATA[".$strvatrate."]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$strvatrate="Tax (SVAT ".$row_invpara["vatrate"]."%)";
					$ResponseXML .= "<taxname><![CDATA[".$strvatrate."]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$strvatrate="Tax (EVAT ".$row_invpara["vatrate"]."%)";
					$ResponseXML .= "<taxname><![CDATA[".$strvatrate."]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="non"){
					//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
					$ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";
					
					$invtot=number_format($row['tot_sub'], 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
				}
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	if($_GET["Command"]=="disp_qty")
	{
		 //include_once("connectioni.php");
					
					$sqlqty="select QTYINHAND from s_submas where STK_NO='".$_GET["it_code"]."' AND STO_CODE='".$_GET["department"]."'";
					$resultqty =mysqli_query($GLOBALS['dbinv'],$sqlqty);	
							
					//$sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$_GET["it_code"]."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
					if($rowqty = mysqli_fetch_array($resultqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
			echo $qty;		
	}
	
	if($_GET["Command"]=="setord")
	{
		
		$sql="Select AD_NO from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["AD_NO"];
			$lenth=strlen($tmpinvno);
			$invno=trim("AD/").$_GET["salesrep"]."/".substr($tmpinvno, $lenth-7);
			$_SESSION["invno"]=$invno;
		
		 
		
		include_once("connectioni.php");
		
		
		/*
		$len=strlen($_GET["salesord1"]);
		$need=substr($_GET["salesord1"],$len-7, $len);
		$salesord1=trim("AD/ ").$_GET["salesrep"].trim(" / ").$need;
		
			$sql = mysqli_query($GLOBALS['dbinv'],"Select SPINV, CRE_INV_NO, CAS_INV_NO from invpara") or die(mysqli_error());
			$row = mysqli_fetch_array($sql);
			if ($_SESSION['dev']=="1"){
				 				
				$tmpinvno="000000".($row["SPINV"]+1);
				$lenth=strlen($tmpinvno);
			
				$invno=trim("CRI/ ").substr($tmpinvno, $lenth-7)."/5";
				$_SESSION["invno"]=$invno;
				$txtdono=$row["CAS_INV_NO"]+1;
			} else {
				
				$tmpinvno="000000".($row["SPINV"]+1);
				$lenth=strlen($tmpinvno);
			
				$invno=trim("CRI/ ").substr($tmpinvno, $lenth-7)."/".$_GET["salesrep"];
				$_SESSION["invno"]=$invno;
				$txtdono=$row["CRE_INV_NO"]+1;
			
			}
			
			*/
		$_SESSION["custno"]=$_GET['custno'];
		$_SESSION["brand"]=$_GET["brand"];
		$_SESSION["department"]=$_GET["department"];
		
		
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			$ResponseXML .= "<invno><![CDATA[".$invno."]]></invno>";
			$ResponseXML .= "<txtdono><![CDATA[".$txtdono."]]></txtdono>";
			
				$cuscode=$_GET["custno"];	
				$salesrep=$_GET["salesrep"];
				$brand=$_GET["brand"];
					
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
	$InvClass="";
	
	$sqlclass = mysqli_query($GLOBALS['dbinv'],"select class from brand_mas where barnd_name='".trim($brand)."'") or die(mysqli_error());
	if ($rowclass = mysqli_fetch_array($sqlclass)){
		if (is_null($rowclass["class"])==false){
			$InvClass=$rowclass["class"];
		}
	}
	
	$sqloutinv = mysqli_query($GLOBALS['dbinv'],"select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($salesrep)."' and class='".$InvClass."'") or die(mysqli_error());
	if ($rowoutinv = mysqli_fetch_array($sqloutinv)){
		if (is_null($rowoutinv["totout"])==false){
			$OutInvAmt=$rowoutinv["totout"];
		}
	}

$sqlinvcheq = mysqli_query($GLOBALS['dbinv'],"SELECT * FROM s_invcheq WHERE che_date>'".$_GET["invdate"]."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salesrep)."'") or die(mysqli_error());
//echo "SELECT * FROM s_invcheq WHERE che_date>'".$_GET["invdate"]."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salesrep)."'";
	while($rowinvcheq = mysqli_fetch_array($sqlinvcheq)){
		
		$sqlsttr = mysqli_query($GLOBALS['dbinv'],"select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"]) ."'") or die(mysqli_error());
		//echo "select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"]) ."'";
		while($rowsttr = mysqli_fetch_array($sqlsttr)){
			$sqlview_s_salma = mysqli_query($GLOBALS['dbinv'],"select class from view_s_salma where REF_NO='".trim($rowsttr["ST_INVONO"])."'") or die(mysqli_error());
			if($rowview_s_salma = mysqli_fetch_array($sqlview_s_salma)){
				
				if (trim($rowview_s_salma["class"]) == $InvClass){
                    $OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
                }
			}
		}
	}


        
        $pend_ret_set = 0;
		
		$sqlinvcheq = mysqli_query($GLOBALS['dbinv'],"SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'".$_GET["invdate"]."' AND cus_code='".trim($cuscode)."' and trn_type='RET'") or die(mysqli_error());
		if($rowinvcheq = mysqli_fetch_array($sqlinvcheq)){
			if (is_null($rowinvcheq["che_amount"])==false){
				$pend_ret_set=$rowinvcheq["che_amount"];
			}
		}
		
		
		$sqlcheq = mysqli_query($GLOBALS['dbinv'],"Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".trim($salesrep)."'") or die(mysqli_error());
		if($rowcheq = mysqli_fetch_array($sqlcheq)){
			if (is_null($rowcheq["tot"])==false){
				$OutREtAmt=$rowcheq["tot"];
			} else {
				$OutREtAmt=0;
			}
		}
		
            
 $d=date("Y-m-d");
		
			$date = date('Y-m-d',strtotime($d.' -60 days'));
		
		$sql_rssal = mysqli_query($GLOBALS['dbinv'],"Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE = '" . trim($cuscode) . "' and (SDATE < '" . $date . "') and GRAND_TOT - TOTPAY > 1 and CANCELL = '0'") or die(mysqli_error());
		
    	if ($row_rssal = mysqli_fetch_array($sql_rssal)){

			if (is_null($row_rssal["out1"])==false) { 
				$rtxover60 = number_format($row_rssal["out1"], 2, ".", ",");
			}
		}

						 
   $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutREtAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutpDAMT, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Over 60 Outstandings\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".$rtxover60."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";
						 
			
			$ResponseXML .= "<OutInvAmt><![CDATA[".$OutInvAmt."]]></OutInvAmt>";
			$ResponseXML .= "<OutREtAmt><![CDATA[".$OutREtAmt."]]></OutREtAmt>";
			$ResponseXML .= "<OutpDAMT><![CDATA[".$OutpDAMT."]]></OutpDAMT>";
			 
				//echo "select * from br_trn where Rep='".trim($salesrep)."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'";			      

      $sqlbr_trn = mysqli_query($GLOBALS['dbinv'],"select * from br_trn where Rep='".trim($salesrep)."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'") or die(mysqli_error());  
	if($rowbr_trn = mysqli_fetch_array($sqlbr_trn)){
	
		if(is_null($rowbr_trn["credit_lim"]) == false){
			$crLmt=$rowbr_trn["credit_lim"];
		} else {	
			$crLmt=0;		
		}
	
		
		if(is_null($rowbr_trn["tmpLmt"]) == false){
			$tmpLmt=$rowbr_trn["tmpLmt"];
		} else {	
			$tmpLmt=0;		
		}
		
		if(is_null($rowbr_trn["tmpLmt"]) == false){
        	if ($rowbr_trn["Day"] == date("Y-m-d")) {
            	$tmpLmt=$rowbr_trn["tmpLmt"];
            } else {
                
				$sql_invcls = mysqli_query($GLOBALS['dbinv'],"select * from brand_mas where barnd_name='" . trim($_GET["brand"]) . "'") or die(mysqli_error());     			if($row_invcls  = mysqli_fetch_array($sql_invcls)){
					$sql_upbr = mysqli_query($GLOBALS['dbinv'],"update br_trn set tmpLmt= '0'   where cus_code='" . trim($cuscode) . "' and brand='" .trim($row_invcls["class"])."' and Rep='".trim($salesrep)."'") or die(mysqli_error());                    
                }   
                $tmpLmt = 0;
                    
            }
        } else {
		    $tmpLmt = 0;
		}	
        
		//echo "cat ".$rowbr_trn["CAT"];
		if (is_null($rowbr_trn["CAT"])==false) {
			$cuscat = trim($rowbr_trn["CAT"]);
            if ($cuscat == "A"){ $m = 2.5; }
            if ($cuscat == "B"){ $m = 2.5; }
            if ($cuscat == "C"){ $m = 1; }
			if ($cuscat == "D"){ $m = 0; }
			
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
		/*  echo "crLmt:".$crLmt;
		  echo "m:".$m;
		  echo "tmpLmt:".$tmpLmt;
		  echo "OutInvAmt:".$OutInvAmt;
		  echo "OutREtAmt:".$OutREtAmt;
		  echo "OutpDAMT:".$OutpDAMT;
		  echo "pend_ret_set:".$pend_ret_set;*/
		  
		  $txt_crebal = $crLmt * $m  - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
         $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;

	   			
			
			 
    }    
			$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
			$ResponseXML .= "<txt_crebal><![CDATA[".number_format($txt_crebal, "2", ".", ",")."]]></txt_crebal>";
          
         	 $ResponseXML .= "<creditbalance><![CDATA[".number_format($txt_crebal, "2", ".", ",")."]]></creditbalance>";
			 $ResponseXML .= "<crebal><![CDATA[".number_format($crebal, "2", ".", ",")."]]></crebal>";

		

		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML;
				
				
	
	
	}

	
	if($_GET["Command"]=="to_wd")
		{
			$sqlt="update s_cusordmas set Forward='WD', Result='P' where REF_NO ='".$_GET['salesord1']."'";
			$resultt =mysqli_query($GLOBALS['dbinv'],$sqlt) ; 
		}
			
	if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_ad_data where id='".$_GET['code']."' and tmp_no='".$_SESSION["tmp_no_ad"]."'";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
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
							
			$i=1;
			$sql="Select * from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
				
				$id="id".$i;
				$code="code".$i;
				$itemd="itemd".$i;
				$rate="rate".$i;
				$actual_selling="actual_selling".$i;
				$qty="qty".$i;			
				$discountper="discountper".$i;			
				$subtotal="subtotal".$i;	
				$discount="discount".$i;	
				$ad="ad".$i;	
						
             	$ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$id."'>".$row['id']."</div></td>
							 <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$code."'>".$row['str_code']."</div></td>
							 <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$itemd."'>".$row['str_description']."</div></td>
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><input type=\"text\"  class=\"text_purchase3\" name=\"".$rate."\" id=\"".$rate."\" size=\"15\"  value=\"".number_format($row['cur_rate'], 2, ".", ",")."\"  onblur=\"calc1_table('".$i."');\"  onkeypress=\"keyset('credper',event);\" /></td>
							  <td align=right ><input type=\"text\"  class=\"text_purchase3\" name=\"".$actual_selling."\" id=\"".$actual_selling."\" size=\"15\"  value=\"".number_format($row['actual_selling'], 2, ".", ",")."\"  onblur=\"calc1_table('".$i."');\"   /></td>
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><input type=\"text\"  class=\"text_purchase3\" name=\"".$qty."\" id=\"".$qty."\" size=\"15\"  value=\"".number_format($row['cur_qty'], 0, ".", ",")."\"  onblur=\"calc1_table('".$i."');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$discountper."'>".$row["dis_per"]."</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"".$discount."\" id=\"".$discount."\" size=\"15\"  value=\"".number_format($row['cur_rate'], 2, ".", ",")."\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$subtotal."'>".number_format($row['cur_subtot'], 2, ".", ",")."</div></td>
							
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['id']."');\"></td>";
							 
							// include_once("connectioni.php");
							$sqlqty="select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'";
							$resultqty =mysqli_query($GLOBALS['dbinv'],$sqlqty);	
					
							// $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
					if($rowqty = mysqli_fetch_array($resultqty)){
						$qty=number_format($rowqty['QTYINHAND'], 0, ".", ",");
					} else {
						$qty=0;
					}	
					
					/*if ($row['ad']=="1"){
						$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."' checked></td>";
					} else {
						$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>";
					}*/
							
						
							$ResponseXML .= "<td  >".$qty."</td>
						
							
							 
                            </tr>";
					$i=$i+1;		
				}						
				
				$ResponseXML .= "   </table>]]></sales_table>";
				 
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ad_data where str_invno='".$_GET['invno']."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$sql_invpara="SELECT * from invpara";
				$result_invpara =mysqli_query($GLOBALS['dbinv'],$sql_invpara);
				$row_invpara = mysqli_fetch_array($result_invpara);
				
				$vatrate=$row_invpara["vatrate"]/100;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$strvatrate="Tax (VAT ".$row_invpara["vatrate"]."%)";
					$ResponseXML .= "<taxname><![CDATA[".$strvatrate."]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$strvatrate="Tax (SVAT ".$row_invpara["vatrate"]."%)";
					$ResponseXML .= "<taxname><![CDATA[".$strvatrate."]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$strvatrate="Tax (EVAT ".$row_invpara["vatrate"]."%)";
					$ResponseXML .= "<taxname><![CDATA[".$strvatrate."]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="non"){
					//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
					$ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";
					
					$invtot=number_format($row['tot_sub'], 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
				}
							
                $ResponseXML .= " </salesdetails>";
				
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

if($_GET["Command"]=="save_item_ord")
		{
			
		
		//	$_SESSION["CURRENT_DOC"] = 1;      //document ID
			//$_SESSION["VIEW_DOC"] = false ;     //view current document
		//	$_SESSION["FEED_DOC"] = true;       //save  current document
		//	$_GET["MOD_DOC"] = false  ;         //delete   current document
		//	$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
		//	$_GET["PRICE_EDIT"] = false ;       //edit selling price
		//	$_GET["CHECK_USER"] = false ;       //check user permission again

			
		if ($_SESSION["save_sales_ord"]==1){
			
			$_SESSION["salesord1"]=$_GET['salesord1'];
			//$_SESSION["brand"]="";
			
			$sql="Select AD_NO from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["AD_NO"];
			$lenth=strlen($tmpinvno);
			$invno=trim("AD/").$_GET["salesrep"]."/".substr($tmpinvno, $lenth-7);
			$_SESSION["invno"]=$invno;
			
			
			
			$sql="delete from s_cusordmas where REF_NO='".$invno."' ";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			
			// Insert s_salma ============================================================ 
			
			$sql="Select * from vendor where CODE='".$_GET['customercode']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			$row = mysqli_fetch_array($result);
			$cusname=$row["NAME"];	
			
			$totdiscount=str_replace(",", "", $_GET["totdiscount"]);
			$subtot=str_replace(",", "", $_GET["subtot"]);
			$invtot=str_replace(",", "", $_GET["invtot"]);
			$tax=str_replace(",", "", $_GET["tax"]);
			
			if ($_GET["discount_org1"]==''){
				$discount1=0;
			} else{
				$discount1=$_GET["discount_org1"];
			}
			if ($_GET["discount_org2"]==''){
				$discount2=0;
			} else{
				$discount2=$_GET["discount_org2"];
			}
			if ($_GET["discount_org3"]==''){
				$discount3=0;
			} else{
				$discount3=$_GET["discount_org3"];
			}
			
			$invtot=str_replace(",", "", $_GET["invtot"]);
			$balance=str_replace(",", "", $_GET["balance"]);
			$creditlimit=str_replace(",", "", $_GET["creditlimit"]);
			
			/*if ($_GET["balance"] < $_GET["invtot"]) {
        		$ex_lim = $invtot - $balance;
    		} else {
        		$ex_lim = 0;
    		}*/
			
			if ($balance < $invtot) {
        		$ex_lim = $invtot - $balance;
    		} else {
        		$ex_lim = 0;
        		
        		/*$sql_over60= "select SDATE from  s_salma where Accname != 'NON STOCK' and  C_CODE='" . trim($_GET['customercode']) . "' and GRAND_TOT-TOTPAY >1 and CANCELL=0  order by SDATE";
				$result_over60 =mysqli_query($GLOBALS['dbinv'],$sql_over60);
				if($row_over60 = mysqli_fetch_array($result_over60)){
					$diff = abs(strtotime($_GET["invdate"]) - strtotime($row_over60["SDATE"]));
					$mdays = floor($diff / (60*60*24));	
        			if ($mdays > 60) {
                		$ex_lim = 1;
            		}
        		}
        		
        		$sql_ret= "Select *  from s_cheq where CR_CHEVAL-PAID>10 and CR_FLAG='0' and CR_C_CODE='" . trim($_GET['customercode']) . "' ";
				$result_ret =mysqli_query($GLOBALS['dbinv'],$sql_ret);
				if($row_ret = mysqli_fetch_array($result_ret)){
        			$ex_lim = 1;
        		}*/
        		
    		}
			 	
				if ($_GET["vatmethod"]=="non"){
					$vatmethod=0;
				} else if ($_GET["vatmethod"]=="vat"){
					$vatmethod=1;
				} else if ($_GET["vatmethod"]=="svat"){
					$vatmethod=2;
				} else if ($_GET["vatmethod"]=="evat"){
					$vatmethod=3;
				}
				
			$sql="Insert into s_admas(REF_NO, TRN_TYPE, SDATE, C_CODE, BRAND, CUS_NAME, VAT, TYPE, DISCOU, AMOUNT, GRAND_TOT, DIS, DIS1, DIS2,  DEPARTMENT, SAL_EX, VAT_VAL, CANCELL, DEV, REQ_DATE, INVNO, tmp_no, Limit_need, Forward, GST, DUMMY_VAL, DIS_RUP, CASH, TOTPAY, ORD_NO, ORD_DA, SETTLED, TOTPAY1, DES_CAT, REMARK, BTT, Account, Accname, Costcenter, RET_AMO, comm, approveby, Result, Rejectby) values('".$invno."', 'INV', '".$_GET["invdate"]."', '".$_GET["customercode"]."', '".$_GET["brand"]."', '".$cusname."', 	'".$vatmethod."', '".$_GET["paymethod"]."', ".$totdiscount.", ".$subtot.", ".$invtot.", ".$discount1.", ".$discount2.", ".$discount3.",  '".$_GET['department']."', '".$_GET["salesrep"]."', ".$tax.", '0', '".$_SESSION['dev']."', '".$_GET["invdate"]."', '0', '".$_SESSION["tmp_no_ad"]."', ".$ex_lim.", 'MM', 0, 0, 0, 0, 0, '', '".$_GET["invdate"]."', '', 0, '', '', 0, '', '', '', 0, 0, 0, 'P', '0')";
			//echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			
			
			
			// Update credit limit ==========================================================
			
	/*		$sqlbrmas="select class from brand_mas where barnd_name='".$_GET["brand"]."'";
			$resultbrmas =mysqli_query($GLOBALS['dbinv'],$sqlbrmas);	
			$rowbrmas = mysqli_fetch_array($resultbrmas);	
			
			$sql="update vendor set CUR_BAL=CUR_BAL+".$_GET["invtot"]." where CODE='".$_GET["customercode"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
				
			$sql="update BR_TRN set credit=credit+".$_GET["invtot"]." where cus_code='".$_GET["customercode"]."' and rep='".$_GET["salesrep"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	*/
			 
				
			// Update Invoice Data  ==========================================================
			$sql_invpara="SELECT * from invpara";
			$result_invpara =mysqli_query($GLOBALS['dbinv'],$sql_invpara);
			$row_invpara = mysqli_fetch_array($result_invpara);
			
			$sql="delete from s_adtrn where REF_NO='".$invno."'" ;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sqltmp="select * from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."' order by id";
			//echo $sqltmp;
			$resulttmp =mysqli_query($GLOBALS['dbinv'],$sqltmp);	
			while($rowtmp = mysqli_fetch_array($resulttmp)){	
				$sqlcost="select * from s_mas where STK_NO='".$rowtmp["str_code"]."' and BRAND_NAME='".$_GET["brand"]."'";
				//echo $sqlcost;
				$resultcost =mysqli_query($GLOBALS['dbinv'],$sqlcost);	
				$rowcost = mysqli_fetch_array($resultcost);	
				
				//$dis_per = Val(Format(MSFlexGrid1.TextMatrix(i, 2), General)) * Val(Format(MSFlexGrid1.TextMatrix(i, 3), General)) * Val(Format(MSFlexGrid1.TextMatrix(i, 4), General)) * 0.01;
			
			
			// Update s_inv, s_trn ==========================================================
				
			//	$sql="insert into s_cusordtrn (REF_NO, SDATE, STK_NO, DESCRIPT, UNIT, COST, PRICE, QTY, DEPARTMENT, DIS_PER, DIS_RS, REP, TAX_PER, BRAND, CANCELL, subtot, tmp_no) values ('".$invno."', '".$_GET["invdate"]."', '".$rowtmp["str_code"]."', '".$rowtmp["str_description"]."', 'ORD', ".$rowcost["COST"].", ".$rowtmp["cur_rate"].", ".$rowtmp["cur_qty"].", '".$_GET["department"]."', '".$rowtmp["dis_per"]."', '".$rowtmp["cur_discount"]."', '".$_GET["salesrep"]."', '12', '".$rowcost["BRAND_NAME"]."', '0', ".$rowtmp["cur_subtot"].", '".$_SESSION["tmp_no_ad"]."')" ;
				
				$sql="insert into s_adtrn (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, COST, PRICE, QTY, DEPARTMENT, DIS_per, DIS_rs, REP, TAX_PER, BRAND, CANCELL, tmp_no, UNIT, ret_qty, DEV, c_code, stk, inv_qty) values('" . trim($invno) . "','" . $_GET["invdate"] . "', '" . trim($rowtmp["str_code"]) . "','" . trim($rowtmp["str_description"]) . "', '" . trim($rowtmp["part_no"]) . "'," . $rowcost["COST"] . "," . $rowtmp["cur_rate"] . "," . $rowtmp["cur_qty"] . ",'" . trim($_GET["department"]) . "'," . $rowtmp["dis_per"] . "," . $rowtmp["cur_discount"] . ",'" . trim($_GET["salesrep"]) . "', '".$row_invpara["vatrate"]."','" . trim($rowcost["BRAND_NAME"]) . "', '0',  '".$_SESSION["tmp_no_ad"]."', 'AD', 0, '', '', 0," . $rowtmp["cur_qty"] . ")";
				//echo $sql;
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
				//echo $sql;
			//	$sql="Insert into s_trn	(STK_NO, SDATE, REFNO, QTY, DEPARTMENT) values 
			//	 ('".$rowtmp["str_code"]."',  '".$_GET["invdate"]."', '".$invno."', ".$rowtmp["cur_qty"].", '".$_GET["department"]."')";
			//	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				//echo $sql;
				
		
       		//====update stock==========================================================
			
			/*	$sql="update s_mas set QTYINHAND= QTYINHAND-".$rowtmp["cur_qty"]." where STK_NO='".$rowtmp["str_code"]."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				
				//$M_STOCODE = Trim(substr($_GET["department"], 1, 5))
				
        		$sql="update s_submas set QTYINHAND=QTYINHAND- ".$rowtmp["cur_qty"]." where stk_no= '".$rowtmp["str_code"]."'  and sto_code= '". $_GET["department"]."' ";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; */
				
				/*$sqls_trn="Insert into s_trn (STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, Dev, seri_no, SAL_EX, ACTIVE, DONO) values('".trim($rowtmp["str_code"])."','".$_GET["invdate"]."','".trim($invno)."', ".$rowtmp["cur_qty"].", 'AD', '".trim($_GET["department"])."', '".$_SESSION['dev']."', '', '', '1', '')";
				$results_trn=mysqli_query($GLOBALS['dbinv'],$sqls_trn);
				if ($results_trn==false){ $sql_status="S_TRN - ".$rowtmp["str_code"]." not saved !!!"; }
				
				$sqls_trn="Insert into s_trn_all (STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, Dev, seri_no, SAL_EX, ACTIVE, DONO, cuscode, cusname, brand) values('".trim($rowtmp["str_code"])."','".$_GET["invdate"]."','".trim($invno)."', ".(-1*$rowtmp["cur_qty"]).", 'AD', '".trim($_GET["department"])."', '".$_SESSION['dev']."', '', '".trim($_GET["salesrep"])."', '1', '', '".trim($_GET["customercode"])."', '".trim($customername)."', '".$_GET["brand"]."')";
				//echo $sqls_trn;
				$results_trn=mysqli_query($GLOBALS['dbinv'],$sqls_trn);
				if ($results_trn==false){ $sql_status="S_TRN_ALL - ".$rowtmp["str_code"]." not saved !!!"; }
						
				$sqls_mas="update s_mas set QTYINHAND= QTYINHAND-".$rowtmp["cur_qty"]." where STK_NO='".trim($rowtmp["str_code"])."'";
				$results_mas=mysqli_query($GLOBALS['dbinv'],$sqls_mas);
				if ($results_mas==false){ $sql_status="S_MAS - ".$rowtmp["str_code"]." not updated !!!"; }*/
		
		// Call upsales(dtdate, Val(MSFlexGrid1.TextMatrix(i, 3)), Trim(MSFlexGrid1.TextMatrix(i, 0)))
        //m_STK_NO = Trim(MSFlexGrid1.TextMatrix(i, 0))
        //M_STOCODE = Trim(Mid(Me.com_dep, 1, 5))
    			
				$sqls_submas1="select * from s_submas_ad where STK_NO= '".trim($rowtmp["str_code"])."' and STO_CODE= '".trim($_GET["department"])."'";
				$results_submas1 =mysqli_query($GLOBALS['dbinv'],$sqls_submas1);	
				if($row_submas1 = mysqli_fetch_array($results_submas1)){
				
					$sqls_submas="update s_submas_ad set QTYINHAND=QTYINHAND- ".$rowtmp["cur_qty"]." where STK_NO= '".trim($rowtmp["str_code"])."' and STO_CODE= '".trim($_GET["department"])."'";
				//echo $sqls_submas;
					$results_submas =mysqli_query($GLOBALS['dbinv'],$sqls_submas);	
					if ($results_submas==false){ $sql_status="S_SUBMAS_ad - ".$rowtmp["str_code"]." not updated !!!"; }
				} else {
					$sqls_submas="insert into s_submas_ad (STO_CODE, STK_NO, QTYINHAND) values ('".trim($_GET["department"])."', '".trim($rowtmp["str_code"])."', ".$rowtmp["cur_qty"].")";
				//echo $sqls_submas;
					$results_submas =mysqli_query($GLOBALS['dbinv'],$sqls_submas);	
					if ($results_submas==false){ $sql_status="S_SUBMAS_ad - ".$rowtmp["str_code"]." not updated !!!"; }
				}	
				
			}
        
     			 $sql="delete  from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."' ";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
  
   			//====creditor file ================================================
			
   
			$sql="Insert into s_led(REF_NO, SDATE, C_CODE, amount, flag, department) values ('".$invno."', '".$_GET["invdate"]."', '".$_GET["customercode"]."', ".$invtot.", 'AD', '".$_GET["department"]."')";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				
			$sql="update invpara set AD_NO=AD_NO+1";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
  
			$_SESSION["print"]=1;
			$_SESSION["save_sales_ord"]=0;
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			$ResponseXML .= "<Saved><![CDATA[Saved]]></Saved>";
			$ResponseXML .= "<invno><![CDATA[".$invno."]]></invno>";
			$ResponseXML .= "<company><![CDATA[".$_SESSION['company']."]]></company>";
			$ResponseXML .= "</salesdetails>";
			
		} else {
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			$ResponseXML .= "<Saved><![CDATA[Can't Save]]></Saved>";
			$ResponseXML .= "<invno><![CDATA[".$invno."]]></invno>";
			$ResponseXML .= "<company><![CDATA[".$_SESSION['company']."]]></company>";
			$ResponseXML .= "</salesdetails>";
		}	
		
		echo $ResponseXML;	
	}
	
if($_GET["Command"]=="save_item")
{

	//include_once("connectioni.php");
			
		//	$_SESSION["CURRENT_DOC"] = 1;      //document ID
		//	$_SESSION["VIEW_DOC"] = false ;     //view current document
		//	$_SESSION["FEED_DOC"] = true;       //save  current document
		//	$_GET["MOD_DOC"] = false  ;         //delete   current document
		//	$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
		//	$_GET["PRICE_EDIT"] = false ;       //edit selling price
		//	$_GET["CHECK_USER"] = false ;       //check user permission again


	if ($_SESSION["save_sales_inv"]==1){
		//$_SESSION["brand"]="";
	
		$insuf_qty="";
		$sqltmp1="select * from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."'";
		$resulttmp1 =mysqli_query($GLOBALS['dbinv'],$sqltmp1);
		while($rowtmp1 = mysqli_fetch_array($resulttmp1)){
			$sqlqty1="select QTYINHAND from s_submas where STK_NO='".$rowtmp1['str_code']."' AND STO_CODE='".$_GET["department"]."'";
			$resultqty1 =mysqli_query($GLOBALS['dbinv'],$sqlqty1);
	//	 $sqlqty1 = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$rowtmp1['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
			 if($rowqty1 = mysqli_fetch_array($resultqty1)){
			 	if ($rowqty1["QTYINHAND"]<$rowtmp1["cur_qty"]){
					$insuf_qty=$rowtmp1['str_code'];
				}
			 }
		}	
		
		
		if ($insuf_qty==""){
		
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
	
						
			
			
		if ($_SESSION['company']=="THT"){	
			
			//echo $_SESSION["tmp_no_ad"];
			
			
			$sql="Select SPINV, CRE_INV_NO, CAS_INV_NO from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			if ($_SESSION['dev']=="1"){
				 				
				$tmpinvno="000000".($row["SPINV"]+1);
				$lenth=strlen($tmpinvno);
			
				$invno=trim("CRI/ ").substr($tmpinvno, $lenth-6)."/5";
				$_SESSION["invno"]=$invno;
				$txtdono=$row["CAS_INV_NO"]+1;
			} else {
				
				$tmpinvno="000000".($row["SPINV"]+1);
				$lenth=strlen($tmpinvno);
			
				$invno=trim("CRI/ ").substr($tmpinvno, $lenth-6)."/".$_GET["salesrep"];
				$_SESSION["invno"]=$invno;
				$txtdono=$row["CRE_INV_NO"]+1;
			
			}
			
		} else 	 if ($_SESSION['company']=="BEN") {
			
			
			$sql="Select SPINV, SPINV1, CAS_INV_NO_m, CAS_INV_NO from invpara";
			//echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			
			if ($_SESSION['dev']=="1"){
				$tmpinvno="000000".($row["SPINV1"]+1);
				$lenth=strlen($tmpinvno);
			
				$invno=trim("BEN/CR/ ").substr($tmpinvno, $lenth-6)."/2";
				$_SESSION["invno"]=$invno;
				$txtdono=$row["CAS_INV_NO_m"]+1;
   	
			} else {
				$tmpinvno="000000".($row["SPINV"]+1);
				$lenth=strlen($tmpinvno);
			
				$invno=trim("BEN/CR/ ").substr($tmpinvno, $lenth-6)."/".$_GET["salesrep"];
				$_SESSION["invno"]=$invno;
				$txtdono=$row["CAS_INV_NO"]+1;
  
			}
		}
			
			$sql="delete from s_salma where REF_NO='".$invno."' ";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			
			$cre_balance=str_replace(",", "", $_GET["balance"]);
			$totdiscount=str_replace(",", "", $_GET["totdiscount"]);
			$subtot=str_replace(",", "", $_GET["subtot"]);
			$invtot=str_replace(",", "", $_GET["invtot"]);
		    $tax=str_replace(",", "", $_GET["tax"]);
			
			// Insert s_salma ============================================================ 
			
			$sql="select * from vendor where CODE = '".trim($_GET["customercode"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			if($row = mysqli_fetch_array($result)){
				if ($row["blacklist"]=="1"){
					$sqlapp="select * from s_cusordmas where ref_no='".trim($_GET["salesord1"])."'";
					$resultapp =mysqli_query($GLOBALS['dbinv'],$sqlapp);
					if($rowapp = mysqli_fetch_array($resultapp)){
						if ($rowapp["approveby"]=="0") {
							exit("Invoice Facilitey Stoped for This Customer,Please Invoice For Approved Sales Order");
						} else {
							exit("Invoice Facilitey Stoped for This Customer,Please Invoice For Approved Sales Order");	
						}	
						$_SESSION["print"]=0;
					}
				}	
			}
			


///////////////////////////   Call checkcreditlimit

			if (trim($_GET["customercode"]) != "") {
				if (cuscat=="A"){
					if ($invtot>$cre_balance){
						$ResponseXML .= "<msg_crelimi><![CDATA[Credit Limit Exceed1]]></msg_crelimi>";
					}
				}
				
				if (cuscat=="B"){
					if ($invtot>$cre_balance){
						$ResponseXML .= "<msg_crelimi><![CDATA[Credit Limit Exceed2]]></msg_crelimi>";
					}
				}
				
				if (cuscat=="C"){
					if ($invtot>$cre_balance){
						$ResponseXML .= "<msg_crelimi><![CDATA[Credit Limit Exceed3]]></msg_crelimi>";
					}
				}
				
				if (cuscat=="D"){
					$ResponseXML .= "<msg_crelimi><![CDATA[Customer Deleted]]></msg_crelimi>";
				}
				
				if ((cuscat!="D") and (cuscat!="A") and (cuscat!="B") and (cuscat!="C")){
					$ResponseXML .= "<msg_crelimi><![CDATA[Customer Catogory Not Entered]]></msg_crelimi>";
				}
			} else {
				$ResponseXML .= "<msg_crelimi><![CDATA[no]]></msg_crelimi>";
			}
			
	
//====================================== End Checking credit limit


			
/*
Dim rst As New ADODB.Recordset
rst.Open "SELECT REF_NO FROM S_SALMA WHERE REF_NO='" & Trim(txt_invno) & "'", dnINV.Coninv

If SAVEOK = False Then
m_ok = ""
If txt_cuscode = "" Then m_ok = "Customer Not Selected"
If Me.txt_stat <> "NEW" Then m_ok = "Invalid Option"
If Me.txt_ordno = "" Then m_ok = "Enter Order No"
If cmbbrand = "" Then m_ok = "Select Brand name"
If Not rst.EOF Then m_ok = "Invoice No Already exists"
rst.Close
Set rst = Nothing
If m_ok <> "" Then
   MsgBox m_ok
Else
dnINV.Coninv.BeginTrans
dnINV.Coninv.Execute "update vendor set Over_DUE_IG_Date='" & Date - 1 & "'  where code='" & Trim(txt_cuscode) & "' " */


//==============================================================



			$sql="select * from s_salma_order where REF_NO= '".trim($_GET["salesord1"])."'";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			if($row = mysqli_fetch_array($result)){
				$sqlord="UPDATE s_salma_order SET CANCELL='1' WHERE (((REF_NO)='".trim($_GET["salesord1"])."'))";
				$resultord =mysqli_query($GLOBALS['dbinv'],$sqlord);
				
				$sqltmp="select * from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."'";
				$resulttmp =mysqli_query($GLOBALS['dbinv'],$sqltmp);
				while($rowtmp = mysqli_fetch_array($resulttmp)){
					$sqlinord="update s_mas set QTYINHAND= QTYINHAND+".$_GET["cur_qty"]." where STK_NO='".$rowtmp["str_code"]."'";
					$resultinord =mysqli_query($GLOBALS['dbinv'],$sqlinord);
					
					$sqlinord="update s_submas set QTYINHAND= QTYINHAND+".$_GET["cur_qty"]." where sto_code= '".$_GET["department"]."' and stk_no= '".$rowtmp["str_code"]."'";
					$resultinord =mysqli_query($GLOBALS['dbinv'],$sqlinord);
				
				
				}
				
				$sqlinord="delete  from s_led where REF_NO='".trim($_GET["salesord1"]) & "'";
				$resultinord =mysqli_query($GLOBALS['dbinv'],$sqlinord);
			}

			//============
			$vat="";
			if (($_GET["vatmethod"]=="vat") or ($_GET["vatmethod"]=="svat") or ($_GET["vatmethod"]=="evat")){
				$vat="1";
			} else {
				$vat="0";	
			}

		
	
//    totpay = Val(Format(txt_chetot, General)) + Val(Format(txt_cash, General))
    		$svat = 0;
			if ($_GET["vatmethod"]=="svat"){
				$svat=str_replace(",", "", $_GET["tax"]);
			}
			
			
    
 /*   REFNO = Trim(txt_invno)
    xx = getauth(CURRENT_DOC, VIEW_DOC, FEED_DOC, MOD_DOC, PRINT_DOC, PRICE_EDIT, CHECK_USER, REFNO)
    If Not AUTH_OK Then Exit Sub*/
    
	
	//================discount
  
	
			$d1=str_replace(",", "", $_GET["discount_org1"]);
			$d2=str_replace(",", "", $_GET["discount_org2"]);
			$d3=str_replace(",", "", $_GET["discount_org3"]);
	
			if ($d1==""){$d1=0;}
			if ($d2==""){$d2=0;}
			if ($d3==""){$d3=0;}
	
	
			$d = 100 - (100 - $d3) * (100 - $d2) * (100 - $d1)/ 100;
    //===============================================
	
			$cre_balance=str_replace(",", "", $_GET["balance"]);
			$totdiscount=str_replace(",", "", $_GET["totdiscount"]);
			$subtot=str_replace(",", "", $_GET["subtot"]);
			$invtot=str_replace(",", "", $_GET["invtot"]);
		    $tax=str_replace(",", "", $_GET["tax"]);
			
			$sql_invpara="SELECT * from invpara";
			$result_invpara =mysqli_query($GLOBALS['dbinv'],$sql_invpara);
			$row_invpara = mysqli_fetch_array($result_invpara);
				
			$mvatrate=$row_invpara["vatrate"];
	//if ($_GET["brand"]=="TRANSKING" and $d > 35){
		//	$sqlcus="select * from vendor where CODE='".trim($_GET["customercode"])."'";
		//	$resultcus =mysqli_query($GLOBALS['dbinv'],$sqlcus);
		//	$rowcus = mysqli_fetch_array($resultcus);
		
		
		$customername =str_replace("~", "&", $_GET["customername"]);  
		$cus_address =str_replace("~", "&", $_GET["cus_address"]);
		
			$sqlisalma="Insert into s_salma  (REF_NO, TRN_TYPE, SDATE, C_CODE, Brand, CUS_NAME, VAT, VAT_VAL, TYPE, DISCOU, AMOUNT, GRAND_TOT,  TOTPAY, ORD_NO, ORD_DA,  DEPARTMENT, SAL_EX, BTT, cre_pe, GST, DIS, DIS1, DIS2, SVAT, Account, TOTPAY1, REMARK, REQ_DATE, CANCELL, DEV, tmp_no, DIS_RUP, CASH, SETTLED, DES_CAT, Accname, Costcenter, RET_AMO, Comm, red, seri_no, points, LOCK1, deliin, vat_no, s_vat_no, C_ADD1) values('".$invno."', 'INV', '".$_GET["invdate"]."', '".trim($_GET["customercode"])."', '".trim($_GET["brand"])."', '".trim($customername)."','".$vat."', ".$tax.", '".$_GET["paymethod"]."',".$totdiscount.", ".$subtot." , ".$invtot.", 0, '".trim($_GET["salesord1"])."', '".$_GET["deldate"]."', '".trim($_GET["department"])."', '".trim($_GET["salesrep"])."', ".$tax.", ".$_GET["credper"]." , ".$mvatrate.", ".$d1.", ".$d2.", ".$d3.", '".$svat."', 'NOTAUTH', '0',  '".$invno."', '".$_GET["deldate"]."', '0', '".$_SESSION['dev']."', '".$_SESSION["tmp_no_ad"]."', 0, 0, '0', 'N', 'OFFICE', '', 0, 'N', '0', '', '0', '0', '', '".trim($_GET["vat1"])."', '".trim($_GET["vat2"])."', '".$cus_address."')";
		//echo $sqlisalma;
			$resultsalma =mysqli_query($GLOBALS['dbinv'],$sqlisalma);
	 		
			if ($_SESSION['dev']=="1"){
       			$sqlisalma="Update invpara  set SPINV1=SPINV1+1";
	   			$resultsalma =mysqli_query($GLOBALS['dbinv'],$sqlisalma);
			}
			
			if ($_SESSION['dev']=="0"){
       			$sqlisalma="Update invpara  set SPINV=SPINV+1";
	   			$resultsalma =mysqli_query($GLOBALS['dbinv'],$sqlisalma);
			}	
	   
	   //==============Update credit limit==========================================
    
			$sqlisalma="update vendor set CUR_BAL= CUR_BAL+".$invtot." where CODE='".trim($_GET["customercode"])."'";
   		 	$resultsalma =mysqli_query($GLOBALS['dbinv'],$sqlisalma);
	
			$sqlisalma="update br_trn set credit= credit+".$invtot." where cus_code='".trim($_GET["customercode"])."'";
    		$resultsalma =mysqli_query($GLOBALS['dbinv'],$sqlisalma);
   

    		$sqltmp="select * from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."'";
			//echo $sqltmp;
			$resulttmp =mysqli_query($GLOBALS['dbinv'],$sqltmp);
			while($rowtmp = mysqli_fetch_array($resulttmp)){
				$dis_per = $sqltmp["cur_rate"]*$sqltmp["cur_qty"]*$sqltmp["dis_per"]*0.01;
		
				$sqlmas="select * from s_mas where STK_NO='".trim($rowtmp["str_code"])."'";
				$resultmas =mysqli_query($GLOBALS['dbinv'],$sqlmas);
				$rowmas = mysqli_fetch_array($resultmas);
	
				$sql_invo="Insert into s_invo  (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, COST, PRICE, QTY, DEPARTMENT, DIS_per, DIS_rs, REP, TAX_PER, BRAND, vatrate, Print_dis1, Print_dis2, Print_dis3, subtot, ret_qty, DEV, CANCELL, c_code, seri_no, ad) values ('".$invno."', '".$_GET["invdate"]."', '".trim($rowtmp["str_code"])."', '".trim($rowtmp["str_description"])."', '".$rowmas["PART_NO"]."', ".$rowmas["COST"].", ".$rowtmp["cur_rate"].", ".$rowtmp["cur_qty"].", '".$department."', '".$rowtmp["dis_per"]."', ".$dis_per.", '".$_GET["salesrep"]."', '".$row_invpara["vatrate"]."', '".$_GET["brand"]."', ".$mvatrate.", ".$d1.", ".$d2.", ".$d3.", ".$rowtmp["cur_subtot"].", '0', '', '0', '', '', '".$rowtmp["ad"]."')";
		//echo $sql_invo;
				$result_invo =mysqli_query($GLOBALS['dbinv'],$sql_invo);
		
				$sqls_trn="Insert into s_trn (STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, Dev, seri_no, SAL_EX, ACTIVE, DONO) values('".trim($rowtmp["str_code"])."','".$_GET["invdate"]."','".trim($_GET["invno"])."', ".$rowtmp["cur_qty"].", 'INV', '".trim($_GET["department"])."', '".$_SESSION['dev']."', '', '', '1', '')";
				$results_trn =mysqli_query($GLOBALS['dbinv'],$sqls_trn);
		
				$sqls_trn="update s_mas set QTYINHAND= QTYINHAND-".$rowtmp["cur_qty"]." where STK_NO='".trim($rowtmp["str_code"])."'";
				$results_trn =mysqli_query($GLOBALS['dbinv'],$sqls_trn);
		
		// Call upsales(dtdate, Val(MSFlexGrid1.TextMatrix(i, 3)), Trim(MSFlexGrid1.TextMatrix(i, 0)))
        //m_STK_NO = Trim(MSFlexGrid1.TextMatrix(i, 0))
        //M_STOCODE = Trim(Mid(Me.com_dep, 1, 5))
    	
				$sqls_submas="update s_submas set QTYINHAND=QTYINHAND- ".$rowtmp["cur_qty"]." where stk_no= '".trim($rowtmp["str_code"])."' and sto_code= '".$_GET["department"]."'";
				$results_submas =mysqli_query($GLOBALS['dbinv'],$sqls_submas);
		
     
  			}
	 
	
			$sqlpara="delete from tmp_ad_data where tmp_no='".$_SESSION["tmp_no_ad"]."'";
			$resultpara =mysqli_query($GLOBALS['dbinv'],$sqlpara);
			 
			$sqls_submas="Insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT) values('".trim($invno)."', '".$_GET["invdate"]."', '".trim($_GET["customercode"])."', ".$invtot.", 'INV', '".$_GET["department"]."')";
			$results_submas =mysqli_query($GLOBALS['dbinv'],$sqls_submas);
		
			if ($_SESSION['dev']=="1"){
				$sqlpara="update invpara set CAS_INV_NO=CAS_INV_NO+1";
				$resultpara =mysqli_query($GLOBALS['dbinv'],$sqlpara);
			} 
		
			if ($_SESSION['dev']=="0"){
				$sqlpara="update invpara set CRE_INV_NO=CRE_INV_NO+1";
				$resultpara =mysqli_query($GLOBALS['dbinv'],$sqlpara);
			}
		
			$sqlpara="update vendor set temp_limit= '0'  where CODE='".trim($_GET["customercode"])."'";
			$resultpara =mysqli_query($GLOBALS['dbinv'],$sqlpara);
		
			$sqlbrand="select * from brand_mas where barnd_name='".trim($_GET["brand"])."'";
			$resultbrand =mysqli_query($GLOBALS['dbinv'],$sqlbrand);	
			if($rowbrand = mysqli_fetch_array($resultbrand)){
				$sqlbr_trn="update br_trn set tmplmt= '0'   where cus_code='".trim($_GET["customercode"])."' and brand='".trim($rowbrand["class"])."' and Rep='".trim($_GET["salesrep"])."'";
				$resultbr_trn =mysqli_query($GLOBALS['dbinv'],$sqlbr_trn);	
			}
		

			$sqlbr_trn="update s_cusordmas set INVNO= '".$_GET["invno"]."' where  REF_NO='".$_GET["ordno"]."'";
			$resultbr_trn =mysqli_query($GLOBALS['dbinv'],$sqlbr_trn);	
		
	/////////////////////////////////////////////////////////////////////////
    
  
			$_SESSION["print"]=1;
			$_SESSION["save_sales_inv"]=0;
			
			$ResponseXML .= "<Saved><![CDATA[Saved]]></Saved>";
			$ResponseXML .= "<invno><![CDATA[".$invno."]]></invno>";
			$ResponseXML .= "<company><![CDATA[".$_SESSION['company']."]]></company>";
			
			//echo "Saved";
			
		} else {
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			$ResponseXML .= "<Saved><![CDATA[insuficent]]></Saved>";
			$ResponseXML .= "<msg_crelimi><![CDATA[no]]></msg_crelimi>";
			
			//echo "insuficent";
		}	
	} else {
		$ResponseXML .= "";
		$ResponseXML .= "<salesdetails>";
		$ResponseXML .= "<msg_crelimi><![CDATA[no]]></msg_crelimi>";
		$ResponseXML .= "<Saved><![CDATA[no]]></Saved>";
		
		//echo "no";
	}	
	
	$ResponseXML .= " </salesdetails>";
	echo $ResponseXML;
}
	
if ($_GET["Command"]=="check_print")
{
	
	echo $_SESSION["print"];
}

	
if($_GET["Command"]=="tmp_crelimit")
{	
	echo "abc";
	$crLmt = 0;
	$cat = "";
	
	$rep=trim(substr($_GET["Com_rep1"], 0, 5));
	
	$sql = "select * from br_trn where rep='".$rep."' and cus_code='".trim($_GET["txt_cuscode"])."' and brand='".trim($_GET["cmbbrand1"])."'";
	echo $sql;
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
    if ($row = mysqli_fetch_array($result)) {
		$crLmt = $row["credit_lim"];
   		If (is_null($row["cat"])==false) {
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