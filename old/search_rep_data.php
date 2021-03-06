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


if ($_GET["Command"] == "chk_number") {

    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_salrep where REPCODE=" . $_GET["txtcode"]) or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        echo "included";
    } else {
        echo "no";
    }
}


if ($_GET["Command"] == "search_inv") {

    $ResponseXML .= "";
//$ResponseXML .= "<invdetails>";



    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Sales Rep No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rep Name</font></td>
                             
   							</tr>";

    if ($_GET["mstatus"] == "repno") {
        $letters = $_GET['repno'];
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $letters);
//$letters="/".$letters;
        $a = "SELECT * from s_salrep where REPCODE like  '$letters%'";
//echo $a;
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_salrep where REPCODE like  '$letters%'") or die(mysqli_error());
    } else if ($_GET["mstatus"] == "repname") {
        $letters = $_GET['repname'];
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_salrep where Name like  '$letters%'") or die(mysqli_error()) or die(mysqli_error());
    } else {

        $letters = $_GET['repname'];
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_salrep where Name like  '$letters%'") or die(mysqli_error()) or die(mysqli_error());
    }



    while ($row = mysqli_fetch_array($sql)) {
        $repcode = $row['REPCODE'];
        $stname = "sal_inv";
        $ResponseXML .= "<tr>
                           	  <td onclick=\"repno('$repcode', '$stname');\">" . $row['REPCODE'] . "</a></td>
                              <td onclick=\"repno('$repcode', '$stname');\">" . $row['Name'] . "</a></td>
                                                                            	
                            </tr>";
    }

    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}


if ($_GET["Command"] == "pass_repno") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $repno = $_GET['repno'];
    $_SESSION["repno"] = $_GET['repno'];
//$tmpinvno="0000".substr($_GET['invno'], 4, 7) ;
//$lenth=strlen($tmpinvno);
//$serial=substr($tmpinvno, $lenth-7);
//$inv=substr($_GET['invno'], 0, 3).substr("\ ", 0, 1).$serial;
    $a = "Select * from s_salrep where REF_NO='" . $repno . "'";
