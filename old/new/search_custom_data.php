<?php

session_start();

include_once './connection_sql.php';

if ($_GET["Command"] == "pass_quot") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];
    $rep = $_SESSION["refRep"];

//    $cuscode = "X03";
//    $rep = 64;

    $sql = "Select * from vendor where code='" . $cuscode . "' ";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<str_customername><![CDATA[" . $row['NAME'] . "]]></str_customername>";
        $cusName = $row['NAME'];
        $sql = "Select sum(GRAND_TOT-TOTPAY) as outst from s_salma where  
                C_CODE='" . $cuscode . "' and CANCELL='0' 
                and GRAND_TOT-TOTPAY>1 
                and SAL_EX='" . $rep . "'";


        $sql = $conn->query($sql);
        if ($row = $sql->fetch()) {
            if ($row['outst'] != "") {
                $ResponseXML .= "<outst><![CDATA[" . $row['outst'] . "]]></outst>";
            } else {
                $ResponseXML .= "<outst><![CDATA[0]]></outst>";
            }
        }

        $sql = "select sum(cr_cheval - paid) as retch from s_cheq
                where CR_FLAG = '0'
                and CR_C_CODE = '$cuscode'
                and cr_cheval - paid>1
                and S_REF = '" . $rep . "'";

        $sql = $conn->query($sql);
        if ($row = $sql->fetch()) {
            if ($row['retch'] != "") {
                $ResponseXML .= "<retch><![CDATA[" . $row['retch'] . "]]></retch>";
            } else {
                $ResponseXML .= "<retch><![CDATA[0]]></retch>";
            }
        }

        $sql = "select sum(target) as target from week_tragets
                where month(tardate) = '" . date('m') . "' and year(tardate) ='" . date('Y') . "'
                and cus_code = '$cuscode'
                 
                and rep = '" . $rep . "'";

        $sql = $conn->query($sql);
        if ($row = $sql->fetch()) {
            if ($row['target'] != "") {
                $ResponseXML .= "<target><![CDATA[" . $row['target'] . "]]></target>";
            } else {
                $ResponseXML .= "<target><![CDATA[0]]></target>";
            }
        }
    }


    $ResponseXML .= "<outstCltd><![CDATA[0]]></outstCltd>";
    $ResponseXML .= "<retchStld><![CDATA[0]]></retchStld>";
    $ResponseXML .= "<stname><![CDATA[" . $_GET['stname'] . "]]></stname>";
    $date = date("Y-m-d");
    $link1 = "../report_customer_current_summery_details_1.php?cuscode=$cuscode&cusname=$cusName&radio=optout&cmbGRNtype=All&cmbrep=$rep&cmbbrand1=All&brand=All&button=View";

    $links = "<div class=\"form-group\">
                    <a href=\"$link1\" target=\"_blank\" class=\"btn btn-primary btn-sm\">
                        <span class=\"fa fa-user-plus\"></span> &nbsp; Current Status
                    </a>
                </div>";

    $ResponseXML .= "<remtable><![CDATA[$links<table class='table table-hover'>";


    $refRep = $_SESSION["refRep"];

    $phrase = "and rep = '$refRep'";

    if ($refRep == "All") {

        $phrase = "";
    }
    $table = "dlr_sch";
    if ($_GET["stname"] == "") {
        $table = "dlr_rmk";
    }

    $sql = "SELECT * from $table where c_code = '$cuscode' $phrase order by date desc";


    $ResponseXML .= "<tr>";

    $ResponseXML .= "<td style=\"width: 350px;\">Dealer C.</td>";

    $ResponseXML .= "<td style=\"width: 350px;\">Name</td>";
    if ($_GET["stname"] == "") {
        $ResponseXML .= "<td style=\"width: 350px;\">Outstanding Collected</td>";
        $ResponseXML .= "<td style=\"width: 350px;\">Return Cheques Collected</td>";
    } else {
        $ResponseXML .= "<td style=\"width: 350px;\">Outstanding to be collected</td>";
        $ResponseXML .= "<td style=\"width: 350px;\">Return Cheques to be collected</td>";
    }

    $ResponseXML .= "<td style=\"width: 350px;\">Date</td>";

    $ResponseXML .= "<td style=\"width: 350px;\">Remark</td>";

    if ($_GET["stname"] == "") {
        $ResponseXML .= "<td style=\"width: 350px;\">Location</td>";

        $ResponseXML .= "<td style=\"width: 350px;\">Target Col.</td>";

        $ResponseXML .= "<td style=\"width: 350px;\">New Ord.</td>";
    }


    $ResponseXML .= "</tr>";



    /* foreach ($conn->query($sql) as $row) {

      $ResponseXML .= "<tr>";

      $ResponseXML .= "<td>" . $row['c_code'] . "</td>";

      $ResponseXML .= "<td>" . $row['c_name'] . "</td>";

      $ResponseXML .= "<td>" . $row['outstCltd'] . "</td>";

      $ResponseXML .= "<td>" . $row['retchStld'] . "</td>";

      $ResponseXML .= "<td>" . $row['date'] . "</td>";

      $ResponseXML .= "<td>" . $row['remark'] . "</td>";
      if ($_GET["stname"] == "") {
      $ResponseXML .= "<td>" . $row['loc'] . "</td>";

      $ResponseXML .= "<td>" . $row['tgt'] . "</td>";

      $ResponseXML .= "<td>" . $row['ord'] . "</td>";
      }
      $ResponseXML .= "</tr>";
      } */

    $ResponseXML .= "</table>]]></remtable>";



    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_dlr_shr") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];


    $sql = "Select * from vendor where code='" . $cuscode . "' ";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<str_customername><![CDATA[" . $row['NAME'] . "]]></str_customername>";
    }


    $ResponseXML .= "<remtable><![CDATA[<table class='table table-hover'>";


    $sql = "SELECT * from dlr_shr where c_code = '$cuscode' order by date desc";

