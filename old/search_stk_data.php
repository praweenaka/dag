<?php


include_once("connectioni.php");

if ($_GET["Command"]=="set_sales_month12"){
	
	//$_GET["month1"];
}


if ($_GET["Command"]=="search_item"){

	if(isset($_GET['item_name']) or isset($_GET['itemno'])){
		
 
	
		$ResponseXML .= "";
	 
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"><b>Item Code</b></font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"><b>Item Description</b></font></td>
                              <td width=\"150\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"><b>Genuine No</b></font></td>
							  <td width=\"150\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"><b>Part No</b></font></td>
							  <td width=\"150\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"><b>Model</b></font></td>
							  <td width=\"150\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"><b>QTY in Hand</b></font></td>
							  <td width=\"150\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"><b>Price</b></font></td>
   							</tr>";
                           
						   if ($_GET["mstatus"]=="name"){
						   		$letters = $_GET['item_name'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$tmp="select STK_NO,DESCRIPT,GEN_NO,PART_NO,BRAND_NAME,SELLING from s_mas where DESCRIPT like  '$letters%'";
								$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_mas where DESCRIPT like  '$letters%'") or die(mysqli_error());
							} else if ($_GET["mstatus"]=="itemno"){
								$letters = $_GET['itemno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$tmp="select STK_NO,DESCRIPT,GEN_NO,PART_NO,BRAND_NAME,SELLING from s_mas where STK_NO like  '$letters%'";
								$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_mas where STK_NO like  '$letters%'") or die(mysqli_error());
							}  else if ($_GET["mstatus"]=="model"){
								$letters = $_GET['model'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$tmp="select STK_NO,DESCRIPT,GEN_NO,PART_NO,BRAND_NAME,SELLING from s_mas where STK_NO like  '$letters%'";
								$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_mas where BRAND_NAME like  '$letters%'") or die(mysqli_error());
							} else {
								
								$letters = $_GET['item_name'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$tmp="select STK_NO,DESCRIPT,GEN_NO,PART_NO,BRAND_NAME,SELLING from s_mas where DESCRIPT like  '$letters%'";
								$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_mas where DESCRIPT like  '$letters%'") or die(mysqli_error());
							}
							
							
							
							
							while($row = mysqli_fetch_array($sql)){
					
							$ResponseXML .= "<tr>
                              <td onclick=\"itemno('".$row['STK_NO']."');\">".$row['STK_NO']."</a></td>
                              <td onclick=\"itemno('".$row['STK_NO']."');\">".$row['DESCRIPT']."</a></td>
                              <td onclick=\"itemno('".$row['STK_NO']."');\">".$row['GEN_NO']."</a></td>
							  <td onclick=\"itemno('".$row['STK_NO']."');\">".$row['PART_NO']."</a></td>
							  <td onclick=\"itemno('".$row['STK_NO']."');\">".$row['BRAND_NAME']."</a></td>
                              	<td onclick=\"itemno('".$row['STK_NO']."');\">".$row['QTYINHAND']."</a></td>
								<td onclick=\"itemno('".$row['STK_NO']."');\">".$row['SELLING']."</a></td>
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
	}
}


if ($_GET["Command"]=="pass_invno"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
					
				$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_mas where stk_no = '".trim($_GET["itno"])."'") or die(mysqli_error());
				if($row = mysqli_fetch_array($sql)){
				
					$ResponseXML .= "<STK_NO><![CDATA[".$row['STK_NO']."]]></STK_NO>";
					$ResponseXML .= "<BRAND_NAME><![CDATA[".trim($row['BRAND_NAME'])."]]></BRAND_NAME>";
					$ResponseXML .= "<DESCRIPT><![CDATA[".$row['DESCRIPT']."]]></DESCRIPT>";
					$ResponseXML .= "<GEN_NO><![CDATA[".$row['GEN_NO']."]]></GEN_NO>";
					$ResponseXML .= "<PART_NO><![CDATA[".$row['PART_NO']."]]></PART_NO>";
					$ResponseXML .= "<cost><![CDATA[".$row['COST']."]]></cost>";
					$ResponseXML .= "<stk_no><![CDATA[".$row['STK_NO']."]]></stk_no>";
					$ResponseXML .= "<LOCATE_1><![CDATA[".$row['LOCATE_1']."]]></LOCATE_1>";
					$ResponseXML .= "<LOCATE_2><![CDATA[".$row['LOCATE_2']."]]></LOCATE_2>";
					$ResponseXML .= "<LOCATE_3><![CDATA[".$row['LOCATE_3']."]]></LOCATE_3>";
					$ResponseXML .= "<LOCATE_4><![CDATA[".$row['LOCATE_4']."]]></LOCATE_4>";
					$ResponseXML .= "<MARGIN><![CDATA[".$row['MARGIN']."]]></MARGIN>";
					$ResponseXML .= "<model><![CDATA[".$row['model']."]]></model>";
					$ResponseXML .= "<SELLING><![CDATA[".$row['SELLING']."]]></SELLING>";
					$ResponseXML .= "<ar_selling><![CDATA[".$row['AR_selling']."]]></ar_selling>";
					$ResponseXML .= "<cat1><![CDATA[".trim($row['Cat1'])."]]></cat1>";
					$ResponseXML .= "<type><![CDATA[".trim($row['type'])."]]></type>";
					$ResponseXML .= "<GROUP1><![CDATA[".$row['GROUP1']."]]></GROUP1>";
					$ResponseXML .= "<GROUP2><![CDATA[".$row['GROUP2']."]]></GROUP2>";
					$ResponseXML .= "<GROUP3><![CDATA[".$row['GROUP3']."]]></GROUP3>";
					$ResponseXML .= "<GROUP4><![CDATA[".$row['GROUP4']."]]></GROUP4>";
					$ResponseXML .= "<UNIT><![CDATA[".$row['UNIT']."]]></UNIT>";
					$ResponseXML .= "<SIZE><![CDATA[".$row['SIZE']."]]></SIZE>";
					$ResponseXML .= "<RE_O_qty><![CDATA[".$row['RE_O_qty']."]]></RE_O_qty>";
					$ResponseXML .= "<RE_O_LEVEL><![CDATA[".$row['RE_O_LEVEL']."]]></RE_O_LEVEL>";
					$ResponseXML .= "<cus_ord><![CDATA[".$row['cus_ord']."]]></cus_ord>";
					$ResponseXML .= "<delivered><![CDATA[".$row['delivered']."]]></delivered>";
					$ResponseXML .= "<weight><![CDATA[".$row['weight']."]]></weight>";
					$ResponseXML .= "<unit><![CDATA[".$row['UNIT']."]]></unit>";
					$ResponseXML .= "<size><![CDATA[".$row['SIZE']."]]></size>";
					$ResponseXML .= "<active_t><![CDATA[".$row['active_t']."]]></active_t>";
					$ResponseXML .= "<active_t1><![CDATA[".$row['active_t1']."]]></active_t1>";
					$ResponseXML .= "<RE_O_LEVEL><![CDATA[".$row['RE_O_LEVEL']."]]></RE_O_LEVEL>";
					$ResponseXML .= "<RE_O_QTY><![CDATA[".$row['RE_O_QTY']."]]></RE_O_QTY>";
					$ResponseXML .= "<country><![CDATA[".$row['country']."]]></country>";
					$ResponseXML .= "<disitem><![CDATA[".$row['disitem']."]]></disitem>";
				}				
			
				
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
				
	
}	
?>
