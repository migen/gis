<?php 
// pr($classroom);
// pr($rows[0]);
?>

<h5>
	Enrollment Manager 
	| Crid#<?php echo $crid; ?> (<?php echo ($crid)? $count:NULL; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>' >Classlist</a>
	| <a href='<?php echo URL."sectioning/crid/$crid/$sy"; ?>' >Sectioning</a>
	<?php $this->shovel('links_enrollment'); ?>

<?php 
	$d['sy']=$sy;$d['repage']="enrollment/manager/$crid";
	$this->shovel('sy_selector',$d); 

?>	
	
	
</h5>

<h4 class="brown" >
<br />1) Init - Creates Entry in next SY Summaries with previous SY's Classroom. 
<br />2) Update - a) contacts Classroom and SY and b) Enrollments. 
</h4>


<table class="gis-table-bordered table-fx" >
<tr>
<td>
<select name="cls" class="vc200" >
<?php foreach($classrooms AS $sel): ?>
<option value="<?php echo $sel['id']; ?>" <?php echo ($crid==$sel['id'])? 'selected':NULL; ?> >
<?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td>
<td><button onclick="redir();" >Go</button></td>
<?php if($crid): ?><td>Adviser: #<?php echo $classroom['acid'].' '.$classroom['adviser'].' Login: '.$classroom['adviser_code'].' '; ?>
| <a href="<?php echo URL.'classrooms/level/'.$classroom['level_id'].DS.$sy; ?>">Edit</a>
</td><td>Crid: #<?php echo $crid; ?></td><?php endif; ?>
</tr>
</table>

<br />


<?php if($crid): ?>
<div class="sixty" >
<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th><input type="checkbox" id="chkAlla"  /></th><th>#</th><th>Scid</th><th>ID No.</th><th>Student</th><th>Cont-SY
	<br /><input class="pdl05 vc80" type="number" id="isy" value="<?php echo $sy; ?>" /><br />	
	<input type="button" value="All" onclick="populateColumn('sy');" >					
</th><th>Actv</th><th>Cont<br>Crid</th><th>Encrid</th><th>Enid</th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="screen" ><input class="chka" type="checkbox" name="posts[<?php echo $i; ?>][is_selected]" 
		value="1" tabindex="2" /></td>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><input class="vc80" name="posts[<?php echo $i; ?>][code]" 
		value="<?php echo $rows[$i]['code']; ?>" tabindex="4" /></td>	
	
	<td><input class="vc200" name="posts[<?php echo $i; ?>][name]" 
		value="<?php echo $rows[$i]['name']; ?>" tabindex="6" /></td>	
	
	<td><input class="center vc80 sy" name="posts[<?php echo $i; ?>][sy]" type="number"
		value="<?php echo $rows[$i]['sy']; ?>" tabindex="8" /></td>
	<td><input class="center vc50 actv" name="posts[<?php echo $i; ?>][is_active]" min=0 max=1
		value="<?php echo $rows[$i]['is_active']; ?>" tabindex="10" /></td>	
	<td><?php echo $rows[$i]['contcrid']; ?></td>
	<td><?php echo $rows[$i]['encrid']; ?></td>
	<td><?php echo $rows[$i]['enid']; ?></td>
</tr>
	<input type="hidden" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $rows[$i]['scid']; ?>"  />
<?php endfor; ?>

</table>

<p>
	<?php if($_SESSION['srid']==RMIS): ?>
		<input type="submit" name="batch" value="Delete" onclick="return confirm('Extremely Dangerous!Sure?');" />	
	<?php endif; ?>
	<select name="cridto" class="vc200" >
	<option value="0" >Section To</option>
	<?php foreach($classrooms AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
	</select>	
	
	<input type="submit" name="batch" value="Section"  />
	<input type="submit" name="batch" value="Init"  />
	<input type="submit" name="batch" value="Update"  />
</p>

</form>
</div>


<div class="third" >
<form id="form" >
<h5>Rostering</h5>
<table class="gis-table-bordered" >
<tr>
	<th>Scid</th>
	<th>ID No.</th>
	<th>Student</th>
	<th>Action</th>
</tr>


<tr>
	<td>
		<input readonly id="scid" class="pdl05 vc60" value="0" />
		<input type="hidden" id="prevcrid" class="pdl05 vc60" value="0" />		
		<input type="hidden" id="acid" class="pdl05 vc60" value="0" />		
	</td>
	<td class="vc200" >
		<input class="pdl05 pdl05 vc100" id="codes"  />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByCode();return false;" />	
	</td>
	<td class="vc250" ><input class="pdl05 vc150" id="part" autofocus />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart();return false;" />		
	</td>
	<td class="vc200" >
		<input type="submit" value="Enroll" onclick="addRoster();return false;"  />
		<input type="submit" value="Register" onclick="registerStudent();return false;"  />
	</td>
</tr>
</table>
</form>

<div id="names" ></div>

</div>

<?php endif; ?>


<script>
var gurl="http://<?php echo GURL; ?>";
var crid="<?php echo $crid; ?>";
var prevcrid="<?php echo $crid; ?>";
var acid="<?php echo $classroom['acid']; ?>";
var sy	 = "<?php echo $sy; ?>";
var hdpass 	= "<?php echo HDPASS; ?>";


$(function(){
	chkAllvar('a');	
	$('html').live('click',function(){
		$('#names').hide();
	});

})

function redir(){
	var crid=$('select[name="cls"]').val();
	var url=gurl+'/enrollment/manager/'+crid+'/'+sy;
	window.location=url;	
}



</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
<script type="text/javascript" src='<?php echo URL."views/js/rosters.js"; ?>' ></script>