//    echo $sql;



    $ResponseXML .= "<tr>";

    $ResponseXML .= "<td style=\"width: 350px;\">Dealer C.</td>";
    $ResponseXML .= "<td style=\"width: 350px;\">Name</td>";
    $ResponseXML .= "<td style=\"width: 350px;\">Date</td>";
    $ResponseXML .= "<td style=\"width: 350px;\">RefNo</td>";
    $ResponseXML .= "<td style=\"width: 350px;\">Amount</td>";
    $ResponseXML .= "<td style=\"width: 350px;\">Remark</td>";

    $ResponseXML .= "</tr>";



    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>";

        $ResponseXML .= "<td>" . $row['c_code'] . "</td>";
        $ResponseXML .= "<td>" . $row['c_name'] . "</td>";
        $ResponseXML .= "<td>" . $row['date'] . "</td>";
        $ResponseXML .= "<td>" . $row['refno'] . "</td>";
        $ResponseXML .= "<td>" . $row['amt'] . "</td>";
        $ResponseXML .= "<td>" . $row['remark'] . "</td>";

        $ResponseXML .= "</tr>";
    }

    $ResponseXML .= "</table>]]></remtable>";



    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_dlr_acc") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];


    $sql = "Select * from vendor where code='" . $cuscode . "' ";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<str_customername><![CDATA[" . $row['NAME'] . "]]></str_customername>";
    }

    $sql = "select * from user_mast_dlr where dlr_code = '" . $cuscode . "' ";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        $ResponseXML .= "<isRegistered><![CDATA[yes]]></isRegistered>";
        $ResponseXML .= "<user_name><![CDATA[" . $row["user_name"] . "]]></user_name>";
    } else {
        $ResponseXML .= "<isRegistered><![CDATA[no]]></isRegistered>";
    }



    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_info") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];

    $sql = "select * from dlr_inf where c_code = '$cuscode' and date = '" . date('Y-m-d') . "'";
    $sql = $conn->query($sql);
    $count = $sql->rowCount();

    if ($count > 0) {
        $ResponseXML .= "<terminate><![CDATA[yes]]></terminate>";
    } else {
        $ResponseXML .= "<terminate><![CDATA[no]]></terminate>";
        $sql = "Select * from vendor where code='" . $cuscode . "' ";
        $sql = $conn->query($sql);
        if ($row = $sql->fetch()) {
            $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
            $ResponseXML .= "<str_customername><![CDATA[" . $row['NAME'] . "]]></str_customername>";
        }
    }
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "search_custom") {
    $ResponseXML = "";
    $ResponseXML .= "<table   class=\"table table-bordered\">
                            <tr>
                    <th width=\"121\"  >Customer No</th>
                    <th width=\"424\"  >Customer Name</th>
                    <th width=\"300\"  >Address</th>

                </tr>";

    if ($_GET["mstatus"] == "cusno") {
        $letters = $_GET['cusno'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select code,name,add1 from vendor where  code like '%$letters%' ";
    } else if ($_GET["mstatus"] == "customername") {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select code,name,add1 from vendor where  name like '%$letters%' ";
    } else {

        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select code,name,add1 from vendor where  name like '%$letters%' ";
    }
    $sql .= " ORDER BY code limit 50";


    foreach ($conn->query($sql) as $row) {
        $cuscode = $row['code'];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['code'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['name'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['add1'] . "</a></td>
                            </tr>";
    }


    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}


if ($_GET["Command"] == "pass_transpay") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $_SESSION["trans_user"]="";
    $cuscode = $_GET["custno"]; 
    $sql = "Select * from vendor where CODE='" . $cuscode . "' "; 
    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        
        $_SESSION["trans_user"]=$row['CODE'];
        $ResponseXML .= "<code><![CDATA[" . $row['CODE'] . "]]></code>";
        $ResponseXML .= "<name><![CDATA[" . $row['NAME'] . "]]></name>";
        $ResponseXML .= "<town><![CDATA[" . $row['ADD1'] . "]]></town>";
    }
     
     
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}
?>
