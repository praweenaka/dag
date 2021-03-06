<?php 
session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("connectioni.php");
	
	
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
		
		if($_GET["Command"]=="add_address")
		{
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;
			
			
	/*		$sql="Select * from tmp_army_no where edu= '".$_GET['edu']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			if($row = mysqli_fetch_array($result)){
				$ResponseXML .= "exist";
				
				
				
			}	else {*/
			
		//	$ResponseXML .= "";
			//$ResponseXML .= "<ArmyDetails>";
			
		/*	$sql1="Select * from mas_educational_qualifications where str_Educational_Qualification= '".$_GET['edu']."'";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			$row1 = mysqli_fetch_array($result1);
			$ResponseXML .=  $row1["int_Educational_Qulifications"];*/
			
			$sqlt="Select * from customer_mast where id ='".$_GET['customerid']."'";
			
			$resultt =mysqli_query($GLOBALS['dbinv'],$sqlt) ; 
			if ($rowt = mysqli_fetch_array($resultt)){
				echo $rowt["str_address"];
			}
			
			
				
			
	}
	
			
		if($_GET["Command"]=="view_from")
		{
			
			include('connection_server.php');
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
      <td colspan=9 background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Order Details</font></td>
	  <td colspan=3 background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">IF</font></td>
	  <td colspan=2 background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">L3M</font></td>
	  <td colspan=2 background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">N3M</font></td>
	  <td background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">THT L3M</font></td>
	  <td background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">THT N3M</font></td>
																		
         <tr>
                <td><b>Code</b></td>
               <td><b>Name</b></td>
               <td><b>Limit</b></td>
               <td><b>Outstanding</b></td>
               <td><b>Ret Chq</b></td>
               <td><b>Ret Chq - BEN</b></td>
               <td><b>Order Val</b></td>
                <td><b>Ex Limit</b></td>
               <td><b></b></td>
               <td><b>PD for Rtn</b></td>
               <td><b>Over 60</b></td>
               <td><b></b></td>
                <td><b>Settlement</b></td>
                <td><b>Ret Chq</b></td>
                <td><b>Settlement</b></td>
                <td><b></b></td>
                <td><b>Settlement</b></td>
                <td><b>Settlement</b></td>
                <td><b>Type</b></td>
                </tr>";
                   												
																
	//$sql=  "Select C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from view_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND Limit_need > '0' and Forward = 'MM'  Group by  C_CODE,NAME,SAL_EX,class order by C_CODE";
	
if ($_SESSION["CURRENT_USER"] == "rohan") {
	$sql=  "Select C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from view_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND  Forward = 'WD' and Result = 'P'  Group by  C_CODE,NAME,SAL_EX,class order by C_CODE";
	   
} else {
    if ($_SESSION["CURRENT_USER"] == "MD") {
		$sql=  "Select C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from view_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND  Forward = 'MD' and Result = 'P'  Group by  C_CODE,NAME,SAL_EX,class order by C_CODE";
		       
    } else {
        if ($_SESSION["CURRENT_USER"] == "Errol") {
			//$sql=  "Select C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from view_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND Limit_need > '0' and Forward = 'MM' and approveby = '0' and rgroup = 'B1'  Group by  C_CODE,NAME,SAL_EX,class order by C_CODE";
			
			$sql=  "Select C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from view_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND Limit_need > '0' and Forward = 'MM' and approveby = '0'  Group by  C_CODE,NAME,SAL_EX,class order by C_CODE";
			
           
        } else {
		
			$sql=  "Select C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from view_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND Limit_need > '0' and Forward = 'MM'  Group by  C_CODE,NAME,SAL_EX,class order by C_CODE";
		    
        }
    }
}

	//echo $sql;
$i = 1;

if ($_SESSION['company']=="THT"){
		$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbtht);
	} else if ($_SESSION['company']=="BEN"){
		$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbben);
	}
	

