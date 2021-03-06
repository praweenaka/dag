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
		
		
		
if ($_GET["Command"]=="pass_defectno"){
			
	include_once("connection.php");

	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
	
	$VATNO="";		
			
	if (trim($_GET["txtrefno"]) != ""){
		
		$sql="Select * from c_clamas where refno = '".$_GET["txtrefno"]."'";
		
		$result =$db->RunQuery($sql);
		if ($row = mysql_fetch_array($result)){
			$_SESSION["txt_fno"]=$row["refno"];
		}
		
		$sqlrsdef="select * from s_deftrn where REFNO='".trim($_GET["txtrefno"])."'";
		//echo $sqlrsdef;
		$resultrsdef =$db->RunQuery($sqlrsdef);
		if ($rowrsdef = mysql_fetch_array($resultrsdef)){
			$table_col1=$rowrsdef["STK_NO"];
			$ResponseXML .= "<dtdate><![CDATA[".$rowrsdef['SDATE']."]]></dtdate>";
			$ResponseXML .= "<txtbat><![CDATA[".$rowrsdef['BAT_NO']."]]></txtbat>";
			if (is_null($rowrsdef["arno"])==false){
				$ResponseXML .= "<cmbShip><![CDATA[".$rowrsdef['arno']."]]></cmbShip>";
			} else {
				$ResponseXML .= "<cmbShip><![CDATA[]]></cmbShip>";
			}
			
			if (is_null($rowrsdef["c_code"])==false){
			 	$ResponseXML .= "<txt_cuscode><![CDATA[".$rowrsdef['c_code']."]]></txt_cuscode>";
			} else {
				$ResponseXML .= "<txt_cuscode><![CDATA[]]></txt_cuscode>";
			}	
			
			$sqlcus="select * from vendor where CODE='".trim($rowrsdef['c_code'])."'";
			$resultcus =$db->RunQuery($sqlcus);
			if ($rowcus = mysql_fetch_array($resultcus)){
				$ResponseXML .= "<txt_cusname><![CDATA[".$rowcus['NAME']."]]></txt_cusname>";
				if (is_null($rowcus["ADD1"])==false) { 
					$txtadd = $rowcus["ADD1"]." ".$rowcus["ADD2"];
					$ResponseXML .= "<txtadd><![CDATA[".$txtadd."]]></txtadd>";
				}
				if ((is_null($rowcus["vatno"])==false) and ($rowcus["vatno"] != ""))
				{
            		$ResponseXML .= "<vatgroup><![CDATA[1]]></vatgroup>"; 
            		$VATNO = $rowcus["vatno"];
        		} else {
            		$ResponseXML .= "<vatgroup><![CDATA[0]]></vatgroup>"; 
        		}
					
			}
			
			$ResponseXML .= "<txtcl_no><![CDATA[".$rowrsdef['CLAM_NO']."]]></txtcl_no>";
				
			if (is_null($rowrsdef['STK_NO'])==false){
				$sql="SELECT * FROM s_mas WHERE STK_NO='".$rowrsdef['STK_NO']."'";
				$result =$db->RunQuery($sql);
				if ($row = mysql_fetch_array($result)){
					if (is_null($row["DESCRIPT"])==false) {	$table_col2=$row["DESCRIPT"]; }
					if (is_null($row["PART_NO"])==false) {	$table_col3=$row["PART_NO"]; }
        		}
			}
   
    		if (is_null($rowrsdef['REsult'])==false){  
				$ResponseXML .= "<Cmbres><![CDATA[".$rowrsdef['REsult']."]]></Cmbres>";  
			}
				
			if (is_null($rowrsdef['Remarks'])==false){  
				$ResponseXML .= "<txtremark><![CDATA[".$rowrsdef['Remarks']."]]></txtremark>";  
			}
    			
			$table_col4=$rowrsdef["AMOUNT"];
			$table_col5=1;
			$table_col6=$rowrsdef["dis"];
    			
			if (is_null($rowrsdef['ref_per'])==false){  
				$sql_df_frm="Select * from c_clamas where DGRN_NO = '".$_GET["txtrefno"]."' or DGRN_NO2 = '".$_GET["txtrefno"]."' or DGRN_NO3 = '".$_GET["txtrefno"]."' ";
				$result_df_frm =$db->RunQuery($sql_df_frm);
					
				$sql_rcbal="select * from c_bal where REFNO = '".$_GET["txtrefno"]."'";
				$result_rcbal =$db->RunQuery($sql_rcbal);
				$row_rcbal = mysql_fetch_array($result_rcbal);
					
				if ($row_df_frm = mysql_fetch_array($result_df_frm)){
      				$ResponseXML .= "<txt_fno><![CDATA[".$row_df_frm['refno']."]]></txt_fno>";
					$_SESSION["txt_fno"]=$row_df_frm['refno'] ;
      		     	$ResponseXML .= "<txt_net><![CDATA[".number_format($row_rcbal['AMOUNT'], 2, ".", ",")."]]></txt_net>";  
						
					$table_col9=number_format($row_rcbal['AMOUNT'], 2, ".", ",");
					$tmp = ($row_rcbal['AMOUNT']/$rowrsdef['ref_per'])*100;
					$table_col7=number_format($tmp, 2, ".", ",");
					$tmp=(($row_rcbal['AMOUNT'] / $rowrsdef['ref_per']) * 100) / (100 - $rowrsdef['dis']) * 100;
					$table_col4=number_format($tmp, 2, ".", ",");
					$table_col8=$rowrsdef['ref_per'];
					$old="false";
				} else {
					$old="true";
				}	
           
            	if ($old=="true"){
					$ResponseXML .= "<txt_fno><![CDATA[OLD]]></txt_fno>"; 
					$_SESSION["txt_fno"]="OLD" ;
           			$table_col8 = $rowrsdef['ref_per'];
					$ResponseXML .= "<txt_net><![CDATA[".number_format($row_rcbal['AMOUNT'], 2, ".", ",")."]]></txt_net>"; 
            		$table_col9 = number_format($row_rcbal['AMOUNT'], 2, ".", ",");
            		$table_col7 =number_format(($row_rcbal['AMOUNT']/$table_col8)*100, 2, ".", ","); 
            		$table_col4 =number_format((($row_rcbal['AMOUNT']/$table_col8)*100)/(100 - $rowrsdef['dis']) * 100, 2, ".", ",");  
				}
			} else {
					
        		$sql_df_frm="Select * from c_clamas where DGRN_NO = '".$_GET["txtrefno"]."'";
				$result_df_frm =$db->RunQuery($sql_df_frm);
					
					
				$sql_rcbal="select * from c_bal where refno = '".$_GET["txtrefno"]."'";
				$result_rcbal =$db->RunQuery($sql_rcbal);
				$row_rcbal = mysql_fetch_array($result_rcbal);
					
				if ($row_df_frm = mysql_fetch_array($result_df_frm)){
					$ResponseXML .= "<txt_fno><![CDATA[".$row_df_frm['refno']."]]></txt_fno>";
					$_SESSION["txt_fno"]=$row_df_frm['refno'] ;	  
      		 	 	$ResponseXML .= "<txt_net><![CDATA[".number_format($row_rcbal['AMOUNT'], 2, ".", ",")."]]></txt_net>";  
						
					$table_col9=number_format($row_rcbal['AMOUNT'], 2, ".", ",");
					$tmp = ($row_rcbal['AMOUNT']/$rowrsdef['ref_per'])*100;
					$table_col7=number_format($tmp, 2, ".", ",");
					$tmp=(($row_rcbal['AMOUNT'] / $rowrsdef['ref_per']) * 100) / (100 - $rowrsdef['dis']) * 100;
					$table_col4=number_format($tmp, 2, ".", ",");
					$table_col8=$rowrsdef['ref_per'];
					$old="false";
				} else {
   					$old="true";
				}	
       				
				$sql_df_frm="Select * from c_clamas where DGRN_NO2 = '".$_GET["txtrefno"]."'";
				$result_df_frm =$db->RunQuery($sql_df_frm);
       				
				$sql_rcbal="select * from c_bal where refno = '".$_GET["txtrefno"]."'";
				$result_rcbal =$db->RunQuery($sql_rcbal);
				$row_rcbal = mysql_fetch_array($result_rcbal);
					
				if ($row_df_frm = mysql_fetch_array($result_df_frm)){
					$ResponseXML .= "<txt_fno><![CDATA[".$row_df_frm['refno']."]]></txt_fno>";
					$_SESSION["txt_fno"]=$row_df_frm['refno'] ;
      		 	 	$ResponseXML .= "<txt_net><![CDATA[".number_format($row_rcbal['AMOUNT'], 2, ".", ",")."]]></txt_net>";  
						
					$table_col9=number_format($row_rcbal['AMOUNT'], 2, ".", ",");
					$tmp = ($row_rcbal['AMOUNT']/$row_df_frm['add_ref1'])*100;
					$table_col7=number_format($tmp, 2, ".", ",");
					$tmp=(($row_rcbal['AMOUNT'] / $row_df_frm['add_ref1']) * 100) / (100 - $rowrsdef['dis']) * 100;
					$table_col4=number_format($tmp, 2, ".", ",");
					$table_col8=$row_df_frm['add_ref1'];
					$old="false";
				} else {
					if ($old=="false"){
						$old="false";
					} else {
						$old="true";
					}
				}	
        			
				$sql_df_frm="Select * from c_clamas where DGRN_NO3 = '".$_GET["txtrefno"]."'";
				$result_df_frm =$db->RunQuery($sql_df_frm);
       				
				$sql_rcbal="select * from c_bal where refno = '".$_GET["txtrefno"]."'";
				$result_rcbal =$db->RunQuery($sql_rcbal);
				$row_rcbal = mysql_fetch_array($result_rcbal);
					
				if ($row_df_frm = mysql_fetch_array($result_df_frm)){
					$ResponseXML .= "<txt_fno><![CDATA[".$row_df_frm['refno']."]]></txt_fno>";
					$_SESSION["txt_fno"]=$row_df_frm['refno'] ;	  
      		 	 	$ResponseXML .= "<txt_net><![CDATA[".number_format($row_rcbal['AMOUNT'], 2, ".", ",")."]]></txt_net>";  
						
					$table_col9=number_format($row_rcbal['AMOUNT'], 2, ".", ",");
						
					$tmp = ($row_rcbal['AMOUNT']/$row_df_frm['add_ref2'])*100;
					$table_col7=number_format($tmp, 2, ".", ",");
						
					$tmp=(($row_rcbal['AMOUNT'] / $row_df_frm['add_ref2']) * 100) / (100 - $rowrsdef['dis']) * 100;
					$table_col4=number_format($tmp, 2, ".", ",");
						
					$table_col8=$row_df_frm['add_ref2'];
					$old="false";
				} else {
					if ($old=="false"){
						$old="false";
					} else {
						$old="true";
					}
				}	
        			
				$sql_rcbal="select * from c_bal where refno = '".$_GET["txtrefno"]."'";
				$result_rcbal =$db->RunQuery($sql_rcbal);
				$row_rcbal = mysql_fetch_array($result_rcbal);
				if ($old=="true"){
					$ResponseXML .= "<txt_fno><![CDATA[OLD]]></txt_fno>";
					$_SESSION["txt_fno"]="OLD" ;
					$table_col8=100;
					$ResponseXML .= "<txt_net><![CDATA[".number_format($row_rcbal['AMOUNT'], 2, ".", ",")."]]></txt_net>";  
					$table_col9=number_format($row_rcbal['AMOUNT'], 2, ".", ",");
						
					$tmp = ($row_rcbal['AMOUNT']/$table_col8)*100;
					$table_col7=number_format($tmp, 2, ".", ",");
						
					$tmp=(($row_rcbal['AMOUNT'] / $table_col8) * 100) / (100 - $rowrsdef['dis']) * 100;
					$table_col4=number_format($tmp, 2, ".", ",");
				}
			}
				
			if (is_null($rowrsdef["DEP"])==false){
    			$sql_rst2="select * from s_stomas where CODE='".$rowrsdef["DEP"]."'";
				$result_rst2 =$db->RunQuery($sql_rst2);
				if ($row_rst2 = mysql_fetch_array($result_rst2)){
					$dep=$rowrsdef["DEP"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row_rst2["DESCRIPTION"];
					$ResponseXML .= "<com_dep><![CDATA[".$dep."]]></com_dep>";
				}
    		}
				
			if (is_null($rowrsdef["SAL_EX"])==false){
    			$sql_rst1="select * from s_salrep where REPCODE='".$rowrsdef["SAL_EX"]."'";
				$result_rst1 =$db->RunQuery($sql_rst1);
				if ($row_rst1 = mysql_fetch_array($result_rst1)){
					$dep=str_split($rowrsdef["SAL_EX"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 6).$row_rst1["Name"];
					$ResponseXML .= "<Com_rep><![CDATA[".$dep."]]></Com_rep>";
				}
    		}
		} else {
			
			$sql_rsdgrn="Select * from  c_clamas where refno = '".$_SESSION["txt_fno"]."'";
			//echo $sql_rsdgrn;
			$result_rsdgrn =$db->RunQuery($sql_rsdgrn);
			if ($row_rsdgrn = mysql_fetch_array($result_rsdgrn)){
				$table_col1=$row_rsdgrn["stk_no"];
				if (is_null($row_rsdgrn["ag_code"])==false){ $ResponseXML .= "<txt_cuscode><![CDATA[".$row_rsdgrn["ag_code"]."]]></txt_cuscode>"; }
				if (is_null($row_rsdgrn["ag_name"])==false){ $ResponseXML .= "<txt_cusname><![CDATA[".$row_rsdgrn["ag_name"]."]]></txt_cusname>"; }
					
				$sql_cus="select * from vendor where CODE='".trim($row_rsdgrn["ag_code"])."'";
				$result_cus =$db->RunQuery($sql_cus);
				if ($row_cus = mysql_fetch_array($result_cus)){
					$ResponseXML .= "<txt_cusname><![CDATA[".$row_cus["NAME"]."]]></txt_cusname>";
						 
				 	if (is_null($row_cus["ADD1"])==false){ 
						$txtadd=$row_cus["ADD1"]." ".$row_cus["ADD2"];
						$ResponseXML .= "<txtadd><![CDATA[".$txtadd."]]></txtadd>";
					}
						
					if ((is_null($row_cus["vatno"])==false) and ($row_cus["vatno"] != ""))
					{
            			$ResponseXML .= "<vatgroup><![CDATA[1]]></vatgroup>"; 
            			$VATNO = $row_cus["vatno"];
        			} else {
            			$ResponseXML .= "<vatgroup><![CDATA[0]]></vatgroup>"; 
        			}
							
				}
					
				if (is_null($row_rsdgrn["agadd"])==false){ $ResponseXML .= "<txtadd><![CDATA[".$row_rsdgrn["agadd"]."]]></txtadd>"; }
				if (is_null($row_rsdgrn["seri_no"])==false){ $ResponseXML .= "<txtbat><![CDATA[".$row_rsdgrn["seri_no"]."]]></txtbat>"; }
					
				$txtcl_no="";
				if (is_null($row_rsdgrn["cl_no"])==false){ 
					$txtcl_no=$row_rsdgrn["cl_no"];
				}
				if (is_null($row_rsdgrn["rem_per"])==false){ 
					$txtcl_no=$txtcl_no.$row_rsdgrn["rem_per"];
				}
				$ResponseXML .= "<txtcl_no><![CDATA[".$txtcl_no."]]></txtcl_no>";
					
				$txtremark="";
				if (is_null($row_rsdgrn["tc_ob"])==false){ 
					$txtremark=$row_rsdgrn["tc_ob"];
				}
				if (is_null($row_rsdgrn["Mn_ob"])==false){ 
					$txtremark=$txtremark." (".$row_rsdgrn["Mn_ob"].")";
				}
				$ResponseXML .= "<txtremark><![CDATA[".$txtremark."]]></txtremark>";
					
				if (is_null($row_rsdgrn["des"])==false){ $table_col2 = $row_rsdgrn["des"]; }
				if (is_null($row_rsdgrn["patt"])==false){ $table_col3 = $row_rsdgrn["patt"]; }
					
				
				$sql_rst="SELECT * FROM s_mas WHERE STK_NO='".$row_rsdgrn["stk_no"]."'";
				$result_rst =$db->RunQuery($sql_rst);
				if ($row_rst = mysql_fetch_array($result_rst)){	
					if (is_null($row_rst["SELLING"])==false){ $table_col4 = $row_rst["SELLING"]; }
				}
				
				$sql_rst="Select ref_no, dis_per from viewinv where cus_code = '".trim($row_rsdgrn["ag_code"])."' and stk_no = '".trim($row_rsdgrn["stk_no"])."' and cancel_m = '0' order by sdate desc";
				
				$result_rst =$db->RunQuery($sql_rst);
				if ($row_rst = mysql_fetch_array($result_rst)){	
					
					$sql_CH_DIS="Select incen_per from  S_CRNFRMTRN where inv_no = '" . trim($rst["REF_NO"]) . "'";
					$result_CH_DIS =$db->RunQuery($sql_CH_DIS);
					if ($row_CH_DIS = mysql_fetch_array($result_CH_DIS)){
						$add_dis=$row_CH_DIS["incen_per"];
					} else {
						$add_dis=0;
					}	
					$table_col6=$row_rst["dis_per"] + $add_dis;
				}	
				
				$table_col5=1;	
       			
				if ($row_rsdgrn["Refund"]=="Recommended"){
					$ResponseXML .= "<Cmbres><![CDATA[DEFECT]]></Cmbres>"; 
				}
				
				if (($row_rsdgrn["Refund"]=="Recommended") and ($row_rsdgrn["Commercialy"]!="0")){
					$ResponseXML .= "<Cmbres><![CDATA[COMMERCIAL CLAIM]]></Cmbres>"; 
				}
				
				if (($row_rsdgrn["Refund"]=="Not Recommended") and ($row_rsdgrn["Commercialy"]!="0")){
					$ResponseXML .= "<Cmbres><![CDATA[COMMERCIAL CLAIM]]></Cmbres>"; 
				}
				
				if (($row_rsdgrn["DGRN_NO"]=="0") and ($row_rsdgrn["rem_per"]>0)){
					$table_col8=$row_rsdgrn["rem_per"];
				}
				
				if (($row_rsdgrn["DGRN_NO2"]=="0") and ($row_rsdgrn["rem_per1"]>0)){
					$table_col8=$row_rsdgrn["rem_per1"];
				}
				
				if (($row_rsdgrn["DGRN_NO3"]=="0") and ($row_rsdgrn["rem_per2"]>0)){
					$table_col8=$row_rsdgrn["rem_per2"];
				}
				
        	}
		}	
	}
	
	$sql_rscbal="select * from c_bal where REFNO='".trim($_GET["txtrefno"])."'";
	$result_rscbal =$db->RunQuery($sql_rscbal);
	if ($row_rscbal = mysql_fetch_array($result_rscbal)){	
		if (is_null($row_rscbal["RNO"])==false){ $ResponseXML .= "<txtrno><![CDATA[".$row_rscbal["RNO"]."]]></txtrno>"; }
	}			
	
	
	
							
			
					$ResponseXML .= "<itemno><![CDATA[".$table_col1."]]></itemno>";		
					$ResponseXML .= "<item_name><![CDATA[".$table_col2."]]></item_name>";
					$ResponseXML .= "<partno><![CDATA[".$table_col3."]]></partno>";
					$ResponseXML .= "<rate><![CDATA[".$table_col4."]]></rate>";
					$ResponseXML .= "<qty><![CDATA[".$table_col5."]]></qty>";
					$ResponseXML .= "<discou><![CDATA[".$table_col6."]]></discou>";
					
					$ResponseXML .= "<refund><![CDATA[".$table_col8."]]></refund>";
					
             	
							
					
					$table_col7 = $table_col4 * $table_col5 - $table_col4 * $table_col5 * $table_col6 * 0.01;
					$ResponseXML .= "<subtot><![CDATA[".number_format($table_col7, 2, ".", ",")."]]></subtot>";
					
					$table_col9 = $table_col9 + ($table_col7 * $table_col8 * 0.01);
					
					$ResponseXML .= "<total><![CDATA[".number_format($table_col9, 2, ".", ",")."]]></total>";	
					$ResponseXML .= "<txt_net><![CDATA[".number_format($table_col9, 2, ".", ",")."]]></txt_net>";	
						
						
			
			
			$ResponseXML .= "</salesdetails>";
			
			echo $ResponseXML;
			
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
			
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			require_once("config.inc.php");
			require_once("DBConnector.php");
			$db = new DBConnector();
	
			$sql="Select DGRN from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="00000000".$row["DGRN"];
			$lenth=strlen($tmpinvno);
			$txtrefno=trim("DGRN/ ").substr($tmpinvno, $lenth-9);
			$_SESSION["invno"]=$txtrefno;
			
			
			
			echo $txtrefno;	
			
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
	
	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
					$sql = mysql_query("CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error());
					  
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				$cuscode=$_GET["custno"];	
				
					
					$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
				
					
				$cuscode=$_GET["custno"];	
				$sql = mysql_query("Select * from vendor where CODE='".$cuscode."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					
					$OldRefno = "";
					$NewRefNo = "";
					$sql1 = mysql_query("SELECT  * From REF_HISTORY WHERE NewRefNo = '".$_GET["salesrep"]."'") or die(mysql_error());
					if($row1 = mysql_fetch_array($sql1)){
						$OldRefno = trim($row1["OldRefno"]);
    					$NewRefNo = trim($row1["NewRefNo"]);	
					}
					
					$OutpDAMT = 0;
					$OutREtAmt = 0;
					$OutInvAmt = 0;
					

		
					$sql1 = mysql_query("select * from brand_mas where barnd_name='".trim($_GET["brand"])."'") or die(mysql_error());
					
					if($row1 = mysql_fetch_array($sql1)){
						if (is_null($row1["class"])==false){ $InvClass = trim($row1["class"]); }
					}
					
		//////// Total Invoice Amount ///////////////////////////////////////////////////////////////	/						
				if ($NewRefNo==$_GET["salesrep"]){
					$sqlview = mysql_query("select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='".trim($cuscode)."' and (sal_ex='".$OldRefno."' or sal_ex='".trim($_GET["salesrep"])."' and class='".$InvClass."'") or die(mysql_error());
				} else {
					$sqlview = mysql_query("select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='".trim($cuscode)."' and sal_ex='".trim($_GET["salesrep"])."' and class='".$InvClass."'") or die(mysql_error());
				}
				
					$rowview = mysql_fetch_array($sqlview);
						if (is_null($rowview["totout"])==false) { $OutInvAmt = $rowview["totout"]; }


////////// PD Cheques ////////////////////////////////////////////////////////////////////////////
				if ($NewRefNo==$_GET["salesrep"]){
				
					$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and (sal_ex='".$OldRefno."' or sal_ex='".trim($_GET["salesrep"])."'") or die(mysql_error());
				} else {	
					
					$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($_GET["salesrep"])."'") or die(mysql_error());
				}
				while($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
				
					$sqlstr = mysql_query("select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"])."'") or die(mysql_error());
						
						while($rowstr = mysql_fetch_array($sqlstr)){
							echo "select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='".trim($rowstr["ST_INVONO"])."' ";
						  	$sqltmp = mysql_query("select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='".trim($rowstr["ST_INVONO"])."' ") or die(mysql_error());
                    		if($rowstmp = mysql_fetch_array($sqltmp)){
								//echo $rowstmp["class"];
                    			if (trim($rowstmp["class"] == $InvClass)) {
                   			 		$OutpDAMT = $OutpDAMT + $rowstr["ST_PAID"];
								}
               			     }
                		}
     				}	
	 
////////////  Return Settlement PD Cheques////////////////////////////////////////////////////////	 
	 	 $pend_ret_set = 0;
		 $sqlview = mysql_query("SELECT sum(che_amount) as  che_amount FROM S_INVCHeQ WHERE CHE_DATE >'".date("Y-m-d")."' AND CUS_CODE='".trim($cuscode)."' and trn_type='RET'") or die(mysql_error());
          $rowsview = mysql_fetch_array($sqlview);
			if( is_null($rowsview["che_amount"])==false){ $pend_ret_set = $rowsview["che_amount"]; }
							

//////////// Reurn Cheques////////////////////////////////////// //   /////////////////////////////////
	 	if ($NewRefNo==$_GET["salesrep"]){
		
     		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and (S_REF='".$_GET["salesrep"]."' or S_REF='" & $OldRefno & "') ") or die(mysql_error());
		
		} else {
	 
	 		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".$_GET["salesrep"]."' ") or die(mysql_error());
			
		}	
		$rowscheq = mysql_fetch_array($sqlcheq);
		if (is_null($rowscheq["tot"])==false){ 
			$OutREtAmt=$rowscheq["tot"];
		} else {
			$OutREtAmt=0;
		}
 
   
		/*$ResponseXML .= "<sales_table><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>".number_format($OutInvAmt, 2, ".", ",")."</td></tr>
						 <td>Return Cheque Amount</td><td>".number_format($OutREtAmt, 2, ".", ",")."</td></tr>
						 <td>Pending Cheque Amount</td><td>".number_format($OutpDAMT, 2, ".", ",")."</td></tr>
						 <td>PSD Cheque Settlments</td><td>".number_format($pend_ret_set, 2, ".", ",")."</td></tr>
						 <td>Total</td><td>".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."</td></tr>
						 </table></table>]]></sales_table>";*/
						 
						 
		$ResponseXML .= "<sales_table><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutREtAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutpDAMT, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table>";
						 
        
        $sqlbrtrn = mysql_query("select * from br_trn where Rep='".trim($_GET["salesrep"])."' and brand='".$InvClass."' and cus_code='".trim($cuscode)."' ") or die(mysql_error());
       if( $rowsbrtrn = mysql_fetch_array($sqlbrtrn)){
	   	if (is_null($rowsbrtrn["credit_lim"])==false){
			$crLmt = $rowsbrtrn["credit_lim"];
		} else {
			$crLmt =0;
		}
		
		if (is_null($rowsbrtrn["tmpLmt"])==false){
			$tmpLmt = $rowsbrtrn["tmpLmt"];
		} else {
			$tmpLmt =0;
		}
		
		if (is_null($rowsbrtrn["CAT"])==false){ $cuscat=$rowsbrtrn["CAT"]; }
		if ($cuscat="A") { $m=2.5; }
		if ($cuscat="B") { $m=2.5; }
		if ($cuscat="C") { $m=1; }
			
		$txt_crelimi="0";
		$txt_crebal="0";
		
		$txt_crelimi=number_format($crLmt, 2, ".", ",");
		
		$txt_crebal = number_format($crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set, 2, ".", ",");
			
		
		$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
        $ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
	   } else {
	   	$ResponseXML .= "<txt_crelimi><![CDATA[0.00]]></txt_crelimi>";
        $ResponseXML .= "<txt_crebal><![CDATA[0.00]]></txt_crebal>";
	   }
		
		$creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
		


				
				
		 			$sql = mysql_query("select dis from brand_mas where barnd_name = '".trim($_GET["brand"])."'") or die(mysql_error());
					if ($row = mysql_fetch_array($sql)){	
						$ResponseXML .= "<dis><![CDATA[".$row["dis"]."]]></dis>";
					}
			
				}
			
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
	
	}
	
	
	if($_GET["Command"]=="cancel_inv")
{
	$sql="select last_update from invpara  ";
	$result =$db->RunQuery($sql);
	$row = mysql_fetch_array($result);	
	
	$sqlinv="select * from s_cusordmas where REF_NO='".$_GET['salesord1']."'";
	$resultinv =$db->RunQuery($sqlinv);
	if ($rowinv = mysql_fetch_array($resultinv))
	{
		if (($rowinv["TOTPAY"]==0) and ($rowinv["SDATE"]>$row["last_update"])){
			$sql2="update s_cusordmas set CANCELL='1' where REF_NO='".$_GET['salesord1']."'";
			$result2 =$db->RunQuery($sql2);
			
			$sqltmp="select * from tmp_ord_data where str_invno='".$_GET['salesord1']."' ";
			$resulttmp =$db->RunQuery($sqltmp);
			while ($rowtmp = mysql_fetch_array($resulttmp)){
				$sqlorddata="update s_cusordtrn set CANCELL='1' where REF_NO='".$_GET['salesord1']."'";
				$resultorddata =$db->RunQuery($sqlorddata);
			}
			echo "Canceled";
		} else {
			echo "Can't Cancel";
		}
	}	
}

	if($_GET["Command"]=="add_tmp")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="delete from tmp_ord_data where str_code='".$_GET['itemcode']."' and str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			$rate=str_replace(",", "", $_GET["rate"]);
			$qty=str_replace(",", "", $_GET["qty"]);
			$discount=str_replace(",", "", $_GET["discount"]);
			$subtotal=str_replace(",", "", $_GET["subtotal"]);
			
			$sql="Insert into tmp_ord_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.", '".$_GET["brand"]."') ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							  <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_ord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td >".$row['str_code']."</a></td>
							 <td >".$row['str_description']."</a></td>
							 <td >".number_format($row['cur_rate'], 2, ".", ",")."</a></td>
							 <td >".number_format($row['cur_qty'], 2, ".", ",")."</a></td>
							 <td >".number_format($_GET["discountper"], 2, ".", ",")."</a></td>
							 <td >".number_format($row['cur_subtot'], 2, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
						
						include_once("connection.php");
							 
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td >".$qty."</a></td>
						
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where str_invno='".$_GET['invno']."'";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$vatrate=0.12;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="non"){
					//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
					$ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";
					
					$invtot=number_format($row['tot_sub'], 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
				}
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	


	
if($_GET["Command"]=="delete_inv")
{
	$sql="select * from S_CUSORDMAS where REF_NO= '".trim($_GET["salesord1"])."' ";
	$result =$db->RunQuery($sql);					
	if($row = mysql_fetch_array($result)){	
		$sql1="UPDATE S_CUSORDMAS SET S_CUSORDMAS.CANCELL = '1' WHERE (((S_CUSORDMAS.REF_NO)='".trim($_GET["salesord1"])."'))";
		
		$result1 =$db->RunQuery($sql1);	
		
		$sql1="UPDATE S_CUSORDTRN SET S_CUSORDTRN.CANCELL = '1' WHERE (((S_CUSORDTRN.REF_NO)='".trim($_GET["salesord1"])."'))";
		$result1 =$db->RunQuery($sql1);		
		
	}
	echo "Canceled";	
  
}
	
		
	if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_ord_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
			//echo $sql;
			$result =$db->RunQuery($sql);
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_ord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_rate']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_qty']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_discount']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_subtot']."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
							 	include_once("connection.php");
							 
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td bgcolor=\"#222222\" >".$qty."</a></td>
                            </tr>";
				}			
				
				 $ResponseXML .= "   </table>]]></sales_table>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where str_invno='".$_GET['invno']."'";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$vatrate=0.12;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="non"){
					//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
					$ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";
					
					$invtot=number_format($row['tot_sub'], 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
				}
							
                $ResponseXML .= "   </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	
	if($_GET["Command"]=="save_item")
		{
			
		
			$_SESSION["CURRENT_DOC"] = 1;      //document ID
			$_SESSION["VIEW_DOC"] = false ;     //view current document
			$_SESSION["FEED_DOC"] = true;       //save  current document
			$_GET["MOD_DOC"] = false  ;         //delete   current document
			$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
			$_GET["PRICE_EDIT"] = false ;       //edit selling price
			$_GET["CHECK_USER"] = false ;       //check user permission again

			
			//$subtot = ($_GET["rate"] * $_GET["qty"]) - ($_GET["rate"] * $_GET["qty"] * $_GET["discou"] * 0.01);
			
			//$tot = $tot + ($subtot * $_GET["refund"] * 0.01);


			
			$sql3="select BRAND_NAME from s_mas where STK_NO='".$_GET["itemno"]."'";
			$result3 =$db->RunQuery($sql3);
			$row3 = mysql_fetch_array($result3);
			
			$mvatrate=0.12;
			
			$sql="insert into s_crnma(REF_NO, DDATE, SAL_EX, Brand, C_CODE, CUS_NAME, GRAND_TOT, DEPARTMENT, DEP_CODE, vatrate) values ('".$_GET["txtrefno"]."', '".$_GET["dtdate"]."', '".$_GET["Com_rep"]."', '".$row3["BRAND_NAME"]."', '".$_GET["txt_cuscode"]."', '".$_GET["txt_cusname"]."', '".$_GET["txt_net"]."', '".$_GET["txtrefno"]."', '".$_GET["com_dep"]."', '".$mvatrate."')";
			//echo $sql;
			$result =$db->RunQuery($sql);
			
			
			
			$sql="Insert into c_bal (REFNO, SDATE, CUSCODE, AMOUNT, BALANCE, DEP, SAL_EX, brand, trn_type, DEV, vatrate, RNO ) values('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . trim($_GET["txt_cuscode"]) . "', " . $_GET["txt_net"] . ", " . $_GET["txt_net"] . ", '" . $_GET["com_dep"] . "', '" . $_GET["Com_rep"] . "', '" . $row3["BRAND_NAME"] . "', 'DGRN', '".$_SESSION['dev']."', '" . $mvatrate . "', '" . trim($_GET["txtrno"]) . "')";
			//echo $sql;
			$result =$db->RunQuery($sql);
			
			if ($_GET["discou"]==""){
				$discou=0;
			} else {
				$discou=$_GET["discou"];	
			}
			
			if ($_GET["refund"]==""){
				$refund=0;
			} else {
				$refund=$_GET["refund"];	
			}
			$sql="Insert into s_deftrn (REFNO, STK_NO, SDATE, BAT_NO, CLAM_NO, REsult, qty, remarks, AMOUNT, dis, c_code, dep, SAL_EX, arno, ref_per) values('" . trim($_GET["txtrefno"]) . "', '" . $_GET["itemno"] . "', '" . trim($_GET["dtdate"]) . "', '" . $_GET["txtbat"] . "', " . $_GET["txtcl_no"] . ", '" . $_GET["Cmbres"] . "', '" . $_GET["qty"] . "', '" . $_GET["txtremark"] . "', ".$_GET["rate"].", ".$discou.", '" . $_GET["txt_cuscode"] . "', '" . trim($_GET["com_dep"]) . "', '" . trim($_GET["Com_rep"]) . "', '" . trim($_GET["cmbShip"]) . "', ".$refund.")";
			//echo $sql;
			$result =$db->RunQuery($sql);
			
			if (date("m", $_GET["dtdate"]) == 1) { 
				$sql= "update s_mas set SALE01= SALE01-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
				$result =$db->RunQuery($sql);
			}
			if (date("m", $_GET["dtdate"]) == 2) { 
				$sql= "update s_mas set SALE02= SALE02-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
				$result =$db->RunQuery($sql);
			}
			if (date("m", $_GET["dtdate"]) == 3) { 
				$sql= "update s_mas set SALE03= SALE03-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
				$result =$db->RunQuery($sql);
			}
			if (date("m", $_GET["dtdate"]) == 4) { 
				$sql= "update s_mas set SALE04= SALE04-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
				$result =$db->RunQuery($sql);
			}
			if (date("m", $_GET["dtdate"]) == 5) { 
				$sql= "update s_mas set SALE05= SALE05-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
				$result =$db->RunQuery($sql);
			}
			if (date("m", $_GET["dtdate"]) == 6) { 
				$sql= "update s_mas set SALE06= SALE06-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
				$result =$db->RunQuery($sql);
			}
			if (date("m", $_GET["dtdate"]) == 7) { 
				$sql= "update s_mas set SALE07= SALE07-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
				$result =$db->RunQuery($sql);
			}
			if (date("m", $_GET["dtdate"]) == 8) { 
				$sql= "update s_mas set SALE08= SALE08-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
				$result =$db->RunQuery($sql);
			}
			if (date("m", $_GET["dtdate"]) == 9) { 
				$sql= "update s_mas set SALE09= SALE09-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
				$result =$db->RunQuery($sql);
			}
			if (date("m", $_GET["dtdate"]) == 10) { 
				$sql= "update s_mas set SALE10= SALE010-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
				$result =$db->RunQuery($sql);
			}
			if (date("m", $_GET["dtdate"]) == 11) { 
				$sql= "update s_mas set SALE11= SALE11-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
				echo $sql;
				$result =$db->RunQuery($sql);
			}
			if (date("m", $_GET["dtdate"]) == 12) { 
				$sql= "update s_mas set SALE12= SALE12-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
				$result =$db->RunQuery($sql);
			}

			
		
		//===============Update customer Ledger======
 		$rss_led= "SELECT * FROM s_led WHERE REF_NO='" . $_GET["txtrefno"] . "'";
 		$result_led =$db->RunQuery($rss_led);
 		if ($row_led = mysql_fetch_array($result_led)){
		
		} else {
			$sql= "insert into s_led (REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT) values ('".$_GET["txtrefno"]."', '".$_GET["dtdate"]."', '".$_GET["txt_cuscode"]."', '".$_GET["txt_net"]."', 'DGRN', '".$_GET["com_dep"]."')";
			$result =$db->RunQuery($sql);
		
		}
		
		//==============update credit limit==========================================
		
		$sql= "update vendor set CUR_BAL= CUR_BAL-" . $_GET["txt_net"] . " where CODE='" . $_GET["txt_cuscode"] . "'";
		$result =$db->RunQuery($sql);
		
		$sql= "update br_trn set credit= credit- " . $_GET["txt_net"] . " where cus_code='" . $_GET["txt_cuscode"] . "' AND Rep='" . $_GET["Com_rep"] . "'";
		$result =$db->RunQuery($sql);
		
		$sql= "update invpara set DGRN= DGRN+1";
		$result =$db->RunQuery($sql);
		
		$sql= "update invpara set rno= rno+1";
		$result =$db->RunQuery($sql);
			

			
		//===================update DGRN Form =========================================

		$sql_fr_clm= "Select * from  c_clamas where refno = '" . $_GET["txt_fno"] . "'";
		$result_fr_clm =$db->RunQuery($sql_fr_clm);
		if ($row_fr_clm = mysql_fetch_array($result_fr_clm)){

			if ($row_fr_clm["DGRN_NO"] == "0") { 
				$sql= "Update c_clamas set DGRN_NO = '" . $_GET["txtrefno"] . "', ref_per = '" . $_GET["refund"] . "'  where refno = '" . $_GET["txt_fno"] . "'";
				$result =$db->RunQuery($sql);
			}	
			
			if ($row_fr_clm["DGRN_NO2"] == "0") {
    			if (is_null($row_fr_clm["add_ref1"])==false) {
        			if ($row_fr_clm["add_ref1"] > 0) { 
						$sql= "Update c_clamas set DGRN_NO2 = '" . $_GET["txtrefno"] . "', add_ref1 = '" . $_GET["refund"] . "'  where refno = '" . $_GET["txt_fno"] . "'";
						$result =$db->RunQuery($sql);
    				}
				}
			}	
			if ($row_fr_clm["dgrn_no3"] == "0") {
    			if (is_null($row_fr_clm["add_ref2"])==false) {
        			if ($row_fr_clm["add_ref2"] > 0 ){ 
						$sql= "Update c_clamas set DGRN_NO3 = '" . $_GET["txtrefno"] . "', add_ref2 = '" .  $_GET["refund"] .  "'  where refno = '" . $_GET["txt_fno"] & "'";
						$result =$db->RunQuery($sql);
    				}
				}
			}

		}
			
			echo "Saved";
			
			
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