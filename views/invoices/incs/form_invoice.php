<h4>
	Fees Lookup 
	<select class="vc200" >
		<?php foreach($feetypes AS $sel): ?>
			<option><?php echo '#'.$sel['id'].' - '.$sel['name'].' - P'.$sel['amount']; ?></option>
		<?php endforeach; ?>		
	</select>
	
	
</h4>

<p class="brown" >*If not a school person, SCID should be 0 and Guest column can have the guest name.</p>

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >

<tr class="headrow" >
	<th>Date (YMD) <br />
		<input class="pdl05 vc50" id="idate" value="" /><br />	
		<input type="button" value="All" onclick="populateColumn('date');" >									
	</th>
	<th>SCID<br />
		<input class="pdl05 vc50" id="iscid" value="" /><br />	
		<input type="button" value="All" onclick="populateColumn('scid');" >								
	</th>
	<th>Guest<br />
		<input class="pdl05 vc50" id="iguest" value="" /><br />	
		<input type="button" value="All" onclick="populateColumn('guest');" >								
	</th>
	<th>Fee<br />
		<input class="pdl05 vc50" id="ifee" value="" /><br />	
		<input type="button" value="All" onclick="populateColumn('fee');" >							
	</th>
	<th>Tender<br />
		<input class="pdl05 vc50" id="ipay" value="" /><br />	
		<input type="button" value="All" onclick="populateColumn('pay');" >								
	</th>
	<th>Amount<br />
		<input class="pdl05 vc50" id="iamt" value="" /><br />	
		<input type="button" value="All" onclick="populateColumn('amt');" >									
	</th>
	<th>Paid<br />
		<input class="pdl05 vc50" id="ipaid" value="" /><br />	
		<input type="button" value="All" onclick="populateColumn('paid');" >									
	</th>
	<th>OR No.</th>
	<th>Details</th>	
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<?php $orno+=1; ?>
<tr>
	<td><input id="date<?php echo $i; ?>" class="pdl05 date" name="posts[<?php echo $i; ?>][date]" 
		value="<?php echo $_SESSION['today']; ?>"  /></td>
	<td><input class="vc50 pdl05 scid" id="scid<?php echo $i; ?>" name="posts[<?php echo $i; ?>][scid]" value="0"  /></td>
	<td><input class="vc100 pdl05 guest" id="part<?php echo $i; ?>" name="posts[<?php echo $i; ?>][guest]" /></td>
	<td><input class="vc30 fee" id="fee<?php echo $i; ?>" name="posts[<?php echo $i; ?>][feetype_id]" value="<?php  ?>"  /></td>
	<td>
		<select class="pay" id="tender<?php echo $i; ?>" name="posts[<?php echo $i; ?>][paytype_id]"  >
			<?php foreach($paytypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	<td><input class="vc60 pdr05 right amt" id="amount<?php echo $i; ?>" name="posts[<?php echo $i; ?>][amount]" value="0"  /></td>
	<td><input class="vc60 pdr05 right paid" id="paid<?php echo $i; ?>" name="posts[<?php echo $i; ?>][paid]" value="0"  /></td>

	<td><input class="vc80 pdr05 right" id="orno<?php echo $i; ?>" name="posts[<?php echo $i; ?>][orno]" value="<?php echo $orno; ?>"  /></td>
	<td><input class="vc100 pdr05 right" id="details<?php echo $i; ?>" name="posts[<?php echo $i; ?>][details]"  /></td>
</tr>
<?php endfor; ?>			


</table>

<p>
	<input onclick="return confirm('Sure?');" type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form>