while ($row = mysqli_fetch_array($result)){
	$limit = 0;
   	$out = 0;
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
	//echo $rs3;
	if ($_SESSION['company']=="THT"){
		$result3=mysqli_query($GLOBALS['dbinv'],$rs3, $dbtht);
	} else if ($_SESSION['company']=="BEN"){
		$result3=mysqli_query($GLOBALS['dbinv'],$rs3, $dbben);
	}
   
	if ($row3 = mysqli_fetch_array($result3)){
		
      	if (is_null($row3["CAT"])==false) {
        	if (trim($row3["CAT"]) == "A") { $limit = $row3["credit_lim"] * 2.5; }
         	if (trim($row3["CAT"]) == "B") { $limit = $row3["credit_lim"] * 2.5; }
         	if (trim($row3["CAT"]) == "C") { $limit = $row3["credit_lim"] * 1; }
         	
			$myg[3] = $limit;
      	} else {
			
         	$myg[3] = 0;
      	}
   	}
  
   
   
    $findref= "SELECT * From ref_history WHERE  (NewRefNo = '" . $row["SAL_EX"] . "')";
    $OldRefno = "";
    $NewRefNo = "";
	
	if ($_SESSION['company']=="THT"){
		$result_findref=mysqli_query($GLOBALS['dbinv'],$findref, $dbtht);
	} else if ($_SESSION['company']=="BEN"){
		$result_findref=mysqli_query($GLOBALS['dbinv'],$findref, $dbben);
	}
	
	if ($row_findref = mysqli_fetch_array($result_findref)){
   
        $OldRefno = $row_findref["OldRefno"];
        $NewRefNo = $row_findref["NewRefNo"];
    }
    
   //=========================================================
   if ($row["SAL_EX"] == $NewRefNo) {
        $rs0= "Select sum(GRAND_TOT - TOTPAY) as out1 from view_s_salma  where class='" . $row["class"] . "' and GRAND_TOT > TOTPAY and CANCELL='0' and C_CODE='" . $row["C_CODE"] . "' and (SAL_EX = '" . $row["SAL_EX"] . "' or SAL_EX = '" . $OldRefno . "')";
   } else {
        $rs0= "Select sum(GRAND_TOT - TOTPAY) as out1 from view_s_salma  where class='" . $row["class"] . "' and GRAND_TOT > TOTPAY and CANCELL='0' and C_CODE='" . $row["C_CODE"] . "' and SAL_EX = '" . $row["SAL_EX"] . "'  ";
   }
  //echo $rs0;
  
    if ($_SESSION['company']=="THT"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
	} else if ($_SESSION['company']=="BEN"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
	}
	
   if ($row_rs0 = mysqli_fetch_array($result_rs0)){
      if (is_null($row_rs0["out1"])==false ) { $out = $row_rs0["out1"]; }
      $myg[4] = $out;
   }
   
   
   if ($row["SAL_EX"] == $NewRefNo) {
        $rs0 = "Select sum(ST_PAID) as out1 from view_sinvcheq_sttr_salma  where che_date >  '" . $_GET["dtfrom"] . "' and C_CODE='" . $row["C_CODE"] . "' and (sal_ex = '" . $row["SAL_EX"] . "' or sal_ex = '" . $OldRefno . "') and class = '" . $row["class"] . "'  ";
   } else {
        $rs0= "Select sum(ST_PAID) as out1 from view_sinvcheq_sttr_salma  where che_date >  '" . $_GET["dtfrom"] . "' and C_CODE='" . $row["C_CODE"] . "' and SAL_EX = '" . $row["SAL_EX"] . "' and class = '" . $row["class"] . "'  ";
   }
   
   if ($_SESSION['company']=="THT"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
	} else if ($_SESSION['company']=="BEN"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
	}
   
  
   if ($row_rs0 = mysqli_fetch_array($result_rs0)){
      if (is_null($row_rs0["out1"])==false) { $out = $out + $row_rs0["out1"]; }
      	$myg[4] = $out;
   }
   
   
   $rs0= "Select sum(CR_CHEVAL-paid) as out1 from s_cheq  where  CR_CHEVAL > PAID  and CR_C_CODE='" . $row["C_CODE"] . "' and CR_FLAG != 'c'  "; 
   
   if ($_SESSION['company']=="THT"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);  
	} else if ($_SESSION['company']=="BEN"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);  
	}
   if ($row_rs0 = mysqli_fetch_array($result_rs0)){
      if (is_null($row_rs0["out1"])==false) { $rtn_ch = $row_rs0["out1"]; }
      	$myg[5] = $rtn_ch;
   }
   
   //------------------------------------------------------BPL Return Chq-------------------------------------------------------------
   
  if ($_SESSION['company']=="BEN"){
   $rsven= "Select commoncode from vendor where CODE = '" . $row["C_CODE"] . "' ";
   $result_rsven=mysqli_query($GLOBALS['dbinv'],$rsven, $dbben);
  
   if ($row_rsven = mysqli_fetch_array($result_rsven)){
       if ($row_rsven["commoncode"] != "0") {
            $rs0= "Select sum(CR_CHEVAL-PAID) as out1 from s_cheq  where  CR_CHEVAL > PAID  and CR_C_CODE='" . trim($result_rsven["commoncode"]) . "' and CR_FLAG != 'c'  ";
			 $result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
			
   			if ($row_rs0 = mysqli_fetch_array($result_rs0)){
                if (is_null($row_rs0["out1"])==false) { $rtn_ch_n = $row_rs0["out1"]; }
                $myg[6] = $rtn_ch_n;
            }
            
        }
   }
  } 
   
    //------------------------------------------------------THT Return Chq-------------------------------------------------------------
  
  if ($_SESSION['company']=="THT"){
   $rsven= "Select commoncode from vendor where CODE = '" . $row["C_CODE"] . "' ";
   $result_rsven=mysqli_query($GLOBALS['dbinv'],$rsven, $dbtht);
  
   if ($row_rsven = mysqli_fetch_array($result_rsven)){
       if ($row_rsven["commoncode"] != "0") {
            $rs0= "Select sum(CR_CHEVAL-PAID) as out1 from s_cheq  where  CR_CHEVAL > PAID  and CR_C_CODE='" . trim($result_rsven["commoncode"]) . "' and CR_FLAG != 'c'  ";
			 $result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
			
   			if ($row_rs0 = mysqli_fetch_array($result_rs0)){
                if (is_null($row_rs0["out1"])==false) { $rtn_ch_n = $row_rs0["out1"]; }
                $myg[6] = $rtn_ch_n;
            }
            
        }
   }
  } 
   
   //----------------------------------------------------------------------------------------------------------------------------------
   
   $myg[7] = $row["amount"];
   
   $rs0= "Select sum(che_amount) as out1 from s_invcheq where  che_date > '" . $_GET["dtfrom"] . "'   and cus_code='" . $row["C_CODE"] . "' and trn_type = 'RET'  ";
    
   if ($_SESSION['company']=="THT"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
		
	} else if ($_SESSION['company']=="BEN"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
	}
	  
   if ($row_rs0 = mysqli_fetch_array($result_rs0)){
   
      if (is_null($row_rs0["out1"])==false) { $out = $out + $row_rs0["out1"]; }
      	$myg[4] = $out;
      	if (is_null($row_rs0["out1"])==false) { $myg[10] = $row_rs0["out1"]; }
   }
   
   
   $myg[8] = $limit - $out - $rtn_ch - $row["amount"];
   
   //.........................Ovr 60.............
   $adddate=date('Y-m-d', strtotime("-60 days"));
   
   $rs0= "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where  GRAND_TOT > TOTPAY and sdate <='" . $adddate . "'  and C_CODE='" . $row["C_CODE"] . "' and CANCELL = '0'  ";
    
	
	if ($_SESSION['company']=="THT"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
		
	} else if ($_SESSION['company']=="BEN"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
	}
	
   if ($row_rs0 = mysqli_fetch_array($result_rs0)){
        if (is_null($row_rs0["out1"])==false) { 
			$myg[11] = $$row_rs0["out1"];
		}	
   }
   
   
   //.........................90 days selltle history..................
   
   $adddate=date('Y-m-d', strtotime("-97 days"));
   $adddate1=date('Y-m-d', strtotime("-7 days"));
   
   $rs0= "SELECT sum(che_amount) as reatot from view_s_invcheq where cus_code='" . $row["C_CODE"] . "'  and ( che_date>'" . $adddate . "' or che_date ='" . $adddate . "')  and ( che_date<'" . $adddate1 . "' or che_date ='" . $adddate1 . "') and trn_type <> 'RET' ";
   
 	if ($_SESSION['company']=="THT"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
		
	} else if ($_SESSION['company']=="BEN"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
	}
	
   if ($row_rs0 = mysqli_fetch_array($result_rs0)){
   	if (is_null($row_rs0["reatot"])==false) { $chq_re = $row_rs0["reatot"]; }
   }
   
    $adddate=date('Y-m-d', strtotime("-90 days"));
   $rs0= "select sum(CA_CASSH) as ca_reatot from s_crec where CA_CODE = '" . $row["C_CODE"] . "' and ( CA_DATE>'" . $adddate . "' or CA_DATE ='" . $adddate . "')  and ( CA_DATE<'" . date("Y-m-d") . "' or CA_DATE ='" . date("Y-m-d") . "') and CANCELL = '0' and FLAG = 'REC' ";
   
 	if ($_SESSION['company']=="THT"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
		
	} else if ($_SESSION['company']=="BEN"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
	}
	
   if ($row_rs0 = mysqli_fetch_array($result_rs0)){
   	if (is_null($row_rs0["ca_reatot"])==false) { $ca_re = $row_rs0["ca_reatot"]; }
   }
   
   $myg[13] = $chq_re + $ca_re;

   //.........................90 days void cheque.......................
   
   $adddate=date('Y-m-d', strtotime("-90 days"));
   $rs0= "SELECT sum(CR_CHEVAL) as out1 from s_cheq where  (CR_DATE>'" . $adddate . "'or CR_DATE='" . $adddate . "')and (CR_DATE<'" . date("Y-m-d") . "'or CR_DATE='" . date("Y-m-d") . "') and CR_C_CODE = '" . $row["C_CODE"] . "' and CR_FLAG='0' ";
   
   if ($_SESSION['company']=="THT"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
		
	} else if ($_SESSION['company']=="BEN"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
	}
	
   if ($row_rs0 = mysqli_fetch_array($result_rs0)){
   	  if (is_null($row_rs0["out1"])==false) { $myg[14] = $row_rs0["out1"]; }	
   }
   
   //.........................90 days void cheque settle.................
   $rs0= "SELECT sum(che_amount) as out1 from view_s_invcheq where ch_count_ret='0' and cus_code='" . $row["C_CODE"] . "'  and ( che_date>'" . date("Y-m-d") . "' or che_date ='" . date("Y-m-d") . "') ";
   if ($_SESSION['company']=="THT"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
	} else if ($_SESSION['company']=="BEN"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
	}
   
  
   if ($row_rs0 = mysqli_fetch_array($result_rs0)){
   	  if (is_null($row_rs0["out1"])==false) { $Ch_pen = $row_rs0["out1"]; }	
   }
  
   
   $rs0= "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE='" . $row["C_CODE"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 ";
   
  if ($_SESSION['company']=="THT"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
	} else if ($_SESSION['company']=="BEN"){
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
	}
	
   if ($row_rs0 = mysqli_fetch_array($result_rs0)){
   	  if (is_null($row_rs0["out1"])==false) { $out_pen = $row_rs0["out1"]; }	
   }
   
   
   $myg[15] = $Ch_pen + $out_pen;
       
   
   //...................SISTER COMPANY.................................
   
   ///////////////// Start of THT //////////////////////////////////////////////   
 
if ($_SESSION["CURRENT_USER"]=="THT"){   

   $chq_re = 0;
   $ca_re = 0;
   $Ch_pen = 0;
   $out_pen = 0;
   $rsven= "Select commoncode from vendor where CODE = '" . $row["C_CODE"] . "'";
   $result_rsven=mysqli_query($GLOBALS['dbinv'],$rsven, $dbben);
  
   if ($row_rsven = mysqli_fetch_array($result_rsven)){
   
    if (trim($row_rsven["commoncode"]) != "0") {
        //.........................90 days selltle history..................
        
		$adddate=date('Y-m-d', strtotime("-97 days"));
   		$adddate1=date('Y-m-d', strtotime("-7 days"));
   
        $rs0= "SELECT sum(che_amount) as reatot from view_s_invcheq where cus_code='" . trim($row_rsven["commoncode"]) . "'  and ( che_date>'" . $adddate . "' or che_date ='" . $adddate . "')  and ( che_date<'" . $adddate1 . "' or che_date ='" . $adddate1 . "') and trn_type <> 'RET' ";
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
	
   		if ($row_rs0 = mysqli_fetch_array($result_rs0)){
			if (is_null($row_rs0["reatot"])==false) { $chq_re = $row_rs0["reatot"]; }	
        }
        
		$adddate=date('Y-m-d', strtotime("-90 days"));

        $rs0= "select sum(CA_CASSH) as ca_reatot from s_crec where CA_CODE = '" . trim($row_rsven["commoncode"]) . "' and ( CA_DATE>'" . $adddate . "' or CA_DATE ='" . $adddate . "')  and ( CA_DATE<'" . date('Y-m-d') . "' or CA_DATE ='" . date('Y-m-d') . "') and CANCELL = '0' and FLAG = 'REC' ";
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
		
   		if ($row_rs0 = mysqli_fetch_array($result_rs0)){
			if (is_null($row_rs0["ca_reatot"])==false) { $ca_re = $row_rs0["ca_reatot"]; }	
        }
               
        $myg[17] = $chq_re + $ca_re;
     
        //.........................90 days void cheque.......................
        
        
        //.........................90 days void cheque settle.................
        $rs0= "SELECT sum(che_amount) as out1 from view_s_invcheq where ch_count_ret='0' and cus_code='" . trim($row_rsven["commoncode"]) . "'  and ( che_date>'" . date('Y-m-d') . "' or che_date ='" . date('Y-m-d') . "') ";
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
		
   		if ($row_rs0 = mysqli_fetch_array($result_rs0)){
			if (is_null($row_rs0["out1"])==false) { $Ch_pen = $row_rs0["out1"]; }	
        }
        
        
        $rs0= "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE='" . trim($row_rsven["commoncode"]) . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 ";
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbben);
		
   		if ($row_rs0 = mysqli_fetch_array($result_rs0)){
			if (is_null($row_rs0["out1"])==false) { $out_pen = $row_rs0["out1"]; }	
        }
               
        $myg[18] = $Ch_pen + $out_pen;
    }
   }
}   
   ///////////////// End of THT //////////////////////////////////////////////
   
   
   
   
   
      ///////////////// Start of BPL //////////////////////////////////////////////   
   
 if ($_SESSION["CURRENT_USER"]=="BEN"){
   $chq_re = 0;
   $ca_re = 0;
   $Ch_pen = 0;
   $out_pen = 0;
   $rsven= "Select commoncode from vendor where CODE = '" . $row["C_CODE"] . "'";
   $result_rsven=mysqli_query($GLOBALS['dbinv'],$rsven, $dbtht);
  
   if ($row_rsven = mysqli_fetch_array($result_rsven)){
   
    if (trim($row_rsven["commoncode"]) != "0") {
        //.........................90 days selltle history..................
        
		$adddate=date('Y-m-d', strtotime("-97 days"));
   		$adddate1=date('Y-m-d', strtotime("-7 days"));
   
        $rs0= "SELECT sum(che_amount) as reatot from view_s_invcheq where cus_code='" . trim($row_rsven["commoncode"]) . "'  and ( che_date>'" . $adddate . "' or che_date ='" . $adddate . "')  and ( che_date<'" . $adddate1 . "' or che_date ='" . $adddate1 . "') and trn_type <> 'RET' ";
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
	
   		if ($row_rs0 = mysqli_fetch_array($result_rs0)){
			if (is_null($row_rs0["reatot"])==false) { $chq_re = $row_rs0["reatot"]; }	
        }
        
		$adddate=date('Y-m-d', strtotime("-90 days"));

        $rs0= "select sum(CA_CASSH) as ca_reatot from s_crec where CA_CODE = '" . trim($row_rsven["commoncode"]) . "' and ( CA_DATE>'" . $adddate . "' or CA_DATE ='" . $adddate . "')  and ( CA_DATE<'" . date('Y-m-d') . "' or CA_DATE ='" . date('Y-m-d') . "') and CANCELL = '0' and FLAG = 'REC' ";
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
		
   		if ($row_rs0 = mysqli_fetch_array($result_rs0)){
			if (is_null($row_rs0["ca_reatot"])==false) { $ca_re = $row_rs0["ca_reatot"]; }	
        }
               
        $myg[17] = $chq_re + $ca_re;
     
        //.........................90 days void cheque.......................
        
        
        //.........................90 days void cheque settle.................
        $rs0= "SELECT sum(che_amount) as out1 from view_s_invcheq where ch_count_ret='0' and cus_code='" . trim($row_rsven["commoncode"]) . "'  and ( che_date>'" . date('Y-m-d') . "' or che_date ='" . date('Y-m-d') . "') ";
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
		
   		if ($row_rs0 = mysqli_fetch_array($result_rs0)){
			if (is_null($row_rs0["out1"])==false) { $Ch_pen = $row_rs0["out1"]; }	
        }
        
        
        $rs0= "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE='" . trim($row_rsven["commoncode"]) . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 ";
		$result_rs0=mysqli_query($GLOBALS['dbinv'],$rs0, $dbtht);
		
   		if ($row_rs0 = mysqli_fetch_array($result_rs0)){
			if (is_null($row_rs0["out1"])==false) { $out_pen = $row_rs0["out1"]; }	
        }
               
        $myg[18] = $Ch_pen + $out_pen;
    }
   }
  }
   ///////////////// End of BPL //////////////////////////////////////////////
   
   
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
						<td align=right><div align=right id=\"".$myg03."\">".$myg[3]."</div></td>
						<td align=right><div align=right id=\"".$myg04."\">".number_format($myg[4], 2, ".", ",")."</div></td>
						<td align=right><div align=right id=\"".$myg05."\">".number_format($myg[5], 2, ".", ",")."</div></td>
						<td align=right><div align=right id=\"".$myg06."\">".number_format($myg[6], 2, ".", ",")."</div></td>
						<td align=right><div align=right id=\"".$myg07."\">".number_format($myg[7], 2, ".", ",")."</div></td>
						<td align=right><div align=right id=\"".$myg08."\">".number_format($myg[8], 2, ".", ",")."</div></td>
						<td align=right><div align=right id=\"".$myg09."\">".$myg[9]."</div></td>
						<td align=right><div align=right id=\"".$myg10."\">".$myg[10]."</div></td>
						<td align=right><div align=right id=\"".$myg11."\">".$myg[11]."</div></td>
						<td align=right><div align=right id=\"".$myg12."\">".$myg[12]."</div></td>
						<td align=right><div align=right id=\"".$myg13."\">".number_format($myg[13], 2, ".", ",")."</div></td>
						<td align=right><div align=right id=\"".$myg14."\">".$myg[14]."</div></td>
						<td align=right><div align=right id=\"".$myg15."\">".number_format($myg[15], 2, ".", ",")."</div></td>
						<td align=right><div align=right id=\"".$myg16."\">".$myg[16]."</div></td>
						<td align=right><div align=right id=\"".$myg17."\">".$myg[17]."</div></td>
						<td align=right><div align=right id=\"".$myg18."\">".$myg[18]."</div></td>
						<td align=right><div align=right id=\"".$myg19."\">".$myg[19]."</div></td>
						<td onclick=\"appro('".$i."');\"><div id=\"".$myg20."\">---</div></td>
						<td><div id=\"".$myg21."\">".$myg[21]."</div></td></tr>";
   
   $i=$i+1;
}
		$ResponseXML .="</table>]]></sales_table>";
		$ResponseXML .= "<mcount><![CDATA[".$i."]]></mcount>";
		$ResponseXML .= "</salesdetails>";
		echo $ResponseXML;
			
}
	
	
if($_GET["Command"]=="appro")
{
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
			
	
	
    if (trim($_GET["myg01"]) != "---"){
        if (trim($_GET["myg20"]) == "YES") {
            $myg20 = "No";
        	$ResponseXML .= "<warn><![CDATA[]]></warn>";
		} else {
            $limit = 0;
            $c = 1;
            $rst= "Select * from br_trn where cus_code = '" . trim($_GET["myg01"]) . "' and Rep = '" . trim($_GET["myg21"]) . "' and credit_lim > '0'";
            $result_rst =mysqli_query($GLOBALS['dbinv'],$rst);
   			while ($row_rst = mysqli_fetch_array($result_rst)){
                if (trim($row_rst["CAT"]) != "C") { $c = $c * 2.5; }
                $limit = $limit + ($row_rst["credit_lim"] * $c);
            }
            
            if ($limit > 0) {
                $chk = (($_GET["myg08"] * -1) / $limit) * 100;
            } else {
                $chk = 100;
            }
            
			$rst= "Select * from   userpermission where docid = '29' and username = '" . trim($_SESSION["CURRENT_USER"]) . "'";
            $result_rst =mysqli_query($GLOBALS['dbinv'],$rst);
   			if ($row_rst = mysqli_fetch_array($result_rst)){
			
                if ($row_rst["doc_mod"] == "1") {
                    if ($chk > "25") {
						$ResponseXML .= "<warn><![CDATA[You are trying to exceed more then 25% Exceed limit]]></warn>";
                        //msg = MsgBox("You are trying to exceed more then 25% Exceed limit", vbYesNo, "Warning")
                        //If msg = vbYes Then
                         //   $myg20 = "YES";
                        //Else
                        //    myg.TextMatrix(myg.Row, 20) = ""
                        //End If
                    } else {
                        $myg20 = "YES";
						$ResponseXML .= "<warn><![CDATA[]]></warn>";
                    }
                } else {
                    if ($chk > "25") {
                        exit("Sorry you are trying to exceed more then 25% Exceed limit");
                    } else {
                        $myg20 = "YES";
                    }
					$ResponseXML .= "<warn><![CDATA[]]></warn>";
                }
            } else {
				$ResponseXML .= "<warn><![CDATA[]]></warn>";
			}
        }
    } else {
		$ResponseXML .= "<warn><![CDATA[]]></warn>";
	}
	
	$ResponseXML .= "<resmyg20><![CDATA[".$myg20."]]></resmyg20>";
	$ResponseXML .= "<i><![CDATA[".$_GET["i"]."]]></i>";
	$ResponseXML .= "</salesdetails>";
		echo $ResponseXML;
}
	

