<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<style>
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
font-size:11px;

}
</style>

</head>

<body>
	<?php
	
    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmppurcon";
	$result =$db->RunQuery($sql);
	
	$mon = date("m",strtotime($_GET["dte_from"]));
	if ($_GET["chkitem"]==0){
		if ($_GET["txtgroup1"] == ""){
      		if ($_GET["brand"] == "All"){ $sql_s_mas = "select * from s_mas order by GROUP1, model, GROUP2";}
      		if ($_GET["brand"] != "All"){ $sql_s_mas = "select * from s_mas where BRAND_NAME='" . $_GET["brand"] . "' order by GROUP1, model, GROUP2";}
   		} else {
      		if ($_GET["txtgroup2"] == ""){
         		if ($_GET["brand"] == "All"){ $sql_s_mas = "select * from s_mas where GROUP1='".$_GET["txtgroup1"]."' order by GROUP1, GROUP2, model"; }
         		if ($_GET["brand"] != "All"){ $sql_s_mas = "select * from s_mas where GROUP1='".$_GET["txtgroup1"]."' and BRAND_NAME='".$_GET["brand"]."' order by GROUP1, model, GROUP2"; }
      		} else {
         		if ($_GET["brand"] == "All"){ $sql_s_mas = "select * from s_mas where GROUP1='".$_GET["txtgroup1"]."' and  GROUP2='".$_GET["txtgroup2"]."' order by GROUP1, GROUP2, model";}
         		if ($_GET["brand"] != "All"){ $sql_s_mas = "select * from s_mas where GROUP1='".$_GET["txtgroup1"]."'and  GROUP2='".$_GET["txtgroup2"]."' and   BRAND_NAME='".$_GET["brand"]."' order by GROUP1, GROUP2, model";}
			}
		}
		
		$result_s_mas =$db->RunQuery($sql_s_mas);
		while($row_s_mas = mysql_fetch_array($result_s_mas)){
			$date = date("Y-m-d");
			$date = strtotime(date("Y-m-d", strtotime($date)) . " -91 days");
			$dt= date("Y-m-d", $date);
        	
			$sql_rs = "select sum(REC_QTY) as stk from s_purtrn where STK_NO='".$row_s_mas["STK_NO"]."' and CANCEL='0' and SDATE > '".$dt."' ";
			$result_rs =$db->RunQuery($sql_rs);
			$row_rs = mysql_fetch_array($result_rs);
       	 	$mnewstk = 0;
        	$munsold = 0;
        	
			if (!is_null($row_rs["stk"])){$mnewstk = $row_rs["stk"];}
        	if ($row_s_mas["QTYINHAND"] > $mnewstk){$munsold = $row_s_mas["QTYINHAND"] - $mnewstk;}
        
        	for ($i = 1; $i<=5; $i++){
            	$mon = date("m",strtotime($_GET["dte_from"]))-$i;
             	$yr = date("Y",strtotime($_GET["dte_from"]));
            	
				switch ($mon){
					case 0:
						$mon=12;
						$yr=$yr-1;
						break;
					case -1:
						$mon=11;
						$yr=$yr-1;
						break;
					case -2:
						$mon=10;
						$yr=$yr-1;
						break;
					case -3:
						$mon=9;
						$yr=$yr-1;
						break;
					case -4:
						$mon=8;
						$yr=$yr-1;
				}
			
            	$sql_rst1 = "select sum(QTY) as purqty from s_trn where STK_NO='".$row_s_mas["STK_NO"]."' and LEDINDI = 'ARN' and month(SDATE)=".$mon." and year(SDATE)=".$yr;
				$result_rst1 =$db->RunQuery($sql_rst1);
				$row_rst1 = mysql_fetch_array($result_rst1);
			
            	$sql_rst2 = "select sum(QTY) as retpurqty from s_trn  where STK_NO='".$row_s_mas["STK_NO"]."' and LEDINDI='ARR' and month(SDATE)=".$mon." and year(SDATE)=".$yr;
				$result_rst2 =$db->RunQuery($sql_rst2);
				$row_rst2 = mysql_fetch_array($result_rst2);
            
            	if (is_null($row_rst1["purqty"])){
                	$pqty = 0;
            	} else {
                	$pqty = $row_rst1["purqty"];
            	}
            
            	if (is_null($row_rst2["retpurqty"])){
                	$rqty = 0;
            	} else {
                	$rqty = $row_rst2["retpurqty"];
            	}
            
            	$qty[$i] = $pqty - $rqty;
			}
			
			for ($i = 0; $i<=5; $i++){
            	$mon = date("m",strtotime($_GET["dte_from"]))-$i;
             	$yr = date("Y",strtotime($_GET["dte_from"]));
            	
				switch ($mon){
					case 0:
						$mon=12;
						$yr=$yr-1;
						break;
					case -1:
						$mon=11;
						$yr=$yr-1;
						break;
					case -2:
						$mon=10;
						$yr=$yr-1;
						break;
					case -3:
						$mon=9;
						$yr=$yr-1;
						break;
					case -4:
						$mon=8;
						$yr=$yr-1;
				}
				
                        
            	$sql_rst1 = "select sum(QTY) as invqty from view_strn_smas_salma where STK_NO='".$row_s_mas["STK_NO"]."' and month(SDATE)=".$mon." and year(SDATE)=".$yr;
				$result_rst1 =$db->RunQuery($sql_rst1);
				$row_rst1 = mysql_fetch_array($result_rst1);
				
            	$sql_rst2 = "select sum(QTY) as retqty from s_trn where STK_NO='".$row_s_mas["STK_NO"]."' and month(SDATE)=".$mon." and LEDINDI='GRN' and year(SDATE)=".$yr;
				$result_rst2 =$db->RunQuery($sql_rst2);
				$row_rst2 = mysql_fetch_array($result_rst2);
            
            	if (is_null($sql_rst1["invqty"])){
                	$pqty = 0;
            	} else {
                	$pqty = $sql_rst1["invqty"];
            	}
            
            	if (is_null($sql_rst2["retqty"])){
                	$rqty = 0;
            	} else {
                	$rqty = $sql_rst2["retqty"];
            	}
            
            	$con[i] = $pqty - $rqty;
        
            }
			
			$sql_LASTAR = "SELECT * FROM s_trn  WHERE STK_NO='".$row_s_mas["STK_NO"]."' and LEDINDI='ARN' order by ID desc";
        	$result_LASTAR =$db->RunQuery($sql_LASTAR);
			$row_LASTAR = mysql_fetch_array($result_LASTAR);
			
			$sql_ord = "select sum(ORD_QTY) as ordqty from s_ordtrn where STK_NO='".$row_s_mas["STK_NO"]."' and CANCEL=0 ";
        	$result_ord =$db->RunQuery($sql_ord);
			$row_ord = mysql_fetch_array($result_ord);
				
			$sql_openstk= "select * from openstk where STK_NO='".$row_s_mas["STK_NO"]."'";
        	$curr_month = date("m",strtotime(date("Y-m-d")));
        	$curr_year = date("Y",strtotime(date("Y-m-d")));
        
        	$sql_ord1 = "select sum(ORD_QTY) as ordqty from vieword where STK_NO='".$row_s_mas["STK_NO"]."' and cancel=0 and month(S_date)=".$curr_month." and year(S_date)=".$curr_year;
			$result_ord1 =$db->RunQuery($sql_ord1);
			$row_ord1 = mysql_fetch_array($result_ord1);
        
        	if (($curr_month + 1) > 12) {
				$s_date=$curr_month + 1 - 12;
				$curryear=$curr_year + 1;
          		$sql_ord2 = "select sum(ORD_QTY) as ordqty from vieword where STK_NO='".$row_s_mas["STK_NO"]."' and cancel=0 and month(S_date)=".$s_date." and year(S_date)=".$curryear;
        	} else {
				$s_date=$curr_month + 1;
				
         		$sql_ord2 = "select sum(ORD_QTY) as ordqty from vieword where STK_NO='".$row_s_mas["STK_NO"]."' and cancel=0 and month(S_date)=".$s_date." and year(S_date)=".$curr_year;
        	}
			$result_ord2 =$db->RunQuery($sql_ord2);
			$row_ord2 = mysql_fetch_array($result_ord2);
        
        	if (($curr_month + 2) > 12){
				$s_date=$curr_month + 2 - 12;
				$curryear=$curr_year + 1;
        		$sql_ord3 = "select sum(ORD_QTY) as ordqty from vieword where STK_NO='".$row_s_mas["STK_NO"]."' and cancel=0 and month(S_date)=".$s_date." and year(s_date)=".$curryear;
        	} else {
				$s_date=$curr_month + 2;
				$curryear=$curr_year + 1;
        		$sql_ord3 = "select sum(ORD_QTY) as ordqty from vieword where STK_NO='".$row_s_mas["STK_NO"]."' and cancel=0 and month(S_date)=".$s_date." and year(S_date)=".$curryear;
        	}
				$result_ord3 =$db->RunQuery($sql_ord3);
				$row_ord3 = mysql_fetch_array($result_ord3);
        	
			$STK_NO = $row_s_mas["STK_NO"];
        	if (!is_null($row_s_mas["DESCRIPT"])) { $desctript = $row_s_mas["DESCRIPT"]; }
        	if (!is_null($row_s_mas["PART_NO"])) {$PART_NO = $row_s_mas["PART_NO"];}
        	if (!is_null($row_s_mas["GROUP3"])) {$group3 =$row_s_mas["GROUP3"];}
        
        	if (!is_null($row_LASTAR["REFNO"])) {$arno = $row_LASTAR["REFNO"];}
        	if (!is_null($row_LASTAR["SDATE"])) {$ardate = $row_LASTAR["SDATE"];}
        	if (!is_null($row_LASTAR["QTY"])) {$larqty = $row_LASTAR["QTY"]; }
        	if (!is_null($row_ord1["ordqty"])) { $ord_qty1 = $row_ord1["ordqty"];}
        	if (!is_null($row_ord2["ordqty"])) { $ord_qty2 = $row_ord2["ordqty"];}
        	if (!is_null($row_ord3["ordqty"])) { $ord_qty3 = $row_ord3["ordqty"];}
        	
        	$mon1 = date($curr_month);
        	if (($curr_month + 1) > 12){
          		$mon2 = MonthName($curr_month + 1 - 12);
        	} else {
         		$mon2 = MonthName($curr_month + 1);
         	}
        	if (($curr_month + 2) > 12){
          		$mon3 = MonthName($curr_month + 2 - 12);
        	} else {
          		$mon3 = MonthName($curr_month + 2);
        	}
        
        	$pur0 = $qty[0];
        	$con0 = $con[0];
        	$ordqty = $row_ord["ordqty"];
        	$pur1 = $qty[1];
        	$con1 = $con[1];
			$open_stk=0;
        	//if (!is_null($row_openstk["open_stk"])){ $open_stk = $row_openstk["open_stk"];}
        	$pur2 = $qty[2];
        	$con2 = $con[2];
        	$pur3 = $qty[3];
        	$con3 = $con[3];
        	$pur4 = $qty[4];
        	$con4 = $con[4];
        	$pur5 = $qty[5];
        	$con5 = $con[5];
        	$QTYINHAND = $row_s_mas["QTYINHAND"];
        	$over90 = $munsold;
        	
			$sql_temp="insert into tmppurcon(STK_NO, desctript, PART_NO, group3, arno, ardate, larqty, ord_qty1, ord_qty2, ord_qty3, mon1, mon2, mon3, pur0, con0, ordqty, pur1, con1, open_stk, pur2, con2, pur3, con3, pur4, con4, pur5, con5, QTYINHAND, over90) values ('".$STK_NO."', '".$desctript."', '".$PART_NO."', '".$group3."', '".$arno."', '".$ardate."', ".$larqty.", ".$ord_qty1.", ".$ord_qty2.", ".$ord_qty3.", '".$mon1."', '".$mon2."', '".$mon3."', ".$pur0.", ".$con0.", ".$ordqty.", ".$pur1.", ".$con1.", ".$open_stk.", ".$pur2."', ".$con2.", ".$pur3.", ".$con3.", ".$pur4.", ".$con4.", ".$pur5.", ".$con5.", ".$QTYINHAND.", ".$over90.")";
			$result_temp =$db->RunQuery($sql_temp);
		}	
	}

        


	if ($_GET["chkitem"] == "on"){
     
        
        $sql="select itemcode, name from tmpitem";
		$result =$db->RunQuery($sql);
		while ($row = mysql_fetch_array($result)){
        	$sql_s_mas = "select * from s_mas WHERE STK_NO='".$row["itemcode"]."'";
        	$result_s_mas =$db->RunQuery($sql_s_mas);
			$row_s_mas = mysql_fetch_array($result_s_mas);
        	
			$date = date("Y-m-d");
			$date = strtotime(date("Y-m-d", strtotime($date)) . " -91 days");
			$dt= date("Y-m-d", $date);
			
        	$sql_rs	= "select sum(rec_qty) as stk from s_purtrn where STK_NO='".$row_s_mas["STK_NO"]."' and CANCEL='0' and SDATE > '".dt."' ";
			$result_rs =$db->RunQuery($sql_rs);
			$row_rs = mysql_fetch_array($result_rs);
        	$mnewstk = 0;
        	$munsold = 0;
        	if (is_null($row_rs["stk"])){ $mnewstk = $row_rs["stk"]; }
        	if ($row_s_mas["QTYINHAND"] > $mnewstk){
           		$munsold = $row_s_mas["QTYINHAND"] - $mnewstk;
        	}
        
        	for ($i = 0; $i<=5; $i++){
            	$mon = date("m",strtotime($_GET["dte_from"]))-$i;
             	$yr = date("Y",strtotime($_GET["dte_from"]));
            	
				switch ($mon){
					case 0: 
						$mon = 12;
                        $yr = $yr - 1;
						break;
            		case -1: 
						$mon = 11;
                    	$yr = $yr - 1;
						break;
            		case -2: 
						$mon = 10;
                    	$yr = $yr - 1;
						break;
            		case -3: 
						$mon = 9;
                    	$yr = $yr - 1;
						break;
            		case -4: 
						$mon = 8;
                    	$yr = $yr - 1;
            	}
            
            	$sql_rst1 = "select sum(QTY) as purqty from s_trn where STK_NO='".$row["itemcode"]."' and LEDINDI='ARN' and month(SDATE)=".$mon." and year(SDATE)=".$yr;
				$result_rst1 =$db->RunQuery($sql_rst1);
				$row_rst1 = mysql_fetch_array($result_rst1);
            	$sql_rst2 = "select sum(QTY) as retpurqty from s_trn where STK_NO='".$row["itemcode"]."' and LEDINDI='ARR' and month(SDATE)=".$mon." and year(SDATE)=".$yr;
				$result_rst2 =$db->RunQuery($sql_rst2);
				$row_rst2 = mysql_fetch_array($result_rst2);
            
            	if (is_null($row_rst1["purqty"])){
                	$pqty = 0;
            	} else {
                	$pqty = $row_rst1["purqty"];
            	}
            
            	if (is_null($row_rst2["retpurqty"])){
                	$rqty = 0;
            	} else {
                	$rqty = $row_rst2["retpurqty"];
            	}
            
            	$qty[$i] = $pqty - $rqty;
        
            }
                
        
			for ($i = 0; $i <= 5; $i++){
				$mon = date("m",strtotime($_GET["dte_from"]))-$i;
             	$yr = date("Y",strtotime($_GET["dte_from"]));
            	
				switch ($mon){
                    case 0: 
					  	$mon = 12;
                    	$yr = $yr - 1;
						break;
            		case -1: 
						$mon = 11;
                    	$yr = $yr - 1;
            		case -2: 
						$mon = 10;
                    	$yr = $yr - 1;
            		case -3: 
						$mon = 9;
                    	$yr = $yr - 1;
            		case -4: 
						$mon = 8;
                        $yr = $yr - 1;
				}		
            
            	$sql_rst1 = "select sum(QTY) as invqty from view_s_invo where STK_NO='" . $row["itemcode"] . "'  and CANCELL='0' and month(SDATE)=" . $mon . " and year(SDATE)=" . $yr . "";
				$result_rst1 =$db->RunQuery($sql_rst1);
				$row_rst1 = mysql_fetch_array($result_rst1);
            	
				$sql_rst2= "select sum(QTY) as retqty from viewcrntrn where STK_NO='" . $row["itemcode"] . "' and CANCELL='0' and month(SDATE)=" . $mon . " and year(SDATE)=" . $yr ;
				$result_rst2 =$db->RunQuery($sql_rst2);
				$row_rst2 = mysql_fetch_array($result_rst2);
            
            	if (is_null($row_rst1["invqty"])==false) {
					$pqty = 0;
            	} else {
                	$pqty = $row_rst1["invqty"];
            	}
            
            	if (is_null($row_rst2["retqty"])==false) {
                	$rqty = 0;
            	} else {
                	$rqty = $row_rst2["retqty"];
            	}
            
            	$con[$i] = $pqty - $rqty;
        
            }
        
        
			$sql_LASTAR= "SELECT * FROM s_trn  WHERE STK_NO='" .$row_s_mas["STK_NO"] . "'and LEDINDI='ARN' order by ID desc";
        	$result_LASTAR =$db->RunQuery($sql_LASTAR);
			$row_LASTAR = mysql_fetch_array($result_LASTAR);
		
			$sql_ord= "select sum(ORD_QTY) as ordqty from s_ordtrn where STK_NO='" . $row_s_mas["STK_NO"] . "' and CANCEL=0";
        	$result_ord =$db->RunQuery($sql_ord);
			$row_ord = mysql_fetch_array($result_ord);
		
		//$sql_openstk= "select * from openstk where stk_no='" . $row_s_mas["STK_NO"] . "' ";
      //  $result_openstk =$db->RunQuery($sql_openstk);
		//$row_openstk = mysql_fetch_array($result_openstk);
				
       
       // openstk.Open "select * from openstk where stk_no='" . $row_s_mas["STK_NO"] . "' ";


        	$curr_month = date("m");
        	$curr_year = date("Y");
        
        	$sql_ord1= "select sum(ORD_QTY) as ordqty from vieword where STK_NO='" . $row_s_mas["STK_NO"] . "' and cancel=0 and month(S_date)=" . $curr_month . " and year(S_date)=" . $curr_year ;
        
        	if (($curr_month + 1) > 12) {
          		$sql_ord2= "select sum(ORD_QTY) as ordqty from vieword where STK_NO='" . $row_s_mas["STK_NO"] . "' and cancel=0 and month(S_date)=" . ($curr_month + 1 - 12) . " and year(S_date)=" . $curr_year + 1 ;
        	} else {
          		$sql_ord2= "select sum(ORD_QTY) as ordqty from vieword where STK_NO='" . $row_s_mas["STK_NO"] . "' and cancel=0 and month(S_date)=" . $curr_month + 1 . " and year(S_date)=" . $curr_year ;
        	}
        
        	if (($curr_month + 2) > 12) {
        
				$sql_ord3= "select sum(ORD_QTY) as ordqty from vieword where STK_NO='" . $row_s_mas["STK_NO"] . "' and cancel=0 and month(S_date)=" . ($curr_month + 2 - 12) . " and year(S_date)=" . ($curr_year + 1) ;
        	} else {
        		$sql_ord3= "select sum(ORD_QTY) as ordqty from vieword where STK_NO='" . $row_s_mas["STK_NO"] . "' and cancel=0 and month(S_date)=" . (curr_month + 2) . " and year(S_date)=" . $curr_year ;
        	}
        
		
			$STK_NO = $row_s_mas["STK_NO"];
        	if (!is_null($row_s_mas["DESCRIPT"])) { $desctript = $row_s_mas["DESCRIPT"]; }
        	if (!is_null($row_s_mas["PART_NO"])) {$PART_NO = $row_s_mas["PART_NO"];}
        	if (!is_null($row_s_mas["GROUP3"])) {$group3 =$row_s_mas["GROUP3"];}
        
        	if (!is_null($row_LASTAR["REFNO"])) {$arno = $row_LASTAR["REFNO"];}
        	if (!is_null($row_LASTAR["SDATE"])) {$ardate = $row_LASTAR["SDATE"];}
        	if (!is_null($row_LASTAR["QTY"])) {$larqty = $row_LASTAR["QTY"]; }
        	if (!is_null($row_ord1["ordqty"])) { $ord_qty1 = $row_ord1["ordqty"];}
        	if (!is_null($row_ord2["ordqty"])) { $ord_qty2 = $row_ord2["ordqty"];}
        	if (!is_null($row_ord3["ordqty"])) { $ord_qty3 = $row_ord3["ordqty"];}
        	
        	$mon1 = MonthName($curr_month);
        	if (($curr_month + 1) > 12){
          		$mon2 = MonthName($curr_month + 1 - 12);
        	} else {
         		$mon2 = MonthName($curr_month + 1);
         	}
        	if (($curr_month + 2) > 12){
          		$mon3 = MonthName($curr_month + 2 - 12);
        	} else {
          		$mon3 = MonthName($curr_month + 2);
        	}
        
        	$pur0 = $qty[0];
        	$con0 = $con[0];
        	$ordqty = $row_ord["ordqty"];
        	$pur1 = $qty[1];
        	$con1 = $con[1];
			$open_stk=0;
        	//if (!is_null($row_openstk["open_stk"])){ $open_stk = $row_openstk["open_stk"];}
        	$pur2 = $qty[2];
        	$con2 = $con[2];
        	$pur3 = $qty[3];
        	$con3 = $con[3];
        	$pur4 = $qty[4];
        	$con4 = $con[4];
        	$pur5 = $qty[5];
        	$con5 = $con[5];
        	$QTYINHAND = $row_s_mas["QTYINHAND"];
        	$over90 = $munsold;

			$sql_temp="insert into tmppurcon(STK_NO, desctript, PART_NO, group3, arno, ardate, larqty, ord_qty1, ord_qty2, ord_qty3, mon1, mon2, mon3, pur0, con0, ordqty, pur1, con1, open_stk, pur2, con2, pur3, con3, pur4, con4, pur5, con5, QTYINHAND, over90) values ('".$STK_NO."', '".$desctript."', '".$PART_NO."', '".$group3."', '".$arno."', '".$ardate."', ".$larqty.", ".$ord_qty1.", ".$ord_qty2.", ".$ord_qty3.", '".$mon1."', '".$mon2."', '".$mon3."', ".$pur0.", ".$con0.", ".$ordqty.", ".$pur1.", ".$con1.", ".$open_stk.", ".$pur2."', ".$con2.", ".$pur3.", ".$con3.", ".$pur4.", ".$con4.", ".$pur5.", ".$con5.", ".$QTYINHAND.", ".$over90.")";
			$result_temp =$db->RunQuery($sql_temp);
     
       }
   }    
	   $heading = "Last 6 Month Stock Consumption With Purchase   Brand   :  " . $_GET["brand"] . "     Data As At    :" . date("Y-m-d");

	$month=date("m",strtotime($_GET["dte_from"]));
	
	if ($month == 1) {
 		$txtmon1= "Aug";
	 	$txtmon2= "Sep";
	 	$txtmon3= "Oct";
 		$txtmon4= "Nov";
 		$txtmon5= "Dec";
 		$txtmon6= "Jan";
	}
	
	
	
	if ($month == 2) {
 		$txtmon1= "Sep";
 		$txtmon2= "Oct";
 		$txtmon3= "Nov";
 		$txtmon4= "Dec";
 		$txtmon5= "Jan";
 		$txtmon6= "Feb";
	}
	if ($month == 3) {
 		$txtmon1= "Oct";
 		$txtmon2= "Nov";
 		$txtmon3= "Dec";
 		$txtmon4= "Jan";
 		$txtmon5= "Feb";
 		$txtmon6= "Mar";
	}
	if ($month == 4) {
 		$txtmon1= "Nov";
 		$txtmon2= "Dec";
 		$txtmon3= "Jan";
 		$txtmon4= "Feb";
 		$txtmon5= "Mar";
 		$txtmon6= "Apr";
	}
	if ($month == 5) {
 		$txtmon1= "Dec";
 		$txtmon2= "Jan";
 		$txtmon3= "Feb";
 		$txtmon4= "Mar";
 		$txtmon5= "Apr";
 		$txtmon6= "May";
	}
	if ($month == 6) {
 		$txtmon1= "Jan";
 		$txtmon2= "Feb";
 		$txtmon3= "Mar";
 		$txtmon4= "Apr";
 		$txtmon5= "May";
 		$txtmon6= "Jun";
	}
	if ($month == 7) {
 		$txtmon1= "Feb";
 		$txtmon2= "Mar";
	 	$txtmon3= "Apr";
 		$txtmon4= "May";
 		$txtmon5= "Jun";
 		$txtmon6= "Jul";
	}
	if ($month == 8) {
 		$txtmon1= "Mar";
 		$txtmon2= "Apr";
 		$txtmon3= "May";
 		$txtmon4= "Jun";
 		$txtmon5= "Jul";
 		$txtmon6= "Aug";
	}
	if ($month == 9) {
 		$txtmon1= "Apr";
 		$txtmon2= "May";
 		$txtmon3= "Jun";
 		$txtmon4= "Jul";
 		$txtmon5= "Aug";
 		$txtmon6= "Sep";
	}
	if ($month == 10) {
 		$txtmon1= "May";
 		$txtmon2= "Jun";
 		$txtmon3= "Jul";
 		$txtmon4= "Aug";
 		$txtmon5= "Sep";
 		$txtmon6= "Oct";
	}
	if ($month == 11) {
 		$txtmon1= "Jun";
 		$txtmon2= "Jul";
 		$txtmon3= "Aug";
 		$txtmon4= "Sep";
 		$txtmon5= "Oct";
 		$txtmon6= "Nov";
	}
	if ($month == 12) {
 		$txtmon1= "Jul";
 		$txtmon2= "Aug";
 		$txtmon3= "Sep";
 		$txtmon4= "Oct";
 		$txtmon5= "Nov";
 		$txtmon6= "Dec";
	}
		
		
	function MonthName($mon){
		switch ($mon){
                    case 1: 
					  	return "Jan";
            		case 2: 
					  	return "Feb";
					case 3: 
					  	return "Mar";
					case 4: 
					  	return "Apr";
					case 5: 
					  	return "May";
					case 6: 
					  	return "Jun";			
					case 7: 
					  	return "Jul";
            		case 8: 
					  	return "Aug";
					case 9: 
					  	return "Sep";
					case 10: 
					  	return "Oct";
					case 11: 
					  	return "Nov";
					case 12: 
					  	return "Dec";				
				}	
	}
		
		$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
		echo "  <tr>
    <th rowspan=\"2\" scope=\"col\">Stock No</th>
    <th rowspan=\"2\" scope=\"col\">Description</th>
    <th rowspan=\"2\" scope=\"col\">Last AR Date</th>
    <th rowspan=\"2\" scope=\"col\">Last AR QTY</th>
    <th rowspan=\"2\" scope=\"col\">Op. Bal</th>
    <th colspan=\"2\" scope=\"col\">".$txtmon1."</th>
    <th colspan=\"2\" scope=\"col\">".$txtmon2."</th>
    <th colspan=\"2\" scope=\"col\">".$txtmon3."</th>
    <th colspan=\"2\" scope=\"col\">".$txtmon4."</th>
    <th colspan=\"2\" scope=\"col\">".$txtmon5."</th>
    <th colspan=\"2\" scope=\"col\">".$txtmon6."</th>
    <th scope=\"col\">Total Pur</th>
    <th scope=\"col\">Total Sale</th>
    <th scope=\"col\">Stock Balance</th>
    <th scope=\"col\">Order Qty</th>
    <th scope=\"col\">Mon1</th>
    <th scope=\"col\">Mon2</th>
    <th colspan=\"2\" scope=\"col\">To Be Order</th>
    <th scope=\"col\">To Be Order</th>
    <th scope=\"col\">&nbsp;</th>
  </tr>
  <tr>
    <td>Pur</td>
    <td>Sale</td>
    <td>Pur</td>
    <td>Sale</td>
    <td>Pur</td>
    <td>Sale</td>
    <td>Pur</td>
    <td>Sale</td>
    <td>Pur</td>
    <td>Sale</td>
    <td>Pur</td>
    <td>Sale</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>";
		//echo $sql;
		$totsort_val=0;
		$totexceed_val=0;
		
		$sql = "SELECT * from tmppurcon  where  pur0>0 or pur1>0 or pur2>0 or pur3>0 or pur5>0   or con0>0 or con1>0 or con2>0 or con3>0 or con4>0 or con5>0   or ordqty>0 or larqty >0";
		$result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result)){	
			echo "<tr>
			<td>".$row["STK_NO"]."</td>
			<td>".$row["desctript"]."</td>
			<td>".$row["ardate"]."</td>
			<td align=\"right\">".$row["larqty"]."</td>";
			
			$opbal=$row["QTYINHAND"]+$row["con5"]+$row["con4"]+$row["con3"]+$row["con2"]+$row["con1"]+$row["con0"]-$row["pur0"]-$row["pur1"]-$row["pur2"]-$row["pur3"]-$row["pur4"]-$row["pur5"];
			
			echo "<td align=\"right\">".number_format($opbal, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["pur5"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["con5"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["pur4"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["con4"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["pur3"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["con3"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["pur2"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["con2"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["pur1"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["con1"], 2, ".", ",")."</td>";
			
			$totpur=$row["pur0"]+$row["pur1"]+$row["pur2"]+$row["pur3"]+$row["pur4"]+$row["pur5"];
			
			echo "<td align=\"right\">".number_format($totpur, 2, ".", ",")."</td>";
			
			$totsale=$row["con0"]+$row["con1"]+$row["con2"]+$row["con3"]+$row["con4"]+$row["con5"];
			
			echo "<td align=\"right\">".number_format($totsale, 2, ".", ",")."</td>";
			echo "<td align=\"right\">".number_format($row["QTYINHAND"], 2, ".", ",")."</td>";
			echo "<td align=\"right\">".number_format($row["ordqty"], 2, ".", ",")."</td>";
			echo "<td align=\"right\">".number_format($row["ord_qty1"], 2, ".", ",")."</td>";
			echo "<td align=\"right\">".number_format($row["ord_qty2"], 2, ".", ",")."</td>";
			echo "<td align=\"right\">".number_format($row["ord_qty3"], 2, ".", ",")."</td>";
			echo "<td align=\"right\">&nbsp;</td>";
			echo "<td align=\"right\">&nbsp;</td>";
			
			if ($row["over90"] > 0) { 
				$over90=$row["over90"]; 
			} else {
				$over90="";
			}
			
			echo "<td align=\"right\">".number_format($over90, 2, ".", ",")."</td>";
			echo "</tr>";
			
			
		}
		
		
			
		echo "<table>";
	
	







?>
</body>
</html>
