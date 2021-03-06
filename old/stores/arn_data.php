<?php 
session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("connectioni.php");
	
	
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
		
		if($_GET["Command"]=="add_address")
		{
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;
			
			
	/*		$sql="Select * from tmp_army_no where edu= '".$_GET['edu']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			if($row = mysqli_fetch_array($result)){
				$ResponseXML .= "exist";
				
				
				
			}	else {*/
			
		//	$ResponseXML .= "";
			//$ResponseXML .= "<ArmyDetails>";
			
		/*	$sql1="Select * from mas_educational_qualifications where str_Educational_Qualification= '".$_GET['edu']."'";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			$row1 = mysqli_fetch_array($result1);
			$ResponseXML .=  $row1["int_Educational_Qulifications"];*/
			
			$sqlt="Select * from customer_mast where id ='".$_GET['customerid']."'";
			
			$resultt =mysqli_query($GLOBALS['dbinv'],$sqlt) ; 
			if ($rowt = mysqli_fetch_array($resultt)){
				echo $rowt["str_address"];
			}
			
			
				
			
	}
	
			
		if($_GET["Command"]=="new_inv")
		{
			
			$_SESSION["print"]=0;
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			$sql="Select ARN from invpara_stores";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["ARN"];
			$lenth=strlen($tmpinvno);
			$invno=trim("ARN/ ").substr($tmpinvno, $lenth-8);
			$_SESSION["invno"]=$invno;
			
			$sql="Select ARN from tmpinvpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$_SESSION["tmp_no_arn"]="ARN/".$row["ARN"];
			
			
			
			$sql1="delete from tmp_arn_data_stores where tmp_no='".$_SESSION["tmp_no_arn"]."'";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			
			$sql1="update tmpinvpara set ARN=ARN+1";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			
			echo $invno;	
			
		}
	
	
	if($_GET["Command"]=="add_tmp")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="delete from tmp_arn_data_stores where str_code='".$_GET['itemcode']."' and tmp_no='".$_SESSION["tmp_no_arn"]."' ";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			
			$qty=str_replace(",", "", $_GET["qty"]);
			
			
			$sql="Insert into tmp_arn_data_stores (str_invno, str_code, str_description, partno, qty, tmp_no) values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', '".$_GET["partno"]."', ".$qty.", '".$_SESSION["tmp_no_arn"]."') ";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"500\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                             
                            </tr>";
							
			
			$sql="Select * from tmp_arn_data_stores where tmp_no='".$_SESSION["tmp_no_arn"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td >".$row['str_code']."</a></td>
							 <td >".$row['str_description']."</a></td>
							 <td >".number_format($row['qty'], 2, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
                           
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	if($_GET["Command"]=="arn")
		{
		
			//$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="select * from s_ordmas where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			if($row = mysqli_fetch_array($result)){
				$ResponseXML .= "<REFNO><![CDATA[".$row['REFNO']."]]></REFNO>";
				$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
				$ResponseXML .= "<SUP_CODE><![CDATA[".$row['SUP_CODE']."]]></SUP_CODE>";
				$ResponseXML .= "<SUP_NAME><![CDATA[".$row['SUP_NAME']."]]></SUP_NAME>";
				$ResponseXML .= "<REMARK><![CDATA[".$row['REMARK']."]]></REMARK>";
				$ResponseXML .= "<DEP_CODE><![CDATA[".$row['DEP_CODE']."]]></DEP_CODE>";
				$ResponseXML .= "<DEP_NAME><![CDATA[".$row['DEP_NAME']."]]></DEP_NAME>";
				$ResponseXML .= "<REP_CODE><![CDATA[".$row['REP_CODE']."]]></REP_CODE>";
				$ResponseXML .= "<REP_NAME><![CDATA[".$row['REP_NAME']."]]></REP_NAME>";
				$ResponseXML .= "<S_date><![CDATA[".$row['S_date']."]]></S_date>";
				$ResponseXML .= "<LC_No><![CDATA[".$row['LC_No']."]]></LC_No>";
				$ResponseXML .= "<pi_no><![CDATA[".$row['pi_no']."]]></pi_no>";
				$ResponseXML .= "<Brand><![CDATA[".$row['Brand']."]]></Brand>";
				$ResponseXML .= "<COUNTRY><![CDATA[".$row["COUNTRY"]."]]></COUNTRY>";
			}	
			
		//	$sql="delete from tmp_purord_data where str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
		//	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
		//	$sql="select * from s_ordtrn where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
		//	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		//	while($row = mysqli_fetch_array($result)){
		//		$sql1="Insert into tmp_purord_data (str_invno, str_code, str_description, partno, qty)values 
		//		('".$row['REFNO']."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', '".$row["partno"]."', ".$row["ORD_QTY"].") ";
			//$ResponseXML .= $sql;
		//		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
		//	}
							
			
			
	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Order Qty</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">FOB</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cost</font></td>
							   <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Selling</font></td>
							    <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Margin</font></td>
								 <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							
                            </tr>";
				
			$mcou=0;	
			$sql="Select count(*) as mcou from s_ordtrn where REFNO='".$_GET['invno']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			$row = mysqli_fetch_array($result);
			$mcou=$row["mcou"]+1;
							
			$i=1;
			$sql="Select * from s_ordtrn where REFNO='".$_GET['invno']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
			
				$itemcode="itemcode".$i;
				$itemname="itemname".$i;
				$ord_qty="ord_qty".$i;
				$fob="fob".$i;
				$qty="qty".$i;
				$cost="cost".$i;
				$selling="selling".$i;
				$margin="margin".$i;
				$subtotal="subtotal".$i;
				
				$sql_selling="select SELLING from s_mas where STK_NO='" . $row['STK_NO'] . "'";
				$result_selling =mysqli_query($GLOBALS['dbinv'],$sql_selling);	
				$row_selling = mysqli_fetch_array($result_selling);
							
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemcode." id=".$itemcode."   value=".$row['STK_NO']." class=\"txtbox\" disabled=\"disabled\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemname." id=".$itemname."  value='".$row['DESCRIPT']."' class=\"txtbox\" disabled=\"disabled\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$ord_qty." id=".$ord_qty."  value=".$row['ORD_QTY']." class=\"txtbox\" disabled=\"disabled\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$fob." id=".$fob."  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$qty." id=".$qty."  class=\"txtbox\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$cost." id=".$cost."  class=\"txtbox\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$selling." id=".$selling." onBlur=\"cal_margine('".$i."', '".$mcou."');\" value=".$row_selling['SELLING']."  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$margin." id=".$margin."  class=\"txtbox\" disabled=\"disabled\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$subtotal." id=".$subtotal."  class=\"txtbox\" disabled=\"disabled\"/></td>
							</tr>";
							$i=$i+1; 
                           
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				$ResponseXML .= "<count><![CDATA[".$i."]]></count>";
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	if($_GET["Command"]=="setord")
	{
		
	//	include_once("connectioni.php");
		
		
		
		
		//$_SESSION["custno"]=$_GET['custno'];
		$_SESSION["brand"]=$_GET["brand"];
		//$_SESSION["department"]=$_GET["department"];
		
		
	//echo $_SESSION["brand"];

	
	}

		
	if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_arn_data_stores where str_code='".$_GET['code']."' and tmp_no='".$_SESSION["tmp_no_arn"]."' ";
			//echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"500\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_arn_data_stores where tmp_no='".$_SESSION["tmp_no_arn"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td >".$row['str_code']."</a></td>
							 <td >".$row['str_description']."</a></td>
							 <td >".$row['qty']."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
						
				}			
				
				$ResponseXML .= "   </table>]]></sales_table>";
							
                $ResponseXML .= " </salesdetails>";
				
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	
if($_GET["Command"]=="save_item")
{

	$vatrate=12;
	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
			$_SESSION["CURRENT_DOC"] = 1;      //document ID
			$_SESSION["VIEW_DOC"] = false ;     //view current document
			$_SESSION["FEED_DOC"] = true;       //save  current document
			$_GET["MOD_DOC"] = false  ;         //delete   current document
			$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
			$_GET["PRICE_EDIT"] = false ;       //edit selling price
			$_GET["CHECK_USER"] = false ;       //check user permission again

		
			//$cre_balance=str_replace(",", "", $_GET["balance"]);
			
			
			
			$sql="select * from s_purmas_stores where REFNO='".$_GET["invno"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			//echo $sql;
			if($row = mysqli_fetch_array($result)){
				exit("AR Number Already Exists");
			} else {	
				/*$sql1="insert into c_bal(REFNO, SDATE, CUSCODE, AMOUNT, BALANCE, DEP, SAL_EX, Cancell, brand, DEV, trn_type, vatrate, old, flag1, active, totpay) values ('".$_GET["invno"]."', '".$_GET["invdate"]."', '".$_GET["supplier_code"]."', '".$_GET["total_value"]."', '".$_GET["total_value"]."', '".$_GET["department"]."', '".$_GET["salesrep"]."', '0', '".$_GET["brand"]."', '".$_SESSION['dev']."', 'ARN', '".$vatrate."', '0', 0, 1, 0)";
				//echo $sql1;
				$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; */
				
				$supplier_name=str_replace("~", "&", $_GET["supplier_name"]);
				$textarea=str_replace("~", "&", $_GET["textarea"]);
				
				$sql1="insert into s_purmas_stores(REFNO, SDATE, LCNO, pi_no, SUP_CODE, SUP_NAME, REMARK, DEPARTMENT, 
TYPE, brand, book_no) values ('".$_GET["invno"]."', '".$_GET["invdate"]."', '".$_GET["lc_no"]."', '".$_GET["pi_no"]."', '".$_GET["supplier_code"]."', '".$supplier_name."', '".$textarea."', '".$_GET["department"]."', '".$_GET["purtype"]."', '".$_GET["brand"]."', '".$_GET["book_no"]."')";
				//echo $sql1;
				$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			}
			
			$i=1;
			
			$sqltmp="select * from tmp_arn_data_stores where tmp_no='".$_SESSION["tmp_no_arn"]."'";
			//echo $sqltmp;
			$resulttmp =mysqli_query($GLOBALS['dbinv'],$sqltmp);
			while($rowtmp = mysqli_fetch_array($resulttmp)){
			
			
				$qty=str_replace(",", "", $rowtmp["qty"]);
			
				$sql1="insert into s_purtrn_stores(REFNO, SDATE, STK_NO, DESCRIPT, REC_QTY) values ('".$_GET["invno"]."', '".$_GET["invdate"]."', '".$rowtmp["str_code"]."', '".$rowtmp["str_description"]."', ".$qty.")";
 			//echo $sql1;
				$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
				
			
				
				$sql1="update s_mas set QTYINHAND_STORES=QTYINHAND_STORES+".$qty." where  STK_NO='".$rowtmp["str_code"]."'";
				$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
				//echo $sql1;
				$sql3="select * from s_submas_stores where STK_NO='".$rowtmp["str_code"]."' and STO_CODE='".$_GET["department"]."'";
				//echo $sql1;
				$result3 =mysqli_query($GLOBALS['dbinv'],$sql3);
				if ($row3 = mysqli_fetch_array($result3)){
					$sql1="update s_submas_stores set QTYINHAND=QTYINHAND+".$qty." where STK_NO='".$rowtmp["str_code"]."' and STO_CODE='".$_GET["department"]."'";
					//echo $sql1;
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
					
				} else {	
					
					$sql1="insert into s_submas_stores(STO_CODE, STK_NO, DESCRIPt, OPENT_DATE, QTYINHAND) values ('".$_GET["department"]."', '".$rowtmp["str_code"]."', '".$rowtmp["str_description"]."', '".$_GET["invdate"]."', ".$qty." )";
					echo $sql1;
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
				}
				
			
				$sql1="insert into s_trn_stores(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values ('".$rowtmp["str_code"]."', '".$_GET["invdate"]."', '".$qty."', 'ARN', '".$_GET["invno"]."', '".$_GET["department"]."', '', '".$_SESSION['dev']."', '', '1', '')";
				//echo $sql1;
				$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
				
			 
			  	
				$i=$i+1;
			  
			}
			
			
			$sql1="update invpara_stores set ARN=ARN+1";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			
					
			
		//$_SESSION["print"]=1;

			
			echo "Saved";
			
			
	}
	

	if($_GET["Command"]=="pass_arnno")
	{
		$ResponseXML = "";
		$ResponseXML .= "<salesdetails>";
		$sql="Select * from s_purmas_stores where REFNO='".$_GET['arnno']."'";
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
		if ($row = mysqli_fetch_array($result)){
			$ResponseXML .= "<REFNO><![CDATA[".$row["REFNO"]."]]></REFNO>";
			$ResponseXML .= "<SDATE><![CDATA[".$row["SDATE"]."]]></SDATE>";
			
			$ResponseXML .= "<LCNO><![CDATA[".$row["LCNO"]."]]></LCNO>";
			$ResponseXML .= "<pi_no><![CDATA[".$row["pi_no"]."]]></pi_no>";
			$ResponseXML .= "<book_no><![CDATA[".$row["book_no"]."]]></book_no>";
			
			$ResponseXML .= "<SUP_CODE><![CDATA[".$row["SUP_CODE"]."]]></SUP_CODE>";
			$ResponseXML .= "<SUP_NAME><![CDATA[".$row["SUP_NAME"]."]]></SUP_NAME>";
			$ResponseXML .= "<REMARK><![CDATA[".$row["REMARK"]."]]></REMARK>";
			$ResponseXML .= "<DEPARTMENT><![CDATA[".$row["DEPARTMENT"]."]]></DEPARTMENT>";
			
			
			$ResponseXML .= "<brand><![CDATA[".$row["brand"]."]]></brand>";
			$ResponseXML .= "<TYPE><![CDATA[".$row["TYPE"]."]]></TYPE>";
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							 							
                            </tr>";
				
			
							
			$i=1;
			
			$sql="Select * from s_purtrn_stores where REFNO='".$_GET['arnno']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
			
				$itemcode="itemcode".$i;
				$itemname="itemname".$i;
				$ord_qty="ord_qty".$i;
				$fob="fob".$i;
				$qty="qty".$i;
				$cost="cost".$i;
				$selling="selling".$i;
				$margin="margin".$i;
				$subtotal="subtotal".$i;
							
			
							
             	$ResponseXML .= "<tr>                              
                             <td >".$row['STK_NO']."</td>
							  <td >".$row['DESCRIPT']."</td>
							
							 <td >".$row['REC_QTY']."</td>
							
							</tr>";
							//$tot=$tot+($row['COST']*$row['REC_QTY']);
							$subtot=$subtot+$stot;
							$i=$i+1; 
                           
				}			
							
                $ResponseXML .= "</table>]]></sales_table>";
				
				$ResponseXML .= "<count><![CDATA[".$i."]]></count>";
		}
		
		
		
		$ResponseXML .= "</salesdetails>";
		echo $ResponseXML;
	}
	
