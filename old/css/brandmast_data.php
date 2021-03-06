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

if ($_GET["Command"]=="save_bank"){
	
		//echo "insert into brand_mas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')";
		$sql = mysql_query("delete from brand_mas where barnd_name='".$_GET["barnd_name"]."'") or die(mysql_error()) or die(mysql_error());
		
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
		
		$sql = mysql_query("insert into brand_mas(barnd_name, class, act, delinrate) values ('".$_GET["barnd_name"]."', '".$_GET["class"]."', '".$act."', '".$delinrate."')") or die(mysql_error()) or die(mysql_error());
	
	
	$ResponseXML = "";
	$ResponseXML .= "<br>
                                        <table border=\"1\" cellspacing=\"0\">";
                                      
									  $sql = mysql_query("select * from brand_mas") or die(mysql_error()) or die(mysql_error());
									
										while ($row = mysql_fetch_array($sql)){
											if ($row["barnd_name"]!=""){
											$ResponseXML .= "<tr>
                                            	<td width=\"155\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$row["barnd_name"]."</td>
                                            	<td width=\"155\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$row["class"]."</td>
                                           		<td width=\"435\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$row["act"]."</td>";
											
											$target="";	
											if ($row["delinrate"]=="0"){
												$target="Normal";	
											} else if ($row["delinrate"]=="2.5"){
												$target="Tyre";	
											} else if ($row["delinrate"]=="3.5"){
												$target="Battery";	
											}	
													
                                            	$ResponseXML .= "<td width=\"150\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$target."</td>
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
	
	 $sql = mysql_query("select * from brand_mas where  barnd_name='".$_GET["barnd_name"]."'") or die(mysql_error()) or die(mysql_error());
	 if ($row = mysql_fetch_array($sql)){
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
		$sql = mysql_query("delete from brand_mas where barnd_name='".$_GET["barnd_name"]."'") or die(mysql_error()) or die(mysql_error());
	
	
	$ResponseXML = "";
	$ResponseXML .= "<br>
                                        <table border=\"1\" cellspacing=\"0\">";
                                      
									  $sql = mysql_query("select * from brand_mas") or die(mysql_error()) or die(mysql_error());
									
										while ($row = mysql_fetch_array($sql)){
											if ($row["barnd_name"]!=""){
											$ResponseXML .=  "<tr>
                                            	<td width=\"155\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$row["barnd_name"]."</td>
                                            	<td width=\"155\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$row["class"]."</td>
                                           		<td width=\"435\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$row["act"]."</td>";
											
											$target="";	
											if ($row["delinrate"]=="0"){
												$target="Normal";	
											} else if ($row["delinrate"]=="2.5"){
												$target="Tyre";	
											} else if ($row["delinrate"]=="3.5"){
												$target="Battery";	
											}	
													
                                            	$ResponseXML .= "<td width=\"150\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$target."</td>
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
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Brand Name</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Class</font></td>
							   <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Active</font></td>
							    <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Target Type</font></td>
                             
   							</tr>";
                           
							
						   		$letters = $_GET['barnd_name'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								
								//echo $a;
							$sql = mysql_query("SELECT * from brand_mas where barnd_name like  '$letters%'") or die(mysql_error());
							while($row = mysql_fetch_array($sql)){
								
							$ResponseXML .= "<tr>
                           	  <td bgcolor=\"#222222\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$row['barnd_name']."</a></td>
                               <td bgcolor=\"#222222\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$row['class']."</a></td>
							    <td bgcolor=\"#222222\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$row['act']."</a></td>";
								
								$target="";	
											if ($row["delinrate"]=="0"){
												$target="Normal";	
											} else if ($row["delinrate"]=="2.5"){
												$target="Tyre";	
											} else if ($row["delinrate"]=="3.5"){
												$target="Battery";	
											}	
													
                                        $ResponseXML .="<td bgcolor=\"#222222\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$target."</td>
                                                                            	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}

?>
