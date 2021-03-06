<?php

session_start();








/*
  include_once("connectioni.php");
  include_once("DBConnector.php");
  $letters = $_GET['letters'];

  $sql="SELECT * FROM mast_family where name like '".$letters."%'";
  $result =mysqli_query($GLOBALS['dbinv'],$sql) ;


  while($row = mysqli_fetch_array($result))
  {

  echo $row["name"];

  }

 */


require_once("connectioni.php");




if ($_GET["Command"] == "set_other_month") {

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 1 months";
    $month2 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 2 months";
    $month3 = date('Y-m-d', strtotime($date . $caldays));

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<mapdetails>";

    $ResponseXML .= "<month2><![CDATA[" . $month2 . "]]></month2>";
    $ResponseXML .= "<month3><![CDATA[" . $month3 . "]]></month3>";
    $ResponseXML .= "</mapdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "set_other_month61") {

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 1 months";
    $month2 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 2 months";
    $month3 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 3 months";
    $month4 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 4 months";
    $month5 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 5 months";
    $month6 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 6 months";
    $month7 = date('Y-m-d', strtotime($date . $caldays));

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<mapdetails>";

    $ResponseXML .= "<month2><![CDATA[" . $month2 . "]]></month2>";
    $ResponseXML .= "<month3><![CDATA[" . $month3 . "]]></month3>";
    $ResponseXML .= "<month4><![CDATA[" . $month4 . "]]></month4>";
    $ResponseXML .= "<month5><![CDATA[" . $month5 . "]]></month5>";
    $ResponseXML .= "<month6><![CDATA[" . $month6 . "]]></month6>";

    $ResponseXML .= "</mapdetails>";


    echo $ResponseXML;
}
if ($_GET["Command"] == "set_other_month6") {
    if ($_GET["op"] == 'Option1') {
        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 1 months";
        $month2 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 2 months";
        $month3 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 3 months";
        $month4 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 4 months";
        $month5 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 5 months";
        $month6 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 6 months";
        $month7 = date('Y-m-d', strtotime($date . $caldays));

        header('Content-Type: text/xml');
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

        $ResponseXML = "";
        $ResponseXML .= "<mapdetails>";

        $ResponseXML .= "<month2><![CDATA[" . $month2 . "]]></month2>";
        $ResponseXML .= "<month3><![CDATA[" . $month3 . "]]></month3>";
        $ResponseXML .= "<month4><![CDATA[" . $month4 . "]]></month4>";
        $ResponseXML .= "<month5><![CDATA[" . $month5 . "]]></month5>";
        $ResponseXML .= "<month6><![CDATA[" . $month6 . "]]></month6>";

        $ResponseXML .= "</mapdetails>";
    } else if ($_GET["op"] == 'Option2') {
        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 1 months";
        $month2 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 2 months";
        $month3 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 3 months";
        $month4 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 4 months";
        $month5 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 5 months";
        $month6 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 6 months";
        $month7 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 7 months";
        $month8 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 8 months";
        $month9 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 9 months";
        $month10 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 10 months";
        $month11 = date('Y-m-d', strtotime($date . $caldays));

        $date = date("Y-m-d", strtotime($_GET["month1"]));
        $caldays = " + 11 months";
        $month12 = date('Y-m-d', strtotime($date . $caldays));


        header('Content-Type: text/xml');
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

        $ResponseXML = "";
        $ResponseXML .= "<mapdetails>";

        $ResponseXML .= "<month2><![CDATA[" . $month2 . "]]></month2>";
        $ResponseXML .= "<month3><![CDATA[" . $month3 . "]]></month3>";
        $ResponseXML .= "<month4><![CDATA[" . $month4 . "]]></month4>";
        $ResponseXML .= "<month5><![CDATA[" . $month5 . "]]></month5>";
        $ResponseXML .= "<month6><![CDATA[" . $month6 . "]]></month6>";
        $ResponseXML .= "<month7><![CDATA[" . $month7 . "]]></month7>";
        $ResponseXML .= "<month8><![CDATA[" . $month8 . "]]></month8>";
        $ResponseXML .= "<month9><![CDATA[" . $month9 . "]]></month9>";
        $ResponseXML .= "<month10><![CDATA[" . $month10 . "]]></month10>";
        $ResponseXML .= "<month11><![CDATA[" . $month11 . "]]></month11>";
        $ResponseXML .= "<month12><![CDATA[" . $month12 . "]]></month12>";

        $ResponseXML .= "</mapdetails>";
    }

    echo $ResponseXML;
}
if ($_GET["Command"] == "set_other_month12") {

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 1 months";
    $month2 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 2 months";
    $month3 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 3 months";
    $month4 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 4 months";
    $month5 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 5 months";
    $month6 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 6 months";
    $month7 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 7 months";
    $month8 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 8 months";
    $month9 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 9 months";
    $month10 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 10 months";
    $month11 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 11 months";
    $month12 = date('Y-m-d', strtotime($date . $caldays));



    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<mapdetails>";

    $ResponseXML .= "<month2><![CDATA[" . $month2 . "]]></month2>";
    $ResponseXML .= "<month3><![CDATA[" . $month3 . "]]></month3>";
    $ResponseXML .= "<month4><![CDATA[" . $month4 . "]]></month4>";
    $ResponseXML .= "<month5><![CDATA[" . $month5 . "]]></month5>";
    $ResponseXML .= "<month6><![CDATA[" . $month6 . "]]></month6>";
    $ResponseXML .= "<month7><![CDATA[" . $month7 . "]]></month7>";
    $ResponseXML .= "<month8><![CDATA[" . $month8 . "]]></month8>";
    $ResponseXML .= "<month9><![CDATA[" . $month9 . "]]></month9>";
    $ResponseXML .= "<month10><![CDATA[" . $month10 . "]]></month10>";
    $ResponseXML .= "<month11><![CDATA[" . $month11 . "]]></month11>";
    $ResponseXML .= "<month12><![CDATA[" . $month12 . "]]></month12>";

    $ResponseXML .= "</mapdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "set_other_month3") {

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 1 months";
    $month2 = date('Y-m-d', strtotime($date . $caldays));

    $date = date("Y-m-d", strtotime($_GET["month1"]));
    $caldays = " + 2 months";
    $month3 = date('Y-m-d', strtotime($date . $caldays));


    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<mapdetails>";

    $ResponseXML .= "<month2><![CDATA[" . $month2 . "]]></month2>";
    $ResponseXML .= "<month3><![CDATA[" . $month3 . "]]></month3>";

    $ResponseXML .= "</mapdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "select_rep") {



    $ResponseXML = "";



    $sql = "SELECT STK_NO, DESCRIPT from s_mas WHERE IMEINo ='" . $_GET["imei"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {

        //$sql1="Delete from tmpselected where imeino='".$_GET["imei"]."'";
        //$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	

        if ($_GET["chk"] == "true") {
            $sql1 = "Insert into tmpitem (itemcode, name) values ('" . $row["STK_NO"] . "', '" . $row["DESCRIPT"] . "')";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        } else if ($_GET["chk"] == "false") {
            $sql1 = "Delete from tmpitem where itemcode='" . $row["STK_NO"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        }
    }

    $ResponseXML .= "<select multiple=\"multiple\" name=\"available\" id=\"available\">";
    $sql = "select * from tmpitem";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $ResponseXML .= "<option>" . $row["itemcode"] . " " . $row["name"] . "</option>";
    }
    $ResponseXML .= "</select>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "setlist") {

    $sql = "delete from tmpitem";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML = "";

    $ResponseXML .= "<select multiple=\"multiple\" name=\"available\" id=\"available\" size=20>";

    if ($_GET["brand"] == "All") {
        $sql = "select STK_NO, DESCRIPT from s_mas order by STK_NO";
    } else {
        $sql = "select STK_NO, DESCRIPT from s_mas where BRAND_NAME='" . $_GET["brand"] . "' order by STK_NO";
    }
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $ResponseXML .= "<option id=" . $row["STK_NO"] . " value=" . $row["STK_NO"] . " ondblclick=\"sel_one('" . $row['STK_NO'] . "');\">" . $row["STK_NO"] . " " . $row["DESCRIPT"] . "</option>";
    }
    $ResponseXML .= "</select>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "sel_one") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $sqltmp = "delete from tmpitem where itemcode='" . $_GET["cdata"] . "'";
    $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);


    $sql = "select * from s_mas where STK_NO='" . $_GET["cdata"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $sqltmp = "insert into tmpitem(itemcode, name,user_nm) values ('" . $_GET["cdata"] . "', '" . $row["DESCRIPT"] . "','" . $_SESSION["CURRENT_USER"] . "')";
        $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);
    }

    $ResponseXML = "";
    $ResponseXML .= "<mapdetails>";

    $ResponseXML .= "<rep_sel><![CDATA[<br><select multiple=\"multiple\" name=\"selectedit\" id=\"selectedit\" size=\"20\">";
    $sql = "select itemcode, name from tmpitem  where user_nm = '" . $_SESSION["CURRENT_USER"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<option id=" . $row["itemcode"] . " value=" . $row["itemcode"] . " ondblclick=\"desel_one('" . $row['itemcode'] . "');\">" . $row["itemcode"] . " " . $row["name"] . "</option>";
    }

    $ResponseXML .= "</select>]]></rep_sel>";
    $ResponseXML .= "</mapdetails>";

    echo $ResponseXML;
}


