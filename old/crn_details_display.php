<?php 

						 
	require_once("connectioni.php");
	
 
?>	


<link rel="stylesheet" href="css/table.css" type="text/css"/>	
 

</label>
      
 <?php
 	$sql="Select * from cred where C_REFNO='".$_GET['crnno']."'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
	$row = mysqli_fetch_array($result);
 ?>     
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Credit Note Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="14%"><input type="text"  class="label_purchase" value="CRN No" disabled/></td>
    <td width="14%"><input type="text" name="crnno" id="crnno" disabled="disabled" value="<?php echo $row["C_REFNO"]; ?>" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
    <td width="9%">&nbsp;</td>
    <td width="9%"><input type="text"  class="label_purchase1" value="Date" disabled="disabled"/></td>
    <td width="15%"><input type="text"  name="crndate" id="crndate" value="<?php echo $row["C_DATE"]; ?>" disabled="disabled" class="text_purchase2"/></td>
    <td width="14%"><input type="text"  class="label_purchase" value="Department" disabled="disabled"/></td>
    <?php
		$sql2="Select * from c_bal where REFNO='".$_GET['crnno']."'";
		$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 	
		$row2 = mysqli_fetch_array($result2);
                
		$sql5="Select * from s_crnfrm where Credit_note='".$_GET['crnno']."'";
		$result5 =mysqli_query($GLOBALS['dbinv'],$sql5) ; 	
		$row5 = mysqli_fetch_array($result5);
                
                
		
	?>
    <td width="14%"><input type="text"  name="department" id="department" value="<?php echo $row2["DEP"]; ?>" disabled="disabled" class="text_purchase2"/>   </td>
    <td width="4%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled="disabled"/></td>
    <td><input type="text" disabled="disabled" value="<?php echo $row["C_CODE"]; ?>"  class="text_purchase3" name="cus_code" id="cus_code"/></td>
    <?php 
		$sql1="Select * from vendor where CODE='".$row["C_CODE"]."'";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
		$row1 = mysqli_fetch_array($result1);
	
			$sql3="Select * from s_salma where REF_NO='".$row["C_INVNO"]."'";
			$result3 =mysqli_query($GLOBALS['dbinv'],$sql3);	
			$row3 = mysqli_fetch_array($result3);
	
	 ?>	
    <td colspan="3"><input type="text" disabled="disabled" value="<?php echo $row1["NAME"]; ?>"  class="text_purchase2" id="cus_name" name="cus_name" /></td>
    <td><input type="text"  class="label_purchase" value="Invoice No" disabled="disabled"/></td>
    <td><input type="text" name="invno" id="invno" value="<?php echo $row["C_INVNO"]; ?>" disabled="disabled" onkeypress="keyset('orderdate',event);" class="text_purchase3"/>
     </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled="disabled"/></td>
    <td colspan="3"><input type="text"  class="text_purchase3"  disabled="disabled" value="<?php echo $row1["ADD1"]." ".$row1["ADD2"]; ?>" id="cus_address" name="cus_address" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Form No" disabled="disabled"/></td>
    <td ><input type="text" size="15" name="orderno1" id="orderno1" disabled="disabled" value="<?php echo $row5["Refno"]; ?>" onkeypress="keyset('orderdate',event);" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Remarks" disabled/></td>
    <td colspan="3"><textarea name="remarks" id="remarks" cols="45" disabled="disabled" rows="2" class="text_purchase3"><?php echo $row["C_REMARK"]; ?></textarea></td>
    <td>&nbsp;</td>
    
    <td><input type="text"  class="label_purchase" value="Invoice Date" disabled="disabled"/></td>
    <td><input type="text" size="15" name="inv_date" id="inv_date" disabled="disabled" value="<?php  echo $row3["SDATE"]; ?>" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td colspan="4"><input type="text" disabled="disabled" value="<?php echo $row["C_SALEX"]; ?>"  class="text_purchase3" name="salesrep" id="salesrep"/></td>
    <td><input type="text"  class="label_purchase" value="Invoice Amount" disabled="disabled"/></td>
    <td><input type="text" size="15" name="invamount" id="invamount" disabled="disabled" value="<?php echo $row3['GRAND_TOT']; ?>" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Cost Centre" disabled="disabled"/></td>
    <td><select name="costcenter" id="costcenter" onkeypress="keyset('vatgroup_0',event);" disabled="disabled" class="text_purchase3" onchange="assignbrand();">
      <option> --Select-- </option>
      <option value='1'>1</option>
      <option value='2'>2</option>
      <option value='3'>3</option>
      <option value='4'>4</option>
      <option value='5'>5</option>
      <option value='6'>6</option>
      <option value='7'>7</option>
      <option value='8'>8</option>
      <option value='9'>9</option>
      <option value='10'>10</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></td>
    <td><input type="text" size="15" name="amount" id="amount" value="<?php echo $row["C_PAYMENT"]; ?>" disabled="disabled" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Total Paid" disabled="disabled"/></td>
    <td><input type="text" size="15" name="totpay" id="totpay" disabled="disabled" value="<?php  echo $row3['TOTPAY']; ?>" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Invoice Balance" disabled="disabled"/></td>
    <?php 
		$bal=$row3['GRAND_TOT']-$row3['TOTPAY'];
	 ?>
    <td><input type="text" size="15" name="invbal" id="invbal" disabled="disabled" value="<?php  echo $bal; ?>" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td><input type="text" size="15" name="amount"disabled="disabled"  id="amount" value="<?php echo $row["Brand"]; ?>" disabled="disabled" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    
    <td>
        <?php
        if ($row2["flag1"] =="1") {
        ?>
        <input type="checkbox" name="chkcash_disc" checked="checked" id="chkcash_disc" />
        <?php
        }else {
        ?>
         <input type="checkbox" name="chkcash_disc" id="chkcash_disc" />
        <?php
        }
        ?>
       
        
      Cash Discount</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Settled" disabled="disabled"/></td>
    <td><input type="text" size="15" name="settled" disabled="disabled" id="settled" value="" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  </table>

  
  <br/>   
              
            
  
</form>        

</fieldset>    
            
 