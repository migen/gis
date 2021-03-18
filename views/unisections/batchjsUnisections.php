<?php 




if(!isset($db)){ pr("DB Not Set."); }
if(isset($_POST['submit'])){
	$posts=$_POST['posts'];$dbg=PDBG;
	foreach($posts AS $post){ $db->add("{$dbg}.01_sections",$post); }
	$msg="<h5>College section/s added.</h5>";
	flashRedirect('unisections',$msg);	
}	/* post */

?>


<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Code</th>
	<th>Name</th>
</tr>
<?php $numrows=isset($_POST['numrows'])? $_POST['numrows']:1; ?>
<?php for($i=0;$i<$numrows;$i++):  ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><input name="posts[<?php echo $i; ?>][code]" id="code-<?php echo $i; ?>" class="vc100" ></td>
	<td><input name="posts[<?php echo $i; ?>][name]" id="name-<?php echo $i; ?>" class="vc200" ></td>
</tr>
<?php endfor; ?>
</table>
<br /><input type="submit" name="submit" value="Add" />
</form>

<br />
<?php $this->shovel('numrows'); ?>