if ($_GET["Command"] == "desel_one") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $sqltmp = "delete from tmpitem where itemcode='" . $_GET["cdata"] . "'";
    $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);



    $ResponseXML = "";
    $ResponseXML .= "<mapdetails>";

    $ResponseXML .= "<rep_sel><![CDATA[<br><select multiple=\"multiple\" name=\"selectedit\" id=\"selectedit\" size=\"20\">";
    $sql = "select itemcode, name from tmpitem";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<option id=" . $row["itemcode"] . " value=" . $row["itemcode"] . " ondblclick=\"desel_one('" . $row['itemcode'] . "');\">" . $row["itemcode"] . " " . $row["name"] . "</option>";
    }

    $ResponseXML .= "</select>]]></rep_sel>";
    $ResponseXML .= "</mapdetails>";

    echo $ResponseXML;
}


if ($_GET["Command"] == "select_all_rep_true") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $sqltmp = "delete from tmpitem";
    $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);

    $ResponseXML = "";
    $ResponseXML .= "<mapdetails>";
    $ResponseXML .= "<rep_table><![CDATA[";

    $ResponseXML .= "<table width=\"450\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
  <tr>
    <td width=\"249\">";


    $sql = "select STK_NO, DESCRIPT from s_mas order by STK_NO";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {



        $ResponseXML .= "<input type=\"checkbox\"  checked=\"checked\" name=" . $row["STK_NO"] . " id=" . $row["STK_NO"] . "  onclick=\"move_sel(" . $row["STK_NO"] . ");\"/> <font color=\"#FFFFFF\"> " . $row["DESCRIPT"] . "</font></br>";
    }



    $ResponseXML .= "</td></tr></table>";
    $ResponseXML .= "]]></rep_table>";

    $sql = "select STK_NO, DESCRIPT from s_mas order by STK_NO";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $sqltmpinst = "insert into tmpitem(itemcode, name) values ('" . $row["STK_NO"] . "', '" . $row["DESCRIPT"] . "')";
        $resulttmpinst = mysqli_query($GLOBALS['dbinv'], $sqltmpinst);
    }

    $ResponseXML .= "<rep_sel><![CDATA[<select multiple=\"multiple\" name=\"available\" id=\"available\">";
    $sql = "select STK_NO, DESCRIPT from s_mas";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $ResponseXML .= "<option>" . $row["STK_NO"] . " " . $row["DESCRIPT"] . "</option>";
    }

    $ResponseXML .= "</select>]]></rep_sel>";
    $ResponseXML .= "</mapdetails>";


    echo $ResponseXML;
}

