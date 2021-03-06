<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<style>
table
{
border-collapse:collapse;
}
table, td, th
{
border:1px solid black;
font-family:Arial, Helvetica, sans-serif;
padding:5px;
}
th
{
font-weight:bold;
font-size:12px;

}
td
{
font-size:11px;

}
</style>

</head>

<body>
	<?php
	
    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmpstk";
	$result =$db->RunQuery($sql);
	


function cost()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	
	if ($_GET["department"] == "All"){
        if ($_GET["brand"] != "All") {$sql = "select * from s_mas where BRAND_NAME='".$_GET["brand"]."' and QTYINHAND<>0 and COST<>0 ORDER BY GROUP1, GROUP2, model "; }
        if ($_GET["brand"] == "All") {$sql = "select * from s_mas where QTYINHAND<>0 and COST<>0 order by GROUP1, GROUP2, model ";}
    }
	
    if ($_GET["department"] != "All"){
        if ($_GET["brand"] != "All") { $sql = "select * from viewsubmas where BRAND_NAME='".$_GET["brand"]."' and QTYINHAND<>0 and COST<>0 ORDER BY GROUP1, GROUP2, model "; }
        if ($_GET["brand"]	== "All") { $sql = "select * from viewsubmas where QTYINHAND<>0 and COST<>0 ORDER BY GROUP1, GROUP2, model  "; }
    }
	
	
	echo "<table border=1><tr>
		<th>Item</th><th>Description</th><th>Part No</th><th>Qty in hand </th><th>Cost</th><th>Total</th></tr>";
	
	
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){
		echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PART_NO"]."</td><td align=\"right\">".$rows["QTYINHAND"]."</td><td align=\"right\">".number_format($rows["COST"], 2, ".", ",")."</td><td align=\"right\">".number_format($rows["QTYINHAND"]*$rows["COST"], 2, ".", ",")."</td></tr>";
	}
	
	echo "</table>";
}


function selling()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	    if ($_GET["brand"] != "All") { $sql = "select * from s_mas where BRAND_NAME='".$_GET["brand"]."' and QTYINHAND<>0 and COST<>0 ORDER BY GROUP1, model, GROUP2 ";}
        if ($_GET["brand"] == "All") { $sql = "select * from s_mas where QTYINHAND<>0 and COST<>0 ORDER BY BRAND_NAME, GROUP1, model, GROUP2 ";}
        
        echo "<table border=1><tr>
		<th>Item</th><th>Description</th><th>Part No</th><th>Qty in hand </th><th>Cost</th><th>Total</th></tr>";
	
	
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){
		echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PART_NO"]."</td><td align=\"right\">".$rows["QTYINHAND"]."</td><td align=\"right\">".$rows["COST"]."</td><td align=\"right\">".$rows["QTYINHAND"]*$rows["COST"]."</td></tr>";
	}
	
	echo "</table>";
       
}
	
function print_rep()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	 if ($_GET["brand"] != "All") { $sql = "select * from s_mas where BRAND_NAME='".$_GET["brand"]."' and QTYINHAND<>0 ORDER BY  GROUP1, model, GROUP2 "; }
     if ($_GET["brand"] == "All") { $sql = "select * from s_mas where QTYINHAND<>0 ORDER BY BRAND_NAME, GROUP1, model, GROUP2 "; }

  	echo "<table border=1><tr>
		<th>Item</th><th>Description</th><th>Part No</th><th>Qty in hand </th><th>Cost</th><th>Total</th></tr>";
	
	
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){
		echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PART_NO"]."</td><td align=\"right\">".$rows["QTYINHAND"]."</td><td align=\"right\">".$rows["COST"]."</td><td align=\"right\">".$rows["TOTCOST"]*$rows["COST"]."</td></tr>";
	}
	
	echo "</table>";
}
	
function printit_print()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$sql = "select * from tmpstk where QTYINHAND<>0 and TOTCOST<>0 "; 

  	echo "<table border=1><tr>
		<th>Item</th><th>Description</th><th>Part No</th><th>Qty in hand </th><th>Cost</th><th>Total</th></tr>";
	
	
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){
		echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PARTNO"]."</td><td align=\"right\">".$rows["QTYINHAND"]."</td><td align=\"right\">".$rows["COST"]."</td><td align=\"right\">".$rows["TOTCOST"]."</td></tr>";
	}
	
	echo "</table>";
}	

function printit()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$sql = "select * from tmpstk where QTYINHAND<>0 and TOTCOST<>0 "; 

  	echo "<table border=1><tr>
		<th>Item</th><th>Description</th><th>Part No</th><th>Qty in hand </th><th>Cost</th><th>Total</th></tr>";
	
	
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){
		echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PARTNO"]."</td><td align=\"right\">".$rows["QTYINHAND"]."</td><td align=\"right\">".$rows["COST"]."</td><td align=\"right\">".$rows["TOTCOST"]."</td></tr>";
	}
	
	echo "</table>";
}


