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


 if ($_GET["Command"]=="chk_number"){
 	
	$sql = mysql_query("Select * from s_salrep where REPCODE=".$_GET["txtcode"]) or die(mysql_error());
	if($row = mysql_fetch_array($sql)){
		echo "included";
	} else { 
		echo "no";
	}
 }
 
 
if ($_GET["Command"]=="search_inv"){
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Sales Rep No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rep Name</font></td>
                             
   							</tr>";
                           
							if ($_GET["mstatus"]=="repno"){
						   		$letters = $_GET['repno'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								$a="SELECT * from s_salrep where REPCODE like  '$letters%'";
								//echo $a;
								$sql = mysql_query("SELECT * from s_salrep where REPCODE like  '$letters%'") or die(mysql_error());
							} else if ($_GET["mstatus"]=="repname"){
								$letters = $_GET['repname'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_salrep where Name like  '$letters%'") or die(mysql_error()) or die(mysql_error());
							} else {
								
								$letters = $_GET['repname'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_salrep where Name like  '$letters%'") or die(mysql_error()) or die(mysql_error());
							}
							
													
						
							while($row = mysql_fetch_array($sql)){
								$repcode = $row['REPCODE'];
								$stname = "sal_inv";
							$ResponseXML .= "<tr>
                           	  <td onclick=\"repno('$repcode', '$stname');\">".$row['REPCODE']."</a></td>
                              <td onclick=\"repno('$repcode', '$stname');\">".$row['Name']."</a></td>
                                                                            	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}


if ($_GET["Command"]=="pass_repno"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
					$repno= $_GET['repno']; 
					$_SESSION["repno"]=$_GET['repno']; 
			 		//$tmpinvno="0000".substr($_GET['invno'], 4, 7) ;
					//$lenth=strlen($tmpinvno);
					//$serial=substr($tmpinvno, $lenth-7);
					//$inv=substr($_GET['invno'], 0, 3).substr("\ ", 0, 1).$serial;
				$a="Select * from s_salrep where REF_NO='".$repno."'";
				//echo $a;
				$sql = mysql_query("Select * from s_salrep where REPCODE=".$repno) or die(mysql_error());
				
				if($row = mysql_fetch_array($sql)){
				
					$ResponseXML .= "<repcode><![CDATA[".$row['REPCODE']."]]></repcode>";
					$ResponseXML .= "<repname><![CDATA[".$row['Name']."]]></repname>";
					$ResponseXML .= "<target><![CDATA[".$row['target']."]]></target>";
					$ResponseXML .= "<group><![CDATA[".$row['RGROUP']."]]></group>";
					$ResponseXML .= "<cancel><![CDATA[".$row['cancel']."]]></cancel>";
					
					$ResponseXML .= "<target_table><![CDATA[ <table width=\"712\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          			<tr>
           			 <td width=\"66\">Code</td>
           			 <td width=\"327\">Name</td>
            		 <td width=\"159\">Target</td>
            		 <td width=\"132\">Last Update</td>
         			 </tr>";
		  		
					$sql1 = mysql_query("Select * from dealer_target where rep='".$repno."' order by cus_code") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){	
		  				$cus_code=$row1["cus_code"];
						$name=$row1["name"];
						$target=$row1["target"];
						
						$ResponseXML .= "<tr bgcolor=\"#222222\">
            						<td onclick=\"showtarget('$cus_code', '$name', '$target');\">".$row1["cus_code"]."</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">".$row1["name"]."</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">".number_format($row1["target"], 2, ".", ",")."</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">".$row1["ldate"]."</td>
									</tr>";
					}
        			
					$ResponseXML .= "   </table>]]></target_table>";
					
					
					$ResponseXML .= "<target_table_s><![CDATA[ <table width=\"712\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          			<tr>
           			 <td width=\"66\">Code</td>
           			 <td width=\"327\">Name</td>
            		 <td width=\"159\">Target</td>
            		 <td width=\"132\">Last Update</td>
         			 </tr>";
					$sql1 = mysql_query("Select * from dealer_target_s where rep='".$repno."' order by cus_code") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){	
		  				$cus_code=$row1["cus_code"];
						$name=$row1["name"];
						$target=$row1["target"];
						
						$ResponseXML .= "<tr bgcolor=\"#222222\">
            						<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">".$row1["cus_code"]."</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">".$row1["name"]."</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">".number_format($row1["target"], 2, ".", ",")."</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">".$row1["ldate"]."</td>
									</tr>";
					}
        			
					$ResponseXML .= "   </table>]]></target_table_s>";
				}	
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
				
	
}

if ($_GET["Command"]=="savetarget"){

header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
	$sql = mysql_query("Select * from dealer_target where rep='".$_GET["repno"]."' and cus_code='".$_GET["cuscode"]."'") or die(mysql_error());
	if($row = mysql_fetch_array($sql)){	
		$sql1 = mysql_query("update dealer_target set target=".$_GET["target"].", ldate='".date("d-m-Y")."' where rep='".$_GET["repno"]."' and  cus_code='".$_GET["cuscode"]."'") or die(mysql_error());
	} else {
//	echo "insert into dealer_target(rep, cus_code, name, target, ldate) values ('".$_GET["repno"]."', '".$_GET["cuscode"]."', '".$_GET["name"]."', ".$_GET["target"].", '".date("d-m-Y")."'";
		$sql1 = mysql_query("insert into dealer_target(rep, cus_code, name, target, ldate) values ('".$_GET["repno"]."', '".$_GET["cuscode"]."', '".$_GET["name"]."', ".$_GET["target"].", '".date("d-m-Y")."')") or die(mysql_error());
	}
	
	$ResponseXML .= "<target_table><![CDATA[ <table width=\"712\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          			<tr>
           			 <td width=\"66\">Code</td>
           			 <td width=\"327\">Name</td>
            		 <td width=\"159\">Target</td>
            		 <td width=\"132\">Last Update</td>
         			 </tr>";
		  		
					$sql1 = mysql_query("Select * from dealer_target where rep='".$_GET["repno"]."' order by cus_code") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){	
		  				$cus_code=$row1["cus_code"];
						$name=$row1["name"];
						$target=$row1["target"];
						
						$ResponseXML .= "<tr bgcolor=\"#222222\">
            						<td onclick=\"showtarget('$cus_code', '$name', '$target');\">".$row1["cus_code"]."</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">".$row1["name"]."</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">".number_format($row1["target"], 2, ".", ",")."</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">".$row1["ldate"]."</td>
									</tr>";
					}
        			
					$ResponseXML .= "   </table>]]></target_table>";
					
							$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
}


if ($_GET["Command"]=="savetarget_s"){

header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
	$sql = mysql_query("Select * from dealer_target_s where rep='".$_GET["repno"]."' and cus_code='".$_GET["cuscode"]."'") or die(mysql_error());
	if($row = mysql_fetch_array($sql)){	
		$sql1 = mysql_query("update dealer_target_s set target=".$_GET["target"].", ldate='".date("d-m-Y")."' where rep='".$_GET["repno"]."' and  cus_code='".$_GET["cuscode"]."'") or die(mysql_error());
	} else {
//	echo "insert into dealer_target(rep, cus_code, name, target, ldate) values ('".$_GET["repno"]."', '".$_GET["cuscode"]."', '".$_GET["name"]."', ".$_GET["target"].", '".date("d-m-Y")."'";
		$sql1 = mysql_query("insert into dealer_target_s(rep, cus_code, name, target, ldate) values ('".$_GET["repno"]."', '".$_GET["cuscode"]."', '".$_GET["name"]."', ".$_GET["target"].", '".date("d-m-Y")."')") or die(mysql_error());
	}
	
	$ResponseXML .= "<target_table><![CDATA[ <table width=\"712\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          			<tr>
           			 <td width=\"66\">Code</td>
           			 <td width=\"327\">Name</td>
            		 <td width=\"159\">Target</td>
            		 <td width=\"132\">Last Update</td>
         			 </tr>";
		  		
					$sql1 = mysql_query("Select * from dealer_target_s where rep='".$_GET["repno"]."' order by cus_code") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){	
		  				$cus_code=$row1["cus_code"];
						$name=$row1["name"];
						$target=$row1["target"];
						
						$ResponseXML .= "<tr bgcolor=\"#222222\">
            						<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">".$row1["cus_code"]."</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">".$row1["name"]."</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">".number_format($row1["target"], 2, ".", ",")."</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">".$row1["ldate"]."</td>
									</tr>";
					}
        			
					$ResponseXML .= "   </table>]]></target_table>";
					
							$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
}


