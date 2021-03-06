
<?php 
/*if($_SESSION["login"]!="True")
{
  header('Location:./index.php');
}*/




/*if($_SESSION["login"]!="True")
{
  header('Location:./index.php');
}*/

  

             
  require_once("connectioni.php");
   
?>  

             
  


<script language="JavaScript" src="js/pur_ord.js"></script>
<link rel="stylesheet" href="css/table.css" type="text/css"/> 
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript" language="javascript" src="js/get_cat_description.js"></script>
<script type="text/javascript" language="javascript" src="js/datepickr.js"></script>

<script language="javascript" src="cal2.js">
/*
Xin's Popup calendar script-  Xin Yang (http://www.yxscripts.com/)
Script featured on/available at http://www.dynamicdrive.com/
This notice must stay intact for use
*/
</script>
<script language="javascript" src="cal_conf2.js"></script>
<script language="javascript" type="text/javascript">
<!--
/****************************************************
     Author: Eric King
     Url: http://redrival.com/eak/index.shtml
     This script is free to use as long as this info is left in
     Featured on Dynamic Drive script library (http://www.dynamicdrive.com)
****************************************************/
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
// -->
</script>

<script type="text/javascript">
function openWin()
{
myWindow=window.open('serach_inv.php','','width=200,height=100');
myWindow.focus();

}
</script>

<script type="text/javascript">
  window.onload = function(){
    new JsDatePick({
      useMode:2,
      target:"dte_shedule",
      dateFormat:"%Y-%m-%d"
      /*selectedDate:{        This is an example of what the full configuration offers.
        day:5,            For full documentation about these settings please see the full version of the code.
        month:9,
        year:2006
      },
      yearsRange:[1978,2020],
      limitToToday:false,
      cellColorScheme:"beige",
      dateFormat:"%m-%d-%Y",
      imgPath:"img/",
      weekStartDay:1*/
    });
  };
</script>


 <!-- Dynamic List area -->
    
    <script type="text/javascript" src="ajax-dynamic-list.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="ajax.js"></script>





    
    <style type="text/css">
  /* Big box with list of options */
  #ajax_listOfOptions{
    position:absolute;  /* Never change this one */
    width:175px;  /* Width of box */
    height:250px; /* Height of box */
    overflow:auto;  /* Scrolling features */
    border:1px solid #317082; /* Dark green border */
    background-color:#FFF;  /* White background color */
    text-align:left;
    font-size:0.9em;
    z-index:100;
  }
  #ajax_listOfOptions div{  /* General rule for both .optionDiv and .optionDivSelected */
    margin:1px;   
    padding:1px;
    cursor:pointer;
    font-size:0.9em;
  }
  #ajax_listOfOptions .optionDiv{ /* Div for each item in list */
    
  }
  #ajax_listOfOptions .optionDivSelected{ /* Selected item in the list */
    background-color:#317082;
    color:#FFF;
  }
  #ajax_listOfOptions_iframe{
    background-color:#F00;
    position:absolute;
    z-index:5;
  }
  
  form{
    display:inline;
  }

  #article {font: 12pt Verdana, geneva, arial, sans-serif;  background: white; color: black; padding: 10pt 15pt 0 5pt}
    .style1 {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 12px;
  font-weight: bold;
}
    </style>   

<!-- End of Dynamic list area -->
</label>
          
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
<fieldset>
                                                  <legend>
  <div class="text_forheader">Enter Item Details</div>
                                                 </legend>             

