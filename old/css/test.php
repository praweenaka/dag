<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table>
 <?php 
							
							require_once("config.inc.php");
							require_once("DBConnector.php");
							$db = new DBConnector();
							
								$sql="SELECT * FROM s_salma where  CANCELL='0' and SDATE>2012-01-01 order by SDATE desc";
							
							//echo $sql;
							$result =$db->RunQuery($sql);
							while($row = mysql_fetch_array($result)){
							
							echo "<tr>               
                              <td onclick=\"invno('".$row['REF_NO']."', '".$_GET['stname']."');\">".$row['REF_NO']."</a></td>
                              <td onclick=\"invno('".$row['REF_NO']."', '".$_GET['stname']."');\">".$row["CUS_NAME"]."</a></td>
                              <td onclick=\"invno('".$row['REF_NO']."', '".$_GET['stname']."');\">".$row['SDATE']."</a></td>
                              
                            </tr>";
							}
							  ?>
                              </table>
</body>
</html>
