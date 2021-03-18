<?php 
// pr($row);
?>

<form method="POST" >

<h5>
	<span class="u" ondblclick="tracehd();" >Edit</span> Advanced Payment 
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				

</h5>

<!--- tracelogin --->
<p><?php $this->shovel('hdpdiv'); ?></p>




<table class="gis-table-bordered table-fx" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Student</th><td><?php echo $row['student']; ?></td></tr>
<tr><th>Fee</th><td><?php echo ($row['pointer']==0)?'Reservation':'Tuition'; ?></td></tr>
<tr><th>Date</th><td><input name="date" value="<?php echo $row['date']; ?>" class="vc150"  /></td></tr>
<tr><th>OR No</th><td><input name="orno" value="<?php echo $row['orno']; ?>" class="vc150"  /></td></tr>
<tr><th>Amount</th><td><input name="amount" value="<?php echo $row['amount']; ?>" class="vc150"  /></td></tr>

<tr><th>Pay Type</th><td>
<select class="vc120" name="paytype_id" >
	<option value="0" >Choose</option>
	<?php foreach($paytypes AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['paytype_id'])? 'selected':NULL; ?> >
		<?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Bank</th><td>
<select class="vc120" name="bank_id" >
	<option value="0" >Choose</option>
	<?php foreach($banks AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['bank_id'])? 'selected':NULL; ?> >
		<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Reference</th><td><input name="reference" value="<?php echo $row['reference']; ?>" class="vc150"  /></td></tr>
<tr class="" ><th>Pointer</th><td><input name="pointer" value="<?php echo $row['pointer']; ?>" class="vc100"  />
<br />* 0 - Rfee | 1 - Tuition</td></tr>

<tr class="hd" ><th>ECID</th><td><input name="ecid" value="<?php echo $row['ecid']; ?>" class="vc100"  />
<?php echo $_SESSION['ucid']; ?></td></tr>

<tr><td colspan="2" ><input type="submit" name="submit" value="Save"  />

<button class="hd" ><a href='<?php echo URL."advances/delete/$pid"; ?>' >Delete</a></button>

</td></tr>

</table>

</form>



<script>
var gurl = 'http://<?php echo GURL; ?>';
var hdpass 	= '<?php echo HDPASS; ?>';


$(function(){
	hd();
	$('#hdpdiv').hide();

})




</script>

