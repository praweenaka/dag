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
		
		
session_start();


	include_once("connectioni.php");

if ($_GET["Command"]=="save_bank"){
	
		//echo "insert into brand_mas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')";
		$sql = mysqli_query($GLOBALS['dbinv'],"delete from brand_mas where barnd_name='".$_GET["barnd_name"]."'") or die(mysqli_error()) or die(mysqli_error());
		
		$delinrate=0;
		if ($_GET["cmbtargettype"]=="Normal"){
			$delinrate=0;
		} else if ($_GET["cmbtargettype"]=="Tyre"){
			$delinrate=2.5;
		} else if ($_GET["cmbtargettype"]=="Battery"){
			$delinrate=3.5;
		}
		
		
		if ($_GET["act"]=="true"){
			$act=1;
		} else {
			$act=0;
		}
		
		$sql = mysqli_query($GLOBALS['dbinv'],"insert into brand_mas(barnd_name, class, act, delinrate,costcenter,dis) values ('".$_GET["barnd_name"]."', '".$_GET["class"]."', '".$act."', '".$delinrate."','" . $_GET['group'] . "','" . $_GET['dis'] . "')") or die(mysqli_error()) or die(mysqli_error());
	
	
	$ResponseXML = "";
	$ResponseXML .= "<br>
                                        <table border=\"1\" cellspacing=\"0\">";
                                      
									  $sql = mysqli_query($GLOBALS['dbinv'],"select * from brand_mas   order by act desc,class, barnd_name") or die(mysqli_error()) or die(mysqli_error());
									
									
									$ResponseXML .= "<tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Brand Name</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Class</font></td>
							   <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Active</font></td>
							    <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Target Type</font></td>
								<td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Group</font></td>
								<td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">DISCOUNT</font></td>
   							</tr>";
										while ($row = mysqli_fetch_array($sql)){
											if ($row["barnd_name"]!=""){
											$ResponseXML .= "<tr>
                                            	<td width=\"155\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."','" . $row['costcenter'] ."','" . $row['dis'] ."');\">".$row["barnd_name"]."</td>
                                            	<td width=\"155\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."','" . $row['costcenter'] ."','" . $row['dis'] ."');\">".$row["class"]."</td>
                                           		<td width=\"435\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."','" . $row['costcenter'] ."','" . $row['dis'] ."');\">".$row["act"]."</td>";
											
											$target="";	
											if ($row["delinrate"]=="0"){
												$target="Normal";	
											} else if ($row["delinrate"]=="2.5"){
												$target="Tyre";	
											} else if ($row["delinrate"]=="3.5"){
												$target="Battery";	
											}	
													
                                            	$ResponseXML .= "<td width=\"150\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."','" . $row['costcenter'] ."','" . $row['dis'] ."');\">".$target."</td>
												<td width=\"150\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."','" . $row['costcenter'] ."','" . $row['dis'] ."');\">". $row['costcenter'] ."</td>
												<td width=\"150\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."','" . $row['costcenter'] ."','" . $row['dis'] ."');\">". $row['dis'] ."</td>
                                          		</tr>";
												}
										}
										
										
                                          
                                       $ResponseXML .= " </table>";
                                       echo $ResponseXML; 	
	
	
}

if ($_GET["Command"]=="setbrand"){
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	 $sql = mysqli_query($GLOBALS['dbinv'],"select * from brand_mas where  barnd_name='".$_GET["barnd_name"]."'") or die(mysqli_error()) or die(mysqli_error());
	 if ($row = mysqli_fetch_array($sql)){
	 	$ResponseXML .= "<class><![CDATA[".$row['class']."]]></class>";
		$ResponseXML .= "<act><![CDATA[".$row['act']."]]></act>";
		
		$delinrate="";
		if ($row["delinrate"]=="0"){
			$delinrate="Normal";
		} else if ($row["delinrate"]=="2.5"){
			$delinrate="Tyre";
		} else if ($row["delinrate"]=="3.5"){
			$delinrate="Battery";
		}
		$ResponseXML .= "<delinrate><![CDATA[".$delinrate."]]></delinrate>";
	 }
	 
	 $ResponseXML .= "</salesdetails>";	
	 echo $ResponseXML;
										
}


if ($_GET["Command"]=="delete_bank"){
	
		//echo "insert into brand_mas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')";
		$sql = mysqli_query($GLOBALS['dbinv'],"delete from brand_mas where barnd_name='".$_GET["barnd_name"]."'") or die(mysqli_error()) or die(mysqli_error());
	
	
	$ResponseXML = "";
	$ResponseXML .= "<br>
                                        <table border=\"1\" cellspacing=\"0\">";
                                      
									  $sql = mysqli_query($GLOBALS['dbinv'],"select * from brand_mas") or die(mysqli_error()) or die(mysqli_error());
									
										while ($row = mysqli_fetch_array($sql)){
											if ($row["barnd_name"]!=""){
											$ResponseXML .=  "<tr>
                                            	<td width=\"155\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."', '".$row['dis']."');\">".$row["barnd_name"]."</td>
                                            	<td width=\"155\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."', '".$row['dis']."');\">".$row["class"]."</td>
                                           		<td width=\"435\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."', '".$row['dis']."');\">".$row["act"]."</td>";
											
											$target="";	
											if ($row["delinrate"]=="0"){
												$target="Normal";	
											} else if ($row["delinrate"]=="2.5"){
												$target="Tyre";	
											} else if ($row["delinrate"]=="3.5"){
												$target="Battery";	
											}	
													
                                            	$ResponseXML .= "<td width=\"150\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."', '".$row['dis']."');\">".$target."</td>
                                            	<td width=\"150\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."', '".$row['dis']."');\">".$row['dis']."</td>

                                          		</tr>";
												}
										}
										
										
                                          
                                       $ResponseXML .= " </table>";
                                       echo $ResponseXML; 	
	
	
}

if ($_GET["Command"]=="search_brand"){
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"1\"  cellspacing=\"0\" >
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">Brand Name</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Class</font></td>
							   <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Active</font></td>
							    <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Target Type</font></td>
                             
   							</tr>";
                           
							
						   		$letters = $_GET['barnd_name'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								
								//echo $a;
							$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from brand_mas where barnd_name like  '$letters%'") or die(mysqli_error());
							while($row = mysqli_fetch_array($sql)){
								
							$ResponseXML .= "<tr>
                           	  <td bgcolor=\"#222222\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."', '".$row['dis']."');\">".$row['barnd_name']."</a></td>
                               <td bgcolor=\"#222222\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."', '".$row['dis']."');\">".$row['class']."</a></td>
							    <td bgcolor=\"#222222\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."', '".$row['dis']."');\">".$row['act']."</a></td>";
								
								$target="";	
											if ($row["delinrate"]=="0"){
												$target="Normal";	
											} else if ($row["delinrate"]=="2.5"){
												$target="Tyre";	
											} else if ($row["delinrate"]=="3.5"){
												$target="Battery";	
											}	
													
                                        $ResponseXML .="<td bgcolor=\"#222222\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$target."</td>
                                        <td bgcolor=\"#222222\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."', '".$row['dis']."');\">".$row['dis']."</td>
                                                                            	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}

?>
