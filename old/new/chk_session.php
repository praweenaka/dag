<?php

session_start();
header('Content-Type: text/xml'); 
if ($_GET['Command'] == "chk_sess") {
    $action = "ok";
    if (!isset($_SESSION['UserName'])) {
        $action = "not";
    }
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<action><![CDATA[" . $_GET['action'] . "]]></action>";
    $ResponseXML .= "<form><![CDATA[" . $_GET['form'] . "]]></form>";
    $ResponseXML .= "<stat><![CDATA[" . $action . "]]></stat>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}