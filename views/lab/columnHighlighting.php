<h3>
	Column Highlighting
	| <?php $this->shovel('homelinks'); ?>

</h3>

<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Code</th>
	<th>Name</th>
	<th>Account</th>
	<th>Male</th>
</tr>
<?php foreach($rows AS $i=>$row):  ?>
<tr class="colshading" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['code']; ?></td>
	<td><?php echo $row['name']; ?></td>
	<td><?php echo $row['account']; ?></td>
	<td><?php echo $row['is_male']; ?></td>
</tr>
<?php endforeach; ?>
</table>



<script>

$(function(){
	// columnHighlightingLocal();

	
})


function columnHighlightingLocal(){    
	var t;
    $('.colshading').hover(
		alert(1);
		function() { t = parseInt($(this).index())+1;	$('td:nth-child(' + t + ')').addClass('bg-red'); },
		function() { $('td:nth-child(' + t + ')').removeClass('colshadingbg'); }
	);	
}	/* fxn */


</script>