//echo $a;
    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_salrep where REPCODE=" . $repno) or die(mysqli_error());

    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<repcode><![CDATA[" . $row['REPCODE'] . "]]></repcode>";
        $ResponseXML .= "<repname><![CDATA[" . $row['Name'] . "]]></repname>";
        $ResponseXML .= "<target><![CDATA[" . $row['target'] . "]]></target>";
        $ResponseXML .= "<group><![CDATA[" . trim($row['RGROUP']) . "]]></group>";
		$ResponseXML .= "<group1><![CDATA[" . trim($row['RGROUP1']) . "]]></group1>";
		$ResponseXML .= "<group2><![CDATA[" . trim($row['RGROUP2']) . "]]></group2>";
        $ResponseXML .= "<cancel><![CDATA[" . $row['cancel'] . "]]></cancel>";


        $mok1 = "0";
        $sql = "select * from com_tabale_dis_del where repcode ='" . $row['REPCODE'] . "'";
        $result_s = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row_s = mysqli_fetch_array($result_s)) {
            $mok1 = "1";
            $ResponseXML .= "<tdam1><![CDATA[" . $row_s['tar1_amount_de'] . "]]></tdam1>";
            $ResponseXML .= "<tdamr1><![CDATA[" . $row_s['tar1_rate_de'] . "]]></tdamr1>";

            $ResponseXML .= "<tdam2><![CDATA[" . $row_s['tar2_amount_de'] . "]]></tdam2>";
            $ResponseXML .= "<tdamr2><![CDATA[" . $row_s['tar2_rate_de'] . "]]></tdamr2>";

            $ResponseXML .= "<tdam3><![CDATA[" . $row_s['tar3_amount_de'] . "]]></tdam3>";
            $ResponseXML .= "<tdamr3><![CDATA[" . $row_s['tar3_rate_de'] . "]]></tdamr3>";


            $ResponseXML .= "<tdisam1><![CDATA[" . $row_s['tar1_amount_di'] . "]]></tdisam1>";
            $ResponseXML .= "<tdisar1><![CDATA[" . $row_s['tar1_rate_di'] . "]]></tdisar1>";

            $ResponseXML .= "<tdisam2><![CDATA[" . $row_s['tar2_amount_di'] . "]]></tdisam2>";
            $ResponseXML .= "<tdisar2><![CDATA[" . $row_s['tar2_rate_di'] . "]]></tdisar2>";

            $ResponseXML .= "<tdisam3><![CDATA[" . $row_s['tar3_amount_di'] . "]]></tdisam3>";
            $ResponseXML .= "<tdisar3><![CDATA[" . $row_s['tar3_rate_di'] . "]]></tdisar3>";
        }
        $ResponseXML .= "<mok1><![CDATA[" . $mok1 . "]]></mok1>";

        $ok2 = "0";
        $sql = "select * from sal_comm_new where sal_ex ='" . $row['REPCODE'] . "' ";

        $result_s = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row_s = mysqli_fetch_array($result_s)) {
            $mok2 = "1";
            $mgroup = trim($row_s['D_group']);
            if ($mgroup == "Tyres") {
                $ResponseXML .= "<T1><![CDATA[" . $row_s['T1'] . "]]></T1>";
                $ResponseXML .= "<TP1><![CDATA[" . $row_s['P1'] . "]]></TP1>";

                $ResponseXML .= "<T2><![CDATA[" . $row_s['T2'] . "]]></T2>";
                $ResponseXML .= "<TP2><![CDATA[" . $row_s['P2'] . "]]></TP2>";

                $ResponseXML .= "<T3><![CDATA[" . $row_s['T3'] . "]]></T3>";
                $ResponseXML .= "<TP3><![CDATA[" . $row_s['P3'] . "]]></TP3>";
            }

            if ($mgroup == "Battery") {

                $ResponseXML .= "<B1><![CDATA[" . $row_s['T1'] . "]]></B1>";
                $ResponseXML .= "<BP1><![CDATA[" . $row_s['P1'] . "]]></BP1>";

                $ResponseXML .= "<B2><![CDATA[" . $row_s['T2'] . "]]></B2>";
                $ResponseXML .= "<BP2><![CDATA[" . $row_s['P2'] . "]]></BP2>";

                $ResponseXML .= "<B3><![CDATA[" . $row_s['T3'] . "]]></B3>";
                $ResponseXML .= "<BP3><![CDATA[" . $row_s['P3'] . "]]></BP3>";
            }
        }
        $ResponseXML .= "<mok2><![CDATA[" . $mok2 . "]]></mok2>";





        $ResponseXML .= "<target_table><![CDATA[ <table width=\"712\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          			<tr>
           			 <td width=\"66\">Code</td>
           			 <td width=\"327\">Name</td>
            		 <td width=\"159\">Target</td>
            		 <td width=\"132\">Last Update</td>
         			 </tr>";

        $sql1 = mysqli_query($GLOBALS['dbinv'], "Select * from dealer_target where rep='" . $repno . "' order by cus_code") or die(mysqli_error());
        while ($row1 = mysqli_fetch_array($sql1)) {
            $cus_code = $row1["cus_code"];
            $name = $row1["name"];
            $target = $row1["target"];

            $ResponseXML .= "<tr>
            						<td onclick=\"showtarget('$cus_code', '$name', '$target');\">" . $row1["cus_code"] . "</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">" . $row1["name"] . "</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">" . number_format($row1["target"], 2, ".", ",") . "</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">" . $row1["ldate"] . "</td>
									</tr>";
        }

        $ResponseXML .= "   </table>]]></target_table>";


        $ResponseXML .= "<target_table_s><![CDATA[ <table width=\"712\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          			<tr>
           			 <td width=\"66\">Code</td>
           			 <td width=\"327\">Name</td>
            		 <td width=\"159\">Target</td>
            		 <td width=\"132\">Last Update</td>
         			 </tr>";
        $sql1 = mysqli_query($GLOBALS['dbinv'], "Select * from dealer_target_s where rep='" . $repno . "' order by cus_code") or die(mysqli_error());
        while ($row1 = mysqli_fetch_array($sql1)) {
            $cus_code = $row1["cus_code"];
            $name = $row1["name"];
            $target = $row1["target"];

            $ResponseXML .= "<tr>
            						<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">" . $row1["cus_code"] . "</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">" . $row1["name"] . "</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">" . number_format($row1["target"], 2, ".", ",") . "</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">" . $row1["ldate"] . "</td>
									</tr>";
        }





        $ResponseXML .= "   </table>]]></target_table_s>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "savetarget") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from dealer_target where rep='" . $_GET["repno"] . "' and cus_code='" . $_GET["cuscode"] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $sql1 = mysqli_query($GLOBALS['dbinv'], "update dealer_target set target=" . $_GET["target"] . ", ldate='" . date("d-m-Y") . "' where rep='" . $_GET["repno"] . "' and  cus_code='" . $_GET["cuscode"] . "'") or die(mysqli_error());
    } else {
//	echo "insert into dealer_target(rep, cus_code, name, target, ldate) values ('".$_GET["repno"]."', '".$_GET["cuscode"]."', '".$_GET["name"]."', ".$_GET["target"].", '".date("d-m-Y")."'";
        $sql1 = mysqli_query($GLOBALS['dbinv'], "insert into dealer_target(rep, cus_code, name, target, ldate) values ('" . $_GET["repno"] . "', '" . $_GET["cuscode"] . "', '" . $_GET["name"] . "', " . $_GET["target"] . ", '" . date("d-m-Y") . "')") or die(mysqli_error());
    }

    $ResponseXML .= "<target_table><![CDATA[ <table width=\"712\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          			<tr>
           			 <td width=\"66\">Code</td>
           			 <td width=\"327\">Name</td>
            		 <td width=\"159\">Target</td>
            		 <td width=\"132\">Last Update</td>
         			 </tr>";

    $sql1 = mysqli_query($GLOBALS['dbinv'], "Select * from dealer_target where rep='" . $_GET["repno"] . "' order by cus_code") or die(mysqli_error());
    while ($row1 = mysqli_fetch_array($sql1)) {
        $cus_code = $row1["cus_code"];
        $name = $row1["name"];
        $target = $row1["target"];

        $ResponseXML .= "<tr>
            						<td onclick=\"showtarget('$cus_code', '$name', '$target');\">" . $row1["cus_code"] . "</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">" . $row1["name"] . "</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">" . number_format($row1["target"], 2, ".", ",") . "</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">" . $row1["ldate"] . "</td>
									</tr>";
    }

    $ResponseXML .= "   </table>]]></target_table>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "savetarget_s") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from dealer_target_s where rep='" . $_GET["repno"] . "' and cus_code='" . $_GET["cuscode"] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $sql1 = mysqli_query($GLOBALS['dbinv'], "update dealer_target_s set target=" . $_GET["target"] . ", ldate='" . date("d-m-Y") . "' where rep='" . $_GET["repno"] . "' and  cus_code='" . $_GET["cuscode"] . "'") or die(mysqli_error());
    } else {
//	echo "insert into dealer_target(rep, cus_code, name, target, ldate) values ('".$_GET["repno"]."', '".$_GET["cuscode"]."', '".$_GET["name"]."', ".$_GET["target"].", '".date("d-m-Y")."'";
        $sql1 = mysqli_query($GLOBALS['dbinv'], "insert into dealer_target_s(rep, cus_code, name, target, ldate) values ('" . $_GET["repno"] . "', '" . $_GET["cuscode"] . "', '" . $_GET["name"] . "', " . $_GET["target"] . ", '" . date("d-m-Y") . "')") or die(mysqli_error());
    }

    $ResponseXML .= "<target_table><![CDATA[ <table width=\"712\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          			<tr>
           			 <td width=\"66\">Code</td>
           			 <td width=\"327\">Name</td>
            		 <td width=\"159\">Target</td>
            		 <td width=\"132\">Last Update</td>
         			 </tr>";

    $sql1 = mysqli_query($GLOBALS['dbinv'], "Select * from dealer_target_s where rep='" . $_GET["repno"] . "' order by cus_code") or die(mysqli_error());
    while ($row1 = mysqli_fetch_array($sql1)) {
        $cus_code = $row1["cus_code"];
        $name = $row1["name"];
        $target = $row1["target"];

        $ResponseXML .= "<tr>
            						<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">" . $row1["cus_code"] . "</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">" . $row1["name"] . "</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">" . number_format($row1["target"], 2, ".", ",") . "</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">" . $row1["ldate"] . "</td>
									</tr>";
    }

    $ResponseXML .= "   </table>]]></target_table>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "deletetarget") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = mysqli_query($GLOBALS['dbinv'], "delete from dealer_target where rep='" . $_GET["repno"] . "' and cus_code='" . $_GET["cuscode"] . "'") or die(mysqli_error());


    $ResponseXML .= "<target_table><![CDATA[ <table width=\"712\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          			<tr>
           			 <td width=\"66\">Code</td>
           			 <td width=\"327\">Name</td>
            		 <td width=\"159\">Target</td>
            		 <td width=\"132\">Last Update</td>
         			 </tr>";

    $sql1 = mysqli_query($GLOBALS['dbinv'], "Select * from dealer_target where rep='" . $_GET["repno"] . "' order by cus_code") or die(mysqli_error());
    while ($row1 = mysqli_fetch_array($sql1)) {
        $cus_code = $row1["cus_code"];
        $name = $row1["name"];
        $target = $row1["target"];

        $ResponseXML .= "<tr>
            						<td onclick=\"showtarget('$cus_code', '$name', '$target');\">" . $row1["cus_code"] . "</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">" . $row1["name"] . "</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">" . number_format($row1["target"], 2, ".", ",") . "</td>
									<td onclick=\"showtarget('$cus_code', '$name', '$target');\">" . $row1["ldate"] . "</td>
									</tr>";
    }

    $ResponseXML .= "   </table>]]></target_table>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "deletetarget_s") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = mysqli_query($GLOBALS['dbinv'], "delete from dealer_target_s where rep='" . $_GET["repno"] . "' and cus_code='" . $_GET["cuscode"] . "'") or die(mysqli_error());


    $ResponseXML .= "<target_table><![CDATA[ <table width=\"712\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          			<tr>
           			 <td width=\"66\">Code</td>
           			 <td width=\"327\">Name</td>
            		 <td width=\"159\">Target</td>
            		 <td width=\"132\">Last Update</td>
         			 </tr>";

    $sql1 = mysqli_query($GLOBALS['dbinv'], "Select * from dealer_target_s where rep='" . $_GET["repno"] . "' order by cus_code") or die(mysqli_error());
    while ($row1 = mysqli_fetch_array($sql1)) {
        $cus_code = $row1["cus_code"];
        $name = $row1["name"];
        $target = $row1["target"];

        $ResponseXML .= "<tr>
            						<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">" . $row1["cus_code"] . "</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">" . $row1["name"] . "</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">" . number_format($row1["target"], 2, ".", ",") . "</td>
									<td onclick=\"showtarget_s('$cus_code', '$name', '$target');\">" . $row1["ldate"] . "</td>
									</tr>";
    }

    $ResponseXML .= "   </table>]]></target_table>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "assign_brand") {
    $_SESSION["brand"] = $_GET["brand"];
