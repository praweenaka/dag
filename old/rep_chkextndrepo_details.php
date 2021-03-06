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
    window.onload = function() {
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
        <div class="text_forheader">Extended Cheque Reports</div>
    </legend>             

    <form id="form1" name="form1" action="report_chkextndrepo.php" target="_blank" method="get">
        <table width="450" border="0">
            <tr>
                <td width="450" align="left"><table width="600">
                        <tr>
                            <td width="76" align="left"><input type="text" disabled="disabled" value="From" class="label_purchase"></td>
                            <td width="150"> 
                                <span style="position: relative;"><input type="text" class="text_purchase3" onfocus="load_calader('dtfrom')"  id="dtfrom" name="dtfrom" size="20" globalnumber="369"><div class="JsDatePickBox" style="z-index: 3; position: absolute; top: 18px; left: 0px; display: none;" globalcalnumber="369"><div class="boxLeftWall"><div class="leftTopCorner"></div><div class="leftWall" style="height: 202px;"></div><div class="leftBottomCorner"></div></div><div class="boxMain"><div class="boxMainInner"><div class="controlsBar" globalnumber="369"><div class="monthForwardButton" globalnumber="369"></div><div class="monthBackwardButton" globalnumber="369"></div><div class="yearForwardButton" globalnumber="369"></div><div class="yearBackwardButton" globalnumber="369"></div><div class="controlsBarText">July, 2014</div></div><div class="clearfix"></div><div class="tooltip"></div><div class="weekDaysRow"><div class="weekDay">Mon</div><div class="weekDay">Tue</div><div class="weekDay">Wed</div><div class="weekDay">Thu</div><div class="weekDay">Fri</div><div class="weekDay">Sat</div><div class="weekDay" style="margin-right: 0px;">Sun</div></div><div class="boxMainCellsContainer"><div class="skipDay"></div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">1</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">2</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">3</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">4</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">5</div><div globalnumber="369" style="margin-right: 0px; background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;" class="dayNormal">6</div><div globalnumber="369" istoday="1" isselected="1" class="dayDownToday" style="background: url(&quot;img/ocean_blue_dayDown.gif&quot;) no-repeat scroll left top transparent;">7</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">8</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">9</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">10</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">11</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">12</div><div globalnumber="369" style="margin-right: 0px; background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;" class="dayNormal">13</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">14</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">15</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">16</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">17</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">18</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">19</div><div globalnumber="369" style="margin-right: 0px; background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;" class="dayNormal">20</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">21</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">22</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">23</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">24</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">25</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">26</div><div globalnumber="369" style="margin-right: 0px; background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;" class="dayNormal">27</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">28</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">29</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">30</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">31</div></div><div class="clearfix"></div></div></div><div class="boxRightWall"><div class="rightTopCorner"></div><div class="rightWall" style="height: 202px;"></div><div class="rightBottomCorner"></div></div><div class="clearfix"></div><div class="jsDatePickCloseButton" globalnumber="369"></div><div class="topWall"></div><div class="bottomWall"></div></div></span>
                            </td>
                            <td width="76" align="left"><input type="text" disabled="disabled" value="To" class="label_purchase"></td>
                            <td width="150">
                                <span style="position: relative;"><input type="text" class="text_purchase3" onfocus="load_calader('dtto')"  id="dtto" name="dtto" size="20" globalnumber="369"><div class="JsDatePickBox" style="z-index: 3; position: absolute; top: 18px; left: 0px; display: none;" globalcalnumber="369"><div class="boxLeftWall"><div class="leftTopCorner"></div><div class="leftWall" style="height: 202px;"></div><div class="leftBottomCorner"></div></div><div class="boxMain"><div class="boxMainInner"><div class="controlsBar" globalnumber="369"><div class="monthForwardButton" globalnumber="369"></div><div class="monthBackwardButton" globalnumber="369"></div><div class="yearForwardButton" globalnumber="369"></div><div class="yearBackwardButton" globalnumber="369"></div><div class="controlsBarText">July, 2014</div></div><div class="clearfix"></div><div class="tooltip"></div><div class="weekDaysRow"><div class="weekDay">Mon</div><div class="weekDay">Tue</div><div class="weekDay">Wed</div><div class="weekDay">Thu</div><div class="weekDay">Fri</div><div class="weekDay">Sat</div><div class="weekDay" style="margin-right: 0px;">Sun</div></div><div class="boxMainCellsContainer"><div class="skipDay"></div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">1</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">2</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">3</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">4</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">5</div><div globalnumber="369" style="margin-right: 0px; background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;" class="dayNormal">6</div><div globalnumber="369" istoday="1" isselected="1" class="dayDownToday" style="background: url(&quot;img/ocean_blue_dayDown.gif&quot;) no-repeat scroll left top transparent;">7</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">8</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">9</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">10</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">11</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">12</div><div globalnumber="369" style="margin-right: 0px; background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;" class="dayNormal">13</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">14</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">15</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">16</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">17</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">18</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">19</div><div globalnumber="369" style="margin-right: 0px; background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;" class="dayNormal">20</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">21</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">22</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">23</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">24</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">25</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">26</div><div globalnumber="369" style="margin-right: 0px; background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;" class="dayNormal">27</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">28</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">29</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">30</div><div globalnumber="369" class="dayNormal" style="background: url(&quot;img/ocean_blue_dayNormal.gif&quot;) no-repeat scroll left top transparent;">31</div></div><div class="clearfix"></div></div></div><div class="boxRightWall"><div class="rightTopCorner"></div><div class="rightWall" style="height: 202px;"></div><div class="rightBottomCorner"></div></div><div class="clearfix"></div><div class="jsDatePickCloseButton" globalnumber="369"></div><div class="topWall"></div><div class="bottomWall"></div></div></span>
                            </td>
                        </tr>


                    </table></td>
            </tr>

                        <tr>
                <td>
                    <input type= "checkbox" name="Check1" id ="Check1">Customer   &nbsp;
<input type= "checkbox" name="chk_ins" id ="chk_ins">Insentive.					
                </td>
				 
                 
            </tr>

            <tr>
                <td width="450" align="left"><table width="600">
                        <tr>
                            <td width="76" align="left"><input type="text" disabled="" value="Customer" class="label_purchase"></td>

                            <td width="186"><input type="text" class="text_purchase3" id="cuscode" name="cuscode"></td>

                            <td width="314"><input type="text" class="text_purchase3" id="cusname" name="cusname"></td>
                            <td><a onfocus="this.blur()" onclick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
                                    return false" href="serach_customer.php?stname=rep_monthly_sales">
                                    <input type="button" class="btn_purchase1" value="..." id="searchcust" name="searchcust">
                                </a></td>
                        </tr>


                    </table></td>
            </tr>          




            <tr>
                <td width="274" align="left"></td>
            </tr>
            <tr>
                <td width="180" align="left"><input type="submit" class="btn_purchase1" value="View" id="button" name="button" ></td>
            </tr>
        </table>


</fieldset>
</form>        