<form name="form1" id="form1">
  <input type="text" name="autho" id="autho" value="" class="text_purchase3"  />            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="9%"><input type="text"  class="label_purchase" value="Stock No (Code)" disabled/></td>
    <td width="15%"><input type="text" name="txtSTK_NO" id="txtSTK_NO" value="" class="text_purchase" onKeyPress="keyset('txtDESCRIPTION', event);" onblur="itemno_ind(); "   />
      <a href="search_stock.php" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchinv2" id="searchinv2" value="..." class="btn_purchase1" >
      </a></td>
    <td width="8%"><input type="text"  class="label_purchase" value="Description" disabled/></td>
    <td colspan="3"><input type="text" name="txtDESCRIPTION" id="txtDESCRIPTION" value="" class="text_purchase3" onkeypress="keyset('txtBRAND_NAME', event);"    /></td>
    <td width="3%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Brand Name" disabled/></td>
    <td><select name="txtBRAND_NAME" id="txtBRAND_NAME" onchange="keyset_chng('txtmodel', event);" onkeypress="keyset('txtmodel',event);" class="text_purchase3" >
      <?php
        if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
            $sql="select * from brand_mas where act ='1' and costcenter='".$_SESSION["CURRENT_DEP"]."' order by barnd_name"; 
        }else{
            $sql="select * from brand_mas where act ='1' order by barnd_name";
        } 
        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
        while($row = mysqli_fetch_array($result)){
         echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
        }
        ?>
    </select> </td>
    <td><input type="text"  class="label_purchase" value="Model" disabled="disabled"/></td>
    <td width="15%"><input id="txtmodel" name="txtmodel" type="text"  class="text_purchase3" onkeypress="keyset('txtPART_NO', event);"/></td>
    <td colspan="2" rowspan="2">
      <fieldset>
          <legend><strong>Reference Numbers (Equal Items)</strong></legend>
<input type="text" class="text_purchase1"  id="txtREFNO1" name="txtREFNO1" onkeypress="keyset('txtREFNO2',event);">
            <input type="text" class="text_purchase1"  id="txtREFNO2" name="txtREFNO2" onkeypress="keyset('txtREFNO3',event);">
            <input type="text" class="text_purchase1"  id="txtREFNO3" name="txtREFNO3" onkeypress="keyset('Com_group1',event);">
        </fieldset>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Part No" disabled="disabled"/></td>
    <td><input id="txtPART_NO" name="txtPART_NO" type="text" onkeypress="keyset('txtGEN_NO',event);" class="text_purchase3" /></td>
    <td><input type="text"  class="label_purchase" value="Genuine No" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3"  id="txtGEN_NO" name="txtGEN_NO" onkeypress="keyset('Com_group1', event);" onKeyUp="ajax_showOptionsfname(this,'getCountriesByLetters',event,'ajax-list-road.php');"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    <td width="35%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="21%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><fieldset>
          <legend><strong>Groups</strong></legend>
<input type="text" class="text_purchase1"  id="Com_group1" name="Com_group1" onkeypress="keyset('Com_group2',event);">
            <input type="text" class="text_purchase1"  id="Com_group2" name="Com_group2" onkeypress="keyset('Com_group3',event);">
            <input type="text" class="text_purchase1"  id="Com_group3" name="Com_group3" onkeypress="keyset('Com_group4',event);">
             <input type="text" class="text_purchase1"  id="Com_group4" name="Com_group4" onkeypress="keyset('cmbcat',event);">
        </fieldset> </td>
    <td colspan="4"><fieldset>
          <legend><strong>Locations (Bins)</strong></legend>
