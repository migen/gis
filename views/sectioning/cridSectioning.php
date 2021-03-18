<?php 


$headrow="<tr><th>Axn</th><th>#</th><th>U|P</th><th>Sxnr</th><th>ID No</th><th>Name</th><th>Classroom</th></tr>";

// $_SESSION['q1']="haha";
// pr($_SESSION['q1']);

?>


<?php 
	$readonly = isset($_SESSION['readonly'])? $_SESSION['readonly'] : true;

	
?>

<!-------------------------------------------------------------------->

<h5> 
	<?php echo $classroom['name']; ?> SY <?php echo $sy; ?>
	| <span class="u" onclick="tracepass();" >Sectioning</span> 	
	| <?php $this->shovel('homelinks'); ?>
	| <span onclick="traceshd();" >SaveBtn</span>
	| <?php $this->shovel('homelinks'); ?>
	(<?php echo $count; ?>)

	| <a href="<?php echo URL.'classlists/classroom/'.$crid.DS.$sy; ?>">Classlist</a> 
	| <a href="<?php echo URL.'students/sectioner'; ?>" >Sectioner</a> 	
	| <a href='<?php echo URL."rosters/classroom/$crid/$sy"; ?>' >Roster</a> 	
	| <a href='<?php echo URL."sectioning/reverse/$crid/$sy"; ?>' onclick="return confirm('Sure?');" >Reverse</a> 	
	<?php if($srid==RMIS): ?>
		| <a href='<?php echo URL."enrollment/manager/$crid/$sy"; ?>' >Manager</a> 	
	<?php endif; ?>	
	<?php if(($srid==RMIS) || ($srid==RREG)): ?>
		| <a href="<?php echo URL.'sectioning/level/'.$classroom['level_id']; ?>" >Level</a>
	<?php endif; ?>
	
	
	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>	

| SY <select onchange="redirSy();" id="sy" >
	<option value="<?php echo DBYR; ?>" <?php echo ($sy==DBYR)? 'selected':NULL; ?> ><?php echo DBYR; ?></option>
	<option value="<?php echo (DBYR+1); ?>" <?php echo ($sy==(DBYR+1))? 'selected':NULL; ?> ><?php echo (DBYR+1); ?></option>
</select>	
		
</h5>

<div id="cellFeedback" >Feedback</div>

<?php echo (DBYR==$sy)? NULL:"<h5 class='brown'>*NOT CURRENT</h5>"; ?>


<p><?php $this->shovel('hdpdiv'); ?></p>


<table class="screen gis-table-bordered table-fx">

	<?php 
		$d['classrooms'] = $classrooms;
		$d['sy']		 = $sy;
		$d['axn']		 = 'crid';
		$this->shovel('redirect_classroom',$d); 	
	?>
</table>

<br />
<!-------------------------------------------------------------------->


<form method="POST" >


<table class="gis-table-bordered table-fx table-altrow" >