//echo $_SESSION["brand"]; 
}

if ($_GET["Command"] == "brand_target") {

    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from reptrn where rep_code='" . $_GET["txtcode"] . "' and BrAnd='" . $_GET["cmbbrand"] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        echo $row["Target"];
    } else {
        echo "0";
    }
}

if ($_GET["Command"] == "update_target") {

    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from reptrn where rep_code='" . $_GET["txtcode"] . "' and BrAnd='" . $_GET["cmbbrand"] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $sql1 = mysqli_query($GLOBALS['dbinv'], "update reptrn set Target=" . $_GET["txttar"] . " where rep_code='" . $_GET["txtcode"] . "' and BrAnd='" . $_GET["cmbbrand"] . "'") or die(mysqli_error());
    } else {
        $sql1 = mysqli_query($GLOBALS['dbinv'], "insert into reptrn(rep_code, BrAnd, Target) values ('" . $_GET["txtcode"] . "', '" . $_GET["cmbbrand"] . "', " . $_GET["txttar"] . ")") or die(mysqli_error());
    }

    $sql = mysqli_query($GLOBALS['dbinv'], "Select sum(Target) as tot_target from reptrn where rep_code='" . $_GET["txtcode"] . "'") or die(mysqli_error());
    $row = mysqli_fetch_array($sql);

    $sql1 = mysqli_query($GLOBALS['dbinv'], "update s_salrep set target=" . $row["tot_target"] . " where REPCODE=" . $_GET["txtcode"]) or die(mysqli_error());

    echo "Updated";
}

