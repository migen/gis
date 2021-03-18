
<?php 


// pr($grades[0]);
// pr($rows[0]);
// pr($traits[0]);

// pr($data);

?>

<h5>Edit Trait (<?php echo (isset($_GET['sort']) && $_GET['sort']=='c.position')? 'Position':'Alphabetical'; ?>)
| <a href='<?php echo URL."cav/matrixByCritype/$crid/$critype_id/$sy/$qtr"; ?>' >CavMatrixByCritype</a>	
| <a href='<?php echo URL."cav/traits/$course_id/$sy/$qtr?ctype=$ctype&dept=$dept_id{$sortcond}"; ?>' >Traits</a>
<?php if(isset($_GET['sort'])): ?>	
	| <a href='<?php echo URL."cav/editColumn/$course_id/$criteria_id/$sy/$qtr?ctype=$ctype&dept=$dept_id"; ?>' >Alphabetical</a> 		
<?php else: ?>
	| <a href='<?php echo URL."cav/editColumn/$course_id/$criteria_id/$sy/$qtr?ctype=$ctype&dept=$dept_id&sort=c.position"; ?>' >Position</a> 			
<?php endif; ?>
| <span class="blue u" onclick="traceshd();" >Show</span>
| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>
| <a href='<?php echo URL."cav/editColumnDG/$course_id/$criteria_id/$sy/$qtr?{$sortcond}"; ?>' >DG Only</a>
| Input Max <input class="vc50 center" value="<?php echo $imax; ?>" onchange="reloadMax(this.value);return false;" />


</h5>

<?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
?>
<script>
	
function redirCtype(){
	var url = gurl+"/cav/editColumn/"+crs+ds+cri+ds+sy+ds+qtr+'?ctype='+$('#ctype').val()+'&dept='+$('#dept').val()+getdg;
	window.location = url;		
}	/* fxn */
	
</script>


<!--------------------------------------------------------------------------->

<h4 class="brown" >Click "DG Only" to override lookup table.</h4>
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
	<th class="shd" >GID</th>
	<th class="shd" >SCID</th>
	<th>Student</th>
	<th class="center" >DB|DG</th>
	<th class="center" >Change
		<br /><input class="vc50" type="text" id="igrade" placeholder="All" />
		<br /><button onclick="populateColumn('grade');return false;">All</button>					
	</th>
</tr>

<?php for($i=0;$i<$numrows;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="shd" ><?php echo $traits[$i]['gid']; ?></td>
		<td class="shd" ><?php echo $traits[$i]['scid']; ?></td>
		<td><?php echo $traits[$i]['student']; ?></td>
		<?php $grade = $traits[$i]['grade']; ?>
		
		<td><?php echo $grade.' | '.$traits[$i]['dg']; ?></td>
		<td><input id="grades<?php echo $i; ?>" class="center vc50 grade" name="rows[<?php echo $i; ?>][grade]" 
			onchange="belowMax(this.value);return false;" value="<?php echo $grade; ?>" tabindex="1" />
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
	<option value="grades" >Grades</option>
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
var imax = "<?php echo $imax; ?>";


$(function(){
	hd();
	shd();
	itago('clipboard');
	nextViaEnter();		
	selectFocused();
	
})

function belowMax(val){
	if(parseInt(val)>parseInt(imax)){ alert('Over max value.'); }
	
}	/* fxn */


function reloadMax(val){
	var url=gurl+'/cav/editColumn/'+crs+ds+cri+ds+sy+ds+qtr;
	url+='?ctype='+$('#ctype').val()+'&dept='+$('#dept').val()+getdg+'&imax='+val;
	window.location=url;
}	/* fxn */


</script>


