<?php  session_start();

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
		
		



	include_once("connectioni.php");

if ($_GET["Command"]=="search_item"){

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
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><strong><font color=\"#FFFFFF\">Item No</font></strong></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Item Description</font></strong></td>
                               <td width=\"150\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Brand Name</font></strong></td>
                              <td width=\"150\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Stock In Hand</font></strong></td>
                             
   							</tr>";
                           
						if ($_GET["checkbox"]=="true"){									
							if ($_GET["mstatus"]=="itno"){
						   		$letters = $_GET['itno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								/*if ($_SESSION["brand"]!=""){
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where STK_NO like  '$letters%' and QTYINHAND>0 and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO limit 50") or die(mysqli_error());
								//echo "SELECT * from s_mas where STK_NO like  '$letters%' and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO limit 50";
								} else {*/
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where STK_NO like  '$letters%' and QTYINHAND>0 order by STK_NO limit 50") or die(mysqli_error());
								//echo "SELECT * from s_mas where STK_NO like  '$letters%' order by STK_NO limit 50";
								//}
							} else if ($_GET["mstatus"]=="itemname"){
								$letters = $_GET['itemname'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								/*if ($_SESSION["brand"]!=""){
									$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where DESCRIPT like  '$letters%' and QTYINHAND>0 and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
									//echo "SELECT * from s_mas where DESCRIPT like  '$letters%' and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO limit 50";
								} else {*/
									$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where DESCRIPT like  '$letters%' and QTYINHAND>0 order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
									//echo "SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO limit 50";
								//}
							} else {
								
								$letters = $_GET['itemname'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								/*if (isset($_SESSION["brand"])==true){
									$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where DESCRIPT like  '$letters%' and QTYINHAND>0 and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
								} else {*/
									$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where DESCRIPT like  '$letters%' and QTYINHAND>0 order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
								//}
							}
						
						} else {
							if ($_GET["mstatus"]=="itno"){
						   		$letters = $_GET['itno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								/*if ($_SESSION["brand"]!=""){
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where STK_NO like  '$letters%' and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO limit 50") or die(mysqli_error());
								//echo "SELECT * from s_mas where STK_NO like  '$letters%' and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO limit 50";
								} else {*/
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where STK_NO like  '$letters%' order by STK_NO limit 50") or die(mysqli_error());
								//echo "SELECT * from s_mas where STK_NO like  '$letters%' order by STK_NO limit 50";
								//}
							} else if ($_GET["mstatus"]=="itemname"){
								$letters = $_GET['itemname'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								/*if ($_SESSION["brand"]!=""){
									$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where DESCRIPT like  '$letters%' and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
									//echo "SELECT * from s_mas where DESCRIPT like  '$letters%' and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO limit 50";
								} else {*/
									$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
									//echo "SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO limit 50";
								//}
							} else {
								
								$letters = $_GET['itemname'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								/*if (isset($_SESSION["brand"])==true){
									$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where DESCRIPT like  '$letters%' and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
								} else {*/
									$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where DESCRIPT like  '$letters%' order by STK_NO limit 50") or die(mysqli_error()) or die(mysqli_error());
								//}
							}
						}	
						
							while($row = mysqli_fetch_array($sql)){
					
							$ResponseXML .= "<tr>
                              <td onclick=\"itno('".$row['STK_NO']."');\">".$row['STK_NO']."</a></td>
                              <td onclick=\"itno('".$row['STK_NO']."');\">".$row['DESCRIPT']."</a></td>
							   <td onclick=\"itno('".$row['STK_NO']."');\">".$row['BRAND_NAME']."</a></td>
							   <td onclick=\"itno('".$row['STK_NO']."');\">". number_format($row['QTYINHAND'], 0, ".", ",")."</a></td>";
							 
							/*  $department=$_SESSION["department"];
							 
							 if ($_GET["department"]!="All"){ 
							  	$sql1 = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['STK_NO']."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error()) or die(mysqli_error());
							} else {
								$sql1 = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['STK_NO']."'") or die(mysqli_error()) or die(mysqli_error());
							}	
							  if($row1 = mysqli_fetch_array($sql1)){
							  	$ResponseXML .= "<td onclick=\"itno('".$row['STK_NO']."');\">".$row1['QTYINHAND']."</a></td>";
							  }	*/
                                                        	
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
							
			
			$sql = mysqli_query($GLOBALS['dbinv'],"select * from inv_data where str_invno='".$_GET['invno']."'") or die(mysqli_error());
			while($row = mysqli_fetch_array($sql)){
									
				$sql1 = mysqli_query($GLOBALS['dbinv'],"Insert into tmp_inv_data (str_invno, str_code, str_description, cur_rate, cur_qty, cur_discount, cur_subtot)values ('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', '".$_GET['rate']."', '".$_GET['qty']."', '".$_GET['discount']."', '".$_GET['subtotal']."') ") or die(mysqli_error());
			
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
				
				$sql = mysqli_query($GLOBALS['dbinv'],"Select * from inv_mast where str_invoiceno='".$_GET['invno']."'") or die(mysqli_error());
				if($row = mysqli_fetch_array($sql)){
				
					$ResponseXML .= "<str_invoiceno><![CDATA[".$row['str_invoiceno']."]]></str_invoiceno>";
					$ResponseXML .= "<str_crecash><![CDATA[".$row['str_crecash']."]]></str_crecash>";
					$ResponseXML .= "<str_customecode><![CDATA[".$row['str_customecode']."]]></str_customecode>";
					
					$sqlcustomer = mysqli_query($GLOBALS['dbinv'],"Select * from customer_mast where id='".$row['str_customecode']."'") or die(mysqli_error());
					if($rowcustomer = mysqli_fetch_array($sqlcustomer)){
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
							
				
				$sql_data = mysqli_query($GLOBALS['dbinv'],"delete from tmp_inv_data where str_invno='".$_GET['invno']."'") or die(mysqli_error());
				$sql_data = mysqli_query($GLOBALS['dbinv'],"Select * from inv_data where str_invno='".$_GET['invno']."'") or die(mysqli_error());
				while($row = mysqli_fetch_array($sql_data)){
					$sql_itdata = mysqli_query($GLOBALS['dbinv'],"Select * from item_mast where str_code='".$row['str_code']."'") or die(mysqli_error());
					$rowit = mysqli_fetch_array($sql_itdata);
							
							
					$sql_tmp = mysqli_query($GLOBALS['dbinv'],"Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, cur_discount, cur_subtot) values ( '".$row['str_invno']."', '".$row['str_code']."', '".$rowit['str_description']."', ".$row['cur_rate'].", ".$row['cur_qty'].", ".$row['cur_discount'].", ".$row['cur_subtot'].")") or die(mysqli_error());
					
					
						
			
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

$display_val="";
if ($_GET["Command"]=="pass_itno"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			//$_SESSION["bin_item"]=$_GET['itno'];
			
			//echo "Select * from s_mas where STK_NO='".$_GET['itno']."' and BRAND_NAME='".$_GET["brand"]."'";
				
				//$_SESSION['itno']=$_GET['itno'];
			//echo "Select * from s_mas where STK_NO='".$_GET['itno']."'";
				$sql = mysqli_query($GLOBALS['dbinv'],"Select * from s_mas where STK_NO='".$_GET['itno']."' ") or die(mysqli_error());
				if($row = mysqli_fetch_array($sql)){
				
					
					$ResponseXML .= "<STK_NO><![CDATA[".$row['STK_NO']."]]></STK_NO>";
					$ResponseXML .= "<DESCRIPT><![CDATA[".$row['DESCRIPT']."]]></DESCRIPT>";
					$ResponseXML .= "<SELLING><![CDATA[".$row['SELLING']."]]></SELLING>";
					$ResponseXML .= "<PART_NO><![CDATA[".$row['PART_NO']."]]></PART_NO>";
									
					$dt=date('Y-m-d', strtotime(date('Y-m-d'). ' - 90 days'));
$sql1 = mysqli_query($GLOBALS['dbinv'],"Select sum(REC_QTY) as stk from s_purtrn_stores where STK_NO='".$row['STK_NO']."' and CANCEL='0' and SDATE>'".$dt."' ") or die(mysqli_error());
					$row1 = mysqli_fetch_array($sql1);
					
					$mnewstk=0;
					if (is_null($row1["stk"])==false){$mnewstk=$row1["stk"];}
					
					if ($row["QTYINHAND_STORES"]>$row1["stk"]){
						$unsold=$row["QTYINHAND_STORES"]-$mnewstk;
					}
					
					$ResponseXML .= "<unsold><![CDATA[".$unsold."]]></unsold>";
					
					$ResponseXML .= "<SALE01><![CDATA[".number_format($row['SALE01'], 0, ".", ",")."]]></SALE01>";
					$ResponseXML .= "<SALE02><![CDATA[".number_format($row['SALE02'], 0, ".", ",")."]]></SALE02>";
					$ResponseXML .= "<SALE03><![CDATA[".number_format($row['SALE03'], 0, ".", ",")."]]></SALE03>";
					$ResponseXML .= "<SALE04><![CDATA[".number_format($row['SALE04'], 0, ".", ",")."]]></SALE04>";
					$ResponseXML .= "<SALE05><![CDATA[".number_format($row['SALE05'], 0, ".", ",")."]]></SALE05>";
					$ResponseXML .= "<SALE06><![CDATA[".number_format($row['SALE06'], 0, ".", ",")."]]></SALE06>";
					$ResponseXML .= "<SALE07><![CDATA[".number_format($row['SALE07'], 0, ".", ",")."]]></SALE07>";
					$ResponseXML .= "<SALE08><![CDATA[".number_format($row['SALE08'], 0, ".", ",")."]]></SALE08>";
					$ResponseXML .= "<SALE09><![CDATA[".number_format($row['SALE09'], 0, ".", ",")."]]></SALE09>";
					$ResponseXML .= "<SALE10><![CDATA[".number_format($row['SALE10'], 0, ".", ",")."]]></SALE10>";
					$ResponseXML .= "<SALE11><![CDATA[".number_format($row['SALE11'], 0, ".", ",")."]]></SALE11>";
					$ResponseXML .= "<SALE12><![CDATA[".number_format($row['SALE12'], 0, ".", ",")."]]></SALE12>";
					
					$avg=($row['SALE01']+$row['SALE02']+$row['SALE03']+$row['SALE04']+$row['SALE05']+$row['SALE06']+$row['SALE07']+$row['SALE08']+$row['SALE09']+$row['SALE10']+$row['SALE11']+$row['SALE12'])/12;
					$avg=number_format($avg, 0, "", ",");
					
					$ResponseXML .= "<avg><![CDATA[".$avg."]]></avg>";
					
					$ResponseXML .= " <sales_table><![CDATA[ <table>
                                      <tr>
                                         <td width=\"122\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Department</font></td>
                                         <td width=\"101\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Stock</font></td>
                                      </tr>";
					
					$sql2 = mysqli_query($GLOBALS['dbinv'],"Select * from s_stomas_stores") or die(mysqli_error());
					while ($row2 = mysqli_fetch_array($sql2))
					{
						//echo "Select QTYINHAND from s_submas_stores where STO_CODE='".$row2["CODE"]."' and STK_NO='".$row["STK_NO"]."'";
						$sql3 = mysqli_query($GLOBALS['dbinv'],"Select QTYINHAND from s_submas_stores where STO_CODE='".$row2["CODE"]."' and STK_NO='".$row["STK_NO"]."'") or die(mysqli_error());
						if($row3 = mysqli_fetch_array($sql3)){
							$ResponseXML .= "  <tr>
                                               	<td width=\"122\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">".$row2["DESCRIPTION"]."</font></td>
                                               	<td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">".number_format($row3["QTYINHAND"], 0, ".", ",")."</font></td>
                                               </tr>";
						} else {											   
							  $ResponseXML .= "  <tr>
                                               	<td width=\"122\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">".$row2["DESCRIPTION"]."</font></td>
                                               	<td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">0</font></td>
                                               </tr>";
							  
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

function display()
{
	
				
	if ($_GET["department"] == "All"){
		
   		$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_trn_stores where  ( SDATE <  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE") or die(mysqli_error());
		//echo "select * from s_trn where  ( SDATE <  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE";
	} else {
	
   		$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_trn_stores where  ( SDATE <  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEPARTMENT='".$_GET["department"]."' ORDER by SDATE") or die(mysqli_error());
		//echo "select * from s_trn where  ( SDATE <  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEPARTMENT='".$_GET["department"]."' ORDER by SDATE";
	}
	
	
	$M_BAL = 0;
	while($row = mysqli_fetch_array($sql)){
   
   	//===stock out
   		if (($row["LEDINDI"] == "INV") or ($row["LEDINDI"] == "ORC") or ($row["LEDINDI"] == "GINI") or ($row["LEDINDI"] == "ARR") or ($row["LEDINDI"] == "IOU")){
      		$M_BAL = $M_BAL - $row["QTY"];
			
   		}
    
	//====stock in
   		if (($row["LEDINDI"] == "ARN") or ($row["LEDINDI"] == "GINR") or ($row["LEDINDI"] == "CRN") or ($row["LEDINDI"] == "GRN") or ($row["LEDINDI"] == "IIN")){
      		$M_BAL = $M_BAL + $row["QTY"];
   		}
   
   		if ($_GET["department"] == "All"){
        	if (($row["LEDINDI"] == "TRN") and (intval($_GET["department"]) == 1)){
           		$M_BAL = $row["QTY"];
        	}
    	} else {
      		if ($row["LEDINDI"] == "TRN"){
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
	  						<td><font color=\"".$fcolor."\">OP Bal</font></td>
							<td><font color=\"".$fcolor."\">".$_GET["dte_from"]."</font></td>
							<td><font color=\"".$fcolor."\"></font></td>
							<td><font color=\"".$fcolor."\"></font></td>
							<td><font color=\"".$fcolor."\"></font></td>
							<td><font color=\"".$fcolor."\">".number_format($M_BAL, 0, ".", ",")."</font></td>
						</tr>	";    
		    				
    /*  $return_val .= "<tr bgcolor=\"#000000\">
	  						<td>Op Bal</td>
							<td>Date</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>".$M_BAL."</td>";    */              
						
//'..............................................................................................................
	/*if rsusercon!dev = 0 Then
   		If com_dep.Text = "All" Then
      		sql = "select *from s_trn where  dev <= '" & rsusercon!dev & "' and  ( sDATE >=  '" & dtpFdate & "' )and STK_NO='" & Trim(txtFItCode.Text) & "'and LEDINDI<>'GINR' and LEDINDI<>'GINI' and LEDINDI<>'VGI'and LEDINDI<>'VGR' )  ORDER BY sdate"
   		Else
      		sql = "select *from s_trn where  dev <= '" & rsusercon!dev & "' and ( sDATE >=  '" & dtpFdate & "' )and STK_NO='" & Trim(txtFItCode.Text) & "' and DEPARTMENT='" & Trim(Left(com_dep, 5)) & "'ORDER by sdate"
   		End If
	Else*/
   		if ($_GET["department"] == "All") {
		
			$sql = mysqli_query($GLOBALS['dbinv'],"select *from s_trn_stores where  (SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."'and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE") or die(mysqli_error());
			//echo "select *from s_trn where  (SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."'and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE";
   		} else {
		
      		$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_trn_stores where (SDATE >= '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEPARTMENT = '".$_GET["department"]."' ORDER BY SDATE") or die(mysqli_error());
			//echo "select * from s_trn where (SDATE >= '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEPARTMENT = '".$_GET["department"]."' ORDER BY SDATE";
		}
	//End If
	




	$i = 0;
	while($row = mysqli_fetch_array($sql)){
 /*  if ($_GET["department"] == "All"){
      while($row1 = mysqli_fetch_array($sql)){
         if (($row1["LEDINDI"] == "TRN") and (intval($row1["DEPARTMENT"]) > 1)){
            rdPrBin.MoveNext
         } else {
            break;
         }
      }
   }*/
 //  If rdPrBin.EOF Then Exit Do


    	$refno=$row["REFNO"];
		$sdate=$row["SDATE"];
		$doc_type="";
		$fcolor="";
	
	
		if ($row["LEDINDI"]=="INV"){
			$doc_type="Sales Invoice";
			$fcolor="#330066";
		}
	//echo "select lcno from s_purmas where refno='".$row["REFNO"]."'";
		if ($row["LEDINDI"]=="ARN"){
		
			$sql1 = mysqli_query($GLOBALS['dbinv'],"select lcno from s_purmas_stores where refno='".$row["REFNO"]."'") or die(mysqli_error());
			
			if ($row1 = mysqli_fetch_array($sql1)){
				$doc_type="LC No:".$row1["lcno"];
			} else {	
				$doc_type="LC No:";
			}
		
			$fcolor="#ff0000";
		}
	
		if (($row["LEDINDI"]=="GINI") or ($row["LEDINDI"]=="GINR")){
			$doc_type="Internal Stock Transfers";
			$fcolor="#003399";
		}
	
		if ($row["LEDINDI"]=="DGRN"){
			$doc_type="Defective Return";
			$fcolor="#66FF00";
		}
	
		if ($row["LEDINDI"]=="ARR"){
			$doc_type="Purchase Return";
			$fcolor="#CC3300";
		}
	
		if ($row["LEDINDI"]=="GRN"){
			$doc_type="Sales Return";
			$fcolor="#9900FF";
		}
	
		if ($row["LEDINDI"]=="IIN"){
			$doc_type="Stock Adjestment IN";
			$fcolor="#669966";
		}
	
		if ($row["LEDINDI"]=="IOU"){
			$doc_type="Stock Adjestment OUT";
			$fcolor="#CC6666";
		}
	
		if ($row["LEDINDI"]=="ORC"){
			$doc_type="Order Confirmation";
			$fcolor="#0099FF";
		}
	
		if ($row["LEDINDI"]=="TRN"){
			$doc_type="Inventory";
			$fcolor="#996600";
			$M_BAL = $row["QTY"];
   		}
	
	
    	//==stock out
		$qty4="";
    	if (($row["LEDINDI"] == "INV") or ($row["LEDINDI"] == "ORC") or ($row["LEDINDI"] == "GINI") or ($row["LEDINDI"] == "ARR") or ($row["LEDINDI"] == "IOU")) {
       		$qty4 = $row["QTY"];
       		$M_BAL = $M_BAL - $row["QTY"];;
    	}
    
    	//===stock in
		$qty3="";
    	if (($row["LEDINDI"] == "ARN") or ($row["LEDINDI"] == "GINR") or ($row["LEDINDI"] == "CRN") or ($row["LEDINDI"] == "GRN") or ($row["LEDINDI"] == "IIN")){
       		$qty3 = $row["QTY"];
       		$M_BAL = $M_BAL + $row["QTY"];
    	}
    	$qty5 = $M_BAL;
 
 		if ($row["LEDINDI"]=="INV"){
    		$return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><a href=\"\" onClick=\"NewWindow('sales_inv_display.php?refno=".$refno."&trn_type=".$row["LEDINDI"]."','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"><font color=\"".$fcolor."\">".$refno."</font></a></td>
							<td><font color=\"".$fcolor."\">".$sdate."</font></td>
							<td><font color=\"".$fcolor."\">".$doc_type."</font></td>
							<td><font color=\"".$fcolor."\">".$qty3."</font></td>
							<td><font color=\"".$fcolor."\">".$qty4."</font></td>
							<td><font color=\"".$fcolor."\">".$M_BAL."</font></td>
						</tr>	";             
   		} else if (($row["LEDINDI"]=="DGRN") or ($row["LEDINDI"]=="GRN")){
			$return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><a href=\"\" onClick=\"NewWindow('grn_display.php?grn=".$refno."&trn_type=".$row["LEDINDI"]."','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"><font color=\"".$fcolor."\">".$refno."</font></a></td>
							<td><font color=\"".$fcolor."\">".$sdate."</font></td>
							<td><font color=\"".$fcolor."\">".$doc_type."</font></td>
							<td><font color=\"".$fcolor."\">".$qty3."</font></td>
							<td><font color=\"".$fcolor."\">".$qty4."</font></td>
							<td><font color=\"".$fcolor."\">".$M_BAL."</font></td>
						</tr>	";             
		} else if (($row["LEDINDI"]=="GINR") or ($row["LEDINDI"]=="GINI")){
			$return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><font color=\"".$fcolor."\"><a href=\"\" onClick=\"NewWindow('gin_display.php?refno=".$refno."&trn_type=".$row["LEDINDI"]."','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">".$refno."</a></font></td>
							<td><font color=\"".$fcolor."\">".$sdate."</font></td>
							<td><font color=\"".$fcolor."\">".$doc_type."</font></td>
							<td><font color=\"".$fcolor."\">".$qty3."</font></td>
							<td><font color=\"".$fcolor."\">".$qty4."</font></td>
							<td><font color=\"".$fcolor."\">".$M_BAL."</font></td>
						</tr>	";     
		}	else {
			$return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><font color=\"".$fcolor."\">".$refno."</font></td>
							<td><font color=\"".$fcolor."\">".$sdate."</font></td>
							<td><font color=\"".$fcolor."\">".$doc_type."</font></td>
							<td><font color=\"".$fcolor."\">".$qty3."</font></td>
							<td><font color=\"".$fcolor."\">".$qty4."</font></td>
							<td><font color=\"".$fcolor."\">".$M_BAL."</font></td>
						</tr>	";     
		}				
    	$i = $i + 1;
	}
	
	
						
						 $i=1;
   while ($i<15){
   		$return_val .= "<tr >
	  						<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>	"; 
						$i=$i+1;     
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
						
	
	if ($_GET["department"] == "All"){
	
		$sql = mysqli_query($GLOBALS['dbinv'],"select * from vieword where  ( SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and cancel=0 ") or die(mysqli_error());
		//echo "select * from vieword where  ( SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and cancel=0 ";
		//$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_ordmas where  SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and cancel=0 ") or die(mysqli_error());
	
	} else {
  	
		$sql = mysqli_query($GLOBALS['dbinv'],"select * from vieword where  ( SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEP_CODE='".$_GET["department"]."' AND cancel=0 order by SDATE") or die(mysqli_error());
		//echo "select * from vieword where  ( SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEP_CODE='".$_GET["department"]."' AND cancel=0 order by SDATE";
	
   }
   while ($row = mysqli_fetch_array($sql)){
   		$return_val .= "<tr >
	  						<td>".$row["REFNO"]."</td>
							<td>".$row["SDATE"]."</td>
							<td>".$row["S_date"]."</td>
							<td>".number_format($row["ORD_QTY"], 0, ".", ",")."</td>
							<td>".$row["LC_No"]."</td>
							<td>".$row["SUP_NAME"]."</td>
						</tr>	";      
   }
   $i=1;
   while ($i<15){
   		$return_val .= "<tr >
	  						<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>	"; 
						$i=$i+1;     
   }
	
	$return_val .= "   </table>]]></ord_table>";
	 $GLOBALS[$display_val]=$return_val;
	//return $return_val;
}

/*if ($_GET["Command"]=="pass_bincard"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			
			//echo "Select * from s_mas where STK_NO='".$_GET['itno']."' and BRAND_NAME='".$_GET["brand"]."'";
				$sql = mysqli_query($GLOBALS['dbinv'],"Select * from s_trn where SDATE= STK_NO='".$_GET['itno']."' ") or die(mysqli_error());
				if($row = mysqli_fetch_array($sql)){
				
					
					$ResponseXML .= "<STK_NO><![CDATA[".$row['STK_NO']."]]></STK_NO>";


}*/



if ($_GET["Command"]=="pass_itno1"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			
			//echo "Select * from s_mas where STK_NO='".$_GET['itno']."' and BRAND_NAME='".$_GET["brand"]."'";
				
				//$_SESSION['itno']=$_GET['itno'];
			//echo "Select * from s_mas where STK_NO='".$_SESSION['itno']."'";
				$sql = mysqli_query($GLOBALS['dbinv'],"Select * from s_mas where STK_NO='".$_GET['itno']."' ") or die(mysqli_error());
				if($row = mysqli_fetch_array($sql)){
				
					
					$ResponseXML .= "<STK_NO><![CDATA[".$row['STK_NO']."]]></STK_NO>";
					$ResponseXML .= "<DESCRIPT><![CDATA[".$row['DESCRIPT']."]]></DESCRIPT>";
					$ResponseXML .= "<SELLING><![CDATA[".$row['SELLING']."]]></SELLING>";
					$ResponseXML .= "<PART_NO><![CDATA[".$row['PART_NO']."]]></PART_NO>";
									
					$dt=date('Y-m-d', strtotime(date('Y-m-d'). ' - 90 days'));
					$sql1 = mysqli_query($GLOBALS['dbinv'],"Select sum(REC_QTY) as stk from s_purtrn_stores where STK_NO='".$row['STK_NO']."' and CANCEL='0' and SDATE>'".$dt."' ") or die(mysqli_error());
					$row1 = mysqli_fetch_array($sql1);
					
					$mnewstk=0;
					if (is_null($row1["stk"])==false){$mnewstk=$row1["stk"];}
					
					if ($row["QTYINHAND_STORES"]>$row1["stk"]){
						$unsold=$row["QTYINHAND_STORES"]-$row1["stk"];
					}
					
					$ResponseXML .= "<unsold><![CDATA[".$unsold."]]></unsold>";
					
					$ResponseXML .= "<SALE01><![CDATA[".number_format($row['SALE01'], 0, ".", ",")."]]></SALE01>";
					$ResponseXML .= "<SALE02><![CDATA[".number_format($row['SALE02'], 0, ".", ",")."]]></SALE02>";
					$ResponseXML .= "<SALE03><![CDATA[".number_format($row['SALE03'], 0, ".", ",")."]]></SALE03>";
					$ResponseXML .= "<SALE04><![CDATA[".number_format($row['SALE04'], 0, ".", ",")."]]></SALE04>";
					$ResponseXML .= "<SALE05><![CDATA[".number_format($row['SALE05'], 0, ".", ",")."]]></SALE05>";
					$ResponseXML .= "<SALE06><![CDATA[".number_format($row['SALE06'], 0, ".", ",")."]]></SALE06>";
					$ResponseXML .= "<SALE07><![CDATA[".number_format($row['SALE07'], 0, ".", ",")."]]></SALE07>";
					$ResponseXML .= "<SALE08><![CDATA[".number_format($row['SALE08'], 0, ".", ",")."]]></SALE08>";
					$ResponseXML .= "<SALE09><![CDATA[".number_format($row['SALE09'], 0, ".", ",")."]]></SALE09>";
					$ResponseXML .= "<SALE10><![CDATA[".number_format($row['SALE10'], 0, ".", ",")."]]></SALE10>";
					$ResponseXML .= "<SALE11><![CDATA[".number_format($row['SALE11'], 0, ".", ",")."]]></SALE11>";
					$ResponseXML .= "<SALE12><![CDATA[".number_format($row['SALE12'], 0, ".", ",")."]]></SALE12>";
					
					$avg=($row['SALE01']+$row['SALE02']+$row['SALE03']+$row['SALE04']+$row['SALE05']+$row['SALE06']+$row['SALE07']+$row['SALE08']+$row['SALE09']+$row['SALE10']+$row['SALE11']+$row['SALE12'])/12;
					$avg=number_format($avg, 0, "", ",");
					
					$ResponseXML .= "<avg><![CDATA[".$avg."]]></avg>";
					
					$ResponseXML .= " <sales_table><![CDATA[ <table>
                                      <tr>
                                         <td width=\"122\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Department</font></td>
                                         <td width=\"101\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Stock</font></td>
                                      </tr>";
					
					$sql2 = mysqli_query($GLOBALS['dbinv'],"Select * from s_stomas_stores") or die(mysqli_error());
					while ($row2 = mysqli_fetch_array($sql2))
					{
						//echo "Select QTYINHAND from s_submas where STO_CODE='".$row2["CODE"]."' and STK_NO='".$row["STK_NO"]."'";
						$sql3 = mysqli_query($GLOBALS['dbinv'],"Select QTYINHAND from s_submas_stores where STO_CODE='".$row2["CODE"]."' and STK_NO='".$row["STK_NO"]."'") or die(mysqli_error());
						if($row3 = mysqli_fetch_array($sql3)){
							$ResponseXML .= "  <tr>
                                               	<td width=\"122\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">".$row2["DESCRIPTION"]."</font></td>
                                               	<td width=\"101\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">".number_format($row3["QTYINHAND"], 0, ".", ",")."</font></td>
                                               </tr>";
						} else {											   
							  $ResponseXML .= "  <tr>
                                               	<td width=\"122\" bgcolor=\"#333333\"><font color=\"#FFFFFF\">".$row2["DESCRIPTION"]."</font></td>
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

function display1()
{
	
				
	if ($_GET["department"] == "All"){
		
   		$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_trn_stores where  ( SDATE <  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE") or die(mysqli_error());
		//echo "select * from s_trn where  ( SDATE <  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE";
	} else {
	
   		$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_trn_stores where  ( SDATE <  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEPARTMENT='".$_GET["department"]."' ORDER by SDATE") or die(mysqli_error());
		//echo "select * from s_trn where  ( SDATE <  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEPARTMENT='".$_GET["department"]."' ORDER by SDATE";
	}
	
	
	$M_BAL = 0;
	while($row = mysqli_fetch_array($sql)){
   
   	//===stock out
   		if (($row["LEDINDI"] == "INV") or ($row["LEDINDI"] == "ORC") or ($row["LEDINDI"] == "GINI") or ($row["LEDINDI"] == "ARR") or ($row["LEDINDI"] == "IOU")){
      		$M_BAL = $M_BAL - $row["QTY"];
			
   		}
    
	//====stock in
   		if (($row["LEDINDI"] == "ARN") or ($row["LEDINDI"] == "GINR") or ($row["LEDINDI"] == "CRN") or ($row["LEDINDI"] == "GRN") or ($row["LEDINDI"] == "IIN")){
      		$M_BAL = $M_BAL + $row["QTY"];
   		}
   
   		if ($_GET["department"] == "All"){
        	if (($row["LEDINDI"] == "TRN") and (intval($_GET["department"]) == 1)){
           		$M_BAL = $row["QTY"];
        	}
    	} else {
      		if ($row["LEDINDI"] == "TRN"){
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
	  						<td><font color=\"".$fcolor."\">OP Bal</font></td>
							<td><font color=\"".$fcolor."\">".$_GET["dte_from"]."</font></td>
							<td><font color=\"".$fcolor."\"></font></td>
							<td><font color=\"".$fcolor."\"></font></td>
							<td><font color=\"".$fcolor."\"></font></td>
							<td><font color=\"".$fcolor."\">".number_format($M_BAL, 0, ".", ",")."</font></td>
						</tr>	";        				
    /*  $return_val .= "<tr bgcolor=\"#000000\">
	  						<td>Op Bal</td>
							<td>Date</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>".$M_BAL."</td>";    */              
						
//'..............................................................................................................
	/*if rsusercon!dev = 0 Then
   		If com_dep.Text = "All" Then
      		sql = "select *from s_trn where  dev <= '" & rsusercon!dev & "' and  ( sDATE >=  '" & dtpFdate & "' )and STK_NO='" & Trim(txtFItCode.Text) & "'and LEDINDI<>'GINR' and LEDINDI<>'GINI' and LEDINDI<>'VGI'and LEDINDI<>'VGR' )  ORDER BY sdate"
   		Else
      		sql = "select *from s_trn where  dev <= '" & rsusercon!dev & "' and ( sDATE >=  '" & dtpFdate & "' )and STK_NO='" & Trim(txtFItCode.Text) & "' and DEPARTMENT='" & Trim(Left(com_dep, 5)) & "'ORDER by sdate"
   		End If
	Else*/
   		if ($_GET["department"] == "All") {
		
			$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_trn_stores where  (SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."'and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE") or die(mysqli_error());
		//	echo "select *from s_trn where  (SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."'and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE";
   		} else {
		
      		$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_trn_stores where (SDATE >= '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEPARTMENT = '".$_GET["department"]."' ORDER BY SDATE") or die(mysqli_error());
			//echo "select * from s_trn where (SDATE >= '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEPARTMENT = '".$_GET["department"]."' ORDER BY SDATE";
		}
	//End If
	




	$i = 0;
	while($row = mysqli_fetch_array($sql)){
 /*  if ($_GET["department"] == "All"){
      while($row1 = mysqli_fetch_array($sql)){
         if (($row1["LEDINDI"] == "TRN") and (intval($row1["DEPARTMENT"]) > 1)){
            rdPrBin.MoveNext
         } else {
            break;
         }
      }
   }*/
 //  If rdPrBin.EOF Then Exit Do


    	$refno=$row["REFNO"];
		$sdate=$row["SDATE"];
		$doc_type="";
		$fcolor="";
	
	
		if ($row["LEDINDI"]=="INV"){
			$doc_type="Sales Invoice";
			$fcolor="#330066";
		}
	//echo "select lcno from s_purmas where refno='".$row["REFNO"]."'";
		if ($row["LEDINDI"]=="ARN"){
		
			$sql1 = mysqli_query($GLOBALS['dbinv'],"select lcno from s_purmas_stores where refno='".$row["REFNO"]."'") or die(mysqli_error());
			
			if ($row1 = mysqli_fetch_array($sql1)){
				$doc_type="LC No:".$row1["lcno"];
			} else {	
				$doc_type="LC No:";
			}
		
			$fcolor="#FF0000";
		}
	
		if (($row["LEDINDI"]=="GINI") or ($row["LEDINDI"]=="GINR")){
			$doc_type="Internal Stock Transfers";
			$fcolor="#003399";
		}
	
		if ($row["LEDINDI"]=="DGRN"){
			$doc_type="Defective Return";
			$fcolor="#66FF00";
		}
	
		if ($row["LEDINDI"]=="ARR"){
			$doc_type="Purchase Return";
			$fcolor="#33CCFF";
		}
	
		if ($row["LEDINDI"]=="GRN"){
			$doc_type="Sales Return";
			$fcolor="#9900FF";
		}
	
		if ($row["LEDINDI"]=="IIN"){
			$doc_type="Stock Adjestment IN";
			$fcolor="#669966";
		}
	
		if ($row["LEDINDI"]=="IOU"){
			$doc_type="Stock Adjestment OUT";
			$fcolor="#CC6666";
		}
	
		if ($row["LEDINDI"]=="ORC"){
			$doc_type="Order Confirmation";
			$fcolor="#0099FF";
		}
	
		if ($row["LEDINDI"]=="TRN"){
			$doc_type="Inventory";
			$fcolor="#996600";
			$M_BAL = $row["QTY"];
   		}
	
	
    	//==stock out
		$qty4="";
    	if (($row["LEDINDI"] == "INV") or ($row["LEDINDI"] == "ORC") or ($row["LEDINDI"] == "GINI") or ($row["LEDINDI"] == "ARR") or ($row["LEDINDI"] == "IOU")) {
       		$qty4 = $row["QTY"];
       		$M_BAL = $M_BAL - $row["QTY"];;
    	}
    
    	//===stock in
		$qty3="";
    	if (($row["LEDINDI"] == "ARN") or ($row["LEDINDI"] == "GINR") or ($row["LEDINDI"] == "CRN") or ($row["LEDINDI"] == "GRN") or ($row["LEDINDI"] == "IIN")){
       		$qty3 = $row["QTY"];
       		$M_BAL = $M_BAL + $row["QTY"];
    	}
    	$qty5 = $M_BAL;
 
    /*	$return_val .= "<tr  bgcolor=\"#ffffff\">
	  						<td><font color=\"".$fcolor."\">".$refno."</font></td>
							<td><font color=\"".$fcolor."\">".$sdate."</font></td>
							<td><font color=\"".$fcolor."\">".$doc_type."</font></td>
							<td><font color=\"".$fcolor."\">".number_format($qty3, 0, ".", ",")."</font></td>
							<td><font color=\"".$fcolor."\">".number_format($qty4, 0, ".", ",")."</font></td>
							<td><font color=\"".$fcolor."\">".number_format($M_BAL, 0, ".", ",")."</font></td>
						</tr>	";  */
						
		if ($row["LEDINDI"]=="INV"){
    		$return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><a href=\"\" onClick=\"NewWindow('sales_inv_display.php?refno=".$refno."&trn_type=".$row["LEDINDI"]."','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"><font color=\"".$fcolor."\">".$refno."</font></a></td>
							<td><font color=\"".$fcolor."\">".$sdate."</font></td>
							<td><font color=\"".$fcolor."\">".$doc_type."</font></td>
							<td><font color=\"".$fcolor."\">".$qty3."</font></td>
							<td><font color=\"".$fcolor."\">".$qty4."</font></td>
							<td><font color=\"".$fcolor."\">".$M_BAL."</font></td>
						</tr>	";             
   		} else if (($row["LEDINDI"]=="DGRN") or ($row["LEDINDI"]=="GRN")){
			$return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><a href=\"\" onClick=\"NewWindow('grn_display.php?grn=".$refno."&trn_type=".$row["LEDINDI"]."','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"><font color=\"".$fcolor."\">".$refno."</font></a></td>
							<td><font color=\"".$fcolor."\">".$sdate."</font></td>
							<td><font color=\"".$fcolor."\">".$doc_type."</font></td>
							<td><font color=\"".$fcolor."\">".$qty3."</font></td>
							<td><font color=\"".$fcolor."\">".$qty4."</font></td>
							<td><font color=\"".$fcolor."\">".$M_BAL."</font></td>
						</tr>	";             
		} else if (($row["LEDINDI"]=="GINR") or ($row["LEDINDI"]=="GINI")){
			$return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><font color=\"".$fcolor."\"><a href=\"\" onClick=\"NewWindow('gin_display.php?refno=".$refno."&trn_type=".$row["LEDINDI"]."','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">".$refno."</a></font></td>
							<td><font color=\"".$fcolor."\">".$sdate."</font></td>
							<td><font color=\"".$fcolor."\">".$doc_type."</font></td>
							<td><font color=\"".$fcolor."\">".$qty3."</font></td>
							<td><font color=\"".$fcolor."\">".$qty4."</font></td>
							<td><font color=\"".$fcolor."\">".$M_BAL."</font></td>
						</tr>	";     
		}	else {
			$return_val .= "<tr  bgcolor=\"#ffffff\" >
	  						<td><font color=\"".$fcolor."\">".$refno."</font></td>
							<td><font color=\"".$fcolor."\">".$sdate."</font></td>
							<td><font color=\"".$fcolor."\">".$doc_type."</font></td>
							<td><font color=\"".$fcolor."\">".$qty3."</font></td>
							<td><font color=\"".$fcolor."\">".$qty4."</font></td>
							<td><font color=\"".$fcolor."\">".$M_BAL."</font></td>
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
						
	
	if ($_GET["department"] == "All"){
	
		$sql = mysqli_query($GLOBALS['dbinv'],"select * from vieword where  ( SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and cancel=0 ") or die(mysqli_error());
		//echo "select * from vieword where  ( SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and cancel=0 ";
		//$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_ordmas where  SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and cancel=0 ") or die(mysqli_error());
	
	} else {
  	
		$sql = mysqli_query($GLOBALS['dbinv'],"select * from vieword where  ( SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEP_CODE='".$_GET["department"]."' AND cancel=0 order by SDATE") or die(mysqli_error());
		//echo "select * from vieword where  ( SDATE >=  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEP_CODE='".$_GET["department"]."' AND cancel=0 order by SDATE";
	
   }
   while ($row = mysqli_fetch_array($sql)){
   		$return_val .= "<tr >
	  						<td>".$row["REFNO"]."</td>
							<td>".$row["SDATE"]."</td>
							<td>".$row["SDATE"]."</td>
							<td>".number_format($row["ORD_QTY"], 0, ".", ",")."</td>
							<td>".$row["LC_No"]."</td>
							<td>".$row["SUP_NAME"]."</td>
						</tr>	";      
   }
	
	$return_val .= "   </table>]]></ord_table>";
	 $GLOBALS[$display_val]=$return_val;
	//return $return_val;
}

if ($_GET["Command"]=="pass_assignbrand"){
	$_SESSION["brand"]=$_GET["brand"];
	$_SESSION["department"]=$_GET["department"];
	
}
?>
