<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
		
if($_GET["Command"]=="select_permission")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	
			
	$ResponseXML = "";
	
			
	$ResponseXML .= " <salesdetails>";
		
	$ResponseXML .= "<balance_table><![CDATA[<table width=\"1000\" border=\"0\" class=\"form-matrix-table\">";
	$ResponseXML .= "<table width=\"1000\" border=\"1\" class=\"form-matrix-table\">";
		 		
	$i=1;
		$ResponseXML .= " <tr>
      <th scope=\"col\"  width=\"300px\"><input type=\"text\"  class=\"label_purchase\" value=\"Form Name\" disabled=\"disabled\"/></th>
      <th scope=\"col\"><input type=\"text\"  class=\"label_purchase\" value=\"Category\" disabled=\"disabled\"/></th>
	  <th scope=\"col\"><input type=\"text\"  class=\"label_purchase\" value=\"View\" disabled=\"disabled\"/></th>
      <th scope=\"col\"><input type=\"text\"  class=\"label_purchase\" value=\"Feed\" disabled=\"disabled\"/></th>
      <th scope=\"col\"><input type=\"text\"  class=\"label_purchase\" value=\"Modify\" disabled=\"disabled\"/></th>
      <th scope=\"col\"><input type=\"text\"  class=\"label_purchase\" value=\"Price Edit\" disabled=\"disabled\"/></th>
      <th scope=\"col\"><input type=\"text\"  class=\"label_purchase\" value=\"Print\" disabled=\"disabled\"/></th>
    </tr>";
	
	$sql1="Select * from doc order by docid";
	$result1 =$db->RunQuery($sql1);					
   	while ($row1 = mysql_fetch_array($result1)){
        	$chkview = "chkview".$i;
        	$chkfeed = "chkfeed".$i;
        	$chkmod = "chkmod".$i;
        	$chkprice = "chkprice".$i;
        	$chkprint = "chkprint".$i;
        	        	
        				
				
			$sql="Select * from userpermission   where username='".trim($_GET["user_name"])."' and docid=".$row1["docid"]."";
			$result =$db->RunQuery($sql);	
			if ($row = mysql_fetch_array($result)){	
				$ResponseXML .=  "	<tr>
      					<td>".$row1["docid"].". ".$row1["docname"]."</td>
						<td>".$row1["grp"]."</td>";
						if ($row["doc_view"]==1){
      						$ResponseXML .= "<td align=\"center\"><input type=\"checkbox\" name=\"".$chkview."\" id=\"".$chkview."\" checked=\"checked\" /></td>";
						} else {
							$ResponseXML .= "<td align=\"center\"><input type=\"checkbox\" name=\"".$chkview."\" id=\"".$chkview."\" /></td>";
						}
						
						if ($row["doc_feed"]==1){	
      						$ResponseXML .= "<td align=\"center\"><input type=\"checkbox\" name=\"".$chkfeed."\" id=\"".$chkfeed."\" checked=\"checked\"/></td>";
						} else {
							$ResponseXML .= "<td align=\"center\"><input type=\"checkbox\" name=\"".$chkfeed."\" id=\"".$chkfeed."\" /></td>";
						}	
						
						if ($row["doc_mod"]==1){	
							$ResponseXML .= "<td align=\"center\"><input type=\"checkbox\" name=\"".$chkmod."\" id=\"".$chkmod."\"checked=\"checked\" /></td>";
						} else {
							$ResponseXML .= "<td align=\"center\"><input type=\"checkbox\" name=\"".$chkmod."\" id=\"".$chkmod."\" /></td>";
						}	
						if ($row["price_edit"]==1){	
							$ResponseXML .= "<td align=\"center\"><input type=\"checkbox\" name=\"".$chkprice."\" id=\"".$chkprice."\" checked=\"checked\"/></td>";
							} else {
								$ResponseXML .= "<td align=\"center\"><input type=\"checkbox\" name=\"".$chkprice."\" id=\"".$chkprice."\" /></td>";
							}
						if ($row["doc_print"]==1){		
      						$ResponseXML .="<td align=\"center\"><input type=\"checkbox\" name=\"".$chkprint."\" id=\"".$chkprint."\" checked=\"checked\"/></td>";
						} else {
							$ResponseXML .="<td align=\"center\"><input type=\"checkbox\" name=\"".$chkprint."\" id=\"".$chkprint."\" /></td>";
						}	
   
																				
                    $ResponseXML .=  "</tr>";
				} else {
					$ResponseXML .=  "	<tr>
      					<td>".$row1["docid"].". ".$row1["docname"]."</td>
						<td>".$row1["grp"]."</td>";
						
						$ResponseXML .= "<td align=\"center\"><input type=\"checkbox\" name=\"".$chkview."\" id=\"".$chkview."\" /></td>";
						$ResponseXML .= "<td align=\"center\"><input type=\"checkbox\" name=\"".$chkfeed."\" id=\"".$chkfeed."\" /></td>";
						$ResponseXML .= "<td align=\"center\"><input type=\"checkbox\" name=\"".$chkmod."\" id=\"".$chkmod."\" /></td>";
						$ResponseXML .= "<td align=\"center\"><input type=\"checkbox\" name=\"".$chkprice."\" id=\"".$chkprice."\" /></td>";
						$ResponseXML .="<td align=\"center\"><input type=\"checkbox\" name=\"".$chkprint."\" id=\"".$chkprint."\" /></td>";
						   
																				
                    	$ResponseXML .=  "</tr>";
				}	
			$i=$i+1;
		
		}
		
       $ResponseXML .= "   </table>]]></balance_table>";   
	   $ResponseXML .= "<mcount><![CDATA[".$i."]]></mcount>";
	     
	   $ResponseXML .= " </salesdetails>";    
		echo $ResponseXML;		
	}
						
