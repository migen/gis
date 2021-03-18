<h3>
	Esc | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."enrollment/ledger/$scid/$sy"; ?>' >Ledger</a>

</h3>


<?php 

// pr($row);


?>


<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID No.</th><td><?php echo $row['studcode']; ?></td></tr>
<tr><th>Student</th><td class="vc200" ><?php echo $row['studname']; ?></td></tr>
<tr><th>Level</th><td class="vc200" ><?php echo $row['level']; ?></td></tr>
<tr><th>Esc</th><td><?php echo $row['escname']; 
	echo ($row['esc_id']>0)?  ': P'.$row['amount']:'None'; ?></td></tr>
<tr><th>Change</th><td>
	<input type="hidden" name="summ[id]" value="<?php echo $row['pkid']; ?>" >
	<select name="summ[esc_id]"   >
		<option value=0 >None</option>
		<?php foreach($esc AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($row['esc_id']==$sel['id'])? 'selected':NULL; ?> >
				<?php echo $sel['name'].': P'.number_format($sel['amount'],2); ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>
<tr><th colspan=2><input type="submit" name="submit" value="Save" ></th></tr>

</table>
</form>
