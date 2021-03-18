<form id='loginform' action="<?php echo URL; ?>grades/login" method="post">

<h5>Student Login


</h5>

<?php 
// pr($data); 
?>

<table id='login' class="table-fx gis-table-bordered" >
<!-- sql injection -->
<tr><td class='headrow'><label>Student ID</label></td><td><input accesskey='l' type='text' name='data[Grade][id]' maxlength='20'  AutoFocus placeholder='Records ID' /></td></tr>
<tr><td class='headrow'><label>Student Code</label></td><td><input type='text' name='data[Grade][code]' maxlength='20' placeholder='Student ID'/></td></tr>
<tr><td colspan='2'><input type='submit' name='submit' value='Login'></td></tr>
</table>
</form>