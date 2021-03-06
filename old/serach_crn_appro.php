<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


        <link href="admin_min.css" rel="stylesheet" type="text/css" media="screen" />



        <title>Search Customer</title>

        <script language="JavaScript" src="js/credit_note_form.js"></script>
        <link rel="stylesheet" href="css/table_min.css" type="text/css"/>
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

        <table width="925" border="0">

            <tr>
                <td  background="" ><input type="radio" name="radio" id="Option1" value="Option1"  onclick="select_list('all', '<?php echo $_GET["stname"]; ?>');" />
                    All</td>
                <td  background="" ><input type="radio" name="radio" id="Option2" value="Option2" onclick="select_list('locked', '<?php echo $_GET["stname"]; ?>');"/>
                    Approved Locked</td>
                <td  background="" ><input type="radio" name="radio" id="Option3" value="Option3" checked="checked" onclick="select_list('pending', '<?php echo $_GET["stname"]; ?>');"/>
                    Pending</td>
            </tr>
            <tr>					
                <?php
                $stname = $_GET["stname"];
                ?>
                <td width="276"  background="" ><input type="text" size="20" name="invno" id="invno" value="" class="txtbox"  onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
                <td width="325"  background="" ><input type="text" size="50" name="customername" id="customername" value="" class="txtbox" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
                <td width="310"  background="" ><input type="text" size="29" name="invdate" id="invdate" value="" class="txtbox"/></td>
            </tr>  </table>   
        <div class="CSSTableGenerator" > 
            <div id="filt_table">  <table width="735" border="0" class=\"form-matrix-table\">
                    <tr>
                        <td width="121"  background="" ><font color="#FFFFFF">Invoice No</font></td>
                        <td width="424"  background=""><font color="#FFFFFF">Customer</font></td>
                        <td width="176"  background=""><font color="#FFFFFF">Invoice Date</font></td>
                    </tr>
                    <?php
                    require_once("connectioni.php");



                    //if ($_GET["stname"]=="crn"){




                    $_SESSION["slected"] = "all";

                    if ($_GET["stname"] == "crn_form_check") {
                        $sql = "select Refno, Code, Amount   from s_crnfrm where Cancell = '0' and Flag = 'ACRN' and Checked='A' order BY Sdate  desc limit 300";
                    } else if ($_GET["stname"] == "crn_form_autho") {
                        $sql = "select Refno, Code, Amount   from s_crnfrm where Cancell = '0' and Flag = 'ACRN' and Checked!='A' and Lock1='0' order BY Sdate  desc limit 300";
                    } else if ($_GET["stname"] == "crn_form_all") {

                        $sql = "select Refno, Code, Amount   from s_crnfrm where Cancell = '0' and Flag = 'ACRN' order BY Sdate  desc limit 300";
                    } else if ($_GET["stname"] == "crn") {

                        $sql = "select Refno, Code, Amount   from s_crnfrm where Cancell = '0' and Checked!='A' and Lock1='1' and Credit_note='A' order BY Sdate  desc limit 300";
                    }


                    /* if ($_GET["stname"]=="crn"){

                      $sql = "select Refno, Code, Amount   from s_crnfrm where Cancell = '0'  and Lock1='1' order BY Sdate  desc limit 50";
                      } */



                    //}
                    //	echo $sql;
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    while ($row = mysqli_fetch_array($result)) {

                        $sql_v = "select * from vendor where CODE='" . $row["Code"] . "'";
                        $result_v = mysqli_query($GLOBALS['dbinv'], $sql_v);
                        $row_v = mysqli_fetch_array($result_v);

                        if ($_GET["stname"] == "crn") {
                            echo "<tr>               
                              <td onclick=\"invno_check_crn('" . $row['Refno'] . "', '" . $_GET['stname'] . "', '" . $row['Amount'] . "');\">" . $row['Refno'] . "</a></td>
                              <td onclick=\"invno_check_crn('" . $row['Refno'] . "', '" . $_GET['stname'] . "', '" . $row['Amount'] . "');\">" . $row["Code"] . " " . $row_v["NAME"] . "</a></td>
                              <td onclick=\"invno_check_crn('" . $row['Refno'] . "', '" . $_GET['stname'] . "', '" . $row['Amount'] . "');\">" . $row['Amount'] . "</a></td>
                              
                            	</tr>";
                        } else {
                            echo "<tr>               
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row['Refno'] . "</a></td>
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row["Code"] . " " . $row_v["NAME"] . "</a></td>
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row['Amount'] . "</a></td>
                              
                            	</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>              

    </body>
</html>