if ($_GET["Command"]=="deletetarget"){

header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
	$sql = mysql_query("delete from dealer_target where rep='".$_GET["repno"]."' and cus_code='".$_GET["cuscode"]."'") or die(mysql_error());
	
	
	$ResponseXML .= "<target_table><![CDATA[ <table width=\"712\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          			<tr>
           			 <td width=\"66\">Code</td>
           			 <td width=\"327\">Name</td>
            		 <td width=\"159\">Target</td>
            		 <td width=\"132\">Last Update</td>
         			 </tr>";
		  		
					$sql1 = mysql_query("Select * from dealer_target where rep='".$_GET["repno"]."' order by cus_code") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){	
		  				$cus_code=$row1["cus_code"];
						$name=$row1["name"];
						$target=$row1["target"];
						
						$ResponseXML .= "<tr bgcolor=\"#222222\">
            						<td onclick=\"showtarget('$cus_code', '$name', '$target');\">".$row1["cus_code"]."</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">".$row1["name"]."</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">".number_format($row1["target"], 2, ".", ",")."</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">".$row1["ldate"]."</td>
									</tr>";
					}
        			
					$ResponseXML .= "   </table>]]></target_table>";
					
							$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
}

if ($_GET["Command"]=="deletetarget_s"){

header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
	$sql = mysql_query("delete from dealer_target_s where rep='".$_GET["repno"]."' and cus_code='".$_GET["cuscode"]."'") or die(mysql_error());
	
	
	$ResponseXML .= "<target_table><![CDATA[ <table width=\"712\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          			<tr>
           			 <td width=\"66\">Code</td>
           			 <td width=\"327\">Name</td>
            		 <td width=\"159\">Target</td>
            		 <td width=\"132\">Last Update</td>
         			 </tr>";
		  		
					$sql1 = mysql_query("Select * from dealer_target_s where rep='".$_GET["repno"]."' order by cus_code") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){	
		  				$cus_code=$row1["cus_code"];
						$name=$row1["name"];
						$target=$row1["target"];
						
						$ResponseXML .= "<tr bgcolor=\"#222222\">
            						<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">".$row1["cus_code"]."</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">".$row1["name"]."</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">".number_format($row1["target"], 2, ".", ",")."</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">".$row1["ldate"]."</td>
									</tr>";
					}
        			
					$ResponseXML .= "   </table>]]></target_table>";
					
							$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
}

