
<?php
/* if($_SESSION["login"]!="True")
  {
  header('Location:./index.php');
  } */




/* if($_SESSION["login"]!="True")
  {
  header('Location:./index.php');
  } */




require_once("connectioni.php");
?>	






<link rel="stylesheet" href="css/table.css" type="text/css"/>	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript" language="javascript" src="js/get_cat_description.js"></script>
<script type="text/javascript" language="javascript" src="js/datepickr.js"></script>

<script type="text/javascript" language="javascript" src="js/sel_item.js"></script>
 
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
    function openWin()
    {
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

</label>

<fieldset>
    <legend>
        <div class="text_forheader">Target Details</div>
    </legend>             

    <form name="form1" id="form1">            
        <table width="100%" border="0"  class=\"form-matrix-table\">
            <tr>
                <td width="10%"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
                <td width="10%"><select name="Com_rep" id="Com_rep" onblur="new_inv();" onchange="new_inv();" class="text_purchase3">
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
                    </select></td>
                <td width="10%"> <a href="search_grn.php?stname=grn" onClick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
            return false" onFocus="this.blur()"></a></td>
                <td width="10%">&nbsp;</td>
                <td width="10%">&nbsp;</td>
                <td width="10%"><a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');return false" onfocus="this.blur()">

                    </a></td>
                <td width="10%">&nbsp;</td>
                <td width="10%">&nbsp;</td>
                <td width="10%">&nbsp;</td>
            </tr>
            <tr>
                <td><input type="text"  class="label_purchase" value="Ref No" disabled="disabled"/></td>
                <td><input type="text" disabled="disabled" name="txtref" id="txtref" value="" class="text_purchase3" onkeypress="keyset('searchcust', event);" onfocus="got_focus('grnno');"  onblur="lost_focus('grnno');"  /></td>
                <td>
                    <input type="button" name="searchinv" onclick="loadwindow();" id="searchinv" value="..." class="btn_purchase1" />
                </td>
                <td>&nbsp;</td>
                <td><input type="text"  class="label_purchase" value="Report Date From" disabled="disabled"/></td>
                <td><input type="text" size="20" name="dtfr" id="dtfr" value="<?php echo date("Y-m-d"); ?>"   onfocus="load_calader('dtfr')" class="text_purchase3"/></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td><input type="text"  class="label_purchase" value="Date From" disabled="disabled"/></td>
                <td><input type="text" size="20" name="dtfrom" id="dtfrom" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtfrom')" class="text_purchase3"/></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="text"  class="label_purchase" value="Report Date To" disabled="disabled"/></td>
                <td><input type="text" size="20" name="dtto" id="dtto" value="<?php echo date("Y-m-d"); ?>"  onfocus="load_calader('dtto')" class="text_purchase3"/></td>
                <td><input type="button" name="searchinv2" onclick="print_inv_new();" id="searchinv2" value="View" class="btn_purchase1" /></td>
                <td></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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
                    <td  width="10%"><span class="style1">
                            <input type="text"  class="label_purchase" value="Date" disabled="disabled"/>
                        </span></td>
                    <td  width="10%"><span class="style1">
                            <input type="text"  class="label_purchase" value="Cus.Code" disabled/>
                        </span></td>
                    <td  width="40%"><span class="style1">
                            <input type="text"  class="label_purchase" value="Cus. Name" disabled/>
                        </span></td>
                    <td  width="10%"><span class="style1">
                            <input type="text"  class="label_purchase" value="Target" disabled/>
                        </span></td>
                    <td  width="10%"><span class="style1">
                            <input type="text"  class="label_purchase" value="Remark" disabled="disabled"/>
                        </span></td>

                    <td  width="10%">&nbsp;</td>
                </tr>
                <tr>
                    <td><input type="text" size="20" name="tar_date" id="tar_date" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('tar_date')" class="text_purchase3"/></td>
                    <td><font color="#FFFFFF">
                        <input type="text"  class="text_purchase2" size="15" id="cuscode" name="cuscode" onblur="custno_ind('rep_outstand_state');" onkeypress="keyset('rate', event);" />
                        </font> <a href="" onClick="NewWindow('serach_customer.php?stname=weekly_tar', 'mywin', '800', '700', 'yes', 'center');
            return false" onFocus="this.blur()"><input type="button" name="searchitem" id="searchitem" value="..." class="btn_purchase" ></a></td>
                    <td><font color="#FFFFFF">
                        <input type="text" size="40" name="cusname" id="cusname" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('qty', event);"/>
                        </font></td>
                    <td><font color="#FFFFFF">
                        <input type="text" size="15" name="target" id="target" value="" class="text_purchase3" onkeypress="keyset('remark', event);"/>
                        </font></td>
                    <td><font color="#FFFFFF">
                        <input type="text" size="15" name="remark" id="remark" value=""  class="text_purchase3" onkeypress="keyset('additem_tmp', event);"/><input type="hidden" size="15" name="discount" id="discount" value=""  class="txtbox" />
                        </font></td>
                    <td><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onclick="add_tmp();" class="btn_purchase1" /></td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div class="CSSTableGenerator" id="itemdetails" >
                            <table>
                                <tr>

                                    <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Cus.Code</font></td>
                                    <td width="30%"  background="images/headingbg.gif"><font color="#FFFFFF">Cus. Name</font></td>
                                    <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Target</font></td>

                                    <td width="20%"  background="images/headingbg.gif"><font color="#FFFFFF">Remark</font></td>
                                </tr>
                            </table>   </div>                                                 		</td>
                </tr>


                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>


    </form>        

</fieldset>    

<table width="765" border="0" cellpadding="0">
    <tr>
        <th height="189" colspan="5" align="left" nowrap="nowrap">
            <div align="left">