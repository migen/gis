<?php 

// prx($data);
if(isset($dbtable)){
	$dbtable=$data['dbtable'];
	$id=$data['id'];
	
} else {
	$id=false;
}
// pr($dbtable);

?>

	| <a href='<?php echo URL."records/dbtables"; ?>' >Records</a>
	| <a href='<?php echo URL."records/find/$dbtable"; ?>' >Find</a>
	| <a href='<?php echo URL."records/set/$dbtable?all"; ?>' >All</a>
	| <a href='<?php echo URL."records/set/$dbtable?full"; ?>' >Full</a>
	| <a href='<?php echo URL."records/add/$dbtable"; ?>' >Add</a>
	| <a href='<?php echo URL."records/setup/$dbtable"; ?>' >Setup</a>
	| <a href='<?php echo URL."records/custom"; ?>' >Custom</a>
	| <a href='<?php echo URL."records/complex"; ?>' >Complex</a>
	| <a href='<?php echo URL."sessions/unsetter/schemas"; ?>' >Reset</a>
	| <a href='<?php echo URL."records/truncate/$dbtable"; ?>' >Truncate</a>
	| <a href='<?php echo URL."records/query"; ?>' >Query</a>
	| <a href='<?php echo URL."sessions"; ?>' >Sessions</a>
	| <a class="u" id="btnExport" >Excel</a> 
	
<?php if($id): ?>	
		| <a href='<?php echo URL."records/view/$dbtable/$id"; ?>' >View</a>
		| <a href='<?php echo URL."records/edit/$dbtable/$id"; ?>' >Edit</a>
<?php endif; ?>
	| <a href='<?php echo URL."records/set/$dbtable"; ?>' >Set</a>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();

})

</script>
