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
	<span ondblclick="tracepass();" class="u" >Fees</span>
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="#addDiv" >Add</a>
	| &id or &pos	
	
</h5>

<p><?php $this->shovel('hdpdiv'); ?></p>

<?php 

$headrow="<tr class='headrow'>
<th>#</th>
<th>ID</th>
<th class='vc100'>Parent</th>
<th class='vc200' >Fee</th>
<th class='vc30' >Is<br>Disc</th>
<th class='vc80' >Amount</th>
<th class='vc80'>Pct</th>
<th class='vc30'>Pos</th>
</tr>";

?>



<h4 class="brown" >
	*Warning! Fixed. Do Not Edit - ID#1 - Tuition Fee | #2 - Reservation | #3 - Previous Balance | #4 - Surchage 
</h4>

<table class='table-fx gis-table-bordered table-altrow'>


<?php for($i=0;$i<$num_feetypes;$i++): ?>
<?php 
	if($i%12==0){ echo $headrow; }

?>

	<tr>
		<td class="vc30" ><?php echo $i+1; ?></td>
		<td class="vc50" ><?php echo $feetypes[$i]['feetype_id']; ?></td>
		<td><?php echo $feetypes[$i]['parent']; ?></td>
		<td><?php echo $feetypes[$i]['name']; ?></td>
		<td><?php echo $feetypes[$i]['is_discount']; ?></td>
		<td class="right" ><?php echo number_format($feetypes[$i]['amount'],2); ?></td>
		<td><?php echo $feetypes[$i]['percent']; ?></td>
		<td><?php echo $feetypes[$i]['position']; ?></td>
	</tr>	
<?php endfor; ?>

</table>
<br />


<!------------------------------------------------------------------------->

<div class="" id="addDiv" >	<!-- add -->
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
	<td><input tabIndex=2 class="full pdl05" type="text" name="feetypes[<?php echo $i; ?>][name]" /></td>
	<td><input class="full pdl05" type="number" min="0" max="1" value="0" name="feetypes[<?php echo $i; ?>][is_discount]" /></td>
	<td><input class="full pdl05" type="text" value="0" name="feetypes[<?php echo $i; ?>][amount]" /></td>		
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

<div class="clear ht100"></div>

<!------------------------------------------------------------------------->



