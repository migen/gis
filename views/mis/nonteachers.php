
<h5>
	Classroom Advisers | 
	<?php 	$this->shovel('homelinks','mis'); ?>
	| <a href="<?php echo URL.'setup/grading/'.$sy; ?>" > Setup </a>
	| <a href="<?php echo URL.'mis/teachers'; ?>" >Teachers</a>
	| <a href="<?php echo URL.'mis/advisers'; ?>" >Advisers</a>	
</h5>

<?php 

// pr($rows[0]);

?>


<table class="gis-table-bordered table-fx table-altrow" >

<tr class="headrow" >
	<th>#</th>
	<th>UCID</th>
	<th>Employee</th>
	<th>Account</th>
	<th>Role Title</th>
	<th>Pass</th>
	<th>Male</th>
	<th>Actv</th>
	<th>Clrd</th>
	<th class="center" >Manage</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>

<tr class="<?php echo($rows[$i]['is_active'])? NULL:'red'; ?>"  >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['ucid']; ?></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
	<td><?php echo $rows[$i]['account']; ?></td>
	<td><?php echo $rows[$i]['title']; ?></td>
	<td><?php echo $rows[$i]['ctp']; ?></td>
	<td><?php echo ($rows[$i]['is_male'])? 'M':'-'; ?></td>
	<td><?php echo ($rows[$i]['is_active'])? 'A':'-'; ?></td>
	<td><?php echo ($rows[$i]['is_cleared'])? 'C':'-'; ?></td>
	<td>
		<button class="vc60" ><a class="no-underline txt-black" href="<?php echo URL.'contacts/ucis/'.$rows[$i]['ucid']; ?>" >Edit</a></button>		
		<button class="vc60" ><a class="no-underline txt-black" href="<?php echo URL.'photos/one/'.$rows[$i]['ucid']; ?>" >Photo</a></button>		
		<button class="vc60" ><a class="no-underline txt-black" href="<?php echo URL.'contacts/statuses/'.$rows[$i]['ucid']; ?>" >Status</a></button>		
	</td>
</tr>

<?php endfor; ?>
</table>




<!------------------------------------------------------------------------>

<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';

$(function(){
	nextViaEnter();

})



</script>