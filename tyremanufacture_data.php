
<?php

session_start();


require_once ("connection_sql.php");
header('Content-Type: text/xml');
date_default_timezone_set('Asia/Colombo');
if ($_POST["Command"] == "uptype") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        

        $sql = "UPDATE t_jobcard set PEN='" . $_POST['pen'] . "',STEP='5'  where id='" . $_POST['id'] . "'";
        $result = $conn->query($sql);

        

        $conn->commit();
        echo "Updated";

    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}


if ($_POST["Command"] == "uptype1") {

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $i = 1;

        $count = $_POST['count'];
        while ($_POST["count"] > $i) {
            $id = "id" . $i;
            $pen = "pen" . $i; 
 
            $sql = "UPDATE t_jobcard set PEN='" . $_POST[$price] . "',STEP='5'  where id='" . $_POST[$id]  . "'";
            $result = $conn->query($sql);
            $i = $i + 1;
        }

        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

?>