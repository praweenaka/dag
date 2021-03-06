<?php session_start();

date_default_timezone_set('Asia/Colombo');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="admin_min.css" rel="stylesheet" type="text/css" media="screen" />

		<title>Search Customer</title>
		<link rel="stylesheet" href="css/table_min.css" type="text/css"/>
		<script language="JavaScript" src="js/ord.js"></script>
		<style type="text/css">
			/* START CSS NEEDED ONLY IN DEMO */
			html {
				height: 100%;
			}

			#mainContainer {
				width: 700px;
				margin: 0 auto;
				text-align: left;
				height: 100%;
				background-color: #FFF;
				border-left: 3px double #000;
				border-right: 3px double #000;
			}
			#formContent {
				padding: 5px;
			}
			/* END CSS ONLY NEEDED IN DEMO */

			/* Big box with list of options */
			#ajax_listOfOptions {
				position: absolute;	/* Never change this one */
				width: 175px;	/* Width of box */
				height: 250px;	/* Height of box */
				overflow: auto;	/* Scrolling features */
				border: 1px solid #317082;	/* Dark green border */
				background-color: #FFF;	/* White background color */
				text-align: left;
				font-size: 0.9em;
				z-index: 100;
			}
			#ajax_listOfOptions div {/* General rule for both .optionDiv and .optionDivSelected */
				margin: 1px;
				padding: 1px;
				cursor: pointer;
				font-size: 0.9em;
			}
			#ajax_listOfOptions .optionDiv {/* Div for each item in list */

			}
			#ajax_listOfOptions .optionDivSelected {/* Selected item in the list */
				background-color: #317082;
				color: #FFF;
			}
			#ajax_listOfOptions_iframe {
				background-color: #F00;
				position: absolute;
				z-index: 5;
			}

			form {
				display: inline;
			}

			#article {
				font: 12pt Verdana, geneva, arial, sans-serif;
				background: white;
				color: black;
				padding: 10pt 15pt 0 5pt
			}
		</style>

	</head>

	<body>

		<table width="810" border="0" class=\"form-matrix-table\">

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
		<table width="810" border="0" class=\"form-matrix-table\">
		<tr>
		<?php
		$stname = $_GET["stname"];
		$_SESSION["stname"] = $stname;
		?>
		<td width="140"  background="" ><input type="text" size="20" name="invno" id="invno" value="" class="txtbox"  onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
		<td colspan="2"  background="" ><input type="text" size="70" name="customername" id="customername" value="" class="txtbox" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
		<td width="215"  background="" ><input type="text" size="29" name="invdate" id="invdate" value="" class="txtbox" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
		</tr>  </table>
		<div id="filt_table" class="CSSTableGenerator">  <table width="735" border="0" class=\"form-matrix-table\">
		 
		
		
		 
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" >Order No</td>
                              <td width=\"171\"  background=\"images/headingbg.gif\">Customer</td>
                             <td width=\"70\"  background=\"images/headingbg.gif\">Order Date</font></td>
							 <td width=\"100\"  background=\"images/headingbg.gif\">Grand Total</font></td>
							 
							 <td width=\"100\"  background=\"images/headingbg.gif\">Status</font></td>
							 <td width=\"100\"  background=\"images/headingbg.gif\">Rep</font></td>
							 <td width=\"100\"  background=\"images/headingbg.gif\">Approve By</font></td>
							 <td width=\"70\"  background=\"images/headingbg.gif\"></td>
   							</tr>
		<?php

		require_once ("connectioni.php");

		//if ($_GET["stname"]=="ord"){
		//	$sql="SELECT * FROM s_cusordmas where CANCELL='0' order by SDATE desc limit 50";
		//} else {
		$sql = "SELECT REF_NO,CUS_NAME,SDATE,GRAND_TOT,Result,SAL_EX,approveby,Forward FROM s_cusordmas where INVNO='0' and CANCELL='0' and result = 'OK' order by id asc limit 50";
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
			<td onclick=\"invno('" . $ref_no . "', '" . $stname . "');\">" . $row['approveby'] . "</a></td>
			<td onclick=\"invno('" . $ref_no . "', '" . $stname . "');\">" . $row['Forward'] . "</a></td> 
			</tr>";
		}
		mysqli_close($GLOBALS['dbinv']);
			?> </table>
			</div>
	</body>
</html>