if($_GET["Command"]=="pass_arnno_gin")
	{
		header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$ResponseXML = "";
		$ResponseXML .= "<salesdetails>";
		$sql="Select * from s_purmas where REFNO='".$_GET['arnno']."'";
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
		if ($row = mysqli_fetch_array($result)){
			$ResponseXML .= "<REFNO><![CDATA[".$row["REFNO"]."]]></REFNO>";
			$ResponseXML .= "<SDATE><![CDATA[".$row["SDATE"]."]]></SDATE>";
			
		}
		$ResponseXML .= "</salesdetails>";
		echo $ResponseXML;
	}
	
				
if($_GET["Command"]=="cancel_inv")
{

	
	
		$sql1="update s_purmas_stores set CANCEL='1' where REFNO='".$_GET["invno"]."'";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
	
		$sql1="update s_purtrn_stores set CANCEL='1' where REFNO='".$_GET["invno"]."'";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
		
		
		$sql1="delete from s_trn_stores  where REFNO='".$_GET["invno"]."'";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
		
		
		$sql1="select * from s_purtrn_stores where REFNO='".$_GET["invno"]."'";
		
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
		while($row1 = mysqli_fetch_array($result1)){
		
			
			
			$sql2="update s_submas_stores set QTYINHAND=QTYINHAND-".$row1["REC_QTY"]." where STK_NO='".$row1["STK_NO"]."' and STO_CODE='".$_GET["department"]."'";
			
			$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
			
			$sql2="update s_mas set QTYINHAND_STORES=QTYINHAND_STORES-".$row1["REC_QTY"]." where STK_NO='".$row1["STK_NO"]."'";
			$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
		}
		
		echo "Canceled!";
	
	
	
	
}	
	
