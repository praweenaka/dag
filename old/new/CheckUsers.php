<?php

session_start();


$UserName = $_GET["UserName"];
$Password = $_GET["Password"];
$Command = $_GET["Command"];
include './connectioni.php';
header('Content-Type: text/xml');
if ($Command == "CheckUsers") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<action><![CDATA[" . $_GET['action'] . "]]></action>";
    $ResponseXML .= "<form><![CDATA[" . $_GET['form'] . "]]></form>";
    $sql = "SELECT * FROM user_mast WHERE user_name =  '" . $UserName . "' and user_pass =  '" . md5($Password) . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    if ($row = mysqli_fetch_array($result)) {

        $sessionId = session_id();
        $_SESSION['sessionId'] = session_id();
        session_regenerate_id();
        $ip = $_SERVER['REMOTE_ADDR'];
        $_SESSION['UserName'] = $UserName;
        $_SESSION["CURRENT_USER"] = $UserName;
        $_SESSION['User_Type'] = $row['dev'];

        if (is_null($row["sal_ex"]) == false) {
            $_SESSION["CURRENT_DEP"] = $row["sal_dep"];
        } else {
            $_SESSION["CURRENT_DEP"] = "";
        }

        if (is_null($row["sal_ex"]) == false) {
            $_SESSION["CURRENT_REP"] = $row["sal_ex"];
        } else {
            $_SESSION["CURRENT_REP"] = "";
        }

        $action = "ok";

        $ResponseXML .= "<stat><![CDATA[" . $action . "]]></stat>";



        $time_now = mktime(date('h') + 5, date('i') + 30, date('s'));
        $time = date("g.i a", time());
        $today = date('Y-m-d');
        $sql1 = "Insert into loging(Name,User_Type,Date,Logon_Time,Sessioan_Id,ip) values ('" . $UserName . "','" . $_SESSION['User_Type'] . "','" . $today . "','" . $time . "','" . $_SESSION['sessionId'] . "','" . $ip . "')";
    } else {
        $action = "not";
        $ResponseXML .= "<stat><![CDATA[" . $action . "]]></stat>";
        $ResponseXML .= "</salesdetails>";
        echo $ResponseXML;
    }
}

if ($Command == "logout") {


    echo $_SESSION['sessionId'];

    $time_now = mktime(date('h') + 5, date('i') + 30, date('s'));
    $time = date('h:i:s', $time_now);
    $today = date('Y-m-d');

    session_unset();
    session_destroy();
}
?>