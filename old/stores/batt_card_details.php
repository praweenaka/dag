<?php
/*if($_SESSION["login"]!="True")
 {
 header('Location:./index.php');
 }*/

/*if($_SESSION["login"]!="True")
 {
 header('Location:./index.php');
 }*/

require_once ("connectioni.php");
?>

<script language="JavaScript" src="js/batt_card.js"></script>
<link rel="stylesheet" href="css/table.css" type="text/css"/>
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript" language="javascript" src="js/get_cat_description.js"></script>
<script type="text/javascript" language="javascript" src="js/datepickr.js"></script>

<script language="javascript" src="cal2.js">
	/*
	 Xin's Popup calendar script-  Xin Yang (http://www.yxscripts.com/)
	 Script featured on/available at http://www.dynamicdrive.com/
	 This notice must stay intact for use
	 */
</script>
<script language="javascript" src="cal_conf2.js"></script>
<script language="javascript" type="text/javascript">
	<!--
	/****************************************************
	 Author: Eric King
	 Url: http://redrival.com/eak/index.shtml
	 This script is free to use as long as this info is left in
	 Featured on Dynamic Drive script library (http://www.dynamicdrive.com)
	 ****************************************************/
	var win = null;
	function NewWindow(mypage, myname, w, h, scroll, pos) {
		if (pos == "random") {
			LeftPosition = (screen.width) ? Math.floor(Math.random() * (screen.width - w)) : 100;
			TopPosition = (screen.height) ? Math.floor(Math.random() * ((screen.height - h) - 75)) : 100;
		}
		if (pos == "center") {
			LeftPosition = (screen.width) ? (screen.width - w) / 2 : 100;
			TopPosition = (screen.height) ? (screen.height - h) / 2 : 100;
		} else if ((pos != "center" && pos != "random") || pos == null) {
			LeftPosition = 0;
			TopPosition = 20
		}
		settings = 'width=' + w + ',height=' + h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
		win = window.open(mypage, myname, settings);
	}

	// -->
</script>

<script type="text/javascript">
	function openWin() {
		myWindow = window.open('serach_inv.php', '', 'width=200,height=100');
		myWindow.focus();

	}
</script>

<script type="text/javascript">
	window.onload = function() {
		new JsDatePick({
			useMode : 2,
			target : "dte_shedule",
			dateFormat : "%Y-%m-%d"

		});
	}; 
</script>

<script type="text/javascript">
	function load_calader(tar) {
		new JsDatePick({
			useMode : 2,
			target : tar,
			dateFormat : "%Y-%m-%d"

		});

	}

</script>
<!-- Dynamic List area -->

<script type="text/javascript" src="ajax-dynamic-list.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="ajax.js"></script>

<style type="text/css">
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
	.style1 {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
		font-weight: bold;
	}

	.btn_add_privilleges {
		height: 25px;
		font-family: "Trebuchet MS";
		color: #FFF;
		font-size: 12px;
		background: url(images/redBtn.png) repeat;
		width: 70%;
		padding: 2px 10px;
		border: 1px solid #000;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		-ms-box-sizing: border-box;
		box-sizing: border-box;
		-moz-box-shadow: 0 5px 0 #363B3E;
		-webkit-box-shadow: 0 5px 0 #363B3E;
		-moz-border-radius: 4px;
		-webkit-border-radius: 4px;
		border-radius: 4px;
	}
</style>

<!-- End of Dynamic list area -->
</label>

<style type="text/css">
	<!--
	.style1 {font-weight: bold}
	-->
