<h5>
Advance Pay

</h5>

<?php if($scid): ?>
<table class="gis-table-bordered table-fx" >
<tr><th>#</th><th>Date</th><th>Amount</th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['amount']; ?></td>
</tr>
<?php endfor; ?>
</table>

<p>&nbsp;</p>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Date</th><td><input name="date" value="<?php echo $today; ?>" ></td></tr>
<tr><th>OR No</th><td><input name="orno" value="<?php echo ($last_orno+1); ?>" ></td></tr>
<tr><th>Amount</th><td><input name="amount" value="0" ></td></tr>
<tr><td colspan="2" ><input type="submit" name="submit" onclick="return confirm('Sure?');" ></td></tr>
</table>
</form>

<?php endif; ?>	<!-- scid -->

