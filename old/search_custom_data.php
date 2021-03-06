<?php

session_start();


include_once("connectioni.php");

if ($_GET["Command"] == "search_custom") {


    $ResponseXML = "";

    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
    <tr>
    <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">Customer No</font></td>
    <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Customer</font></td>
    <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Address</font></td>
    </tr>";

    if ($_GET['stname'] != "sal_reg1") {
        if ($_GET['stname'] != "" and $_GET['stname'] != "crn" and $_GET['stname'] != "item_claim") {
            // if ($_GET["mstatus"] == "cusno") {
            //     $letters = $_GET['cusno'];
            //     //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            //     $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from vendor where CODE like  '$letters%' and CAT<>'X' order by CODE limit 50") or die(mysqli_error());
            // } else if ($_GET["mstatus"] == "customername") {
            //     $letters = $_GET['customername'];
            //     //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            //     $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from vendor where NAME like  '$letters%' and CAT<>'X' order by CODE limit 50") or die(mysqli_error()) or die(mysqli_error());
            // } else {

            //     $letters = $_GET['customername'];
            //     //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            //     $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from vendor where NAME like  '$letters%' and CAT<>'X' order by CODE limit 50") or die(mysqli_error()) or die(mysqli_error());
            // }
            if($_GET['stname'] == "sales_order"){
                $sql = "SELECT * from view_vendor where  CAT<>'X'  order by c_code limit 50";
                if ($_GET["mstatus"] == "cusno") {
                    $letters = $_GET['cusno'];
                    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from view_vendor where c_code like  '$letters%' and CAT<>'X' order by c_code limit 50") or die(mysqli_error());
                } else if ($_GET["mstatus"] == "customername") {
                    $letters = $_GET['customername'];
                    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from view_vendor where (c_name like  '$letters%' or m_name like '$letters') and CAT<>'X' order by c_code limit 50") or die(mysqli_error()) or die(mysqli_error());
                } else {
                    $letters = $_GET['customername'];
                    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from view_vendor where (c_name like  '$letters%' or m_name like '$letters') and CAT<>'X' order by c_code limit 50") or die(mysqli_error()) or die(mysqli_error());
                }
            }else{
                if ($_GET["mstatus"] == "cusno") {
                    $letters = $_GET['cusno'];
                    //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
                    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from vendor where CODE like  '$letters%' and CAT<>'X' order by CODE limit 50") or die(mysqli_error());
                } else if ($_GET["mstatus"] == "customername") {
                    $letters = $_GET['customername'];
                    //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
                    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from vendor where NAME like  '$letters%' and CAT<>'X' order by CODE limit 50") or die(mysqli_error()) or die(mysqli_error());
                } else {

                    $letters = $_GET['customername'];
                    //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
                    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from vendor where NAME like  '$letters%' and CAT<>'X' order by CODE limit 50") or die(mysqli_error()) or die(mysqli_error());
                }
            }
        } else {
            if (($_SESSION["CURRENT_USER"] == 'sarath' or $_SESSION["CURRENT_USER"] == 'SARATH') and $_GET['stname'] == "item_claim") {

                $sql = "SELECT * from sarath_salma  order by c_code1 limit 50";

                if ($_GET["mstatus"] == "cusno") {
                    $letters = $_GET['cusno'];
                    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from sarath_salma where c_code1 like  '$letters%'   order by c_code1 limit 50") or die(mysqli_error());
                } else if ($_GET["mstatus"] == "customername") {
                    $letters = $_GET['customername'];
                    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from sarath_salma where (CUS_NAME like  '$letters%')  order by c_code1 limit 50") or die(mysqli_error()) or die(mysqli_error());
                } else {
                    $letters = $_GET['customername'];
                    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from sarath_salma where (CUS_NAME like  '$letters%')   order by c_code1 limit 50") or die(mysqli_error()) or die(mysqli_error());
                }
            } else {
                $sql = "SELECT * from view_vendor where  CAT<>'X'  order by c_code limit 50";
                if ($_GET["mstatus"] == "cusno") {
                    $letters = $_GET['cusno'];
                    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from view_vendor where c_code like  '$letters%' and CAT<>'X' order by c_code limit 50") or die(mysqli_error());
                } else if ($_GET["mstatus"] == "customername") {
                    $letters = $_GET['customername'];
                    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from view_vendor where (c_name like  '$letters%' or m_name like '$letters') and CAT<>'X' order by c_code limit 50") or die(mysqli_error()) or die(mysqli_error());
                } else {
                    $letters = $_GET['customername'];
                    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from view_vendor where (c_name like  '$letters%' or m_name like '$letters') and CAT<>'X' order by c_code limit 50") or die(mysqli_error()) or die(mysqli_error());
                }
            }
        }


        while ($row = mysqli_fetch_array($sql)) {
            if (($_SESSION["CURRENT_USER"] == 'sarath' or $_SESSION["CURRENT_USER"] == 'SARATH') and $_GET['stname'] == "item_claim") {
                $cuscode = $row["c_code1"];
            } else {
                $cuscode = $row["c_code"];
            }

            $stname = $_GET["stname"];


            if ($_GET['stname'] == "" or $_GET['stname'] == "crn" or $_GET['stname'] == "item_claim") {
                if (($_SESSION["CURRENT_USER"] == 'sarath' or $_SESSION["CURRENT_USER"] == 'SARATH') and $_GET['stname'] == "item_claim") {
                    $ResponseXML .= "<tr>
                    <td onclick=\"custno('$cuscode', '$stname');\">" . $row['C_CODE'] . "</a></td>
                    <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CUS_NAME'] . "</a></td>
                    <td onclick=\"custno('$cuscode', '$stname');\">" . $row['C_ADD1'] . "</a></td>    
                    <td onclick=\"custno('$cuscode', '$stname');\">" . $row['c_code1'] . "</a></td>		
                    </tr>";
                } else {
                    $ResponseXML .= "<tr>
                    <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CODE'] . "</a></td>
                    <td onclick=\"custno('$cuscode', '$stname');\">" . $row['c_name'] . "</a></td>
                    <td onclick=\"custno('$cuscode', '$stname');\">" . $row['town'] . "</a></td>    
                    <td onclick=\"custno('$cuscode', '$stname');\">" . $row['c_code'] . "</a></td>		
                    </tr>";
                }
            } else {
                // $cuscode = $row["CODE"];
                // $ResponseXML .= "<tr>
                //               <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CODE'] . "</a></td>
                //               <td onclick=\"custno('$cuscode', '$stname');\">" . $row['NAME'] . "</a></td>
                //               <td onclick=\"custno('$cuscode', '$stname');\">" . $row['ADD2'] . "</a></td> 

                //             </tr>";
             if($_GET['stname'] == "sales_order"){
                $ResponseXML .= "<tr>
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CODE'] . "</a></td>
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['c_name'] . "</a></td>
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['c_add'] . "</a></td>
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['c_code'] . "</a></td>       
                </tr>";
            } else {
                $cuscode = $row["CODE"];
                $ResponseXML .= "<tr>
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CODE'] . "</a></td>
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['NAME'] . "</a></td>
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['ADD2'] . "</a></td> 

                </tr>";

            }
        }
    }
} else {
    if ($_GET["mstatus"] == "cusno") {
        $letters = $_GET['cusno'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from view_vendor where c_code like  '$letters%' and CAT<>'X' order by c_code limit 50") or die(mysqli_error());
    } else if ($_GET["mstatus"] == "customername") {
        $letters = $_GET['customername'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from view_vendor where c_name like  '$letters%' and CAT<>'X' order by c_code limit 50") or die(mysqli_error()) or die(mysqli_error());
    } else {

        $letters = $_GET['customername'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from view_vendor where c_name like  '$letters%' and CAT<>'X' order by c_code limit 50") or die(mysqli_error()) or die(mysqli_error());
    }

    while ($row = mysqli_fetch_array($sql)) {
        $cuscode = $row["c_code"];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>
        <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CODE'] . "</a></td>
        <td onclick=\"custno('$cuscode', '$stname');\">" . $row['c_name'] . "</a></td>
        <td onclick=\"custno('$cuscode', '$stname');\">" . $row['c_add'] . "</a></td> 
        <td onclick=\"custno('$cuscode', '$stname');\">" . $row['c_code'] . "</a></td> 

        </tr>";
    }
}

$ResponseXML .= "   </table>";


echo $ResponseXML;
//	}
}

if ($_GET["Command"] == "sal_reg1") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from view_vendor where c_code='" . $_GET['custno'] . "'") or die(mysqli_error());

    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['c_code'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['c_name'] . "]]></NAME>";
        $ResponseXML .= "<type1><![CDATA[" . $row['type'] . "]]></type1>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "search_custom1") {



    $ResponseXML = "";

    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
    <tr>
    <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">Customer No</font></td>
    <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Customer</font></td>
    <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Address</font></td>
    </tr>";
    if ($_GET["mstatus"] == "cusno") {
        $letters = $_GET['cusno'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from view_vendor where c_code like  '$letters%' and CAT<>'X' order by c_code limit 50") or die(mysqli_error());
    } else if ($_GET["mstatus"] == "customername") {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from view_vendor where c_name like  '$letters%' and CAT<>'X' order by c_code limit 50") or die(mysqli_error()) or die(mysqli_error());
    } else {

        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from view_vendor where c_name like  '$letters%' and CAT<>'X' order by c_code limit 50") or die(mysqli_error()) or die(mysqli_error());
    }

    while ($row = mysqli_fetch_array($sql)) {
        $cuscode = $row["c_code"];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>
        <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CODE'] . "</a></td>
        <td onclick=\"custno('$cuscode', '$stname');\">" . $row['c_name'] . "</a></td>
        <td onclick=\"custno('$cuscode', '$stname');\">" . $row['c_add'] . "</a></td> 
        <td onclick=\"custno('$cuscode', '$stname');\">" . $row['c_code'] . "</a></td> 

        </tr>";
    }

    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}

if ($_GET["Command"] == "save_customer") {


    $txtCNAME = str_replace("~", "&", $_GET['txtCNAME']);



    $sql_data = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['txt_cuscode'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql_data)) {
        //echo "update vendor set NAME='".$txtCNAME."', ADD1='".$_GET['txtBADD1']."', ADD2='".$_GET['txtBADD2']."', TELE1='".$_GET['txtTEL']."', TELE2='".$_GET['txttel2']."', CONT='".$_GET['txtcper']."', CUR_BAL='".$_GET['txtbal']."', OPDATE='".$_GET['DTOPDATE']."', cLIMIT='".$_GET['txtcrlimt']."', PEN='".$_GET['txtover']."', PENDA='".$_GET['']."', FAX='".$_GET['txtFAX']."', EMAIL='".$_GET['TXTEMAIL']."', vatno='".$_GET['txtvatno']."', acno='".$_GET["txtACCno"]."', CAT='".$_GET['txtcat']."', svatno='".$_GET['SVAT']."', cus_type='".$_GET['txttype']."', area='".$_GET['txtarea']."', incdays='".$_GET['txtInc']."', chk_bangr='".$chkgarant."', bank_gr_date='".$_GET["DTbankgrdate"]."', AltMessage='".$_GET["txtMsg"]."'  where CODE='".$_GET['txt_cuscode']."'";

        $sql_data = mysqli_query($GLOBALS['dbinv'], "update vendor set province='" . $_GET['txtprovince'] . "',district='" . $_GET['txtdistrict'] . "',commoncode='" . $_GET['txt_commcode'] . "', vatgroup ='" . $_GET['txtvatgroup'] . "', NAME='" . $txtCNAME . "', ADD1='" . $_GET['txtBADD1'] . "', ADD2='" . $_GET['txtBADD2'] . "', TELE1='" . $_GET['txtTEL'] . "', TELE2='" . $_GET['txttel2'] . "', CONT='" . $_GET['txtcper'] . "', CUR_BAL='" . $_GET['txtbal'] . "', OPDATE='" . $_GET['DTOPDATE'] . "', cLIMIT='" . $_GET['txtcrlimt'] . "', PEN='" . $_GET['txtover'] . "', PENDA='" . $_GET[''] . "', FAX='" . $_GET['txtFAX'] . "', EMAIL='" . $_GET['TXTEMAIL'] . "', vatno='" . $_GET['txtvatno'] . "', acno='" . $_GET["txtACCno"] . "', CAT='" . $_GET['txtcat'] . "', svatno='" . $_GET['SVAT'] . "', cus_type='" . $_GET['txttype'] . "', area='" . $_GET['txtarea'] . "', incdays='" . $_GET['txtInc'] . "', chk_bangr='" . $chkgarant . "', bank_gr_date='" . $_GET["DTbankgrdate"] . "', AltMessage='" . $_GET["txtMsg"] . "', rep='" . $_GET["TXT_REP"] . "', field1='" . $_GET["txt_scat"] . "', remark='" . $_GET["remark"] . "'  where CODE='" . $_GET['txt_cuscode'] . "'") or die(mysqli_error());

        $sql = "delete from vender_sub where c_code = '" . $_GET['txt_cuscode'] . "' and c_main = '" . $_GET['txt_cuscode'] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);


        $c_add = $_GET['txtBADD1'];
        $sql = "insert into vender_sub (c_code,c_name,c_add,c_tele,c_vatno,c_svatno,c_main,type,town) values
        ('" . $_GET['txt_cuscode'] . "','" . $txtCNAME . "','" . $c_add . "','" . $_GET['txtTEL'] . "','" . $_GET['txtvatno'] . "','" . $_GET['SVAT'] . "','" . $_GET['txt_cuscode'] . "','M','" . $_GET['txtBADD2'] . "') ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    } else {

        //echo "insert into vendor (CODE, NAME, ADD1, ADD2, TELE1, TELE2, CONT, CUR_BAL, OPDATE, cLIMIT, PEN, FAX, EMAIL, vatno, acno, CAT, svatno, cus_type, area, incdays, chk_bangr, bank_gr_date, AltMessage) values ('".$_GET['txt_cuscode']."', '".$txtCNAME."', '".$_GET['txtBADD1']."', '".$_GET['txtBADD2']."', '".$_GET['txtTEL']."', '".$_GET['txttel2']."', '".$_GET['txtcper']."', '".$_GET['txtbal']."', '".$_GET['DTOPDATE']."', '".$_GET['txtcrlimt']."', '".$_GET['txtover']."', '".$_GET['txtFAX']."', '".$_GET['TXTEMAIL']."', '".$_GET['txtvatno']."', '".$_GET["txtACCno"]."', '".$_GET['txtcat']."', '".$_GET['SVAT']."', '".$_GET['txttype']."', '".$_GET['txtarea']."', '".$_GET['txtInc']."', '".$chkgarant."', '".$_GET["DTbankgrdate"]."', '".$_GET["txtMsg"]."')";

        $sql_data = mysqli_query($GLOBALS['dbinv'], "insert into vendor 
          (CODE, NAME, ADD1, ADD2, TELE1, TELE2, CONT, CUR_BAL, OPDATE, cLIMIT, PEN, FAX, EMAIL, vatno, acno, CAT, svatno, cus_type, area, incdays, chk_bangr, bank_gr_date, AltMessage, rep, field1, remark,vatgroup,district,province) 
          values ('" . $_GET['txt_cuscode'] . "', '" . $txtCNAME . "', '" . $_GET['txtBADD1'] . "', '" . $_GET['txtBADD2'] . "', '" . $_GET['txtTEL'] . "', '" . $_GET['txttel2'] . "', '" . $_GET['txtcper'] . "', '" . $_GET['txtbal'] . "', '" . $_GET['DTOPDATE'] . "', '" . $_GET['txtcrlimt'] . "', '" . $_GET['txtover'] . "', '" . $_GET['txtFAX'] . "', '" . $_GET['TXTEMAIL'] . "', '" . $_GET['txtvatno'] . "', '" . $_GET["txtACCno"] . "', '" . $_GET['txtcat'] . "', '" . $_GET['SVAT'] . "', '" . $_GET['txttype'] . "', '" . $_GET['txtarea'] . "', '" . $_GET['txtInc'] . "', '" . $chkgarant . "', '" . $_GET["DTbankgrdate"] . "', '" . $_GET["txtMsg"] . "', '" . $_GET["TXT_REP"] . "', '" . $_GET["txt_scat"] . "', '" . $_GET["remark"] . "','" . $_GET['txtvatgroup'] . "','" . $_GET['txtdistrict'] . "','" . $_GET['txtprovince'] . "')") or die(mysqli_error());

        $sql = "delete from vender_sub where c_code = '" . $_GET['txt_cuscode'] . "' and c_main = '" . $_GET['txt_cuscode'] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);


        $c_add = $_GET['txtBADD1'] . " " . $_GET['txtBADD2'];
        $sql = "insert into vender_sub (c_code,c_name,c_add,c_tele,c_vatno,c_svatno,c_main,type,town) values
        ('" . $_GET['txt_cuscode'] . "','" . $txtCNAME . "','" . $c_add . "','" . $_GET['txtTEL'] . "','" . $_GET['txtvatno'] . "','" . $_GET['SVAT'] . "','" . $_GET['txt_cuscode'] . "','M','" . $_GET['txtBADD2'] . "') ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql_data = mysqli_query($GLOBALS['dbinv'], "update invpara set " . $_GET["cmbcat"] . " = " . $_GET["cmbcat"] . " + 1") or die(mysqli_error());

        $sql1 = "update invpara set A=A+1";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }

    echo "Successfully Saved";
}

if ($_GET["Command"] == "pass_sellimit_result") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql_data = mysqli_query($GLOBALS['dbinv'], "select * from br_trn where cus_code='" . $_GET["txt_cuscode"] . "' and Rep='" . $_GET["Com_rep"] . "' and brand='" . $_GET["cmbbrand"] . "' ") or die(mysqli_error());
    //echo "select * from br_trn where cus_code='".$_GET["txt_cuscode"]."' and Rep='".$_GET["Com_rep"]."' and brand='".$_GET["cmbbrand"]."' ";
    if ($row = mysqli_fetch_array($sql_data)) {
        $ResponseXML .= "<credit_lim><![CDATA[" . $row["credit_lim"] . "]]></credit_lim>";
        if (is_null($row["CAT"]) == false) {
            $ResponseXML .= "<CAT><![CDATA[" . $row["CAT"] . "]]></CAT>";
        } else {
            $ResponseXML .= "<CAT><![CDATA[]]></CAT>";
        }
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "delete_customer") {
    $sql_data = mysqli_query($GLOBALS['dbinv'], "delete from vendor where CODE='" . $_GET['txt_cuscode'] . "'") or die(mysqli_error());
    echo "Successfully Deleted";
}

if ($_GET["Command"] == "tmp_crelimit") {

    $crelim = 0;
    $cat = "";
    $Com_rep1 = trim($_GET["Com_rep1"]);

    //echo "Select * from br_trn where cus_code='".$_GET["txt_cuscode"]."' and Rep='".$Com_rep1."' and  brand='".$_GET["cmbbrand1"]."'";
    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from br_trn where cus_code='" . $_GET["txt_cuscode"] . "' and Rep='" . $Com_rep1 . "' and  brand='" . $_GET["cmbbrand1"] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $crelim = $row["credit_lim"];
        if (is_null($row["CAT"]) == false) {
            $cat = $row["CAT"];
        } else {
            $crelim = 0;
        }
    }

    $sql_data = mysqli_query($GLOBALS['dbinv'], "insert into tmpcrlmt (sdate, stime, username, tmpLmt, Class, Rep, cusCode, crLmt, cat) values ('" . date("Y-m-d") . "', '" . date("H:i:s") . "', '" . $_SESSION["CURRENT_USER"] . "', " . $_GET["txt_templimit"] . ", '" . trim($_GET["cmbbrand1"]) . "', '" . $Com_rep1 . "', '" . trim($_GET["txt_cuscode"]) . "', " . $crelim . ", '" . $cat . "' )") or die(mysqli_error());


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from br_trn where cus_code='" . trim($_GET["txt_cuscode"]) . "' and Rep='" . $Com_rep1 . "' and  brand='" . $_GET["cmbbrand1"] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        //	echo "update br_trn set tmpLmt= ".$_GET["txt_templimit"]." where cus_code='".trim($_GET["txt_cuscode"])."' and Rep='".$Com_rep1."' and brand='".$_GET["cmbbrand1"]."'";
        $sql_data = mysqli_query($GLOBALS['dbinv'], "update br_trn set tmpLmt= " . $_GET["txt_templimit"] . ", Day= '" . date("Y-m-d") . "' where cus_code='" . trim($_GET["txt_cuscode"]) . "' and Rep='" . $Com_rep1 . "' and brand='" . $_GET["cmbbrand1"] . "'") or die(mysqli_error());
        //	echo "update br_trn set tmpLmt= ".$_GET["txt_templimit"].", Day= '".date("Y-m-d")."' where cus_code='".trim($_GET["txt_cuscode"])."' and Rep='".$Com_rep1."' and brand='".$_GET["cmbbrand1"]."'";
    } else {

        $sql_data = mysqli_query($GLOBALS['dbinv'], "insert into br_trn (cus_code, Rep, credit_lim, brand, tmpLmt, Day) values ('" . trim($_GET["txt_cuscode"]) . "', '" . $Com_rep1 . "', '0', '" . $_GET["cmbbrand1"] . "', '" . $_GET["txt_templimit"] . "', '" . date("Y-m-d") . "')") or die(mysqli_error());
    }

    if ($_GET["chkstop"] == 1) {
        $chkstop = 1;
    } else {
        $chkstop = 0;
    }

    if ($_GET["check1"] == 1) {
        //echo "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."'";
        $sql_data = mysqli_query($GLOBALS['dbinv'], "update vendor set blacklist= '1'  where code='" . trim($_GET["txt_cuscode"]) . "'") or die(mysqli_error());
    } else {
        //echo "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."'";
        $sql_data = mysqli_query($GLOBALS['dbinv'], "update vendor set blacklist= '0'  where code='" . trim($_GET["txt_cuscode"]) . "'") or die(mysqli_error());
    }

    echo "Updated";
}

