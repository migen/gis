<?php 
// echo $qtr; 

?>

<h5>
	Traits
	| <?php $this->shovel('homelinks','Letters'); ?>
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr><th>#</th><th>Index</th></tr>

<tr><th>Level</th><td>
<select id="lvl" onchange="redir();" >
	<option>Select</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>




</table>

<!------->
<script>

var gurl="http://<?php echo GURL; ?>";
var qtr="<?php echo $qtr; ?>";


$(function(){

})

function redir(){
	var lvl=$('#lvl').val();
	var url=gurl+'/cav/traitsByLevel/'+lvl+'?qtr='+qtr;
	window.location=url;
}


</script>



