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
			
			if (trim($_GET["txtChequeNo"]) != ""){
				$sql = mysql_query("select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' and che_amount = '".$_GET["che_amount"]."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					$ResponseXML .= "<Txtcusco><![CDATA[".$row['cus_code']."]]></Txtcusco>";
					$ResponseXML .= "<txtcusname><![CDATA[".$row['CUS_NAME']."]]></txtcusname>";
					
					$sql1 = mysql_query("Select * from s_salrep where REPCODE='".$row["sal_ex"]."'") or die(mysql_error());
					if($row1 = mysql_fetch_array($sql1)){
						$ResponseXML .= "<com_rep><![CDATA[".$row1['REPCODE']." ".$row1['Name']."]]></com_rep>";
					}	
					$ResponseXML .= "<txtChequeNo><![CDATA[".$row['cheque_no']."]]></txtChequeNo>";
					$ResponseXML .= "<txtChequeAmount><![CDATA[".$row['che_amount']."]]></txtChequeAmount>";
					$ResponseXML .= "<cmbBankname><![CDATA[".$row['bank']."]]></cmbBankname>";
					$ResponseXML .= "<txtrctdate><![CDATA[".$row['SDATE']."]]></txtrctdate>";
					$ResponseXML .= "<DTPicker2><![CDATA[".$row['che_date']."]]></DTPicker2>";
					$ResponseXML .= "<lblRET_chno><![CDATA[".$row['ret_chno']."]]></lblRET_chno>";
					$ResponseXML .= "<lblretrefno><![CDATA[".$row['ret_refno']."]]></lblretrefno>";
					$ResponseXML .= "<lblretdate><![CDATA[".$row['ret_chdate']."]]></lblretdate>";
					$ResponseXML .= "<lblnoof><![CDATA[".$row['noof']."]]></lblnoof>";
					
				}
			}
			
			$refinv = "";
			$i = 1;
			$st_amou = 0;
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Inv No</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Inv Amt</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">St. Amt</font></td>
                             
                            </tr>";
			
		  
			//echo "select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' and che_amount = '".$_GET["che_amount"]."'";
			$sql = mysql_query("select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' and che_amount = '".$_GET["che_amount"]."'") or die(mysql_error());
			if($row = mysql_fetch_array($sql)){
				if (trim($row["trn_type"]) == "RET") {
					//echo "select * from ch_sttr where ST_CHNO = '".trim($_GET["txtChequeNo"])."' and ST_INDATE = '".$row['che_date']."'";
					$sql1 = mysql_query("select * from ch_sttr where ST_CHNO = '".trim($_GET["txtChequeNo"])."' and ST_INDATE = '".$row['che_date']."'") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){
						//echo "select * from ret_chq_history where Ref_no = '".trim($row1["ST_INVONO"])."'";
						$sql_his = mysql_query("select * from ret_chq_history where Ref_no = '".trim($row1["ST_INVONO"])."'") or die(mysql_error());
						while($row_his = mysql_fetch_array($sql_his)){
							$refinv = $row_his["Inv_no"];
							$sql_rs = mysql_query("select * from  ret_ch_sett where CR_REFNO = '".trim($row1["ST_INVONO"])."' and  ST_CHNO = '" .trim($_GET["txtChequeNo"])."' and ret_chno = '".$row_his["chk_no"]."'") or die(mysql_error());
							$row_rs = mysql_fetch_array($sql_rs);
							
							if (is_null($row_his["st_amt"])==false) { $st_amou=$row_his["st_amt"]; }
								
								$sql_rst = mysql_query("select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'") or die(mysql_error());
								if ($row_rst = mysql_fetch_array($sql_rst)){
									$ResponseXML .= "<tr>
                              
                             			<td >".$row_rst['REF_NO']."</td>
							 			<td>".$row_rst['SDATE']."</td>
							 			<td >".$row_rst['GRAND_TOT']."</td>
							 			<td  >".$st_amou."</td>
							 			</tr>";
								}
   						 
    					}
					}
				} else {
					//echo "Select * from s_sttr where cus_code = '".trim($row['cus_code'])."' and st_chno = '".trim($_GET["txtChequeNo"])."' and st_chdate = '".$row['che_date']."'";
					$sql_inv = mysql_query("Select * from s_sttr where cus_code = '".trim($row['cus_code'])."' and st_chno = '".trim($_GET["txtChequeNo"])."' and st_chdate = '".$row['che_date']."'") or die(mysql_error());
					while($row_inv = mysql_fetch_array($sql_inv)){
						$refinv = $row_inv["ST_INVONO"];
        				$st_amou = $row_inv["ST_PAID"];
						//echo "select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'";
						$sql_rst = mysql_query("select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'") or die(mysql_error());
							if ($row_rst = mysql_fetch_array($sql_rst)){
								$ResponseXML .= "<tr>
                              
                             	<td >".$row_rst['REF_NO']."</td>
							 	<td>".$row_rst['SDATE']."</td>
							 	<td >".$row_rst['GRAND_TOT']."</td>
							 	<td  >".$st_amou."</a></td>
							 	</tr>";
							}
					}
				}	
      
			}	
	
			$ResponseXML .= "   </table>]]></sales_table>";
			
		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML; 
}


?>
