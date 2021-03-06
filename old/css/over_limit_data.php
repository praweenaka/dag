<?php 
session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
		
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
	
			
		if($_GET["Command"]=="view_from")
		{
			
			
		//----------------------------Check User----------------------------------------
/*If CURRENT_USER = "rohan" Then
    rs.Open "Select c_code,name,sal_ex,class,sum(grand_tot) as amount from VIEW_repord_brand_btr where invno = '0' and cancell = '0' and Forward = 'WD' and result = 'P' Group by  c_code,name,sal_ex,class order by c_code", dnINV.conINV
Else
    If CURRENT_USER = "MD" Then
        rs.Open "Select c_code,name,sal_ex,class,sum(grand_tot) as amount from VIEW_repord_brand_btr where invno = '0' and cancell = '0' and Forward = 'MD' Group by  c_code,name,sal_ex,class order by c_code", dnINV.conINV
    Else
        If CURRENT_USER = "Errol" Then
            rs.Open "Select c_code,name,sal_ex,class,sum(grand_tot) as amount from VIEW_repord_brand_btr where invno = '0' and cancell = '0' AND Limit_need > '0' and Forward = 'MM' and Approveby = '0' Group by  c_code,name,sal_ex,class order by c_code", dnINV.conINV
        Else
            rs.Open "Select c_code,name,sal_ex,class,sum(grand_tot) as amount from VIEW_repord_brand_btr where invno = '0' and cancell = '0' AND Limit_need > '0' and Forward = 'MM'  Group by  c_code,name,sal_ex,class order by c_code", dnINV.conINV
        End If
    End If
End If*/
	
	$myg= array();
	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
	$ResponseXML .= "<sales_table><![CDATA[ <table>
                                                        			<tr>
                              											<td background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              											<td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Name</font></td>
                              											<td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Limit</font></td>
                              											<td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Outstanding</font></td>
                                                                        <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ret Chq</font></td>
                                                                        <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ret Chq - BEN</font></td>
                                                                        <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Order Val</font></td>
                                                                        <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ex Limit</font></td>
                                                                         <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"></font></td>
                                                                          <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">PD for Rtn</font></td>
                                                                           <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Over 60</font></td>
                                                                            <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"></font></td>
                                                                             <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Settlement</font></td>
                                                                              <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ret Chq</font></td>
                                                                               <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Settlement</font></td>
                                                                                <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"></font></td>
                                                                                 <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Settlement</font></td>
                                                                                  <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Settlement</font></td>
                                                                                   <td background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Type</font></td>
                           											</tr>
                   												</table> ";
																
	$sql=  "Select C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from VIEW_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND Limit_need > '0' and Forward = 'MM'  Group by  C_CODE,NAME,SAL_EX,class order by C_CODE";
	$i = 1;

	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
   		$limit = 0;
   		$Out = 0;
   		$rtn_ch = 0;
   		$rtn_ch_n = 0;
   		$chq_re = 0;
   		$ca_re = 0;
   		$Ch_pen = 0;
   		$out_pen = 0;
		
   		$myg[1] = $row["C_CODE"];
   		$myg[2] = $row["NAME"];
   		$myg[3] = 0;
   		
		$rs3= "Select CAT,credit_lim, brand from br_trn where cus_code='" . $row["C_CODE"] . "' and Rep = '" . $row["SAL_EX"] . "'  and brand = '" . $row["class"] . "' and credit_lim != 0 ";
   		$result3 =$db->RunQuery($rs3);
		if ($row3 = mysql_fetch_array($result3)){
	
      		if (is_null($row3["CAT"])==false) {
         	if ($row3["CAT"] == "A") { $limit = $row3["credit_lim"] * 2.5; }
         	if ($row3["CAT"] == "B") { $limit = $row3["credit_lim"] * 2.5; }
         	if ($row3["CAT"] == "C") { $limit = $row3["credit_lim"] * 1; }
         	
			$myg[3] = $limit;
      	} else {
         	$myg[3] = 0;
      	}
   	}
   
   
   
    $findref= "SELECT * From ref_history WHERE  (NewRefNo = '" . $row["SAL_EX"] . "')";
    $OldRefno = "";
    $NewRefNo = "";
	$result_findref =$db->RunQuery($findref);
	if ($row_findref = mysql_fetch_array($result_findref)){
   
        $OldRefno = $row_findref["OldRefno"];
        $NewRefNo = $row_findref["NewRefNo"];
    }
    
   //=========================================================
   if ($row["SAL_EX"] == $NewRefNo) {
        $rs0= "Select sum(GRAND_TOT - TOTPAY) as out from VIEW_s_salma  where class='" . $row["class"] . "' and GRAND_TOT > TOTPAY and CANCELL='0' and C_CODE='" . $row["C_CODE"] . "' and (SAL_EX = '" . $row["SAL_EX"] . "' or SAL_EX = '" . $OldRefno . "'";
   } else {
        $rs0= "Select sum(GRAND_TOT - TOTPAY) as out from VIEW_s_salma  where class='" . $row["class"] . "' and GRAND_TOT > TOTPAY and CANCELL='0' and C_CODE='" . $row["C_CODE"] . "' and SAL_EX = '" . $row["SAL_EX"] . "'  ";
   }
   $result_rs0 =$db->RunQuery($rs0);
   if ($row_rs0 = mysql_fetch_array($result_rs0)){
      if (is_null($row_rs0["out"])==false ) { $out = $row_rs0["out"]; }
      $myg[4] = $out;
   }
   
   
   if ($row["SAL_EX"] == $NewRefNo) {
        $rs0 = "Select sum(ST_PAID) as out from VIEW_sinvcheq_sttr_salma  where che_date >  '" . $_GET["dtfrom"] . "' and C_CODE='" . $row["C_CODE"] . "' and (sal_ex = '" . $row["SAL_EX"] . "' or sal_ex = '" . $OldRefno . "') and class = '" . $row["class"] . "'  ";
   } else {
        $rs0= "Select sum(ST_PAID) as out from VIEW_sinvcheq_sttr_salma  where che_date >  '" . $_GET["dtfrom"] . "' and C_CODE='" . $row["C_CODE"] . "' and SAL_EX = '" . $row["SAL_EX"] . "' and class = '" . $row["class"] . "'  ";
   }
   $result_rs0 =$db->RunQuery($rs0);
   if ($row_rs0 = mysql_fetch_array($result_rs0)){
      if (is_null($row_rs0["out"])==false) { $out = $out + $row_rs0["out"]; }
      	$myg["4"] = $out;
   }
   
   
   $rs0= "Select sum(CR_CHEVAL-paid) as out from s_cheq  where  CR_CHEVAL > PAID  and CR_C_CODE='" . $row["C_CODE"] . "' and CR_FLAG != 'c'  ";   $result_rs0 =$db->RunQuery($rs0);
   if ($row_rs0 = mysql_fetch_array($result_rs0)){
      if (is_null($row_rs0["out"])==false) { $rtn_ch = $row_rs0["out"]; }
      	$myg[5] = $rtn_ch;
   }
   
   //------------------------------------------------------BPL Return Chq-------------------------------------------------------------
   $rsven= "Select commoncode from vendor where CODE = '" . $row["C_CODE"] . "' ";
   $result_rsven =$db->RunQuery($rsven);
   if ($row_rsven = mysql_fetch_array($result_rsven)){
       if ($row_rsven["commoncode"] != "0") {
            $rs0= "Select sum(CR_CHEVAL-PAID) as out from s_cheq  where  CR_CHEVAL > PAID  and CR_C_CODE='" . trim($result_rsven["commoncode"]) . "' and CR_FLAG != 'c'  ";
			$result_rs0 =$db->RunQuery($rs0);
   			if ($row_rs0 = mysql_fetch_array($result_rs0)){
                if (is_null($row_rs0["out"])==false) { $rtn_ch_n = $row_rs0["out"]; }
                $myg[6] = $rtn_ch_n;
            }
            
        }
   }
   
   //----------------------------------------------------------------------------------------------------------------------------------
   
   $myg["7"] = $row["AMOUNT"];
   
   $rs0= "Select sum(che_amount) as out from s_invcheq where  che_date > '" . $_GET["dtfrom"] . "'   and cus_code='" . $row["C_CODE"] . "' and trn_type = 'RET'  ";
   $result_rs0 =$db->RunQuery($rs0);
   if ($row_rs0 = mysql_fetch_array($result_rs0)){
   
      if (is_null($row_rs0["out"])==false) { $out = $out + $row_rs0["out"]; }
      	$myg[4] = $out;
      	if (is_null($row_rs0["out"])==false) { $myg[10] = $row_rs0["out"]; }
   }
   
   
   $myg[8] = $limit - $out - $rtn_ch - $row["AMOUNT"];
   
   //.........................Ovr 60.............
   $adddate=date('Y-m-d', strtotime("-60 days"));
   
   $rs0= "Select sum(GRAND_TOT - TOTPAY) as out from s_salma where  GRAND_TOT > TOTPAY and sdate <='" . $adddate . "'  and C_CODE='" . $row["C_CODE"] . "' and CANCELL = '0'  ";
   $result_rs0 =$db->RunQuery($rs0);
   if ($row_rs0 = mysql_fetch_array($result_rs0)){
        if (is_null($row_rs0["out"])==false) { 
			$myg[11] = $$row_rs0["out"];
		}	
   }
   
   
   //.........................90 days selltle history..................
   
   $adddate=date('Y-m-d', strtotime("-97 days"));
   $adddate1=date('Y-m-d', strtotime("-7 days"));
   
   $rs0= "SELECT sum(che_amount) as reatot from view_s_invcheq where cus_code='" . $row["C_CODE"] . "'  and ( che_date>'" . $adddate . "' or che_date ='" . $adddate . "')  and ( che_date<'" . $adddate1 . "' or che_date ='" . $adddate1 . "') and trn_type <> 'RET' ";
   $result_rs0 =$db->RunQuery($rs0);
   if ($row_rs0 = mysql_fetch_array($result_rs0)){
   	if (is_null($row_rs0["reatot"])==false) { $chq_re = $row_rs0["reatot"]; }
   }
   
    $adddate=date('Y-m-d', strtotime("-90 days"));
   $rs0= "select sum(CA_CASSH) as ca_reatot from s_crec where CA_CODE = '" . $row["C_CODE"] . "' and ( CA_DATE>'" . $adddate . "' or CA_DATE ='" . $adddate . "')  and ( CA_DATE<'" . date("Y-m-d") . "' or CA_DATE ='" . date("Y-m-d") . "') and CANCELL = '0' and FLAG = 'REC' ";
   $result_rs0 =$db->RunQuery($rs0);
   if ($row_rs0 = mysql_fetch_array($result_rs0)){
   	if (is_null($row_rs0["ca_reatot"])==false) { $ca_re = $row_rs0["ca_reatot"]; }
   }
   
   $myg[13] = $chq_re + $ca_re;

   //.........................90 days void cheque.......................
   
   $adddate=date('Y-m-d', strtotime("-90 days"));
   $rs0= "SELECT sum(CR_CHEVAL) as out from s_cheq where  (CR_DATE>'" . $adddate . "'or CR_DATE='" . $adddate . "')and (CR_DATE<'" . date("Y-m-d") . "'or CR_DATE='" . date("Y-m-d") . "') and CR_C_CODE = '" . $row["C_CODE"] . "' and CR_FLAG='0' ";
   $result_rs0 =$db->RunQuery($rs0);
   if ($row_rs0 = mysql_fetch_array($result_rs0)){
   	  if (is_null($row_rs0["out"])==false) { $myg[14] = $row_rs0["out"]; }	
   }
   
   //.........................90 days void cheque settle.................
   $rs0= "SELECT sum(che_amount) as out from view_s_invcheq where ch_count_ret='0' and cus_code='" . $row["C_CODE"] . "'  and ( che_date>'" . date("Y-m-d") . "' or che_date ='" . date("Y-m-d") . "') ";
   $result_rs0 =$db->RunQuery($rs0);
   if ($row_rs0 = mysql_fetch_array($result_rs0)){
   	  if (is_null($row_rs0["out"])==false) { $Ch_pen = $row_rs0["out"]; }	
   }
  
   
   $rs0= "Select sum(GRAND_TOT - TOTPAY) as out from s_salma where C_CODE='" . $row["C_CODE"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 ";
   $result_rs0 =$db->RunQuery($rs0);
   if ($row_rs0 = mysql_fetch_array($result_rs0)){
   	  if (is_null($row_rs0["out"])==false) { $out_pen = $row_rs0["out"]; }	
   }
   
   
   $myg[15] = $Ch_pen + $out_pen;
       
   
   //...................SISTER COMPANY.................................
   $chq_re = 0;
   $ca_re = 0;
   $Ch_pen = 0;
   $out_pen = 0;
   $rsven= "Select commoncode from vendor where CODE = '" . $row["C_CODE"] . "'";
   $result_rsven =$db->RunQuery($rsven);
   if ($row_rsven = mysql_fetch_array($result_rsven)){
   
    if (trim($row_rsven["commoncode"]) != "0") {
        //.........................90 days selltle history..................
        
		$adddate=date('Y-m-d', strtotime("-97 days"));
   		$adddate1=date('Y-m-d', strtotime("-7 days"));
   
        $rs0= "SELECT sum(che_amount) as reatot from view_s_invcheq where cus_code='" . trim($row_rsven["commoncode"]) . "'  and ( che_date>'" . $adddate . "' or che_date ='" . $adddate . "')  and ( che_date<'" . $adddate1 . "' or che_date ='" . $adddate1 . "') and trn_type <> 'RET' ";
		$result_rs0 =$db->RunQuery($rs0);
   		if ($row_rs0 = mysql_fetch_array($result_rs0)){
			if (is_null($row_rs0["reatot"])==false) { $chq_re = $row_rs0["reatot"]; }	
        }
        
		$adddate=date('Y-m-d', strtotime("-90 days"));

        $rs0= "select sum(CA_CASSH) as ca_reatot from s_crec where CA_CODE = '" . trim($row_rsven["commoncode"]) . "' and ( CA_DATE>'" . $adddate . "' or CA_DATE ='" . $adddate . "')  and ( CA_DATE<'" . date('Y-m-d') . "' or CA_DATE ='" . date('Y-m-d') . "') and CANCELL = '0' and FLAG = 'REC' ";
		$result_rs0 =$db->RunQuery($rs0);
   		if ($row_rs0 = mysql_fetch_array($result_rs0)){
			if (is_null($row_rs0["ca_reatot"])==false) { $ca_re = $row_rs0["ca_reatot"]; }	
        }
               
        $myg[17] = $chq_re + $ca_re;
     
        //.........................90 days void cheque.......................
        
        
        //.........................90 days void cheque settle.................
        $rs0= "SELECT sum(che_amount) as out from view_s_invcheq where ch_count_ret='0' and cus_code='" . trim($row_rsven["commoncode"]) . "'  and ( che_date>'" . date('Y-m-d') . "' or che_date ='" . date('Y-m-d') . "') ";
		$result_rs0 =$db->RunQuery($rs0);
   		if ($row_rs0 = mysql_fetch_array($result_rs0)){
			if (is_null($row_rs0["out"])==false) { $Ch_pen = $row_rs0["out"]; }	
        }
        
        
        $rs0= "Select sum(GRAND_TOT - TOTPAY) as out from s_salma where C_CODE='" . trim($row_rsven["commoncode"]) . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 ";
		$result_rs0 =$db->RunQuery($rs0);
   		if ($row_rs0 = mysql_fetch_array($result_rs0)){
			if (is_null($row_rs0["out"])==false) { $out_pen = $row_rs0["out"]; }	
        }
               
        $myg[18] = $Ch_pen + $out_pen;
    }
   }
   
   //................ END SISTER COMPANY .................................................
   $myg[19] = $row["class"];
   $myg[21] = $row["SAL_EX"];
   
   $myg01="myg".$i."_01";
   $myg02="myg".$i."_02";
   $myg03="myg".$i."_03";
   $myg04="myg".$i."_04";
   $myg05="myg".$i."_05";
   $myg06="myg".$i."_06";
   $myg07="myg".$i."_07";
   $myg08="myg".$i."_08";
   $myg09="myg".$i."_09";
   $myg10="myg".$i."_10";
   $myg11="myg".$i."_11";
   $myg12="myg".$i."_12";
   $myg13="myg".$i."_13";
   $myg14="myg".$i."_14";
   $myg15="myg".$i."_15";
   $myg16="myg".$i."_16";
   $myg17="myg".$i."_17";
   $myg18="myg".$i."_18";
   $myg19="myg".$i."_19";
   $myg20="myg".$i."_20";
   $myg21="myg".$i."_21";
  
   
   $ResponseXML .="<tr><td><div id=\"".$myg01."\">".$myg[1]."</div></td>
   						<td><div id=\"".$myg02."\">".$myg[2]."</div></td>
						<td><div id=\"".$myg03."\">".$myg[3]."</div></td>
						<td><div id=\"".$myg04."\">".$myg[4]."</div></td>
						<td><div id=\"".$myg05."\">".$myg[5]."</div></td>
						<td><div id=\"".$myg06."\">".$myg[6]."</div></td>
						<td><div id=\"".$myg07."\">".$myg[7]."</div></td>
						<td><div id=\"".$myg08."\">".$myg[8]."</div></td>
						<td><div id=\"".$myg09."\">".$myg[9]."</div></td>
						<td><div id=\"".$myg10."\">".$myg[10]."</div></td>
						<td><div id=\"".$myg11."\">".$myg[11]."</div></td>
						<td><div id=\"".$myg12."\">".$myg[12]."</div></td>
						<td><div id=\"".$myg13."\">".$myg[13]."</div></td>
						<td><div id=\"".$myg14."\">".$myg[14]."</div></td>
						<td><div id=\"".$myg15."\">".$myg[15]."</div></td>
						<td><div id=\"".$myg16."\">".$myg[16]."</div></td>
						<td><div id=\"".$myg17."\">".$myg[17]."</div></td>
						<td><div id=\"".$myg18."\">".$myg[18]."</div></td>
						<td><div id=\"".$myg19."\">".$myg[19]."</div></td>
						<td><div id=\"".$myg20."\ onClick=\"appro('".$myg20."');\></div></td>
						<td><div id=\"".$myg21."\">".$myg[21]."</div></td></tr>";
   
   $i=$i+1;
}
		$ResponseXML .="</table>]]></sales_table>";
		$ResponseXML .= "<mcount><![CDATA[".$i."]]></mcount>";
		$ResponseXML .= "</salesdetails>";
		echo $ResponseXML;
			
		}
	
	
