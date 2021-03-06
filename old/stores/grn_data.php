<?php session_start();

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
	
	if ($_GET["Command"]=="search_inv"){
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	include_once("connectioni.php");
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">GRN No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">GRN Date</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Invoice No</font></td>
                             
   							</tr>";
                           
							if ($_GET["mstatus"]=="invno"){
						   		$letters = $_GET['invno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * FROM s_crnma_stores where CANCELL='0' and REF_NO like  '$letters%' order by SDATE desc limit 50  ") or die(mysqli_error());
							} else if ($_GET["mstatus"]=="customername"){
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_salma where CUS_NAME like  '$letters%' limit 50") or die(mysqli_error()) or die(mysqli_error());
							} else {
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_salma where CUS_NAME like  '$letters%' limit 50") or die(mysqli_error()) or die(mysqli_error());
							}
							
													
						
						while($row = mysqli_fetch_array($sql)){
								 $ResponseXML .=  "<tr>               
                              <td onclick=\"grn('".$row['REF_NO']."');\">".$row['REF_NO']."</a></td>
                              <td onclick=\"grn('".$row['REF_NO']."');\">".$row['SDATE']."</a></td>
                              <td onclick=\"grn('".$row['REF_NO']."');\">".$row['C_CODE']." - ".$row['CUS_NAME']."</a></td>
							  <td onclick=\"grn('".$row['REF_NO']."');\">".$row['INVOICENO']."</a></td>
                            </tr>";
							
							
						}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}


			
		if($_GET["Command"]=="new_inv")
		{
			
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			$sql="Select grn, rno from invpara_stores";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["grn"];
			
			$lenth=strlen($tmpinvno);
			if ($_SESSION['company']=="BEN"){
				$invno=trim("BGRN/ ").substr($tmpinvno, $lenth-6);
			} 
			
			if ($_SESSION['company']=="THT"){
				$invno=trim("TGRN/ ").substr($tmpinvno, $lenth-6);
			}
			$_SESSION["invno"]=$invno;
			
			
			$sql="Select grn, rno from tmpinvpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["grn"];
			
			$lenth=strlen($tmpinvno);
			if ($_SESSION['company']=="BEN"){
				$invnotmp=trim("BGRN/ ").substr($tmpinvno, $lenth-6);
			} 
			
			if ($_SESSION['company']=="THT"){
				$invnotmp=trim("TGRN/ ").substr($tmpinvno, $lenth-6);
			}
				
			$_SESSION["tmp_grnvno"]=$invnotmp;
			
			$sql="delete from tmp_grn_data_stores where tmp_no='".$_SESSION["tmp_grnvno"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="update tmpinvpara set grn=grn+1";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			$ResponseXML .= "<invno><![CDATA[".$invno."]]></invno>";
			$ResponseXML .= "<rno><![CDATA[".$row["rno"]."]]></rno>";
			$ResponseXML .= "<cdate><![CDATA[".date("Y-m-d")."]]></cdate>";
			$ResponseXML .= "</salesdetails>";
			
			$_SESSION["custno"]="";
			
			echo $ResponseXML;
		}
	
	
	if($_GET["Command"]=="add_tmp")
		{
		include_once("connectioni.php");
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"500\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  
                            </tr>";
							
				
			 
				
				
//echo "Insert into tmp_grn_data(str_invno, str_code, str_description, cur_rate, cur_qty, pre_ret_qty, ret_qty, dis_per, cur_discount, cur_subtot, brand) values ( '".$_GET["invno"]."', '".$_GET["itemcode"]."', '".$_GET["item"]."', ".$_GET["rate"].", ".$_GET["qty"].", 0, 0, ".$_GET["discount"].", ".$_GET["discount_amt"].", ".$_GET["subtotal"].", '".$_GET["brand"]."')";				
				$sql_tmp = mysqli_query($GLOBALS['dbinv'],"Insert into tmp_grn_data_stores(str_invno, str_code, str_description, cur_qty, tmp_no) values ( '".$_GET["invno"]."', '".$_GET["itemcode"]."', '".$_GET["item"]."', ".$_GET["qty"].", '".$_SESSION["tmp_grnvno"]."')") or die(mysqli_error());
				
				$i=1;
				$sql_tmp = mysqli_query($GLOBALS['dbinv'],"select * from tmp_grn_data_stores where tmp_no = '".$_SESSION["tmp_grnvno"]."'") or die(mysqli_error());	
				while($row = mysqli_fetch_array($sql_tmp)){
					
						
			
			 	$ResponseXML .= "<tr>
                        
							 <td >".$row["str_code"]."</td>
							 <td >".$row["str_description"]."</td>
							
							 <td  >".number_format($row["cur_qty"], 0, ".", "")."</td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row["str_code"]."  name=".$row["str_code"]." onClick=\"del_item('".$row["str_code"]."');\"></td>
                            </tr>";
							
							
							$i=$i+1;
            					
				}
			
			    $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	if($_GET["Command"]=="add_tmp2")
		{
		
			//$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
		
			
			$sql = "Insert into tmp_inv_serino_grn(refno ,stk_no , serino) values('" . trim($_GET["invno"]) . "', '" . trim($_GET["stk_no"]) . "', '" . trim($_GET["seri_no"]) . "')";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"25%\"><font color=\"#FFFFFF\">Stock No</font></td>
               				 	<td width=\"40%\"><font color=\"#FFFFFF\">Serial No</font></td>
							  </tr>";
							
			$i=1;
			
			//$sql1="Select pirnt_serial from s_salma where REF_NO='".trim($_GET["invno"])."'";
			//$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
			//$row1 = mysqli_fetch_array($result1);
						
				
			$sql="Select * from tmp_inv_serino_grn where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
								
						
             	$ResponseXML .= "<tr>                              
                             <td >".$row['stk_no']."</td>
							 <td >".$row['serino']."</td>";
				
				
				//if ($row1["pirnt_serial"]!="1"){
					$ResponseXML .="<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['serino']."  name=".$row['serino']." onClick=\"del_item2('".$row['serino']."');\"></td>";
				//}
							
                   $ResponseXML .= "</tr>";
					$i=$i+1;		
			}			
			
			$sql="Select * from inv_serino_grn where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
								
						
             	$ResponseXML .= "<tr>                              
                             <td >".$row['stk_no']."</td>
							 <td >".$row['serino']."</td>";
				
				
				//if ($row1["pirnt_serial"]!="1"){
				//	$ResponseXML .="<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['serino']."  name=".$row['serino']." onClick=\"del_item('".$row['serino']."');\"></td>";
				//}
							
                   $ResponseXML .= "</tr>";
					$i=$i+1;		
			}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	if($_GET["Command"]=="add_serial")
	{
		
			
			$sql="Select * from tmp_inv_serino_grn where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
								
				$sql1 = "Insert into inv_serino_grn(refno ,stk_no , serino, seri_datetime) values('" . trim($row["refno"]) . "', '" . trim($row["stk_no"]) . "', '" . trim($row["serino"]) . "', '".date("Y-m-d H:i:s")."')";
				$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
					
 			}			
							
          	//$sql1 = "update s_salma set serial_datetime='".date("Y-m-d H:i:s")."' where REF_NO ='".trim($_GET["invno"]). "'";
			//$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	  
			
			$sql="delete from tmp_inv_serino_grn where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"25%\"><font color=\"#FFFFFF\">Stock No</font></td>
               				 	<td width=\"40%\"><font color=\"#FFFFFF\">Serial No</font></td>
							  </tr>";
							
			$i=1;
			
			//$sql1="Select pirnt_serial from s_salma where REF_NO='".trim($_GET["invno"])."'";
			//$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
			//$row1 = mysqli_fetch_array($result1);
						
				
			$sql="Select * from inv_serino_grn where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
								
						
             	$ResponseXML .= "<tr>                              
                             <td >".$row['stk_no']."</td>
							 <td >".$row['serino']."</td>";
				
				
				//if ($row1["pirnt_serial"]!="1"){
				//	$ResponseXML .="<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['serino']."  name=".$row['serino']." onClick=\"del_item('".$row['serino']."');\"></td>";
				//}
							
                   $ResponseXML .= "</tr>";
					$i=$i+1;		
			}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				$ResponseXML .= "<resul><![CDATA[Serial Numbers are Saved]]></resul>";
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
	}
	
	
	if($_GET["Command"]=="del_item2")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql = "delete from tmp_inv_serino_grn where refno='" . trim($_GET["invno"]) . "' and serino='" . trim($_GET["seri_no"]) . "'";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"25%\"><font color=\"#FFFFFF\">Stock No</font></td>
               				 	<td width=\"40%\"><font color=\"#FFFFFF\">Serial No</font></td>
							  </tr>";
							
			$i=1;
			$sql="Select * from tmp_inv_serino_grn where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
								
						
             	$ResponseXML .= "<tr>                              
                             <td >".$row['stk_no']."</td>
							 <td >".$row['serino']."</td>";
				
				
				//if ($row1["pirnt_serial"]!="1"){
					$ResponseXML .="<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['serino']."  name=".$row['serino']." onClick=\"del_item2('".$row['serino']."');\"></td>";
				//}
							
                   $ResponseXML .= "</tr>";
					$i=$i+1;		
			}			
			
			$sql="Select * from inv_serino_grn where refno='".trim($_GET["invno"])."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
								
						
             	$ResponseXML .= "<tr>                              
                             <td >".$row['stk_no']."</td>
							 <td >".$row['serino']."</td>";
				
				
				//if ($row1["pirnt_serial"]!="1"){
				//	$ResponseXML .="<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['serino']."  name=".$row['serino']." onClick=\"del_item('".$row['serino']."');\"></td>";
				//}
							
                   $ResponseXML .= "</tr>";
					$i=$i+1;		
			}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				
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
		
			
			include_once("connectioni.php");
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"500\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  
                            </tr>";
							
						$sql_tmp = mysqli_query($GLOBALS['dbinv'],"delete from tmp_grn_data_stores where tmp_no='".$_SESSION["tmp_grnvno"]."' and str_code='".$_GET["code"]."'") or die(mysqli_error());
				
				$i=1;
				$sql_tmp = mysqli_query($GLOBALS['dbinv'],"select * from tmp_grn_data_stores where tmp_no = '".$_SESSION["tmp_grnvno"]."'") or die(mysqli_error());	
				while($row = mysqli_fetch_array($sql_tmp)){
					
						
			
			 	$ResponseXML .= "<tr>
                        
							 <td >".$row["str_code"]."</td>
							 <td >".$row["str_description"]."</td>
							
							 <td  >".number_format($row["cur_qty"], 0, ".", "")."</td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row["str_code"]."  name=".$row["str_code"]." onClick=\"del_item('".$row["str_code"]."');\"></td>
                            </tr>";
							
							
							$i=$i+1;
            					
				}
			
			    $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	
