<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sales Summery</title>
<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
}
table
{
border-collapse:collapse;
}
table, td, th
{
border:1px solid black;
font-family:Arial, Helvetica, sans-serif;
padding:5px;
}
th
{
font-weight:bold;
font-size:12px;

}
td
{
font-size:12px;

}
</style>
<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
	font-size: 24px;
}
-->
</style>
</head>

<body>
 <!-- Progress bar holder -->


<?php
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();

	if ($_GET["cmbdev"] == "All") { $sysdiv = "A"; }
    if ($_GET["cmbdev"] == "Computer") { $sysdiv = "1"; }
    if ($_GET["cmbdev"] == "Manual") { $sysdiv = "0"; }
           
    if ($_GET["radio"]=="optrep") {
    	//reports();
        PrintRep1();
    }
    if ($_GET["radio"]=="OPsum") {  
        reports();
        PrintRepsum();
    }
     if ($_GET["radio"]=="optbrand") {
        brrep();
        Printrepbr();
     }
     if ($_GET["radio"]=="Optcus") { 
        report_cuswise();
        PrintRep1();
     }
				

function reports()
{
       //===========================================depALL/repALL===========
      
	  require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	  
      $sql= "delete from salrep ";
      $result =$db->RunQuery($sql);
		
     
	    
     //   Report.Open "SELECT *FROM SALREP", DNUSER.CONUSER, adOpenDynamic, adLockOptimistic
       if ($_GET["cmbcat"] == "All") { 
	   		$sql_rep= "select * from s_salrep  where cancel = '0' ";
       }
	   
	   if ($_GET["cmbcat"] != "All") { 
	   		$sql_rep= "select * from s_salrep where repcode ='" . trim($_GET["cmbcat"]) . "' ";
       }	
		
	  
	   $mon=date("m", strtotime($_GET["calmon"]));
	   $year=date("Y", strtotime($_GET["calmon"]));
        
        $result_rep =$db->RunQuery($sql_rep);
		while($row_rep = mysql_fetch_array($result_rep)){
			$PBAR = 0;
			$sql_brandmas="select * from brand_mas";
           	$result_brandmas =$db->RunQuery($sql_brandmas);
			while($row_brandmas = mysql_fetch_array($result_brandmas)){
            	
				$sql_salma="select * from s_salma where Accname != 'NON STOCK' and SAL_EX='" . $row_rep["REPCODE"] . "' and month(SDATE)='" . $mon . "' and year(SDATE)='" . $year . "' and Brand='" . $row_brandmas["barnd_name"] . "' and CANCELL='0' AND DEV!='" . $sysdiv . "' ";
           		$result_salma =$db->RunQuery($sql_salma);
				while($row_salma = mysql_fetch_array($result_salma)){
                
                    if (date("d", $row_salma["SDATE"]) < 8) {
                        $wk1 = $wk1 + $row_salma["GRAND_TOT"];
                    } else if (date("d", $row_salma["SDATE"]) < 15) {
                        $wk2 = $wk2 + $row_salma["GRAND_TOT"];
                    } else if (date("d", $row_salma["SDATE"]) < 22) { 
                        $wk3 = $wk3 + $row_salma["GRAND_TOT"];
					} else if (date("d", $row_salma["SDATE"]) < 29) { 	
                        $wk4 = $wk4 + $row_salma["GRAND_TOT"];
                    } else {
                        $wk5 = $wk5 + $row_salma["GRAND_TOT"];
                    }
                    
                }
                
             	if ($_GET["chkdef"] == "on") { 
					$sql_cbal="select * from c_bal where SAL_EX='" . trim($row_rep["REPCODE"]) . "' and month(SDATE)='" . $mon . "' and year(SDATE)='" . $year . "' and brand='" . trim($row_brandmas["barnd_name"]) . "' and trn_type!='ARN' and trn_type!='REC' and trn_type!='INC' and trn_type!='PAY' AND DEV!='" . $sysdiv . "' and flag1 != '1'";
				}	
             	if ($_GET["chkdef"] != "on") { 
					$sql_cbal="select * from c_bal where SAL_EX='" . trim($row_rep["REPCODE"]) . "' and month(SDATE)='" . $mon . "' and year(SDATE)='" . $year . "' and brand='" . trim($row_brandmas["barnd_name"]) . "' and trn_type!='ARN' and trn_type!='REC'and trn_type!='DGRN' and trn_type!='INC' and trn_type!='PAY' AND DEV!='" . $sysdiv . "' and flag1 != '1'";
				}	
				$result_cbal =$db->RunQuery($sql_cbal);
				while($row_cbal = mysql_fetch_array($result_cbal)){
                
                    if (date("d", $row_cbal["SDATE"]) < 8) {
                        $G1 = $G1 + $row_cbal["SDATE"];
                    } else if (date("d", $row_cbal["SDATE"]) < 15) {
                        $G2 = $G2 + $row_cbal["SDATE"];
					} else if (date("d", $row_cbal["SDATE"]) < 22) {	
                        $G3 = $G3 + $row_cbal["SDATE"];
					} else if (date("d", $row_cbal["SDATE"]) < 29) {	
                        $G4 = $G4 + $row_cbal["SDATE"];
                    } else {
                        $G5 = $G5 + $row_cbal["SDATE"];
                    }
                    
                }
                
				$sql_btrn="select *from reptrn where rep_code='" . trim($row_rep["REPCODE"]) . "' and BrAnd='" . $row_brandmas["barnd_name"] . "'";
				$result_btrn =$db->RunQuery($sql_btrn);
				if($row_btrn = mysql_fetch_array($result_btrn)){
					$target = $row_btrn["Target"];
                } else {
                    $target = 0;
                }
                
				if (date("Y-m-d", strtotime($_GET["calmon"])) < date("Y-m-d")) {
                    $week1 = ($wk1 - $G1) / 1.15;
                    $week2 = ($wk2 - $G2) / 1.15;
                    $week3 = ($wk3 - $G3) / 1.15;
                    $week4 = ($wk4 - $G4) / 1.15;
                    $week5 = ($wk5 - $G5) / 1.15;
                  
                } else {
                    $week1 = ($wk1 - $G1) / (1 + ($mvatrate / 100));
                    $week2 = ($wk2 - $G2) / (1 + ($mvatrate / 100));
                    $week3 = ($wk3 - $G3) / (1 + ($mvatrate / 100));
                    $week4 = ($wk4 - $G4) / (1 + ($mvatrate / 100));
                    $week5 = ($wk5 - $G5) / (1 + ($mvatrate / 100));
                   
                }
				
                $sql="insert into salrep(rep, brand, target, week1, week2, week3, week4, week5, no) values ('".$row_rep["Name"]."', '" . $row_brandmas["barnd_name"] . "', '".$target."', '".$week1."', '".$week2."', '".$week3."', '".$week4."', '".$week5."', '".$_GET["cmbweek"]."')";
				$result =$db->RunQuery($sql);
				
                 
               
                $totgrn = $totgrn + $G1 + $G2 + $G3 + $G4 + $G5;
                $totinv = $totinv + $wk1 + $wk2 + $wk3 + $wk4 + $wk5;
                $wk1 = 0;
                $wk2 = 0;
                $wk3 = 0;
                $wk4 = 0;
                $wk5 = 0;
                $G1 = 0;
                $G2 = 0;
                $G3 = 0;
                $G4 = 0;
                $G5 = 0;
                $target = 0;
                
            }
            
        }
        
}


