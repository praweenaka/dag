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
	
if ($_GET["Command"]=="search_inv"){
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">GIN No</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">From</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">To</font></td>
                             
   							</tr>";
                           
							if ($_GET["mstatus"]=="invno"){
						   		$letters = $_GET['invno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								$sql = mysql_query("SELECT * from s_ginmas where cancel='0' and REF_NO like  '$letters%' order by SDATE desc") or die(mysql_error());
							} else if ($_GET["mstatus"]=="from"){
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_ginmas where cancel='0' and DEP_F_NAME like  '$letters%' order by SDATE desc") or die(mysql_error()) or die(mysql_error());
							} else if ($_GET["mstatus"]=="to"){
								$letters = $_GET['invdate'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_ginmas where cancel='0' and DEP_T_NAME like  '$letters%' order by SDATE desc") or die(mysql_error()) or die(mysql_error());
							} else {
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_ginmas where cancel='0' order by SDATE desc") or die(mysql_error()) or die(mysql_error());
							}
							
													
						
							while($row = mysql_fetch_array($sql)){
							
							$ResponseXML .= "<tr>
                           	  <td onclick=\"gin('".$row['REF_NO']."');\">".$row['REF_NO']."</a></td>
                              <td onclick=\"gin('".$row['REF_NO']."');\">".$row['DEP_F_NAME']."</a></td>
                              <td onclick=\"gin('".$row['REF_NO']."');\">".$row['DEP_T_NAME']."</a></td>
                                                        	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}



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
								
								$sql = mysql_query("SELECT * from s_mas where STK_NO like  '$letters%' order by STK_NO") or die(mysql_error());
								
							} else if ($_GET["mstatus"]=="itemname"){
								$letters = $_GET['itemname'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								
									$sql = mysql_query("SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO") or die(mysql_error());
								
							} else {
								
								$letters = $_GET['itemname'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								
									$sql = mysql_query("SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO") or die(mysql_error());
								
							}
							
						//echo $sql;
							while($row = mysql_fetch_array($sql)){
					
							$ResponseXML .= "<tr>
                              <td onclick=\"itno('".$row['STK_NO']."');\">".$row['STK_NO']."</a></td>
                              <td onclick=\"itno('".$row['STK_NO']."');\">".$row['DESCRIPT']."</a></td>";
							  
							//  $department=$_SESSION["department"];
							  
							//  $sql1 = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['STK_NO']."' AND STO_CODE='".$department."'") or die(mysql_error()) or die(mysql_error());
							//  if($row1 = mysql_fetch_array($sql1)){
							//  	$ResponseXML .= "<td bgcolor=\"#222222\" onclick=\"itno('".$row['STK_NO']."');\">".$row1['QTYINHAND']."</a></td>";
							//  }	else {
							//  	$ResponseXML .= "<td bgcolor=\"#222222\" onclick=\"itno('".$row['STK_NO']."');\">0</a></td>";
							//  }
                                                        	
                            $ResponseXML .= "</tr>";
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
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
  							<td bgcolor=\"#222222\" >".$rowit['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_rate']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_qty']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_discount']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_subtot']."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>
							 
                            </tr>";
							
							
            					
				}
			
			    $ResponseXML .= "   </table>]]></sales_table>";
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
				
	
}	

if ($_GET["Command"]=="pass_itno"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			if ($_GET["brand"] != ""){	
			//echo "Select * from s_mas where STK_NO='".$_GET['itno']."' and BRAND_NAME='".$_GET["brand"]."'";
				$sql = mysql_query("Select * from s_mas where STK_NO='".$_GET['itno']."' and BRAND_NAME='".$_GET["brand"]."'") or die(mysql_error());
				} else {
				$sql = mysql_query("Select * from s_mas where STK_NO='".$_GET['itno']."'") or die(mysql_error());
				}
				if($row = mysql_fetch_array($sql)){
				
					
					$ResponseXML .= "<str_code><![CDATA[".$row['STK_NO']."]]></str_code>";
					$ResponseXML .= "<str_description><![CDATA[".$row['DESCRIPT']."]]></str_description>";
					$ResponseXML .= "<str_selpri><![CDATA[".$row['SELLING']."]]></str_selpri>";
					
					
					
					
					$department=trim(substr($_GET["department"], 0, 2));
					
					
					$sql = mysql_query("select QTYINHAND from s_submas where STK_NO='".$_GET['itno']."' AND STO_CODE='".$department."'") or die(mysql_error());
					if($row = mysql_fetch_array($sql)){
						if (is_null($row["QTYINHAND"])==false){
							$ResponseXML .= "<qtyinhand><![CDATA[".$row["QTYINHAND"]."]]></qtyinhand>";
						} else {
							$ResponseXML .= "<qtyinhand><![CDATA[]]></qtyinhand>";
						}
					}
				
				
				}				
			
				 
			
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
			
	
}	

if ($_GET["Command"]=="pass_assignbrand"){
	$_SESSION["brand"]=$_GET["brand"];
	$_SESSION["department"]=$_GET["department"];
	
}
?>
