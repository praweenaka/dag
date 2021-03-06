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

</label>

<style type="text/css">
	<!--
	.style1 {font-weight: bold}
	-->
</style>
<fieldset>
	<legend>
		<div class="text_forheader">
			Outstanding Invoice Report
		</div>
	</legend>

	<form id="form1" name="form1" action="report_outstanding.php" target="_blank" method="get">
		<table width="767" border="0">
			<tr>
				<td colspan="2" align="left">&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="2">
				<script type="text/javascript">
					window.onload = function() {
						new JsDatePick({
							useMode : 2,
							target : "dtddate",
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
				</script></td>
			</tr>
			<tr>
				<td width="422" align="left">
				<table width="274">
					<tr>
						<td width="76" align="left">
						<input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/>
						</td>
						<td width="186">
						<select name="cmbrep" id="cmbrep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">

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
                                                         echo $sql;
                                                         $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                                                         while($row = mysqli_fetch_array($result)){
                                                         echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                                                         }
                                                     }
							?>
						</select></td>
					</tr>
				</table></td>
				<td width="210" align="left">
				<input type="text"  class="label_purchase" value="Brand" disabled="disabled"/>
				</td>
				<td width="160">
				<select name="cmbbrand" id="cmbbrand" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="setord();">
					<option value='All'>All</option>
					<?php
                                        if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
                                            $sql="select * from brand_mas where act ='1' and costcenter='".$_SESSION["CURRENT_DEP"]."' order by barnd_name"; 
                                        }else{
                                            $sql="select * from brand_mas where act ='1' order by barnd_name";
                                        }  
					$result = mysqli_query($GLOBALS['dbinv'], $sql);
					while ($row = mysqli_fetch_array($result)) {
						echo "<option value='" . $row["barnd_name"] . "'>" . $row["barnd_name"] . "</option>";
					}
					?>
				</select></td>
				<td width="198">
				<select name="cmbdev" id="cmbdev" class="text_purchase3">

					<?php
					if ($_SESSION['dev'] == "1") {
						echo "<option value=\"All\">All</option>
					<option value=\"Manual\">Van Sale</option>
					<option value=\"Computer\">Office Sale</option>";
					} else if ($_SESSION['dev'] == "0") {
						echo "<option value=\"Computer\">Office Sale</option>";
					}
					?>
				</select></td>
				<td width="399">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="5" align="left">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3" align="left">
				<table width="500" border="0">
					<tr>
						<th width="403" scope="col">
						<table width="400" border="0">
							<tr>
								<th scope="col">
								<input type="radio" name="radio" id="optinv" value="optinv" checked="checked" />
								Invoice wise</th>
								<th scope="col">
								<input type="radio" name="radio" id="optcus" value="optcus" />
								Customer wise</th>
							</tr>
							<tr>
								<td>
								<input type="checkbox" name="chkrefno" id="chkrefno" />
								Reference No </td>
								<td>
								<input type="radio" name="radio" id="optscrap" value="optscrap" />
								Scrap Inv</td>
							</tr>
						</table></th>
						<th width="87" scope="col">
						<table width="300" border="0">
							<tr>
								<th scope="col">&nbsp;</th>
								<th scope="col">&nbsp;</th>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table></th>
					</tr>
				</table></td>
				<td colspan="2" align="left">
				<table width="100" border="0">
					<tr>
						<th scope="col">&nbsp;</th>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
			</tr>
			<tr>
				<td colspan="5" align="left">
				<fieldset>
					<table width="821" border="0">
						<tr>
							<th width="147" scope="col">
							<input type="radio" name="radio2" id="optcur" value="optcur" checked="checked" />
							Current</th>
							<th width="59" scope="col">&nbsp;</th>
							<th width="84" scope="col">&nbsp;</th>
							<th width="144" scope="col">
							<input type="text"  class="label_purchase" value="Days Over" disabled="disabled"/>
							</th>
							<th width="162" scope="col">
							<input type="text" name="txtdays" id="txtdays" value="0" class="text_purchase3"/>
							</th>
							<th colspan="2" scope="col">&nbsp;</th>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2">
							<input type="checkbox" name="chkpe" id="chkpe" />
							Period</td>
							<td>
							<input type="text"  class="label_purchase" value="Days Over" disabled="disabled"/>
							</td>
							<td>
							<input type="text" name="txtover" id="txtover" value="0" class="text_purchase3"/>
							</td>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
							<input type="text"  class="label_purchase" value="Days Below" disabled="disabled"/>
							</td>
							<td>
							<input type="text" name="txtdb" id="txtdb" value="0" class="text_purchase3"/>
							</td>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td>
							<input type="radio" name="radio2" id="optdate" value="optdate"  />
							For Given Date</td>
							<td colspan="2">
							<input type="text" name="dtdate" id="dtdate" class="text_purchase3" value="<?php echo date("Y-m-d"); ?>"/>
							<script type="text/javascript">
								window.onload = function() {
									new JsDatePick({
										useMode : 2,
										target : "dtdate",
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
							</script></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td width="109">&nbsp;</td>
							<td width="86">&nbsp;</td>
						</tr>
					</table>
				</fieldset></td>
			</tr>
			<tr>
				<td colspan="2" align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td colspan="2" align="left">&nbsp;</td>
			</tr>
			<tr>
				<td width="422" colspan="2" align="left">&nbsp;</td>
				<td width="160" align="left"></td>
				<td width="399" colspan="2" align="left">&nbsp;</td>
			</tr>
			<tr>
				<td width="422" colspan="2" align="left"></td>
				<td>
				<input type="submit" name="button" id="button" value="View" class="btn_purchase1"/>
				</td>
			</tr>
		</table>

	</form>

