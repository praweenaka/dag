
<?php 
session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		
if($_GET["Command"]=="show_bal")
{
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;
		
	$sqlw="CREATE VIEW VIEW_com_she_B_mas AS
         SELECT Com_SHE.*, brand_mas.act AS act
         FROM brand_mas INNER JOIN Com_SHE ON brand_mas.barnd_name = Com_SHE.Brand";
	
	$resultw =$db->RunQuery($sqlw);	

	
			$ResponseXML .= "";
			$ResponseXML .= "<balancedetails>";
			
			$cmbrep=trim(substr($_GET["cmbrep"], 0, 4));
			
			$txttar=0;
			$txtT1=0;
			$txtT2=0;
			
			$sql="select * from s_salrep where repcode='".$cmbrep."'";
			$result =$db->RunQuery($sql);	
			
			if ($row = mysql_fetch_array($result)){
				if (is_null($row["target"])==false){
					$txttar = number_format($row["target"], 2, ".", ",");
				}	
			}
			
			$sql="select * from sal_comm where sal_ex='".$cmbrep."'";
			$result =$db->RunQuery($sql);
			if ($row = mysql_fetch_array($result)){
				$txtT1 = number_format($row["T1"], 2, ".", ",");
				$txtT2 = number_format($row["T2"], 2, ".", ",");
			}

			$cmbrep=trim(substr($_GET["cmbrep"], 0, 5));
			
			$ResponseXML .= "<txttar><![CDATA[".$txttar."]]></txttar>";
			$ResponseXML .= "<txtT1><![CDATA[".$txtT1."]]></txtT1>";
			$ResponseXML .= "<txtT2><![CDATA[".$txtT2."]]></txtT2>";
			
		//	$ResponseXML .= "<txttar><![CDATA[150]]></txttar>";
		//	$ResponseXML .= "<txtT1><![CDATA[".$txtT1."]]></txtT1>";
		//	$ResponseXML .= "<txtT2><![CDATA[".$txtT2."]]></txtT2>";
			
		/*	$sql="select id,Brand,T1_Cat1,T1_cat2,T1_cat3,T2_Cat1,T2_cat2,T2_Cat3,T3_cat1,T3_cat2,T3_cat3,Day1,Day2 from VIEW_com_she_B_mas where sal_ex='".$cmbrep."'and act = '1' order by brand";
			echo $sql;
			$result =$db->RunQuery($sql);
			if ($row = mysql_fetch_array($result)){
				
				$sql1="select * from brand_mas where act = '1' order by barnd_name";
				$result1 =$db->RunQuery($sql1);
				while ($row1 = mysql_fetch_array($result1)){
					
					$sql2="select  * from com_SHE where sal_ex='".$cmbrep."' and brand='".trim($row1["barnd_name"])."'";
					$result2 =$db->RunQuery($sql2);
					if ($row2 = mysql_fetch_array($result2)){
						$sql3="insert into com_she(brand,sal_ex) values('".trim($row1["barnd_name"])."','".$cmbrep."')";
						$result3 =$db->RunQuery($sql3);
					}	
    			}*/
				
				
				//Set Grid==========================
				$i=1;
				$ResponseXML .= "<balance_table><![CDATA[<table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\"><td width=\"0\"></td>
					<td width=\"200\"  background=\"images/headingbg.gif\">Brand</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">T1_cat1</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">T1_cat2</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">T1_cat3</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">T2_cat1</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">T2_cat2</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">T2_cat3</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">T3_cat1</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">T3_cat2</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">T3_cat3</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">Day1</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">Day2</td></tr>";
				
				$sql="select id,Brand,T1_Cat1,T1_cat2,T1_cat3,T2_Cat1,T2_cat2,T2_Cat3,T3_cat1,T3_cat2,T3_cat3,Day1,Day2 from VIEW_com_she_B_mas where sal_ex='".$cmbrep."'and act = '1' order by Brand";
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
					if ($row["T1_Cat1"]!="") {
						$id="id".$i;
						$Brand="brand".$i;
						$T1_cat1="T1_cat1".$i;
						$T1_cat2="T1_cat2".$i;
						$T1_cat3="T1_cat3".$i;
						$T2_cat1="T2_cat1".$i;
						$T2_cat2="T2_cat2".$i;
						$T2_cat3="T2_cat3".$i;
						$T3_cat1="T3_cat1".$i;
						$T3_cat2="T3_cat2".$i;
						$T3_cat3="T3_cat3".$i;
						$Day1="Day1".$i;
						$Day2="Day2".$i;
						
						$ResponseXML .=  "<tr><td><font size=2><input type=\"hidden\" name=".$id." id=".$id." size=\"8\" value=".$row["id"]." class=\"txtbox\" ></font></td>
						<td><font size=2><div id=".$Brand.">".$row["Brand"]."</div></font></td>
						<td><input type=\"text\" name=".$T1_cat1." id=".$T1_cat1." size=\"8\" value=".$row["T1_Cat1"]." class=\"txtbox\" ></td>
						<td><input type=\"text\" name=".$T1_cat2." id=".$T1_cat2." size=\"8\" value=".$row["T1_cat2"]." class=\"txtbox\"  ></td>
						<td><input type=\"text\" name=".$T1_cat3." id=".$T1_cat3." size=\"8\" value=".$row["T1_cat3"]."  class=\"txtbox\" ></td>
						<td><input type=\"text\" name=".$T2_cat1." id=".$T2_cat1." size=\"8\" value=".$row["T2_Cat1"]."  class=\"txtbox\" ></td>
						<td><input type=\"text\" name=".$T2_cat2." id=".$T2_cat2." size=\"8\" value=".$row["T2_cat2"]."  class=\"txtbox\" ></td>
						<td><input type=\"text\" name=".$T2_cat3." id=".$T2_cat3." size=\"8\" value=".$row["T2_Cat3"]." class=\"txtbox\"  ></td>
						<td><input type=\"text\" name=".$T3_cat1." id=".$T3_cat1." size=\"8\" value=".$row["T3_cat1"]." class=\"txtbox\"  ></td>
						<td><input type=\"text\" name=".$T3_cat2." id=".$T3_cat2." size=\"8\" value=".$row["T3_cat2"]." class=\"txtbox\"  ></td>
						<td><input type=\"text\" name=".$T3_cat3." id=".$T3_cat3." size=\"8\" value=".$row["T3_cat3"]." class=\"txtbox\"  ></td>
						<td><input type=\"text\" name=".$Day1." id=".$Day1." size=\"8\" value=".$row["Day1"]." class=\"txtbox\"  ></td>
						<td><input type=\"text\" name=".$Day2." id=".$Day2." size=\"8\" value=".$row["Day2"]." class=\"txtbox\"  ></font></td>
						</tr>";
						$i=$i+1;
					 }
					
				}
				$ResponseXML .=  "</table>]]></balance_table>";			
			 $ResponseXML .= "<mtot><![CDATA[".$i."]]></mtot>";
			$ResponseXML .=  "</balancedetails>";
			echo $ResponseXML;			
}

