<?php


$sql = "select * from s_cheq where  cr_date >='2016-01-01'";

include_once("connectioni.php");

$result_m = mysqli_query($GLOBALS['dbinv'],$sql);
			while ($row_m = mysqli_fetch_array($result_m)){

			$acou = 0;
			$i=0;
			$cou =9;
			$mchno = trim($row_m['CR_CHNO']);
			$mchdate = $row_m["CR_CHDATE"];
			//echo $t;
			while ($i <= $cou) {
				
			$sql = "select * from  s_invcheq where  cheque_no='". trim($mchno) ."' and che_date = '". $mchdate ."'";
			
			$result = mysqli_query($GLOBALS['dbinv'],$sql);
			if($row = mysqli_fetch_array($result)){
				  
				if (trim($row['trn_type']) == "RET") {
					$sql = "select * from ch_sttr where st_refno ='" . $row['refno'] . "' and st_chno ='"  . $row['cheque_no'] . "'";
					$result_p = mysqli_query($GLOBALS['dbinv'],$sql);
					
					if ($row_p = mysqli_fetch_array($result_p)){
						$sql = "select * from s_cheq where cr_refno ='" . $row_p['ST_INVONO'] . "'";
						$result_p1 = mysqli_query($GLOBALS['dbinv'],$sql);
						if ($row_p1 = mysqli_fetch_array($result_p1)) {
							
							$sql = "select * from  s_invcheq where  cheque_no='". trim($row_p1['CR_CHNO']) ."' and che_date = '". $row_p1['CR_CHDATE'] ."'";
							$result_p2 = mysqli_query($GLOBALS['dbinv'],$sql);
							if($row_p2 = mysqli_fetch_array($result_p2)) {
								$mchno = trim($row_p2["cheque_no"]);
								$mchdate = $row_p2["che_date"];
							} else {
								$cou = $i;
							}
							
						}
						$acou = $acou+1;
					} else {
					
					$cou = $i;

					
					}	
					
			} else {
				$t ="t";
				$mrefno = $row['refno'];
				$cou = $i;
				$acou = $acou+1;
			}	
			}
			$i = $i +1;
			}

			$sql = "update s_cheq set retcout = '" . $acou . "',pdno = '" . $mrefno . "' where cr_refno = '" . $row_m['CR_REFNO'] . "'";
			$result_p =  mysqli_query($GLOBALS['dbinv'],$sql);
			
			}

?>