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

if ($_GET["Command"] == "search_inv") {

    $ResponseXML = "";


    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
						<tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque No</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sales Ex</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Chq Amount</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Chq Date</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Chq Extn Date</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Approved</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Acc Appro</font></td>
						</tr>";



    //  $letters = $_GET['invno'];
    //  $sql = mysqli_query($GLOBALS['dbinv'],"select * from s_invcheq where cheque_no like '$letters%' ORDER BY che_date desc limit 50") or die(mysqli_error());
    //  echo "select * from s_invcheq where cheque_no like '$letters%' ORDER BY che_date desc limit 50";
    /* if ($_GET["mstatus"]=="invno"){
      $letters = $_GET['invno'];
      //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
      //$letters="/".$letters;
      //$a="SELECT * from s_salma where REF_NO like  '$letters%'";
      //echo $a;
      $sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_purmas where  REFNO like  '$letters%' order by id desc") or die(mysqli_error());
      } else if ($_GET["mstatus"]=="customername"){
      $letters = $_GET['customername'];
      //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
      $sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_purmas where SUP_NAME like  '$letters%' order by id desc") or die(mysqli_error()) or die(mysqli_error());
      } else {
      $letters = $_GET['customername'];
      //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
      $sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_purmas where SUP_NAME like  '$letters%' order by id desc") or die(mysqli_error()) or die(mysqli_error());
      } */

    require_once("connectioni.php");



    $letters = $_GET['invno'];

    $sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  ch_no like '" . $letters . "%' ORDER BY sdate desc limit 50";

    if ($_GET["mstatus"] == "Option1") {
        $sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  ch_no like '" . $letters . "%' ORDER BY ch_exdate desc limit 50";
    }
    if ($_GET["mstatus"] == "Option2") {
        $sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  approved = '0'  and  ch_no like '" . $letters . "%' ORDER BY ch_exdate desc limit 50";
    }
    if ($_GET["mstatus"] == "Option3") {
        $sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  approved != '0' and acc_approved ='0' and  ch_no like '" . $letters . "%' ORDER BY ch_exdate desc limit 50";
    }
    if ($_GET["mstatus"] == "Option4") {
        $sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  acc_approved !='0' and  ch_no like '" . $letters . "%' ORDER BY ch_exdate desc limit 50";
    }

    //echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $ResponseXML .= "<tr>               
                              <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\">" . $row['ch_no'] . "</a></td>
                              <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\">" . $row['refno'] . "</a></td>
                              <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\">" . $row['sal_ex'] . "</a></td>
							  <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\">" . $row['ch_amount'] . "</a></td>
							   <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\">" . $row['ch_date'] . "</a></td>
							   <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\">" . $row['ch_exdate'] . "</a></td>
							   <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\">" . $row['approved'] . "</a></td>
							   <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\">" . $row['acc_approved'] . "</a></td>
                            </tr>";
    }




    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}