function brrep(){

 $sql= "delete from salrep ";
 $result =$db->RunQuery($sql);
 
 $sql_rsbr="select * from brand_mas";
 $result_rsbr =$db->RunQuery($sql_rsbr);	  
 while($row_rsbr = mysql_fetch_array($result_rsbr)){

    if ($_GET["cmbdep"] == "All") {
        $sql_sqltar = "select *from reptrn where BrAnd ='" . $row_rsbr["barnd_name"] . "'";
    } else {
		$sql_sqltar = "select *from reptrn where BrAnd ='" . $row_rsbr["barnd_name"] . "'";
    }
    
	$result_sqltar =$db->RunQuery($sql_sqltar);	  
 	while($row_sqltar = mysql_fetch_array($result_sqltar)){
        $TAR = $TAR + $row_sqltar["Target"];
    }
    
   
    if ($_GET["cmbdep"] == "All") { 
		$sql_sqlinv = "select * from s_salma where Accname != 'NON STOCK' and  Brand='" . $row_rsbr["barnd_name"] . "' And Month(SDATE) = '" . date("m", strtotime($_GET["calmon"])) . "' And Year(SDATE) ='" . date("Y", strtotime($_GET["calmon"])) . "' and CANCELL='0' AND DEV !='" . $sysdiv . "' ";
	}	
    if ($_GET["cmbdep"] != "All") { 
		$sql_sqlinv = "select * from s_salma where Accname != 'NON STOCK' and Brand='" . $row_rsbr["barnd_name"] . "' and DEPARTMENT='" . $_GET["cmbdep"] . "' and Month(SDATE) = '" . date("m", strtotime($_GET["calmon"])) . "' And Year(SDATE) = '" . date("Y", strtotime($_GET["calmon"])) . "'and CANCELL='0' AND DEV!='" . $sysdiv . "' ";
	}	
	
	 $result_RSINVO =$db->RunQuery($sql_sqlinv);	  
 	while($row_RSINVO = mysql_fetch_array($result_RSINVO)){
    
         //if (((date("m", strtotime($row_RSINVO["SDATE"])) == date("m", strtotime($_GET["calmon"]))) and (date("Y", strtotime($row_RSINVO["SDATE"])) == date("Y", strtotime($_GET["calmon"])))) {
		 if ((date("m", strtotime($row_RSINVO["SDATE"])) == date("m", strtotime($_GET["calmon"]))) and (date("Y", strtotime($row_RSINVO["SDATE"])) == date("Y", strtotime($_GET["calmon"]))))  {
		
                if (date("d", strtotime($row_RSINVO["SDATE"])) < 8) {
                    $W1 = $W1 + $row_RSINVO["GRAND_TOT"] ;
                } if (date("d", strtotime($row_RSINVO["SDATE"])) < 15) {
                    $W2 = $W2 + $row_RSINVO["GRAND_TOT"] ;
                } if (date("d", strtotime($row_RSINVO["SDATE"])) < 22) {
                    $W3 = $W3 + $row_RSINVO["GRAND_TOT"] ;
                } if (date("d", strtotime($row_RSINVO["SDATE"])) < 29) {
                    $W4 = $W4 + $row_RSINVO["GRAND_TOT"] ;
                } else {
                    $W5 = $W5 + $row_RSINVO["GRAND_TOT"] ;
                }
        }
    }
   if ($_GET["chkdef"] == "on") {
    if ($_GET["cmbdep"] == "All") { 
		$sqlgrn = "select * from c_bal where brand='" . $row_rsbr["barnd_name"] . "' and trn_type!='ARN'and trn_type!='REC' and trn_type!='INC'  AND DEV!='" . $sysdiv . "' and flag1 != '1' ";
	}	
    if ($_GET["cmbdep"] != "All") { 
		$sqlgrn = "select * from c_bal where brand='" . $row_rsbr["barnd_name"] . "'and trn_type!='ARN' and trn_type!='INC'and trn_type!='REC' AND DEV!='" . $sysdiv . "' and flag1 != '1' ";
	}	
   }
   
   if ($_GET["chkdef"] != "on") {
   	if ($_GET["cmbdep"] == "All") { 
		$sqlgrn = "select * from c_bal where brand='" . $row_rsbr["barnd_name"] . "' and trn_type!='ARN'and trn_type!='DGRN' and trn_type!='REC' and trn_type!='INC'  AND DEV!='" . $sysdiv . "' and flag1 != '1' ";
	}	
    if ($_GET["cmbdep"] != "All") { 
		$sqlgrn = "select * from c_bal where brand='" . $row_rsbr["barnd_name"] . "'and trn_type!='ARN' and trn_type!='DGRN' and trn_type!='INC'and trn_type!='REC' AND DEV!='" . $sysdiv . "' and flag1 != '1' ";
	}	
	
   }
	
    $result_grn =$db->RunQuery($sqlgrn);	  
 	while($row_grn = mysql_fetch_array($result_grn)){
		if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["calmon"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["calmon"])))) {
				if (date("m", strtotime($row_grn["SDATE"]))<8){
                    $G1 = $G1 + $row_grn["SDATE"];
				}	
                else if (date("m", strtotime($row_grn["SDATE"]))<15){
                    $G2 = $G2 + $row_grn["SDATE"];
                }
				else if (date("m", strtotime($row_grn["SDATE"]))<22){
                    $G3 = $G3 + $row_grn["SDATE"];
                }
				else if (date("m", strtotime($row_grn["SDATE"]))<29){
                    $G4 = $G4 + $row_grn["SDATE"];
                } else {
                    $G5 = $G5 + $row_grn["SDATE"];
                }
        }
       
    }
    
    
  
    $mvatrate=12;
	
    if ($_GET["calmon"] < date("Y-m-d")) {
        $week1 = ($W1 - $G1) / 1.15;
        $week2 = ($W2 - $G2) / 1.15;
        $week3 = ($W3 - $G3) / 1.15;
        $week4 = ($W4 - $G4) / 1.15;
        $week5 = ($W5 - $G5) / 1.15;
    } else {
        $week1 = ($W1 - $G1) / (1 + ($mvatrate / 100));
        $week2 = ($W2 - $G2) / (1 + ($mvatrate / 100));
        $week3 = ($W3 - $G3) / (1 + ($mvatrate / 100));
        $week4 = ($W4 - $G4) / (1 + ($mvatrate / 100));
        $week5 = ($W5 - $G5) / (1 + ($mvatrate / 100));
    }
    

    

	$sql="insert into salrep(brand, target, week1, week2, week3, week4, week5, no) values ('" . $row_rsbr["barnd_name"] . "', '".$TAR."', '".$week1."', '".$week2."', '".$week3."', '".$week4."', '".$week5."', '".$_GET["cmbweek"]."')";
	$result =$db->RunQuery($sql);
   
    $W1 = 0;
    $W2 = 0;
    $W3 = 0;
    $W4 = 0;
    $W5 = 0;
    $G1 = 0;
    $G2 = 0;
    $G3 = 0;
    $G4 = 0;
    $G5 = 0;
    $TAR = 0;
   
  }

}