if ($_GET["Command"] == "pass_sto_inv") {

    if ($_GET["chkstop"] == "true") {
        $sql_data = mysqli_query($GLOBALS['dbinv'], "update vendor set blacklist= '1'  where code='" . trim($_GET["txt_cuscode"]) . "'") or die(mysqli_error());
        $sql = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["txt_cuscode"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Stop Invoice', 'BLOCK', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    } else {
        $sql_data = mysqli_query($GLOBALS['dbinv'], "update vendor set blacklist= '0'  where code='" . trim($_GET["txt_cuscode"]) . "'") or die(mysqli_error());
        $sql = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["txt_cuscode"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Allow Invoice', 'BLOCK', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    }
}

if ($_GET["Command"] == "pass_quot") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];
    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $cuscode . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<str_customername><![CDATA[" . trim($row['NAME']) . "]]></str_customername>";
        $address = trim($row['ADD1']); // ",  " . trim($row['ADD2']);
        $ResponseXML .= "<str_address><![CDATA[" . trim($address) . "]]></str_address>";
        $ResponseXML .= "<str_vatno><![CDATA[" . trim($row["vatno"]) . "]]></str_vatno>";
        $ResponseXML .= "<str_svatno><![CDATA[" . trim($row["svatno"]) . "]]></str_svatno>";
        $ResponseXML .= "<AltMessage><![CDATA[" . $row["AltMessage"] . "]]></AltMessage>";
        $ResponseXML .= "<blacklist><![CDATA[" . $row['blacklist'] . "]]></blacklist>";
    }
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_cusno") {



    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];

    $sql = "select * from vender_sub where c_code = '" . $_GET["custno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {

        $cuscode = $row['c_main'];
    }




    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $cuscode . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<c_subcode><![CDATA[" . $_GET["custno"] . "]]></c_subcode>";



        $sql = "select * from vender_sub where c_code = '" . $_GET["custno"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row_1 = mysqli_fetch_array($result)) {
            $ResponseXML .= "<str_customername><![CDATA[" . trim($row_1['c_name']) . "]]></str_customername>";
            $address = trim($row_1['c_add']); // . ",  " . trim($row_1['c_add1']);
            $ResponseXML .= "<str_address><![CDATA[" . trim($address) . "]]></str_address>";
            $ResponseXML .= "<str_vatno><![CDATA[" . trim($row_1["c_vatno"]) . "]]></str_vatno>";
            $ResponseXML .= "<str_svatno><![CDATA[" . trim($row_1["c_svatno"]) . "]]></str_svatno>";
        }

        $ResponseXML .= "<AltMessage><![CDATA[" . $row["AltMessage"] . "]]></AltMessage>";
        $ResponseXML .= "<blacklist><![CDATA[" . $row['blacklist'] . "]]></blacklist>";


        $cuscode = $_GET["custno"];
        $RET_AMOUNT = 0;
        $PD_AMOUNT = 0;
        $OUT_AMOUNT = 0;


        $sqlchq = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as che_amount FROM s_invcheq WHERE che_date>'" . date("Y-m-d") . "' AND cus_code='" . $row["CODE"] . "'") or die(mysqli_error());

        while ($rowchq = mysqli_fetch_array($sqlchq)) {
            $PD_AMOUNT = $PD_AMOUNT + $rowchq["che_amount"];
        }

        if ($row["chk_bangr"] == "1") {

            $dateDiff = $row["bank_gr_date"] - date("Y-m-d");
            $m_dates = floor($dateDiff / (60 * 60 * 24));
            if ($m_dates > 30 and $m_dates < 60) {
                $ResponseXML .= "<bank_message><![CDATA[Please Re-New Bank Grantee Date]]></bank_message>";
                $_SESSION["inv_status"] = 0;
            } else if ($m_dates <= 30) {
                $ResponseXML .= "<bank_message><![CDATA[No Permission For Invoice For This Customer Please Re-New Bank Grantee Date]]></bank_message>";
                $_SESSION["inv_status"] = 0;
            }
        } else {
            $ResponseXML .= "<bank_message><![CDATA[]]></bank_message>";
        }


        $sql60 = mysqli_query($GLOBALS['dbinv'], "select SDATE from  s_salma where  C_CODE='" . trim($cuscode) . "' and GRAND_TOT-TOTPAY >1 and CANCELL=0  order by SDATE") or die(mysqli_error());
        if ($row60 = mysqli_fetch_array($sql60)) {
            //$mtmp = date("Y-m-d") - $row60["SDATE"];
            //$mdays= floor($mtmp/(60*60*24));


            $date1 = $row60["SDATE"];
            $date2 = date("Y-m-d");

            $diff = abs(strtotime($date2) - strtotime($date1));

            $years = floor($diff / (365 * 60 * 60 * 24));

            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));

            $mday = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            $mdays = $mday + ($months * 30) + ($years * 365);

            if ($mdays > 60) {
                $ResponseXML .= "<over60_message><![CDATA[Over 60 Outsnding Avilabale]]></over60_message>";
                $ResponseXML .= "<over60_txt><![CDATA[60]]></over60_txt>";
                $_SESSION["inv_status"] = 0;
                if (is_null($row["Over_DUE_IG_Date"]) == false) {
                    if ($row["Over_DUE_IG_Date"] == date("Y-m-d")) {
                        $ResponseXML .= "<over60_qst><![CDATA[This is Over 60 Days Customer Do you want to Proceed]]></over60_qst>";

                        $sqltmpCrLmt = mysqli_query($GLOBALS['dbinv'], "insert into tmpcrlmt (sdate, stime, tmpLmt, Class, Rep,cusCode, crLmt,  FLAG) values ('" . date("Y-m-d") . "','" . date("h:i:s") . "' , " . $mdays . " ,'NB','NR','" . trim($cuscode) . "','0', 'O60')") or die(mysqli_error());
                    } else {
                        $ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
                    }
                } else {
                    $ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
                }
            } else {
                $ResponseXML .= "<over60_message><![CDATA[]]></over60_message>";
                $ResponseXML .= "<over60_txt><![CDATA[0]]></over60_txt>";
                $ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
            }
        } else {
            $ResponseXML .= "<over60_message><![CDATA[]]></over60_message>";
            $ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
            $ResponseXML .= "<over60_txt><![CDATA[0]]></over60_txt>";
        }

        $sqls_cheq = mysqli_query($GLOBALS['dbinv'], "Select (CR_CHEVAL-PAID) as CR_CHEVAL from s_cheq where CR_CHEVAL-PAID>0 and CR_FLAG='0' and CR_C_CODE='" . trim($cuscode) . "'") or die(mysqli_error());
        $rows_cheq = mysqli_fetch_array($sqls_cheq);


        if (is_null($rows_cheq["CR_CHEVAL"]) == false) {
            if ($rows_cheq["CR_CHEVAL"] > 0) {
                $ResponseXML .= "<chq_message><![CDATA[Return Cheque]]></chq_message>";
                $_SESSION["inv_status"] = 0;

                if (is_null($row["Over_DUE_IG_Date"]) == false) {
                    if ($row["Over_DUE_IG_Date"] == date("Y-m-d")) {
                        $ResponseXML .= "<chq_message_que><![CDATA[Do You Want To Continue with Return Cheques]]></chq_message_que>";

                        $sqltmpCrLmt = mysqli_query($GLOBALS['dbinv'], "insert into tmpcrlmt (sdate, stime, tmpLmt, Class, Rep,cuscode, crLmt, FLAG) values ('" . date("Y-m-d") . "', '" . date("h:i:s") . "', '0' ,'NB','NR','" . trim($cuscode) . "','0', 'RTN')") or die(mysqli_error());
                    } else {
                        $ResponseXML .= "<chq_message_que><![CDATA[]]></chq_message_que>";
                    }
                }
            }
        } else {
            $ResponseXML .= "<chq_message><![CDATA[]]></chq_message>";
            $ResponseXML .= "<chq_message_que><![CDATA[]]></chq_message_que>";
        }




        if (is_null($row["cLIMIT"]) == false) {
            $ResponseXML .= "<txt_crelimi><![CDATA[" . number_format($row['cLIMIT'] + $row['temp_limit'], 2, ".", ",") . "]]></txt_crelimi>";
        }

        if (is_null($row["CUR_BAL"]) == false) {
            $OUT_AMOUNT = $row["CUR_BAL"];
        }

        if (is_null($row["CAT"]) == false) {
            $cuscat = $row["CAT"];
        }
    }


    //Call SETLIMIT ====================================================================

    $OutpDAMT = 0;
    $OutREtAmt = 0;
    $OutInvAmt = 0;
    $InvClass = "";
    //echo "select class from brand_mas where barnd_name='".trim($_GET["brand"])."'";
    $sqlclass = mysqli_query($GLOBALS['dbinv'], "select class from brand_mas where barnd_name='" . trim($_GET["brand"]) . "'") or die(mysqli_error());
    if ($rowclass = mysqli_fetch_array($sqlclass)) {
        if (is_null($rowclass["class"]) == false) {
            $InvClass = $rowclass["class"];
        }
    }


    $sqloutinv = mysqli_query($GLOBALS['dbinv'], "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and SAL_EX='" . trim($_GET["salesrep"]) . "' and class='" . $InvClass . "'") or die(mysqli_error());
    if ($rowoutinv = mysqli_fetch_array($sqloutinv)) {
        if (is_null($rowoutinv["totout"]) == false) {
            $OutInvAmt = $rowoutinv["totout"];
        }
    }
    $OutpDAMT = 0;

    $sqlinvcheq1 = "Select sum(ST_PAID) as out1 from view_sinvcheq_sttr_salma1  where che_date >  '" . date("Y-m-d") . "' and C_CODE='" . trim($cuscode) . "'  and trn_type='REC' and SAL_EX = '" . trim($_GET["salesrep"]) . "' and class = '" . $InvClass . "'  ";
    // $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_invcheq WHERE che_date>'" . date("Y-m-d") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . trim($_GET["salesrep"]) . "'") or die(mysqli_error());
    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], $sqlinvcheq1);
    while ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {
        $OutpDAMT = $OutpDAMT + $rowinvcheq["out1"];
    }



    $pend_ret_set = 0;
    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'" . date("Y-m-d") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
    if ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {
        if (is_null($rowinvcheq["che_amount"]) == false) {
            $pend_ret_set = $rowinvcheq["che_amount"];
        }
    }

    $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='" . trim($_GET["salesrep"]) . "'") or die(mysqli_error());
    if ($rowcheq = mysqli_fetch_array($sqlcheq)) {
        if (is_null($rowcheq["tot"]) == false) {
            $OutREtAmt = $rowcheq["tot"];
            $ResponseXML .= "<msg_return><![CDATA[Return Cheques Available]]></msg_return>";
        } else {
            $OutREtAmt = 0;
            $ResponseXML .= "<msg_return><![CDATA[]]></msg_return>";
        }
    } else {
        $ResponseXML .= "<msg_return><![CDATA[]]></msg_return>";
    }



    $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
    <tr><td><input type=\"text\"  class=\"text_purchase3\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"\" value=\"" . number_format($OutInvAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
    <td><input type=\"text\"  class=\"text_purchase3\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"\" value=\"" . number_format($OutREtAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
    <td><input type=\"text\"  class=\"text_purchase3\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"\" value=\"" . number_format($OutpDAMT, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
    <td><input type=\"text\"  class=\"text_purchase3\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"\" value=\"" . number_format($pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
    <td><input type=\"text\"  class=\"text_purchase3\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"\" value=\"" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
    </table></table>]]></sales_table_acc>";

    $txt_crelimi = 0;
    $txt_crebal = 0;
    $crebal = 0;
    $creditbalance = 0;
    $sqlbr_trn = mysqli_query($GLOBALS['dbinv'], "select * from br_trn where rep='" . trim($_GET["salesrep"]) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($cuscode) . "'") or die(mysqli_error());
    if ($rowbr_trn = mysqli_fetch_array($sqlbr_trn)) {
        if (is_null($rowbr_trn["credit_lim"]) == false) {
            $crLmt = $rowbr_trn["credit_lim"];
        } else {
            $crLmt = 0;
        }


        if (is_null($rowbr_trn["tmpLmt"]) == false) {
            $tmpLmt = $rowbr_trn["tmpLmt"];
        } else {
            $tmpLmt = 0;
        }

        if (is_null($rowbr_trn["CAT"]) == false) {
            $cuscat = trim($rowbr_trn["CAT"]);
            if ($cuscat == "A") {
                $m = 2.5;
            }
            if ($cuscat == "B") {
                $m = 2.5;
            }
            if ($cuscat == "C") {
                $m = 1;
            }
            if ($cuscat == "D") {
                $m = 0;
            }

            $txt_crelimi = 0;
            $txt_crebal = 0;
            $txt_crelimi = number_format($crLmt, 2, ".", ",");

            $txt_crebal = $crLmt * $m - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
        } else {
            $txt_crelimi = 0;
            $txt_crebal = 0;
        }
        $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
    }
    $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
    $ResponseXML .= "<txt_crebal><![CDATA[" . number_format($txt_crebal, "2", ".", ",") . "]]></txt_crebal>";
    $ResponseXML .= "<crebal><![CDATA[" . number_format($crebal, "2", ".", ",") . "]]></crebal>";

    $ResponseXML .= "<creditbalance><![CDATA[" . $creditbalance . "]]></creditbalance>";


    $invqty = 0;
    $rtnqty = 0;

    // $Mon = date("m", strtotime(date('Y-m-d')));
    // $Yer = date("Y", strtotime(date('Y-m-d')));
    // $sql_inv = "Select sum(Qty) as totQty from viewinv where  Cus_CODE = '" . $row['C_CODE'] . "' and s_Brand = '" . $row['Brand'] . "' and month(SDATE1) = '" . $Mon . "' and year(SDATE1) = '" . $Yer . "' and cancel_m = '0' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'L0531' AND stk_no <> 'T3520' AND stk_no <> 'T3522' and stk_no <> 'A0356' and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and stk_no <> 'A0359' and stk_no <> 'MR099'";
    // $sql_grn = " Select sum(Qty) as totQty from viewcrntrn where  C_CODE = '" . $row['C_CODE'] . "' and Brand = '" . $row['Brand'] . "' and month(SDATE1) = '" . $Mon . "' and year(SDATE1) = '" . $Yer . "' and cancell = '0' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'L0531' AND stk_no <> 'T3520' AND stk_no <> 'T3522' and stk_no <> 'A0356' and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and stk_no <> 'A0359' and stk_no <> 'MR099'";
    // $res_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
    // if ($row_inv = mysqli_fetch_array($res_inv)) {
    //     if (!is_null($row_inv['totQty'])) {
    //         $invqty = $row_inv['totQty'];
    //     }
    // }
    // $res_grn = mysqli_query($GLOBALS['dbinv'], $sql_grn);
    // if ($row_grn = mysqli_fetch_array($res_grn)) {
    //     if (!is_null($row_grn['totQty'])) {
    //         $rtnqty = $row_grn['totQty'];
    //     }
    // }


    $netqty = $invqty - $rtnqty;






    $ResponseXML .= "<netqty><![CDATA[" . $netqty . "]]></netqty>";
    $ResponseXML .= "<stname><![CDATA[" . $_GET["stname"] . "]]></stname>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_modify") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
        $ResponseXML .= "<ADD1><![CDATA[" . $row['ADD1'] . "]]></ADD1>";
        $ResponseXML .= "<ADD2><![CDATA[" . $row['ADD2'] . "]]></ADD2>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "pass_crn") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";







    $sql = "select * from vender_sub where c_code = '" . $_GET["custno"] . "'";
    //echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row_1 = mysqli_fetch_array($result)) {
        $ResponseXML .= "<NAME><![CDATA[" . trim($row_1['c_name']) . "]]></NAME>";
        $address = trim($row_1['c_add']); // . ",  " . trim($row_1['c_add1']);
        $ResponseXML .= "<ADD1><![CDATA[" . trim($address) . "]]></ADD1>";
        $ResponseXML .= "<ADD2><![CDATA[.]]></ADD2>";
        $ResponseXML .= "<id><![CDATA[" . $row_1['c_main'] . "]]></id>";
        $ResponseXML .= "<c_subcode><![CDATA[" . $row_1['c_code'] . "]]></c_subcode>";
        $ResponseXML .= "<str_vatno><![CDATA[" . trim($row_1["c_vatno"]) . "]]></str_vatno>";
        $ResponseXML .= "<str_svatno><![CDATA[" . trim($row_1["c_svatno"]) . "]]></str_svatno>";
    } else {
        $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
        if ($row = mysqli_fetch_array($sql)) {
            $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
            $ResponseXML .= "<ADD1><![CDATA[" . $row['ADD1'] . "]]></ADD1>";
            $ResponseXML .= "<ADD2><![CDATA[" . $row['ADD2'] . "]]></ADD2>";
            $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
            $ResponseXML .= "<c_subcode><![CDATA[" . $row['CODE'] . "]]></c_subcode>";
        }
    }



    //}

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "rep_outstand_state") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
        $ResponseXML .= "<ADD1><![CDATA[" . $row['ADD1'] . "]]></ADD1>";
        $ResponseXML .= "<ADD2><![CDATA[" . $row['ADD2'] . "]]></ADD2>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "rep_settlement") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "defective_item") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
        $ResponseXML .= "<ADD1><![CDATA[" . $row['ADD1'] . "]]></ADD1>";
        $ResponseXML .= "<ADD2><![CDATA[" . $row['ADD2'] . "]]></ADD2>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "incentive") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
        $ResponseXML .= "<ADD1><![CDATA[" . $row['ADD1'] . "]]></ADD1>";
        $ResponseXML .= "<ADD2><![CDATA[" . $row['ADD2'] . "]]></ADD2>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "bin_card") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "rep_dealercard") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "weekly_ord") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
        $ResponseXML .= "<ADD1><![CDATA[" . $row['ADD1'] . "]]></ADD1>";
        $ResponseXML .= "<ADD2><![CDATA[" . $row['ADD2'] . "]]></ADD2>";
        $ResponseXML .= "<vatno><![CDATA[" . $row['vatno'] . "]]></vatno>";
        $ResponseXML .= "<svatno><![CDATA[" . $row['svatno'] . "]]></svatno>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "weekly_tar") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
        $ResponseXML .= "<ADD1><![CDATA[" . $row['ADD1'] . "]]></ADD1>";
        $ResponseXML .= "<ADD2><![CDATA[" . $row['ADD2'] . "]]></ADD2>";
        $ResponseXML .= "<vatno><![CDATA[" . $row['vatno'] . "]]></vatno>";
        $ResponseXML .= "<svatno><![CDATA[" . $row['svatno'] . "]]></svatno>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "pass_utilization") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $_SESSION['uti_cus_code'] = $row['CODE'];
        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
        $ResponseXML .= "<ADD1><![CDATA[" . $row['ADD1'] . "]]></ADD1>";
        $ResponseXML .= "<ADD2><![CDATA[" . $row['ADD2'] . "]]></ADD2>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "pass_ret_cheque_entry") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $_SESSION["txt_cuscode"] = "";

    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
        $ResponseXML .= "<ADD1><![CDATA[" . $row['ADD1'] . "]]></ADD1>";
        $ResponseXML .= "<ADD2><![CDATA[" . $row['ADD2'] . "]]></ADD2>";
        $_SESSION["txt_cuscode"] = $row['CODE'];
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_item_claim") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vender_sub where c_code='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['c_main'] . "]]></id>";
        $ResponseXML .= "<c_subcode><![CDATA[" . $row['c_code'] . "]]></c_subcode>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['c_name'] . "]]></NAME>";
        $ResponseXML .= "<ADD1><![CDATA[" . $row['c_add'] . "]]></ADD1>";
        $ResponseXML .= "<ADD2><![CDATA[]]></ADD2>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_grn") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
        $ResponseXML .= "<ADD1><![CDATA[" . $row['ADD1'] . "]]></ADD1>";
        $ResponseXML .= "<ADD2><![CDATA[" . $row['ADD2'] . "]]></ADD2>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "add_gr") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $sql = mysqli_query($GLOBALS['dbinv'], "delete from guarentee_data where cus_code='" . $_GET['txt_cuscode'] . "' and gr_id='" . $_GET['gr_id'] . "'");
    $sql = mysqli_query($GLOBALS['dbinv'], "delete from s_guaratee where code='" . $_GET['txt_cuscode'] . "' and type='" . $_GET['gr_type'] . "'");

    if ($_GET['gr_status'] == "true") {
        $gr_status = 1;
    } else {
        $gr_status = 0;
    }
    //echo "insert into guarentee_data(cus_code, gr_type, gr_amount, gr_date, gr_status, gr_bank, gr_id) values ('".$_GET['txt_cuscode']."', '".$_GET['gr_type']."', '".$_GET['gr_amount']."', '".$_GET['gr_date']."', '".$gr_status."', '".$_GET['gr_bank']."', '".$_GET['gr_id']."')";
    $sql = mysqli_query($GLOBALS['dbinv'], "insert into guarentee_data(cus_code, gr_type, gr_amount, gr_date, gr_status, gr_bank, gr_id) values ('" . $_GET['txt_cuscode'] . "', '" . $_GET['gr_type'] . "', '" . $_GET['gr_amount'] . "', '" . $_GET['gr_date'] . "', '" . $gr_status . "', '" . $_GET['gr_bank'] . "', '" . $_GET['gr_id'] . "')") or die(mysqli_error());
    $sql = mysqli_query($GLOBALS['dbinv'], "insert into s_guaratee(code, type, amount, Expire, status, Bank) values ('" . $_GET['txt_cuscode'] . "', '" . $_GET['gr_type'] . "', '" . $_GET['gr_amount'] . "', '" . $_GET['gr_date'] . "', '" . $gr_status . "', '" . $_GET['gr_bank'] . "')") or die(mysqli_error());

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<sales_table><![CDATA[ <table width=\"300\" border=\"1\" cellspacing=\"0\">
    <tr>
    <td background=\"\" height=\"10\">ID</td>
    <td background=\"\" height=\"15\">Guarentee</td>
    <td background=\"\">Amount</td>
    <td background=\"\">Exp Date</td>
    <td background=\"\">Bank</td>
    <td background=\"\">Status</td>
    </tr>";

    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_guaratee where code='" . $_GET['txt_cuscode'] . "'") or die(mysqli_error());
    while ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<tr>
        <td >" . $row["id"] . "</td>
        <td >" . $row["type"] . "</td>
        <td >" . $row["amount"] . "</td>
        <td >" . $row["Expire"] . "</td>
        <td > " . $row["Bank"] . "</td>
        <td > " . $row["status"] . "</td>
        <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row["id"] . "  name=" . $row["id"] . " onClick=\"del_gr('" . $row["code"] . "', '" . $row["id"] . "');\"></td>
        </tr>";
    }
    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "del_gr") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    //echo "delete from guarentee_data where cus_code='".$_GET['txt_cuscode']."' and gr_id='".$_GET['gr_id']."'";
    $sql = mysqli_query($GLOBALS['dbinv'], "delete from guarentee_data where cus_code='" . $_GET['txt_cuscode'] . "' and gr_id='" . $_GET['gr_id'] . "'") or die(mysqli_error());
    $sql = mysqli_query($GLOBALS['dbinv'], "delete from s_guaratee where code='" . $_GET['txt_cuscode'] . "' and id='" . $_GET['gr_id'] . "'") or die(mysqli_error());



    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<sales_table><![CDATA[ <table width=\"300\" border=\"1\" cellspacing=\"0\">
    <tr>
    <td background=\"\" height=\"10\">ID</td>
    <td background=\"\" height=\"15\">Guarentee</td>
    <td background=\"\">Amount</td>
    <td background=\"\">Exp Date</td>
    <td background=\"\">Bank</td>
    <td background=\"\">Status</td>
    </tr>";

    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_guaratee where code='" . $_GET['txt_cuscode'] . "'") or die(mysqli_error());
    while ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<tr>
        <td >" . $row["id"] . "</td>
        <td >" . $row["type"] . "</td>
        <td >" . $row["amount"] . "</td>
        <td >" . $row["Expire"] . "</td>
        <td > " . $row["Bank"] . "</td>
        <td > " . $row["status"] . "</td>
        <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row["id"] . "  name=" . $row["id"] . " onClick=\"del_gr('" . $row["cus_code"] . "', '" . $row["gr_id"] . "');\"></td>
        </tr>";
    }
    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "del_item_rep_cat") {

    $sql1 = mysqli_query($GLOBALS['dbinv'], "delete from br_trn where cus_code='" . $_GET['txt_cuscode'] . "' and Rep='" . $_GET["rep"] . "'  and brand='" . $_GET["brand"] . "'") or die(mysqli_error());

    $doc_mod = $_GET["doc_mod"];

    echo "<table width=\"300\" border=\"1\" cellspacing=\"0\">
    <tr>
    <td background=\"\" height=\"25\">Credit Limit</td>
    <td background=\"\">Sales Rep</td>
    <td background=\"\">Cat</td>
    <td background=\"\">Type</td>
    </tr>";

    $cre_lim = 0;
    $sql1 = mysqli_query($GLOBALS['dbinv'], "Select * from br_trn where cus_code='" . $_GET['txt_cuscode'] . "'") or die(mysqli_error());
    while ($row1 = mysqli_fetch_array($sql1)) {
        $credit_lim = $row1["credit_lim"];
        $credit = $row1["credit"];
        $rep = trim($row1["Rep"]);
        $cat = trim($row1["CAT"]);
        $brand = trim($row1["brand"]);
        $days = trim($row1['days']);
        $balance = $credit_lim - $credit;



        echo "<tr>
        <td >" . $credit_lim . "</td>
        <td >" . $row1["Rep"] . "</td>";
        /* 	<td >".$credit."</td>
        <td > ".$balance."</td> */
        echo "<td >" . $row1["CAT"] . "</td>
        <td >" . $row1["brand"] . "</td>
        <td >" . $row1["days"] . "</td>
        <td><input type=\"button\" name=\"additem_tmp\" id=\"additem_tmp\" value=\"Select\" onClick=\"ass_lim('$credit_lim', '$rep', '$credit', '$balance', '$cat', '$brand','$days');\"></td>											
        <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item_rep_cat('$credit_lim', '$rep', '$credit', '$balance', '$cat', '$brand', '$doc_mod');\"></td>
        </tr>";
    }
    echo "</table>";
}