if ($_GET["Command"] == "select_list") {

    require_once("connectioni.php");



    echo "<table><tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque No</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sales Ex</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Chq Amount</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Chq Date</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Chq Extn Date</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Approved</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Acc Appro</font></td>
</tr>";



    require_once("connectioni.php");



    $sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved,ins  from  s_cheque_extend ORDER BY id desc limit 50";

    if ($_GET["mstatus"] == "Option1") {
        $sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved,ins  from  s_cheque_extend where  ch_no like '" . $_GET["chqno"] . "%' ORDER BY id desc limit 50";
    }
    if ($_GET["mstatus"] == "Option2") {
        $sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved,ins  from  s_cheque_extend where  approved = '0'  and  ch_no like '" . $_GET["chqno"] . "%' ORDER BY id desc limit 50";
    }
    if ($_GET["mstatus"] == "Option3") {
        $sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved,ins  from  s_cheque_extend where  approved != '0' and app = '0' and acc_approved ='0' and  ch_no like '" . $_GET["chqno"] . "%' ORDER BY id desc limit 50";
    }
    if ($_GET["mstatus"] == "Option4") {
        $sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved,ins  from  s_cheque_extend where  acc_approved !='0' and  ch_no like '" . $_GET["chqno"] . "%' ORDER BY id desc limit 50";
    }

    //echo $sql;

    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $bgcolou = "";
        if ($row['ins'] == "YES") {
            $bgcolou = "#FF0000";
        }

        echo "<tr bgcolour = '" . $bgcolou . "'>               
                              <td  onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\"><font color='" . $bgcolou . "'>" . $row['ch_no'] . "</a></td>
                              <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\"><font color='" . $bgcolou . "'>" . $row['refno'] . "</a></td>
                              <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\"><font color='" . $bgcolou . "'>" . $row['sal_ex'] . "</a></td>
							  <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\"><font color='" . $bgcolou . "'>" . $row['ch_amount'] . "</a></td>
							   <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\"><font color='" . $bgcolou . "'>" . $row['ch_date'] . "</a></td>
							   <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\"><font color='" . $bgcolou . "'>" . $row['ch_exdate'] . "</a></td>
							   <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\"><font color='" . $bgcolou . "'>" . $row['approved'] . "</a></td>
							   <td onclick=\"chq_extn('" . $row['ch_no'] . "', '" . $row['refno'] . "');\"><font color='" . $bgcolou . "'>" . $row['acc_approved'] . "</a></td>
                            </tr>";
    }

    echo "</table>";
}