if ($_GET["Command"] == "select_all_rep_false") {
    /* 		
      header('Content-Type: text/xml');
      echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

      $sqltmp="delete from tmpselected";
      $resulttmp =mysqli_query($GLOBALS['dbinv'],$sqltmp);

      $ResponseXML = "";
      $ResponseXML .= "<mapdetails>";
      $ResponseXML .= "<rep_table><![CDATA[";

      $ResponseXML .= "<table width=\"253\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
      <tr>
      <td width=\"249\">";


      $sql="select * from user_tracking where UID=".$_SESSION["id"];
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      while($row = mysqli_fetch_array($result)){
      $sql1="select * from rep_mast where rep_id=".$row["rep_id"];
      $result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ;
      $row1 = mysqli_fetch_array($result1);


      $ResponseXML .= "<input type=\"checkbox\"  name=".$row1["IMEINo"]." id=".$row1["IMEINo"]."  onclick=\"move_sel(".$row1["IMEINo"].")\"/> <font color=\"#FFFFFF\"> ".$row1["rep_name"]."</font></br>";


      }
      $ResponseXML .= "</td></tr></table>";
      $ResponseXML .= "]]></rep_table>";

      $ResponseXML .= "<rep_sel><![CDATA[<select multiple=\"multiple\" name=\"available\" id=\"available\">";


      $ResponseXML .= "</select>]]></rep_sel>";

      $ResponseXML .= "</mapdetails>";

      echo $ResponseXML;
     */
}



