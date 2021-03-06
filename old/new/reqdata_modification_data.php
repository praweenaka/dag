<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("./connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_GET["Command"] == "getdt") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT reqmodi FROM invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();
    $no = $row['reqmodi'];
    $uniq = uniqid();
    $ResponseXML .= "<id><![CDATA[$no]]></id>";
    $ResponseXML .= "<uniq><![CDATA[$uniq]]></uniq>";
    $ResponseXML .= "</new>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "save_item") {

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();


        $sql = "SELECT reqmodi FROM invpara";
        $result = $conn->query($sql);
        $row = $result->fetch();
        $idno = $row['reqmodi'];


        if (strlen($idno) == 1) {
            $idno = "REQM/0000" . $idno;
        } else if (strlen($idno) == 2) {
            $idno = "REQM/000" . $idno;
        } else if (strlen($idno) == 3) {
            $idno = "REQM/00" + $idno;
        } else if (strlen($idno) == 4) {
            $idno = "REQM/0" + $idno;
        } else if (strlen($idno) == 5) {
            $idno = "REQM/" + $idno;
        }

        $sql = "SELECT * from requestdatamodi where cancel ='0'   and code  = '" . $_GET['code'] . "'";
        $sql = $conn->query($sql);
        if ($row = $sql->fetch()) {
            exit("Can't Save...!!!");
        }

        $sqlbrand = "insert into requestdatamodi(code,uniq, reqby, des, sdate,user) values ('" . $idno . "','" . $_GET['uniq'] . "', '" . $_GET['reqby'] . "', '" . $_GET['des'] . "', '" . date("Y-m-d") . "','" . $_SESSION["CURRENT_USER"] . "')";
        $resultbrand = $conn->query($sqlbrand);

        $sqlbrand1 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $idno . "', '" . $_SESSION["CURRENT_USER"] . "', 'Request Data Modifications ', '" . $_GET['des'] . " Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $resultbrand1 = $conn->query($sqlbrand1);

        $sql = "SELECT reqmodi FROM invpara";
        $result = $conn->query($sql);
        $row = $result->fetch();
        $no = $row['reqmodi'];
        $no2 = $no + 1;
        $sql = "update invpara set reqmodi = $no2 where reqmodi = $no";
        $result = $conn->query($sql);

        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}


if ($_GET["Command"] == "pass_quot") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];

    $sql = "Select * from requestdatamodi where code='" . $cuscode . "' ";

    $ResponseXML .= "<stname><![CDATA[" . $_GET['stname'] . "]]></stname>";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        $ResponseXML .= "<code><![CDATA[" . $cuscode . "]]></code>";
        $ResponseXML .= "<sdate><![CDATA[" . $row['sdate'] . "]]></sdate>";
        $ResponseXML .= "<reqby><![CDATA[" . $row['reqby'] . "]]></reqby>";
        $ResponseXML .= "<des><![CDATA[" . $row['des'] . "]]></des>";
        $ResponseXML .= "<uniq><![CDATA[" . $row['uniq'] . "]]></uniq>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "search_custom") {


    $ResponseXML = "";

    $ResponseXML .= "<table   class=\"table table-bordered\">
                <tr>
                    <th width=\"121\">Code</th>
                    <th width=\"100\">Req By</th>
                    <th width=\"100\">Description</th>
                    <th width=\"100\">Sdate</th>
                </tr>";

    $sql = "select * from requestdatamodi where cancel='0' and code <> ''";
    if ($_GET["code"] != "") {
        $sql .= " and code like '" . Trim($_GET["code"]) . "%'";
    }
    if ($_GET["reqby"] != "") {
        $sql .= " and reqby like '" . Trim($_GET["reqby"]) . "%'";
    }
    if ($_GET["des"] != "") {
        $sql .= " and des like '" . Trim($_GET["des"]) . "%'";
    }

    foreach ($conn->query($sql) as $row) {
        $cuscode = $row['code'];
        $ResponseXML .= "<tr>               
                <td onclick=\"custno('" . $row['code'] . "','" . $stname . "');\">" . $row['code'] . "</a></td>
                                  <td onclick=\"custno('" . $row['code'] . "','" . $stname . "');\">" . $row['reqby'] . "</a></td>
                              <td onclick=\"custno('" . $row['code'] . "','" . $stname . "');\">" . $row['des'] . "</a></td>
                              <td onclick=\"custno('" . $row['code'] . "','" . $stname . "');\">" . $row['sdate'] . "</a></td>
                                  
                  </tr>";
    }


    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}


if ($_GET["Command"] == "cancelinv") {

    $sql = "update requestdatamodi set cancel = '1' where code = '" . $_GET["code"] . "'";
    $result = $conn->query($sql);
    echo "Cancel";
}