<table cellpadding="3">
<tr bgcolor="#CCCCCC">
<td><b>User</b></td>
<td><b>Date In</b></td>
<td><b>Time In</b></td>
</tr>
<?php
while( $row = mysqli_fetch_array( $result ) ) {
if($row['userID'] == $_SESSION['loggedUserID']){
?>
<tr bgcolor="#CCCCFF">
<td><?php echo $row['user']; ?></td>
<td><?php echo $row['dateIn']; ?></td>
<td><?php echo $row['timeIn']; ?></td>
</tr>
<?php
}
else {
?>
<tr bgcolor="#CCCCFF">
<td><?php echo $row['user']; ?></td>
<td><?php echo $row['dateIn']; ?></td>
<td><?php echo $row['timeIn']; ?></td>
<td><a href="logoutuser.php?userid=<?php echo $row['userID'] ?>">Remove User</a></td>
</tr>
<?php }
}?>