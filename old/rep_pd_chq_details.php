<?php
require_once("connectioni.php");
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
        }
        else if ((pos != "center" && pos != "random") || pos == null) {
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
<script type="text/javascript">
                    window.onload = function () {
                        new JsDatePick({
                            useMode: 2,
                            target: "dtddate",
                            dateFormat: "%Y-%m-%d"
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

<style type="text/css">
    <!--
    .style1 {font-weight: bold}
    -->
</style>
<fieldset>
    <legend>
        <div class="text_forheader">Pending Cheque</div>
    </legend>             

    <form id="form1" name="form1" action="report_pg_chq.php" target="_blank" method="get">
        <table width="994" border="0">
            <tr>
                <td width="144" align="left"><input type="checkbox" name="Check1" id="Check1" /> 
                    Customer</td>
                <td width="160" align="left"><input type="radio" name="radio" id="Option1" value="Option1" checked="checked" />
                    Option 1</td>
                <td width="121" align="left"><input type="radio" name="radio" id="Option2" value="Option2" /> 
                    Option 2</td>
                <td width="144"><input type="checkbox" name="CHK_RTN" id="CHK_RTN" /> 
                    Return PD Only</td>
                <td width="128" colspan=2><input type="radio" name="radio" id="Option3" value="Option3" /> 
                    Receipt Recon.     <input type="checkbox" name="CHK_CHNO" id="CHK_CHNO" /> 
                    With AC Code</td>
                  <td width="160" align="left"><input type="radio" name="radio" id="Option4" value="Option4"   />
                    New Modification</td>
            </tr>


            <tr>
                <td colspan="2" align="left"><table width="274">
                        <tr>
                            <td width="76" align="left"><input type="text"  class="label_purchase" value="Customer" disabled/></td>
                            <td width="186"><input type="text" name="cuscode" id="cuscode" class="text_purchase3"/></td>
                        </tr>
                    </table></td>
                <td colspan="3" align="left"><a href="" onclick="NewWindow('serach_customer.php', 'mywin', '800', '700', 'yes', 'center');
                        return false" onfocus="this.blur()"><input type="text" name="cusname" id="cusname" class="text_purchase3"/>

                    </a></td>
                <td width="91"><a href="serach_customer.php?stname=rep_outstand_state" onclick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
                        return false" onfocus="this.blur()">
                        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase2" />
                    </a></td>
            </tr>
            <tr>
                <td colspan="3" align="left"><input type="text"  class="text_purchase3"  disabled="disabled" id="cus_address" name="cus_address" /></td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
            </tr>
            <tr>
                <td align="left"><input type="checkbox" name="chkperiod" id="chkperiod" /> 
                    Period
                </td>
                <td align="left">&nbsp;</td>
                <td align="left"><input type="text" size="20" name="dtfrom" id="dtfrom" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtfrom');" class="text_purchase3"/></td>
                <td align="left"><input type="text"  class="label_purchase" value="To" disabled="disabled"/></td>
                <td align="left"><input type="text" size="20" name="dtto" id="dtto" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtto');" class="text_purchase4"/></td>
                <td align="left">&nbsp;</td>
            </tr>
            <tr>
                <td align="left"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
                <td align="left"><select name="com_rep" id="com_rep"   class="text_purchase3">
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
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
            </tr>
            <tr>
                <td align="left"><input type="radio" name="radio" id="optAsAt" value="optAsAt" /> 
                    PD Cheque As at
                </td>
                <td align="left"><input type="text" size="20" name="dtasatDate" id="dtasatDate" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtasatDate');" class="text_purchase3"/></td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
            </tr>
            <tr>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="3" align="left">&nbsp;</td>
                <td colspan="2" align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" align="left">&nbsp;</td>
                <td colspan="2" align="left"></td>
                <td width="91" align="left"><input type="submit" name="button" id="button" value="View" class="btn_purchase2"/></td>
            </tr>
            <tr>
                <td colspan="3" align="left"></td>
                <td colspan="2">&nbsp;</td>
            </tr>
        </table>
        <fieldset>               


    </form>        



