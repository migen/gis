
<?php 


// pr($grades[0]);
// pr($rows[0]);
// pr($traits[0]);

// pr($criteria);
$critype_id=$criteria['critype_id'];
$traits_value_dg=$_SESSION['settings']['traits_value_dg'];

?>

<h5>Edit Trait (<?php echo (isset($_GET['sort']) && $_GET['sort']=='c.position')? 'Position':'Alphabetical'; ?>)
| <a href='<?php echo URL."cav/dg/$course_id/$sy/$qtr?{$sortcond}"; ?>' >Traits DG</a>
<?php if(isset($_GET['sort'])): ?>	
	| <a href='<?php echo URL."cav/editColumnDG/$course_id/$criteria_id/$sy/$qtr"; ?>' >Alphabetical</a> 		
<?php else: ?>
	| <a href='<?php echo URL."cav/editColumnDG/$course_id/$criteria_id/$sy/$qtr?sort=c.position"; ?>' >Position</a> 			
<?php endif; ?>

| <span class="u" onclick="randomizeLetter('dg');" >Randomize DG</span>
| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>
| <a href='<?php echo URL."cav/editColumn/$course_id/$criteria_id/$sy/$qtr?{$sortcond}"; ?>' >Numeric</a>

| <a href='<?php echo URL."cav/matrix/$crid/$sy/$qtr?value={$traits_value_dg}"; ?>' >CavMatrix</a>
| <a href='<?php echo URL."cav/matrixByCritype/$crid/$critype_id/$sy/$qtr?value={$traits_value_dg}"; ?>' >ByCritype</a>



</h5>



<!--------------------------------------------------------------------------->

<p>
<table class="gis-table-bordered" >
<tr><th>Classroom</th><td><?php echo $course['level'].' - '.$course['section']; ?></td>
<tr><th>Criteria</th><td><?php echo $criteria['id'].' - '.$criteria['name']; ?></td>
</tr>
<?php if($admin): ?>
	<tr><th>Adviser</th><td><?php echo $course['teacher']; ?></td>
<?php endif; ?>
</table>
</p>


<div class="half" >

<form method="POST" >

<p>
<table class="gis-table-bordered" >
<tr class="headrow" >
	<th>#</th>
	<th>GID</th>
	<th>Student</th>
	<th class="center" >DG
		<br /><input class="vc50 center" id="idg" />
		<br /><button onclick="populateColumn('dg');return false;" >All</button>
	</th>
</tr>

<?php for($i=0;$i<$numrows;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $traits[$i]['gid']; ?></td>
		<td><?php echo $traits[$i]['student']; ?></td>
		<?php $grade = $traits[$i]['grade']; ?>
		
		<td>
			<?php $dg = $traits[$i]['dg']; ?>
			<input id="dg<?php echo $i; ?>" class="vc50 dg center" name="rows[<?php echo $i; ?>][dg]" value="<?php echo $dg; ?>" 
				tabindex="2" />
			<input type="hidden" name="rows[<?php echo $i; ?>][gid]" 
				value="<?php echo $traits[$i]['gid']; ?>" />						
			</td>
	</tr>
<?php endfor; ?>
</table>
</p>


<p>
	<input onclick="return confirm('Sure?');" type="submit" name="submit" value="Save"  />	
	<button><a class="no-underline txt-black" 
		href='<?php echo URL."cav/traits/$course_id/$sy/$qtr"; ?>' >Cancel</a></button>	
</p>

</form>

</div>


<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="dg" >DG</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>


<!---------------------------------------------------------------------------------------------->


<script>

var gurl = "http://<?php echo GURL; ?>";
var crs 	= "<?php echo $course_id; ?>";
var cri 	= "<?php echo $criteria_id; ?>";
var sy	 	= "<?php echo $sy; ?>";
var qtr 	= "<?php echo $qtr; ?>";
var ds 		= "/";
var getdg = "<?php echo ($dgonly)? '&dgonly':NULL; ?>";
var count=<?php echo $numrows; ?>;


$(function(){
	hd();
	itago('clipboard');
	nextViaEnter();		
	selectFocused();
	
})

function randomizeLetter(aim){ 
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";var len=possible.length;
	for(var i=0;i<count;i++){ var x=possible.charAt(Math.floor(Math.random()*len));document.getElementById(aim+i).value=x; }	
}	





</script>


