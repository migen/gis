<h5>
	<?php echo $classroom['name'].' Roster Sync'; echo (isset($count))? " ($count)":NULL; ?>	
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'rosters/classroom/'.$crid; ?>">Roster</a>	
	| <a href="<?php echo URL.'rosters/batch/'.$crid; ?>">Batch</a>	
	| <a href="<?php echo URL.'profiles/classroom/'.$crid; ?>">Profiling</a>	
	| <a href="<?php echo URL.'tools/enye'; ?>">Enye</a>

</h5>

<?php 



?>



<div class="clear" >
<table class='gis-table-bordered table-fx'>
<?php 
	$d['classrooms'] = $classrooms;
	$d['sy']		 = $sy;
	$d['axn']		 = 'sync';
	
	$this->shovel('redirect_classroom',$d); 
?>
	

</table>
</div>

<p></p>

<?php if($crid): ?>

<table id="roster" class="gis-table-bordered table-fx table-altrow"  >
<tr class="" >
	<th class="vc100" >SCID</th>
	<th class="vc200" >ID Number</th>
	<th class="vc250" >Student</th>
	<th>Action</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $scid = $rows[$i]['scid']; ?>
<tr id="tr<?php echo $i; ?>" >
	<td><?php echo str_pad($rows[$i]['scid'], 4, '0', STR_PAD_LEFT); ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td>
		<?php echo $i+1; ?>
		| <a class="u" href="<?php echo URL.'contacts/ucis/'.$scid; ?>"  />Edit</a>		
	</td>
</tr>
<?php endfor; ?>
</table>



<div class="addrows" style="width:600px;float:left;"  >
<h5> 
	Add Students
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
</h5>

<form method="POST" >	<!-- form add -->
<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th class="vc200" >ID Number</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td class="vc20" ><?php echo $i+1; ?></td>
	<td><input id="code<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>]" /></td>		
		
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="sync" value="Sync" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->





<p><?php $this->shovel('numrows'); ?></p>
</div>



<!------------------------------------------------------------------------>

<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="code" >Code</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<div class="clear ht100" >&nbsp;</div>



<?php endif; ?>



<!-------------------------------------------------------------------------------------->

<script>

var gurl = "http://<?php echo GURL; ?>";
var home = "<?php echo 'rosters'; ?>";
var crid = "<?php echo $crid; ?>";
var tmpcrid = "<?php echo $tmpcrid; ?>";
var outcrid = "<?php echo $outcrid; ?>";

$(function(){
	itago('clipboard');
	

})




</script>



<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
