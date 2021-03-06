<?php 	
/*
	include_once("connectioni.php");
	include_once("DBConnector.php");
	$letters = $_GET['letters'];
	
	$sql="SELECT * FROM mast_family where name like '".$letters."%'";
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			
			while($row = mysqli_fetch_array($result))
			{
			
			echo $row["name"];
			
			}
			
		*/	
		



	include_once("connectioni.php");

if ($_GET["Command"]=="save_bank"){
	
		//echo "insert into bankmas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')";
		
		
		
			$sql = mysqli_query($GLOBALS['dbinv'],"delete from bankmas where bcode='".$_GET["bcode"]."'") or die(mysqli_error());
			//echo "insert into s_stomas(CODE, DESCRIPTION) values ('".$_GET["store_code"]."', '".$_GET["storename"]."')";
			$sql = mysqli_query($GLOBALS['dbinv'],"insert into bankmas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')") or die(mysqli_error());
	
	
			$ResponseXML = "";
			$ResponseXML .= "<br>
                                        <table border=\"1\" cellspacing=\"0\">
                                        <tr><td>Bank Code</td>
                                        <td>Branch</td>
                                        <td>Bank Name</td>
                                        <td>Short Name</td>
              </tr>";
                                      
				
										$sql = mysqli_query($GLOBALS['dbinv'],"select * from bankmas order by bcode") or die(mysqli_error());
										while ($row = mysqli_fetch_array($sql)){
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
		$sql = mysqli_query($GLOBALS['dbinv'],"delete from bankmas where bcode='".$_GET["bcode"]."'") or die(mysqli_error());
	
	
	$ResponseXML = "";
	$ResponseXML .= "<br>
                                        <table border=\"1\" cellspacing=\"0\">
                                        <tr><td>Bank Code</td>
                                        <td>Branch</td>
                                        <td>Bank Name</td>
                                        <td>Short Name</td>
              </tr>";
                                      
				
										$sql = mysqli_query($GLOBALS['dbinv'],"select * from bankmas order by bcode") or die(mysqli_error());
										while ($row = mysqli_fetch_array($sql)){
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
