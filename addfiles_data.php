<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_POST["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT addfile FROM invpara";
    $result = $conn->query($sql);

    $row = $result->fetch();
    $no = $row['addfile'];
    $uniq = uniqid();
    $ResponseXML .= "<id><![CDATA[$no]]></id>";
    $ResponseXML .= "<uniq><![CDATA[$uniq]]></uniq>";

    $ResponseXML .= "</new>";

    echo $ResponseXML;
}


if ($_POST["Command"] == "imageup") {
    $target_dir = "upload/";

    $mrefno = str_replace("/", "-", "hfghf");

    $target_dir = $target_dir;
    if (!file_exists($target_dir)) {
        if (mkdir($target_dir, 0777, true)) {

        }
    }

    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    $mok = "no";
    if (file_exists($target_file)) {
        $mok = "no";
    } else {
        $mok = "ok";
    }


    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    if ($mok = "ok") {

        try {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->beginTransaction();

            $sql2 = "insert into s_addfiles(batch,company, user, sdate, file) values ('" . $_POST['batchno'] . "', '" . $_SESSION["company"] . "', '" . $_SESSION["CURRENT_USER"] . "', '" . date("Y-m-d H:i:s") . "', '" . $target_file . "')";
            $result2 = $conn->query($sql2);


            $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_POST['batchno'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'File Add', 'SAVE', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $result2 = $conn->query($sql2);

            $conn->commit();
            echo "Saved";
        } catch (Exception $e) {
            $conn->rollBack();
            echo $e;
        }
    } else {
        echo "Sorry, file already exists";
    }
}
?>