if ($_GET["Command"] == "pass_cusno_cust_mast") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $doc_mod = 0;

    $sql_permission = mysqli_query($GLOBALS['dbinv'], "Select * from view_userpermission where docname='Customer Master File' and username='" . $_SESSION["CURRENT_USER"] . "'") or die(mysqli_error());
    if ($row_permission = mysqli_fetch_array($sql_permission)) {
        if ($row_permission["doc_mod"] == "1") {
            $doc_mod = "1";
        }
    }

    $ResponseXML .= "<doc_mod><![CDATA[" . $doc_mod . "]]></doc_mod>";

    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $ResponseXML .= "<blacklist><![CDATA[" . $row['blacklist'] . "]]></blacklist>";
        $ResponseXML .= "<id><![CDATA[" . $row['CODE'] . "]]></id>";
        $ResponseXML .= "<NAME><![CDATA[" . $row['NAME'] . "]]></NAME>";
        $ResponseXML .= "<ADD1><![CDATA[" . $row['ADD1'] . "]]></ADD1>";
        $ResponseXML .= "<ADD2><![CDATA[" . $row['ADD2'] . "]]></ADD2>";
        $ResponseXML .= "<OPBAL><![CDATA[" . $row['OPBAL'] . "]]></OPBAL>";
        $ResponseXML .= "<TELE1><![CDATA[" . $row['TELE1'] . "]]></TELE1>";
        $ResponseXML .= "<TELE2><![CDATA[" . $row['TELE2'] . "]]></TELE2>";
        $ResponseXML .= "<CONT><![CDATA[" . $row['CONT'] . "]]></CONT>";
        $ResponseXML .= "<CUR_BAL><![CDATA[" . $row['CUR_BAL'] . "]]></CUR_BAL>";
        $ResponseXML .= "<LIMIT><![CDATA[" . $row['cLIMIT'] . "]]></LIMIT>";
        $ResponseXML .= "<PEN><![CDATA[" . $row['PEN'] . "]]></PEN>";
        $ResponseXML .= "<FAX><![CDATA[" . $row['FAX'] . "]]></FAX>";
        $ResponseXML .= "<acno><![CDATA[" . $row['acno'] . "]]></acno>";
        $ResponseXML .= "<EMAIL><![CDATA[" . $row['EMAIL'] . "]]></EMAIL>";
        $ResponseXML .= "<CAT><![CDATA[" . $row['CAT'] . "]]></CAT>";
        $ResponseXML .= "<svatno><![CDATA[" . $row['svatno'] . "]]></svatno>";
        $ResponseXML .= "<vatno><![CDATA[" . $row['vatno'] . "]]></vatno>";
        $ResponseXML .= "<OPDATE><![CDATA[" . $row['OPDATE'] . "]]></OPDATE>";
        $ResponseXML .= "<area><![CDATA[" . $row['area'] . "]]></area>";
        $ResponseXML .= "<CUS_TYPE><![CDATA[" . $row['cus_type'] . "]]></CUS_TYPE>";
        $ResponseXML .= "<note><![CDATA[" . $row['note'] . "]]></note>";
        $ResponseXML .= "<temp_limit><![CDATA[" . $row['temp_limit'] . "]]></temp_limit>";
        $ResponseXML .= "<bank_gr_date><![CDATA[" . $row['bank_gr_date'] . "]]></bank_gr_date>";
        $ResponseXML .= "<AltMessage><![CDATA[" . $row['AltMessage'] . "]]></AltMessage>";
        $ResponseXML .= "<incdays><![CDATA[" . $row['incdays'] . "]]></incdays>";
        $ResponseXML .= "<TXT_REP><![CDATA[" . $row['rep'] . "]]></TXT_REP>";
        $ResponseXML .= "<sales_cat><![CDATA[" . $row['field1'] . "]]></sales_cat>";
        $ResponseXML .= "<remark><![CDATA[" . $row['remark'] . "]]></remark>";
        $ResponseXML .= "<txtvatgroup><![CDATA[" . $row['vatgroup'] . "]]></txtvatgroup>";
        $ResponseXML .= "<txt_commcode><![CDATA[" . $row['commoncode'] . "]]></txt_commcode>";
        $ResponseXML .= "<TXT_REP><![CDATA[" . $row['rep'] . "]]></TXT_REP>";
        $ResponseXML .= "<district><![CDATA[" . $row['district'] . "]]></district>";

        $ResponseXML .= "<province><![CDATA[" . $row['province'] . "]]></province>";


        $ResponseXML .= "<gr_table><![CDATA[ <table width=\"300\" border=\"1\" cellspacing=\"0\">
        <tr>
        <td background=\"\" height=\"10\">ID</td>
        <td background=\"\" height=\"15\">Guarentee</td>
        <td background=\"\">Amount</td>
        <td background=\"\">Exp Date</td>
        <td background=\"\">Bank</td>
        <td background=\"\">Status</td>

        </tr>";

        $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_guaratee where code='" . $_GET['custno'] . "' order by id") or die(mysqli_error());
        while ($row = mysqli_fetch_array($sql)) {

            $ResponseXML .= "<tr>
            <td >" . $row["id"] . "</td>
            <td >" . $row["type"] . "</td>
            <td >" . $row["amount"] . "</td>
            <td >" . $row["Expire"] . "</td>
            <td > " . $row["Bank"] . "</td>
            <td > " . $row["status"] . "</td>
            <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row["id"] . "  name=" . $row["id"] . " onClick=\"del_gr('" . $row["code"] . "', '" . $row["id"] . "');\"></td>
            </tr>";
        }
        $ResponseXML .= "   </table>]]></gr_table>";


        $ResponseXML .= "<sales_table><![CDATA[ <table width=\"300\" border=\"1\" cellspacing=\"0\">
        <tr>
        <td background=\"\" height=\"25\">Credit Limit</td>
        <td background=\"\">Sales Rep</td>";
        /* <td background=\"\">Outstanding</td>
        <td background=\"\">Balance</td> */
        $ResponseXML .= "<td background=\"\">Cat</td>
        <td background=\"\">Type</td>
        </tr>";



        $cre_lim = 0;
        $sql1 = mysqli_query($GLOBALS['dbinv'], "Select credit_lim, credit, Rep, CAT, brand,days from br_trn where cus_code='" . $_GET['custno'] . "'") or die(mysqli_error());
        while ($row1 = mysqli_fetch_array($sql1)) {
            $credit_lim = $row1["credit_lim"];
            $credit = $row1["credit"];
            $rep = trim($row1["Rep"]);
            $cat = trim($row1["CAT"]);
            $brand = trim($row1["brand"]);
            $days = $row1['days'];
            $balance = $credit_lim - $credit;




            $ResponseXML .= "<tr>
            <td >" . $credit_lim . "</td>
            <td >" . $row1["Rep"] . "</td>";
            /* 	<td >".$credit."</td>
            <td > ".$balance."</td> */
            $ResponseXML .= "<td >" . $row1["CAT"] . "</td>
            <td >" . $row1["brand"] . "</td>
            <td >" . $row1["days"] . "</td>

            <td><input type=\"button\" name=\"additem_tmp\" id=\"additem_tmp\" value=\"Select\" onClick=\"ass_lim('$credit_lim', '$rep', '$credit', '$balance', '$cat', '$brand','$days');\"></td>
            <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item_rep_cat('$credit_lim', '$rep', '$credit', '$balance', '$cat', '$brand', '$doc_mod');\"></td>
            </tr>";

            if (trim($row1["CAT"]) == "C") {
                $cre_lim = $cre_lim + $credit_lim;
            }
            if (trim($row1["CAT"]) == "B") {
                $cre_lim = $cre_lim + $credit_lim * 2.5;
            }
            if (trim($row1["CAT"]) == "A") {
                $cre_lim = $cre_lim + $credit_lim * 2.5;
            }
        }

        $ResponseXML .= "   </table>]]></sales_table>";
    }


    $Out = 0;
    $pen = 0;
    $chq_rea = 0;
    $Ca_rea = 0;
    $R_chq = 0;
    $chno = 0;
    $RTNTOT = 0;



    $date = date("Y-m-d");
    $caldays = " - 90 days";
    $tmpdate = date('Y-m-d', strtotime($caldays));




    $sql_ch_rtn = mysqli_query($GLOBALS['dbinv'], "SELECT CR_CHNO, CR_CHEVAL from s_cheq where  (CR_DATE>'" . $tmpdate . "'or CR_DATE='" . $tmpdate . "')and (CR_DATE<'" . date("Y-m-d") . "'or CR_DATE='" . date("Y-m-d") . "') and CR_C_CODE = '" . trim($_GET['custno']) . "' and CR_FLAG='0' ORDER BY CR_CHNO") or die(mysqli_error());
    while ($row_ch_rtn = mysqli_fetch_array($sql_ch_rtn)) {

        if ($row_ch_rtn["CR_CHNO"] == $chno) {

        } else {
            $chno = $row_ch_rtn["CR_CHNO"];
            $RTNTOT = $RTNTOT + $row_ch_rtn["CR_CHEVAL"];
        }
    }

    $date = date("Y-m-d");
    $caldays = " -97 days";
    $tmpdate97 = date('Y-m-d', strtotime($caldays));

    $date = date("Y-m-d");
    $caldays = " -7 days";
    $tmpdate7 = date('Y-m-d', strtotime($caldays));

    $sql_ch_rea = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as reatot from view_s_invcheq where cus_code='" . trim($_GET['custno']) . "'  and ( che_date>'" . $tmpdate97 . "' or che_date ='" . $tmpdate97 . "')  and ( che_date<'" . $tmpdate7 . "' or che_date ='" . $tmpdate7 . "') and trn_type != 'RET'") or die(mysqli_error());
    $row_ch_rea = mysqli_fetch_array($sql_ch_rea);

    $date = date("Y-m-d");
    $caldays = " -7 days";
    $tmpdate90 = date('Y-m-d', strtotime($caldays));

    $sql_cash_rea = mysqli_query($GLOBALS['dbinv'], "select sum(CA_CASSH) as ca_reatot from s_crec where CA_CODE = '" . trim($_GET['custno']) . "' and ( CA_DATE>'" . $tmpdate90 . "' or CA_DATE ='" . $tmpdate90 . "')  and ( CA_DATE<'" . date("Y-m-d") . "' or CA_DATE ='" . date("Y-m-d") . "') and CANCELL = '0' and FLAG = 'REC'") or die(mysqli_error());
    $row_cash_rea = mysqli_fetch_array($sql_cash_rea);

    $sql_ch_pen1 = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as pentot1 from view_s_invcheq where ch_count_ret='0' and cus_code='" . trim($_GET['custno']) . "'  and ( che_date>'" . date("Y-m-d") . "' or che_date ='" . date("Y-m-d") . "')  and month(che_date) = '" . date("m") . "'") or die(mysqli_error());
    $row_ch_pen1 = mysqli_fetch_array($sql_ch_pen1);

    $sql_ch_pen2 = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as pentot2 from view_s_invcheq where ch_count_ret='0' and cus_code='" . trim($_GET['custno']) . "'  and ( che_date>'" . date("Y-m-d") . "' or che_date ='" . date("Y-m-d") . "') ") or die(mysqli_error());
    $row_ch_pen2 = mysqli_fetch_array($sql_ch_pen2);

    $sql_salma = mysqli_query($GLOBALS['dbinv'], "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE='" . trim($_GET['custno']) . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1") or die(mysqli_error());
    $row_salma = mysqli_fetch_array($sql_salma);

    $sql_c_rtn = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL - PAID) as Rtn from s_cheq where CR_C_CODE = '" . trim($_GET['custno']) . "' and CR_FLAG = '0' and CR_CHEVAL - PAID > 1") or die(mysqli_error());

    $row_c_rtn = mysqli_fetch_array($sql_c_rtn);


    if (is_null($row_salma["out1"]) == false) {
        $Out = $row_salma["out1"];
    }
    if (is_null($row_ch_pen2["pentot2"]) == false) {
        $pen = $row_ch_pen2["pentot2"];
    }
    if (is_null($row_ch_rea["reatot"]) == false) {
        $chq_rea = $row_ch_rea["reatot"];
    }
    if (is_null($row_cash_rea["ca_reatot"]) == false) {
        $Ca_rea = $row_cash_rea["ca_reatot"];
    }
    if (is_null($row_c_rtn["Rtn"]) == false) {
        $R_chq = $row_c_rtn["Rtn"];
    }

    $ResponseXML .= "<info_table><![CDATA[ <table width=\"200\" border=\"1\" cellspacing=\"0\">
    <tr>
    <td background=\"\" height=\"25\">Info Type</td>
    <td background=\"\">Amount</td>
    </tr>";

    $ResponseXML .= "<tr><td>Last 3 Month Rtn Chqs</td><td align=right>" . number_format($RTNTOT, 2, ".", ",") . "</td></tr>
    <tr>	<td>Last 3 Month Settlements</td><td align=right>" . number_format(($chq_rea + $Ca_rea), 2, ".", ",") . "</td></tr>
    <tr>	<td>Next 3 month Chqs to be realize</td><td align=right>" . number_format(($Out + $pen), 2, ".", ",") . "</td></tr>
    <tr>	<td>Current Rtn Chqs</td><td align=right>" . number_format($R_chq, 2, ".", ",") . "</td></tr>
    <tr>	<td>Current month Pending Chqs</td><td align=right>" . number_format($row_ch_pen1["pentot1"], 2, ".", ",") . "</td></tr>";

    $ResponseXML .= "   </table>]]></info_table>";




    $ResponseXML .= "<cre_lim><![CDATA[" . $cre_lim . "]]></cre_lim>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}



