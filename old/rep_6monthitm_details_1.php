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

<style type="text/css">
    <!--
    .style1 {font-weight: bold}
    -->
</style>
<fieldset>
    <legend>
        <div class="text_forheader">6 Month Sales Summery - GEN No Wise</div>
    </legend>             

    <form id="form1" name="form1" action="report_6monthitm_1.php" target="_blank" method="get">
        <table width="1000" border="0">
            <tr>
                <td colspan="4" align="left">&nbsp;</td>
                <td><input type="text" name="DTPicker1" id="DTPicker1" class="text_purchase3" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('DTPicker1');"/></td>
                <td colspan="2"><script type="text/javascript">
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
                    </script>    </td>
            </tr>
            <tr>
                <td  align="left"><input type="radio" name="radio1" id="opdetail" value="opdetail" checked="checked"  />
                    Detail</td>
                <td  align="left"><input type="radio" name="radio1" id="opsum" value="opsum"   />
                    Summery</td>
                 <td  align="left"></td>
                <td align="left"><input type="radio" name="radio" id="Option1" value="Option1" checked="checked"  />
                    6 Month</td>
                <td  align="left"><input type="radio" name="radio" id="Option2" value="Option2" />
                    12 Month</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>


            </tr>

            <tr>
                <td align="left"><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>

                <td colspan="2"  align="left"><select name="cmbbrand" id="cmbbrand" onkeypress="keyset('searchitem', event);" class="text_purchase3"  onchange="setord();">
                    <option value='All'>All</option>    
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
                <td align="left"><input type="text"  class="label_purchase" value="Month 1" disabled="disabled"/></td>
                <td align="left"><input type="text" name="month1" id="month1" class="text_purchase3" onfocus="load_calader('month1');" /></td>
                <td align="left"><input type="text"  class="label_purchase" value="Month 7" disabled="disabled"/></td>
                <td align="left"><input type="text" name="month7" id="month7" class="text_purchase3" onfocus="load_calader('month7');" /></td>
                <td>&nbsp;</td>
                <td><input type="button" name="button2" id="button2" value="Set Month" class="btn_purchase1" onclick="set_other_month6();"/></td>
            </tr>
             
            
            <tr>
                <td align="left"><input type="text"  class="label_purchase" value="GEN No" disabled="disabled"/></td>

                <td colspan="2"  align="left"><select name="cmbgen" id="cmbbrand" onkeypress="keyset('searchitem', event);" class="text_purchase3"  onchange="setord();">
                        <?php
                        $sql = "select gen_no from s_mas group by gen_no";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row["gen_no"] . "'>" . $row["gen_no"] . "</option>";
                        }
                        ?>
                    </select></td>
                <td align="left"><input type="text"  class="label_purchase" value="Month 2" disabled="disabled"/></td>
                <td align="left"><input type="text" name="month2" id="month2" class="text_purchase3" onfocus="load_calader('month2');"/></td>
                <td align="left"><input type="text"  class="label_purchase" value="Month 8" disabled="disabled"/></td>
                <td align="left"><input type="text" name="month8" id="month8" class="text_purchase3" onfocus="load_calader('month8');"/></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>

            </tr>
            <tr>
                <td align="left"></td>

                <td colspan="2"  align="left"></td>
                <td align="left"><input type="text"  class="label_purchase" value="Month 3" disabled="disabled"/></td>
                <td align="left"><input type="text" name="month3" id="month3" class="text_purchase3" onfocus="load_calader('month3');"/></td>
                <td align="left"><input type="text"  class="label_purchase" value="Month 9" disabled="disabled"/></td>
                <td align="left"><input type="text" name="month9" id="month9" class="text_purchase3" onfocus="load_calader('month9');"/></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>

            </tr>
            <tr>
                <td align="left"></td>
                <td colspan="2"  align="left"></td>
                <td align="left"><input type="text"  class="label_purchase" value="Month 4" disabled="disabled"/></td>
                <td align="left"><input type="text" name="month4" id="month4" class="text_purchase3" onfocus="load_calader('month4');"/></td>
                <td align="left"><input type="text"  class="label_purchase" value="Month 10" disabled="disabled"/></td>
                <td align="left"><input type="text" name="month10" id="month10" class="text_purchase3" onfocus="load_calader('month10');"/></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>

            </tr>
            <tr>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left"><input type="text"  class="label_purchase" value="Month 5" disabled="disabled"/></td>
                <td align="left"><input type="text" name="month5" id="month5" class="text_purchase3" onfocus="load_calader('month5');"/></td>
                <td align="left"><input type="text"  class="label_purchase" value="Month 11" disabled="disabled"/></td>
                <td align="left"><input type="text" name="month11" id="month11" class="text_purchase3" onfocus="load_calader('month11');"/></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>

            </tr>  
            <tr>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left"><input type="text"  class="label_purchase" value="Month 6" disabled="disabled"/></td>
                <td align="left"><input type="text" name="month6" id="month6" class="text_purchase3" onfocus="load_calader('month6');"/></td>

                <td align="left"><input type="text"  class="label_purchase" value="Month 12" disabled="disabled"/></td>
                <td align="left"><input type="text" name="month12" id="month12" class="text_purchase3" onfocus="load_calader('month12');"/></td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>

            </tr>  


            <tr>
                <td colspan="5" align="left"><table width="500" border="0">
                        <tr>
                            <th width="403" scope="col"><table width="400" border="0">
                            <tr>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>
                            </tr>

                        </table></th>
                        <th width="87" scope="col"><table width="300" border="0">
                            <tr>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>
                            </tr>

                        </table></th>
            </tr>
        </table></td>
        <td colspan="2" align="left">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>

        </tr>
        <tr>
            <td colspan="7" align="left">   </td>
        </tr>
        <tr>
            <td colspan="4" align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
        </tr>
        <tr>
            <td width="422" colspan="4" align="left">&nbsp;</td>
            <td width="160" align="left"></td>
            <td width="399" colspan="2" align="left">&nbsp;</td>
        </tr>
        <tr>
            <td width="422" colspan="4" align="left"></td>
            <td><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
        </tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>

        </table>




    </form>        