if ($_GET["Command"] == "view_rep_history_rep") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $_SESSION["datefrom"] = $_GET["txtdatefrom"];
    $_SESSION["dateto"] = $_GET["txtdateto"];

    $sql = "delete from tmprep";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sqlrep = "SELECT * from tmpselected order by repname";
    $resultrep = mysqli_query($GLOBALS['dbinv'], $sqlrep);
    while ($rowrep = mysqli_fetch_array($resultrep)) {









        $cur_status = "";
        $cur_time = "";

        //$sql="SELECT * from tracking_data WHERE IMEI = '".$rowrep["imeino"]."' and mdate >='".$_GET["txtdatefrom"]."' and mdate <='".$_GET["txtdateto"]."' and (flag='I' or flag='O') order by mdate, mtime";
        $sql = "SELECT * from tracking_data WHERE IMEI = '" . $rowrep["imeino"] . "' and mdate >='" . $_GET["txtdatefrom"] . "' and mdate <='" . $_GET["txtdateto"] . "' order by mdate, mtime";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row = mysqli_fetch_array($result)) {
            if ($row["flag"] == "I") {

                $mdatetime = $row["mdate"] . " " . $row["mtime"];
                $sqli = "insert into tmprep(imei, mdate, check_in, check_in_time, check_out, check_out_time, idlefrom, idlefrom_time, idleto, idleto_time) values ('" . $rowrep["imeino"] . "', '" . $row["mdate"] . "', '" . $mdatetime . "', '" . $row["mtime"] . "', '', '', '', '', '', '')";
                $resulti = mysqli_query($GLOBALS['dbinv'], $sqli);
                $cur_status = "I";
            }

            if ($row["flag"] == "A") {

                $mdatetime = $row["mdate"] . " " . $row["mtime"];
                $sqli = "insert into tmprep(imei, mdate, check_in, check_in_time, check_out, check_out_time, idlefrom, idlefrom_time, idleto, idleto_time, location) values ('" . $rowrep["imeino"] . "', '" . $row["mdate"] . "', '', '', '', '', '" . $mdatetime . "', '" . $row["mtime"] . "', '', '', '" . $row["actual_location"] . "')";
                $resulti = mysqli_query($GLOBALS['dbinv'], $sqli);
                $cur_status = "A";
            }

            $cur_time = $row["mtime"];
        }


        $sql = "SELECT * from tracking_data WHERE IMEI = '" . $rowrep["imeino"] . "' and mdate >='" . $_GET["txtdatefrom"] . "' and mdate <='" . $_GET["txtdateto"] . "' and mtime>'" . $cur_time . "' order by mdate, mtime";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {
            if (($cur_status == "I") and ($row["flag"] == "O")) {

                $sqlmaxin = "SELECT max(check_in) maxin from tmprep where imei='" . $rowrep["imeino"] . "'";
                //echo $sqlmaxin;
                $resultmaxin = mysqli_query($GLOBALS['dbinv'], $sqlmaxin);
                $rowmaxin = mysqli_fetch_array($resultmaxin);

                $mdatetime = $row["mdate"] . " " . $row["mtime"];
                $sqli = "update tmprep set check_out='" . $mdatetime . "', check_out_time='" . $row["mtime"] . "', lat=" . $row["latitude"] . ", lon=" . $row["longtitude"] . ", remarks='" . $row["remarks"] . "' where imei='" . $rowrep["imeino"] . "' and check_in='" . $rowmaxin["maxin"] . "'";
                $resulti = mysqli_query($GLOBALS['dbinv'], $sqli);



                $sqli = "insert into tmprep(imei, mdate, check_in, check_in_time, check_out, check_out_time, idlefrom, idlefrom_time, idleto, idleto_time, location) values ('" . $rowrep["imeino"] . "', '" . $row["mdate"] . "', '', '', '', '', '" . $mdatetime . "', '" . $row["mtime"] . "', '', '', '" . $row["actual_location"] . "')";
                $resulti = mysqli_query($GLOBALS['dbinv'], $sqli);

                $cur_status = "A";
            }

            if (($cur_status == "A") and ($row["flag"] == "A")) {

                $sqlmaxin = "SELECT max(idlefrom) maxidlefrom from tmprep";
                $resultmaxin = mysqli_query($GLOBALS['dbinv'], $sqlmaxin);
                $rowmaxin = mysqli_fetch_array($resultmaxin);


                $mdatetime = $row["mdate"] . " " . $row["mtime"];

                $location = "";
                $sqlloc = "SELECT * from tmprep where imei='" . $rowrep["imeino"] . "' and idlefrom='" . $rowmaxin["maxidlefrom"] . "'";
                $resultloc = mysqli_query($GLOBALS['dbinv'], $sqlloc);
                $rowloc = mysqli_fetch_array($resultloc);

                if (is_null($row["actual_location"]) == false) {
                    $location = $rowloc["location"] . " / " . $row["actual_location"];
                }

                $sqli = "update tmprep set idleto='" . $mdatetime . "', idleto_time='" . $row["mtime"] . "', location='" . $location . "' where imei='" . $rowrep["imeino"] . "' and idlefrom='" . $rowmaxin["maxidlefrom"] . "'";

                $resulti = mysqli_query($GLOBALS['dbinv'], $sqli);

                $cur_status = "A";
            }

            if (($cur_status == "A") and ($row["flag"] == "I")) {

                $sqlmaxin = "SELECT max(idlefrom) maxidlefrom from tmprep";
                $resultmaxin = mysqli_query($GLOBALS['dbinv'], $sqlmaxin);
                $rowmaxin = mysqli_fetch_array($resultmaxin);

                $location = "";
                $sqlloc = "SELECT * from tmprep where imei='" . $rowrep["imeino"] . "' and idlefrom='" . $rowmaxin["maxidlefrom"] . "'";
                $resultloc = mysqli_query($GLOBALS['dbinv'], $sqlloc);
                $rowloc = mysqli_fetch_array($resultloc);

                if (is_null($row["actual_location"]) == false) {
                    $location = $rowloc["location"] . " / " . $row["actual_location"];
                }

                $mdatetime = $row["mdate"] . " " . $row["mtime"];
                $sqli = "update tmprep set idleto='" . $mdatetime . "', idleto_time='" . $row["mtime"] . "', location='" . $location . "' where imei='" . $rowrep["imeino"] . "' and idlefrom='" . $rowmaxin["maxidlefrom"] . "'";
                $resulti = mysqli_query($GLOBALS['dbinv'], $sqli);

                $sqli = "insert into tmprep(imei, check_in, check_out, idlefrom, idleto) values ('" . $rowrep["imeino"] . "', '" . $mdatetime . "', '', '', '')";
                $sqli = "insert into tmprep(imei, mdate, check_in, check_in_time, check_out, check_out_time, idlefrom, idlefrom_time, idleto, idleto_time) values ('" . $rowrep["imeino"] . "', '" . $row["mdate"] . "', '" . $mdatetime . "', '" . $row["mtime"] . "', '', '', '', '', '', '')";
                $resulti = mysqli_query($GLOBALS['dbinv'], $sqli);

                $cur_status = "I";
            }
        }
    }
    $ResponseXML = "";
    $ResponseXML .= "<mapdetails>";
    $ResponseXML .= "<rep_table><![CDATA[";


    $table = "";

    $sqlrep = "SELECT *  from tmpselected";
    $resultrep = mysqli_query($GLOBALS['dbinv'], $sqlrep);
    while ($rowrep = mysqli_fetch_array($resultrep)) {

        $ResponseXML .= "</br>" . $rowrep["repname"] . " <input type=\"button\" value=\"View Map\" onclick=\"view_map('" . $rowrep["imeino"] . "')\" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"images/red.png\" width=\"21\" height=\"33\"><strong>Waypoints</strong><img src=\"images/green.png\" width=\"21\" height=\"33\"> <strong>Starting and Ending Point</strong>	</br>";
        $ResponseXML .= "<table  border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
                            <tr  bgcolor=\"#333333\">
                              <td width=\"100\" align=\"center\"><font color=\"#FFFFFF\"><b>Date</b></font></span></td>
							  <td width=\"100\" align=\"center\"><font color=\"#FFFFFF\"><b>Check In</b></font></span></td>
							  <td width=\"100\" align=\"center\"><font color=\"#FFFFFF\"><b>Check Out</b></font></span></td>
							  <td width=\"100\" align=\"center\"><font color=\"#FFFFFF\"><b>Idle From</b></font></span></td>
							  <td width=\"100\" align=\"center\"><font color=\"#FFFFFF\"><b>Idle To</b></font></span></td>
                              <td width=\"200\" align=\"center\"><font color=\"#FFFFFF\"><b>Location</b></font></td>
							  <td width=\"100\" align=\"center\"><font color=\"#FFFFFF\"><b>No of min</b></font></td>
                              <td width=\"249\" align=\"center\"><font color=\"#FFFFFF\"><b>Remarks</b></font></td>
                            </tr>";

        $table .= "<table  border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
                            <tr  bgcolor=\"#333333\">
                              <td width=\"100\" align=\"center\"><font color=\"#FFFFFF\"><b>Date</b></font></span></td>
							  <td width=\"100\" align=\"center\"><font color=\"#FFFFFF\"><b>Check In</b></font></span></td>
							  <td width=\"100\" align=\"center\"><font color=\"#FFFFFF\"><b>Check Out</b></font></span></td>
							  <td width=\"100\" align=\"center\"><font color=\"#FFFFFF\"><b>Idle From</b></font></span></td>
							  <td width=\"100\" align=\"center\"><font color=\"#FFFFFF\"><b>Idle To</b></font></span></td>
                              <td width=\"200\" align=\"center\"><font color=\"#FFFFFF\"><b>Location</b></font></td>
							  <td width=\"100\" align=\"center\"><font color=\"#FFFFFF\"><b>No of min</b></font></td>
                              <td width=\"249\" align=\"center\"><font color=\"#FFFFFF\"><b>Remarks</b></font></td>
                            </tr>";

        $i = 1;




        $sql = "SELECT *  from tmprep where imei='" . $rowrep["imeino"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {
            $ResponseXML .= "<tr>
                              <td>" . $row["mdate"] . "</td>
							  <td>" . $row["check_in_time"] . "</td>
							  <td>" . $row["check_out_time"] . "</td>
							  <td>" . $row["idlefrom_time"] . "</td>
							  <td>" . $row["idleto_time"] . "</td>
							   <td>" . $row["location"] . "</td>";

            $table .= "<tr>
                              <td>" . $row["mdate"] . "</td>
							  <td>" . $row["check_in_time"] . "</td>
							  <td>" . $row["check_out_time"] . "</td>
							  <td>" . $row["idlefrom_time"] . "</td>
							  <td>" . $row["idleto_time"] . "</td>
							   <td>" . $row["location"] . "</td>";


            if ($row["check_out"] != "0000-00-00 00:00:00") {
                $diff = abs(strtotime($row["check_out"]) - strtotime($row["check_in"]));
            } else if ($row["idleto"] != "0000-00-00 00:00:00") {
                $diff = abs(strtotime($row["idleto"]) - strtotime($row["idlefrom"]));
            }

            $hours = floor($diff / (60 * 60));
            $mins = floor(($diff - $hours * 60 * 60) / (60));

            $diff_str = $hours . ":" . $mins;

            $ResponseXML .= "<td>" . $diff_str . "</td>
								<td>" . $row["remarks"] . "</td>
								</tr>";
            $table .= "<td>" . $diff_str . "</td>
								<td>" . $row["remarks"] . "</td>
								</tr>";
        }

        //if ($i==1){


        /* ========================================================== if ($row["flag"]=="I"){
          $ResponseXML .= "<tr>
          <td>".$row["mdate"]."</td>";
          $ResponseXML .= "<td>".$row["mtime"]."</td>";
          $idleto=$row["mtime"];

          $sql1="SELECT min(mtime) as mintime from tracking_data WHERE IMEI = '".$row["IMEI"]."' and mdate ='".$row["mdate"]."' and mtime >'".$row["mtime"]."' and flag='O' order by mdate, mtime";
          $result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ;
          $row1 = mysqli_fetch_array($result1);
          $ResponseXML .= "<td>".$row1["mintime"]."</td>";
          $idlefrom=$row1["mintime"];

          $sql2="SELECT * from tracking_data WHERE IMEI = '".$row["IMEI"]."' and mdate ='".$row["mdate"]."' and mtime ='".$row1["mintime"]."' and flag='O' order by mdate, mtime";
          $result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ;
          $row2 = mysqli_fetch_array($result2);
          $ResponseXML .= "<td>&nbsp;</td><td>&nbsp;</td><td>".$row2["place"]."</td>";

          $diff = abs(strtotime($row1["mintime"]) - strtotime($row["mtime"]));

          $hours = floor($diff / (60*60));
          $mins = floor(($diff - $hours * 60*60) / (60));

          $diff_str=$hours.":".$mins;
          //	$diff=get_time_difference($row["mtime"], $row1["mintime"]);

          $ResponseXML .= "<td>".$diff_str."</td>";
          $ResponseXML .= " <td>".$row2["remarks"]."</td></tr>";

          $mintime=$row1["mintime"];

          $sqlidle="SELECT min(mtime) as mintime_in from tracking_data WHERE IMEI = '".$row["IMEI"]."' and mdate ='".$row["mdate"]."' and mtime >'".$mintime."' and flag='I' ";
          $resultidle =mysqli_query($GLOBALS['dbinv'],$sqlidle);
          $rowidle = mysqli_fetch_array($resultidle);
          $idleto=$rowidle["mintime_in"];

          if ($idleto != ""){
          $diff = abs(strtotime($idleto) - strtotime($idlefrom));
          $hours = floor($diff / (60*60));
          $mins = floor(($diff - $hours * 60*60) / (60));

          $diff_str=$hours.":".$mins;

          $ResponseXML .= "<tr>
          <td>".$row["mdate"]."</td>";
          $ResponseXML .= "<td>&nbsp;</td>";
          $ResponseXML .= "<td>&nbsp;</td>";
          $ResponseXML .= "<td>".$idlefrom."</td>";
          $ResponseXML .= "<td>".$idleto."</td>";


          $location="";

          /*	$sql2="SELECT * from tracking_data WHERE IMEI = '".$row["IMEI"]."' and mdate ='".$row["mdate"]."' and mtime >='".$idlefrom."' and mtime <='".$idleto."' and flag='A' order by mdate, mtime";
          //echo $sql2;
          $result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ;
          while($row2 = mysqli_fetch_array($result2)){
          $lon=substr($row2["longtitude"], 0, 9);
          $lat=substr($row2["latitude"], 0, 8);

          $sqlloc="SELECT * from geoname_lk WHERE longitude = ".$lon." and latitude =".$lat;
          $resultloc =mysqli_query($GLOBALS['dbinv'],$sqlloc);
          if ($rowloc = mysqli_fetch_array($resultloc)){
          $location .= "  ".$rowloc["asciiname"];
          }
          }
          $ResponseXML .= "<td>".$location."</td>"; */

        /* 	$ResponseXML .= "<td>&nbsp;</td>";
          $ResponseXML .= "<td>&nbsp;</td></tr>";
          }
          } ===================================================================================================== */


        /* 		$i=2;
          } else {
          $ResponseXML .= "<tr>
          <td bgcolor=\"#cccccc\">".$row["mtime"]."</span></td>
          <td bgcolor=\"#cccccc\">".$row["place"]."</span></td>
          <td bgcolor=\"#cccccc\">".$row["remarks"]."</span></td>
          </tr>";
          $i=1;
          } */




        $ResponseXML .= "</table>";
        $table .= "</table>";
    }
    $ResponseXML .= "</br><a href=\"report/rpt_visit.xls\">Download Report</a>]]></rep_table>";

    /* 	$i=1;
      $sql="SELECT * from tracking_data WHERE IMEI = '".$_GET["imei"]."' and mdate='".$_GET["txtdate"]."' order by mtime";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      while ($row = mysqli_fetch_array($result)){

      $ResponseXML .= "<latitude".$i."><![CDATA[".$row['latitude']."]]></latitude".$i.">";
      $ResponseXML .= "<longtitude".$i."><![CDATA[".$row['longtitude']."]]></longtitude".$i.">";
      $i=$i+1;


      }
      $ResponseXML .= "<tot><![CDATA[".$i."]]></tot>"; */
    $ResponseXML .= "</mapdetails>";


    //WRITE XLS FILE
    $file = "report/rpt_visit.xls";

    $f = fopen($file, "w+");

    fwrite($f, $table);


    echo $ResponseXML;
}
?>