<input type="text" class="text_purchase1"  id="txtLOCATE_1" name="txtLOCATE_1" onkeypress="keyset('txtLOCATE_2',event);">
            <input type="text" class="text_purchase1"  id="txtLOCATE_2" name="txtLOCATE_2" onkeypress="keyset('txtLOCATE_3',event);">
            <input type="text" class="text_purchase1"  id="txtLOCATE_3" name="txtLOCATE_3" onkeypress="keyset('txtLOCATE_4',event);">
             <input type="text" class="text_purchase1"  id="txtLOCATE_4" name="txtLOCATE_4" onkeypress="keyset('txtCOST',event);">
        </fieldset> </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="-1%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="10"><table width="1000" border="0">
      <tr>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Cost" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txtCOST" name="txtCOST" onkeypress="keyset('txtMARGIN',event);"/></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Margine" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txtMARGIN" name="txtMARGIN" onkeypress="keyset('txtSELLING',event);"/></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Weight" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txtweight" name="txtweight" onkeypress="keyset('txtcountry',event);"/></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Country" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txtcountry" name="txtcountry" onkeypress="keyset('txtUNIT',event);"/></th>
      </tr>
      <tr>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Unit" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txtUNIT" name="txtUNIT" onkeypress="keyset('txtSIZE',event);"/></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Size" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txtSIZE" name="txtSIZE" onkeypress="keyset('txtRE_O_LEVEL',event);"/></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Re-Order Level" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txtRE_O_LEVEL" name="txtRE_O_LEVEL" onkeypress="keyset('txtRE_O_qty',event);"/></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Re-Order Qty" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txtRE_O_qty" name="txtRE_O_qty" onkeypress="keyset('txttype',event);"/></th>
        <th scope="col"><input type="text"  class="label_purchase" value="Type" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txttype" name="txttype" onkeypress="keyset('txtpendingord',event);"/></th>
        <th scope="col">&nbsp;</th>
        <th scope="col">&nbsp;</th>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9"><table width="1000" border="0">
      <tr>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Pending Orders" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txtpendingord" name="txtpendingord" onkeypress="keyset('txtdelivered',event);"/></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Delivered" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txtdelivered" name="txtdelivered" onkeypress="keyset('cmbcat',event);"/></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Cat" disabled="disabled"/></th>
        <th scope="col"><select name="cmbcat" id="cmbcat" onkeypress="keyset('cmbtype',event);" onchange="keyset_chng('cmbtype', event);" class="text_purchase3">
          <option value="">--Not Selected--</option>
          <option value="TYRE">TYRE</option>
          <option value="BATTERY">BATTERY</option>
          <option value="TUBE">TUBE</option>
          <option value="ALLOY WHEEL">ALLOY WHEEL</option>
          <option value="MORTOR CYCLE">MORTOR CYCLE</option>
          <option value="NON STOCK">NON STOCK</option>
        </select></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Type" disabled="disabled"/></th>
        <th scope="col"><select name="cmbtype" id="cmbtype" onkeypress="keyset('brand',event);" class="text_purchase3">
          <option value="">--Not Selected--</option>
          <option value="PCR">PCR</option>
          <option value="LTR">LTR</option>
          <option value="OTR">OTR</option>
          <option value="TBR">TBR</option>
          <option value="BIAS TYRES">BIAS TYRES</option>
          <option value="MC">MC</option>
          <option value="SUV">SUV</option>
        </select></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Lock" disabled="disabled"/></th>
        <th scope="col"><input type="checkbox" onclick="lock_itm();" id="check1" name="check1"></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Tmp Lock Opn" disabled="disabled"/></th>
        <th scope="col"><input type="checkbox" onclick="lock_itm();" id="check2" name="check2"></th>
      </tr>
      
    </table></td>
    </tr>
  
  
    <tr>
    
     
    <td colspan='5'>&nbsp;</td>
  </tr>
<?php


  $sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Item Master File' and grp='Master Files' and price_edit=1";
            
  $result =mysqli_query($GLOBALS['dbinv'],$sql) ;   
  if ($row = mysqli_fetch_array($result)){

?>
  <tr>
    
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Selling" disabled="disabled"/></th>
        <th scope="col"><input type="text"  class="text_purchase3"  id="txtSELLING" name="txtSELLING" onkeypress="keyset('TXTSELLING_DISPLAY',event);"/></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Display Setting" disabled="disabled"/></th>
        <th scope="col"><input type="text"  class="text_purchase3"  id="TXTSELLING_DISPLAY" name="TXTSELLING_DISPLAY" onkeypress="keyset('txtweight',event);"/></th>
       
    
  </tr>
  
  <?php
  
  } else {
    
  ?>
  <tr>
    
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Selling" disabled="disabled"/></th>
        <th scope="col"><input type="text" disabled="disabled"  class="text_purchase3"  id="txtSELLING" name="txtSELLING" onkeypress="keyset('TXTSELLING_DISPLAY',event);"/></th>
        <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Display Setting" disabled="disabled"/></th>
        <th scope="col"><input type="text" disabled="disabled"    class="text_purchase3"  id="TXTSELLING_DISPLAY" name="TXTSELLING_DISPLAY" onkeypress="keyset('txtweight',event);"/></th>
     <th width="10%" scope="col"><input type="text"  class="label_purchase" value="Discount Item" disabled="disabled"/></th>
       <th scope="col"><select name="disitem" id="disitem" onkeypress="keyset('brand',event);" class="text_purchase3">
          <option value=""></option>
          <option value="250pertyre">250 Per Tyre</option>
          <option value="250pertyreold">250 Per Tyre Old</option>
          
        </select></th>
  </tr>
  <?php
  }
  
  ?>
  </table>

  
 
  <fieldset>               
            
 
</form>        
<script>
   
   function print_inv() {
  
  var url = "new/price_list.php";
    url = url + "?brand=" + document.getElementById('txtBRAND_NAME').value;
  
    window.open(url,'_blank');
  
}
   
   </script>
   
            
          