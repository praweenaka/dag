
<?php
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	
	
	$cou=1;
	echo"dfksdkf". $_POST["mcount"];
	while($_POST["mcount"]>$cou){
	
		$barnd_name="barnd_name".$cou;
		$b60="b60".$cou;
		$d60to75="d60to75".$cou;
		$d75to90="d75to90".$cou;
		$o90="o90".$cou;
	
	$sql1="update brand_mas set b60='".$_POST[$b60]."', d60to75='".$_POST[$d60to75]."', d75to90='".$_POST[$d75to90]."', o90='".$_POST[$o90]."' where barnd_name='".$_POST[$barnd_name]."'";
		
	
	echo $sql1;
	$result1 =$db->RunQuery($sql1);
	$cou=$cou+1;
	
	}
	echo "Successfully Saved";
?>	