if($_GET["Command"]=="save_inv")
	{
		
		//$CrTmpLmt = Val(Format(txt_tmeplimit, General))

		//$REFNO = Trim(txt_cuscode) ' + " Limit:" + Trim(txtcrlimt) + "  Templimit:" + Trim(CrTmpLmt)
/*frmGetAuth.Show 1
 If Not AUTH_OK Then
    MsgBox "You have No Permission"
    Exit Sub
End If
i = 1*/

			$i=1;
			
			while ($_POST["mcount"]>$i){	
				$myg01="myg"+$i+"_01";
   				$myg02="myg"+$i+"_02";
				$myg03="myg"+$i+"_03";
				$myg04="myg"+$i+"_04";
				$myg05="myg"+$i+"_05";
				$myg06="myg"+$i+"_06";
				$myg07="myg"+$i+"_07";
				$myg08="myg"+$i+"_08";
				$myg09="myg"+$i+"_09";
				$myg10="myg"+$i+"_10";
				$myg11="myg"+$i+"_11";
				$myg12="myg"+$i+"_12";
				$myg13="myg"+$i+"_13";
				$myg14="myg"+$i+"_14";
				$myg15="myg"+$i+"_15";
				$myg16="myg"+$i+"_16";
				$myg17="myg"+$i+"_17";
				$myg18="myg"+$i+"_18";
				$myg19="myg"+$i+"_19";
				$myg20="myg"+$i+"_20";
				$myg21="myg"+$i+"_21";
			
				

    if (trim($myg20) == "YES") {
		$AUTH_USER="";
        if (($myg05 > 0) or ($myg11 > 0)) {
            $sql= "insert into tmpcrlmt (sdate, stime, username, tmpLmt, Class, Rep, cusCode, crLmt, cat, FLAG) values ('" . date("Y-m-d") . "','" . date("H:m:s") . "' ,'" . $AUTH_USER . "', '0' , 'NB', 'NR', '" . trim($myg01) . "', '0', 'C', 'PER' )";
			$result =$db->RunQuery($sql);
            
			$sql=  "update vendor set Over_DUE_IG_Date='" . date("Y-m-d") . "'  where code='" . trim($myg01) . "' ";
			$result =$db->RunQuery($sql);
			
            if ($myg08 < 0) {
                $sql=  "insert into tmpcrlmt (sdate, stime, username, tmpLmt, Class, Rep, cusCode, crLmt, cat) values ('" . date("Y-m-d") . "','" . date("H:m:s") . "' ,'" . $AUTH_USER . "'," . (($myg08 - 10) * -1) . " ,'" . trim($myg19) . "','" . trim($myg21) . "','" . trim($myg01) . "'," . $myg03 . ", 'C' )";
				$result =$db->RunQuery($sql);
                
                $sql=  "Update VIEW_repord_brand_btr set Limit_need = Limit_need * -1, Result = 'OK' where C_CODE = '" . trim($myg01) . "' and SAL_EX = '" . trim($myg21) . "' and class = '" . trim($myg19) . "' and INVNO = '0'   ";
				$result =$db->RunQuery($sql);
                
				$sql= "select * from  br_trn where cus_code='" . trim($myg01) . "' and Rep='" . trim($myg21) . "' and brand='" . trim($myg19) . "' ";
				$result =$db->RunQuery($sql);
   				if ($row = mysql_fetch_array($result)){
                
                   $sql_br= "insert into br_trn (cus_code, Rep, credit_lim, brand, tmpLmt, day) values ('" . trim($myg01) . "','" . trim($myg21) . "', '0', '" . trim($myg19) . "', " . (($myg08 - 10) * -1) . ", '" . date("Y-m-d") . "' )";
				   $result_br =$db->RunQuery($sql_br);
                } else {
                    $sql_br= "update br_trn set tmpLmt= " . (($myg08 - 10) * -1) . " , day = '" . date("Y-m-d") . "' where cus_code='" . trim($myg01) . "' and Rep='" . trim($myg21) . "' and brand='" . trim($myg19) . "' ";
					$result_br =$db->RunQuery($sql_br);

                }
                
            }
        } else {
            $sql= "insert into tmpcrlmt (sdate, stime, username, tmpLmt, Class, Rep, cusCode, crLmt, cat) values ('" . date("Y-m-d") . "','" . date("H:m:s") . "' ,'" . $AUTH_USER . "'," . (($myg08 - 10) * -1) . " ,'" . trim($myg19) . "','" . trim($myg21) . "','" . trim($myg01) . "'," . $myg03 . ", 'C' )";
            $result =$db->RunQuery($sql);
			
            $sql= "Update view_repord_brand_btr set Limit_need = Limit_need * -1, Result = 'OK' where C_CODE = '" . trim($myg01) . "' and SAL_EX = '" . trim($myg21) . "' and class = '" . trim($myg19) . "' and INVNO = '0'   ";
			$result =$db->RunQuery($sql);
			
            $sql_br= "select * from  br_trn where cus_code='" . trim($myg01) . "' and Rep='" . trim($myg21) . "' and brand='" . trim($myg19) . "' ";
			$result_br =$db->RunQuery($sql_br);
			if ($row_br = mysql_fetch_array($result_br)){
			
               $sql= "insert into br_trn (cus_code, rep, credit_lim, brand, tmpLmt, day) values ('" . trim($myg01) . "','" . trim($myg21) . "','0','" . trim($myg19) . "'," . (($myg08 - 10) * -1) . ", '" . date("Y-m-d") . "' )";
			   $result =$db->RunQuery($sql);
            } else {
               $sql= "update br_trn set tmpLmt= " . (($myg08 - 10) * -1) . " , day = '" . date("Y-m-d") . "' where cus_code='" . trim($myg01) . "' and Rep='" . trim($myg21) . "' and brand='" . trim($myg19) . "' ";
			   $result =$db->RunQuery($sql);
               
            }
            
        }
    } else {
        if (trim($myg20) == "No") { 
			$sql = "Update view_repord_brand_btr set Limit_need = Limit_need * -1, Result = 'No' where C_CODE = '" . trim($myg01) . "' and INVNO = '0'  and SAL_EX = '" . trim($myg21) . "' and class = '" . trim($myg19) . "'   ";
			$result =$db->RunQuery($sql);
		}	
    }
    $i = $i + 1;
}
echo  "Selected Limits Approved";
			
				
			
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
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_grn_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
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
							
			
			$sql="Select * from tmp_grn_data where str_invno='".$_GET['invno']."'";
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
							
                $ResponseXML .= "   </table>]]></sales_table></salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	
if($_GET["Command"]=="save_item")
{

	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
	/*		$_SESSION["CURRENT_DOC"] = 1;      //document ID
			$_SESSION["VIEW_DOC"] = false ;     //view current document
			$_SESSION["FEED_DOC"] = true;       //save  current document
			$_GET["MOD_DOC"] = false  ;         //delete   current document
			$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
			$_GET["PRICE_EDIT"] = false ;       //edit selling price
			$_GET["CHECK_USER"] = false ;       //check user permission again

	*/
	
	
	
			$mvatrate=12;
			
			$cre_balance=str_replace(",", "", $_GET["balance"]);
			$totdiscount=str_replace(",", "", $_GET["totdiscount"]);
			$subtot=str_replace(",", "", $_GET["subtot"]);
			$invtot=str_replace(",", "", $_GET["invtot"]);
		  
			
			// Insert c_bal ============================================================ 
			
			$sql="insert into c_bal(REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate, RNO, Cancell) values ('".$_GET["grnno"]."', '".$_GET["grndate"]."', 'GRN', '".$_GET["cusno"]."', ".$invtot.", ".$invtot.", '".$_GET["brand"]."', '".$_GET["department"]."', '".$_GET["salesrep"]."', '0', ".$mvatrate.", '".$_GET["rno"]."', '0')";
			
			$result =$db->RunQuery($sql);
			
			$sql="insert into s_crnma(REF_NO, SDATE, INVOICENO, DDATE, C_CODE, CUS_NAME, GRAND_TOT, DIS, DEPARTMENT, DEP_CODE, Brand, SAL_EX, DEV, GST, seri_no, vatrate, CANCELL) values ('".$_GET["grnno"]."', '".$_GET["grndate"]."', '".$_GET["invno"]."', '".$_GET["invdate"]."', '".$_GET["cusno"]."', '".$_GET["cusname"]."', ".$invtot.", ".$totdiscount.", '".$_GET["department"]."', '".$_GET["department"]."', '".$_GET["brand"]."', '".$_GET["salesrep"]."', '0', ".$mvatrate.", '".$_GET["serialno"]."', ".$mvatrate.", '0')";
			
			$result =$db->RunQuery($sql);
			
			if ($_GET["serialno"]!=""){
				$sql="update seri_trn set loc='01', Sold='0' where seri_no='".$_GET["serialno"]."'";
				$result =$db->RunQuery($sql);
			}
		
			$i=1;
			
			while($_GET["mcou"]>$i){
				$stkno="stkno".$i;
				$descript="descript".$i;
				$price="price".$i;
				$qty="qty".$i;
				$preretqty="preret"+$i;
				$retqty="ret".$i;
				$disc="disc".$i;
				$subtot="subtot".$i;
				
				if ($_GET[$retqty]>0){
					$sql="insert into s_crntrn(REF_NO, STK_NO, SDATE, DESCRIPT, PRICE, DIS_P, QTY, DEPARTMENT, VAT, Seri_no, vatrate) values ('".$_GET["grnno"]."', '".$_GET[$stkno]."', '".$_GET["grndate"]."', '".$_GET[$descript]."', '".$_GET[$price]."', '".$_GET[$disc]."', ".$_GET[$retqty].", '".$_GET["department"]."', '".$_GET["vatmethod"]."', '".$_GET["serialno"]."', ".$mvatrate.")";
					//echo $sql;
					$result =$db->RunQuery($sql);
					
					$sql="update s_invo set ret_qty=ret_qty+".$_GET[$retqty]." where REF_NO='".$_GET["grnno"]."' and STK_NO='".$_GET[$stkno]."'";
					
					$result =$db->RunQuery($sql);
					
					$sql="update s_mas set QTYINHAND=QTYINHAND+".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."'";
					
					$result =$db->RunQuery($sql);
					
					$sql="update s_submas set QTYINHAND=QTYINHAND+".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."' and STO_CODE='".$_GET["department"]."'";
					
					$result =$db->RunQuery($sql);
					
					$sql="insert into s_trn(STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, seri_no) values ('".$stkno."', '".$_GET["grndate"]."', '".$_GET["grnno"]."', ".$_GET[$retqty].", 'GRN', '".$_GET["department"]."', '".$_GET["serialno"]."')";
					
					$result =$db->RunQuery($sql);
					
					
				}
				
				$i=$i+1;
			}
			
			
			$sql="update s_salma set RET_AMO=RET_AMO+".$_GET["invtot"]." where REF_NO='".$_GET["grnno"]."' ";
			
			$result =$db->RunQuery($sql);
					
			$sql="insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values ('".$_GET["grnno"]."', '".$_GET["grndate"]."', '".$_GET["cusno"]."', ".$_GET["invtot"].", 'GRN', '".$_GET["department"]."', '0') ";
			
			$result =$db->RunQuery($sql);

			$sql="update vendor set CUR_BAL=CUR_BAL-".$_GET["invtot"]." where CODE='".$_GET["cusno"]."' ";
			
			$result =$db->RunQuery($sql);
			
			$sql="update invpara set grn=grn+1 ";
			
			$result =$db->RunQuery($sql);


			
			echo "Saved";
			
			
	}
	

if($_GET["Command"]=="cancel_inv")
{

	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
	/*		$_SESSION["CURRENT_DOC"] = 1;      //document ID
			$_SESSION["VIEW_DOC"] = false ;     //view current document
			$_SESSION["FEED_DOC"] = true;       //save  current document
			$_GET["MOD_DOC"] = false  ;         //delete   current document
			$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
			$_GET["PRICE_EDIT"] = false ;       //edit selling price
			$_GET["CHECK_USER"] = false ;       //check user permission again

	*/
			$mvatrate=12;
			
			$cre_balance=str_replace(",", "", $_GET["balance"]);
			$totdiscount=str_replace(",", "", $_GET["totdiscount"]);
			$subtot=str_replace(",", "", $_GET["subtot"]);
			$invtot=str_replace(",", "", $_GET["invtot"]);
		  
			
			$sql="select * from c_bal where REFNO='".$_GET["grnno"]."'";
			$result =$db->RunQuery($sql);
			if ($row = mysql_fetch_array($result)) {
				if ($row["AMOUNT"]==$row["BALANCE"]){
					$sql1="update s_crnma set CANCELL='1' where REF_NO='".$_GET["grnno"]."'";
					$result1 =$db->RunQuery($sql1);
					
					$sql1="update s_crntrn set CANCELL='1' where REF_NO='".$_GET["grnno"]."'";
					$result1 =$db->RunQuery($sql1);
					
					$sql1="delete from c_bal where REFNO='".$_GET["grnno"]."'";
					$result1 =$db->RunQuery($sql1);
                  
				
					$i=1;
					while ($_GET["mcou"]>$i){
						$stkno="stkno".$i;
						$descript="descript".$i;
						$price="price"+i;
						$qty="qty"+i;
						$preretqty="preret"+i;
						$retqty="ret"+i;
						$disc="disc"+i;
						$subtot="subtot"+i;
				
						if ($_GET[$retqty]>0){
							$sql1="update s_invo set ret_qty=ret_qty-".$_GET[$retqty]." where REF_NO='".$_GET["grnno"]."' and STK_NO='".$_GET[$stkno]."'";
							$result1 =$db->RunQuery($sql1);
											
							$sql1="update s_mas set QTYINHAND=QTYINHAND-".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."'";
							$result1 =$db->RunQuery($sql1);
					
							$sql1="update s_submas set QTYINHAND=QTYINHAND-".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."' and STO_CODE='".$_GET["department"]."'";
							$result1 =$db->RunQuery($sql1);
					
                           
						}
						$i=$i+1;
					}
			
					$sql1="delete from s_trn where ltrim(REFNO)='".$_GET["grnno"]."'";
					$result1 =$db->RunQuery($sql1);
							
					$sql1="delete from s_led where REF_NO='".$_GET["grnno"]."'";
					$result1 =$db->RunQuery($sql1);
			
		            $sql1="update s_salma set RET_AMO=RET_AMO+".$_GET["invtot"]." where REF_NO='".$_GET["grnno"]."'";
					$result1 =$db->RunQuery($sql1);
			        
        		    $sql1="update vendor set CUR_BAL=CUR_BAL+".$_GET["invtot"]." where CODE='".$_GET["cusno"]."'";
					$result1 =$db->RunQuery($sql1);        
               
				}
				
			}	


			
			echo "Canceled";
			
			
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