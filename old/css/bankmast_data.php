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
		



	include_once("connection.php");

if ($_GET["Command"]=="save_bank"){
	
		//echo "insert into bankmas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')";
		
		
		
			$sql = mysql_query("delete from bankmas where bcode='".$_GET["bcode"]."'") or die(mysql_error());
			//echo "insert into s_stomas(CODE, DESCRIPTION) values ('".$_GET["store_code"]."', '".$_GET["storename"]."')";
			$sql = mysql_query("insert into bankmas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')") or die(mysql_error());
	
	
			$ResponseXML = "";
			$ResponseXML .= "<br>
                                        <table border=\"1\" cellspacing=\"0\">
                                        <tr><td>Bank Code</td>
                                        <td>Branch</td>
                                        <td>Bank Name</td>
                                        <td>Short Name</td>
              </tr>";
                                      
				
										$sql = mysql_query("select * from bankmas order by bcode") or die(mysql_error());
										while ($row = mysql_fetch_array($sql)){
											if ($row["bcode"]!=""){
											$ResponseXML .= "<tr>
                                            	<td onclick=\"bankno('".$row['bcode']."', '".$row['bbcode']."', '".$row['bname']."', '".$row['shname']."');\">".$row["bcode"]."</td>
                                            	<td onclick=\"bankno('".$row['bcode']."', '".$row['bbcode']."', '".$row['bname']."', '".$row['shname']."');\">".$row["bbcode"]."</td>
												<td onclick=\"bankno('".$row['bcode']."', '".$row['bbcode']."', '".$row['bname']."', '".$row['shname']."');\">".$row["bname"]."</td>
												<td onclick=\"bankno('".$row['bcode']."', '".$row['bbcode']."', '".$row['bname']."', '".$row['shname']."');\">".$row["shname"]."</td></tr>";
												}
										}
										
										
                                          
                                       $ResponseXML .= " </table>";
                                       	
		
	
	echo $ResponseXML; 
}

if ($_GET["Command"]=="delete_bank"){
	
		//echo "insert into bankmas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')";
		$sql = mysql_query("delete from bankmas where bcode='".$_GET["bcode"]."'") or die(mysql_error());
	
	
	$ResponseXML = "";
	$ResponseXML .= "<br>
                                        <table border=\"1\" cellspacing=\"0\">
                                        <tr><td>Bank Code</td>
                                        <td>Branch</td>
                                        <td>Bank Name</td>
                                        <td>Short Name</td>
              </tr>";
                                      
				
										$sql = mysql_query("select * from bankmas order by bcode") or die(mysql_error());
										while ($row = mysql_fetch_array($sql)){
											if ($row["bcode"]!=""){
											$ResponseXML .= "<tr>
                                            	<td onclick=\"bankno('".$row['bcode']."', '".$row['bbcode']."', '".$row['bname']."', '".$row['shname']."');\">".$row["bcode"]."</td>
                                            	<td onclick=\"bankno('".$row['bcode']."', '".$row['bbcode']."', '".$row['bname']."', '".$row['shname']."');\">".$row["bbcode"]."</td>
												<td onclick=\"bankno('".$row['bcode']."', '".$row['bbcode']."', '".$row['bname']."', '".$row['shname']."');\">".$row["bname"]."</td>
												<td onclick=\"bankno('".$row['bcode']."', '".$row['bbcode']."', '".$row['bname']."', '".$row['shname']."');\">".$row["shname"]."</td></tr>";
												}
										}
										
                                          
                                       $ResponseXML .= " </table>";
                                       echo $ResponseXML; 	
	
	
}



?>
