<?php

$hostname = 'localhost';
$username = 'root';
$password = '';

$ben = mysql_connect($hostname, $username, $password, true);
$ben_tyre = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben', $dbinv);

mysql_select_db('ben', $ben);
mysql_select_db('ben_tyre', $ben_tyre);

$sql = "SELECT * FROM c_clamas WHERE entdate >='2014-08-19'";
$result = mysql_query($sql, $ben);
while ($row = mysql_fetch_array($result)) {

  
    $sql1 = "insert into c_clamas  (refno, entdate, recieve_date, cl_no, ag_code, ag_name, agadd, cus_name, cus_add, stk_no, des, brand, siz, pr, patt, seri_no, tc_ob, Mn_ob, remin, cldate, spec, remming, ref_per, CRD_no, CRE_date, CRE_amount, origin1, origin2, origin3, origin4, origin5, remin1, remin2, remin3, remin4, remin5, rem_per, Refund, Commercialy, add_ref1, add_ref2, approve_md_wd, gatepass, returndate, type, DGRN_NO, DGRN_NO2, DGRN_NO3) values ('".$row["refno"]."', '".$row["entdate"]."', '".$row["recieve_date"]."', '".$row["cl_no"]."', '".$row["ag_code"]."', '".$row["ag_name"]."', '".$row["agadd"]."', '".$row["cus_name"]."', '".$row["cus_add"]."', '".$row["stk_no"]."', '".$row["des"]."', '".$row["brand"]."', '".$row["siz"]."', '".$row["pr"]."', '".$row["patt"]."', '".$row["seri_no"]."', '".$row["tc_ob"]."', '".$row["Mn_ob"]."', '".$row["remin"]."', '".$row["cldate"]."', '".$row["spec"]."', '".$row["remming"]."', '".$row["ref_per"]."', '".$row["CRD_no"]."', '".$row["CRE_date"]."', '".$row["CRE_amount"]."', '".$row["origin1"]."', '".$row["origin2"]."', '".$row["origin3"]."', '".$row["origin4"]."', '".$row["origin5"]."', '".$row["remin1"]."', '".$row["remin2"]."', '".$row["remin3"]."', '".$row["remin4"]."', '".$row["remin5"]."', '".$row["rem_per"]."', '".$row["Refund"]."', '".$row["Commercialy"]."', '".$row["add_ref1"]."', '".$row["add_ref2"]."', '".$row["approve_md_wd"]."', '".$row["gatepass"]."', '".$row["returndate"]."', '".$row["type"]."', '".$row["DGRN_NO"]."', '".$row["DGRN_NO2"]."', '".$row["DGRN_NO3"]."' )";
    echo $sql1 . "<br>";
    $result1 = mysql_query($sql1, $ben_tyre);

}






  
?>