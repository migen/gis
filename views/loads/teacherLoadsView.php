<?php 

// pr($data);
// pr($courses[0]);
// pr($_SESSION['q']);

$srid = $_SESSION['srid'];
$admin = ($srid==RMIS || $srid==RREG)? true:false;

$dbo=PDBO;
$dbg=VCPREFIX.$sy.US.DBG;
$dbcontacts="{$dbo}.00_contacts";



function setPage($cq){
	global $settings_scores;
	switch($cq['ctype_id']){
		case 1: {
			$page = ($cq['with_scores']==1)? 'scores':'grades'; 			
			break;		
		}		
		case 2: $page = 'traits'; break;
		case 5: $page = 'conducts'; break;
		default: $page = 'scores'; break;		
	}
	return $page;
}


?>



<h5>
	<span ondblclick="xxtracehd();" >Loads (Teacher View)</span> | 
	<a href="<?php echo URL.$home; ?>">Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	<?php if($all): ?>
		| <a href='<?php echo URL."loads/teacher/$tcid/$sy"; ?>'>Active</a>
	<?php else: ?>	
		| <a href='<?php echo URL."loads/teacher/$tcid/$sy?all"; ?>'>All</a>	
	<?php endif; ?>	
	
	<?php if($_SESSION['srid']==RMIS && !isset($_GET['edit'])):  ?>
		| <a href='<?php echo URL."loads/teacher/$tcid?edit"; ?>'>Edit</a>		
	<?php endif; ?>
	
</h5>


<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus value="-" />
		<input type="submit" name="auto" value="Contacts" onclick='abc(dbcontacts,30,cond);return false;' />		
	</td></tr>
	
</table></p>

<div id="names" >names</div>


<?php if($tcid): ?>


<form method="POST" >	<!-- form add courses -->
<!------------------------------------------------------------------>
<?php if($admin): ?>
	<table class="table-fx gis-table-bordered">
	<tr><td><?php echo $teacher['tcid']; ?></td>
		<td><?php echo $teacher['teacher_code']; ?></td>
		<td><?php echo $teacher['teacher']; ?></td>
	<?php if(!empty($teacher['advisory'])): ?>
		<td>Advisory: <?php echo $teacher['advisory']; ?></td>	
	<?php endif; ?>
	</tr></table> <br />
<?php endif; ?>
<!------------------------------------------------------------------------------------------------------------------------>

<table class="table-fx gis-table-bordered table-altrow">
<tr class='headrow'>
	<th>#</th>
	<th>ID</th>
	<th>Classroom</th>
	<th>Type</th>
	<th>Course</th>
	<th class="vc50" >Code</th>
	<th>Label</th>
	<th>TCID</th>

	<th>Is <br />Active</th>	
	<th>With <br />Scores</th>
	<th>Is<br />3-Tier</th>
	<th>Wt</th>
	
	<th>On<br />Display</th>
	<th>In<br />Genave</th>
	<th>Affects<br />Ranking</th>

	<th>Is<br />Aggre</th>
	<th>Is<br />Trns</th>
	<th>Pos</th>
	<th>Sem</th>
		
	<th>Schedule</th>
	<?php if(!$is_teacher): ?>			
		<th class="vc100 center" >Manage</th>
	<?php endif; ?>
	
</tr>
<!-- tbody -->
<?php for($i=0;$i<$num_courses;$i++): ?>
	<?php $active = ($courses[$i]['is_active'])? true:false;  ?>
	<tr id="tr<?php echo $i; ?>" class="<?php echo (!$active)? 'red':NULL; ?>"  >
		<td><?php echo $i+1; ?></td>
		<td><?php echo $courses[$i]['course_id']; ?></td>
		<td><?php echo $courses[$i]['classroom']; ?></td>
		<td><?php echo $courses[$i]['crstype']; ?></td>
		<td><?php echo $courses[$i]['name']; ?></td>
		<td><?php echo $courses[$i]['code']; ?></td>
		<td><?php echo $courses[$i]['label']; ?></td>
		
		<td><?php echo $courses[$i]['tcid']; ?></td>
		<td><?php echo ($courses[$i]['is_active']==1)? 'Y':'-'; ?></td>
		<td><?php echo ($courses[$i]['with_scores']==1)? 'Y':'-'; ?></td>
		<td><?php echo ($courses[$i]['is_kpup']==1)? 'Y':'-'; ?></td>

		<td><?php echo $courses[$i]['course_weight']; ?></td>
		<td><?php echo ($courses[$i]['is_displayed']==1)? 'Y':'-'; ?></td>
		<td><?php echo ($courses[$i]['in_genave']==1)? 'Y':'-'; ?></td>
		<td><?php echo ($courses[$i]['affects_ranking']==1)? 'Y':'-'; ?></td>
		<td><?php echo ($courses[$i]['is_aggregate']==1)? 'Y':'-'; ?></td>
		<td><?php echo ($courses[$i]['is_transmuted']==1)? 'Y':'-'; ?></td>

		<td><?php echo $courses[$i]['position']; ?></td>
		<td><?php echo $courses[$i]['semester']; ?></td>
		<td><?php echo $courses[$i]['schedule']; ?></td>		
	</tr>
	
<?php endfor; ?>

</table>
<br />


</form> <!-- save -->
</table>

<?php endif; ?>	<!-- tcid -->

<p> <?php $this->shovel('hdpdiv'); ?> </p>

<!------------------------------------------------------------------------->

<?php 
$cond="AND role_id<>1";

?>

<script>
var cond = "<?php echo $cond; ?>";
var hdpass 	= '<?php echo HDPASS; ?>';
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var limit=20;
			
$(function(){
	hd();
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	$('#hdpdiv').hide();
	
})




function axnFilter(id){
	var url=gurl+"/loads/teacher/"+id;
	window.location=url;
}




function abc(dbtable,limit=20,cond=null){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/axdata.php';	
	// var task = "xgetDataWithCondition";
	var task = "abc";

	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&part='+part+'&limit='+limit+'&dbtable='+dbtable+'&cond='+cond,async: true,
		success: function(s) {  
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="axnFilter(this.id);return false;" >'+s[i].name+' - #'+s[i].id+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}		  
    });					

}	/* fxn */








</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

