<?php session_start();

date_default_timezone_set('Asia/Colombo');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="admin_min.css" rel="stylesheet" type="text/css" media="screen" />

		<title>Search Orders</title>
                <link rel="stylesheet" href="css/bootstrap.css" type="text/css"/>
                <script language="JavaScript" src="js/sales_inv.js"></script>
                
	</head>

	<body>

		<table width="810" border="0" class=\"table\">

		<tr>
		<td  background="" ><input type="radio" name="radio" id="Option5" value="Option5" checked="checked" onclick="update_list('$stname');" />
		Approved Orders</td>

		<td  background="" ><input type="radio" name="radio" id="Option1" value="Option1"  onclick="update_list('$stname');" />
		All not Invoiced Orders</td>
		<td background="" ><input type="radio" name="radio" id="Option2" value="Option2" onclick="update_list('$stname');"/>
		To MM</td>
		<td  background="" ><input type="radio" name="radio" id="Option3" value="Option3" onclick="update_list('$stname');"/>
		To WD</td>
		<td  background="" ><input type="radio" name="radio" id="Option4" value="Option4" onclick="update_list('$stname');"/>
		Approved and  Invoiced</td>
		</tr>
		</table>
		<table width="810" border="0" class=\"table\">
		<tr>
		<?php
		$stname = $_GET["stname"];
		$_SESSION["stname"] = $stname;
		?>
		<td width="140"  background="" ><input type="text" size="20" name="invno" id="invno" value="" class="txtbox"  onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
		<td  background="" ><input type="text" size="50" name="customername" id="customername" value="" class="txtbox" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
		<td width="215"  background="" ><input type="text" size="29" name="invdate" id="invdate" value="" class="txtbox" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
		</tr>  </table>
		<div id="filt_table" class="CSSTableGenerator">  <table width="800" border="0" class="table-bordered">
		 <tr>
<th width=\"121\">Order No</th>
<th width=\"200\" >Customer</th>
<th width=\"100\" >Order Date</th>
<th width=\"100\" >Grand Total</th>
<th width=\"100\" >Status</th>
<th width=\"50\" >Rep</th>
<th width=\"50\" >Approve By</th>
<th width=\"70\" ></th>
</tr>
		<?php

		require_once ("connectioni.php");

		//if ($_GET["stname"]=="ord"){
		//	$sql="SELECT * FROM s_cusordmas where CANCELL='0' order by SDATE desc limit 50";
		//} else {
		$sql = "SELECT REF_NO,CUS_NAME,SDATE,GRAND_TOT,Result,SAL_EX,Brand,Forward,id FROM s_cusordmas where INVNO='0' and CANCELL='0' and result = 'OK' order by id asc limit 50";
		//}

		$result = mysqli_query($GLOBALS['dbinv'], $sql);
		while ($row = mysqli_fetch_array($result)) {
			$ref_no = $row['REF_NO'];
			echo "
		<tr>
			<td onclick=\"invno('" . $ref_no . "', '" . $stname . "');\">" . $row['REF_NO'] . "</a></td>
			<td onclick=\"invno('" . $ref_no . "', '" . $stname . "');\">" . $row['CUS_NAME'] . "</a></td>
			<td onclick=\"invno('" . $ref_no . "', '" . $stname . "');\">" . $row['SDATE'] . "</a></td>
			<td onclick=\"invno('" . $ref_no . "', '" . $stname . "');\">" . $row['GRAND_TOT'] . "</a></td>
			<td onclick=\"invno('" . $ref_no . "', '" . $stname . "');\">" . $row['Result'] . "</a></td>
			<td onclick=\"invno('" . $ref_no . "', '" . $stname . "');\">" . $row['SAL_EX'] . "</a></td>
			<td onclick=\"invno('" . $ref_no . "', '" . $stname . "');\">" . $row['Brand'] . "</a></td>
			<td onclick=\"invno('" . $ref_no . "', '" . $stname . "');\">" . $row['Forward'] . "</a></td> 
			</tr>";
		}
		mysqli_close($GLOBALS['dbinv']);
			?> </table>
			</div>
	</body>
</html>
