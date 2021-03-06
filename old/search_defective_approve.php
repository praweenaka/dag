<?php
ini_set('session.gc_maxlifetime', 30*60*60*60);
 session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


        <link href="admin_min.css" rel="stylesheet" type="text/css" media="screen" />



        <title>Approve DGRN</title>

        <link rel="stylesheet" href="css/table_min.css" type="text/css"/>
        <script language="JavaScript" src="js/defective.js"></script>
        <style type="text/css">

            /* START CSS NEEDED ONLY IN DEMO */
            html{
                height:100%;
            }


            #mainContainer{
                width:700px;
                margin:0 auto;
                text-align:left;
                height:100%;
                background-color:#FFF;
                border-left:3px double #000;
                border-right:3px double #000;
            }
            #formContent{
                padding:5px;
            }
            /* END CSS ONLY NEEDED IN DEMO */


            /* Big box with list of options */
            #ajax_listOfOptions{
                position:absolute;	/* Never change this one */
                width:175px;	/* Width of box */
                height:250px;	/* Height of box */
                overflow:auto;	/* Scrolling features */
                border:1px solid #317082;	/* Dark green border */
                background-color:#FFF;	/* White background color */
                text-align:left;
                font-size:0.9em;
                z-index:100;
            }
            #ajax_listOfOptions div{	/* General rule for both .optionDiv and .optionDivSelected */
                margin:1px;		
                padding:1px;
                cursor:pointer;
                font-size:0.9em;
            }
            #ajax_listOfOptions .optionDiv{	/* Div for each item in list */

            }
            #ajax_listOfOptions .optionDivSelected{ /* Selected item in the list */
                background-color:#317082;
                color:#FFF;
            }
            #ajax_listOfOptions_iframe{
                background-color:#F00;
                position:absolute;
                z-index:5;
            }

            form{
                display:inline;
            }

            #article {font: 12pt Verdana, geneva, arial, sans-serif;  background: white; color: black; padding: 10pt 15pt 0 5pt}
        </style>


    </head>

    <body>

        <table width="864" border="0">

            <tr>					
                <?php
                $stname = $_GET["stname"];
                ?>
                <td width="212"  background="images/headingbg.gif" ><input type="text" size="20" name="invno" id="invno" value="" class="txtbox"  onkeyup="<?php echo "update_list_approve('$stname')"; ?>"/></td>
                <td width="345"  background="images/headingbg.gif" ><input type="text" size="30" name="customername" id="customername" value="" class="txtbox" onkeyup="<?php echo "update_list_approve('$stname')"; ?>"/></td>
                <td width="293"  background="images/headingbg.gif" >&nbsp;</td>
            </tr>  </table>    
        <div class="CSSTableGenerator" id="filt_table">  <table width="735" border="0" class=\"form-matrix-table\">
                <tr>
                    <td width="100"  background="images/headingbg.gif" ><font color="#FFFFFF">REF No</font></td>
                    <td width="176"  background="images/headingbg.gif"><font color="#FFFFFF">Customer</font></td>
                    <td width="176"  background="images/headingbg.gif"><font color="#FFFFFF">Description</font></td>
                    <td width="206"  background="images/headingbg.gif"><font color="#FFFFFF">Remark</font></td>
                    <td width="146"  background="images/headingbg.gif"><font color="#FFFFFF">Rate</font></td>
                    <td width="100"  background="images/headingbg.gif"><font color="#FFFFFF">Discount</font></td>
                    <td width="176"  background="images/headingbg.gif"><font color="#FFFFFF">Refund</font></td>
                    <td width="176"  background="images/headingbg.gif"><font color="#FFFFFF">Total</font></td>
                    <td width="176"  background="images/headingbg.gif"><font color="#FFFFFF">Approve</font></td>
                </tr>
                <?php
               require_once("connectioni.php");

                //$sql="select REFNO, BAT_NO, CLAM_NO, SDATE  from s_deftrn where REFNO like '" & txtcode.Text & "%' and CANCELL='0' ORDER BY REFNO"
                //$sql="SELECT * FROM s_crnma where CANCELL='0' order by REF_NO desc";
                $sql = "select * from view_s_deftrn_vender where  CANCELL='0' and approve='0' and denie='0' ORDER BY SDATE desc limit 50";

               $result = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row = mysqli_fetch_array($result)) {

                    echo "<tr>               
                                <td>" . $row['REFNO'] . "</a></td>
                                <td>" . $row['NAME'] . "</a></td>
                                 <td>" . $row['DESCRIPT'] . "</a></td>
                                <td>" . $row['Remarks'] . "</a></td>
                                 <td>" . $row['AMOUNT'] . "</a></td>
                                 <td>" . $row['dis'] . "</a></td>
                                 <td>" . $row['ref_per'] . "</a></td>
                                 <td>" . $row['GRAND_TOT'] . "</a></td>
                                <td><button onclick=\"approve('" . $row['REFNO'] . "');\">Approve</button>&nbsp;&nbsp;<button onclick=\"denie('" . $row['REFNO'] . "','" . $row['cl_no'] . "','" . $row['clrefno'] . "','" . $row['GRAND_TOT'] . "','" . $row['c_code'] . "','" . $row['SAL_EX'] . "');\">Denie</button></a></td>
                            </tr>";
                }
                ?>
                <!--<td><button onclick=\"approve('" . $row['REFNO'] . "');\">Approve</button>&nbsp;&nbsp;<button onclick=\"reject('" . $row['REFNO'] . "','" . $row['cl_no'] . "','" . $row['clrefno'] . "','" . $row['GRAND_TOT'] . "','" . $row['c_code'] . "','" . $row['SAL_EX'] . "');\">Cancel</button></a></td>-->
            </table>
        </div>

    </body>
</html>