if ($_GET["Command"] == "pass_repno_cust_mast") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $ResponseXML .= "<code><![CDATA[" . $row['CODE'] . "]]></code>";
        $ResponseXML .= "<name><![CDATA[" . $row['NAME'] . "]]></name>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_cus_cash_rec") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";



    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $ResponseXML .= "<code><![CDATA[" . $row['CODE'] . "]]></code>";
        $ResponseXML .= "<name><![CDATA[" . $row['NAME'] . "]]></name>";
        $ResponseXML .= "<address><![CDATA[" . $row['ADD1'] . " " . $row['ADD2'] . "]]></address>";
    }

    $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=1  cellspacing=0>
    <tr><td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\"></font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Date</font></td>
    <td width=\"200\"  background=\"\" ><font color=\"#FFFFFF\">Invoice No</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Value</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Paid</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Overdue</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Chq Pay</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Chq Balance</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Cash Pay</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Inv Balance</font></td></tr>";

    //$sql = mysqli_query($GLOBALS['dbinv'],"Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and DEV='" & rsusercon!dev & "' and CANCELL='0' and SAL_EX='" & Trim(Left(Com_rep, 5)) & "' and Accname <> 'NON STOCK' ORDER BY SDATE") or die(mysqli_error());
    //	echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0' and SAL_EX='".$_GET["refno"]."' and Accname <> 'NON STOCK' ORDER BY SDATE";

    $i = 1;
    //	echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0'  ORDER BY SDATE";

    if ($_GET['refno'] == "") {
        $sql = mysqli_query($GLOBALS['dbinv'], "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='" . $_GET['custno'] . "' and GRAND_TOT > TOTPAY and (GRAND_TOT-TOTPAY)>0 and CANCELL='0' and DEV='" . $_SESSION['dev'] . "' ORDER BY SDATE") or die(mysqli_error());
    } else {

        $sql = mysqli_query($GLOBALS['dbinv'], "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='" . $_GET['custno'] . "' and GRAND_TOT > TOTPAY and (GRAND_TOT-TOTPAY)>0 and CANCELL='0' and SAL_EX='" . $_GET['refno'] . "' and DEV='" . $_SESSION['dev'] . "'  ORDER BY SDATE") or die(mysqli_error());
    }
    while ($row = mysqli_fetch_array($sql)) {

        $sdate = "sdate" . $i;
        $delidate = "delidate" . $i;

        $invval = "invval" . $i;


        //if (is_null($row["deli_date"]==false)){
        if (is_null($row["deli_date"] == false) or ( $row["deli_date"] != "0000-00-00")) {


            //$ResponseXML .= "<tr><td><div id=".$delidate.">".$row["REQ_DATE"]."</div></td>";
            $ResponseXML .= "<tr><td><div id=" . $delidate . ">" . $row["deli_date"] . "</div></td>";
        } else {
            $ResponseXML .= "<tr><td><div id=" . $delidate . ">" . $row["SDATE"] . "</div></td>";
        }

        $ResponseXML .= "<td><div id=" . $sdate . ">" . $row["SDATE"] . "</div></td>";

        $j = $i + 1;

        $overdue = "overdue" . $i;

        $chq_pay = "chq_pay" . $i;
        $chq_pay_next = "chq_pay" . $j;

        $chq_balance = "chq_balance" . $i;
        $chq_balance_next = "chq_balance" . $j;

        $cash_pay = "cash_pay" . $i;
        $cash_pay_next = "cash_pay" . $j;

        $inv_balance = "inv_balance" . $i;
        $overdueamt = $row["GRAND_TOT"] - $row["TOTPAY"];
        //number_format($row["GRAND_TOT"]-$row["TOTPAY"], 2, ".")

        $invno = "invno" . $i;

        $ResponseXML .= "<td><div id=" . $invno . ">" . $row["REF_NO"] . "</div></td>
        <td><div id=" . $invval . "  align=right>" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</div></td>
        <td align=right>" . number_format($row["TOTPAY"], 2, ".", ",") . "</td>
        <td><input type=\"text\"  class=\"text_purchase3_right\" name=" . $overdue . " id=" . $overdue . " value=" . number_format($overdueamt, 2, ".", "") . " size=\"10\" disabled  align=right/></td>
        <td><input type=\"text\" align=\"right\"  class=\"text_purchase3_right\" name=" . $chq_pay . " id=" . $chq_pay . " onBlur=\"calc_bal('$overdue', '$chq_pay', '$inv_balance', '$chq_balance', '$chq_balance_next', '$cash_pay', '$i', event);\"  onKeyPress=\"keyset('$chq_pay_next', event);\"   size=\"10\"/></td>									
        <td><input type=\"text\" align=\"right\"  class=\"text_purchase3_right\" name=" . $chq_balance . " disabled id=" . $chq_balance . " onKeyPress=\"keysetvalue('$chq_balance','$chq_balance_next', '$chq_pay', event);\" size=\"10\"/></td>
        <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $cash_pay . " id=" . $cash_pay . " onBlur=\"calc_bal_cash('$overdue', '$cash_pay_next', '$chq_pay', '$inv_balance', '$cash_pay', event);\" onKeyPress=\"keyset('$cash_pay_next', event);\" size=\"10\"/></td>
        <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $inv_balance . " id=" . $inv_balance . " disabled size=\"10\"/></td></tr>";
        $i = $i + 1;
    }


    $overdue = "overdue" . $i;

    $chq_pay = "chq_pay" . $i;
    $chq_pay_next = "chq_pay" . $j;

    $chq_balance = "chq_balance" . $i;
    $chq_balance_next = "chq_balance" . $j;

    $cash_pay = "cash_pay" . $i;
    $cash_pay_next = "cash_pay" . $j;

    $inv_balance = "inv_balance" . $i;
    $overdueamt = $row["GRAND_TOT"] - $row["TOTPAY"];
    $invno = "invno" . $i;
    $ResponseXML .= "<tr><td><td></td>
    <td></td><div id=" . $invno . "></div></td>
    <td></td>
    <td></td>
    <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $overdue . " id=" . $overdue . " value=" . $overdueamt . " size=\"10\"/></td>
    <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $chq_pay . " id=" . $chq_pay . " onBlur=\"calc_bal('$overdue', '$chq_pay', '$inv_balance', '$chq_balance', '$chq_balance_next', '$cash_pay', '$i', event);\"  onKeyPress=\"keyset('$chq_pay_next', event);\"   size=\"10\"/></td>									
    <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $chq_balance . " id=" . $chq_balance . " onKeyPress=\"keysetvalue('$chq_balance','$chq_balance_next', '$chq_pay', event);\" size=\"10\"/></td>
    <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $cash_pay . " id=" . $cash_pay . " onKeyPress=\"calc_bal_cash('$overdue', '$cash_pay_next', '$chq_pay', '$inv_balance', '$cash_pay', event);\" size=\"10\"/></td>
    <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $inv_balance . " id=" . $inv_balance . " disabled size=\"10\"/></td></tr>";

    $_SESSION["count"] = $i;
    $ResponseXML .= "   </table>]]></sales_table_acc>";
    $ResponseXML .= "<mcount><![CDATA[" . $_SESSION["count"] . "]]></mcount>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_ret_chq_settle") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";



    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $ResponseXML .= "<code><![CDATA[" . $row['CODE'] . "]]></code>";
        $ResponseXML .= "<name><![CDATA[" . $row['NAME'] . "]]></name>";
        $ResponseXML .= "<address><![CDATA[" . $row['ADD1'] . " " . $row['ADD2'] . "]]></address>";
    }

    $ResponseXML .= "<sales_table_acc><![CDATA[ <table  bgcolor=\"#003366\" border=1  cellspacing=0>
    <tr>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Rtn Count</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Doc.Date</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Doc.No</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Chq.No</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Chq.Date</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Chq.Val</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Chq.Paid</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Chq.Bal</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Set.Amount</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Balance</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Cash</font></td>
    <td width=\"80\"  background=\"\" ><font color=\"#FFFFFF\">Ret.Chq.bal</font></td></tr>";

    //$sql = mysqli_query($GLOBALS['dbinv'],"Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and DEV='" & rsusercon!dev & "' and CANCELL='0' and SAL_EX='" & Trim(Left(Com_rep, 5)) & "' and Accname <> 'NON STOCK' ORDER BY SDATE") or die(mysqli_error());
    //	echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0' and SAL_EX='".$_GET["refno"]."' and Accname <> 'NON STOCK' ORDER BY SDATE";

    $i = 1;
    //	echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0'  ORDER BY SDATE";

    $sql = mysqli_query($GLOBALS['dbinv'], "select * from s_cheq where CR_C_CODE='" . trim($row['CODE']) . "' and CR_CHEVAL+CR_REPAY>PAID and CR_FLAG='0'") or die(mysqli_error());

    while ($row = mysqli_fetch_array($sql)) {



        $j = $i + 1;

        $docdate = "docdate" . $i;
        $docno = "docno" . $i;
        $chqval = "chqval" . $i;
        $chqno = "chqno" . $i;
        $chqdate = "chqdate" . $i;

        $chqbal = "chqbal" . $i;
        $chqbal_next = "chqbal" . $j;
        $chq_bal_val = $row["CR_CHEVAL"] - $row["PAID"] + $row["CR_REPAY"];

        $setamount = "setamount" . $i;
        $setamount_next = "setamount" . $j;

        $balance = "balance" . $i;
        $balance_next = "balance" . $j;

        $cash = "cash" . $i;
        $cash_next = "cash" . $j;

        $retchqbal = "retchqbal" . $i;
        $retchqbal_next = "retchqbal" . $j;

        $inv_balance = "inv_balance" . $i;
        $overdueamt = $row["GRAND_TOT"] - $row["TOTPAY"];
        //number_format($row["GRAND_TOT"]-$row["TOTPAY"], 2, ".")

        $invno = "invno" . $i;

        $ResponseXML .= "<tr><td><font color=\"#FFFFFF\">" . $row['retcout'] . "</font></td><td><font color=\"#FFFFFF\"><div id=" . $docdate . ">" . $row["CR_DATE"] . "</div></font></td>
        <td><font color=\"#FFFFFF\"><div id=" . $docno . ">" . $row["CR_REFNO"] . "</div></font></td>
        <td><font color=\"#FFFFFF\"><div id=" . $chqno . ">" . $row["CR_CHNO"] . "</div></font></td>
        <td><font color=\"#FFFFFF\"><div id=" . $chqdate . ">" . $row["CR_CHDATE"] . "</div></font></td>
        <td><font color=\"#FFFFFF\"><div id=" . $chqval . ">" . number_format($row["CR_CHEVAL"] + $row["CR_REPAY"], 2, ".", ",") . "</div></font></td>
        <td><font color=\"#FFFFFF\">" . number_format($row["PAID"], 2, ".", ",") . "</font></td>
        <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $chqbal . " id=" . $chqbal . " value=" . number_format($chq_bal_val, 2, ".", ",") . " size=\"10\"/></td>
        <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $setamount . " id=" . $setamount . " onBlur=\"calc_bal('$chqbal', '$setamount', '$retchqbal', '$balance', '$balance_next', '$cash', '$i', event);\"  onKeyPress=\"keyset('$setamount_next', event);\"   size=\"10\"/></td>									
        <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $balance . " id=" . $balance . " onKeyPress=\"keysetvalue('$balance','$balance_next', '$setamount', event);\" size=\"10\"/></td>
        <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $cash . " id=" . $cash . " onBlur=\"calc_bal_cash('$chqbal', '$cash_next', '$setamount', '$retchqbal', '$cash', event);\" size=\"10\"/></td>
        <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $retchqbal . " id=" . $retchqbal . " disabled size=\"10\"/></td></tr>";



        $i = $i + 1;
    }


    $j = $i + 1;

    $docdate = "docdate" . $i;
    $docno = "docno" . $i;
    $chqval = "chqval" . $i;
    $chqno = "chqno" . $i;
    $chqdate = "chqdate" . $i;

    $chqbal = "chqbal" . $i;
    $chqbal_next = "chqbal" . $j;
    $chq_bal_val = $row["CR_CHEVAL"] - $row["PAID"];

    $setamount = "setamount" . $i;
    $setamount_next = "setamount" . $j;

    $balance = "balance" . $i;
    $balance_next = "balance" . $j;

    $cash = "cash" . $i;
    $cash_next = "cash" . $j;

    $retchqbal = "retchqbal" . $i;
    $retchqbal_next = "retchqbal" . $j;

    $inv_balance = "inv_balance" . $i;
    $overdueamt = $row["GRAND_TOT"] - $row["TOTPAY"];
    //number_format($row["GRAND_TOT"]-$row["TOTPAY"], 2, ".")

    $invno = "invno" . $i;

    $ResponseXML .= "<tr><td><font color=\"#FFFFFF\"><div id=" . $docdate . ">" . $row["CR_DATE"] . "</div></font></td>
    <td><font color=\"#FFFFFF\"><div id=" . $docno . ">" . $row["CR_REFNO"] . "</div></font></td>
    <td><font color=\"#FFFFFF\"><div id=" . $chqno . ">" . $row["CR_CHNO"] . "</div></font></td>
    <td><font color=\"#FFFFFF\"><div id=" . $chqdate . ">" . $row["CR_CHDATE"] . "</div></font></td>
    <td><font color=\"#FFFFFF\"><div id=" . $chqval . ">" . number_format($row["CR_CHEVAL"], 2, ".", ",") . "</div></font></td>
    <td><font color=\"#FFFFFF\">" . number_format($row["PAID"], 2, ".", ",") . "</font></td>
    <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $chqbal . " id=" . $chqbal . " value=" . number_format($chq_bal_val, 2, ".", ",") . " size=\"10\"/></td>
    <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $setamount . " id=" . $setamount . " onBlur=\"calc_bal('$chqbal', '$setamount', '$retchqbal', '$balance', '$balance_next', '$cash', '$i', event);\"  onKeyPress=\"keyset('$setamount_next', event);\"   size=\"10\"/></td>									
    <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $balance . " id=" . $balance . " onBlur=\"keysetvalue('$balance','$balance_next', '$setamount', event);\" size=\"10\"/></td>
    <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $cash . " id=" . $cash . " onBlur=\"calc_bal_cash('$chqbal', '$cash_next', '$setamount', '$retchqbal', '$cash', event);\" size=\"10\"/></td>
    <td><input type=\"text\" align=\"right\" class=\"text_purchase3_right\" name=" . $retchqbal . " id=" . $retchqbal . " disabled size=\"10\"/></td></tr>";


    $_SESSION["ret_count"] = $i;
    $ResponseXML .= "   </table>]]></sales_table_acc>";
    $ResponseXML .= "<mcount><![CDATA[" . $i . "]]></mcount>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "update_limit") {
    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from br_trn where cus_code='" . $_GET['txt_cuscode'] . "' and Rep='" . $_GET['rep'] . "' and brand='" . $_GET['brand'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $sql1 = mysqli_query($GLOBALS['dbinv'], "update  br_trn set credit_lim=" . $_GET['txtlimit'] . ", CAT='" . $_GET['cmbCAt'] . "',days = '" . $_GET['days'] . "' where cus_code='" . $_GET['txt_cuscode'] . "' and Rep='" . $_GET['rep'] . "' and brand='" . $_GET['brand'] . "'") or die(mysqli_error());
    } else {
        $sqlq = "insert into br_trn (cus_code, Rep, credit_lim, brand, CAT,days) values ('" . $_GET['txt_cuscode'] . "', '" . $_GET['rep'] . "', " . $_GET['txtlimit'] . ", '" . $_GET['brand'] . "', '" . $_GET['cmbCAt'] . "','" . $_GET['days'] . "') ";
        // echo $sqlq;
        $sql1 = mysqli_query($GLOBALS['dbinv'], $sqlq) or die(mysqli_error());
    }

    if ($_GET["stopinv"] == "true") {
        $sql1 = mysqli_query($GLOBALS['dbinv'], "update  vendor set blacklist='1' where CODE='" . $_GET['txt_cuscode'] . "'") or die(mysqli_error());
    } else {
        $sql1 = mysqli_query($GLOBALS['dbinv'], "update  vendor set blacklist='0' where CODE='" . $_GET['txt_cuscode'] . "'") or die(mysqli_error());
    }

    $sql = mysqli_query($GLOBALS['dbinv'], "Select sum(credit_lim) as tot from br_trn where cus_code='" . $_GET['txt_cuscode'] . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        $totcr = $row["tot"];
    } else {
        $totcr = 0;
    }

    $sql1 = mysqli_query($GLOBALS['dbinv'], "update vendor set cLIMIT=" . $totcr . " where CODE='" . $_GET['txt_cuscode'] . "'") or die(mysqli_error());


    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<totcr><![CDATA[" . $totcr . "]]></totcr>";
    $ResponseXML .= "<cre_table><![CDATA[ <table width=\"300\" border=\"1\" cellspacing=\"0\">
    <tr>
    <td background=\"\" height=\"25\">Credit Limit</td>
    <td background=\"\">Sales Rep</td>
    <td background=\"\">Outstanding</td>
    <td background=\"\">Balance</td>
    <td background=\"\">Cat</td>
    <td background=\"\">Type</td>
    <td background=\"\">Days</td>
    </tr>";

    $cre_lim = 0;
    $sql1 = mysqli_query($GLOBALS['dbinv'], "Select credit_lim, credit, Rep, CAT, brand,days from br_trn where cus_code='" . $_GET['txt_cuscode'] . "'") or die(mysqli_error());
    while ($row1 = mysqli_fetch_array($sql1)) {
        $credit_lim = $row1["credit_lim"];
        $credit = $row1["credit"];
        $rep = trim($row1["Rep"]);
        $cat = trim($row1["CAT"]);
        $brand = trim($row1["brand"]);
        $days = $row1['days'];
        $balance = $credit_lim - $credit;




        $ResponseXML .= "<tr>
        <td >" . $credit_lim . "</td>
        <td >" . $row1["Rep"] . "</td>";
        /* 	<td >".$credit."</td>
        <td > ".$balance."</td> */
        $ResponseXML .= "<td >" . $row1["CAT"] . "</td>
        <td >" . $row1["brand"] . "</td>
        <td >" . $row1["days"] . "</td>

        <td><input type=\"button\" name=\"additem_tmp\" id=\"additem_tmp\" value=\"Select\" onClick=\"ass_lim('$credit_lim', '$rep', '$credit', '$balance', '$cat', '$brand','$days');\"></td>
        <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item_rep_cat('$credit_lim', '$rep', '$credit', '$balance', '$cat', '$brand', '$doc_mod');\"></td>
        </tr>";

        if (trim($row1["CAT"]) == "C") {
            $cre_lim = $cre_lim + $credit_lim;
        }
        if (trim($row1["CAT"]) == "B") {
            $cre_lim = $cre_lim + $credit_lim * 2.5;
        }
        if (trim($row1["CAT"]) == "A") {
            $cre_lim = $cre_lim + $credit_lim * 2.5;
        }
    }

    $ResponseXML .= "   </table>]]></cre_table>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "delete_limit") {
    $sql = mysqli_query($GLOBALS['dbinv'], "delete from br_trn where cus_code='" . $_GET['txt_cuscode'] . "' and Rep='" . $_GET['rep'] . "' and brand='" . $_GET['brand'] . "'") or die(mysqli_error());



    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<totcr><![CDATA[" . $totcr . "]]></totcr>";
    $ResponseXML .= "<cre_table><![CDATA[ <table width=\"300\" border=\"1\" cellspacing=\"0\">
    <tr>
    <td background=\"\" height=\"25\">Credit Limit</td>
    <td background=\"\">Sales Rep</td>
    <td background=\"\">Outstanding</td>
    <td background=\"\">Balance</td>
    <td background=\"\">Cat</td>
    <td background=\"\">Type</td>
    <td background=\"\">Days</td>
    </tr>";

    $cre_lim = 0;
    $sql1 = mysqli_query($GLOBALS['dbinv'], "Select * from br_trn where cus_code='" . $_GET['txt_cuscode'] . "'") or die(mysqli_error());
    while ($row1 = mysqli_fetch_array($sql1)) {
        $credit_lim = $row1["credit_lim"];
        $credit = $row1["credit"];
        $rep = $row1["Rep"];
        $cat = $row1["CAT"];
        $brand = $row1["brand"];
        $days = $row1['days'];
        $balance = $credit_lim - $credit;



        $ResponseXML .= "<tr>
        <td >" . $credit_lim . "</td>
        <td >" . $row1["Rep"] . "</td>
        <td >" . $credit . "</td>
        <td > " . $balance . "</td>
        <td >" . $row1["CAT"] . "</td>
        <td >" . $row1["brand"] . "</td>
        <td >" . $row1["days"] . "</td>
        <td><input type=\"button\" name=\"additem_tmp\" id=\"additem_tmp\" value=\"Select\" onClick=\"ass_lim('$credit_lim', '$rep', '$credit', '$balance', '$cat', '$brand','$days');\"></td>

        </tr>";

        if ($row1["CAT"] == "C") {
            $cre_lim = $cre_lim + $credit_lim;
        }
        if ($row1["CAT"] == "B") {
            $cre_lim = $cre_lim + $credit_lim * 2.5;
        }
        if ($row1["CAT"] == "A") {
            $cre_lim = $cre_lim + $credit_lim * 2.5;
        }
    }

    $ResponseXML .= "   </table>]]></cre_table>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_POST["Command"] == "note_update") {
    //echo "update vendor set note= '".trim($_POST["txtnote"])."' where code='".trim($_POST["txt_cuscode"])."'";
    $sql = mysqli_query($GLOBALS['dbinv'], "update vendor set note= '" . trim($_POST["txtnote"]) . "' where code='" . trim($_POST["txt_cuscode"]) . "'") or die(mysqli_error());
    $sql = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["txt_cuscode"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Note Updated, 'Update', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
    $result = mysql_query($sql);
}

