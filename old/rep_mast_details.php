
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
<!-- Tab -->
<link rel="stylesheet" type="text/css" href="css/tabcontent.css" />

<script type="text/javascript" src="js/tabcontent.js">

    /***********************************************
     * Tab Content script v2.2- � Dynamic Drive DHTML code library (www.dynamicdrive.com)
     * This notice MUST stay intact for legal use
     * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
     ***********************************************/

</script>


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
    function openWin()
    {
        myWindow = window.open('serach_inv.php', '', 'width=200,height=100');
        myWindow.focus();

    }
</script>

<script type="text/javascript">
    window.onload = function () {
        new JsDatePick({
            useMode: 2,
            target: "dte_shedule",
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
        <div class="text_forheader">Enter Marketing Executive Details</div>
    </legend>             

    <form name="form1" id="form1">            
        <table width="100%" border="0"  class=\"form-matrix-table\">
            <tr>
                <td width="16%"><input type="text"  class="label_purchase" value="Code" disabled/></td>
                <td width="20%">
                    <?php
                    include_once("connectioni.php");
                    $sql = mysqli_query($GLOBALS['dbinv'], "Select max(REPCODE) as nextcode from s_salrep ") or die(mysqli_error());
                    $row = mysqli_fetch_array($sql);
                    ?>	


                    <input type="text" name="txtcode" id="txtcode" value="<?php echo $row["nextcode"] + 1; ?>" class="text_purchase" onblur="chk_number();" onkeypress="keyset('txtname', event);"   />
                    <a href="search_rep.php?stname=rep_mast" onClick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
                            return false" onFocus="this.blur()">
                        <input type="button" name="searchinv2" id="searchinv2" value="..." class="btn_purchase1" >
                    </a></td>
                <td>&nbsp;</td>
                <td width="16%"><input type="text"  class="label_purchase" value="Group" disabled="disabled"/></td>
                <td width="20%"><select name="cmb_group" id="cmb_group"  class="text_purchase3" >
                        <option value='OFFICE'>OFFICE</option>
                        <option value='AREA I'>AREA I</option>
                        <option value='AREA II'>AREA II</option>
                        <option value='DISTRIBUTION'>DISTRIBUTION</option>
                        <option value='Battery AND Tube'>BATTERY & TUBE</option>
						<option value='TYRES AND ALLOY WHEELS'>TYRES & ALLOY WHEELS</option>
                    </select></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="9%">&nbsp;</td>
            </tr>
			            <tr>
                <td width="16%"><input type="text"  class="label_purchase" value="RGroup1" disabled="disabled"/></td>
                <td width="20%">
                    <select name="cmb_group1" id="cmb_group1"  class="text_purchase3" >
                        <option value='OFFICE'>OFFICE</option>
                        <option value='AREA I'>AREA I</option>
                        <option value='AREA II'>AREA II</option>
                        <option value='DISTRIBUTION'>DISTRIBUTION</option>
                        <option value='Battery AND Tube'>BATTERY & TUBE</option>
                        <option value='TYRES AND ALLOY WHEELS'>TYRES & ALLOY WHEELS</option>
                    </select></td>
                <td>&nbsp;</td>
                <td width="16%"><input type="text"  class="label_purchase" value="RGroup2" disabled="disabled"/></td>
                <td width="20%"><select name="cmb_group2" id="cmb_group2"  class="text_purchase3" >
                        <option value=''>Not Specified</option>
                        <option value='A'>A</option>
                        <option value='B'>B</option>
                    </select></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="9%">&nbsp;</td>
            </tr>
            <tr>
                <td><input type="text"  class="label_purchase" value="Name" disabled/></td>
                <td><input type="text" class="text_purchase3" name="txtname" id="txtname" onkeypress="keyset('txttottar', event);"/></td>
                <td>&nbsp;</td>
                <td width="16%"><input type="text"  class="label_purchase" value="Active" disabled="disabled"/></td>
                <td width="20%"><input type="checkbox" name="chk_active" id="chk_active" /></td>
                <td width="12%">&nbsp;</td>
                <td width="16%">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><input type="text"  class="label_purchase" value="Target" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3" name="txttottar" id="txttottar" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">
                    <fieldset>
                        <legend><strong>Target</strong></legend>
                        <table width="658" border="0">
                            <tr>
                                <th width="144" scope="col"><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></th>
                                <th width="425" scope="col">

                                    <select name="cmbbrand" id="cmbbrand" class="text_purchase3" onChange="brand_target();">
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
                                    </select>
                                </th>
                                <th width="75" scope="col"><input type="button" class="btn_purchase1" name="cmdupdate" id="cmdupdate" value="Update" onclick="update_target();" /></th>
                            </tr>
                            <tr>
                                <td><input type="text"  class="label_purchase" value="Target" disabled="disabled"/></td>
                                <td><input type="text" class="text_purchase3"  id="txttar" name="txttar" /></td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </fieldset>    </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td colspan="7">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="0%">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="7">


                    <ul id="countrytabs" class="shadetabs">	
                        <li><a href="#" rel="country1" class="selected">General Dealer Targets</a></li>
                        <li><a href="#" rel="country2">Special Dealer Targets</a></li>
                        <li><a href="#" rel="country5">Advance Rates</a></li>
                    </ul>


                    <div style="border:1px solid gray; width:800px; margin-bottom: 1em; padding: 10px">

                        <div id="country1" class="tabcontent">
                            <!-- Tab 1  -->


                            <div id="creditlim" > 
                                <table width="300" border="1" cellspacing="0">
                                    <tr>
                                        <td><input type="text"  class="label_purchase" value="Dealer" disabled/></td>
                                        <td> <a href="serach_customer.php?stname=rep_mast_general" onClick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
                                                return false" onFocus="this.blur()"><input type="button" name="comcus" id="comcus" value="..." class="btn_purchase1" ></a><input type="text" size="10" name="txt_cuscode" id="txt_cuscode"   class="text_purchase2"/><input type="text" size="55" name="txt_cusname" id="txt_cusname"   class="text_purchase2"/></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text"  class="label_purchase" value="Target Sale" disabled/></td>
                                        <td><input type="text" size="20" name="txtdetar" id="txtdetar"   class="text_purchase2"/><input type="button" name="cmdadd" id="cmdadd" value="Add" onClick="savetarget();" class="btn_purchase1" ><input type="button" name="cmdremove" id="cmdremove" value="Delete" onClick="deletetarget();" class="btn_purchase1"></td>
                                    </tr>
                                </table>
                                <br>
                                <div id="target" class="CSSTableGenerator">
                                    <table width="712" border="1" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="66">Code</td>
                                            <td width="327">Name</td>
                                            <td width="159">Target</td>
                                            <td width="132">Last Update</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                </div>
                                <p>&nbsp;</p>
                            </div>
                            <br />


                            <script type="text/javascript">

                                var countries = new ddtabcontent("countrytabs1")
                                countries.setpersist(true)
                                countries.setselectedClassTarget("link") //"link" or "linkparent"
                                countries.init()

                            </script>

                            <br />
                        </div>

                        <div id="country2" class="tabcontent">
                            <table width="300" border="1" cellspacing="0">
                                <tr>
                                    <td><input type="text"  class="label_purchase" value="Dealer" disabled/></td>
                                    <td><a href="serach_customer.php?stname=rep_mast_general_s" onClick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
                                                    return false" onFocus="this.blur()"><input type="button" name="comcus_s" id="comcus_s" value="..." class="btn_purchase1" ></a><input type="text" size="10" name="txt_cuscode_s" id="txt_cuscode_s"   class="text_purchase2"/><input type="text" size="35" name="txt_cusname_s" id="txt_cusname_s"   class="text_purchase2"/></td>
                                </tr>
                                <tr>
                                    <td><input type="text"  class="label_purchase" value="Target Sale" disabled/></td>
                                    <td><input type="text" size="20" name="txtdetar_s" id="txtdetar_s"   class="text_purchase2"/><input type="button" name="cmdadd_s" id="cmdadd_s" value="Add" class="btn_purchase1" onClick="savetarget_s();"  ><input type="button" name="cmdremove_s" id="cmdremove_s" value="Delete" class="btn_purchase1"  onClick="deletetarget_s();" ></td>
                                </tr>
                            </table>

                            <br>
                            <div id="target_s" class="CSSTableGenerator">
                                <table width="712" border="1" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="66">Code</td>
                                        <td width="327">Name</td>
                                        <td width="159">Target</td>
                                        <td width="132">Last Update</td>
                                    </tr>
                                    <tr >
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div id="country3" class="tabcontent">
                            <textarea name="txtMsg" id="txtMsg" cols="45" rows="5"></textarea><br />
                        </div>

                        <div id="country4" class="tabcontent">
                            Approved only for <input type="text" name="DT_Over_DUE_IG" id="DT_Over_DUE_IG" /><br />
                        </div>

                        <div id="country5" width='500' class="tabcontent">
                            <legend><b>Dealer</legend>
                            <table width="250" border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="150">Target</td>
                                    <td width="100">Rate</td>

                                </tr>                                    
                                <tr>
                                    <td><input type="text" class="text_purchase3"  id="tdam1" name="tdam1" /></td>
                                    <td><input type="text" class="text_purchase3"  id="tdamr1" name="tdamr1" /></td>  
                                </tr>
                                <tr>
                                    <td><input type="text" class="text_purchase3"  id="tdam2" name="tdam2" /></td>
                                    <td><input type="text" class="text_purchase3"  id="tdamr2" name="tdamr2" /></td>  
                                </tr>
                                <tr>
                                    <td><input type="text" class="text_purchase3"  id="tdam3" name="tdam3" /></td>
                                    <td><input type="text" class="text_purchase3"  id="tdamr3" name="tdamr3" /></td>  
                                </tr>
                                
                            </table>
                            <legend>Distributor</legend>
                            <table width="250" border="1" class cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="150">Target</td>
                                    <td width="100">Rate</td>

                                </tr>                                    
                                <tr>
                                    <td><input type="text" class="text_purchase3"  id="tdisam1" name="tdisam1" /></td>
                                    <td><input type="text" class="text_purchase3"  id="tdisar1" name="tdisar1" /></td>  
                                </tr>
                                <tr>
                                    <td><input type="text" class="text_purchase3"  id="tdisam2" name="tdisam2" /></td>
                                    <td><input type="text" class="text_purchase3"  id="tdisar2" name="tdisar2" /></td>  
                                </tr>
                                <tr>
                                    <td><input type="text" class="text_purchase3"  id="tdisam3" name="tdisam3" /></td>
                                    <td><input type="text" class="text_purchase3"  id="tdisar3" name="tdisar3" /></td>  
                                </tr>
                            </table>
                            
                            <legend>Battries</legend>
                            <table width="250" border="1"  cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="150">Target</td>
                                    <td width="100">Rate</td>

                                </tr>                                    
                                <tr>
                                    <td><input type="text" class="text_purchase3"  id="BT1" name="BT1" /></td>
                                    <td><input type="text" class="text_purchase3"  id="BR1" name="BR1" /></td>  
                                </tr>
                                <tr>
                                    <td><input type="text" class="text_purchase3"  id="BT2" name="BT2" /></td>
                                    <td><input type="text" class="text_purchase3"  id="BR2" name="BR2" /></td>  
                                </tr>
                                <tr>
                                    <td><input type="text" class="text_purchase3"  id="BT3" name="BT3" /></td>
                                    <td><input type="text" class="text_purchase3"  id="BR3" name="BR3" /></td>  
                                </tr>
                            </table>
                            
                            
                            <legend>Tyres A/W</legend>
                            <table width="250" border="1"  cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="150">Target</td>
                                    <td width="100">Rate</td>

                                </tr>                                    
                                <tr>
                                    <td><input type="text" class="text_purchase3"  id="TT1" name="TT1" /></td>
                                    <td><input type="text" class="text_purchase3"  id="TR1" name="TR1" /></td>  
                                </tr>
                                <tr>
                                    <td><input type="text" class="text_purchase3"  id="TT2" name="TT2" /></td>
                                    <td><input type="text" class="text_purchase3"  id="TR2" name="TR2" /></td>  
                                </tr>
                                <tr>
                                    <td><input type="text" class="text_purchase3"  id="TT3" name="TT3" /></td>
                                    <td><input type="text" class="text_purchase3"  id="TR3" name="TR3" /></td>  
                                </tr>
                            </table>
                            
                        </div>


                    </div>

                    <script type="text/javascript">

                        var countries = new ddtabcontent("countrytabs")
                        countries.setpersist(true)
                        countries.setselectedClassTarget("link") //"link" or "linkparent"
                        countries.init()

                    </script>  </td>
                <td colspan="3"> </td>
                <td>&nbsp;</td>
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
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="11">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="10">&nbsp;</td>
            </tr>
        </table>



        <fieldset>               


    </form>        



