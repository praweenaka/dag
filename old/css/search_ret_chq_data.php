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


if ($_GET["Command"]=="pass_arr"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			//echo "Select * from s_cheq where CR_REFNO='".$_GET["invno"]."'";
			$sql = mysql_query("Select * from s_cheq where CR_REFNO='".$_GET["invno"]."'") or die(mysql_error());
			if($row = mysql_fetch_array($sql)){
				$ResponseXML .= "<lblReciptNo><![CDATA[".$row['CR_REFNO']."]]></lblReciptNo>";
				$ResponseXML .= "<txtRetChCha><![CDATA[".$row['CR_REPAY']."]]></txtRetChCha>";
				$ResponseXML .= "<DTPicker1><![CDATA[".$row['CR_DATE']."]]></DTPicker1>";
				$ResponseXML .= "<Txtcusco><![CDATA[".$row['CR_C_CODE']."]]></Txtcusco>";
				$ResponseXML .= "<cmbBankname><![CDATA[".$row['CR_BANK']."]]></cmbBankname>";
				if (is_null($row['CR_C_NAME'])==false){
					$ResponseXML .= "<txtcusname><![CDATA[".$row['CR_C_NAME']."]]></txtcusname>";
				} else {
					$ResponseXML .= "<txtcusname><![CDATA[]]></txtcusname>";	
				}	
				$ResponseXML .= "<txtremark><![CDATA[".$row['REMARK']."]]></txtremark>";
				$ResponseXML .= "<DTPicker2><![CDATA[".$row['CR_CHDATE']."]]></DTPicker2>";
				$ResponseXML .= "<txtChequeNo><![CDATA[".$row['CR_CHNO']."]]></txtChequeNo>";
				$ResponseXML .= "<txtChequeAmount><![CDATA[".$row['CR_CHEVAL']."]]></txtChequeAmount>";
				$ResponseXML .= "<txtChequeNo><![CDATA[".$row['CR_CHNO']."]]></txtChequeNo>";
				
				if (is_null($row['DEPARTMENT'])==false){
					$ResponseXML .= "<com_dep><![CDATA[".$row['DEPARTMENT']."]]></com_dep>";
				}	
				$ResponseXML .= "<txtforwhat><![CDATA[".$row['FORwhat']."]]></txtforwhat>";
				$ResponseXML .= "<txtcrenoteno><![CDATA[".$row['crenoteno']."]]></txtcrenoteno>";
				$ResponseXML .= "<txtcrenoteamo><![CDATA[".$row['crenoteamo']."]]></txtcrenoteamo>";
				$ResponseXML .= "<dev><![CDATA[".$row['dev']."]]></dev>";
				
				
				if (is_null($row["depobank"])){ 
					$com_cheq_dpo_bank = $row["depobank"]; 
      				$Txtacco = $row["DEBACC"];  
				}
				   
				$sql_INVCHEQ = mysql_query("Select * from s_invcheq where cheque_no = '".trim($row['CR_CHNO'])."' and cus_code = '".trim($row['CR_C_CODE'])."'") or die(mysql_error());
				if($row_INVCHEQ = mysql_fetch_array($sql_INVCHEQ)){
					if ($row_INVCHEQ["ch_count_ret"]=="1"){
						$ResponseXML .= "<Check1><![CDATA[1]]></Check1>";
					} else {
						$ResponseXML .= "<Check1><![CDATA[0]]></Check1>";
					}
				} else {
					$ResponseXML .= "<Check1><![CDATA[0]]></Check1>";
				}
				
				if (is_null($row['CR_C_NAME'])==true){
					$sql_VENDOR = mysql_query("Select CODE, NAME from vendor where CODE='".trim($row['CR_C_CODE'])."'") or die(mysql_error());
					if($row_VENDOR = mysql_fetch_array($sql_VENDOR)){
						$ResponseXML .= "<txtcusname><![CDATA[".$row_VENDOR['NAME']."]]></txtcusname>";
					}
				}
				
				if (is_null($row['DEPARTMENT'])==true){
					$sql_stomas = mysql_query("Select CODE, DESCRIPTION from s_stomas where CODE='".$row_stomas['DESCRIPTION']."'") or die(mysql_error());
					if($row_stomas = mysql_fetch_array($sql_stomas)){
						$ResponseXML .= "<com_dep><![CDATA[".$row_stomas['CODE']." - ".$row_stomas['DESCRIPTION']."]]></com_dep>";
					}
				}	
				
				if ($row["CR_FLAG"] == "0"){
       				
					$ResponseXML .= "<lab_cancel><![CDATA[Cancel]]></lab_cancel>";
				} else {
					$ResponseXML .= "<lab_cancel><![CDATA[]]></lab_cancel>";
				}	
      			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Inv No</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Inv.Amt</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">St.Amt</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Pre.Ret.Qty</font></td>
							 
                            </tr>";
							
	  			$sql_rst = mysql_query("Select * from ret_chq_history where Ref_no='".trim($row['CR_REFNO'])."'") or die(mysql_error());
				while ($row_rst = mysql_fetch_array($sql_rst)){
					
						$ResponseXML .= "<tr><td >".$sql_rst["Inv_no"]."</td>
										<td>".$sql_rst['Inv_date']."</td>
										<td>".$sql_rst['inv_Amt']."</td>
										<td>".$sql_rst['st_amt']."</td></tr>";
				}	
				
	
				$ResponseXML .= "   </table>]]></sales_table>";
			}				
		  	
				
			
		
			
		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML; 
}	
?>
