<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("connectioni.php");
	
	
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
	
	
	if ($_GET["Command"]=="chk_user"){
	
		$sql="select * from userpermission where username='" . $_GET["txtUserName"] . "' and userpass='" . md5($_GET["txtPassword"])."' and docid=" . $_SESSION["CURRENT_DOC"] ;
		
		
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
    	if ($row = mysqli_fetch_array($result)){
    		
			//echo "VIEW_DOC-".$_SESSION["PRICE_EDIT"];
			//echo "User_Type-".$_SESSION['User_Type'];
      		if ($_SESSION["VIEW_DOC"]=="true"){
            	$_SESSION["AUTH_OK"] = $row["doc_view"];
            	$actType = "view";
      		}
      		if ($_SESSION["FEED_DOC"]=="true"){
				$_SESSION["AUTH_OK"] = $row["doc_feed"];
            	$actType = "save";
      		}
      		if ($_SESSION["MOD_DOC"]=="true") {
            	$_SESSION["AUTH_OK"] = $row["doc_mod"];
            	$actType = "delete";
      		}
      		if ($_SESSION["PRINT_DOC"]=="true") {
            	$_SESSION["AUTH_OK"] = $row["doc_print"];
            	$actType = "print";
      		}
      		if ($_SESSION["PRICE_EDIT"]=="true") {
				echo $row["price_edit"];
            	$_SESSION["AUTH_OK"] = $row["price_edit"];
            	$actType = "price";
      		}
      		
			
    	} else {
        	if ($_SESSION["CURRENT_DOC"] == "0") {
       			$sql2="select * from userpermission where username='" . $_GET["txtUserName"] . "' and userpass='" . md5($_GET["txtPassword"])."' ";
				echo "3-".$sql2;
				$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
				if ($row2 = mysqli_fetch_array($result2)){
                	if ($row2["admin"]=="1") {
            			$_SESSION["AUTH_OK"] = "1";
            		}else{
            			$_SESSION["AUTH_OK"] = "0";
					}	
            	}
        	} else {
           		$_SESSION["AUTH_OK"] = "0";
        	}
    	}
    	
		if (trim($_SESSION["CURRENT_DOC"]=="")) {
		if ($_SESSION['User_Type']=="1") {
            	$_SESSION["AUTH_OK"] = $_SESSION['User_Type'];
            	$actType = "creedit";
      		}
		}
		
		if ($_SESSION["AUTH_OK"]!="1") {
      		exit ("Access Denied");
		} else {
        	if (trim($crLmt) == "") { $crLmt = 0; }
        	if (trim($CrTmpLmt) == "") { $CrTmpLmt = 0; }
        	/*if ($_SESSION["CURRENT_DOC"] == "66" Or CURRENT_DOC = "65" Then
            AuthCon.Execute "insert into entry_log (refno,username,docid,docname,trnType,stime,sdate,CrLmt,TmpCrLmt) " _
            & " VALUES ('" & REFNO & "','" & Trim(txtUserName) & "'," & CURRENT_DOC & " ,'" & GetDocName(CURRENT_DOC) & "' ,'" & actType & "' ,'" & Time & "','" & Date & "'," & crLmt & " ," & CrTmpLmt & ")"
        Else*/
			
			$sql_doc="select * from doc where docid=" . $_SESSION["CURRENT_DOC"] . "";
   			$result_doc =mysqli_query($GLOBALS['dbinv'],$sql_doc);
    		$row_doc = mysqli_fetch_array($result_doc);
			
			$sql_log="insert into entry_log (refno, username, docid, docname, trnType, stime, sdate)  VALUES ('" . $_SESSION["REFNO"] . "', '" . trim($_GET["txtUserName"]) . "', " . $_SESSION["CURRENT_DOC"] . " , '" . $row_doc["docname"] . "' ,'" . $actType . "', '" . date("H:i:s") . "', '" . date("Y-m-d") . "')";
				
       // End If
        
     		$_SESSION["AUTH_USER"] = $_GET["txtUserName"];
     		/*$_SESSION["VIEW_DOC"] = "false";
     		$_SESSION["FEED_DOC"] = "false";
     		$_SESSION["MOD_DOC"] = "false";
     		$_SESSION["PRINT_DOC"] = "false";
     		$_SESSION["PRICE_EDIT"] = "false";*/
    
    	}
		
		if ($_GET["stname"]=="item_mast"){
			echo $_SESSION["AUTH_OK"];
		}
		
		
		if ($_GET["stname"]=="cash_crn_form"){
			if ($_SESSION["AUTH_OK"]!="1") {
        		exit("You have No Permission");
        	}
    
    		
    		if (($_GET["txt_cuscode"] != "") and ($_GET["mcou"] != "") and ($_GET["mcou"] > 0)) {
        		$mrefno = trim($_GET["txtrefno"]);
				
				$sql_rscrnfrm="Select * from s_crnfrm where Refno = '" . $mrefno . "'";
				//echo $sql_rscrnfrm;
   				$result_rscrnfrm =mysqli_query($GLOBALS['dbinv'],$sql_rscrnfrm);
    			while ($row_rscrnfrm = mysqli_fetch_array($result_rscrnfrm)){
					$sql="update s_crnfrm set Checked = '" . $_SESSION["CURRENT_USER"] . "', Check_date = '" . date("Y-m-d") . "' where Refno = '" . $mrefno . "'";
					//echo $sql;
   					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
            
        		}
        		echo "Recordes are marked as Checked";
    		}
    	}
		
		
		if ($_GET["stname"]=="crn"){
			 
			if (trim($_SESSION["AUTH_OK"])!="1") {
        		exit("You have No Permission");
        	}
    

    		if (($_GET["txt_cuscode"] != "")) {
        		$mrefno = trim($_GET["txtrefno"]);
				
				$sql_rscrnfrm="Select * from c_bal where Refno = '" . $mrefno . "'";
   				$result_rscrnfrm =mysqli_query($GLOBALS['dbinv'],$sql_rscrnfrm);
    			while ($row_rscrnfrm = mysqli_fetch_array($result_rscrnfrm)){
					$sql="update c_bal set active = '0'  where Refno = '" . $mrefno . "'";
   					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
        		}
        		echo "Recordes are marked as Unlocked";
    		}	
    	}
		
		if ($_GET["stname"]=="cash_crn_form_autho"){
			if ($_SESSION["AUTH_OK"]!="1") {
        		exit("You have No Permission");
        	}
    
    		
    		if (($_GET["txt_cuscode"] != "") and ($_GET["mcou"] != "") and ($_GET["mcou"] > 0)) {
        		$mrefno = trim($_GET["txtrefno"]);
				
				$sql_rscrnfrm="Select * from s_crnfrm where Refno = '" . $mrefno . "'";
   				$result_rscrnfrm =mysqli_query($GLOBALS['dbinv'],$sql_rscrnfrm);
    			while ($row_rscrnfrm = mysqli_fetch_array($result_rscrnfrm)){
					$sql="update s_crnfrm set Approved = '" . $_SESSION["CURRENT_USER"] . "', App_date = '" . date("Y-m-d") . "', Lock1='1'  where Refno = '" . $mrefno . "'";
   					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
            
        		}
        		echo "Recordes are marked as Locked";
    		}
    	}
		
		if ($_GET["stname"]=="crn_form"){
			if ($_SESSION["AUTH_OK"]!="1") {
        		exit("You have No Permission");
        	}
    
    		
    		if (($_GET["txt_cuscode"] != "") and ($_GET["mcou"] != "") and ($_GET["mcou"] > 0)) {
        		$mrefno = trim($_GET["txtrefno"]);
				
				$sql_rscrnfrm="Select * from s_crnfrm where Refno = '" . $mrefno . "'";
   				$result_rscrnfrm =mysqli_query($GLOBALS['dbinv'],$sql_rscrnfrm);
    			while ($row_rscrnfrm = mysqli_fetch_array($result_rscrnfrm)){
					$sql="update s_crnfrm set Checked = '" . $_SESSION["CURRENT_USER"] . "', Check_date = '" . date("Y-m-d") . "' where Refno = '" . $mrefno . "'";
   					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
            
        		}
        		echo "Recordes are marked as Checked";
    		}
    	}
		
		if ($_GET["stname"]=="crn_form_autho"){
			if ($_SESSION["AUTH_OK"]!="1") {
        		exit("You have No Permission");
        	}
    
    		
    		if (($_GET["txt_cuscode"] != "") and ($_GET["mcou"] != "") and ($_GET["mcou"] > 0)) {
        		$mrefno = trim($_GET["txtrefno"]);
				
				$sql_rscrnfrm="Select * from s_crnfrm where Refno = '" . $mrefno . "'";
   				$result_rscrnfrm =mysqli_query($GLOBALS['dbinv'],$sql_rscrnfrm);
    			while ($row_rscrnfrm = mysqli_fetch_array($result_rscrnfrm)){
					$sql="update s_crnfrm set Approved = '" . $_SESSION["CURRENT_USER"] . "', App_date = '" . date("Y-m-d") . "', Lock1='1'  where Refno = '" . $mrefno . "'";
   					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
            
        		}
        		echo "Recordes are marked as Locked";
    		}
			
			
    	}
		
		 
	}
		
		
		
	
?>