<?php

/*
	include_once("config.inc.php");
	include_once("DBConnector.php");
	$letters = $_GET['letters'];
	
	$sql="SELECT * FROM mast_family where name like '".$letters."%'";
		$result =$db->RunQuery($sql);
			
			
			while($row = mysql_fetch_array($result))
			{
			
			echo $row["name"];
			
			}
			
		*/	
		
		
session_start();


	include_once("connection.php");

if ($_GET["Command"]=="search_item"){

//	if(isset($_GET['itemname'])){
//		$letters = $_GET['itemname'];
	//$letters = $_GET['letters'];
//		$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
//	$res = mysql_query("SELECT * FROM mast_family where name like '".$letters."%'") or die(mysql_error());
	
	//$res = mysql_query("SELECT distinct trn_involved.str_name FROM trn_involved where str_name like '".$letters."%'") or die(mysql_error());
		
	
	//SELECT * FROM occupation_details where str_first_name like 'k%'
//echo $res;
	
		$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Item No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Item Description</font></td>
                             
   							</tr>";
                           
														
							if ($_GET["mstatus"]=="itno"){
						   		$letters = $_GET['itno'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								if (isset($_SESSION["brand"])==true){
								$sql = mysql_query("SELECT * from s_mas where STK_NO like  '$letters%' and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO") or die(mysql_error());
								} else {
								$sql = mysql_query("SELECT * from s_mas where STK_NO like  '$letters%' order by STK_NO") or die(mysql_error());
								}
							} else if ($_GET["mstatus"]=="itemname"){
								$letters = $_GET['itemname'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								if (isset($_SESSION["brand"])==true){
									$sql = mysql_query("SELECT * from s_mas where DESCRIPT like  '$letters%' and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO") or die(mysql_error()) or die(mysql_error());
								} else {
									$sql = mysql_query("SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO") or die(mysql_error()) or die(mysql_error());
								}
							} else {
								
								$letters = $_GET['itemname'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								if (isset($_SESSION["brand"])==true){
									$sql = mysql_query("SELECT * from s_mas where DESCRIPT like  '$letters%' and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO") or die(mysql_error()) or die(mysql_error());
								} else {
									$sql = mysql_query("SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO") or die(mysql_error()) or die(mysql_error());
								}
							}
							
						
							while($row = mysql_fetch_array($sql)){
					
							$ResponseXML .= "<tr>
                              <td onclick=\"itno('".$row['STK_NO']."');\">".$row['STK_NO']."</a></td>
                              <td onclick=\"itno('".$row['STK_NO']."');\">".$row['DESCRIPT']."</a></td>
                                                        	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
	//}
}


if ($_GET["Command"]=="pass_invno"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
	/*		$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";
							
			
			$sql = mysql_query("select * from inv_data where str_invno='".$_GET['invno']."'") or die(mysql_error());
			while($row = mysql_fetch_array($sql)){
									
				$sql1 = mysql_query("Insert into tmp_inv_data (str_invno, str_code, str_description, cur_rate, cur_qty, cur_discount, cur_subtot)values ('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', '".$_GET['rate']."', '".$_GET['qty']."', '".$_GET['discount']."', '".$_GET['subtotal']."') ") or die(mysql_error());
			
		       	$ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_rate']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_qty']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_discount']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_subtot']."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>
							 
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";*/
				
				$sql = mysql_query("Select * from inv_mast where str_invoiceno='".$_GET['invno']."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
				
					$ResponseXML .= "<str_invoiceno><![CDATA[".$row['str_invoiceno']."]]></str_invoiceno>";
					$ResponseXML .= "<str_crecash><![CDATA[".$row['str_crecash']."]]></str_crecash>";
					$ResponseXML .= "<str_customecode><![CDATA[".$row['str_customecode']."]]></str_customecode>";
					
					$sqlcustomer = mysql_query("Select * from customer_mast where id='".$row['str_customecode']."'") or die(mysql_error());
					if($rowcustomer = mysql_fetch_array($sqlcustomer)){
						$ResponseXML .= "<str_customername><![CDATA[".$rowcustomer['str_customername']."]]></str_customername>";
						$ResponseXML .= "<str_address><![CDATA[".$rowcustomer['str_address']."]]></str_address>";
					}
					$ResponseXML .= "<str_vatno1><![CDATA[".$row['str_vatno1']."]]></str_vatno1>";
					$ResponseXML .= "<str_vatno2><![CDATA[".$row['str_vatno2']."]]></str_vatno2>";
					$ResponseXML .= "<str_salesrep><![CDATA[".$row['str_salesrep']."]]></str_salesrep>";
					$ResponseXML .= "<str_salesorder1><![CDATA[".$row['str_salesorder1']."]]></str_salesorder1>";
					$ResponseXML .= "<str_salesorder2><![CDATA[".$row['str_salesorder2']."]]></str_salesorder2>";
					$ResponseXML .= "<dte_deliverdate><![CDATA[".$row['dte_deliverdate']."]]></dte_deliverdate>";
					$ResponseXML .= "<str_orderno1><![CDATA[".$row['str_orderno1']."]]></str_orderno1>";
					$ResponseXML .= "<str_orderno2><![CDATA[".$row['str_orderno2']."]]></str_orderno2>";
					$ResponseXML .= "<cur_credit><![CDATA[".$row['cur_credit']."]]></cur_credit>";
					$ResponseXML .= "<cur_balance><![CDATA[".$row['cur_balance']."]]></cur_balance>";
					$ResponseXML .= "<str_department><![CDATA[".$row['str_department']."]]></str_department>";
					$ResponseXML .= "<str_brand><![CDATA[".$row['str_brand']."]]></str_brand>";
					$ResponseXML .= "<str_vat><![CDATA[".$row['str_vat']."]]></str_vat>";
					$ResponseXML .= "<cur_discount1><![CDATA[".$row['cur_discount1']."]]></cur_discount1>";
					$ResponseXML .= "<cur_discount2><![CDATA[".$row['cur_discount2']."]]></cur_discount2>";
					$ResponseXML .= "<cur_subtotal><![CDATA[".$row['cur_subtotal']."]]></cur_subtotal>";
					$ResponseXML .= "<cur_discount><![CDATA[".$row['cur_discount']."]]></cur_discount>";
					$ResponseXML .= "<cur_tax><![CDATA[".$row['cur_tax']."]]></cur_tax>";
					$ResponseXML .= "<cur_invoiceval><![CDATA[".$row['cur_invoiceval']."]]></cur_invoiceval>";
				}				
			
				
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";
							
				
				$sql_data = mysql_query("delete from tmp_inv_data where str_invno='".$_GET['invno']."'") or die(mysql_error());
				$sql_data = mysql_query("Select * from inv_data where str_invno='".$_GET['invno']."'") or die(mysql_error());
				while($row = mysql_fetch_array($sql_data)){
					$sql_itdata = mysql_query("Select * from item_mast where str_code='".$row['str_code']."'") or die(mysql_error());
					$rowit = mysql_fetch_array($sql_itdata);
							
							
					$sql_tmp = mysql_query("Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, cur_discount, cur_subtot) values ( '".$row['str_invno']."', '".$row['str_code']."', '".$rowit['str_description']."', ".$row['cur_rate'].", ".$row['cur_qty'].", ".$row['cur_discount'].", ".$row['cur_subtot'].")") or die(mysql_error());
					
					
						
			
			 	$ResponseXML .= "<tr>
                              
                             <td  >".$row['str_code']."</a></td>
  							<td  >".$rowit['str_description']."</a></td>
							 <td  >".$row['cur_rate']."</a></td>
							 <td  >".$row['cur_qty']."</a></td>
							 <td  >".$row['cur_discount']."</a></td>
							 <td  >".$row['cur_subtot']."</a></td>
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>
							 
                            </tr>";
							
							
            					
				}
			
			    $ResponseXML .= "   </table>]]></sales_table>";
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
				
	
}	


if ($_GET["Command"]=="pass_ginno"){


	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			$sql=mysql_query("Select * from s_ginmas where REF_NO='".$_GET['gin']."'")or die(mysql_error());
			if($row = mysql_fetch_array($sql)){		
			
				$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
				$ResponseXML .= "<REF_NO><![CDATA[".$row['REF_NO']."]]></REF_NO>";
				$ResponseXML .= "<DEP_FROM><![CDATA[".$row['DEP_FROM']."]]></DEP_FROM>";
				$ResponseXML .= "<DEP_TO><![CDATA[".$row['DEP_TO']."]]></DEP_TO>";
				
			//	$sql1="insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT) values ('".$row2["str_code"]."', '".$_GET["invdate"]."', '".$cur_qty."', 'GINI', '".$_GET["invno"]."', '".$_GET["from_dep"]."')";
				//	$result1 =$db->RunQuery($sql1);
				
				
				
								
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";
							
			
				$sql1=mysql_query("Select * from s_trn where REFNO='".$_GET['gin']."' and LEDINDI='GINI'")or die(mysql_error());
				while($row1 = mysql_fetch_array($sql1)){
		
             	$ResponseXML .= "<tr>                              
                             <td  >".$row1['STK_NO']."</a></td>";
							 
				$sqldesc=mysql_query("Select * from s_mas where STK_NO='".$row1['STK_NO']."'")or die(mysql_error());
				$rowdesc = mysql_fetch_array($sqldesc);
			
					$ResponseXML .= " <td >".$rowdesc['DESCRIPT']."</a></td>
							 <td >".$rowdesc['PART_NO']."</a></td>
							 <td >".number_format($row1['QTY'], 0, ".", ",")."</a></td>
							
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
							 include_once("connection.php");
					//	echo "select QTYINHAND from s_submas where STK_NO='".$row1['STK_NO']."' AND STO_CODE='".$_GET["from_dep"]."'";
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row1['STK_NO']."' AND STO_CODE='".$row['DEP_FROM']."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td >".number_format($qty, 0, ".", ",")."</a></td>
							 
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				
				$ResponseXML .= " </salesdetails>";
				
			}	
				
				
				echo $ResponseXML;
}	




if ($_GET["Command"]=="pass_stk_sdj"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			
				$sql = mysql_query("Select * from s_mas where STK_NO='".$_GET['itno']."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
				
					
					$ResponseXML .= "<str_code><![CDATA[".$row['STK_NO']."]]></str_code>";
					$ResponseXML .= "<str_description><![CDATA[".$row['DESCRIPT']."]]></str_description>";
					$ResponseXML .= "<str_partno><![CDATA[".$row['PART_NO']."]]></str_partno>";
					//$ResponseXML .= "<str_selpri><![CDATA[".$row['SELLING']."]]></str_selpri>";
					
					
				/*	if ($_GET["vatmethod"]=="non"){
     					if (is_null($row["SELLING"])==false){
							$selpri = number_format($row["SELLING"]);
   						} 
						
					}else {
						$mvatrate=12;
						
      					if (is_null($row["SELLING"])==false){
							$selpri = number_format($row["SELLING"] / (1 + ($mvatrate / 100)), 2, ".", ",");
   						} 
					}*/
					
					
				//	$ResponseXML .= "<str_selpri><![CDATA[".$selpri."]]></str_selpri>";
					
					$department=trim(substr($_GET["department"], 0, 2));
					
					//echo "select QTYINHAND from s_submas where STK_NO='".$_GET['itno']."' AND STO_CODE='".$department."'";
					$sql = mysql_query("select QTYINHAND from s_submas where STK_NO='".$_GET['itno']."' AND STO_CODE='".$department."'") or die(mysql_error());
					if($row = mysql_fetch_array($sql)){
						if (is_null($row["QTYINHAND"])==false){
							$ResponseXML .= "<qtyinhand><![CDATA[".$row["QTYINHAND"]."]]></qtyinhand>";
						}  else {
							$ResponseXML .= "<qtyinhand><![CDATA[0]]></qtyinhand>";
						}
					}  else {
							$ResponseXML .= "<qtyinhand><![CDATA[0]]></qtyinhand>";
						}
				
					//================discount
				/*	$d1=0;
					if (is_numeric($_GET["discount1"])==true){
						$d1=$_GET["discount1"];
					} else {
						$d1=0;
					}
					
					$d2=0;
					if (is_numeric($_GET["discount2"])==true){
						$d2=$_GET["discount2"];
					} else {
						$d2=0;
					}
					
					$d3=0;
					if (is_numeric($_GET["discount3"])==true){
						$d3=$_GET["discount3"];
					} else {
						$d3=0;
					}
   										
   					$d = 100 - (100 - $d2) * (100 - $d1) / 100;
  				 	$ResponseXML .= "<dis><![CDATA[".$d."]]></dis>";*/
				}				
			
				 
			
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
			
	
}	


?>
