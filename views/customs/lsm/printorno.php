<?php 

	// pr($data);

?>

<style>


</style>




<div style="clear:both;height:70px;" >&nbsp;</div>

<span class="screen" ><a href='?std' >Standard</a></span>

<div class="screen" style="font-size:2em;color:black;right;padding-left:430px;" >
	<?php echo $orno; ?></div>


<div style="position:absolute;margin-left:450px;padding-top:40px;" ><?php echo date('M-d, Y',strtotime($_SESSION['today'])); ?></div>	
	
<p><table style="color:brown;font-size:10px;" >

<span style="font-size:0.8em;color:black;right;padding-left:270px;" >
	<?php echo DBYR.' - '.(DBYR+1); ?></span>

<?php if($is_student): ?>
	<?php 
		$custname = isset($student['name'])? $student['name']:$customer['name'];
		$payee = isset($a[0]['details'])? $a[0]['details']:$custname;
	
	?>
	<tr><th style="width:120px;" >&nbsp;</th><td class="vc300" ><?php echo '<br />'.$custname; ?></td></tr>
	<tr><th> </th><td><input class="full" style="border:none;font-size:10px;" 
		value="<?php echo $payee; ?>"  /></td></tr>
	<tr><th></th><td><?php echo $student['level'].'-'.$student['section']; ?></td></tr>
<?php else: ?>	
	<tr><th>Customer</th><td><?php echo $customer['name']; ?></td></tr>
<?php endif; ?>	
</table>
</p>

<br />
<div style="padding-left:30px;" >	<!-- details -->
<table style="color:blue;" class="table-bordeblack" >
<tr class="bgheadrow" >
<th>Date</th>
<th>Particular</th>
<th>Tender</th>
<th>Amount</th>
<th>Details</th>
</tr>

<?php $total=0; ?>
<?php foreach($rows AS $row): ?>
<?php $total+=$row['amount']; ?>
<tr>
	<td><?php echo $row['date']; ?></td>
	<td><?php echo $row['feetype']; ?></td>
	<td><?php echo $row['paytype']; ?></td>
	<td class="right" ><?php echo $row['amount']; ?></td>
	<td><?php echo $row['details']; ?></td>
</tr>
<?php endforeach; ?>

</table>
</div>	<!-- details -->

<style>
div#total{ 
	position:absolute;margin-top:150px;color:brown;
	margin-left:76px;font-weight:bold;
}



</style>
<div id="total" ><?php echo 'P'.number_format($total,2); ?></div>

<div style="font-size:1em;color:black;right;padding-left:380px;margin-top:170px;" >
	<?php echo $_SESSION['user']['fullname']; ?></div>




<script>
	var gurl = "http://<?php echo GURL; ?>";
	
	$(function(){})


</script>

