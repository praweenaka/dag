<?php

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


session_start();


include_once("connectioni.php");

if ($_GET["Command"] == "save_sto") {

    //echo "insert into bankmas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')";



    $sql = mysqli_query($GLOBALS['dbinv'], "delete from s_stomas where CODE='" . $_GET["store_code"] . "'") or die(mysqli_error());
    //echo "insert into s_stomas(CODE, DESCRIPTION) values ('".$_GET["store_code"]."', '".$_GET["storename"]."')";
    if ($_GET["act"] == "true") {
        $act = 1;
    } else {
        $act = 0;
    }

    $sql = mysqli_query($GLOBALS['dbinv'], "insert into s_stomas(CODE, DESCRIPTION, act,department) values ('" . $_GET["store_code"] . "', '" . $_GET["storename"] . "', '" . $act . "','" . $_GET["depart"] . "')") or die(mysqli_error());


    $ResponseXML = "";
    $ResponseXML .= "<br>
                                        <table border=\"1\" cellspacing=\"0\">
                                        <tr><td width=\"39%\">Store Code</td>
              <td width=\"61%\">Store Name</td>
              <td width=\"61%\">Department</td>
			  <td width=\"10%\">Activate</td>
              </tr>";


    $sql = mysqli_query($GLOBALS['dbinv'], "select * from s_stomas order by CODE") or die(mysqli_error());
    while ($row = mysqli_fetch_array($sql)) {
        if ($row["CODE"] != "") {
            $ResponseXML .= "<tr>
                                            	<td width=\"155\" onclick=\"stono('" . $row['CODE'] . "', '" . $row['DESCRIPTION'] . "', '" . $row['department'] . "','" . $row['act'] . "');\">" . $row["CODE"] . "</td>
                                            	<td width=\"155\" onclick=\"stono('" . $row['CODE'] . "', '" . $row['DESCRIPTION'] . "', '" . $row['department'] . "','" . $row['act'] . "');\">" . $row["DESCRIPTION"] . "</td>
                                                <td width=\"155\" onclick=\"stono('" . $row['CODE'] . "', '" . $row['DESCRIPTION'] . "', '" . $row['department'] . "','" . $row['act'] . "');\">" . $row["department"] . "</td>
						<td width=\"155\" onclick=\"stono('" . $row['CODE'] . "', '" . $row['DESCRIPTION'] . "', '" . $row['department'] . "','" . $row['act'] . "');\">" . $row["act"] . "</td></tr>";
        }
    }



    $ResponseXML .= " </table>";



    echo $ResponseXML;
}

if ($_GET["Command"] == "delete_sto") {

    //echo "insert into bankmas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')";
    $sql = mysqli_query($GLOBALS['dbinv'], "delete from s_stomas where CODE='" . $_GET["store_code"] . "'") or die(mysqli_error());


    $ResponseXML = "";
    $ResponseXML .= "<br>
                                        <table border=\"1\" cellspacing=\"0\">
                                        <tr><td width=\"39%\">Store Code</td>
              <td width=\"61%\">Store Name</td>
			  <td width=\"10%\">Activate</td>
              </tr>";


    $sql = mysqli_query($GLOBALS['dbinv'], "select * from s_stomas order by CODE") or die(mysqli_error());
    while ($row = mysqli_fetch_array($sql)) {
        if ($row["CODE"] != "") {
            $ResponseXML .= "<tr>
                                            	<td width=\"155\" onclick=\"stono('" . $row['CODE'] . "', '" . $row['DESCRIPTION'] . "');\">" . $row["CODE"] . "</td>
                                            	<td width=\"155\" onclick=\"stono('" . $row['CODE'] . "', '" . $row['DESCRIPTION'] . "');\">" . $row["DESCRIPTION"] . "</td>
												<td width=\"155\" onclick=\"stono('" . $row['CODE'] . "', '" . $row['act'] . "');\">" . $row["act"] . "</td></tr>";
        }
    }



    $ResponseXML .= " </table>";
    echo $ResponseXML;
}
?>