<tr class="" >
	<th class="" >Action</th>
	<th>#</th>
	<th>U|P</th>
	<th>Sxnr</th>
	<th>ID<br />Number</th>
	<th>Name</th>

	<th colspan="" class="center" > 
		<select id="icrid" class='vc200'>	
			<option> TO </option>
			<?php foreach($classrooms as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> 
					<?php echo $sel['name'].' #'.$sel['id']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('crid');" >	
	</th>		
	
	<td class="shd" >Cont<br />Sy</td>
	<td class="shd" >Cont<br />Crid</td>
	<td class="shd" >En<br />Crid</td>
	<td class="shd" >Summ<br />Prev<br />Crid</td>

	
<!-- contacts -->	

	
	
	
</tr>

<?php 
	$num_sum=0;
?>


<?php for($i=0;$i<$count;$i++): ?>
<?php $scid=$rows[$i]['ucid']; ?>
<tr>
	<td class="" >		
		<button class="scb<?php echo $i; ?>" id="btn<?php echo $i; ?>" 
			onclick="xenrollStudentByRow(<?php echo $i; ?>);return false;" >Save</button>  		
	</td>
	<td><?php echo $i+1; ?></td>	
<td>
	<a href="<?php echo URL.'contacts/ucis/'.$rows[$i]['ucid']; ?>" ><?php echo $rows[$i]['summscid']; ?>		
	<?php if($rows[$i]['ucid']!=$rows[$i]['pcid']){ echo "|".$rows[$i]['pcid']; } ?>				
</td>	
	<td><a href="<?php echo URL.'students/sectioner/'.$rows[$i]['ucid'].DS.$sy; ?>" >Sxnr</a></td>		
	<td class="u" ><a href="<?php echo URL."contacts/ucis/$scid"; ?>" ><?php echo $rows[$i]['studcode']; ?></a></td>
	<td><?php echo $rows[$i]['studname']; ?></td>
		
	<td>
		<select id="<?php echo $i; ?>" name='posts[<?php echo $i; ?>][crid]' class="crid vc200" 
			onchange="thisAdvi(<?php echo $i; ?>,this.value,<?php echo $sy; ?>);"  >
		<?php foreach($classrooms AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$crid)? 'selected':null; ?> >
			<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
		</select>	
	</td>	
				
	
	
	
	

		
	
<!-- edit: contacts -->	


<td class="shd" ><?php echo $rows[$i]['contsy']; ?></td>
<td class="shd" ><?php echo $rows[$i]['contcrid']; ?></td>
<td class="shd" ><?php echo $rows[$i]['encrid']; ?></td>
<td class="shd" ><?php echo $rows[$i]['summprevcrid']; ?></td>

	<input type="hidden" name="posts[<?php echo $i; ?>][name]"  value="<?php echo $rows[$i]['studname']; ?>"  >
	<input type="hidden" name="posts[<?php echo $i; ?>][scid]"  value="<?php echo $rows[$i]['ucid']; ?>"  >
	<input type="hidden" name="posts[<?php echo $i; ?>][enid]"  value="<?php echo $rows[$i]['enid']; ?>"  >


</tr>
<?php endfor; ?>
<?php echo $headrow; ?>
</table>


<p class="hd shd" ><input onclick="return confirm('Proceed?');" type="submit" name="submit" value="Save All"   /></p>
</form>


<div class="ht100 clear" >&nbsp;</div>

<!------------------------------------------------------------------------------------------------------------->

<?php $hdpass = isset($hdpass)? $hdpass:HDPASS;  ?>
<?php  DEFINE('SECRET',$hdpass); ?>


<script>
var gurl = "http://<?php echo HOST.'/'.DOMAIN; ?>";
var sy = "<?php echo $sy; ?>";
var psy = "<?php echo $psy; ?>";
var crid = "<?php echo $crid; ?>";
var home = "sectioning";
var hdpass 	= "<?php echo SECRET; ?>";


$(function(){
	// hd();
	// shd();
	// alert(hdpass);
	$('#hdpdiv').hide();

})


function redirSy(){
	var sy=$('#sy').val();
	var url=gurl+'/sectioning/crid/'+crid+'/'+sy;
	window.location=url;	
}	/* fxn */



function xenrollStudentByRow(i){
	var scid=$('input[name="posts['+i+'][scid]"]').val();	
	var name=$('input[name="posts['+i+'][name]"]').val();	
	var crid=$('select[name="posts['+i+'][crid]"]').val();	

	var vurl = gurl+'/ajax/xenrollment.php';			
	var task = "xenrollStudent";		
	var pdata="task="+task+"&sy="+sy+"&scid="+scid+"&crid="+crid;
	
	
	$.ajax({
		url:vurl,type:"POST",data:pdata,
		success: function() { 
			$('#cellFeedback').text(name+" to "+crid); 
		}		  
	});					
	
}	/* fxn */





</script>


<script type='text/javascript' src="<?php echo URL; ?>views/js/promotionsHide.js"></script>