if ($_GET["department"]=="All"){
	
	if ($_GET["chkitem"]!="on") {
		if ($_GET["stype"]=="Cost"){
			
			cost();
		} else if ($_GET["stype"]=="Selling"){
			
			selling();
		} else {
			
			print_rep();
		}
	} else {
		
        $sql="select itemcode, name from tmpitem";
		$result =$db->RunQuery($sql);
		while ($rows = mysql_fetch_array($result)){
	    	
			$sql1="select * from s_mas where STK_NO='".$rows["itemcode"]."'";
			$result1 =$db->RunQuery($sql1);
			if ($rows1 = mysql_fetch_array($result1)){
            	$costval=0;
            	if ($_GET["stype"] == "Cost") {
                	if (!is_null($rows1["acc_cost"])) {$costval = $rows1["acc_cost"];}
            	} else {
					if (!is_null($rows1["selling"])) {$costval = $rows1["selling"];}
            	}
                
				$sql2="Insert into tmpstk (STK_NO, DESCRIPT, PARTNO, COST, TOTCOST, QTYINHAND) values ('".$rows1["STK_NO"]."', '".$rows1["DESCRIPT"]."', '".$rows1["PART_NO"]."', ".$costval.", ".$costval * $rows1["QTYINHAND"].", ".$rows1["QTYINHAND"].")";
				
           		$result2 =$db->RunQuery($sql2);
            	$costval = 0;
            }

        }
      
       if ($_GET["stype"] == "Print"){
	   		
       		printit_print();
       } else {
	   		echo "printit";
			printit();
       }
		
		
	}

} else {
	
	if ($_GET["chkitem"]!="on") {
	
    	if ($_GET["brand"] != "All")  {$sql = "select * from viewsubmas where BRAND_NAME='" & cmbbrand & "' and STO_CODE='".$_GET["department"]."' and QTYINHAND<>0  ORDER BY GROUP1, GROUP2, model ";}
        
		if ($_GET["brand"] == "All")  {$sql = "select * from viewsubmas where STO_CODE='".$_GET["department"]."' and QTYINHAND<>0  ORDER BY  GROUP1, GROUP2, model ";}
		
			$result =$db->RunQuery($sql);
			while ($rows = mysql_fetch_array($result)){
				$costval=0;
    			if ($_GET["stype"] == "Cost") {
                	if (!is_null($rows["acc_cost"])) { $costval = $rows["acc_cost"]; }
                } else {
                 	if (!is_null($rows["selling"])) { $costval = $rows["selling"]; }
                }
				
				$sql1="Insert into tmpstk (STK_NO, DESCRIPT, PARTNO, COST, TOTCOST, QTYINHAND, BRAND) values ('".$rows["STK_NO"]."', '".$rows["DESCRIPt"]."', '".$rows["PART_NO"]."', ".$costval.", ".$costval * $rows["QTYINHAND"].", ".$rows["QTYINHAND"].", '".$rows["BRAND_NAME"]."')";
                $result1 =$db->RunQuery($sql1);
   				$costval = 0;
      
    		}
	 
       if ($_GET["stype"] == "Print") {
       		printit_print();
       } else{
       		printit();
       }
    
	} else {
        
        $sql1="select * from tmpitem";
		$result =$db->RunQuery($sql);
		while ($rows = mysql_fetch_array($result)){
            $sql1="select * from s_mas where STK_NO='".$rows["itemcode"]."'";
			$result1 =$db->RunQuery($sql1);
			if ($rows2 = mysql_fetch_array($result2)){
				$sql2="select QTYINHAND from s_submas where STK_NO='".$rows["itemcode"]."' and STO_CODE='".$_GET["department"]."'";
				$result2 =$db->RunQuery($sql2);
				if ($rows2 = mysql_fetch_array($result2)){
					$costval=0;
					if ($_GET["stype"] = "Cost"){
                		$costval = $rows1["acc_cost"];
					} else {
						$costval = $rows1["selling"];
					}	
          
                	$sql3="Insert into tmpstk (STK_NO, DESCRIPT, PARTNO, TOTCOST, QTYINHAND, BRAND) values 
					('".$rows1["STK_NO"]."', '".$rows1["DESCRIPT"]."', '".$rows1["PART_NO"]."', ".$costval.", ".$costval * $rows2["QTYINHAND"].", ".$rows2["QTYINHAND"].", '".$rows1["BRAND_NAME"]. "')";
					$result3 =$db->RunQuery($sql3);
					$costval = 0;

				}
			}
		}

       	if ($_GET["stype"] == "Print"){
        	printit_print();
       	} else {
        	printit();
       	}
    }
}	
	


?>
</body>
</html>
