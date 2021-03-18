<script>

var gurl = 'http://<?php echo GURL; ?>';	
var hdpass 	= "<?php echo MD5('angel'); ?>";


$(function(){	
	$('#hdpdiv').hide();
	hd();
	shd();

	
});



</script>


<h5>
	<span ondblclick="tracepass();" class="u" >Feetypes</span>
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <span class="u" onclick="traceshd();" >Add</span>
	

</h5>

<!------ tracelogin -------------------------------->
	<p><?php $this->shovel('hdpdiv'); ?></p>



<h4 class="brown" >
	*Warning! Do Not Edit - 1) Tuition Fee, 2) Old Balance, 3) Surcharge. 4) Overpayment Refund (Fixed, the rest OK to edit.) 
</h4>

<table class='table-fx gis-table-bordered'>
<tr class='headrow'><th>ID</th>
	<th class="vc100" >Parent</th>
	<th class="vc200" >Fee</th>
	<th class="vc30" >Is Disc.</th>
	<th class="vc80" >Amount</th>
	<th class="vc80" >Pct%</th>
	<th class="vc30" >Pos</th>
<th class="vc50" >Edit</th>

</tr>
<?php for($i=0;$i<$num_feetypes;$i++): ?>
	<tr>
		<td class="vc50" ><?php echo $feetypes[$i]['feetype_id']; ?></td>
		<td><?php echo $feetypes[$i]['parent']; ?></td>
		<td><?php echo $feetypes[$i]['name']; ?></td>
		<td><?php echo $feetypes[$i]['is_discount']; ?></td>
		<td class="right" ><?php echo number_format($feetypes[$i]['amount'],2); ?></td>
		<td><?php echo $feetypes[$i]['percentage']; ?></td>
		<td><?php echo $feetypes[$i]['position']; ?></td>
		<td>
			<a href='<?php echo URL."tfees/edittype/".$feetypes[$i]['feetype_id']; ?>' >Edit</a>
			<span class="hd" > | <a href='<?php echo URL."fees/deleteXXX/".$feetypes[$i]['feetype_id']; ?>' 
				onclick="return confirm('Sure?');" >Del</a></span>
		</td>		
	</tr>	
<?php endfor; ?>

</table>
<br />


<!------------------------------------------------------------------------->

<div class="shd" >	<!-- add -->
<hr />
<br />

<form method="POST" >	<!-- form add subjects -->
<!------------------------------------------------------------------>
<h5> Add Tuition Types </h5>

<table class="gis-table-bordered" >
<tr class='headrow'>
	<th class="vc20" >#</th>	
	<th class="vc100" >Parent</th>
	<th class="vc200" >Fee</th>
	<th class="vc30" >Is Disc.</th>
	<th class="vc80" >Amount</th>
	<th class="vc60" >Pct%</th>
	<th class="vc30" >Pos</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td>
		<select class="full pdl05" name="feetypes[<?php echo $i; ?>][parent_id]"  >
			<option value="0" >Select</option>
			<?php	foreach($feetypes as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>
	<td><input class="full pdl05" type="text" name="feetypes[<?php echo $i; ?>][name]" /></td>
	<td><input class="full pdl05" type="number" min="0" max="1" value="0" name="feetypes[<?php echo $i; ?>][is_discount]" /></td>
	<td><input class="full pdl05" type="text" value="0" name="feetypes[<?php echo $i; ?>][amount]" /></td>		
	<td><input class="full pdl05" type="text" value="0" name="feetypes[<?php echo $i; ?>][percentage]" /></td>		
	<td><input class="full pdl05" type="number" value="10" name="feetypes[<?php echo $i; ?>][position]" /></td>
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->

<p><?php $this->shovel('numrows'); ?></p>

</div> <!-- add -->


<!------------------------------------------------------------------------->



