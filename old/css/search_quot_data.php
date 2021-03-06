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
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
                             
   							</tr>";
                           
							if ($_GET["mstatus"]=="invno"){
						   		$letters = $_GET['invno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								$sql = mysql_query("SELECT * from s_salma where REF_NO like  '$letters%'") or die(mysql_error());
							} else if ($_GET["mstatus"]=="customername"){
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_salma where CUS_NAME like  '$letters%'") or die(mysql_error()) or die(mysql_error());
							} else {
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_salma where CUS_NAME like  '$letters%'") or die(mysql_error()) or die(mysql_error());
							}
							
													
						
							while($row = mysql_fetch_array($sql)){
								$REF_NO = $row['REF_NO'];
								$stname = "inv_mast";
							$ResponseXML .= "<tr>
                           	  <td bgcolor=\"#222222\" onclick=\"invno('$REF_NO');\">".$row['REF_NO']."</a></td>
                              <td bgcolor=\"#222222\" onclick=\"invno('$REF_NO');\">".$row['CUS_NAME']."</a></td>
                              <td bgcolor=\"#222222\" onclick=\"invno('$REF_NO');\">".$row['SDATE']."</a></td>
                                                        	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}


	

if ($_GET["Command"]=="search_arn"){
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">ARN No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Supplier</font></td>
                             <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">ARN Date</font></td>
   							</tr>";
                           
							if ($_GET["mstatus"]=="invno"){
						   		$letters = $_GET['invno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								$sql = mysql_query("SELECT * from s_purmas where REFNO like  '$letters%'") or die(mysql_error());
							} else if ($_GET["mstatus"]=="customername"){
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_purmas where SUP_CODE like  '$letters%'") or die(mysql_error()) or die(mysql_error());
							} else {
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_purmas where SUP_CODE like  '$letters%'") or die(mysql_error()) or die(mysql_error());
							}
							
													
						
							while($row = mysql_fetch_array($sql)){
								$REF_NO = $row['REFNO'];
								$stname = "inv_mast";
							$ResponseXML .= "<tr>
                           	  <td bgcolor=\"#222222\" onclick=\"invno('$REF_NO');\">".$row['REFNO']."</a></td>
                              <td bgcolor=\"#222222\" onclick=\"invno('$REF_NO');\">".$row['SUP_CODE']." - ".$row['SUP_NAME']."</a></td>
                              <td bgcolor=\"#222222\" onclick=\"invno('$REF_NO');\">".$row['SDATE']."</a></td>
                                                        	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}

if ($_GET["Command"]=="pass_crn"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$brand="";
			$salrep="";
			$cuscode="";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
					$inv= $_GET['invno']; 
					$_SESSION["invno"]=$_GET['invno']; 
					
				//	$_SESSION["custno"]=$_GET['custno'];
					$_SESSION["brand"]=$_GET["brand"];
					$_SESSION["department"]=$_GET["department"];
					
			 		//$tmpinvno="0000".substr($_GET['invno'], 4, 7) ;
					//$lenth=strlen($tmpinvno);
					//$serial=substr($tmpinvno, $lenth-7);
					//$inv=substr($_GET['invno'], 0, 3).substr("\ ", 0, 1).$serial;
				//$a="Select * from s_salma where REF_NO='".$inv."'";
				//echo $a;
				$sql = mysql_query("Select * from s_salma where REF_NO='".$inv."'") or die(mysql_error());
				
				if($row = mysql_fetch_array($sql)){
				
					$ResponseXML .= "<REF_NO><![CDATA[".$row['REF_NO']."]]></REF_NO>";
					$ResponseXML .= "<C_CODE><![CDATA[".$row['C_CODE']."]]></C_CODE>";
					$ResponseXML .= "<CUS_NAME><![CDATA[".$row['CUS_NAME']."]]></CUS_NAME>";
					$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
					$ResponseXML .= "<inv_amt><![CDATA[".$row['GRAND_TOT']."]]></inv_amt>";
					$ResponseXML .= "<TOTPAY><![CDATA[".$row['TOTPAY']."]]></TOTPAY>";
					$bal=$row['GRAND_TOT']-$row['TOTPAY'];
					$ResponseXML .= "<balance><![CDATA[".$bal."]]></balance>";
					$ResponseXML .= "<Brand><![CDATA[".$row['Brand']."]]></Brand>";
					$ResponseXML .= "<DEPARTMENT><![CDATA[".$row['DEPARTMENT']."]]></DEPARTMENT>";
					$ResponseXML .= "<SAL_EX><![CDATA[".$row['SAL_EX']."]]></SAL_EX>";

				}
		$ResponseXML .= "</salesdetails>";		

				echo $ResponseXML;
				
				
	
}

if ($_GET["Command"]=="pass_grn"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$brand="";
			$salrep="";
			$cuscode="";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
					$inv= $_GET['invno']; 
					$_SESSION["invno"]=$_GET['invno']; 
					
					//$_SESSION["custno"]=$_GET['custno'];
					$_SESSION["brand"]=$_GET["brand"];
					$_SESSION["department"]=$_GET["department"];
					
			 		//$tmpinvno="0000".substr($_GET['invno'], 4, 7) ;
					//$lenth=strlen($tmpinvno);
					//$serial=substr($tmpinvno, $lenth-7);
					//$inv=substr($_GET['invno'], 0, 3).substr("\ ", 0, 1).$serial;
				//$a="Select * from s_salma where REF_NO='".$inv."'";
				//echo $a;
				$sql = mysql_query("Select * from s_salma where REF_NO='".$inv."'") or die(mysql_error());
				
				if($row = mysql_fetch_array($sql)){
				
					$ResponseXML .= "<REF_NO><![CDATA[".$row['REF_NO']."]]></REF_NO>";
					$ResponseXML .= "<SAL_EX><![CDATA[".$row['SAL_EX']."]]></SAL_EX>";
					$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
					$ResponseXML .= "<Brand><![CDATA[".$row['Brand']."]]></Brand>";
					$ResponseXML .= "<DEPARTMENT><![CDATA[".$row['DEPARTMENT']."]]></DEPARTMENT>";
					$ResponseXML .= "<TYPE><![CDATA[".$row['TYPE']."]]></TYPE>";
					$ResponseXML .= "<DISCOU><![CDATA[".$row['DISCOU']."]]></DISCOU>";
					$ResponseXML .= "<GRAND_TOT><![CDATA[".$row['GRAND_TOT']."]]></GRAND_TOT>";
					$ResponseXML .= "<VAT><![CDATA[".$row['VAT']."]]></VAT>";
					
					$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Pre.RetQty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ret.Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";
							
				$i=1;
				
				$sql_data = mysql_query("delete from tmp_grn_data where str_invno='".$inv."'") or die(mysql_error());
				//echo "Select * from s_invo where REF_NO='".$inv."'";
				$sql_data = mysql_query("Select count(*) as mcount from s_invo where REF_NO='".$inv."'") or die(mysql_error());
				$row = mysql_fetch_array($sql_data);
				$mcou=$row['mcount'];
				
				$sql_data = mysql_query("Select * from s_invo where REF_NO='".$inv."'") or die(mysql_error());
				while($row = mysql_fetch_array($sql_data)){
					$sql_itdata = mysql_query("Select * from s_mas where STK_NO='".$row['STK_NO']."' and BRAND_NAME='".$brand."'") or die(mysql_error());
					$rowit = mysql_fetch_array($sql_itdata);
					
				
					$subtot=(floatval($row['PRICE'])*floatval($row['QTY']))-floatval($row['DIS_rs']);
					//echo $subtot;
					echo "Insert into tmp_grn_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$inv."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$subtot.", '".$row['BRAND']."')";
					$sql_tmp = mysql_query("Insert into tmp_grn_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$inv."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$subtot.", '".$row['BRAND']."')") or die(mysql_error());
					
						$stkno="stkno".$i;
						$descript="descript".$i;
						$price="price".$i;
						$qty="qty".$i;
						$preretqty="preret".$i;
						$retqty="ret".$i;
						$disc="disc".$i;
						$subtot="subtot".$i;
			
			
					if (is_null($row['ret_qty']) or $row['ret_qty']==0){
						$ret_qty=0;
					} else {
						$ret_qty=$row['ret_qty'];
					}
					
				
			 	$ResponseXML .= "<tr>
                        
							 <td bgcolor=\"#222222\"><input type=\"text\" size=\"10\" name=".$stkno."  disabled id=".$stkno." value='".$row['STK_NO']."' class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\"><input type=\"text\" size=\"20\" name=".$descript."  disabled id=".$descript." value='".$row['DESCRIPT']."' class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\"><input type=\"text\" size=\"10\" name=".$price."  disabled id=".$price." value=".number_format($row['PRICE'], 2, ".", ",")." class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"10\" name=".$qty."  disabled id=".$qty." value=".$row['QTY']." class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"10\" name=".$preretqty."  disabled id=".$preretqty." value=".$ret_qty." class=\"txtbox\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"10\" name=".$retqty." id=".$retqty."  class=\"txtbox\" onKeyPress=\"ret_deduct('".$i."',event, '".$mcou."');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"10\" name=".$disc." id=".$disc." value=".$row['DIS_per']." class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"10\" name=".$subtot." id=".$subtot." value='0' class=\"txtbox\"/></td>
							 
							
							 
                            </tr>";
							
							$i=$i+1;
            					
				}
			
			    $ResponseXML .= "   </table>]]></sales_table>";
				$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
					

				}
		$ResponseXML .= "</salesdetails>";		

				echo $ResponseXML;
				
				
	
}


if ($_GET["Command"]=="pass_search_grn"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$brand="";
			$salrep="";
			$cuscode="";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
					$inv= $_GET['invno']; 
					$_SESSION["invno"]=$_GET['invno']; 
					
					//$_SESSION["custno"]=$_GET['custno'];
					$_SESSION["brand"]=$_GET["brand"];
					$_SESSION["department"]=$_GET["department"];
					
			 		//$tmpinvno="0000".substr($_GET['invno'], 4, 7) ;
					//$lenth=strlen($tmpinvno);
					//$serial=substr($tmpinvno, $lenth-7);
					//$inv=substr($_GET['invno'], 0, 3).substr("\ ", 0, 1).$serial;
				//$a="Select * from s_salma where REF_NO='".$inv."'";
				//echo $a;
				
				

				
				$sql = mysql_query("select * from c_bal where REFNO='".$inv."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					$ResponseXML .= "<RNO><![CDATA[".$row['RNO']."]]></RNO>";
				}
				
				
				$sql = mysql_query("Select * from s_crnma where REF_NO='".$inv."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					$ResponseXML .= "<C_CODE><![CDATA[".$row['C_CODE']."]]></C_CODE>";
						
					$sql1 = mysql_query("Select * from vendor where CODE='".$row['C_CODE']."'") or die(mysql_error());
					if($row1 = mysql_fetch_array($sql1)){
						$ResponseXML .= "<NAME><![CDATA[".$row1['NAME']."]]></NAME>";
						$address=$row1['ADD1']." ".$row1['ADD2'];
						$ResponseXML .= "<ADDRESS><![CDATA[".$address."]]></ADDRESS>";
					}
					
					$ResponseXML .= "<REF_NO><![CDATA[".$inv."]]></REF_NO>";
					$ResponseXML .= "<INVOICENO><![CDATA[".$row['INVOICENO']."]]></INVOICENO>";
					$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
					$ResponseXML .= "<GRAND_TOT><![CDATA[".$row['GRAND_TOT']."]]></GRAND_TOT>";
					$ResponseXML .= "<DIS><![CDATA[".$row['DIS']."]]></DIS>";
					$ResponseXML .= "<GST><![CDATA[".$row['GST']."]]></GST>";
					$ResponseXML .= "<SAL_EX><![CDATA[".$row['SAL_EX']."]]></SAL_EX>";
					$ResponseXML .= "<DEPARTMENT><![CDATA[".$row['DEPARTMENT']."]]></DEPARTMENT>";
					$ResponseXML .= "<Brand><![CDATA[".$row['Brand']."]]></Brand>";
					$ResponseXML .= "<seri_no><![CDATA[".$row['seri_no']."]]></seri_no>";
					
					$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Pre.RetQty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ret.Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";
							
					 $tot=0;
					 $dis=0;
							
					$sql1 = mysql_query("Select * from s_crntrn where REF_NO='".$inv."'") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){
						$stkno="stkno".$i;
						$descript="descript".$i;
						$price="price".$i;
						$qty="qty".$i;
						$preretqty="preret".$i;
						$retqty="ret".$i;
						$disc="disc".$i;
						$subtot="subtot".$i;
			
			
						if (is_null($row1['QTY']) or $row1['QTY']==0){
							$ret_qty=0;
						} else {
							$ret_qty=$row1['QTY'];
						}
					
				
			 			$ResponseXML .= "<tr>
                        
							 <td bgcolor=\"#222222\"><input type=\"text\" size=\"10\" name=".$stkno."  disabled id=".$stkno." value='".$row1['STK_NO']."' class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\"><input type=\"text\" size=\"20\" name=".$descript."  disabled id=".$descript." value='".$row1['DESCRIPT']."' class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\"><input type=\"text\" size=\"10\" name=".$price."  disabled id=".$price." value=".number_format($row1['PRICE'], 2, ".", ",")." class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"10\" name=".$qty."  disabled id=".$qty." value=".$row1['QTY']." class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"10\" name=".$preretqty."  disabled id=".$preretqty." value=".$ret_qty." class=\"txtbox\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"10\" name=".$retqty." id=".$retqty."  class=\"txtbox\" onKeyPress=\"ret_deduct('".$i."',event, '".$mcou."');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"10\" name=".$disc." id=".$disc." value=".$row1['DIS_P']." class=\"txtbox\"/></td>";
							 
							 $subtotval=($row1['PRICE']*$row1['QTY'])-($row1['PRICE']*$row1['QTY']*$row1['DIS_P']*0.01);
							 $tot=$tot+ $subtotval;
							 $dis=$dis+($row1['PRICE']*$row1['QTY']*$row1['DIS_P']*0.01);
							 
							 $ResponseXML .= "<td bgcolor=\"#222222\" ><input type=\"text\" size=\"10\" name=".$subtot." id=".$subtot." value='".$subtotval."' class=\"txtbox\"/></td>
							 
							
							 
                            </tr>";

							$vat=$row1["VAT"];
														
							$i=$i+1;
            					
					}
					
					$ResponseXML .= "   </table>]]></sales_table>";
					$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";
					
					$ResponseXML .= "<sub_tot><![CDATA[".$tot."]]></sub_tot>";
					$ResponseXML .= "<dis><![CDATA[".$dis."]]></dis>";
				
					$vattot=$tot/(100+$row["vatrate"]*$row["vatrate"]);
					
					$ResponseXML .= "<vat><![CDATA[".$vattot."]]></vat>";
					
					$gtot=$tot-$vattot;
					$ResponseXML .= "<net><![CDATA[".$gtot."]]></net>";
			
		
			   
					
					
				}
				
				
		$ResponseXML .= "</salesdetails>";		

				echo $ResponseXML;
				
				
	
}


if ($_GET["Command"]=="pass_invno"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$brand="";
			$salrep="";
			$cuscode="";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
					$inv= $_GET['invno']; 
					$_SESSION["invno"]=$_GET['invno']; 
					
					$_SESSION["custno"]=$_GET['custno'];
					$_SESSION["brand"]=$_GET["brand"];
					$_SESSION["department"]=$_GET["department"];
			 		//$tmpinvno="0000".substr($_GET['invno'], 4, 7) ;
					//$lenth=strlen($tmpinvno);
					//$serial=substr($tmpinvno, $lenth-7);
					//$inv=substr($_GET['invno'], 0, 3).substr("\ ", 0, 1).$serial;
				$a="Select * from s_salma where REF_NO='".$inv."'";
				//echo $a;
				$sql = mysql_query("Select * from s_quomas where REF_NO='".$inv."'") or die(mysql_error());
				
				if($row = mysql_fetch_array($sql)){
				
					$ResponseXML .= "<str_invoiceno><![CDATA[".$row['REF_NO']."]]></str_invoiceno>";
					$ResponseXML .= "<str_crecash><![CDATA[".$row['TYPE']."]]></str_crecash>";
					$cuscode=$row['C_CODE'];
					$ResponseXML .= "<str_customecode><![CDATA[".$row['C_CODE']."]]></str_customecode>";
					$_SESSION["tmp_no_quot"]=$row['tmp_no'];
					
					$sqlcustomer = mysql_query("Select * from vendor where CODE='".$row['C_CODE']."'") or die(mysql_error());
					if($rowcustomer = mysql_fetch_array($sqlcustomer)){
						$ResponseXML .= "<str_customername><![CDATA[".$rowcustomer['NAME']."]]></str_customername>";
						$ResponseXML .= "<str_address><![CDATA[".$rowcustomer['ADD1']." ".$rowcustomer['ADD2']."]]></str_address>";
						$ResponseXML .= "<str_vatno1><![CDATA[".$rowcustomer['vatno']."]]></str_vatno1>";
						$ResponseXML .= "<str_vatno2><![CDATA[".$rowcustomer['svatno']."]]></str_vatno2>";
					}
					
					//$ResponseXML .= "<str_vatno2><![CDATA[".$row['str_vatno2']."]]></str_vatno2>";
					$ResponseXML .= "<str_salesrep><![CDATA[".$row['SAL_EX']."]]></str_salesrep>";
					$salrep=$row['SAL_EX'];
					//$ResponseXML .= "<str_salesorder1><![CDATA[".$row['str_salesorder1']."]]></str_salesorder1>";
					//$ResponseXML .= "<str_salesorder2><![CDATA[".$row['str_salesorder2']."]]></str_salesorder2>";
					$ResponseXML .= "<dte_deliverdate><![CDATA[".$row['REQ_DATE']."]]></dte_deliverdate>";
					$ResponseXML .= "<str_orderno1><![CDATA[".$row['ORD_NO']."]]></str_orderno1>";
					$ResponseXML .= "<str_orderno2><![CDATA[".$row['ORD_DA']."]]></str_orderno2>";
					//$ResponseXML .= "<cur_credit><![CDATA[".$row['cur_credit']."]]></cur_credit>";
					//$ResponseXML .= "<cur_balance><![CDATA[".$row['cur_balance']."]]></cur_balance>";
					
					
					
					$ResponseXML .= "<str_department><![CDATA[".$row['DEPARTMENT']."]]></str_department>";
					$ResponseXML .= "<str_brand><![CDATA[".$row['Brand']."]]></str_brand>";
					$brand=$row['Brand'];
					$ResponseXML .= "<str_vat><![CDATA[".$row['VAT']."]]></str_vat>";
					//$ResponseXML .= "<cur_discount1><![CDATA[".$row['cur_discount1']."]]></cur_discount1>";
					//$ResponseXML .= "<cur_discount2><![CDATA[".$row['cur_discount2']."]]></cur_discount2>";
					$ResponseXML .= "<cur_subtotal><![CDATA[".number_format($row['AMOUNT'], 2, ".", ",")."]]></cur_subtotal>";
					$ResponseXML .= "<cur_discount><![CDATA[".number_format($row['DISCOU'], 2, ".", ",")."]]></cur_discount>";
					$ResponseXML .= "<cur_tax><![CDATA[".number_format($row['VAT_VAL'], 2, ".", ",")."]]></cur_tax>";
					$ResponseXML .= "<cur_invoiceval><![CDATA[".number_format($row['GRAND_TOT'], 2, ".", ",")."]]></cur_invoiceval>";
					
					$ResponseXML .= "<Perform><![CDATA[".$row['Perform']."]]></Perform>";
					$ResponseXML .= "<chk1><![CDATA[".$row['Chk1']."]]></chk1>";
					$ResponseXML .= "<chk2><![CDATA[".$row['chk2']."]]></chk2>";
					$ResponseXML .= "<chk3><![CDATA[".$row['chk3']."]]></chk3>";
					$ResponseXML .= "<chk4><![CDATA[".$row['chk4']."]]></chk4>";
					$ResponseXML .= "<chk5><![CDATA[".$row['chk5']."]]></chk5>";
					$ResponseXML .= "<chk6><![CDATA[".$row['chk6']."]]></chk6>";
					$ResponseXML .= "<chk7><![CDATA[".$row['chk7']."]]></chk7>";
					$ResponseXML .= "<warranty><![CDATA[".$row['warranty']."]]></warranty>";
					$ResponseXML .= "<delivery><![CDATA[".$row['delivery']."]]></delivery>";
					$ResponseXML .= "<pay_type><![CDATA[".$row['pay_type']."]]></pay_type>";
					$ResponseXML .= "<validity><![CDATA[".$row['validity']."]]></validity>";
					$ResponseXML .= "<Country><![CDATA[".$row['Country']."]]></Country>";
					$ResponseXML .= "<GROUPS><![CDATA[".$row['GROUPS']."]]></GROUPS>";
					
				}				
		
				
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";
							
				
				$sql_data = mysql_query("delete from tmp_quot_data where tmp_no='".$_SESSION["tmp_no_quot"]."'") or die(mysql_error());
				$sql_data = mysql_query("Select * from s_quotrn where REF_NO='".$inv."'") or die(mysql_error());
				while($row = mysql_fetch_array($sql_data)){
					$sql_itdata = mysql_query("Select * from s_mas where STK_NO='".$row['STK_NO']."' and BRAND_NAME='".$brand."'") or die(mysql_error());
					$rowit = mysql_fetch_array($sql_itdata);
							
							
					//$sql_tmp = mysql_query("Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, cur_subtot) values ( '".$row['REFNO']."', '".$row['STK_NO']."', '".$rowit['DESCRIPT']."', ".$rowit['SELLING'].", ".$row['QTY'].", ".$rowit['SELLING']*$row['QTY'].")") or die(mysql_error());
				//	echo "Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$inv."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$row["subtot"].", '".$row['BRAND']."')";
					
					//$sql="Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$inv."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$row["subtot"].", '".$row['BRAND']."')";
				
					$subtot=(floatval($row['PRICE'])*floatval($row['QTY']))-floatval($row['DIS_rs']);
					//echo $subtot;
					
					$sql_tmp = mysql_query("Insert into tmp_quot_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand, tmp_no) values ( '".$inv."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$subtot.", '".$row['BRAND']."', '".$_SESSION["tmp_no_salinv"]."')") or die(mysql_error());
					
						
			
			 	$ResponseXML .= "<tr>
                            <td onClick=\"disp_qty('".$row['STK_NO']."');\">".$row['STK_NO']."</a></td>
  							 <td onClick=\"disp_qty('".$row['STK_NO']."');\">".$row['DESCRIPT']."</a></td>
							 <td onClick=\"disp_qty('".$row['STK_NO']."');\">".number_format($row['PRICE'], 2, ".", ",")."</a></td>
							 <td onClick=\"disp_qty('".$row['STK_NO']."');\">".$row['QTY']."</a></td>
							 <td onClick=\"disp_qty('".$row['STK_NO']."');\">".number_format($row['DIS_per'], 2, ".", ",")."</td>
							 <td onClick=\"disp_qty('".$row['STK_NO']."');\">".number_format($subtot, 2, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>
							 
                            </tr>";
							
							
            					
				}
			
			    $ResponseXML .= "   </table>]]></sales_table>";
	
/*		$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
					$sql = mysql_query("CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error());*/
	

	
	
	$OutpDAMT = 0;
	$OutREtAmt = 0;
	$OutInvAmt = 0;
	$InvClass="";
	
	$sqlclass = mysql_query("select class from brand_mas where barnd_name='".trim($brand)."'") or die(mysql_error());
	if ($rowclass = mysql_fetch_array($sqlclass)){
		if (is_null($rowclass["class"])==false){
			$InvClass=$rowclass["class"];
		}
	}
	
	$sqloutinv = mysql_query("select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($salrep)."' and class='".$InvClass."'") or die(mysql_error());
	if ($rowoutinv = mysql_fetch_array($sqloutinv)){
		if (is_null($rowoutinv["totout"])==false){
			$OutInvAmt=$rowoutinv["totout"];
		}
	}

$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salrep)."'") or die(mysql_error());
	while($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
		
		$sqlsttr = mysql_query("select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"]) ."'") or die(mysql_error());
		while($rowsttr = mysql_fetch_array($sqlsttr)){
			$sqlview_s_salma = mysql_query("select class from view_s_salma where REF_NO='".trim($rowsttr["ST_INVONO"])."'") or die(mysql_error());
			if($rowview_s_salma = mysql_fetch_array($sqlview_s_salma)){
				
				if (trim($rowview_s_salma["class"]) == $InvClass){
                    $OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
                }
			}
		}
	}


        
        $pend_ret_set = 0;
		
		$sqlinvcheq = mysql_query("SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='RET'") or die(mysql_error());
		if($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
			if (is_null($rowinvcheq["che_amount"])==false){
				$pend_ret_set=$rowinvcheq["che_amount"];
			}
		}
		
		
		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".trim($salrep)."'") or die(mysql_error());
		if($rowcheq = mysql_fetch_array($sqlcheq)){
			if (is_null($rowcheq["tot"])==false){
				$OutREtAmt=$rowcheq["tot"];
			} else {
				$OutREtAmt=0;
			}
		}
		
            

        

$ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td width=\"200\"><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutREtAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutpDAMT, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";



      $sqlbr_trn = mysql_query("select * from br_trn where Rep='".trim($salrep)."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'") or die(mysql_error());  
	if($rowbr_trn = mysql_fetch_array($sqlbr_trn)){
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
		
		if (is_null($rowbr_trn["CAT"])==false) {
			$cuscat = trim($rowbr_trn["CAT"]);
            if ($cuscat == "A"){ $m = 2.5; }
            if ($cuscat == "B"){ $m = 2.5; }
            if ($cuscat == "C"){ $m = 1; }
			if ($cuscat == "D"){ $m = 0; }
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
			$crebal=$crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $txt_crebal = number_format($crebal, "2", ".", ",");
          } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
          }
         $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;

	   			
			
			 
    }    
			$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
			$ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
          
         	 $ResponseXML .= "<creditbalance><![CDATA[".$creditbalance."]]></creditbalance>";

			
		
		
			
		$ResponseXML .= "</salesdetails>";		


	$_SESSION["print"]=1;
	
				echo $ResponseXML;
				
				
	
}

