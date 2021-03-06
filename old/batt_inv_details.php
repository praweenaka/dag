<?php
require_once ("connectioni.php");
?>

<link rel="stylesheet" href="css/table_min.css" type="text/css"/>

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
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	function openWin() {
		myWindow = window.open('serach_inv.php', '', 'width=200,height=100');
		myWindow.focus();

	}
</script>

<script type="text/javascript">
    function load_calader(tar) {
        new JsDatePick({
            useMode: 2,
            target: tar,
            dateFormat: "%Y-%m-%d"

        });

    }

</script>

<script type="text/javascript">
	window.onload = function() {
		new JsDatePick({
			useMode : 2,
			target : "dte_shedule",
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
			Inventry
		</div>
	</legend>

	<form name="form1" id="form1">
		<table width="100%" border="0"  class=\"form-matrix-table\">

		<tr>

		<td width="120" align="left"><input type="text" disabled="" value="Customer" class="label_purchase"></td>
		<td width="100"><input type="text" onchange="view_his();" onblur="view_his();" class="text_purchase3" id="cuscode" name="cuscode"></td>

		<td width="245"><a onfocus="this.blur()" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" href=""><input type="text" class="text_purchase3" id="cusname" name="cusname">

		</a></td>
		<td width="100"><a onfocus="this.blur()" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" href="serach_customer.php?stname=rep_outstand_state">
		<input type="button" class="btn_purchase1" value="..." id="searchcust" name="searchcust">
		</a></td>

		<td width="100"><input type="text"   class="label_purchase" value="Date" disabled="disabled"/></td>
		<td width="14%"><input type="text"  name="invdate" id="invdate" value="<?php echo date("Y-m-d"); ?>"  onfocus="load_calader('invdate');" class="text_purchase3"/></td>
		</tr>

		<input type="hidden" disabled="disabled" name="cmdsave" id="cmdsave" value="1" class="text_purchase" onkeypress="keyset('searchcust',event);"   />

		<input type="hidden" disabled="disabled" name="cus_address" id="cus_address" class="text_purchase"  />

		<tr>
		<td><input type="text" disabled="disabled" value="Marketing Executive" class="label_purchase"></td>
		<td>
		<select name="cmbrep" id="cmbrep" onkeypress="keyset('dte_dor',event);" onblur="view_his();" onchange="view_his();" class="text_purchase3">

            <?php
                					require_once("connectioni.php");
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
		</select>

		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		</table>

		<br/>
		<fieldset>

		<legend><div class="text_forheader">Item Details</div></legend>

		<table>
		<tr>
		<td align="right">&nbsp;</td>
		<td colspan="3">
		<input type="text" disabled="disabled" value="Stk No" class="label_purchase">
		</td>
		<td colspan="2">
		<input type="text" disabled="disabled" value="Description" class="label_purchase">
		</td>
		<td>
		<input type="text" disabled="disabled" value="Brand" class="label_purchase">
		</td>
		<td>
		<input type="text" disabled="disabled" value="Pattern" class="label_purchase">
		</td>

		<td colspan="2">
		<input type="text"   value="Qty" class="label_purchase">
		</td>

		<td width="100">&nbsp;</td>
		<td>&nbsp;</td>
		</tr>

		<tr>
		<td align="right"><a onfocus="this.blur()" onclick="NewWindow('serach_item_claim.php?stname=claim_item','mywin','800','700','yes','center');return false" href="">
		<input type="button" class="btn_purchase1" value="..." id="searchcust2" name="searchcust2">
		</a></td>
		<td colspan="3">
		<input type="text" class="text_purchase3" onkeypress="keyset('vat2',event);" value="" disabled="disabled" id="txtstk_no" name="txtstk_no" size="20">
		</td>
		<td colspan="2">
		<input type="text" class="text_purchase3" onkeypress="keyset('salesrep',event);" value="" disabled="disabled" id="txtdes" name="txtdes" size="20">
		</td>
		<td>
		<input type="text" class="text_purchase3" onkeypress="keyset('vat2',event);" value="" disabled="disabled" id="txtbrand" name="txtbrand" size="20">
		</td>
		<td><label>
			<input type="text" class="text_purchase3" onkeypress="keyset('vat2',event);" value="" disabled="disabled" id="txtpatt" name="txtpatt" size="20">
		</label></td>
		<td colspan="2">
		<input type="text" class="text_purchase3" onkeypress="keyset('vat2',event);" value="" id="txtqty" name="txtqty" size="20">
		<label></label><label></label></td>
		<td width="150">
		<a onclick="save_me();"  value="Save" class="btn_purchase1">Save</a>
		</td>
		<td>&nbsp;</td>
		</tr>

		</table>

		<table width="84%" border="0">

			<tr>
				<td colspan="5"><div id="itemdetails1" class="CSSTableGenerator">

				</div></td>

			</tr>

		</table>
		<input type="hidden" size="15" name="stklevel" id="stklevel" value="" class="text_purchase3" disabled="disabled" />

                
                
                
                
                
	</form>

    <table>
        
        <tr>
        <td width="16%" colspan="2">
      </td>
        <td width="11%" colspan="4">
         <fieldset> <legend>Periodic Report</legend> 
        <table border="0" width="583">
          <tbody><tr>
            <th width="144" scope="col"><input type="text" disabled="disabled" value="Date from" class="label_purchase"></th>
            <th width="120" scope="col"><input type="text" class="text_purchase3" onfocus="load_calader('dtfrom')" id="dtfrom" name="dtfrom" size="20"></th>
            <th width="144" scope="col"><input type="text" disabled="disabled" value="Date from" class="label_purchase"></th>
            <th width="157" scope="col"><input type="text" class="text_purchase3" onfocus="load_calader('dtto')" id="dtto" name="dtto" size="20"></th>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td><a class="btn_purchase2" onclick="getrep();"  id="com_View_repo" name="com_View_repo">
            View</a></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
        </tbody></table>
       </fieldset>        </td>
      </tr>
        
        
		
		 <tr>
        <td width="16%" colspan="2">
      </td>
        <td width="11%" >
         <fieldset> <legend>Dealer Total</legend> 
        <table border="0" >
          <tbody> 
          <tr>
             
            <td><a class="btn_purchase2" onclick="getrep1();"  id="com_View_repo" name="com_View_repo">
            View</a></td>
             
			 <td><a class="btn_purchase2" href="report_scan_details.php" target="_blank" id="com_View_repo" name="com_View_repo">
            View Scaned</a></td> 
			 
          </tr>
        </tbody></table>
       </fieldset>        </td>
      </tr>
		
		
		
		
		
		
		
		
		
    </table>
