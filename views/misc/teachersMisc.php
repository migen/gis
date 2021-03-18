

<?php 
// pr($rows[21]);

?>



<h5>
	<span class="u" ondblclick="tracehd();" >Teachers</span> | 
	<?php 	$this->shovel('homelinks','mis'); ?>
	| <a href="<?php echo URL.'setup/grading/'.$sy; ?>" >Setup</a>
	| <a href="<?php echo URL.'misc/advisers'; ?>" >Advisers</a>
	| <a href="<?php echo URL.'nonteachers'; ?>" >Nonteachers</a>	
	| <a href="<?php echo URL.'mis/editTeachers'; ?>" >Edit</a>
	| <a class="u" id="btnExport" >Excel</a> 	
	
</h5>

<?php 


?>

<!------------------------------------------------------------------------------------->

<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >

<tr class="headrow" >
	<th>U-P</th>
	<th class="hd" >CRID</th>
	<th>Classroom</th>
	<th>Lvl</th>
	<th>Sxn</th>
	<th>Adviser</th>
	<th>Account</th>
	<th class="hd" >Pass</th>
	<th>Male</th>
	<th>Actv</th>
	<th>Clrd</th>
<?php if(isset($_GET['signatures'])): ?>	
	<th class="vc100" >Signatures</th>
<?php else: ?>	
	<th class="center" >Manage</th>
<?php endif; ?>	
</tr>

<?php for($i=0;$i<$count;$i++): ?>

<tr class="<?php echo($rows[$i]['is_active'])? NULL:'red'; ?>"  >
	<td><?php echo ($rows[$i]['ucid']==$rows[$i]['pcid'])? $rows[$i]['ucid']:$rows[$i]['ucid'].'-'.$rows[$i]['pcid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['crid']; ?></td>
	<td class="vc200" ><?php echo $rows[$i]['classroom']; ?></td>
	<td ><?php echo $rows[$i]['level_id']; ?></td>
	<td><?php echo $rows[$i]['section_id']; ?></td>
	<td class="vc200" ><?php echo $rows[$i]['adviser']; ?></td>
	<td class="vc200" ><?php echo '#'.$rows[$i]['ucid'].'-'.$rows[$i]['account'].'-'.$rows[$i]['ctp']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['ctp']; ?></td>
	<td><?php echo ($rows[$i]['is_male'])? 'M':'-'; ?></td>
	<td><?php echo ($rows[$i]['is_active'])? 'A':'-'; ?></td>
	<td><?php echo ($rows[$i]['is_cleared'])? 'C':'-'; ?></td>
<?php if(isset($_GET['signatures'])): ?>	
	<td></td>
<?php else: ?>
	<td>	
<a class="" href='<?php echo URL."loads/teacher/".$rows[$i]['ucid'].DS.$sy; ?>' >Loads</a>
| <a class="" href="<?php echo URL.'contacts/ucis/'.$rows[$i]['ucid']; ?>" >Edit</a>
| <a class="" href="<?php echo URL.'mgt/users/'.$rows[$i]['ucid']; ?>" >User</a>
| <a class="" href="<?php echo URL.'codename/one/'.$rows[$i]['ucid']; ?>" >Code</a>
| <a class="" href="<?php echo URL.'mgt/pass/'.$rows[$i]['ucid']; ?>" >Pass</a>

	</td>
<?php endif; ?>	
	
</tr>

<?php endfor; ?>
</table>




<!------------------------------------------------------------------------>

<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';

$(function(){
	hd();
	excel();
	nextViaEnter();

})



</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