if ($_GET["Command"]=="assign_brand"){
	$_SESSION["brand"]=$_GET["brand"];
	//echo $_SESSION["brand"];
	
/*	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
	
	
	$sql = mysql_query("CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error());
	

	
	header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		$ResponseXML = "";
		$ResponseXML .= "<salesdetails>";
		
	$OutpDAMT = 0;
	$OutREtAmt = 0;
	$OutInvAmt = 0;
	
	$InvClass=" ";
	
	
	$sql = mysql_query("select class from brand_mas where barnd_name = '".trim($_GET["brand"])."'") or die(mysql_error());
	if($row = mysql_fetch_array($sql)){
		if (is_null($row["class"])==false) {
			$InvClass = trim($row["class"]);		
		}
	}	

	
	
	$cuscode=$_GET["txt_cuscode"];
	if ($InvClass!=""){
		$cmbrep=trim(substr($_GET["salesrep"], 0, 5));
	
		$sql = mysql_query("select sum(grand_tot-totpay) as totOut from view_s_salma where grand_tot>totpay and cancell='0' and c_code='".trim($cuscode)."' and sal_ex='".$cmbrep."' and class='".$InvClass."'") or die(mysql_error());
		if($row = mysql_fetch_array($sql)){
		
		   if (is_null($row["totOut"])==false){
		   	$OutInvAmt = $row["totOut"];
			
			}
		}
		
 		
	
		$sql = mysql_query("SELECT * FROM s_invcheq WHERE CHE_DATE>'".date("d-m-Y")."' AND CUS_CODE='".trim($cuscode)."' and trn_type='REC' and sal_ex='".$cmbrep."'") or die(mysql_error());
		while($row = mysql_fetch_array($sql)){
		    $sql1 = mysql_query("select * from s_sttr where st_refno='".trim($row["REFNO"])."' and st_chno ='".trim($row["cheque_no"])."'") or die(mysql_error());
			while($row1 = mysql_fetch_array($sql1)){
				$sql2 = mysql_query("select class from view_s_salma where ref_no='".trim($row["ST_INVONO"])."' ") or die(mysql_error());
				if ($row2 = mysql_fetch_array($sql2)){
                    if (trim($row2["Class"]) == $InvClass) {
                    	$OutpDAMT = $OutpDAMT + $row1["ST_PAID"];
                    }
                }
			}
		}
		
		$pend_ret_set = 0;		
		
		$sql = mysql_query("SELECT sum(che_amount) as  che_amount FROM S_INVCHeQ WHERE CHE_DATE >'".date("d-m-Y")."' AND CUS_CODE='".trim($cuscode)."' and trn_type='RET' ") or die(mysql_error());
				if ($row = mysql_fetch_array($sql)){	
					if (is_null($row["che_amount"])==false){
						$pend_ret_set = $row["che_amount"];
					}
				}
						
        
 

       
		 $sql = mysql_query("Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='".trim($cuscode). "'  and CR_CHEVAL-paid>0 and cr_flag='0' and s_ref='".trim($cmbrep)."' ") or die(mysql_error());
		if ($row = mysql_fetch_array($sql)){	
		
        	if (is_null($row["tot"]==false)){
           		$OutREtAmt = $row["tot"];
        	} else {
           		$OutREtAmt = 0;
        	}
        }
		
		
		
        $ResponseXML .= "<sales_table><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>".number_format($OutInvAmt, 2, ".", ",")."</td></tr>
						 <td>Return Cheqe Amount</td><td>".number_format($OutREtAmt, 2, ".", ",")."</td></tr>
						 <td>Pending Cheque Amount</td><td>".number_format($OutpDAMT, 2, ".", ",")."</td></tr>
						 <td>PSD Cheque Settlments</td><td>".number_format($pend_ret_set, 2, ".", ",")."</td></tr>
						 <td>Total</td><td>".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."</td></tr>
						 </table></table>]]></sales_table>";
				

        
		  $sql = mysql_query("select * from br_trn where rep='".$cmbrep."' and brand='".trim($InvClass)."' and cus_code='".trim($cuscode)."' ") or die(mysql_error());
		if ($row = mysql_fetch_array($sql)){	
		           
            if (is_null($row["credit_lim"]==false)){
               $crLmt = $row["credit_lim"];
            } else {
               $crLmt = 0;
            }
			
			if (is_null($row["tmpLmt"]==false)){
               $tmpLmt = $row["tmpLmt"];
            } else {
               $tmpLmt = 0;
            }
			
			if (is_null($row["cat"]==false)){
               $cuscat = trim($row["cat"]);
            }
            
			if ($cuscat=="A"){ $m = 2.5; }
			if ($cuscat=="B"){ $m = 2.5; }
			if ($cuscat=="C"){ $m = 1; }
                      
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi =number_format($crLmt, 2, ".", ",");
            $txt_crebal = number_format($crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set, 2, ".", ",");
			
			$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
			$ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
          } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
			
			$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
			$ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
          }
          $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
          $ResponseXML .= "<creditbalance><![CDATA[".$creditbalance."]]></creditbalance>";
		  
		 $sql = mysql_query("select dis from brand_mas where barnd_name = '".trim($_GET["brand"])."'") or die(mysql_error());
		if ($row = mysql_fetch_array($sql)){	
			$ResponseXML .= "<dis><![CDATA[".$row["dis"]."]]></dis>";
		}
          $xx = 1;
 		}	
		
		
			
		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML; */
}	
?>