/*function Private Sub report_cuswise()
//===========================================depALL/repALL===========
        Dim Report As New ADODB.Recordset
        Dim rep As New ADODB.Recordset
        Dim grn As New ADODB.Recordset
        Dim wk1, wk2, wk3, wk4, wk5, G1, G2, G3, G4, G5, target As Double
        Dim rsrep As New ADODB.Recordset
        Dim sqlRep, sqlinv, sqlgrn As String
        Dim salma As New ADODB.Recordset
        Dim cbal As New ADODB.Recordset
        Dim brandmas As New ADODB.Recordset
        Dim btrn As New ADODB.Recordset
        Dim rsVENDOR As New ADODB.Recordset
        Dim totgrn, totinv As Double
      
        If DNUSER.CONUSER.State = 0 Then DNUSER.CONUSER.Open
        DNUSER.CONUSER.Execute "DELETE * FROM SALREP"
        Report.Open "SELECT *FROM SALREP", DNUSER.CONUSER, adOpenDynamic, adLockOptimistic
       If cmbcat = "All" Then rep.Open "select * from s_salrep where CANCEL = '0' ", dnINV.conINV
       If cmbcat <> "All" Then rep.Open "select * from s_salrep where repcode ='" & Trim(Left(cmbcat, 5)) & "'", dnINV.conINV
 
        Do While Not rep.EOF
            brandmas.Open "select * from brand_mas ", dnINV.conINV
            PBAR = 0
            PBAR.Max = brandmas.RecordCount
            Do While Not brandmas.EOF
                salma.Open "select * from s_salma where ACCNAME <> 'NON STOCK' and sal_ex='" & rep!repcode & "' and month(sdate)='" & calmon.Month & "' and year(sdate)='" & calmon.year & "' and brand='" & brandmas!barnd_name & "' and CANCELL='0' AND dev<>'" & sysdiv & "' order by c_code ", dnINV.conINV
                Do While Not salma.EOF
                    If m_cus <> salma!c_code Then
                        If m_cus <> "" Then
                            Report.addNew
                            Report!rep = Trim(rep!Name)
                            Report!brand = Trim(brandmas!barnd_name)
                            If calmon.Value < DTPicker1.Value Then
                                Report!week1 = (wk1) / 1.15
                                Report!week2 = (wk2) / 1.15
                                Report!week3 = (wk3) / 1.15
                                Report!week4 = (wk4) / 1.15
                                Report!week5 = (wk5) / 1.15
                                
                            Else
                                Report!week1 = (wk1) / (1 + (mvatrate / 100))
                                Report!week2 = (wk2) / (1 + (mvatrate / 100))
                                Report!week3 = (wk3) / (1 + (mvatrate / 100))
                                Report!week4 = (wk4) / (1 + (mvatrate / 100))
                                Report!week5 = (wk5) / (1 + (mvatrate / 100))
                                
                            End If
                            Report!no = "1"
                            Report!Cus_Code = Trim(m_cus)
                            rsVENDOR.Open "Select * from vendor where code = '" & Trim(m_cus) & "'", dnINV.conINV
                            If Not rsVENDOR.EOF Then
                                Report!cus_name = Trim(rsVENDOR!Name)
                            End If
                            rsVENDOR.Close
                            Report.update
                            wk1 = 0
                            wk2 = 0
                            wk3 = 0
                            wk4 = 0
                            wk5 = 0
                        End If
                    End If
                    m_cus = salma!c_code
                    If Day(salma!SDATE) < 8 Then
                        wk1 = wk1 + salma!GRAND_TOT
                    ElseIf Day(salma!SDATE) < 15 Then
                        wk2 = wk2 + salma!GRAND_TOT
                    ElseIf Day(salma!SDATE) < 22 Then
                        wk3 = wk3 + salma!GRAND_TOT
                    ElseIf Day(salma!SDATE) < 29 Then
                        wk4 = wk4 + salma!GRAND_TOT
                    Else
                        wk5 = wk5 + salma!GRAND_TOT
                    End If
                    salma.MoveNext
                Loop
                Report.addNew
                Report!rep = Trim(rep!Name)
                Report!brand = Trim(brandmas!barnd_name)
                If calmon.Value < DTPicker1.Value Then
                    Report!week1 = (wk1) / 1.15
                    Report!week2 = (wk2) / 1.15
                    Report!week3 = (wk3) / 1.15
                    Report!week4 = (wk4) / 1.15
                    Report!week5 = (wk5) / 1.15
                   
                Else
                    Report!week1 = (wk1) / (1 + (mvatrate / 100))
                    Report!week2 = (wk2) / (1 + (mvatrate / 100))
                    Report!week3 = (wk3) / (1 + (mvatrate / 100))
                    Report!week4 = (wk4) / (1 + (mvatrate / 100))
                    Report!week5 = (wk5) / (1 + (mvatrate / 100))
                   
                End If
                Report!no = "1"
                Report!Cus_Code = Trim(m_cus)
                rsVENDOR.Open "Select * from vendor where code = '" & Trim(m_cus) & "'", dnINV.conINV
                If Not rsVENDOR.EOF Then
                    Report!cus_name = Trim(rsVENDOR!Name)
                End If
                rsVENDOR.Close
                Report.update
                wk1 = 0
                wk2 = 0
                wk3 = 0
                wk4 = 0
                wk5 = 0
                salma.Close
                m_cus = ""
                Set salma = Nothing
     
             If chkdef = 1 Then cbal.Open "select * from c_bal where rtrim(ltrim(sal_ex))='" & Trim(rep!repcode) & "' and month(sdate)='" & calmon.Month & "' and year(sdate)='" & calmon.year & "' and rtrim(ltrim(brand))='" & Trim(brandmas!barnd_name) & "' and trn_type<>'ARN' and trn_type<>'REC' and trn_type<>'INC' and trn_type<>'PAY' AND dev<>'" & sysdiv & "' and flag1 <> '1'", dnINV.conINV
             If chkdef = 0 Then cbal.Open "select * from c_bal where rtrim(ltrim(sal_ex))='" & Trim(rep!repcode) & "' and month(sdate)='" & calmon.Month & "' and year(sdate)='" & calmon.year & "' and rtrim(ltrim(brand))='" & Trim(brandmas!barnd_name) & "' and trn_type<>'ARN' and trn_type<>'REC'and trn_type<>'DGRN' and trn_type<>'INC' and trn_type<>'PAY' AND dev<>'" & sysdiv & "' and flag1 <> '1' ", dnINV.conINV
                
                Do While Not cbal.EOF
                    If m_cus <> cbal!Cuscode Then
                        If m_cus <> "" Then
                            Report.addNew
                            Report!rep = Trim(rep!Name)
                            Report!brand = Trim(brandmas!barnd_name)
                            If calmon.Value < DTPicker1.Value Then
                                Report!week1 = (G1) / 1.15 * -1
                                Report!week2 = (G2) / 1.15 * -1
                                Report!week3 = (G3) / 1.15 * -1
                                Report!week4 = (G4) / 1.15 * -1
                                Report!week5 = (G5) / 1.15 * -1
                                'Report!week5 = 12
                            Else
                                Report!week1 = (G1) / (1 + (mvatrate / 100)) * -1
                                Report!week2 = (G2) / (1 + (mvatrate / 100)) * -1
                                Report!week3 = (G3) / (1 + (mvatrate / 100)) * -1
                                Report!week4 = (G4) / (1 + (mvatrate / 100)) * -1
                                Report!week5 = (G5) / (1 + (mvatrate / 100)) * -1
                                'Report!week5 = 12
                            End If
                            Report!no = "2"
                            Report!Cus_Code = Trim(m_cus)
                            rsVENDOR.Open "Select * from vendor where code = '" & Trim(m_cus) & "'", dnINV.conINV
                            If Not rsVENDOR.EOF Then
                                Report!cus_name = Trim(rsVENDOR!Name)
                            End If
                            rsVENDOR.Close
                            Report.update
                            G1 = 0
                            G2 = 0
                            G3 = 0
                            G4 = 0
                            G5 = 0
                        End If
                    End If
                    m_cus = cbal!Cuscode
                    If Day(cbal!SDATE) < 8 Then
                        G1 = G1 + cbal!AMOUNT
                    ElseIf Day(cbal!SDATE) < 15 Then
                        G2 = G2 + cbal!AMOUNT
                    ElseIf Day(cbal!SDATE) < 22 Then
                        G3 = G3 + cbal!AMOUNT
                    ElseIf Day(cbal!SDATE) < 29 Then
                        G4 = G4 + cbal!AMOUNT
                    Else
                        G5 = G5 + cbal!AMOUNT
                    End If
                    cbal.MoveNext
                Loop
                Report.addNew
                Report!rep = Trim(rep!Name)
                Report!brand = Trim(brandmas!barnd_name)
                If calmon.Value < DTPicker1.Value Then
                    Report!week1 = (G1) / 1.15 * -1
                    Report!week2 = (G2) / 1.15 * -1
                    Report!week3 = (G3) / 1.15 * -1
                    Report!week4 = (G4) / 1.15 * -1
                    Report!week5 = (G5) / 1.15 * -1
                   
                Else
                    Report!week1 = (G1) / (1 + (mvatrate / 100)) * -1
                    Report!week2 = (G2) / (1 + (mvatrate / 100)) * -1
                    Report!week3 = (G3) / (1 + (mvatrate / 100)) * -1
                    Report!week4 = (G4) / (1 + (mvatrate / 100)) * -1
                    Report!week5 = (G5) / (1 + (mvatrate / 100)) * -1
                   
                End If
                Report!no = "2"
                Report!Cus_Code = Trim(m_cus)
                rsVENDOR.Open "Select * from vendor where code = '" & Trim(m_cus) & "'", dnINV.conINV
                If Not rsVENDOR.EOF Then
                    Report!cus_name = Trim(rsVENDOR!Name)
                End If
                rsVENDOR.Close
                Report.update
                G1 = 0
                G2 = 0
                G3 = 0
                G4 = 0
                G5 = 0
                cbal.Close
                Set cbal = Nothing
                btrn.Open "select *from reptrn where rep_code='" & rep!repcode & "' and brand='" & brandmas!barnd_name & "'", dnINV.conINV
                If Not btrn.EOF Then
                    target = btrn!target
                Else
                    target = 0
                End If
                btrn.Close
                Set btrn = Nothing
                

               PBAR = brandmas.AbsolutePosition
               brandmas.MoveNext
                
            Loop
            brandmas.Close
            Set brandmas = Nothing
            rep.MoveNext
        Loop
        rep.Close
        Set rep = Nothing
    
End Sub*/
function PrintRep1(){
	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$sql_head="select * from invpara";
	$result_head =$db->RunQuery($sql_head);
	$row_head = mysql_fetch_array($result_head);
 

	$txtrepono= $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");
	
    if ($_GET["radio"]=="Optcus") {
		$sql_rsPrInv="SELECT * from salrep where week1!= '0' or week2!= '0' or week3 !='0' or week4 !='0' or week5!='0' "; 
 	    //Section10.Suppress = True
 	} else {
		$sql_rsPrInv="SELECT * from salrep where week1!= '0' or week2!= '0' or week3 !='0' or week4 !='0' or week5!='0' "; 

    	/*Section3.Suppress = True
    	Section4.Suppress = True
   	 	Section5.Suppress = True*/
 	}
	
	
	

	$rtxtComName=$row_head["COMPANY"];
	$rtxtcomadd1= $row_head["ADD1"];
	$rtxtComAdd2= $row_head["ADD2"] . ", " . $row_head["ADD3"];
	$rtxtmonth= date("F", strtotime($_GET["calmon"])) . " " . date("Y", strtotime($_GET["calmon"]));
	if ($_GET["chkdef"] == "on") { $txtremark= "Department  " . $_GET["cmbdep"] . "    With Defective"; }
	if ($_GET["chkdef"] != "on") { $txtremark= "Department  " . $_GET["cmbdep"]; }
	
	$sql_rep="SELECT distinct rep from salrep  order by rep";
	//echo $sql_rep; 
	$result_rep =$db->RunQuery($sql_rep);
	while ($row_rep = mysql_fetch_array($result_rep)){
		echo "<table border=1>
		<tr>
		<th colspan=9 align=left>".$row_rep["rep"]."</th>
		</tr>";
		
	
		echo "
		<tr>
		<th>Brand</th>
		<th>Target</th>
		<th>Week1</th>
		<th>Week2</th>
		<th>Week3</th>
		<th>Week4</th>
		<th>Week5</th>
		<th>Total</th>
		<th>Sort to Target</th>
		</tr>";
		
	
		$sql_rsPrInv=$sql_rsPrInv." and rep='".$row_rep["rep"]."'";
		echo $sql_rsPrInv;
		$result_rsPrInv =$db->RunQuery($sql_rsPrInv);
		while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
			if ($rep!=$row_rsPrInv["rep"]){
				echo "
				<th colspan=6 align=left><b>".$row_rsPrInv["rep"]."</b></th></tr>";
				$rep=$row_rsPrInv["rep"];
			} 	
		
			echo "<tr><td>".$row_rsPrInv["brand"]."</td>
			<td align=\"right\">".number_format($row_rsPrInv["target"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row_rsPrInv["week1"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row_rsPrInv["week2"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row_rsPrInv["week3"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row_rsPrInv["week4"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row_rsPrInv["week5"], 2, ".", ",")."</td>";
			
			$Total=$row_rsPrInv["week1"]+$row_rsPrInv["week2"]+$row_rsPrInv["week3"]+$row_rsPrInv["week4"]+$row_rsPrInv["week5"];
			$sort_tar=$row_rsPrInv["target"]-$Total;
			
			$target=$target+$row_rsPrInv["target"];
			$week1=$week1+$row_rsPrInv["week1"];
			$week2=$week2+$row_rsPrInv["week2"];
			$week3=$week3+$row_rsPrInv["week3"];
			$week4=$week4+$row_rsPrInv["week4"];
			$week5=$week5+$row_rsPrInv["week5"];
			
			$totTotal=$totTotal+$Total;
			$totsort_tar=$totsort_tar+$sort_tar;
			
			echo "<td align=\"right\">".number_format($Total, 2, ".", ",")."</td>";
			echo "<td align=\"right\">".number_format($sort_tar, 2, ".", ",")."</td></tr>";
		}
		
		echo "<tr><td>&nbsp;</td>
			<td align=\"right\">".number_format($target, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($week1, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($week2, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($week3, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($week4, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($week5, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($Total, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($sort_tar, 2, ".", ",")."</td></tr>";	
	}
	
	echo "</table>";

}


function PrintRepsum()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$sql_head="select * from invpara";
	$result_head =$db->RunQuery($sql_head);
	$row_head = mysql_fetch_array($result_head);
 

	$txtrepono= $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");
 
	
		
		$rtxtComName=$row_head["COMPANY"];
		$rtxtcomadd1= $row_head["ADD1"];
		$rtxtComAdd2= $row_head["ADD2"] . ", " . $row_head["ADD3"];
		
		$rtxtmonth= date("F", strtotime($_GET["calmon"])) . " " . date("Y", strtotime($_GET["calmon"]));
		
	
		if ($_GET["chkdef"] == "1") { 
			$txtremark = "Department  " . $_GET["cmbdep"] . "    With Defective";
		}	
		if ($_GET["chkdef"] == "0") { 
			$txtremark = "Department  " . $_GET["cmbdep"];
		}	
		
		
	$sql_rsPrInv="SELECT * from salrep where week1!= '0' or week2!= '0' or week3 !='0' or week4 !='0' or week5!='0' order by rep "; 
 	$result_rsPrInv =$db->RunQuery($sql_rsPrInv);
	while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
		echo "<table border=1>
		<tr>
		<th colspan=7 align=left>".$row_rsPrInv["rep"]."</th>
		</tr>";
		
	
		echo "<table border=1>
		<tr>
		<th></th>
		<th>Week1/th>
		<th>Week2</th>
		<th>Week3</th>
		<th>Week4</th>
		<th>Week5</th>
		<th>Total</th>
		</tr>";
		
		$Total=$row_rsPrInv["week1"]+$row_rsPrInv["week2"]+$row_rsPrInv["week3"]+$row_rsPrInv["week4"]+$row_rsPrInv["week5"];
		
		echo "<tr><td>&nbsp;</td>
			<td align=\"right\">".number_format($row_rsPrInv["week1"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row_rsPrInv["week2"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row_rsPrInv["week3"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row_rsPrInv["week4"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row_rsPrInv["week5"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($Total, 2, ".", ",")."</td>";
			
			$target=$target+$row_rsPrInv["target"];
			$week1=$week1+$row_rsPrInv["week1"];
			$week2=$week2+$row_rsPrInv["week2"];
			$week3=$week3+$row_rsPrInv["week3"];
			$week4=$week4+$row_rsPrInv["week4"];
			$week5=$week5+$row_rsPrInv["week5"];
			
			$totTotal=$totTotal+$Total;
		
			
	}
	
	echo "<tr><td>&nbsp;</td>
			<td align=\"right\">".number_format($week1, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($week2, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($week3, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($week4, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($week5, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($Total, 2, ".", ",")."</td></tr>";	
	
	echo "</table>";
}




?>



</body>
</html>
