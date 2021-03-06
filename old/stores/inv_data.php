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
			$vatrate=0.12;
			
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
	
	
 if ($_GET["Command"]=="save_deli_date"){
 	
	require_once("connectioni.php");
	
	
	
	$sql="update s_salma set deli_date='".$_GET["DTdel_date"]."' where REF_NO = '".trim($_GET["invno"])."'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	echo "Updated";
	
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
			$_SESSION["save_sales_inv"]=1;
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
			
			$_SESSION["brand"]="";
			
		 // if ($_SESSION['company']=="THT"){	
			$sql="Select SPINV from tmpinvpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$_SESSION["tmp_no_salinv"]="CRI/".$row["SPINV"];
			//echo $_SESSION["tmp_no_salinv"];
			$sql="delete from tmp_inv_data_stores where tmp_no='".$_SESSION["tmp_no_salinv"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="update tmpinvpara set SPINV=SPINV+1";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			
			
			
			
			/*$sql="Select SPINV, CRE_INV_NO, CAS_INV_NO from invpara";
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
			$sql="Select SPINV from tmpinvpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$_SESSION["tmp_no_salinv"]="CRI/".$row["SPINV"];
			//echo $_SESSION["tmp_no_salinv"];
			$sql="delete from tmp_inv_data_stores where tmp_no='".$_SESSION["tmp_no_salinv"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="update tmpinvpara set SPINV=SPINV+1";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			
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
		}*/
			header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			$invno="";
			$txtdono="";
			
			$ResponseXML .= "<invno><![CDATA[".$invno."]]></invno>";
			$ResponseXML .= "<txtdono><![CDATA[".$txtdono."]]></txtdono>";
			
			$ResponseXML .= "</salesdetails>";
			echo $ResponseXML;	
		
		}
	
	
	if($_GET["Command"]=="cancel_inv")
	{
		$sql="select last_update from invpara";
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		$row = mysqli_fetch_array($result);
		
		$sqlinv="select * from s_salma where REF_NO='".$_GET["invno"]."' ";
		//echo $sqlinv;
		$resultinv =mysqli_query($GLOBALS['dbinv'],$sqlinv);
		if ($rowinv = mysqli_fetch_array($resultinv)){
			//if (($rowinv["TOTPAY"]==0) and ($rowinv["SDATE"]>$row["last_update"])){
				//$sql2="update s_salma set CANCELL='1' where REF_NO='".$_GET["invno"]."'";
				//$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
				
				$sqlisalma="Update s_salma set veheno='', driver='', loaddate='' where REF_NO='".$_GET["invno"]."'";
				$resultsalma =mysqli_query($GLOBALS['dbinv'],$sqlisalma);
			
				
				
				$sqltmp="select * from tmp_inv_data_stores where tmp_no='".$_SESSION["tmp_no_salinv"]."' and str_invno='".$_GET["invno"]."'";
				$resulttmp =mysqli_query($GLOBALS['dbinv'],$sqltmp);
				while ($rowtmp = mysqli_fetch_array($resulttmp)){
					
					
					$sql2="update s_mas set QTYINHAND_STORES=QTYINHAND_STORES+".$rowtmp["cur_qty"]." where STK_NO='".$rowtmp['str_code']."'";
					$resul2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
					//echo $sql2;
					
					$sql2="update s_submas_stores set QTYINHAND=QTYINHAND+".$rowtmp["cur_qty"]." where STO_CODE='".$_GET['department']."' and STK_NO='".$rowtmp['str_code']."'";
					$resul2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
					//echo $sql2;
					
					$sql2="delete from s_trn_stores where REFNO='".$_GET['invno']."'";
					$resul2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
					//echo $sql2;
					
				}
				echo "Canceled";
			
		}
	}
	
	
	if($_GET["Command"]=="chk_ad")
		{
			if ($_GET["chk"]=="false"){
				$chk=0;
			} else {
				$chk=1;
			}
			$sql="update tmp_inv_data_stores set ad='".$chk."' where id=".$_GET["id"]." and str_code='".$_GET['itemcode']."' and tmp_no= '".$_SESSION["tmp_no_salinv"]."'";
			echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
		}
		
		
	if($_GET["Command"]=="add_tmp")
		{
		
			//$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
		
			
			$sql = "Insert into tmp_inv_serino(refno ,stk_no , serino) values('" . trim($_GET["invno"]) . "', '" . trim($_GET["stk_no"]) . "', '" . trim($_GET["seri_no"]) . "')";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"25%\"><font color=\"#FFFFFF\">Stock No</font></td>
               				 	<td width=\"40%\"><font color=\"#FFFFFF\">Serial No</font></td>
							  </tr>";
							
			$i=1;
			
			//$sql1="Select pirnt_serial from s_salma where REF_NO='".trim($_GET["invno"])."'";
			//$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
			//$row1 = mysqli_fetch_array($result1);
						
				
			$sql="Select * from tmp_inv_serino where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
								
						
             	$ResponseXML .= "<tr>                              
                             <td >".$row['stk_no']."</td>
							 <td >".$row['serino']."</td>";
				
				
				//if ($row1["pirnt_serial"]!="1"){
					$ResponseXML .="<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['serino']."  name=".$row['serino']." onClick=\"del_item('".$row['serino']."');\"></td>";
				//}
							
                   $ResponseXML .= "</tr>";
					$i=$i+1;		
			}			
			
			$sql="Select * from inv_serino where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
								
						
             	$ResponseXML .= "<tr>                              
                             <td >".$row['stk_no']."</td>
							 <td >".$row['serino']."</td>";
				
				
				//if ($row1["pirnt_serial"]!="1"){
				//	$ResponseXML .="<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['serino']."  name=".$row['serino']." onClick=\"del_item('".$row['serino']."');\"></td>";
				//}
							
                   $ResponseXML .= "</tr>";
					$i=$i+1;		
			}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	if($_GET["Command"]=="add_serial")
	{
		
			
			$sql="Select * from tmp_inv_serino where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
								
				$sql1 = "Insert into inv_serino(refno ,stk_no , serino, seri_datetime) values('" . trim($row["refno"]) . "', '" . trim($row["stk_no"]) . "', '" . trim($row["serino"]) . "', '".date("Y-m-d H:i:s")."')";
				$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
					
 			}			
							
          	//$sql1 = "update s_salma set serial_datetime='".date("Y-m-d H:i:s")."' where REF_NO ='".trim($_GET["invno"]). "'";
			//$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	  
			
			$sql="delete from tmp_inv_serino where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"25%\"><font color=\"#FFFFFF\">Stock No</font></td>
               				 	<td width=\"40%\"><font color=\"#FFFFFF\">Serial No</font></td>
							  </tr>";
							
			$i=1;
			
			//$sql1="Select pirnt_serial from s_salma where REF_NO='".trim($_GET["invno"])."'";
			//$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
			//$row1 = mysqli_fetch_array($result1);
						
				
			$sql="Select * from inv_serino where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
								
						
             	$ResponseXML .= "<tr>                              
                             <td >".$row['stk_no']."</td>
							 <td >".$row['serino']."</td>";
				
				
				//if ($row1["pirnt_serial"]!="1"){
				//	$ResponseXML .="<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['serino']."  name=".$row['serino']." onClick=\"del_item('".$row['serino']."');\"></td>";
				//}
							
                   $ResponseXML .= "</tr>";
					$i=$i+1;		
			}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				$ResponseXML .= "<resul><![CDATA[Serial Numbers are Saved]]></resul>";
				
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
			
			
			//$sql="delete from tmp_inv_data_stores where id='".$_GET['id']."' and str_code='".$_GET['itemcode']."' and tmp_no='".$_SESSION["tmp_no_salinv"]."' ";
			
			//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			$rate=str_replace(",", "", $_GET["rate"]);
			$actual_selling=str_replace(",", "", $_GET["actual_selling"]);
			$qty=str_replace(",", "", $_GET["qty"]);
			$discount=str_replace(",", "", $_GET["discount"]);
			$subtotal=str_replace(",", "", $_GET["subtotal"]);
			
			
			//$sql="Insert into tmp_inv_data_stores (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, tmp_no, actual_selling)values 
			//('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.", '".$_GET['brand']."', '".$_SESSION["tmp_no_salinv"]."', ".$actual_selling.") ";
			
			$sql="update tmp_inv_data_stores set cur_rate=".$rate.", cur_qty=".$qty.", dis_per=".$_GET["discountper"].", cur_discount=".$discount.", cur_subtot=".$subtotal.", actual_selling=".$actual_selling." where id='".$_GET['id']."'";
			//('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', , , , , , , '".$_SESSION["tmp_no_salinv"]."', ) ";
			//echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"50\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">ID</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate With VAT</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							  <td></td>
							  <td width=\"50\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">AD</font></td>
							  <td width=\"70\">Qty In Hand</td>
                            </tr>";
							
			$i=1;
			$sql="Select * from tmp_inv_data_stores where tmp_no='".$_SESSION["tmp_no_salinv"]."' order by id";
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
							 
							include_once("connectioni.php");
							
							 $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
					if($rowqty = mysqli_fetch_array($sqlqty)){
						$qty=number_format($rowqty['QTYINHAND'], 0, ".", ",");
					} else {
						$qty=0;
					}	
					
					if ($row['ad']=="1"){
						$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."' checked></td>";
					} else {
						$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>";
					}
							
						
							$ResponseXML .= "<td  >".$qty."</td>
						
							
							 
                            </tr>";
					$i=$i+1;		
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= "<item_count><![CDATA[".$i."]]></item_count>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data_stores where tmp_no='".$_SESSION["tmp_no_salinv"]."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$vatrate=0.12;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";
					
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
			
			
			//$sql="delete from tmp_inv_data_stores where tmp_no='".$_SESSION["tmp_no_salinv"]."' ";
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
			
			//$sql="Insert into tmp_inv_data_stores (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, actual_selling, tmp_no, ad)values 
			//('".$_GET['invno']."', '".$_GET[$code]."', '".$_GET[$itemd]."', ".$rate.", ".$qty.", ".$_GET[$discountper].", ".$discount.", ".$subtotal.", '".$_GET['brand']."', '".$actual_selling."', '".$_SESSION["tmp_no_salinv"]."', '".$ad_val."') ";
			
			$sql="update tmp_inv_data_stores set cur_rate=".$rate.", cur_qty=".$qty.", dis_per=".$_GET[$discountper].", cur_discount=".$discount.", cur_subtot=".$subtotal.", actual_selling='".$actual_selling."', ad='".$ad_val."' where id=".$_GET[$id];
			//echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			 $i=$i+1;
			}
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"50\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">ID</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate With VAT</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							  <td></td>
							  <td width=\"50\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">AD</font></td>
							  <td width=\"70\">Qty In Hand</td>
							  
                            </tr>";
							
			$i=1;
			$sql="Select * from tmp_inv_data_stores where tmp_no='".$_SESSION["tmp_no_salinv"]."' order by id";
			
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
							 
							
						include_once("connectioni.php");
							
							 $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
					if($rowqty = mysqli_fetch_array($sqlqty)){
						$qty=number_format($rowqty['QTYINHAND'], 0, ".", ",");
					} else {
						$qty=0;
					}	
					
					if ($row['ad']=="1"){
						$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."' checked></td>";
					} else {
						$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>";
					}
							
						
							$ResponseXML .= "<td  >".$qty."</td>
							
							 
                            </tr>";
					$i=$i+1;		
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= "<item_count><![CDATA[".$i."]]></item_count>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data_stores where tmp_no='".$_SESSION["tmp_no_salinv"]."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$vatrate=0.12;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";
					
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
		 include_once("connectioni.php");
						
					$sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$_GET["it_code"]."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
					if($rowqty = mysqli_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
			echo $qty;		
	}
	
	if($_GET["Command"]=="setord")
	{
		
		
		 if ($_SESSION['company']=="THT"){	
			$sql="Select SPINV from tmpinvpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			//$_SESSION["tmp_no_salinv"]="CRI/".$row["SPINV"];
			//echo $_SESSION["tmp_no_salinv"];
			//$sql="delete from tmp_inv_data_stores where tmp_no='".$_SESSION["tmp_no_salinv"]."'";
			//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			//$sql="update tmpinvpara set SPINV=SPINV+1";
			//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			
			
			
			
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
			$sql="Select SPINV from tmpinvpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			//$_SESSION["tmp_no_salinv"]="CRI/".$row["SPINV"];
			//echo $_SESSION["tmp_no_salinv"];
			//$sql="delete from tmp_inv_data_stores where tmp_no='".$_SESSION["tmp_no_salinv"]."'";
			//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			//$sql="update tmpinvpara set SPINV=SPINV+1";
			//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			
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
		
		include_once("connectioni.php");
		
		
		/*
		$len=strlen($_GET["salesord1"]);
		$need=substr($_GET["salesord1"],$len-7, $len);
		$salesord1=trim("ORD/ ").$_GET["salesrep"].trim(" / ").$need;
		
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

		
	if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql = "delete from tmp_inv_serino where refno='" . trim($_GET["invno"]) . "' and serino='" . trim($_GET["seri_no"]) . "'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"25%\"><font color=\"#FFFFFF\">Stock No</font></td>
               				 	<td width=\"40%\"><font color=\"#FFFFFF\">Serial No</font></td>
							  </tr>";
							
			$i=1;
			$sql="Select * from tmp_inv_serino where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
								
						
             	$ResponseXML .= "<tr>                              
                             <td >".$row['stk_no']."</td>
							 <td >".$row['serino']."</td>";
				
				
				//if ($row1["pirnt_serial"]!="1"){
					$ResponseXML .="<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['serino']."  name=".$row['serino']." onClick=\"del_item('".$row['serino']."');\"></td>";
				//}
							
                   $ResponseXML .= "</tr>";
					$i=$i+1;		
			}			
			
			$sql="Select * from inv_serino where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
								
						
             	$ResponseXML .= "<tr>                              
                             <td >".$row['stk_no']."</td>
							 <td >".$row['serino']."</td>";
				
				
				//if ($row1["pirnt_serial"]!="1"){
				//	$ResponseXML .="<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['serino']."  name=".$row['serino']." onClick=\"del_item('".$row['serino']."');\"></td>";
				//}
							
                   $ResponseXML .= "</tr>";
					$i=$i+1;		
			}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
			
	}
	

	
if($_GET["Command"]=="save_item")
{

	
			
		//	$_SESSION["CURRENT_DOC"] = 1;      //document ID
		//	$_SESSION["VIEW_DOC"] = false ;     //view current document
		//	$_SESSION["FEED_DOC"] = true;       //save  current document
		//	$_GET["MOD_DOC"] = false  ;         //delete   current document
		//	$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
		//	$_GET["PRICE_EDIT"] = false ;       //edit selling price
		//	$_GET["CHECK_USER"] = false ;       //check user permission again


	//if ($_SESSION["save_sales_inv"]==1){
		$_SESSION["brand"]="";
		
		$invno=$_GET["invno"];
		
		
				
		$sqltmp1="select * from s_trn_stores where REFNO ='" . $invno . "'";
		$resultinv =mysqli_query($GLOBALS['dbinv'],$sqltmp1);
		if ($rowinv = mysqli_fetch_array($resultinv)){
			//if (($rowinv["TOTPAY"]==0) and ($rowinv["SDATE"]>$row["last_update"])){
				//$sql2="update s_salma set CANCELL='1' where REF_NO='".$_GET["invno"]."'";
				//$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
				
				$sqlisalma="Update s_salma set veheno='', driver='' where REF_NO='".$_GET["invno"]."'";
				$resultsalma =mysqli_query($GLOBALS['dbinv'],$sqlisalma);
			
				$sqltmp="select * from tmp_inv_data_stores where str_invno='".$_GET["invno"]."' ";
				$resulttmp =mysqli_query($GLOBALS['dbinv'],$sqltmp);
				while ($rowtmp = mysqli_fetch_array($resulttmp)){
					
					
					$sql2="update s_mas set QTYINHAND_STORES=QTYINHAND_STORES+".$rowtmp["cur_qty"]." where STK_NO='".$rowtmp['str_code']."'";
					$resul2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
				//	echo $sql2;
					
					$sql2="update s_submas_stores set QTYINHAND=QTYINHAND+".$rowtmp["cur_qty"]." where STO_CODE='".$_GET['department']."' and STK_NO='".$rowtmp['str_code']."'";
					$resul2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
				//	echo $sql2;
					
					$sql2="delete from s_trn_stores where REFNO='".$_GET['invno']."'";
					$resul2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
				//	echo $sql2;
					
				}
				
			
		}
				
		
	
		
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
	
						
			
			

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
			
			$mvatrate=12;
		
		
		$customername =str_replace("~", "&", $_GET["customername"]);  
		$cus_address =str_replace("~", "&", $_GET["cus_address"]);
			
			$sqlisalma="Update s_salma set veheno='".$_GET["com_vehe"]."', driver='".$_GET["com_driver"]."', loaddate='".date("Y-m-d")."' where REF_NO='".$invno."'";
			//echo $sqlisalma;
			$resultsalma =mysqli_query($GLOBALS['dbinv'],$sqlisalma);
			
			
   

    		$sqltmp="select * from tmp_inv_data_stores where str_invno='".$_GET["invno"]."'";
			//echo $sqltmp;
			$resulttmp =mysqli_query($GLOBALS['dbinv'],$sqltmp);
			while($rowtmp = mysqli_fetch_array($resulttmp)){
				$dis_per = $rowtmp["cur_rate"]*$rowtmp["cur_qty"]*$rowtmp["dis_per"]*0.01;
		
				$sqlmas="select * from s_mas where STK_NO='".trim($rowtmp["str_code"])."'";
				$resultmas =mysqli_query($GLOBALS['dbinv'],$sqlmas);
				$rowmas = mysqli_fetch_array($resultmas);
	
				
		
				$sqls_trn="Insert into s_trn_stores (STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, Dev, seri_no, SAL_EX, ACTIVE, DONO) values('".trim($rowtmp["str_code"])."','".$_GET["invdate"]."','".trim($_GET["invno"])."', ".$rowtmp["cur_qty"].", 'INV', '1', '".$_SESSION['dev']."', '', '', '1', '')";
				//echo $sqls_trn;
				$results_trn =mysqli_query($GLOBALS['dbinv'],$sqls_trn);
		
				$sqls_trn="update s_mas set QTYINHAND_STORES= QTYINHAND_STORES-".$rowtmp["cur_qty"]." where STK_NO='".trim($rowtmp["str_code"])."'";
				//echo $sqls_trn;
				$results_trn =mysqli_query($GLOBALS['dbinv'],$sqls_trn);
		
		
    	
				$sqls_submas="update s_submas_stores set QTYINHAND=QTYINHAND- ".$rowtmp["cur_qty"]." where STK_NO= '".trim($rowtmp["str_code"])."' and sto_code= '1'";
				//echo $sqls_submas;
				$results_submas =mysqli_query($GLOBALS['dbinv'],$sqls_submas);
		
     
  			}
	 
	
			$sqlpara="delete from tmp_inv_data_stores where str_invno='".$_GET["invno"]."'";
			$resultpara =mysqli_query($GLOBALS['dbinv'],$sqlpara);
			 
		echo "Saved";
		
	
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