if ($_GET["Command"] == "pass_arr") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    if (trim($_GET["txtChequeNo"]) != "") {
        //$sql = mysqli_query($GLOBALS['dbinv'],"select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' and che_amount = '".$_GET["che_amount"]."'") or die(mysqli_error());

        $sql = mysqli_query($GLOBALS['dbinv'], "select * from  s_invcheq where  cheque_no='" . trim($_GET["txtChequeNo"]) . "' and che_date = '" . $_GET["che_date"] . "' ") or die(mysqli_error());
        //echo "select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."'";
        if ($row = mysqli_fetch_array($sql)) {
            //$ResponseXML .= "<lblReciptNo><![CDATA[".$row['refno']."]]></lblReciptNo>";
            $ResponseXML .= "<Txtcusco><![CDATA[" . $row['cus_code'] . "]]></Txtcusco>";
            $ResponseXML .= "<txtcusname><![CDATA[" . $row['CUS_NAME'] . "]]></txtcusname>";

            $sql1 = mysqli_query($GLOBALS['dbinv'], "Select * from s_salrep where REPCODE='" . $row["sal_ex"] . "'") or die(mysqli_error());
            if ($row1 = mysqli_fetch_array($sql1)) {
                $ResponseXML .= "<com_rep><![CDATA[" . $row1['REPCODE'] . "]]></com_rep>";
            } else {
                $ResponseXML .= "<com_rep><![CDATA[]]></com_rep>";
            }
            $ResponseXML .= "<txtChequeNo><![CDATA[" . $row['cheque_no'] . "]]></txtChequeNo>";
            $ResponseXML .= "<txtChequeAmount><![CDATA[" . $row['che_amount'] . "]]></txtChequeAmount>";
            $ResponseXML .= "<cmbBankname><![CDATA[" . $row['bank'] . "]]></cmbBankname>";
            $ResponseXML .= "<txtrctdate><![CDATA[" . $row['SDATE'] . "]]></txtrctdate>";
            $ResponseXML .= "<DTPicker2><![CDATA[" . $row['che_date'] . "]]></DTPicker2>";
            $ResponseXML .= "<lblRET_chno><![CDATA[" . $row['ret_chno'] . "]]></lblRET_chno>";
            $ResponseXML .= "<lblretrefno><![CDATA[" . $row['ret_refno'] . "]]></lblretrefno>";
            $ResponseXML .= "<lblretdate><![CDATA[" . $row['ret_chdate'] . "]]></lblretdate>";
            $ResponseXML .= "<lblnoof><![CDATA[" . $row['noof'] . "]]></lblnoof>";

            $sql_chq = mysqli_query($GLOBALS['dbinv'], "select * from  s_cheq where  CR_CHNO='" . trim($_GET["txtChequeNo"]) . "' order by id desc ") or die(mysqli_error());
            if ($row_chq = mysqli_fetch_array($sql_chq)) {
                $ResponseXML .= "<cheq_dpo_bank><![CDATA[" . $row_chq['depobank'] . "]]></cheq_dpo_bank>";
                $ResponseXML .= "<reason><![CDATA[" . $row_chq['reason'] . "]]></reason>";
                $ResponseXML .= "<REMARK><![CDATA[" . $row_chq['REMARK'] . "]]></REMARK>";


                include('connectioni.php');

                $sql_led = "select * from  ledger where  l_refno='" . $row_chq['CR_REFNO'] . "' ";
                $result_led = mysqli_query($GLOBALS['dbinv'], $sql_led, $dbacc);
                $row_led = mysqli_fetch_array($result_led);
                $ResponseXML .= "<bank_st_date><![CDATA[" . $row_led['l_date'] . "]]></bank_st_date>";
            } else {
                $ResponseXML .= "<cheq_dpo_bank><![CDATA[]]></cheq_dpo_bank>";
                $ResponseXML .= "<reason><![CDATA[]]></reason>";
                $ResponseXML .= "<REMARK><![CDATA[]]></REMARK>";
                //$ResponseXML .= "<lblReciptNo><![CDATA[]]></lblReciptNo>";
                $ResponseXML .= "<bank_st_date><![CDATA[]]></bank_st_date>";
            }
        }
    }

    $refinv = "";
    $i = 1;
    $st_amou = 0;

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Inv No</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Inv Amt</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">St. Amt</font></td>
                             
                            </tr>";


    //echo "select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' and che_amount = ".$_GET["che_amount"];
    $sql = mysqli_query($GLOBALS['dbinv'], "select * from  s_invcheq where  cheque_no='" . trim($_GET["txtChequeNo"]) . "' and che_date = '" . $_GET["che_date"] . "' and che_amount = " . $_GET["che_amount"]) or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        if (trim($row["trn_type"]) == "RET") {
            //	echo "select * from ch_sttr where ST_CHNO = '".trim($_GET["txtChequeNo"])."' and ST_INDATE = '".$row['che_date']."'";
            $sql1 = mysqli_query($GLOBALS['dbinv'], "select * from ch_sttr where ST_CHNO = '" . trim($_GET["txtChequeNo"]) . "' and ST_INDATE = '" . $row['che_date'] . "'") or die(mysqli_error());
            while ($row1 = mysqli_fetch_array($sql1)) {
                //	echo "select * from ret_chq_history where Ref_no = '".trim($row1["ST_INVONO"])."'";
                $sql_his = mysqli_query($GLOBALS['dbinv'], "select * from ret_chq_history where Ref_no = '" . trim($row1["ST_INVONO"]) . "'") or die(mysqli_error());
                while ($row_his = mysqli_fetch_array($sql_his)) {
                    $refinv = $row_his["Inv_no"];
                    $sql_rs = mysqli_query($GLOBALS['dbinv'], "select * from  ret_ch_sett where CR_REFNO = '" . trim($row1["ST_INVONO"]) . "' and  ST_CHNO = '" . trim($_GET["txtChequeNo"]) . "' and ret_chno = '" . $row_his["chk_no"] . "'") or die(mysqli_error());
                    $row_rs = mysqli_fetch_array($sql_rs);

                    if (is_null($row_his["st_amt"]) == false) {
                        $st_amou = $row_his["st_amt"];
                    }

                    $sql_rst = mysqli_query($GLOBALS['dbinv'], "select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'") or die(mysqli_error());
                    if ($row_rst = mysqli_fetch_array($sql_rst)) {
                        $sdate = $row_rst['SDATE'];
                        if (!is_null($row_rst['deli_date'])) {
                            $sdate = $row_rst['deli_date'];
                        }
                        $ResponseXML .= "<tr>
                              
                             			<td >" . $row_rst['REF_NO'] . "</td>
							 			<td>" . $sdate . "</td>
							 			<td >" . $row_rst['GRAND_TOT'] . "</td>
							 			<td  >" . $st_amou . "</td>
							 			</tr>";
                    }
                }
            }
        } else {
            //echo "Select * from s_sttr where cus_code = '".trim($row['cus_code'])."' and st_chno = '".trim($_GET["txtChequeNo"])."' and st_chdate = '".$row['che_date']."'";
            $sql_inv = mysqli_query($GLOBALS['dbinv'], "Select * from s_sttr where cus_code = '" . trim($row['cus_code']) . "' and ST_CHNO = '" . trim($_GET["txtChequeNo"]) . "' and st_chdate = '" . $row['che_date'] . "'") or die(mysqli_error());
            while ($row_inv = mysqli_fetch_array($sql_inv)) {
                $refinv = $row_inv["ST_INVONO"];
                $st_amou = $row_inv["ST_PAID"];
                //	echo "select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'";
                $sql_rst = mysqli_query($GLOBALS['dbinv'], "select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'") or die(mysqli_error());
                if ($row_rst = mysqli_fetch_array($sql_rst)) {
                    $sdate = $row_rst['SDATE'];
                    if (!is_null($row_rst['deli_date'])) {
                        $sdate = $row_rst['deli_date'];
                    }
                    $ResponseXML .= "<tr>
                              
                             	<td >" . $row_rst['REF_NO'] . "</td>
							 	<td>" . $sdate . "</td>
							 	<td >" . $row_rst['GRAND_TOT'] . "</td>
							 	<td  >" . $st_amou . "</a></td>
							 	</tr>";
                }
            }
        }
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "extend") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $txtchexdate = "";
    if (trim($_GET["txtChequeNo"]) != "") {
        //$sql = mysqli_query($GLOBALS['dbinv'],"select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' and che_amount = '".$_GET["che_amount"]."'") or die(mysqli_error());

        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT *  FROM s_cheque_extend WHERE refno = '" . trim($_GET["ref_no"]) . "' ") or die(mysqli_error());
        //$sql = mysqli_query($GLOBALS['dbinv'],"select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and cus_code = '".$_GET["cusno"]."' ") or die(mysqli_error());
        //echo "select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."'";
        if ($row = mysqli_fetch_array($sql)) {
            //$ResponseXML .= "<lblReciptNo><![CDATA[".$row['refno']."]]></lblReciptNo>";
            $ResponseXML .= "<refno><![CDATA[" . trim($row['refno']) . "]]></refno>";
            $ResponseXML .= "<txtcode><![CDATA[" . $row['c_code'] . "]]></txtcode>";
            $ResponseXML .= "<txtname><![CDATA[" . $row['c_name'] . "]]></txtname>";
            $ResponseXML .= "<txtsal_ex><![CDATA[" . $row['sal_ex'] . "]]></txtsal_ex>";

            $ResponseXML .= "<txtch_no><![CDATA[" . $row['ch_no'] . "]]></txtch_no>";
            $ResponseXML .= "<txtch_amount><![CDATA[" . $row['ch_amount'] . "]]></txtch_amount>";
            $ResponseXML .= "<txtch_date><![CDATA[" . $row['ch_date'] . "]]></txtch_date>";
            $ResponseXML .= "<ch_exdate><![CDATA[" . $row['ch_exdate'] . "]]></ch_exdate>";
            $ResponseXML .= "<approved><![CDATA[" . $row['approved'] . "]]></approved>";
            $ResponseXML .= "<acc_approved><![CDATA[" . $row['acc_approved'] . "]]></acc_approved>";

            $ResponseXML .= "<ded><![CDATA[" . $row['ded'] . "]]></ded>";
            $txtch_date = $row['ch_date'];
            $txtchexdate = $row['ch_exdate'];
        }
    }


    $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and docid='17'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row_rs = mysqli_fetch_array($result)) {

        $ResponseXML .= "<doc_feed><![CDATA[" . $row_rs["doc_feed"] . "]]></doc_feed>";
    } else {

        $ResponseXML .= "<doc_feed><![CDATA[0]]></doc_feed>";
    }




    $refinv = "";
    $i = 1;
    $st_amou = 0;

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Inv Date</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Deli Date</font></td>
                              <td width=\"150\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Paid</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cheque.Date</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Days</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Extended Up To</font></td>
							   <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Dealer Ins.</font></td>
                            </tr>";




    $sql_inv = mysqli_query($GLOBALS['dbinv'], "Select * from s_sttr where cus_code = '" . trim($row['c_code']) . "' and ST_CHNO = '" . trim($_GET["txtChequeNo"]) . "' ORDER BY ST_INVONO") or die(mysqli_error());
    while ($row_inv = mysqli_fetch_array($sql_inv)) {
        $refinv = $row_inv["ST_INVONO"];
        $st_amou = $row_inv["ST_PAID"];
        //	echo "select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'";
        $sql_rst = mysqli_query($GLOBALS['dbinv'], "select * from s_salma where REF_NO='" . trim($refinv) . "'") or die(mysqli_error());
        //echo "select * from s_salma where REF_NO='" . trim($refinv) . "'";
        if ($row_rst = mysqli_fetch_array($sql_rst)) {
            $ResponseXML .= "<tr>
                              <td><a href=\"\" class=\"INV\" onClick=\"NewWindow('sales_inv_display.php?refno=" . $refinv . "&trn_type=" . $row_rst['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"> " . $refinv. "</a></td>";
                             	 
//                             	<td >" . $refinv . "</td>";



            $ResponseXML .= "<td>" . $row_rst['SDATE'] . "</td>";

            $ResponseXML .= "<td>" . $row_rst['deli_date'] . "</td>";

            if (!is_null()) {
                $deli_date = $row_rst['deli_date'];
            } else {
                $deli_date = $row_rst['SDATE'];
            }

            $ResponseXML .= "<td align=right >" . $row_inv["ST_PAID"] . "</td>
								<td >" . $row_inv["st_chdate"] . "</td>";

            $date1 = $txtch_date;
            $date2 = $deli_date;
            $diff = abs(strtotime($date2) - strtotime($date1));
            $days = floor($diff / (60 * 60 * 24));
            //echo $date1."/".$date2;
            $ResponseXML .= "<td  align=right>" . $days . "</td>";

            $date1 = $txtchexdate;
            $date2 = $deli_date;
            $diff = abs(strtotime($date2) - strtotime($date1));
            $days = floor($diff / (60 * 60 * 24));
            //echo $date1."/".$date2."-";
            $ResponseXML .="<td  align=right>" . $days . "</td>";


            $sql = "select * from ins_payment where cuscode = '" . $row_rst['C_CODE'] . "' and (I_month) = '" . intval(date("m", strtotime($row_rst['SDATE']))) . "' and (I_year) = '" . date("Y", strtotime($row_rst['SDATE'])) . "'";
//            echo $sql;
            $sql_ins = mysqli_query($GLOBALS['dbinv'], $sql);
           
            $numr_ins = 0;
            $myes = "";
            $numr_ins = mysqli_num_rows($sql_ins);
            if ($numr_ins > 0) {
                $myes = "YES";
            }
            $ResponseXML .="<td>" . $myes . "</td>";

            $ResponseXML .="</tr>";
        }
    }




    $ResponseXML .= "   </table>]]></sales_table>";


    $sql_inv = mysqli_query($GLOBALS['dbinv'], "select * from userpermission where username='" . $_SESSION['UserName'] . "' and docid='17'") or die(mysqli_error());
    $row_rs = mysqli_fetch_array($sql_inv);
    if ($row_rs["doc_feed"] == "1") {
        $ResponseXML .= "<autho><![CDATA[1]]></autho>";
    } else {
        $ResponseXML .= "<autho><![CDATA[0]]></autho>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}
?>