if ($_GET["Command"]=="assign_brand"){
	$_SESSION["brand"]=$_GET["brand"];
	//echo $_SESSION["brand"]; 
	
}	

if ($_GET["Command"]=="brand_target"){
	
	$sql = mysql_query("Select * from reptrn where rep_code='".$_GET["txtcode"]."' and BrAnd='".$_GET["cmbbrand"]."'") or die(mysql_error());
	if($row = mysql_fetch_array($sql)){
		echo $row["Target"];
	} else {
		echo "0";
	}
	
}	

if ($_GET["Command"]=="update_target"){
	
	$sql = mysql_query("Select * from reptrn where rep_code='".$_GET["txtcode"]."' and BrAnd='".$_GET["cmbbrand"]."'") or die(mysql_error());
	if($row = mysql_fetch_array($sql)){
		$sql1 = mysql_query("update reptrn set Target=".$_GET["txttar"]." where rep_code='".$_GET["txtcode"]."' and BrAnd='".$_GET["cmbbrand"]."'") or die(mysql_error());
	} else {
		$sql1 = mysql_query("insert into reptrn(rep_code, BrAnd, Target) values ('".$_GET["txtcode"]."', '".$_GET["cmbbrand"]."', ".$_GET["txttar"].")") or die(mysql_error());
	}
	
	$sql = mysql_query("Select sum(Target) as tot_target from reptrn where rep_code='".$_GET["txtcode"]."'") or die(mysql_error());
	$row = mysql_fetch_array($sql);
	
	$sql1 = mysql_query("update s_salrep set target=".$row["tot_target"]." where REPCODE=".$_GET["txtcode"]) or die(mysql_error());

	echo "Updated";
}

if ($_GET["Command"]=="save_rep"){
	$sql = mysql_query("Select * from s_salrep where REPCODE=".$_GET["txtcode"]) or die(mysql_error());
	if($row = mysql_fetch_array($sql)){
		$sql1 = mysql_query("update s_salrep set Name='".$_GET["txtname"]."', target='".$_GET["txttottar"]."', cancel='".$_GET["act"]."', RGROUP='".$_GET["cmb_group"]."' where REPCODE=".$_GET["txtcode"]) or die(mysql_error());
	} else {
		$sql1 = mysql_query("insert into s_salrep (REPCODE, Name, target, cancel, RGROUP) values (".$_GET["txtcode"].", '".$_GET["txtname"]."', '".$_GET["txttottar"]."', '".$_GET["act"]."', '".$_GET["cmb_group"]."')") or die(mysql_error());
	}
	echo "Successfully saved";

}

if ($_GET["Command"]=="deleterep"){
	$sql = mysql_query("delete from s_salrep where REPCODE=".$_GET["txtcode"]) or die(mysql_error());
	
	echo "Successfully Deleted";

}

?>