if($_POST["Command"]=="save_balance_item")
{	
	$i=1;
	//echo "jhhhkk". $_POST["mcount"];
	while($_POST["mcount"]>$i){
		$id="id".$i;
						$Brand="brand".$i;
						$T1_cat1="T1_cat1".$i;
						$T1_cat2="T1_cat2".$i;
						$T1_cat3="T1_cat3".$i;
						$T2_cat1="T2_cat1".$i;
						$T2_cat2="T2_cat2".$i;
						$T2_cat3="T2_cat3".$i;
						$T3_cat1="T3_cat1".$i;
						$T3_cat2="T3_cat2".$i;
						$T3_cat3="T3_cat3".$i;
						$Day1="Day1".$i;
						$Day2="Day2".$i;
	$sql1="update com_she set Brand='".$_POST[$Brand]."', sal_ex='".$_POST["sal_ex"]."', T1_Cat1='".$_POST[$T1_cat1]."', T1_cat2='".$_POST[$T1_cat2]."', T1_cat3='".$_POST[$T1_cat3]."', T2_Cat1='".$_POST[$T2_cat1]."', T2_cat2='".$_POST[$T2_cat2]."', T2_Cat3='".$_POST[$T2_cat3]."', T3_cat1='".$_POST[$T3_cat1]."', T3_cat2='".$_POST[$T3_cat2]."', T3_cat3='".$_POST[$T3_cat3]."', Day1='".$_POST[$Day1]."', Day2='".$_POST[$Day2]."' where id=".$_POST[$id];
	//echo $sql1;
	$result1 =$db->RunQuery($sql1);
	$i=$i+1;
	
	}
	echo "Saved";
	
}

echo $_POST["Command"];
?>