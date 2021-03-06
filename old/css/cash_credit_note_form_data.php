<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
	
	
	if ($_GET["Command"]=="chk_ccrnf"){
		
		$_SESSION["CURRENT_DOC"] = "66";     //document ID
    //VIEW_DOC = True      '  view current document
     	$_SESSION["FEED_DOC"] = "true";      //   save  current document
    //MOD_DOC = True       '   delete   current document
    //PRINT_DOC = True     ' get additional print   of  current document
    //PRICE_EDIT=true      ' edit selling price
    	$_SESSION["CHECK_USER"] = "true";    // check user permission again
    
    
    
	
	}
		
		
		
		if($_GET["Command"]=="add_address")
		{
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;
			
			
	/*		$sql="Select * from tmp_army_no where edu= '".$_GET['edu']."'";
			$result =$db->RunQuery($sql);
			if($row = mysql_fetch_array($result)){
				$ResponseXML .= "exist";
				
				
				
			}	else {*/
			
		//	$ResponseXML .= "";
			//$ResponseXML .= "<ArmyDetails>";
			
		/*	$sql1="Select * from mas_educational_qualifications where str_Educational_Qualification= '".$_GET['edu']."'";
			$result1 =$db->RunQuery($sql1);
			$row1 = mysql_fetch_array($result1);
			$ResponseXML .=  $row1["int_Educational_Qulifications"];*/
			
			$sqlt="Select * from customer_mast where id ='".$_GET['customerid']."'";
			
			$resultt =$db->RunQuery($sqlt);
			if ($rowt = mysql_fetch_array($resultt)){
				echo $rowt["str_address"];
			}
			
			
				
			
	}
	
			
		if($_GET["Command"]=="new_inv")
		{
			
			$_SESSION["print"]=0;
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			$_SESSION["MonthView1"]="";
			
			$sql="Select CCRNNO from invpara";
			
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CCRNNO"];
			$lenth=strlen($tmpinvno);
			//txtrefno = "CCRN\" + dnINV.conINV.DefaultDatabase + "\" + Right("0000" + Trim(Str(rsinvpara.Fields("CCRNNO"))), 4)
			$invno=trim("CCRN/".$_SESSION['company']."/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["invno"]=$invno;
			
			$sql="Select CCRNNO from tmpinvpara";
			
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CCRNNO"];
			$lenth=strlen($tmpinvno);
			$invno1=trim("CCRN/".$_SESSION['company']."/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["credit_note_form"]=$invno1;
			
			$sql="update tmpinvpara set CCRNNO=CCRNNO+1";
			$result =$db->RunQuery($sql);
			
			$sql_tmpinst= " delete from tmp_credit_note_form where crn_form_no='".$invno."'";
			$result_tmpinst =$db->RunQuery($sql_tmpinst);
			
			echo $invno;	
			
		}
	
if ($_GET["Command"]=="set_check"){	
	
        //mrefno = Trim(txtrefno)
		$sql= "Select * from s_crnfrm where Refno = '" . $_GET["txtrefno"] . "'";
		$result =$db->RunQuery($sql);
		if ($row = mysql_fetch_array($result)){
			$sql1= "update s_crnfrm set Checked = '" . $_SESSION['UserName'] . "',Check_date = '" . date("Y-m-d") . "' where Refno = '" . $_GET["txtrefno"] . "'";
			$result1 =$db->RunQuery($sql1);
		}
	
       echo "Recordes are marked as Checked";
   
}

if ($_GET["Command"]=="search_inv"){	
$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	include_once("connection.php");
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Invoice Date</font></td>
   							</tr>";
                       
						if ($_GET["mstatus"]=="invno"){ 
							$letters = $_GET['invno']; 
						  if ($_SESSION["slected"]=="all"){
						  	$sql = mysql_query("select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' and cancell = '0' and flag = 'CCRN' order BY Refno desc limit 50") or die(mysql_error());
							
						  } else if ($_SESSION["slected"]=="locked"){
						  	$sql = mysql_query("select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' cancell = '0' and Lock1='1' and flag = 'CCRN' order BY Refno desc limit 50") or die(mysql_error());
							
		
						  } else if ($_SESSION["slected"]=="pending"){
						  	$sql = mysql_query("select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' cancell = '0' and Lock1='0' and flag = 'CCRN' order BY Refno desc limit 50") or die(mysql_error());
							
		
						  }	
	 					}
							
							
													
						
							while($row = mysql_fetch_array($sql)){
								$cuscode = $row["CODE"];
								$stname = $_GET["stname"];
							$ResponseXML .= "<tr>               
                              <td onclick=\"invno_check('".$row['Refno']."', '".$_GET['stname']."');\">".$row['Refno']."</a></td>
                              <td onclick=\"invno_check('".$row['Refno']."', '".$_GET['stname']."');\">".$row["Code"]."</a></td>
                              <td onclick=\"invno_check('".$row['Refno']."', '".$_GET['stname']."');\">".$row['Amount']."</a></td>
                              
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
	}			
	
			
if ($_GET["Command"]=="select_list"){
	
	$_SESSION["slected"]=$_GET["mstatus"];
	if ($_GET["mstatus"]=="all"){
		$sql = "select Refno, Code, Amount   from s_crnfrm where cancell = '0' and flag = 'CCRN' order BY Refno desc limit 50";
	} else if ($_GET["mstatus"]=="locked"){
		$sql = "select Refno, Code, Amount   from s_crnfrm where cancell = '0' and Lock1='1' and flag = 'CCRN' order BY Refno desc limit 50";
		
	} else if ($_GET["mstatus"]=="pending"){
		$sql = "select Refno, Code, Amount   from s_crnfrm where cancell = '0' and Lock1='0' and flag = 'CCRN' order BY Refno desc limit 50";	
		
	}	
	
							//}
							echo "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Invoice Date</font></td>
   </tr>";
								
							//echo $sql;
							$result =$db->RunQuery($sql);
							while($row = mysql_fetch_array($result)){
							
							echo "<tr>               
                              <td onclick=\"invno_check('".$row['Refno']."', '".$_GET['stname']."');\">".$row['Refno']."</a></td>
                              <td onclick=\"invno_check('".$row['Refno']."', '".$_GET['stname']."');\">".$row["Code"]."</a></td>
                              <td onclick=\"invno_check('".$row['Refno']."', '".$_GET['stname']."');\">".$row['Amount']."</a></td>
                              
                            </tr>";
							}
							 echo "</table>";
                    
}
	
if ($_GET["Command"]=="set_session_month"){
	$_SESSION["MonthView1"]=$_GET["MonthView1"];
	echo $_SESSION["MonthView1"];
}	

if ($_GET["Command"]=="pass_crn_form"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$sql_tmpinst= " delete from tmp_credit_note_form where crn_form_no='".$_GET["txtrefno"]."' and inv_no='".$_GET["invno"]."'";
	$result_tmpinst =$db->RunQuery($sql_tmpinst);
	
	$ResponseXML = "<salesdetails>";		
	
	
			
	$i = 1;
    $tot = 0;
   // Do While MSFlexGrid1.TextMatrix(i, 1) <> ""
        $mqty = 0;
        $sql_rscrn= " Select * from s_crnfrmtrn where Inv_no = '" .$_GET["invno"]. "' and Flag = 'ACRN'";
        $result_rscrn =$db->RunQuery($sql_rscrn);
		if ($row_rscrn = mysql_fetch_array($result_rscrn)){
			
			 	
		
			$ResponseXML .= "<msg><![CDATA[Sorry this Invoice Incentive Already Paid]]></msg>";	
			   
        } else {
        
       
        	$sql_RSINVO= "Select * from s_invo  where REF_NO =  '" .$_GET["invno"]. "'";
			$result_RSINVO =$db->RunQuery($sql_RSINVO);
        	$sql_rssalma= "Select * from s_salma where REF_NO = '" .$_GET["invno"]. "'";
			$result_rssalma =$db->RunQuery($sql_rssalma);
        	if ($row_rssalma = mysql_fetch_array($result_rssalma)){
				
			
            	$sql_rsqty= " select * from view_salma_sinvo where REF_NO = '" . trim($row_rssalma["REF_NO"]) . "'";
				$result_rsqty =$db->RunQuery($sql_rsqty);
                while ($row_rsqty = mysql_fetch_array($result_rsqty)){
                    $mqty = $mqty + $row_rsqty["QTY"];
                    
                }
				
				
				$sql_tmpinst= " insert into tmp_credit_note_form (crn_form_no, Inv_date, inv_no, Amount, disc, Qty,  Brands, tmp_no) values ('".$_GET["txtrefno"]."', '".$row_rssalma['SDATE']."', '".$_GET["invno"]."', ".$row_rssalma['GRAND_TOT'].", ".$row_rssalma['DIS'].", ".$mqty.", '".$row_rssalma['Brand']."' , '".$_SESSION["credit_note_form"]."')";
				//echo $sql_tmpinst;
        		$result_tmpinst =$db->RunQuery($sql_tmpinst);
			
				
        	}
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Incentive (%)</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Incentive Val</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Brand</font></td>
                             
                            </tr>";		
			
			$Incen_val_val=0;
			
			$sql= "Select * from tmp_credit_note_form where tmp_no = '" .$_SESSION["credit_note_form"]. "'";
			$result =$db->RunQuery($sql);
        	while ($row = mysql_fetch_array($result)){
			
						$Inv_date="Inv_date".$i;
						$inv_no="inv_no".$i;
						$Amount="Amount".$i;
						$disc="disc".$i;
						$Qty="Qty".$i;
						$Incen_per="Incen_per".$i;
						$Incen_val="Incen_val".$i;
						$Brands="Brands".$i;
						
					$ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=".$Inv_date."  disabled id=".$Inv_date." value='".$row['Inv_date']."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=".$inv_no."  disabled id=".$inv_no." value='".$row["inv_no"]."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Amount."  disabled id=".$Amount." value=".$row['Amount']." class=\"txtbox\"/></td>
							 
							 <td ><input type=\"text\" size=\"10\" name=".$disc."  disabled id=".$disc." value=".$row['disc']." class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Qty."  disabled id=".$Qty." value=".$row['Qty']." class=\"txtbox\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=".$Incen_per."  onBlur=\"cal_incentive('".$i."')\" id=".$Incen_per." value='".$row['Incen_per']."' class=\"txtbox\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=".$Incen_val."  disabled id=".$Incen_val." value='".$row['Incen_val']."' class=\"txtbox\"/></td>
            	            	
            	<td ><input type=\"text\" size=\"10\" name=".$Brands."  disabled id=".$Brands." value=".$row['Brands']." class=\"txtbox\"/></td>
				
				<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row["inv_no"]."  name=".$row["inv_no"]." onClick=\"del_item('".$row["inv_no"]."');\"></td></tr>"; 		
				
				if ((is_null($row['Incen_val'])==false) and ($row['Incen_val']!="")){
					$Incen_val_val=$Incen_val_val+$row['Incen_val'];
				}	
				$i=$i+1;
			}
							
			$ResponseXML .= "   </table>]]></sales_table>";
			$ResponseXML .= "<Incen_val><![CDATA[".$Incen_val_val."]]></Incen_val>";	
			$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
			$ResponseXML .= "<msg><![CDATA[]]></msg>";						
			
		}	 	
			
        
    //Loop
    //txttot = Format(tot, "######.00")		
			
		
		$ResponseXML .= "</salesdetails>";		

		echo $ResponseXML;	
			
	
}
	
if ($_GET["Command"]=="invno_check"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$sql_tmpinst= " delete from tmp_credit_note_form where crn_form_no='".$_GET["txtrefno"]."' and inv_no='".$_GET["invno"]."'";
	$result_tmpinst =$db->RunQuery($sql_tmpinst);
	
	$ResponseXML = "<salesdetails>";		
	
	
			
	$i = 1;
    $tot = 0;
   // Do While MSFlexGrid1.TextMatrix(i, 1) <> ""
        $mqty = 0;
        $sql_rscrn= " Select * from s_crnfrm where Refno = '" .$_GET["invno"]. "'";
        $result_rscrn =$db->RunQuery($sql_rscrn);
		if ($row_rscrn = mysql_fetch_array($result_rscrn)){
			
			$_SESSION["credit_note_form"]=$row_rscrn["tmp_no"];
			
			if (is_null($row_rscrn["Sdate"])==false) { 
				$ResponseXML .= "<DTPicker1><![CDATA[".$row_rscrn["Sdate"]."]]></DTPicker1>";	
			}
			if (is_null($row_rscrn["Code"])==false) { 
				$ResponseXML .= "<txt_cuscode><![CDATA[".$row_rscrn["Code"]."]]></txt_cuscode>";	
			}
			$sql2= " Select * from vendor where CODE = '" .$row_rscrn["Code"]. "'";
        	$result2 =$db->RunQuery($sql2);
			$row2 = mysql_fetch_array($result2);
			if (is_null($row2["NAME"])==false) { 
				$ResponseXML .= "<txt_cusname><![CDATA[".$row2["NAME"]."]]></txt_cusname>";	
			}
			
			if (is_null($row_rscrn["Mon"])==false) { 
				$ResponseXML .= "<MonthView1><![CDATA[".$row_rscrn["Mon"]."]]></MonthView1>";	
			}
			if (trim($row_rscrn["Checked"])=="A") { 
				$ResponseXML .= "<txt_check><![CDATA[]]></txt_check>";	
			} else {
				$ResponseXML .= "<txt_check><![CDATA[".$row_rscrn["Checked"]."]]></txt_check>";	
			}
			
			if (is_null($row_rscrn["Check_date"])==false) { 
				$ResponseXML .= "<DTPicker2><![CDATA[".$row_rscrn["Check_date"]."]]></DTPicker2>";	
			}
			if (is_null($row_rscrn["Approved"])==false) { 
				$ResponseXML .= "<txt_auth><![CDATA[".$row_rscrn["Approved"]."]]></txt_auth>";	
			}	
			
			if (is_null($row_rscrn["App_date"])==false) { 
				$ResponseXML .= "<DTPicker5><![CDATA[".$row_rscrn["App_date"]."]]></DTPicker5>";	
			}
			if (is_null($row_rscrn["Sal_ex"])==false) { 
				$sql1= " Select * from s_salrep where REPCODE = '" .$row_rscrn["Sal_ex"]. "'";
        		$result1 =$db->RunQuery($sql1);
				if ($row1 = mysql_fetch_array($result1)){
					$ResponseXML .= "<Com_rep><![CDATA[".$row1["REPCODE"]." ".$row1["Name"]."]]></Com_rep>";	
				}
			}
			
			if (is_null($row_rscrn["Refno"])==false) { 
				$ResponseXML .= "<txtrefno><![CDATA[".$row_rscrn["Refno"]."]]></txtrefno>";	
			}
			
			if (is_null($row_rscrn["Remark"])==false) { 
				$ResponseXML .= "<txtremark><![CDATA[".$row_rscrn["Remark"]."]]></txtremark>";	
			}	
    			
    		if ($row_rscrn["Checked"]=="A") { 
				$ResponseXML .= "<cmd_check><![CDATA[Check]]></cmd_check>";	
			} else {
				$ResponseXML .= "<cmd_check><![CDATA[Checked]]></cmd_check>";
			}
			
			if (is_null($row_rscrn["Approved"])==true) { 
				$ResponseXML .= "<cmd_auth><![CDATA[Autorize]]></cmd_auth>";	
			} else {
				$ResponseXML .= "<cmd_auth><![CDATA[Autorized]]></cmd_auth>";
			}
			
			$ResponseXML .= "<txttot><![CDATA[".$row_rscrn["Amount"]."]]></txttot>";	
			if ($row_rscrn["Lock1"]=="1"){
				$ResponseXML .= "<lbllock><![CDATA[Locked]]></lbllock>";	
			} else {
				$ResponseXML .= "<lbllock><![CDATA[]]></lbllock>";	
			}	
			
			
			$sql= "delete from tmp_credit_note_form where tmp_no = '" .$_SESSION["credit_note_form"]. "'";
			//echo $sql;
			$result =$db->RunQuery($sql);
   
        
       
        	$sql_rscrntrn= "Select * from s_crnfrmtrn where Refno = '" . $_GET["invno"] . "'";
			$result_rscrntrn =$db->RunQuery($sql_rscrntrn);
        	if ($row_rscrntrn = mysql_fetch_array($result_rscrntrn)){
				
				if ((is_null($row_rscrntrn['disc'])==false) and ($row_rscrntrn['disc']!="")){
					$disc=$row_rscrntrn['disc'];
				} else {
					$disc=0;
				}
								
				$sql_tmpinst= " insert into tmp_credit_note_form (crn_form_no, Inv_date, inv_no, Amount, disc, Qty, Incen_per, Incen_val, Brands, tmp_no) values ('".$_GET["invno"]."', '".$row_rscrntrn['Inv_date']."', '".$row_rscrntrn["Inv_no"]."', '".$row_rscrntrn['Amount']."', ".$disc.", ".$row_rscrntrn["Qty"].", ".$row_rscrntrn["Incen_per"].", ".$row_rscrntrn["Incen_val"].", '".$row_rscrntrn['Brand']."', '".$_SESSION["credit_note_form"]."')";
				//echo $sql_tmpinst;
        		$result_tmpinst =$db->RunQuery($sql_tmpinst);
			
				
        	}
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Incentive (%)</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Incentive Val</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Brand</font></td>
                             
                            </tr>";		
			
			$Incen_val_val=0;
			
			
			
			$sql= "Select * from tmp_credit_note_form where tmp_no = '" .$_SESSION["credit_note_form"]. "'";
			//echo $sql;
			$result =$db->RunQuery($sql);
        	while ($row = mysql_fetch_array($result)){
			
						$Inv_date="Inv_date".$i;
						$inv_no="inv_no".$i;
						$Amount="Amount".$i;
						$disc="disc".$i;
						$Qty="Qty".$i;
						$Incen_per="Incen_per".$i;
						$Incen_val="Incen_val".$i;
						$Brands="Brands".$i;
						
					$ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=".$Inv_date."  disabled id=".$Inv_date." value='".$row['Inv_date']."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=".$inv_no."  disabled id=".$inv_no." value='".$row["inv_no"]."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Amount."  disabled id=".$Amount." value='".$row['Amount']."' class=\"txtbox\"/></td>
							 
							 <td ><input type=\"text\" size=\"10\" name=".$disc."  disabled id=".$disc." value='".$row['disc']."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Qty."  disabled id=".$Qty." value='".$row['Qty']."' class=\"txtbox\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=".$Incen_per."  onBlur=\"cal_incentive('".$i."')\" id=".$Incen_per." value='".$row['Incen_per']."' class=\"txtbox\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=".$Incen_val."  disabled id=".$Incen_val." value='".$row['Incen_val']."' class=\"txtbox\"/></td>
            	            	
            	<td ><input type=\"text\" size=\"10\" name=".$Brands."  disabled id=".$Brands." value='".$row['Brands']."' class=\"txtbox\"/></td>
				
				<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row["inv_no"]."  name=".$row["inv_no"]." onClick=\"del_item('".$row["inv_no"]."');\"></td></tr>"; 		
				
				if ((is_null($row['Incen_val'])==false) and ($row['Incen_val']!="")){
					$Incen_val_val=$Incen_val_val+$row['Incen_val'];
				}	
				$i=$i+1;
			}
							
			$ResponseXML .= "   </table>]]></sales_table>";
			$ResponseXML .= "<Incen_val><![CDATA[".$Incen_val_val."]]></Incen_val>";	
			$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
			$ResponseXML .= "<msg><![CDATA[]]></msg>";						
			
		}	 	
			
        
    //Loop
    //txttot = Format(tot, "######.00")		
			
		
		$ResponseXML .= "</salesdetails>";		

		echo $ResponseXML;	
			
	
}

	
	
	if($_GET["Command"]=="save_incent")
		{
		
					
					
						
		
		$sql_tmpinst= " update tmp_credit_note_form set Incen_per=".$_GET["Incen_per"].", Incen_val=".$_GET["Incen_val"]." where crn_form_no='".$_GET["txtrefno"]."' and inv_no='".$_GET["inv_no"]."'";
				echo $sql_tmpinst;
        	$result_tmpinst =$db->RunQuery($sql_tmpinst);
		
		}
		
		
	if($_GET["Command"]=="add_tmp")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="delete from tmp_purord_data where str_code='".$_GET['itemcode']."' and str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			
			$qty=str_replace(",", "", $_GET["qty"]);
			
			
			$sql="Insert into tmp_purord_data (str_invno, str_code, str_description, partno, qty)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', '".$_GET["partno"]."', ".$qty.") ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                             
                            </tr>";
							
			
			$sql="Select * from tmp_purord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['partno']."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['qty'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
                           
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	if($_GET["Command"]=="arn")
		{
		
			//$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="select * from s_ordmas where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			if($row = mysql_fetch_array($result)){
				$ResponseXML .= "<REFNO><![CDATA[".$row['REFNO']."]]></REFNO>";
				$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
				$ResponseXML .= "<SUP_CODE><![CDATA[".$row['SUP_CODE']."]]></SUP_CODE>";
				$ResponseXML .= "<SUP_NAME><![CDATA[".$row['SUP_NAME']."]]></SUP_NAME>";
				$ResponseXML .= "<REMARK><![CDATA[".$row['REMARK']."]]></REMARK>";
				$ResponseXML .= "<DEP_CODE><![CDATA[".$row['DEP_CODE']."]]></DEP_CODE>";
				$ResponseXML .= "<DEP_NAME><![CDATA[".$row['DEP_NAME']."]]></DEP_NAME>";
				$ResponseXML .= "<REP_CODE><![CDATA[".$row['REP_CODE']."]]></REP_CODE>";
				$ResponseXML .= "<REP_NAME><![CDATA[".$row['REP_NAME']."]]></REP_NAME>";
				$ResponseXML .= "<S_date><![CDATA[".$row['S_date']."]]></S_date>";
				$ResponseXML .= "<LC_No><![CDATA[".$row['LC_No']."]]></LC_No>";
				$ResponseXML .= "<Brand><![CDATA[".$row['Brand']."]]></Brand>";
				$ResponseXML .= "<COUNTRY><![CDATA[".$row["COUNTRY"]."]]></COUNTRY>";
			}	
			
		//	$sql="delete from tmp_purord_data where str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
		//	$result =$db->RunQuery($sql);
			
		//	$sql="select * from s_ordtrn where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
		//	$result =$db->RunQuery($sql);
		//	while($row = mysql_fetch_array($result)){
		//		$sql1="Insert into tmp_purord_data (str_invno, str_code, str_description, partno, qty)values 
		//		('".$row['REFNO']."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', '".$row["partno"]."', ".$row["ORD_QTY"].") ";
			//$ResponseXML .= $sql;
		//		$result1 =$db->RunQuery($sql1);	
		//	}
							
			
			
	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Order Qty</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">FOB</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cost</font></td>
							   <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Selling</font></td>
							    <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Margin</font></td>
								 <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							
                            </tr>";
				
			$mcou=0;	
			$sql="Select count(*) as mcou from s_ordtrn where REFNO='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			$row = mysql_fetch_array($result);
			$mcou=$row["mcou"]+1;
							
			$i=1;
			$sql="Select * from s_ordtrn where REFNO='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){	
			
				$itemcode="itemcode".$i;
				$itemname="itemname".$i;
				$ord_qty="ord_qty".$i;
				$fob="fob".$i;
				$qty="qty".$i;
				$cost="cost".$i;
				$selling="selling".$i;
				$margin="margin".$i;
				$subtotal="subtotal".$i;
							
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemcode." id=".$itemcode."   value=".$row['STK_NO']." class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemname." id=".$itemname."  value='".$row['DESCRIPT']."' class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$ord_qty." id=".$ord_qty."  value=".$row['ORD_QTY']." class=\"txtbox\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$fob." id=".$fob."  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$qty." id=".$qty."  class=\"txtbox\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$cost." id=".$cost."  class=\"txtbox\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$selling." id=".$selling."  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$margin." id=".$margin."  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$subtotal." id=".$subtotal."  class=\"txtbox\"/></td>
							</tr>";
							$i=$i+1; 
                           
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				$ResponseXML .= "<count><![CDATA[".$i."]]></count>";
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	if($_GET["Command"]=="setord")
	{
		
		include_once("connection.php");
		
		$len=strlen($_GET["salesord1"]);
		$need=substr($_GET["salesord1"],$len-7, $len);
		$salesord1=trim("ORD/ ").$_GET["salesrep"].trim(" / ").$need;
		
		
		$_SESSION["custno"]=$_GET['custno'];
		$_SESSION["brand"]=$_GET["brand"];
		$_SESSION["department"]=$_GET["department"];
		
		
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				$cuscode=$_GET["custno"];	
				$salesrep=$_GET["salesrep"];
				$brand=$_GET["brand"];
					
			//		$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
				
					
	    //Call SETLIMIT ====================================================================
		
		
		
	/*	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
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
	
	$sqloutinv = mysql_query("select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($salesrep)."' and class='".$InvClass."'") or die(mysql_error());
	if ($rowoutinv = mysql_fetch_array($sqloutinv)){
		if (is_null($rowoutinv["totout"])==false){
			$OutInvAmt=$rowoutinv["totout"];
		}
	}

$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salesrep)."'") or die(mysql_error());
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
		
		
		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".trim($salesrep)."'") or die(mysql_error());
		if($rowcheq = mysql_fetch_array($sqlcheq)){
			if (is_null($rowcheq["tot"])==false){
				$OutREtAmt=$rowcheq["tot"];
			} else {
				$OutREtAmt=0;
			}
		}
		
            
 
$ResponseXML .= "<sales_table_acc><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>".number_format($OutInvAmt, 2, ".", ",")."</td></tr>
						 <td>Return Cheque Amount</td><td>".number_format($OutREtAmt, 2, ".", ",")."</td></tr>
						 <td>Pending Cheque Amount</td><td>".number_format($OutpDAMT, 2, ".", ",")."</td></tr>
						 <td>PSD Cheque Settlments</td><td>".number_format($pend_ret_set, 2, ".", ",")."</td></tr>
						 <td>Total</td><td>".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."</td></tr>
						 </table></table>]]></sales_table_acc>";
        

      $sqlbr_trn = mysql_query("select * from br_trn where Rep='".trim($salesrep)."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'") or die(mysql_error());  
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
			$cuscat = trim($rowbr_trn["cat"]);
            if ($cuscat = "A"){ $m = 2.5; }
            if ($cuscat = "B"){ $m = 2.5; }
            if ($cuscat = "C"){ $m = 1; }
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
		echo $ResponseXML;
				
				
	
	
	}

		
	if($_GET["Command"]=="del_item")
		{
		
			
			header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$sql_tmpinst= " delete from tmp_credit_note_form where crn_form_no='".$_GET["txtrefno"]."' and inv_no='".$_GET["code"]."'";
	$result_tmpinst =$db->RunQuery($sql_tmpinst);
	
	$ResponseXML = "<salesdetails>";		
	
	
			
	$i = 1;
    $tot = 0;
   // Do While MSFlexGrid1.TextMatrix(i, 1) <> ""
        $mqty = 0;
     
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Incentive (%)</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Incentive Val</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Brand</font></td>
                             
                            </tr>";		
			
			$Incen_val_val=0;
			
			$sql= "Select * from tmp_credit_note_form where crn_form_no = '" .$_GET["txtrefno"]. "'";
			$result =$db->RunQuery($sql);
        	while ($row = mysql_fetch_array($result)){
			
						$Inv_date="Inv_date".$i;
						$inv_no="inv_no".$i;
						$Amount="Amount".$i;
						$disc="disc".$i;
						$Qty="Qty".$i;
						$Incen_per="Incen_per".$i;
						$Incen_val="Incen_val".$i;
						$Brands="Brands".$i;
						
					$ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=".$Inv_date."  disabled id=".$Inv_date." value='".$row['Inv_date']."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=".$inv_no."  disabled id=".$inv_no." value='".$row["inv_no"]."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Amount."  disabled id=".$Amount." value=".$row['Amount']." class=\"txtbox\"/></td>
							 
							 <td ><input type=\"text\" size=\"10\" name=".$disc."  disabled id=".$disc." value=".$row['disc']." class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Qty."  disabled id=".$Qty." value=".$row['Qty']." class=\"txtbox\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=".$Incen_per."  onBlur=\"cal_incentive('".$i."')\" id=".$Incen_per." value='".$row['Incen_per']."' class=\"txtbox\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=".$Incen_val."  disabled id=".$Incen_val." value='".$row['Incen_val']."' class=\"txtbox\"/></td>
            	            	
            	<td ><input type=\"text\" size=\"10\" name=".$Brands."  disabled id=".$Brands." value=".$row['Brands']." class=\"txtbox\"/></td>
				
				<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row["inv_no"]."  name=".$row["inv_no"]." onClick=\"del_item('".$row["inv_no"]."');\"></td></tr>"; 		
				
				if ((is_null($row['Incen_val'])==false) and ($row['Incen_val']!="")){
					$Incen_val_val=$Incen_val_val+$row['Incen_val'];
				}	
				$i=$i+1;
			}
							
			$ResponseXML .= "   </table>]]></sales_table>";
			$ResponseXML .= "<Incen_val><![CDATA[".$Incen_val_val."]]></Incen_val>";	
			$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
			$ResponseXML .= "<msg><![CDATA[]]></msg>";						
			
	
			
        
    //Loop
    //txttot = Format(tot, "######.00")		
			
		
		$ResponseXML .= "</salesdetails>";		

		echo $ResponseXML;	
			
				
			
	}
	

	
if($_GET["Command"]=="save_item")
{

	$vatrate=0.12;
	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
  if (($_GET["txt_cuscode"] != "") and ($_GET["mcou"] > 0)){
    $mrefno = trim($_GET["txtrefno"]);
	
    $sql_rscrnfrm= "Select * from s_crnfrmtrn where Refno = '" . $mrefno . "'";
	$result_rscrnfrm =$db->RunQuery($sql_rscrnfrm);
		
    $sql_rscrn= "Select * From s_crnfrm where Refno = '" . $mrefno . "'";
	$result_rscrn =$db->RunQuery($sql_rscrn);
    if($row_rscrnfrm = mysql_fetch_array($result_rscrnfrm)){	
		$row_rscrn = mysql_fetch_array($result_rscrn);	
        if ($row_rscrn["Lock1"] == "1") {
            exit ("Sorry this Credit note is locked");
            
        }
		$sql1= "Delete from s_crnfrmtrn where Refno = '" . $mrefno . "'";
		$result1 =$db->RunQuery($sql1);
		
		$sql1= "Delete from s_crnfrm where REfno = '" . $mrefno . "'";
		$result1 =$db->RunQuery($sql1);
       
        
        $i = 1;
        $mamount = 0;
        while ($_GET["mcou"]>$i){
			
			$Inv_date="Inv_date".$i;
			$inv_no="inv_no".$i;
			$Amount="Amount".$i;
			$disc="disc".$i;
			$Qty="Qty".$i;
			$Incen_per="Incen_per".$i;
			$Incen_val="Incen_val".$i;
			$Brands="Brands".$i;
			
			$sql1= "Insert into s_crnfrmtrn (Sdate, Refno, Code, Name, Sal_ex, Mon, Inv_no, Inv_date, Amount, Qty, Incen_per, Incen_val, Brand, Flag) values('" . $_GET["DTPicker1"] . "', '" . $mrefno . "','" . trim($_GET["txt_cuscode"]) . "', '" . trim($_GET["txt_cusname"]) . "', '" . $_GET["Com_rep"] . "', '" . $_GET["MonthView1"] . "','" . trim($_GET[$inv_no]) . "', '" . $_GET[$Inv_date] . "', '" . $_GET[$Amount] . "', '" . $_GET[$Qty] . "', '" . $_GET[$Incen_per] . "', '" . $_GET[$Incen_val] . "','" . $_GET[$Brands] . "','CCRN')";
			echo $sql1;
			$result1 =$db->RunQuery($sql1);
		
          
            $mamount = $mamount + $_GET[$Incen_val];
            $i = $i + 1;
        }
        
		$sql1= "insert into s_crnfrm (Refno, Sdate, Code, Mon, Amount, Remark, Sal_ex, Flag, Checked, Lock1, Cancell, Credit_note) Values('" . $mrefno . "','" . $_GET["DTPicker1"] . "', '" . trim($_GET["txt_cuscode"]) . "', '" . $_GET["MonthView1"] . "', '" . $mamount . "','" . trim($_GET["txtremark"]) . "','" . $_GET["Com_rep"] . "','CCRN', 'A', '0', '0', 'A')";
		$result1 =$db->RunQuery($sql1);
			
       
	    $sql1= "Update invpara set CCRNNO = CCRNNO+1";
		$result1 =$db->RunQuery($sql1);
        
    	echo "Saved";
		  
    } else {
        $i = 1;
        $mamount = 0;
        while ($_GET["mcou"]>$i){
			
			$Inv_date="Inv_date".$i;
			$inv_no="inv_no".$i;
			$Amount="Amount".$i;
			$disc="disc".$i;
			$Qty="Qty".$i;
			$Incen_per="Incen_per".$i;
			$Incen_val="Incen_val".$i;
			$Brands="Brands".$i;
			
			$sql1= "Insert into s_crnfrmtrn (Sdate, Refno, Code, Name, Sal_ex, Mon, Inv_no, Inv_date, Amount, Qty, Incen_per, Incen_val, Brand, Flag) values('" . $_GET["DTPicker1"] . "','" . $mrefno . "','" . trim($_GET["txt_cuscode"]) . "','" . trim($_GET["txt_cuscode"]) . "','" . $_GET["Com_rep"] . "', '" . $_GET["MonthView1"] . "','" . trim($_GET[$inv_no]) . "','" . $_GET[$Inv_date] . "','" . $_GET[$Amount] . "', '" . $_GET[$Qty] . "', '" . $_GET[$Incen_per] . "', '" . $_GET[$Incen_val] . "','" . $_GET[$Brands] . "','CCRN')";
			$result1 =$db->RunQuery($sql1);
           
            $mamount = $mamount + $_GET[$Incen_val];
            $i = $i + 1;
        }
        
		$sql1= "insert into s_crnfrm (Refno,sdate,code,mon,Amount,Remark,sal_ex,flag, Checked, Lock1, Cancell, Credit_note) Values('" . $mrefno . "','" . $_GET["DTPicker1"] . "', '" . trim($_GET["txt_cuscode"]) . "','" . $_GET["MonthView1"] . "', '" . $mamount . "','" . trim($_GET["txtremark"]) . "','" . $_GET["Com_rep"] . "','CCRN', 'A', '0', '0', 'A')";
		$result1 =$db->RunQuery($sql1);
		
       
        
		$sql1= "Update invpara set CCRNNO = CCRNNO+1";
		$result1 =$db->RunQuery($sql1);
        echo "Saved";
    }
  }
		
}
	

	if($_GET["Command"]=="pass_arnno")
	{
		$ResponseXML .= "";
		$ResponseXML .= "<salesdetails>";
		$sql="Select * from s_purmas where REFNO='".$_GET['arnno']."'";
		$result =$db->RunQuery($sql);	
		if ($row = mysql_fetch_array($result)){
			$ResponseXML .= "<REFNO><![CDATA[".$row["REFNO"]."]]></REFNO>";
			$ResponseXML .= "<SDATE><![CDATA[".$row["SDATE"]."]]></SDATE>";
			$ResponseXML .= "<ORDNO><![CDATA[".$row["ORDNO"]."]]></ORDNO>";
			$ResponseXML .= "<LCNO><![CDATA[".$row["LCNO"]."]]></LCNO>";
			$ResponseXML .= "<COUNTRY><![CDATA[".$row["COUNTRY"]."]]></COUNTRY>";
			$ResponseXML .= "<SUP_CODE><![CDATA[".$row["SUP_CODE"]."]]></SUP_CODE>";
			$ResponseXML .= "<SUP_NAME><![CDATA[".$row["SUP_NAME"]."]]></SUP_NAME>";
			$ResponseXML .= "<REMARK><![CDATA[".$row["REMARK"]."]]></REMARK>";
			$ResponseXML .= "<DEPARTMENT><![CDATA[".$row["DEPARTMENT"]."]]></DEPARTMENT>";
			$ResponseXML .= "<AMOUNT><![CDATA[".$row["AMOUNT"]."]]></AMOUNT>";
			$ResponseXML .= "<PUR_DATE><![CDATA[".$row["PUR_DATE"]."]]></PUR_DATE>";
			$ResponseXML .= "<brand><![CDATA[".$row["brand"]."]]></brand>";
			$ResponseXML .= "<TYPE><![CDATA[".$row["TYPE"]."]]></TYPE>";
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Unit</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Pre. Ret. Qty</font></td>
							  <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Price</font></td>
							   <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ret Qty</font></td>
							    <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Value</font></td>
							
                            </tr>";
				
			$mcou=0;	
			$sql="Select count(*) as mcou from s_purtrn where REFNO='".$_GET['arnno']."'";
			$result =$db->RunQuery($sql);	
			$row = mysql_fetch_array($result);
			$mcou=$row["mcou"]+1;
							
			$i=1;
			$tot=0;
			$sql="Select * from s_purtrn where REFNO='".$_GET['arnno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){	
			
				$itemcode="itemcode".$i;
				$itemname="itemname".$i;
				$unit="unit".$i;
				$qty="qty".$i;
				$preretqty="preretqty".$i;
				$price="price".$i;
				$retqty="retqty".$i;
				$value="value".$i;
			
					
				if (($row['ret_qty']=="") or ($row['ret_qty']==0) or is_null($row['ret_qty'])){
					$val_ret_qty=0;
				}	else {
					$val_ret_qty=$row['ret_qty'];
				}
						
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemcode." id=".$itemcode."   value='".$row['STK_NO']."' class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemname." id=".$itemname."  value='".$row['DESCRIPT']."' class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$unit." id=".$unit."  value='' class=\"txtbox\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$qty." id=".$qty." value='".$row['REC_QTY']."'  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$preretqty." id=".$preretqty." value='".$val_ret_qty."'  class=\"txtbox\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$price." id=".$price." value='".$row['SELLING']."'  class=\"txtbox\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$retqty." id=".$retqty." value=''  class=\"txtbox\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$value." id=".$value." value=''  class=\"txtbox\"/></td>
							
							</tr>";
							$tot=$tot+($row['COST']*$row['REC_QTY']);
							$i=$i+1; 
                           
				}			
							
                $ResponseXML .= "</table>]]></sales_table>";
				$ResponseXML .= "<tot><![CDATA[".$tot."]]></tot>";
				$ResponseXML .= "<count><![CDATA[".$i."]]></count>";
		}
		
		
		
		$ResponseXML .= "</salesdetails>";
		echo $ResponseXML;
	}
	
if($_GET["Command"]=="cancel_inv")
{
	if (($_GET["txt_cuscode"] != "") and ($_GET["mcou"] > 0)) {
    	$mrefno = trim($_GET["txtrefno"]);
    	$sql_rscrnfrm= "Select * from s_crnfrmtrn where Refno = '" . $mrefno . "'";
		$result_rscrnfrm =$db->RunQuery($sql_rscrnfrm);	
		
    	$sql_rscrn= " Select * from s_crnfrm where Refno = '" . $mrefno . "'";
		$result_rscrn =$db->RunQuery($sql_rscrn);	
    	if($row_rscrnfrm = mysql_fetch_array($result_rscrnfrm)){	
			
			$row_rscrn = mysql_fetch_array($result_rscrn);
			
        	if ($row_rscrn["Lock1"] == "1") {
            	exit ("Sorry this credit note cannot Cancel");
            	
        	}
			$sql1= "Update s_crnfrm set Cancell = '1' where Refno = '" . $mrefno . "'";
			$result1 =$db->RunQuery($sql1);	
			
			$sql1= "Delete from s_crnfrmtrn where Refno = '" . $mrefno . "'";
			$result1 =$db->RunQuery($sql1);	
        	
        	echo "Cancelled";
        	
    	}
	}

}	

if ($_GET["Command"]=="set_month")
{
	
	 $_SESSION["MonthView1"]=$_GET["MonthView1"];
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
	$result =$db->RunQuery($sql);
    if ($row = mysql_fetch_array($result)) {
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
$result =$db->RunQuery($sql);

$sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
$result =$db->RunQuery($sql);
if ($row = mysql_fetch_array($result)) {
   $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
   $resultbrtrn =$db->RunQuery($sqlbrtrn);
   
} else {
  
  	$sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
 	$resultbrtrn =$db->RunQuery($sqlbrtrn);
	
//	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
}

	If ($_GET["Check1"] == 1) {
   		$sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =$db->RunQuery($sqlblack);
	} else {	
    	$sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =$db->RunQuery($sqlblack);
	}

echo "Tempory limit updated";*/

}
	
?>