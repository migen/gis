<h5>
	Manage Course and Advisory - Locking | <?php $this->shovel('homelinks'); ?>
	
	
</h5>


<?php 


?>


<table class="mca accordion gis-table-bordered table-altrow" >
	<tr class="headrow" >
		<th style="widtd:250px;" class="accorHeadrow" onclick="accordionTable('mca');" >MCA</th>
		<th>Locking</th>
	</tr>

<?php foreach($levels AS $sel): ?>
	<tr>
		<td><a href="<?php echo URL.'mca/locking/'.$sel['id']; ?>" ><?php echo $sel['name']; ?></a></td>
		<td><a href="<?php echo URL.'conducts/locking/'.$sel['id']; ?>" >Conducts</a></td>
	
	</tr>
<?php endforeach; ?>



<tr><td>&nbsp;</td></tr>

</table>
