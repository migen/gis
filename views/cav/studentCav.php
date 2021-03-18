<?php 

	$deciconducts = $_SESSION['settings']['deciconducts'];
	$decicard = $_SESSION['settings']['decicard'];
	$decifconducts  = $_SESSION['settings']['decifconducts'];
	$dgonly=isset($_GET['dgonly'])? '?dgonly':NULL;
	
	$get=sages($_GET);
	$get=str_replace("reset","",$get);
	
	// pr($data);
	// pr($grades[0]);
	
?>

<script>

var rcardgdeci  = '<?php echo $decicard; ?>';
var fcgdeci 	= '<?php echo $decifconducts; ?>';		
var deciconducts 	= "<?php echo $deciconducts; ?>";		
	
var gurl = "http://<?php echo GURL; ?>";
var crs 	= "<?php echo $course_id; ?>";
var scid 	= "<?php echo $scid; ?>";
var sy	 	= "<?php echo $sy; ?>";
var qtr 	= "<?php echo $qtr; ?>";
var ds 		= "/";
var getdg = "<?php echo ($dgonly)? '&dgonly':NULL; ?>";	
var get = "<?php echo $get; ?>";	


$(function(){
	hd();
	nextViaEnter();
	selectFocused();
	tallyAve();
	
})


function tallyAve(){
	var numtp = '<?php echo $num_grades; ?>';
	
	var tpgtotal = 0;
	var tpgave   = 0;
	
	$('.tpg').each(function(){		
		tpgtotal += parseFloat($(this).val());			
	})
	
	tpgave = tpgtotal / numtp;	
	$('#tpgave').val(tpgave.toFixed(deciconducts));

}	/* fxn */
	
	
</script>




<h5>
	Edit Student <span onclick="tracehd();" class="u" >Traits</span> |
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a class="" href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>' >Matrix</a>
	| <a href='<?php echo URL."utils/syncStudentTraits/$course_id/$scid/$sy/$qtr"; ?>' >Sync</a>

	<?php if($_SESSION['srid']==RTEAC): ?>
		| <a href='<?php echo URL."cav/traits/$course_id/$sy/$qtr$dgonly"; ?>' >Traits</a>
	<?php else: ?>
		| <a href='<?php echo URL."cav/traits/$course_id/$sy/$qtr$dgonly"; ?>' >Traits</a>	
		| <a href='<?php echo URL."cav/dg/$course_id/$sy/$qtr"; ?>' >DG Class</a>	
		| <a href='<?php echo URL."cav/dgStudent/$course_id/$scid/$sy/$qtr"; ?>' >DG Student</a>	
	<?php endif; ?>

<?php $sqtr=$_SESSION['qtr']; ?>	
<?php if($qtr!=5): ?>	
	| <a href='<?php echo URL."cav/student/$course_id/$scid/$sy/5{$get}"; ?>' >Final</a>
<?php else: ?>
	| <a href='<?php echo URL."cav/student/$course_id/$scid/$sy/$sqtr{$get}"; ?>' >Qtr</a>
<?php endif; ?>
	
</h5>

<?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
?>

<script>
	
function redirCtype(){
	var url = gurl+"/cav/student/"+crs+ds+scid+ds+sy+ds+qtr+'?reset&ctype='+$('#ctype').val()+'&dept='+$('#dept').val()+getdg;
	window.location = url;		
}	/* fxn */
	
</script>


<!---------------------------------------------------------------->
<div class="left half ht1000" >

<h4>Details</h4>
<table class='gis-table-bordered table-fx'>

<tr class="hd" ><th class='bg-blue2'>CrsId</th><td><?php echo $course['id']; ?></td></tr>
<tr class="hd" ><th class='bg-blue2'>Scid</th><td><?php echo $student['scid']; ?></td></tr>
<tr><th class='bg-blue2'>Course</th><td><?php echo $course['name']; ?></td></tr>
<tr><th class='bg-blue2'>ID</th><td><?php echo $student['student_code']; ?></td></tr>
<tr><th class='bg-blue2'>Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th class='bg-blue2'>Status</th><td><?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>

</table>
<br />
<!---------------------------------------------------------------->


<form method="POST" >
<table class="gis-table-bordered table-fx" >

<tr class="headrow" >
	<th class="hd" >GID</th>
	<th class="hd" >Cri</th>
	<th>#</th>
	<th>TP</th>
	<th>Wt</th>
	<th>Num
		<br /><input class="vc50 center" id="igrade" />
		<br /><button onclick="populateColumn('grade');return false;" >All</button>
	</th>
	<th>DG</th>
</tr>

<?php for($i=0;$i<$num_grades;$i++): ?>
<tr>
	<td class="hd" ><?php echo $grades[$i]['gid']; ?></td>
	<td class="hd" ><?php echo $grades[$i]['criteria_id']; ?></td>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $grades[$i]['criteria_code'].' - '.$grades[$i]['criteria']; ?></td>
	<td><?php echo $criteria[$i]['weight']; ?></td>
	<?php 
		$grade=$grades[$i]['grade']; 
		$dgdb=$grades[$i]['dg']; 	
	?>
	<td><input class="tpg vc50 right grade" type="text" name="grades[<?php echo $i; ?>][grade]" onchange="tallyAve();"
		value="<?php echo number_format($grade,$deciconducts); ?>" tabindex="2"  /></td>		
	<td><?php echo $dgdb; ?></td>	
	<input type="hidden" name="grades[<?php echo $i; ?>][gid]" value="<?php echo $grades[$i]['gid']; ?>"   />
</tr>
<?php endfor; ?>
<th colspan="3" >Final (Average)</th>
<?php 
	$grade=$grades[0]['final']; 
	$dgdb=$grades[0]['dgfinal']; 
?>
<td><input id="tpgave" class=" vc50 right" type="text" name="post[final]" 
	value="<?php echo number_format($grade,$deciconducts); ?>" tabindex="2"  /></td>
<td><?php echo $dgdb; ?></td>	
<input type="hidden" name="scid" value="<?php echo $scid; ?>"   />

</table>
<?php if(!$is_locked): ?>
	<p>
		<input type="submit" name="save" value="Save" /> &nbsp; 
		<button><a class="txt-black no-underline" href='<?php echo URL."cav/traits/$course_id/$sy/$qtr"; ?>' > Class Record </a></button>
	</p>
<?php endif; ?>
</form>

</div>



<div class="fifth"  >
<h5>Boys</h5>
<?php foreach($boys AS $row): ?>
<p><a href="<?php echo URL.'cav/student/'.$course_id.DS.$row['scid'].DS.$sy.DS.$qtr.$get; ?>" >
	<?php echo $row['student']; ?></a></p>
<?php endforeach; ?>
</div>

<div class="fifth"  >
<h5>Girls</h5>
<?php foreach($girls AS $row): ?>
<p><a href="<?php echo URL.'cav/student/'.$course_id.DS.$row['scid'].DS.$sy.DS.$qtr.$get; ?>" >
	<?php echo $row['student']; ?></a></p>
<?php endforeach; ?>
</div>