if($_GET["Command"]=="save_item")
{

	require_once("connectioni.php");
	
	
	
  $sql_alredy="select * from s_crnma_stores where REF_NO='".$_GET["grnno"]."'";
  $result_alredy =mysqli_query($GLOBALS['dbinv'],$sql_alredy);	
  if($row_alredy = mysqli_fetch_array($result_alredy)){
	exit("Already Exist");
  } 		
		
	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
		$mvatrate=12;
			
		
			$cusname=str_replace("~", "&", $_GET["cusname"]);
			
			$sql="insert into s_crnma_stores(REF_NO, SDATE, C_CODE, CUS_NAME, DEPARTMENT, DEP_CODE, Brand, CANCELL, TRN_TYPE, stoRef) values ('".$_GET["grnno"]."', '".$_GET["grndate"]."', '".$_GET["cusno"]."', '".$cusname."', '".$_GET["department"]."', '".$_GET["department"]."', '".$_GET["brand"]."', '0', 'GRN', '".$_GET["txtstoRef"]."')";
			echo $sql;
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="select * from tmp_grn_data_stores where tmp_no = '".$_SESSION["tmp_grnvno"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			while($row = mysqli_fetch_array($result)){
				
					$sql2="insert into s_crntrn_stores(REF_NO, STK_NO, SDATE, DESCRIPT, QTY, DEPARTMENT) values ('".$_GET["grnno"]."', '".$row["str_code"]."', '".$_GET["grndate"]."', '".$row["str_description"]."', ".$row["cur_qty"].", '".$_GET["department"]."')";
					echo $sql2;
					$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
					
					
					
					$sql2="update s_mas set QTYINHAND_STORES=QTYINHAND_STORES+".$row["cur_qty"]." where STK_NO='".$row["str_code"]."'";
					$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
					
					$sql2="update s_submas_stores set QTYINHAND=QTYINHAND+".$row["cur_qty"]." where STK_NO='".$row["str_code"]."' and STO_CODE='".$_GET["department"]."'";
					$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
					
					$sql2="insert into s_trn_stores(STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, seri_no) values ('".$row["str_code"]."', '".$_GET["grndate"]."', '".$_GET["grnno"]."', ".$row["cur_qty"].", 'GRN', '".$_GET["department"]."', '".$_GET["serialno"]."')";
					$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
					
					
				
				
				$i=$i+1;
			}
			
		
			
			$sql="update invpara_stores set grn=grn+1 ";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			//$sql="delete from tmp_grn_data_stores where tmp_no='".$_SESSION["tmp_grnvno"]."' ";
			//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 

			$_SESSION["custno"]="";
			
			echo "Saved";
			
			
	}
	


if ($_GET["Command"]=="pass_grnno"){
include_once("connectioni.php");

	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			$sql=mysqli_query($GLOBALS['dbinv'],"Select * from s_crnma_stores where REF_NO='".$_GET['grn']."'")or die(mysqli_error());
			if($row = mysqli_fetch_array($sql)){		
			
				$ResponseXML .= "<REF_NO><![CDATA[".$row['REF_NO']."]]></REF_NO>";
				
				$ResponseXML .= "<C_CODE><![CDATA[".$row['C_CODE']."]]></C_CODE>";
				$ResponseXML .= "<CUS_NAME><![CDATA[".$row['CUS_NAME']."]]></CUS_NAME>";
				
				$sql_ven=mysqli_query($GLOBALS['dbinv'],"Select * from vendor where CODE='".$row['C_CODE']."'")or die(mysqli_error());
				$row_ven = mysqli_fetch_array($sql_ven);	
				$ResponseXML .= "<address><![CDATA[".$row_ven['ADD1']." ".$row_ven['ADD2']."]]></address>";
				$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
				$ResponseXML .= "<Brand><![CDATA[".$row['Brand']."]]></Brand>";
				$ResponseXML .= "<DEPARTMENT><![CDATA[".$row['DEPARTMENT']."]]></DEPARTMENT>";
				$ResponseXML .= "<stoRef><![CDATA[".$row['stoRef']."]]></stoRef>";
				$txtvatp=$row['GST'];
				
			//	$sql1="insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT) values ('".$row2["str_code"]."', '".$_GET["invdate"]."', '".$cur_qty."', 'GINI', '".$_GET["invno"]."', '".$_GET["from_dep"]."')";
				//	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
				
				
				
				
				
						$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Return Qty</font></td>
							  
                            </tr>";
							
				$i=1;
				
				//echo "delete from tmp_grn_data where str_invno='".$row['REF_NO']."'";
				$sql_data = mysqli_query($GLOBALS['dbinv'],"delete from tmp_grn_data_stores where str_invno='".$row['REF_NO']."'") or die(mysqli_error());
				//echo "Select * from s_invo where REF_NO='".$inv."'";
				
				$sql_data = mysqli_query($GLOBALS['dbinv'],"Select count(*) as mcount from s_crntrn_stores where REF_NO='".$row['REF_NO']."'") or die(mysqli_error());
				$row_data = mysqli_fetch_array($sql_data);
				$mcou=$row_data['mcount'];
				
				//echo "Select * from s_crntrn where REF_NO='".$row['REF_NO']."'";
				$sql_data = mysqli_query($GLOBALS['dbinv'],"Select * from s_crntrn_stores where REF_NO='".$row['REF_NO']."'") or die(mysqli_error());
				//echo "Select * from s_crntrn_stores where REF_NO='".$row['REF_NO']."'";
				while($row_data = mysqli_fetch_array($sql_data)){
					
				
					
					
					$sql_tmp = mysqli_query($GLOBALS['dbinv'],"Insert into tmp_grn_data_stores(str_invno, str_code, str_description, cur_qty, brand) values ( '".$row['REF_NO']."', '".$row_data['STK_NO']."', '".$row_data['DESCRIPT']."', ".$row_data["QTY"].", '".$row["Brand"]."')") or die(mysqli_error());
					
						
			
			
				
			 	$ResponseXML .= "<tr>
                        
							 <td>".$row_data['STK_NO']."</td>
							 <td>".$row_data['DESCRIPT']."</td>
							  <td>".number_format($row_data['QTY'], 0, "", ".")."</td>
						      </tr>";
							
							$i=$i+1;
							
							
							
            					
				}
			
			    $ResponseXML .= "   </table>]]></sales_table>";
				
				
				$ResponseXML .= "<serial_table><![CDATA[ <table><tr>
                              <td width=\"25%\"><font color=\"#FFFFFF\">Stock No</font></td>
               				 	<td width=\"40%\"><font color=\"#FFFFFF\">Serial No</font></td>
							  </tr>";
			  $sql="Select * from inv_serino_grn where refno='".trim($_GET['grn'])."'";
			  $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			  while($row = mysqli_fetch_array($result)){	
								
						
             	$ResponseXML .= "<tr>                              
                             <td >".$row['stk_no']."</td>
							 <td >".$row['serino']."</td>";
				
				
				//if ($row1["pirnt_serial"]!="1"){
				//	$ResponseXML .="<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['serino']."  name=".$row['serino']." onClick=\"del_item('".$row['serino']."');\"></td>";
				//}
							
                   $ResponseXML .= "</tr>";
					$i=$i+1;		
			  }			
							
                $ResponseXML .= "   </table>]]></serial_table>";
				
				
			
				$ResponseXML .= " </salesdetails>";
				
			}	
				
				
				echo $ResponseXML;
}	

if($_GET["Command"]=="cancel_inv")
{

	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
	/*		$_SESSION["CURRENT_DOC"] = 1;      //document ID
			$_SESSION["VIEW_DOC"] = false ;     //view current document
			$_SESSION["FEED_DOC"] = true;       //save  current document
			$_GET["MOD_DOC"] = false  ;         //delete   current document
			$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
			$_GET["PRICE_EDIT"] = false ;       //edit selling price
			$_GET["CHECK_USER"] = false ;       //check user permission again

	*/
			$mvatrate=12;
			
		
			$sql="select * from s_crnma_stores where REF_NO='".$_GET["grnno"]."'";
			//echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				if ($row = mysqli_fetch_array($result)) {
					$sql1="update s_crnma_stores set CANCELL='1' where REF_NO='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
					$sql1="update s_crntrn_stores set CANCELL='1' where REF_NO='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
					$sql2="select * from s_crntrn_stores where REF_NO='".$_GET["grnno"]."'";
					//echo $sql;
					$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
					$i=1;
					while ($row2 = mysqli_fetch_array($result2)){
						
						//if ($row2["QTY"]>0){
											
							$sql1="update s_mas set QTYINHAND_STORES=QTYINHAND_STORES-".$row2["QTY"]." where STK_NO='".$row2["STK_NO"]."'";
							$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
							$sql1="update s_stomas_stores set QTYINHAND=QTYINHAND-".$row2["QTY"]." where STK_NO='".$row2["STK_NO"]."' and STO_CODE='".$_GET["department"]."'";
							$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
                           
					//	}
						$i=$i+1;
					}
			
					$sql1="delete from s_trn_stores where ltrim(REFNO)='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
							
					echo "Canceled";	
				} else {
					echo "Can't Cancel";	
				}
				
				

			
			
			$_SESSION["custno"]="";
			
			
			
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
   		If (is_null($row["cat"])==false) {
      		$cat = trim($row["cat"]);
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