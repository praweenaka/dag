<?php

session_start();
date_default_timezone_set('Asia/Colombo');
require_once ("connection_sql.php");

if ($_POST["Command"] == "save") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql = "SELECT * from user_mast where user_name = '" . $_SESSION['CURRENT_USER'] . "'"; 
        $sql = $conn->query($sql);
        if (!$row=  $sql->fetch()) {
           exit("Not Found User..!!!");
       }


       $sql = "UPDATE user_mast set password='" . md5($_POST["psw"]) . "',password1='" . $_POST["psw"] . "' where user_name = '" . $_SESSION['CURRENT_USER'] . "'";  
       $row = $conn->query($sql);   

       $conn->commit();
       echo "Saved";
   } catch (Exception $e) {
    $conn->rollBack();
    echo $e;
}

}
?>