if ($_GET["Command"] == "app_only_for") {
    //echo "update vendor set note= '".trim($_GET["txtnote"])."' where code='".trim($_GET["txt_cuscode"])."'";
    $sql = mysqli_query($GLOBALS['dbinv'], "insert into tmpcrlmt (sdate, stime, username, tmpLmt, Class, Rep, cusCode, crLmt, cat, FLAG) values ('" . date("Y-m-d") . "','" . date("H:m:s") . "', '', '0', 'NB', 'NR', '" . trim($_GET["txt_cuscode"]) . "', '0','','PER' )") or die(mysqli_error());

    $sql = mysqli_query($GLOBALS['dbinv'], "update vendor set Over_DUE_IG_Date='" . $_GET["DT_Over_DUE_IG"] . "'  where CODE='" . trim($_GET["txt_cuscode"]) . "'") or die(mysqli_error());
    echo "Over 60 Outstanding and Return Cheque Ignore for the billing ";

    $sql = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["txt_cuscode"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Return Cheque Ignore, 'Update', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
    $result = mysql_query($sql);
}
if ($_GET["Command"] == "custmast_inv") {
   

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from invpara ") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
       
        $ResponseXML .= "<txt_cuscode><![CDATA[" . $row['A'] . "]]></txt_cuscode>";
    }
    
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "set_cus_no") {
   
    $sql = mysqli_query($GLOBALS['dbinv'], " select " . $_GET["cmbcat"] . " from invpara") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
       

        // $tmpinvno = "0000" . $row[$_GET["cmbcat"]];
        // $lenth = strlen($tmpinvno);
        // $cus_no = $_GET["cmbcat"] . substr($tmpinvno, $lenth -4);

        $cus_no = $_GET["cmbcat"] . $row[$_GET["cmbcat"]];

        echo $cus_no;
    }
}

mysqli_close($GLOBALS['dbinv']);
mysqli_close($GLOBALS['dbacc']);
?>
