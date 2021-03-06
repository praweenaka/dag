<?php
	
	
	$UserName=$_GET["UserName"];
	$Password=$_GET["Password"];
	$Command=$_GET["Command"];
	

	
if($Command=="CheckUsers")

	{	
	
	
	$connection = mysql_connect("localhost","root", "");
	$db = "tyre";
	mysql_select_db($db, $connection) or die( "Could not open $db database");

	
					$UserName = mysql_real_escape_string($UserName);
					$Password = mysql_real_escape_string($Password);
					
					
					
					
					
					
				$sql="SELECT
					administrator.str_Admin_Name,
					administrator.str_Password,
					administrator.User_Type
					FROM
					administrator
					WHERE
					administrator.str_Admin_Name =  '".$UserName."' AND
					administrator.str_Password =  '".$Password."' ";
					
	
					$result =mysql_query($sql, $connection);
				
					if($row = mysql_fetch_array($result))
					  {
						session_start();
						$sessionId = session_id(  );
						$_SESSION['sessionId']=session_id(  );
						session_regenerate_id();
						$ip=$_SERVER['REMOTE_ADDR'];
						$_SESSION['UserName']=$UserName;
						$_SESSION['User_Type']=$row['User_Type'];
						
						echo $row['User_Type'];
						
						$time_now=mktime(date('h')+5,date('i')+30,date('s'));
						$time=date('h:i:s',$time_now);
						$today = date('Y-m-d');
						
						$sql1="Insert into loging(Name,User_Type,Date,Logon_Time,Sessioan_Id,ip) values ('".$UserName."','".$row['User_Type']."','".$today."','".$time."','".$_SESSION['sessionId']."','".$ip."')";
						
						$result1 =mysql_query($sql1, $connection);
						
						
						
						}	
					
					
					
					
	}

			
			
			

else if($Command=="logout")
	{
		
		
	$connection = mysql_connect("localhost","weldb", "uY4xjyHNur7JYNGj");
	$db = "welfare1";
	mysql_select_db($db, $connection) or die( "Could not open $db database");
		
		
		session_start();
		//$_SESSION['int_User_ID']=$int_User_ID;
		echo $_SESSION['sessionId'];
		
		$time_now=mktime(date('h')+5,date('i')+30,date('s'));
		$time=date('h:i:s',$time_now);
		$today = date('Y-m-d');
		
		$sql="UPDATE loging
			  SET Logout_Time='".$time."'
			  WHERE Sessioan_Id='".$_SESSION['sessionId']."'";
			  
			  $result =mysql_query($sql, $connection);
			  
			
			
			  $sqlDelete="Delete FROM active_users
			  where Sessioan_Id='".$_SESSION['sessionId']."'";
			   $result1 =mysql_query($sqlDelete, $connection);
			 
			
		session_unset();
		session_destroy();
			
}











?>