</style>
<fieldset>
	<legend>
		<div class="text_forheader">
			Card Details
		</div>
	</legend>

	<form name="form1" id="form1">
		<table  border="0"  class=\"form-matrix-table\">
                    <!-- MAR 13 2015 -->
                    <input type="hidden" id="chkcus" name="chkcus">            
		<tr>
		<td  align="left"><input type="text" disabled="" value="Customer" class="label_purchase"></td>
		<td ><input type="text" class="text_purchase3" id="cuscode" name="cuscode"></td>

		<td colspan='2'><a onfocus="this.blur()" onclick="NewWindow('serach_customer.php?stname=rep_outstand_state','mywin','800','700','yes','center');return false" href=""><input type="text" class="text_purchase3" id="cusname" name="cusname">

		</a></td>
		<td ><a onfocus="this.blur()" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" href="serach_customer.php?stname=rep_outstand_state">
		<input type="button" class="btn_purchase1" value="..." id="searchcust" name="searchcust">
		</a></td>
		</tr>
		<tr>
		<td><input type="text"  class="label_purchase" value="Address" disabled="disabled"/></td>
		<td colspan='3'><input name="cus_address" id="cus_address"  class="text_purchase3" type='text'></td>

		</tr>

		<tr>
		<td><input type="text"  class="label_purchase" value="Address 2" disabled="disabled"/></td>
		<td colspan='3'><input name="cus_address1" id="cus_address1"  class="text_purchase3" type='text'></td>

		</tr>

		<tr>
		<td><input type="text"  class="label_purchase" value="Invoice No" disabled="disabled"/></td>
		<td><input name="inv_no" id="inv_no"  class="text_purchase3" type='text'></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>

		<tr>
		<td><input type="text"  class="label_purchase" value="Invoice Date" disabled="disabled"/></td>
		<td><input name="inv_dt" id="inv_dt" onfocus="load_calader('inv_dt');"   class="text_purchase3" type='text'></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>

		<tr>
		<td align="right">&nbsp;</td>
		<td><input type="text" disabled="disabled" value="Stk No" class="label_purchase"></td>
		<td colspan="-2"><input type="text" disabled="disabled" value="Description" class="label_purchase"></td>
		<td><input type="text" disabled="disabled" value="Brand" class="label_purchase"></td>
		<td><input type="text" disabled="disabled" value="Batch No" class="label_purchase"></td>
		<td colspan="2"><input type="text" disabled="disabled" value="Battery Serial No" class="label_purchase"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>

		<tr>
		<td align="right"><a onfocus="this.blur()" onclick="NewWindow('../serach_item_claim.php?stname=claim_item','mywin','800','700','yes','center');return false" href="">
		<input type="button" class="btn_purchase1" value="..." id="searchcust2" name="searchcust2">
		</a></td>
		<td><input type="text" class="text_purchase3" onkeypress="keyset('vat2',event);" value="" disabled="disabled" id="txtstk_no" name="txtstk_no" size="20"></td>
		<td colspan="-2">
		<input type="text" class="text_purchase3" onkeypress="keyset('salesrep',event);" value="" disabled="disabled" id="txtdes" name="txtdes" size="20">
		</td>
		<td>
		<input type="text" class="text_purchase3" onkeypress="keyset('vat2',event);" value="" disabled="disabled" id="txtbrand" name="txtbrand" size="20">
		</td>
		<td><label>
		<input type="text" class="text_purchase3" onkeypress="keyset('vat2',event);" value="" disabled="disabled" id="txtpatt" name="txtpatt" size="20">
		</label></td>
		<td colspan="2">
		<input type="text" class="text_purchase3" onkeypress="keyset('vat2',event);" value="" id="txtseri_no" name="txtseri_no" size="20">
		<label></label><label></label></td>
		<td><label></label></td>
		<td><a onfocus="this.blur()" onclick="NewWindow('serach_serial_item.php','mywin','800','700','yes','center');return false" href="">
		<input type="button" class="btn_purchase1" value="..." id="searchcust3" name="searchcust3">
		</a</td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</form>
	<form id="3" name="3" method="GET" action="rep_batt.php" target="_blank">

		<tr>
			<td>
			<input type="text"  class="label_purchase" value="From"/>
			</td>
			<td>
			<input type='text' id="dtfrom" name="dtfrom" onfocus="load_calader('dtfrom');" value="<?php echo date('Y-m-d'); ?>"/>
			</td>
			<td>
			<input type="text"  class="label_purchase" value="To"/>
			</td>
			<td>
			<input type='text' id="dtto" name="dtto" onfocus="load_calader('dtto');" value="<?php echo date('Y-m-d'); ?>"/>
			</td>
		</tr>

		<tr>
			<td>
			<input type="radio" id="user" checked="true" name="rtype">
			User Count</td>
			<td>
			<input type="radio" id="entd" name="entd">
			Entry Date</td>
			<td>
			<input type="radio" id="invd" name="invd">
			Invoice Date</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
			<input type="submit" class="btn_purchase1" value="Print" id="searchcust3" name="searchcust">
			</td>
			<td></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</form>
	</table>

