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
					
			
			$inv= $_GET['invno']; 
							
						//	echo "Select * from s_purrmas where REFNO='".$inv."'";
				$sql = mysql_query("Select * from s_purrmas where REFNO='".$inv."'") or die(mysql_error());
				
				if($row = mysql_fetch_array($sql)){
				
					$ResponseXML .= "<REFNO><![CDATA[".$row['REFNO']."]]></REFNO>";
					$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
					$ResponseXML .= "<SUP_CODE><![CDATA[".$row['SUP_CODE']."]]></SUP_CODE>";
					$ResponseXML .= "<SUP_NAME><![CDATA[".$row['SUP_NAME']."]]></SUP_NAME>";
					$ResponseXML .= "<REMARK><![CDATA[".$row['REMARK']."]]></REMARK>";
					$ResponseXML .= "<AMOUNT><![CDATA[".number_format($row['AMOUNT'], 2, ".", ",")."]]></AMOUNT>";
					$ResponseXML .= "<ORDNO><![CDATA[".$row['ORDNO']."]]></ORDNO>";
					$ResponseXML .= "<DEPARTMENT><![CDATA[".$row['DEPARTMENT']."]]></DEPARTMENT>";
					$ResponseXML .= "<SUP_CODE><![CDATA[".$row['SUP_CODE']."]]></SUP_CODE>";
					
					
					
				
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Stock No</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Unit</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Pre.Ret.Qty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Price</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ret.Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Value</font></td>
                            </tr>";
							
					$sqlcustomer = mysql_query("Select * from s_purrtrn where REFNO='".$inv."'") or die(mysql_error());
					while($rowcustomer = mysql_fetch_array($sqlcustomer)){
						$ResponseXML .= "<tr><td >".$rowcustomer['STK_NO']."</td>
  							 			<td >".$rowcustomer['DESCRIPT']."</td>
										<td ></td>
										<td ></td>
										<td ></td>
										<td >".$rowcustomer['acc_COST']."</td>
										<td >".$rowcustomer['ret_qty']."</td>
										<td >".$rowcustomer['acc_COST']*$rowcustomer['ret_qty']."</td></tr>";
										
					}
					$ResponseXML .= "   </table>]]></sales_table>";
				}				
		  	
				
			
		
			
		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML; 
}	
?>