if ($_GET["Command"]=="check_print")
{
	
	echo $_SESSION["print"];
}

	
if($_GET["Command"]=="tmp_crelimit")
{	
	echo "abc";
	$crLmt = 0;
	$cat = "";
	
	$rep=trim(substr($_GET["Com_rep1"], 0, 5));
	
	$sql = "select * from br_trn where rep='".$rep."' and cus_code='".trim($_GET["txt_cuscode"])."' and brand='".trim($_GET["cmbbrand1"])."'";
	echo $sql;
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
    if ($row = mysqli_fetch_array($result)) {
		$crLmt = $row["credit_lim"];
   		If (is_null($row["CAT"])==false) {
      		$cat = trim($row["CAT"]);
   		} else {
      		$crLmt = 0;
		}	
   	}
/*	
$_SESSION["CURRENT_DOC"] = 66     //document ID
//$_SESSION["VIEW_DOC"] = true      //  view current document
 $_SESSION["FEED_DOC"] = true      //  save  current document
//$_SESSION["MOD_DOC"] = true       //   delete   current document
//$_SESSION["PRINT_DOC"] = true     // get additional print   of  current document
//$_SESSION["PRICE_EDIT"]= true     // edit selling price
$_SESSION["CHECK_USER"] = true    // check user permission again
$crLmt = $crLmt;
setlocale(LC_MONETARY, "en_US");
$CrTmpLmt = number_format($_GET["txt_tmeplimit"], 2, ".", ",");

$REFNO = trim($_GET["txt_cuscode"]) ;

$AUTH_USER="tmpuser";

$sql = "insert into tmpCrLmt (sdate, stime, username, tmpLmt, class, rep, cuscode, crLmt, cat) values 
        ('".date("Y-m-d")."','".date("H:i:s", time())."' ,'".$AUTH_USER."',".$CrTmpLmt." ,'".trim($_GET["cmbbrand1"])."','".$rep."','".trim($_GET["txt_cuscode"])."',".$crLmt.",'".$cat"' )";
$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 

$sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
if ($row = mysqli_fetch_array($result)) {
   $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
   $resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);
   
} else {
  
  	$sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
 	$resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);
	
//	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
}

	If ($_GET["Check1"] == 1) {
   		$sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
	} else {	
    	$sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
	}

echo "Tempory limit updated";*/

}
	
?>