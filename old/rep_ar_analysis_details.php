
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


$sql = "delete FROM TMP_EDU_FILTER";

$result = mysqli_query($GLOBALS['dbinv'],$sql) ; 

$sql = "delete FROM	TMP_QUALI_FILTER";

$result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
?>	





<script language="JavaScript" src="js/pur_ord.js"></script>
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

</label>

<style type="text/css">
    <!--
    .style1 {font-weight: bold}
    -->
</style>
<script type="text/javascript">
    function load_calader(tar) {
        new JsDatePick({
            useMode: 2,
            target: tar,
            dateFormat: "%Y-%m-%d"

        });

    }

</script>
<fieldset>
    <legend>
        <div class="text_forheader">AR Details</div>
    </legend>             

    <form id="form1" name="form1" action="report_ar_analysis.php" target="_blank" method="get">
        <table border="0">



            <tr>

                <td><input type="text" disabled="disabled" value="AR No" class="label_purchase"></td>
                <td>  
                   <input type="text"  class="text_purchase3" id="invno" name="invno" globalnumber="334"> 
                </td>

                
                 <td>
                    <a onfocus="this.blur()" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" href="serach_arn.php">
        <input type="button" class="btn_purchase1" value="..." id="searchinv" name="searchinv">
      </a>
                    
                 </td>      
                    
               <td>
<input type="text" disabled="disabled" value="AR Date" class="label_purchase">
                </td>

                <td><input type="text"  class="text_purchase3" id="invdate" name="invdate" globalnumber="334">     </td>
                 
                <td></td>
                 <td>
<input type="text" disabled="disabled" value="Without Wheels,Nuts" class="label_purchase">
                </td>

                <td><input type="checkbox"  class="text_purchase3" id="chk1" name="chk1"  >     </td>
                 
                <td></td>
            </tr>


            <tr>

                <td></td> 
                <td></td>
                <td></td> 
                <td></td>
                <td></td> 
                <td></td>
            </tr>


            <tr>

          

            </tr>





            <tr>
                <td colspan= '3' align="left"><input type="submit" class="btn_purchase1" value="View" id="button" name="button"></td>

                <td></td>
                <td></td> 
                <td></td>
            </tr>
        </table>


</fieldset>
</form>        



