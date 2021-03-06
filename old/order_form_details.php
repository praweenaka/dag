<?php   
require_once ("connectioni.php");
$sql="delete from tmppurcon where user_nm = '" . $_SESSION["CURRENT_USER"] . "'";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
$_SESSION["insert"] = 0;
$_SESSION["update"] = 0;
?>

<link rel="stylesheet" href="css/table.css" type="text/css"/>
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript" language="javascript" src="js/get_cat_description.js"></script>
<script type="text/javascript" language="javascript" src="js/datepickr.js"></script>

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
			target : "dte_dor",
			dateFormat : "%Y-%m-%d"
			/*selectedDate:{				This is an example of what the full configuration offers.
			 day:5,						For full documentation about these settings please see the full version of the code.
			 month:9,
			 year:2006
			 },
			 yearsRange:[1978,2020],
			 limitToToday:false,
			 cellColorScheme:"beige",
			 dateFormat:"%m-%d-%Y",
			 imgPath:"img/",
			 weekStartDay:1*/
		});
	}; 
</script>

</label>

<fieldset>
	<legend>
		<div class="text_forheader">
			Order Details
		</div>
	</legend>

	<form name="form1" id="form1">
		<table border="0"  class=\"form-matrix-table\">

		<tr>
		<td height="41"></td>
		<td><input type="hidden"   value="01" id='department' name='department'/></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
		<td><select name="brand" id="brand" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="assignbrandsession();">
		<?php
		if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
                    $sql = "select * from brand_mas where act ='1' and costcenter='" . $_SESSION["CURRENT_DEP"] . "' order by barnd_name";
                } else {
                    $sql = "select * from brand_mas where act ='1' order by barnd_name";
                }
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='" . $row["barnd_name"] . "'>" . $row["barnd_name"] . "</option>";
                }
		?>
		</select></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		 
		</table>

		<br/>
		<fieldset>

		<legend><div class="text_forheader">Item Details</div></legend>

		<table width="84%" border="0">
		<tr>
		<td width="10%"><span class="style1">
		<input type="text"  class="label_purchase" value="Code" disabled/>
		</span></td>
		<td  width="40%"><span class="style1">
		<input type="text"  class="label_purchase" value="Description" disabled/>
		</span></td>
		<td  width="10%"><span class="style1">
		<input type="text"  class="label_purchase" value="Part No" disabled/>
		</span></td>
		 
		<td  width="10%">&nbsp;</td>
		</tr>
		<tr>
		<td><font color="#FFFFFF">
		<div id="test"><font color="#FFFFFF">
		<input type="text"  class="text_purchase3" name="itemd_hidden" id="itemd_hidden" size="10"  onkeypress="keyset('qty',event);"  onblur="itno_ind();"    />
		</font></div>  </font></td>
		<td><font color="#FFFFFF">
		<input type="text"  class="text_purchase6" size="40" id="itemd" name="itemd" disabled="disabled" onkeypress="keyset('rate',event);" />
		</font><a href="serach_item_ord.php" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"><input type="button" name="searchitem" id="searchitem" value="..." class="btn_purchase" ></a></td>
		<td><font color="#FFFFFF">
		<input type="text" size="15" name="partno" id="partno" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('qty',event);"/>
		</font></td>
		 
		<td><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onClick="add_tmp();" class="btn_purchase1"></td>
		</tr>
		<tr>
		<td colspan="4">
		<div class="CSSTableGenerator" id="itemdetails" >
		<table>
 
		
		
		
		</table>   </div>                                                 		</td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" rowspan="5"><div id="storgrid"></div></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		</table>

	</form>

</fieldset>

<table width="765" border="0" cellpadding="0">
	<tr>
		<th height="189" colspan="5" align="left" nowrap="nowrap"><div align="left">
