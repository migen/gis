
<?php 

echo ($message)? $message:NULL;

?>


<h5>
<?php if($crid): ?>
	<?php echo $classroom['name'].' Roster Batch'; echo (isset($count))? " ($count)":NULL; ?>	
<?php endif; ?>

	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'rosters/classroom/'.$crid; ?>">Roster</a>	
	| <a href="<?php echo URL.'rosters/batchByScid/'.$crid; ?>">BatchByScid</a>	
	<?php if($crid): ?>
		| <a href="<?php echo URL.'profiles/classroom/'.$crid; ?>">Profiling</a>		
	<?php endif; ?>
	| <a href='<?php echo URL."students/sectioner"; ?>'>Sectioner</a>
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href='<?php echo URL."rosters/releaseCridStudents/$crid"; ?>'>ReleaseAll</a>	
	<?php endif; ?>

</h5>

<?php 


// pr($_SESSION['q']);
// pr($classroom);

if(isset($_GET['debug'])){ pr($q); }

?>



<div class="clear" >
<table class='gis-table-bordered table-fx'>
<?php 
	$d['classrooms']=$classrooms;$d['sy']=$sy;$d['axn']='batch';	
	$this->shovel('redirect_classroom',$d); 
?>
	
</table>
</div>

<p class="brown" >*Possible failures: 1) Summcrid > zero (after Qtr1) 2) Inconsistent ID length / Dirty ID </p>


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
	<td><button id="btn-<?php echo $i; ?>" 
		onclick="releaseRoster(<?php echo $i.','.$scid; ?>);" >Release</button></td>		
</tr>
<?php endfor; ?>
</table>


<form method="POST" >	<!-- form add -->

<div class="addrows" style="width:600px;float:left;"  >
<h5> 
	Roster
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
</h5>
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
	<input type="submit" name="add" value="Roster" /> &nbsp; 
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
var sy	 = "<?php echo $sy; ?>";
var home = "<?php echo 'rosters'; ?>";
var crid = "<?php echo $crid; ?>";


$(function(){
	itago('clipboard');
	

})






</script>



<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
<script type="text/javascript" src='<?php echo URL."views/js/rosters.js"; ?>' ></script>

