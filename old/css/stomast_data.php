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

if ($_GET["Command"]=="save_sto"){
	
		//echo "insert into bankmas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')";
		
		
		
			$sql = mysql_query("delete from s_stomas where CODE='".$_GET["store_code"]."'") or die(mysql_error());
			//echo "insert into s_stomas(CODE, DESCRIPTION) values ('".$_GET["store_code"]."', '".$_GET["storename"]."')";
			$sql = mysql_query("insert into s_stomas(CODE, DESCRIPTION, act) values ('".$_GET["store_code"]."', '".$_GET["storename"]."', '".$_GET["act"]."')") or die(mysql_error());
	
	
			$ResponseXML = "";
			$ResponseXML .= "<br>
                                        <table border=\"1\" cellspacing=\"0\">
                                        <tr><td width=\"39%\">Store Code</td>
              <td width=\"61%\">Store Name</td>
			  <td width=\"10%\">Activate</td>
              </tr>";
                                      
				
										$sql = mysql_query("select * from s_stomas order by CODE") or die(mysql_error());
										while ($row = mysql_fetch_array($sql)){
											if ($row["CODE"]!=""){
											$ResponseXML .= "<tr>
                                            	<td width=\"155\" onclick=\"stono('".$row['CODE']."', '".$row['DESCRIPTION']."');\">".$row["CODE"]."</td>
                                            	<td width=\"155\" onclick=\"stono('".$row['CODE']."', '".$row['DESCRIPTION']."');\">".$row["DESCRIPTION"]."</td>
												<td width=\"155\" onclick=\"stono('".$row['CODE']."', '".$row['act']."');\">".$row["act"]."</td></tr>";
												}
										}
										
										
                                          
                                       $ResponseXML .= " </table>";
                                       	
		
	
	echo $ResponseXML; 
}

if ($_GET["Command"]=="delete_sto"){
	
		//echo "insert into bankmas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')";
		$sql = mysql_query("delete from s_stomas where CODE='".$_GET["store_code"]."'") or die(mysql_error());
	
	
	$ResponseXML = "";
	$ResponseXML .= "<br>
                                        <table border=\"1\" cellspacing=\"0\">
                                        <tr><td width=\"39%\">Store Code</td>
              <td width=\"61%\">Store Name</td>
			  <td width=\"10%\">Activate</td>
              </tr>";
                                      
								
										$sql = mysql_query("select * from s_stomas order by CODE") or die(mysql_error());
										while ($row = mysql_fetch_array($sql)){
											if ($row["CODE"]!=""){
											$ResponseXML .= "<tr>
                                            	<td width=\"155\" onclick=\"stono('".$row['CODE']."', '".$row['DESCRIPTION']."');\">".$row["CODE"]."</td>
                                            	<td width=\"155\" onclick=\"stono('".$row['CODE']."', '".$row['DESCRIPTION']."');\">".$row["DESCRIPTION"]."</td>
												<td width=\"155\" onclick=\"stono('".$row['CODE']."', '".$row['act']."');\">".$row["act"]."</td></tr>";
												}
										}
										
										
                                          
                                       $ResponseXML .= " </table>";
                                       echo $ResponseXML; 	
	
	
}



?>
