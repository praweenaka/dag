<?php session_start();

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
		
		

require_once("config.inc.php");
							require_once("DBConnector.php");
							$db = new DBConnector();

	//include_once("connection.php");


if ($_GET["Command"]=="SetListName"){

  if ($_SESSION["mDGRN"] == "DGRN") {
	
	if ($_GET["tyre"]=="true"){
  
    	if ($_GET["Option1"] == "true") {
        
           $strsql = "select refno, cl_no, ag_name, cus_name  from c_clamas where  Refund = 'Recommended' and DGRN_NO = '0' and type != 'BAT' ORDER BY refno";
		   
    	}
    	if ($_GET["Option2"] == "true") {
        
           $strsql = "select refno, cl_no, ag_name, cus_name  from c_clamas where  commercialy = '1' and DGRN_NO = '0' and type != 'BAT' ORDER BY refno";
    	}
    	if ($_GET["Option3"] == "true") {
        
           $strsql = "select refno, cl_no, ag_name, cus_name  from c_clamas where  commercialy = '2'  and DGRN_NO2 = '0' or commercialy = '3'  and DGRN_NO3 = '0' and type != 'BAT' ORDER BY refno";
                
    	}
		
	} else if ($_GET["battery"]=="true"){	
	
		if ($_GET["Option1"] == "true") {
        
		   $strsql = "select refno, cl_no, ag_name, cus_name  from c_clamas where  Refund = 'Recommended' and DGRN_NO = '0' and type = 'BAT' ORDER BY refno";
    	}
    	if ($_GET["Option2"] == "true") {
                  
		   $strsql = "select refno, cl_no, ag_name, cus_name  from c_clamas where  commercialy = '1' and DGRN_NO = '0' and type = 'BAT' ORDER BY refno";
    	}
    	if ($_GET["Option3"] == "true") {
        	
		   $strsql = "select refno, cl_no, ag_name, cus_name  from c_clamas where commercialy = '2'  and DGRN_NO2 = '0' or commercialy = '3'  and DGRN_NO3 = '0' and type = 'BAT' ORDER BY refno";
                
    	}
	}
  } else {
    if ($_GET["tyre"]=="true"){
		$strsql = "select refno, cl_no, ag_name, cus_name  from c_clamas where type = 'BAT' ORDER BY refno";
	} else if ($_GET["battery"]=="true"){	
    	$strsql = "select refno,cl_no, ag_name, cus_name  from c_clamas where type = 'BAT' ORDER BY refno";
	}	
  }


							
							
					echo "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">REF No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Claim No</font></td>
                               <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Agent Name</font></td>
                               <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer Name</font></td>
   							</tr>";
							
						
							
						$result =$db->RunQuery($strsql);
						while($row = mysql_fetch_array($result)){
					
							echo "<tr>               
                              <td onclick=\"defect('".$row['refno']."');\">".$row['refno']."</a></td>
                              <td onclick=\"defect('".$row['refno']."');\">".$row['cl_no']."</a></td>
                              <td onclick=\"defect('".$row['refno']."');\">".$row['ag_name']."</a></td>
							  <td onclick=\"defect('".$row['refno']."');\">".$row['cus_name']."</a></td>
                            </tr>";
							}
						  echo "</table>";
	
}


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
