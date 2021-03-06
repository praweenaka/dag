<?php

ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60*60);
session_start();


$UserName = $_GET["UserName"];
$Password = $_GET["Password"];
$Command = $_GET["Command"];

require_once("connectioni.php");
date_default_timezone_set('Asia/Colombo');



if ($Command == "CheckUsers") {

    $sql = "SELECT * FROM user_mast WHERE user_name =  '" . $UserName . "' AND user_pass =  '" . md5($Password) . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    if ($row = mysqli_fetch_array($result)) {

        $today = date('Y-m-d');

        if ((strtotime($today) < strtotime($row['exp_date']))) {
            echo "ok";


            $sql1 = "SELECT * FROM invpara";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            $row1 = mysqli_fetch_array($result1);
            if ($row1["flag"] == "BEN") {
                $_SESSION['company'] = "BEN";
            } else if ($row1["flag"] == "TRAD") {
                $_SESSION['company'] = "THT";
            }
            //$_SESSION['company']="THT";
            $sessionId = session_id();
            $_SESSION['sessionId'] = session_id();
            session_regenerate_id();
            $ip = $_SERVER['REMOTE_ADDR'];
            $_SESSION['UserName'] = $UserName;
            $_SESSION["CURRENT_USER"] = $UserName;
            if (is_null($row["sal_dep"]) == false) {
                $_SESSION["CURRENT_DEP"] = $row["sal_dep"];
            } else {
                $_SESSION["CURRENT_DEP"] = "";
            }
            $_SESSION['User_Type'] = $row['user_level'];

            $sql_master = "select * from invpara";
            $result_master = mysqli_query($GLOBALS['dbinv'], $sql_master);
            $row_master = mysqli_fetch_array($result_master);
            if ($row_master["master_dev"] == "0") {
                $_SESSION['dev'] = $row['dev'];
            } else {
                $_SESSION['dev'] = "0";
            }
            $sql_manager = "select * from user_mast where user_name ='" . $UserName . "' ";
            $result_manager = mysqli_query($GLOBALS['dbinv'], $sql_manager);
            $row_manager = mysqli_fetch_array($result_manager);
//            echo $row_manager['managermain'];
            if ($row_manager["managermain"] != "") {
                $_SESSION['MANAGER'] = $row_manager['managermain'];
            } else {
                $_SESSION['MANAGER'] = "";
            }

            if ($row_manager["department"] != "") {
                $_SESSION['department'] = $row_manager['department'];
            } else {
                $_SESSION['department'] = "";
            }

            if (is_null($row["sal_ex"]) == false) {
                $_SESSION["CURRENT_REP"] = $row["sal_ex"];
            } else {
                $_SESSION["CURRENT_REP"] = "";
            }
            $Devcheck = 0;


            $time_now = mktime(date('h') + 5, date('i') + 30, date('s'));
            $time = date('Y-m-d H:i:s');
            $today = date('Y-m-d');


            $sql1 = "Insert into loging(Name,User_Type,Date,Logon_Time,Sessioan_Id,ip) values ('" . $UserName . "','" . $_SESSION['User_Type'] . "','" . $today . "','" . $time . "','" . $_SESSION['sessionId'] . "','" . $ip . "')";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        } else {
            echo "Your Password Has Expired";
        }
    }
} else if ($Command == "logout") {



    echo $_SESSION['sessionId'];

    $time_now = mktime(date('h') + 5, date('i') + 30, date('s'));
//		$time=date('h:i:s',$time_now);
    $time = date('Y-m-d H:i:s');
    $today = date('Y-m-d');


    $sql = "UPDATE loging
			  SET Logout_Time='" . $time . "'
			  WHERE Sessioan_Id='" . $_SESSION['sessionId'] . "'";


    $result = mysqli_query($GLOBALS['dbinv'], $sql);


    $sqlDelete = "Delete FROM active_users
			  where Sessioan_Id='" . $_SESSION['sessionId'] . "'";
    $resultDelete = mysqli_query($GLOBALS['dbinv'], $sqlDelete);



    session_unset();
    session_destroy();
} else if ($Command == "setdiv") {

    session_unset();
    session_destroy();
    $_SESSION['UserName'] = "";
    $_SESSION["CURRENT_USER"] = "";
    $_SESSION['User_Type'] = "";
    $_SESSION['dev'] = "";


    if ($_GET["activ"] == "true") {
        $_SESSION["master_dev"] = 1;
    } else {
        $_SESSION["master_dev"] = 0;
    }

    $sql_rsuser = "update invpara set master_dev='" . $_SESSION["master_dev"] . "'";
    $result_rsuser = mysqli_query($GLOBALS['dbinv'], $sql_rsuser);
    echo "UserName-" . $_SESSION['UserName'];
    echo "dev-" . $_SESSION['dev'];
}

if ($_GET["Command"] == "click") {
    $sqls_submas = "update s_cheq set clicked='1' where CR_CHNO= '" . $_GET["chkno"]. "'  "; 
     $result_rsuser = mysqli_query($GLOBALS['dbinv'], $sqls_submas);
}
?>