if ($_GET["Command"] == "save_rep") {
    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_salrep where REPCODE=" . $_GET["txtcode"]) or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $sql1 = mysqli_query($GLOBALS['dbinv'], "update s_salrep set Name='" . $_GET["txtname"] . "', target='" . $_GET["txttottar"] . "', cancel='" . $_GET["act"] . "', RGROUP='" . $_GET["cmb_group"] . "' , RGROUP1='" . $_GET["cmb_group1"] . "' , RGROUP2='" . $_GET["cmb_group2"] . "' where REPCODE=" . $_GET["txtcode"]) or die(mysqli_error());
    } else {
        $sql1 = mysqli_query($GLOBALS['dbinv'], "insert into s_salrep (REPCODE, Name, target, cancel, RGROUP, RGROUP1, RGROUP2) values (" . $_GET["txtcode"] . ", '" . $_GET["txtname"] . "', '" . $_GET["txttottar"] . "', '" . $_GET["act"] . "', '" . $_GET["cmb_group"] . "', '" . $_GET["cmb_group1"] . "', '" . $_GET["cmb_group2"] . "')") or die(mysqli_error());
    }
    echo "Successfully saved";


    $sql = "delete  from com_tabale_dis_del where repcode='" . $_GET["txtcode"] . "'";
    mysqli_query($GLOBALS['dbinv'], $sql);

    $sql = "insert into com_tabale_dis_del (repcode,tar1_amount_de,tar1_rate_de,tar2_amount_de,tar2_rate_de,tar3_amount_de,tar3_rate_de,tar1_amount_di,tar1_rate_di,tar2_amount_di,tar2_rate_di,tar3_amount_di,tar3_rate_di)"
            . " values ('" . $_GET["txtcode"] . "','" . $_GET["tdam1"] . "','" . $_GET["tdamr1"] . "','" . $_GET["tdam2"] . "','" . $_GET["tdamr2"] . "','" . $_GET["tdam3"] . "','" . $_GET["tdamr3"] . "','" . $_GET["tdisam1"] . "','" . $_GET["tdisar1"] . "','" . $_GET["tdisam2"] . "','" . $_GET["tdisar2"] . "','" . $_GET["tdisam3"] . "','" . $_GET["tdisar3"] . "')";
    mysqli_query($GLOBALS['dbinv'], $sql);

    $sql = "delete  from sal_comm_new where sal_ex='" . $_GET["txtcode"] . "'";
    mysqli_query($GLOBALS['dbinv'], $sql);

    If ($_GET["BT1"] != "") {
        $sql = "insert into sal_comm_new (sal_ex,d_group,t1,t2,t3,p1,p2,p3,base) values ('" . $_GET["txtcode"] . "','Battery','" . $_GET["BT1"] . "','" . $_GET["BT2"] . "','" . $_GET["BT3"] . "','" . $_GET["BR1"] . "','" . $_GET["BR2"] . "','" . $_GET["BR3"] . "','" . $_GET["BR3"] . "') ";
        mysqli_query($GLOBALS['dbinv'], $sql);
    }
    If ($_GET["TT1"] != "") {
        $sql = "insert into sal_comm_new (sal_ex,d_group,t1,t2,t3,p1,p2,p3,base) values ('" . $_GET["txtcode"] . "','Tyres','" . $_GET["TT1"] . "','" . $_GET["TT2"] . "','" . $_GET["TT3"] . "','" . $_GET["TR1"] . "','" . $_GET["TR2"] . "','" . $_GET["TR3"] . "','" . $_GET["TR3"] . "') ";
        mysqli_query($GLOBALS['dbinv'], $sql);
    }
}


if ($_GET["Command"] == "deleterep") {
    $sql = mysqli_query($GLOBALS['dbinv'], "delete from s_salrep where REPCODE=" . $_GET["txtcode"]) or die(mysqli_error());

    echo "Successfully Deleted";
}
?>
