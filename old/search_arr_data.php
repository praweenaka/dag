<?php

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
		
		
session_start();


	include_once("connectioni.php");


if ($_GET["Command"]=="pass_arr"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
					
			
			$inv= $_GET['invno']; 
							
						//	echo "Select * from s_purrmas where REFNO='".$inv."'";
				$sql = mysqli_query($GLOBALS['dbinv'],"Select * from s_purrmas where REFNO='".$inv."'") or die(mysqli_error());
				
				if($row = mysqli_fetch_array($sql)){
				
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
					
					$tot=0;		
					$sqlcustomer = mysqli_query($GLOBALS['dbinv'],"Select * from s_purrtrn where REFNO='".$inv."'") or die(mysqli_error());
					while($rowcustomer = mysqli_fetch_array($sqlcustomer)){
						$ResponseXML .= "<tr><td >".$rowcustomer['STK_NO']."</td>
  							 			<td >".$rowcustomer['DESCRIPT']."</td>
										<td ></td>
										<td ></td>
										<td ></td>
										<td >".$rowcustomer['acc_COST']."</td>
										<td >".number_format($rowcustomer['REC_QTY'], 0, ".", ",")."</td>
										<td >".number_format($rowcustomer['acc_COST']*$rowcustomer['REC_QTY'], 2, ".", ",")."</td></tr>";
										$tot=$tot+($rowcustomer['acc_COST']*$rowcustomer['REC_QTY']);
										
					}
					$ResponseXML .= "   </table>]]></sales_table>";
				}				
		  	
				$ResponseXML .= "<tot><![CDATA[".number_format($tot, 2, ".", ",")."]]></tot>";
			
		
			
		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML; 
}	
?>
