<h3>
	Sync Level Tsum SY<?php echo $sy; ?>
	| <a href="<?php echo URL.'tsum/sync'; ?>" >SyncTsum</a>
	
</h3>

<?php 
	pr("&exe");

?>

<?php 
// pr($level);
// pr($rows[0]);

?>

<table class="gis-table-bordered" >
<tr>
	<th><?php echo $level['name']; ?></th>
	<th>Tuition Amount &nbsp; <?php echo 'P'.number_format($level['tuition_amount'],2); ?></th>
	<th>Tuition Total &nbsp; <?php echo 'P'.number_format($level['total'],2); ?></th>
</tr>
</table>
<br />
<br />


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>Tsum<br />Scid</th>
	<th>Code</th>
	<th>Name</th>
	<th>Paymode</th>
	<th>Tfee<br />Paid</th>
	<th>Total<br />Discount</th>
	<th>Upon Enrollment</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['paymode']; ?></td>
	<td><?php echo number_format($rows[$i]['tfee_paid'],2); ?></td>
	<td><?php echo number_format($rows[$i]['total_discount'],2); ?></td>
	<td>
		<?php 
			
			$arp=adjustPayablesSjam($rows[$i]);
			pr($arp);

		
		?>
		
		
	</td>
	
	<td><a href="<?php echo URL.'enrollment/ledger/'.$rows[$i]['scid']; ?>" >Ledger</a></td>
</tr>
<?php endfor; ?>
</table>


<div class="ht100" ></div>