if($_POST["Command"]=="save_inv")
{
		$pass="";
		
		$sql1="select * from user_mast where user_name='".$_POST["user_name"]."'";
		$result1 =$db->RunQuery($sql1);	
		if ($row1 = mysql_fetch_array($result1)){
			$pass=$row1["user_pass"];
			$admin=$row1["user_level"];
			$dev=$row1["dev"];
		}
			   
		$sql1="delete from userpermission where username='".$_POST["user_name"]."'";
		$result1 =$db->RunQuery($sql1);		
		
		$i=1;
		$sql1="Select * from doc order by docid";
		$result1 =$db->RunQuery($sql1);					
   		while ($row1 = mysql_fetch_array($result1)){
        	$chkview = "chkview".$i;
        	$chkfeed = "chkfeed".$i;
        	$chkmod = "chkmod".$i;
        	$chkprice = "chkprice".$i;
        	$chkprint = "chkprint".$i;
			
			
			if ($_POST[$chkview]=="true"){
				$view=1;
			} else {
				$view=0;
			}
			
			if ($_POST[$chkfeed]=="true"){
				$feed=1;
			} else {
				$feed=0;
			}
			
			if ($_POST[$chkmod]=="true"){
				$mod=1;
			} else {
				$mod=0;
			}
			
			if ($_POST[$chkprice]=="true"){
				$price=1;
			} else {
				$price=0;
			}
			
			if ($_POST[$chkprint]=="true"){
				$print=1;
			} else {
				$print=0;
			}
			
			$sql="insert into userpermission(username, userpass, grp, docid, doc_view, doc_feed, doc_mod, price_edit, admin, dev, doc_print) values  ('".$_POST["user_name"]."', '".$pass."', '".$row1["grp"]."', ".$row1["docid"].", ".$view.", ".$feed.", ".$mod.", ".$price.", ".$admin.", ".$dev.", ".$print.")";
			//echo $sql;
			$result =$db->RunQuery($sql);		
			
			$i=$i+1;
		}
		
		echo "Saved";		   
}			   						
 
?>