if($_POST["Command"]=="save_inv")
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
			
		//	echo $myg20;
	//echo $_POST[$myg20];
    	if (trim($_POST[$myg20]) == "YES") {
		//echo $_POST[$myg20];
		//	$AUTH_USER="";
        	if (($_POST[$myg05] > 0) or ($_POST[$myg11] > 0)) {
            	$sql= "insert into tmpcrlmt (sdate, stime, username, tmpLmt, Class, Rep, cusCode, crLmt, cat, FLAG) values ('" . date("Y-m-d") . "','" . date("H:m:s") . "' ,'" . $_SESSION["CURRENT_USER"] . "', '0' , 'NB', 'NR', '" . trim($_POST[$myg01]) . "', '0', 'C', 'PER' )";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
            	echo "1-".$sql;
				
				$sql=  "update vendor set Over_DUE_IG_Date='" . date("Y-m-d") . "'  where code='" . trim($_POST[$myg01]) . "' ";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				echo "2-". $sql;
				
            	if ($_POST[$myg08] < 0) {
					$myg08_val=str_replace(",", "", $_POST[$myg08]);
                	$sql=  "insert into tmpcrlmt (sdate, stime, username, tmpLmt, Class, Rep, cusCode, crLmt, cat) values ('" . date("Y-m-d") . "','" . date("H:m:s") . "' ,'" . $_SESSION["CURRENT_USER"] . "'," . (($myg08_val - 10) * -1) . " ,'" . trim($_POST[$myg19]) . "','" . trim($_POST[$myg21]) . "','" . trim($_POST[$myg01]) . "'," . $_POST[$myg03] . ", 'C' )";
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                	echo "3-". $sql;
					
                	$sql=  "Update view_repord_brand_btr set Limit_need = Limit_need * -1, Result = 'OK' where C_CODE = '" . trim($_POST[$myg01]) . "' and SAL_EX = '" . trim($_POST[$myg21]) . "' and class = '" . trim($_POST[$myg19]) . "' and INVNO = '0'   ";
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                	echo "4-". $sql;
					
					$sql= "select * from  br_trn where cus_code='" . trim($_POST[$myg01]) . "' and Rep='" . trim($_POST[$myg21]) . "' and brand='" . trim($_POST[$myg19]) . "' ";
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
   					if ($row = mysqli_fetch_array($result)){
                
                   		$sql_br= "insert into br_trn (cus_code, Rep, credit_lim, brand, tmpLmt, day) values ('" . trim($_POST[$myg01]) . "','" . trim($_POST[$myg21]) . "', '0', '" . trim($_POST[$myg19]) . "', " . (($myg08_val - 10) * -1) . ", '" . date("Y-m-d") . "' )";
				   		$result_br =mysqli_query($GLOBALS['dbinv'],$sql_br);
						echo "5-". $sql_br;
                	} else {
                    	$sql_br= "update br_trn set tmpLmt= " . (($myg08_val - 10) * -1) . " , day = '" . date("Y-m-d") . "' where cus_code='" . trim($_POST[$myg01]) . "' and Rep='" . trim($_POST[$myg21]) . "' and brand='" . trim($_POST[$myg19]) . "' ";
						echo "6-". $sql_br;
						$result_br =mysqli_query($GLOBALS['dbinv'],$sql_br);

                	}
                
            	}
        	} else {
				
				$myg08_val=str_replace(",", "", $_POST[$myg08]);
            	$sql= "insert into tmpcrlmt (sdate, stime, username, tmpLmt, Class, Rep, cusCode, crLmt, cat) values ('" . date("Y-m-d") . "','" . date("H:m:s") . "' ,'" . $_SESSION["CURRENT_USER"] . "'," . (($myg08_val - 10) * -1) . " ,'" . trim($_POST[$myg19]) . "','" . trim($_POST[$myg21]) . "','" . trim($_POST[$myg01]) . "'," . $_POST[$myg03] . ", 'C' )";
				echo "7-". $sql;
            	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
            	$sql= "Update view_repord_brand_btr set Limit_need = Limit_need * -1, Result = 'OK' where C_CODE = '" . trim($_POST[$myg01]) . "' and SAL_EX = '" . trim($_POST[$myg21]) . "' and class = '" . trim($_POST[$myg19]) . "' and INVNO = '0'   ";
				echo "8-". $sql;
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
            	$sql_br= "select * from  br_trn where cus_code='" . trim($_POST[$myg01]) . "' and Rep='" . trim($_POST[$myg21]) . "' and brand='" . trim($_POST[$myg19]) . "' ";
				$result_br =mysqli_query($GLOBALS['dbinv'],$sql_br);
				if ($row_br = mysqli_fetch_array($result_br)){
			
               		$sql= "insert into br_trn (cus_code, rep, credit_lim, brand, tmpLmt, day) values ('" . trim($_POST[$myg01]) . "','" . trim($_POST[$myg21]) . "','0','" . trim($_POST[$myg19]) . "'," . (($myg08_val - 10) * -1) . ", '" . date("Y-m-d") . "' )";
					echo "9-". $sql;
			   		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
            	} else {
               		$sql= "update br_trn set tmpLmt= " . (($myg08_val - 10) * -1) . " , day = '" . date("Y-m-d") . "' where cus_code='" . trim($_POST[$myg01]) . "' and Rep='" . trim($_POST[$myg21]) . "' and brand='" . trim($_POST[$myg19]) . "' ";
					echo "10-". $sql;
			   		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
               
            	}
            
        	}
    	} else {
        	if (trim($_POST[$myg20]) == "No") { 
				$sql = "Update view_repord_brand_btr set Limit_need = Limit_need * -1, Result = 'No' where C_CODE = '" . trim($_POST[$myg01]) . "' and INVNO = '0'  and SAL_EX = '" . trim($_POST[$myg21]) . "' and class = '" . trim($_POST[$myg19]) . "'   ";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			}	
    	}
    	$i = $i + 1;
	}
		echo  "Selected Limits Approved";
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
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="insert into s_crnma(REF_NO, SDATE, INVOICENO, DDATE, C_CODE, CUS_NAME, GRAND_TOT, DIS, DEPARTMENT, DEP_CODE, Brand, SAL_EX, DEV, GST, seri_no, vatrate, CANCELL) values ('".$_GET["grnno"]."', '".$_GET["grndate"]."', '".$_GET["invno"]."', '".$_GET["invdate"]."', '".$_GET["cusno"]."', '".$_GET["cusname"]."', ".$invtot.", ".$totdiscount.", '".$_GET["department"]."', '".$_GET["department"]."', '".$_GET["brand"]."', '".$_GET["salesrep"]."', '0', ".$mvatrate.", '".$_GET["serialno"]."', ".$mvatrate.", '0')";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			if ($_GET["serialno"]!=""){
				$sql="update seri_trn set loc='01', Sold='0' where seri_no='".$_GET["serialno"]."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
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
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
					
					$sql="update s_invo set ret_qty=ret_qty+".$_GET[$retqty]." where REF_NO='".$_GET["grnno"]."' and STK_NO='".$_GET[$stkno]."'";
					
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
					
					$sql="update s_mas set QTYINHAND=QTYINHAND+".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."'";
					
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
					
					$sql="update s_submas set QTYINHAND=QTYINHAND+".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."' and STO_CODE='".$_GET["department"]."'";
					
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
					
					$sql="insert into s_trn(STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, seri_no) values ('".$stkno."', '".$_GET["grndate"]."', '".$_GET["grnno"]."', ".$_GET[$retqty].", 'GRN', '".$_GET["department"]."', '".$_GET["serialno"]."')";
					
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
					
					
				}
				
				$i=$i+1;
			}
			
			
			$sql="update s_salma set RET_AMO=RET_AMO+".$_GET["invtot"]." where REF_NO='".$_GET["grnno"]."' ";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
					
			$sql="insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values ('".$_GET["grnno"]."', '".$_GET["grndate"]."', '".$_GET["cusno"]."', ".$_GET["invtot"].", 'GRN', '".$_GET["department"]."', '0') ";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 

			$sql="update vendor set CUR_BAL=CUR_BAL-".$_GET["invtot"]." where CODE='".$_GET["cusno"]."' ";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="update invpara set grn=grn+1 ";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 


			
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
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			if ($row = mysqli_fetch_array($result)) {
				if ($row["AMOUNT"]==$row["BALANCE"]){
					$sql1="update s_crnma set CANCELL='1' where REF_NO='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
					$sql1="update s_crntrn set CANCELL='1' where REF_NO='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
					$sql1="delete from c_bal where REFNO='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
                  
				
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
							$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
											
							$sql1="update s_mas set QTYINHAND=QTYINHAND-".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."'";
							$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
							$sql1="update s_submas set QTYINHAND=QTYINHAND-".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."' and STO_CODE='".$_GET["department"]."'";
							$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
                           
						}
						$i=$i+1;
					}
			
					$sql1="delete from s_trn where ltrim(REFNO)='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
							
					$sql1="delete from s_led where REF_NO='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			
		            $sql1="update s_salma set RET_AMO=RET_AMO+".$_GET["invtot"]." where REF_NO='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			        
        		    $sql1="update vendor set CUR_BAL=CUR_BAL+".$_GET["invtot"]." where CODE='".$_GET["cusno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ;         
               
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
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
    if ($row = mysqli_fetch_array($result)) {
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

$_SESSION["CURRENT_USER"]="tmpuser";

$sql = "insert into tmpCrLmt (sdate, stime, username, tmpLmt, class, rep, cuscode, crLmt, cat) values 
        ('".date("Y-m-d")."','".date("H:i:s", time())."' ,'".$AUTH_USER."',".$CrTmpLmt." ,'".trim($_GET["cmbbrand1"])."','".$rep."','".trim($_GET["txt_cuscode"])."',".$crLmt.",'".$cat"' )";
$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 

$sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
if ($row = mysqli_fetch_array($result)) {
   $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
   $resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);
   
} else {
  
  	$sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
 	$resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);
	
//	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
}

	If ($_GET["Check1"] == 1) {
   		$sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
	} else {	
    	$sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
	}

echo "Tempory limit updated";*/

}
	
?>