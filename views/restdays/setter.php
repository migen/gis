<h5>
	Restdays Setter
	| <?php $this->shovel('homelinks','HR'); ?>
	
	
</h5>

<?php 
	$page_msg="Check the rightmost box to update the row for safety precaution.";
?>

<h4>*<?php echo $page_msg; ?></h4>

<?php 	
	$days=array(0=>'Sun',1=>'Mon',2=>'Tue',3=>'Wed',4=>'Thu',5=>'Fri',6=>'Sat');
	
	
?>





<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>PCID</th>
	<th>Employee</th>
	<th colspan=7 >Restdays</th>
	<th><input type="checkbox" id="chkAlla" /></th>
</tr>

<?php $i=0; ?>
<?php foreach($rows AS $row): ?>
<tr id="row-<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['name']; ?>
	<input type="hidden" name="post[<?php echo $i; ?>][pcid]" value="<?php echo $row['id']; ?>" />
	</td>
		
	<?php foreach($days AS $k=>$v): ?>
		<td>
			<?php echo $v;  ?><br />
			<input type="checkbox" value="<?php echo $k; ?>" 
				name="post[<?php echo $i; ?>][restdays][<?php echo $k; ?>]" 
				<?php echo in_array($k,$row['restdays'])? 'checked':NULL; ?>  />
		</td>
	<?php endforeach; ?>		
	<td><br /><input class="chka" type="checkbox" value="1" name="post[<?php echo $i; ?>][check]"  /></td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>

<tr><td colspan=11 ><input type="submit" name="submit" value="Save"  /></td></tr>

</table>
</form>

<h4>*<?php echo $page_msg; ?></h4>


<script>


$(function(){
	chkAllvar('a');	

	
})


function xsaveRestdays(i){
	$('#btn-'+i).hide();
	pcid=$('#pcid-'+i).val();
	msg="row-"+i;
	msg+=", pcid-"+pcid;
	$.each($('.row-'+i),function(){
		console.log(this);
	})
	
	
	
	
}	/* fxn */

</script>

