<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////


if (isset($_POST["Command"])) {
	
	if ($_POST["Command"] == "save_item") {





		try {
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$conn->beginTransaction();


			$i = 1;

			$count = $_POST['count'];
			while ($_POST["count"] > $i) {	
				$stk_no = "stk_no" . $i;

				$price = "price" . $i;

				$sql = "update s_mas set selling ='" . $_POST[$price] . "' where stk_no ='" . $_POST[$stk_no] . "'";  	
				$conn->query($sql);	
				$i = $i+1;	
			}



			$conn->commit();
			echo "Saved";
		} catch (Exception $e) {
			$conn->rollBack();
			echo $e;
		}
	}
}

if($_GET["Command"]=="load_items")
{



	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";





	$ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
	<tr>
	<th style=\"width: 90px;\">Item Code</th>
	<th style=\"width: 250px;\">Description</th>
	<th style=\"width: 80px;\">Selling</th>

	</tr>";

	$i = 1;
	$sql = "Select * from s_mas where brand_name='" . $_GET['brand'] . "'";
	$result = $conn->query( $sql);
	foreach ($conn->query($sql) as $row) {
		
		$stk_no = "stk_no" .$i;
		$price = "price" . $i;
		
		$ResponseXML .= "<tr>                              
		<td><input class='input-sm form-control' disabled type='text' id='" . $stk_no . "' value='" . $row['STK_NO'] . "'></td>
		<td>" . $row['DESCRIPT'] . "</td>
		<td><input class='input-sm form-control' type='text'  id='" . $price . "' value='" . $row['SELLING'] . "'></td>

		</tr>";
		$i = $i + 1;
		
	}
	

	$ResponseXML .= "   </table>]]></sales_table>";



	$ResponseXML .= "<itm_count><![CDATA[" . $i . "]]></itm_count>";

	$ResponseXML .= " </salesdetails>";
	echo $ResponseXML;

}

?>