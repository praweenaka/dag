<?php
/* if($_SESSION["login"]!="True")
 {
 header('Location:./index.php');
 } */

/* if($_SESSION["login"]!="True")
 {
 header('Location:./index.php');
 } */

require_once ("connectioni.php");
 

?>

<script language="JavaScript" src="js/outstand.js"></script>
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
	function load_calader(tar) {
		new JsDatePick({
			useMode : 2,
			target : tar,
			dateFormat : "%Y-%m-%d"

		});

	}

</script>

</label>

<style type="text/css">
	<!--
	.style1 {font-weight: bold}
	-->
</style>
<fieldset>
	<legend>
		<div class="text_forheader">
			Quantity Sales Report
		</div>
	</legend>

	<form id="form1" name="form1" action="report_qty_sales.php" target="_blank" method="get">
		<table width="787" border="0">
			<tr>
				<td width="151" align="left">
				<input type="text"  class="label_purchase" value="Date" disabled="disabled"/>
				</td>
				<td width="169" align="left">
				<input type="text" size="20" name="DTfrom" id="DTfrom"  onfocus="load_calader('DTfrom');" class="text_purchase3" value="<?php echo date("Y-m-d"); ?>"/>
				</td>
				<td width="152" align="left">
				<input type="text"  class="label_purchase" value="To" disabled="disabled"/>
				</td>
				<td width="120">
				<input type="text" size="20" name="DTTO" id="DTTO" value="<?php echo date("Y-m-d") ?>" onfocus="load_calader('DTTO');" class="text_purchase4"/>
				</td>
				<td width="70">&nbsp;</td>
				<td></td>
			</tr>
			<tr>
				<td align="left">
				<input type="text"  class="label_purchase" value="Brand" disabled="disabled"/>
				</td>
				<td align="left">
				<select name="cmbbrand" id="cmbbrand" onkeypress="keyset('searchitem', event);" class="text_purchase3"  onchange="setord();">
					<option value="All">All</option>
					<?php
					
                                        if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
                                            $sql="select * from brand_mas where act ='1' and costcenter='".$_SESSION["CURRENT_DEP"]."' order by barnd_name"; 
                                        }else{
                                            $sql="select * from brand_mas where act ='1' order by barnd_name";
                                        } 
                                        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                                        while($row = mysqli_fetch_array($result)){
                                         echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
                                        }
					?>
				</select></td>
				<td align="left">
				<select name="cmbtype" id="cmbtype" class="text_purchase3" onchange="set_chk();">
					<option value="Detail">Detail</option>
					<option value="Summary">Summary</option>
				</select></td>
				<td colspan="2">
				<input type="text"  class="label_purchase" value="Dev" disabled="disabled"/>
				</td>
				<td>
				<select name="cmbdev" id="cmbdev" class="text_purchase3">
					<?php
					if ($_SESSION['dev'] == "1") {
						echo "<option value=\"All\">All</option>
					<option value=\"Manual\">Van Sale</option>
					<option value=\"Computer\">Office Sale</option>";
					} else {
						echo "<option value=\"Computer\">Office Sale</option>";
					}
					?>
				</select></td>
			</tr>
			<tr>
				<td align="left">
				<input type="checkbox" name="Chk_cus" id="Chk_cus" />
				Select</td>
				<td align="left">
				<input type="checkbox" name="Chk_cus_wise" id="Chk_cus_wise" />
				<label id="Chk_cus_wise_lbl"> Customer wise summery</label></td>
				<td align="left">
				<input type="checkbox" name="chk_over25" id="chk_over25" />
				<label id="chk_over25_lbl">Over 25 Tyres</label></td>
				<td colspan="2">
				<select name="cmb_t" id="cmb_t" class="text_purchase3">
					<option value="ALL">ALL</option>
					<option value="PCR">PCR</option>
					<option value="TBR">TBR</option>
					<option value="LTR">LTR</option>
					<option value="BIAS TYRES">BIAS TYRES</option>
					<option value="OTR">OTR</option>
					<option value="MC">MC</option>
					<option value="SUV">SUV</option>
				</select></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" align="left">
				<table width="274">
					<tr>
						<td width="76" align="left">
						<input type="text"  class="label_purchase" value="Customer" disabled/>
						</td>
						<td width="186">
						<input type="text" name="cuscode" id="cuscode" class="text_purchase3"/>
						</td>
					</tr>
				</table></td>
				<td colspan="3" align="left">
				<input type="text" name="cusname" id="cusname" class="text_purchase3"/>
				</a></td>
				<td width="99"><a href="serach_customer.php?stname=rep_outstand_state" onclick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
				return false" onfocus="this.blur()">
				<input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase1" />
				</a></td>
			</tr>
			<tr>
				<td colspan="3" align="left">
				<input type="text"  class="text_purchase3"  disabled="disabled" id="cus_address" name="cus_address" />
				</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
			</tr>
			<tr>
				<td align="left">
				<input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/>
				</td>
				<td align="left">
				<select name="cmbrep" id="cmbrep" onkeypress="keyset('dte_dor', event);" onchange="custno('cash_rec_rep');" class="text_purchase3">
            <?php
                if ($_SESSION["MANAGER"]!="") {
                   echo "<option value='All'>All</option>";			 						
                   $sql="select * from s_salrep where cancel='1' and manager='".$_SESSION["MANAGER"]."'order by REPCODE"; 
                   $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                   while($row = mysqli_fetch_array($result)){
                       echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                   }
                }else if ($_SESSION["CURRENT_REP"]=="") {
                     
                   echo "<option value='All'>All</option>";			 						
                   $sql="select * from s_salrep where cancel='1' order by REPCODE";
                   $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                   while($row = mysqli_fetch_array($result)){
                       echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                   }
		} else {
                    $sql="select * from s_salrep where cancel='1' and repcode = '" . $_SESSION["CURRENT_REP"] ."' order by REPCODE"; 
                    $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                    while($row = mysqli_fetch_array($result)){
                    echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                    }
                }
                ?>
				</select></td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
			</tr>

			<tr>
				<td colspan="3" align="left"><input type="checkbox" name="chk_o90" id="Chk_cus" /> Over <input type="text" name="txt_90" id="txt_90" /> </td>
				<td colspan="2" align="left"></td>
				<td align="left">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3" align="left">&nbsp;</td>
				<td colspan="2" align="left"></td>
				<td width="99" align="left">
				<input type="submit" name="button" id="button" value="View" class="btn_purchase2"/>
				</td>
			</tr>
			<tr>
				<td colspan="3" align="left"></td>
				<td colspan="2">&nbsp;</td>
			</tr>
		</table>
		<fieldset>

	</form>

