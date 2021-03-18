<?php 
	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbclassrooms="{$dbg}.05_classrooms";
	

?>
<h3>
	Conduct Tally Index | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."tests/ledger"; ?>' >Ledger</a>


</h3>


<table class="gis-table-bordered" >
<tr>
	<th>Classroom</th>
	<td>
		<select onchange="axnFilter(this.value)" >
			<option value=0>Select One</option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	
</tr>


</table>



<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbclassrooms = "<?php echo $dbclassrooms; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	var url=gurl+"/cdt/tally/"+id+"/"+sy;
	window.location=url;
}









</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

