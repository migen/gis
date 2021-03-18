<?php 

// pr($_SESSION['q']);
// pr($rows[0]);

$headrow="<tr><th>Axn</th><th>#</th><th>U|P</th><th>Sxnr</th><th>ID No</th><th>Name</th><th>Classroom</th><th>Grp</th><th>SY</th><th>CCR</th><th>Actv</th><th>Male</th><th class='hd'>Clrd</th><th  class='hd'>Summ</th><th  class='hd'>Attd</th><th  class='hd'>Stud</th><th  class='hd'>Ctp</th><th  class='hd'>Prof</th></tr>";



?>

<?php // echo $hdpass; ?>

<?php 
	$readonly = isset($_SESSION['readonly'])? $_SESSION['readonly'] : true;

	
?>

<!-------------------------------------------------------------------->

<h5>
	<span class="u" ondblclick="tracepass();" ><?php echo $level['name']; ?> Sectioning</span>
	(<?php echo $count; ?>)
	<span class="hd" >HD</span>
	| <a href="<?php echo URL.$home; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'rosters/classroom'; ?>">Roster</a> 
	| <a href="<?php echo URL.'sectioning/level/'.$level_id.'?grp'; ?>">Sort by Group</a> 
	| <a href='<?php echo URL."sectioning/level/$level_id?all"; ?>' >All SY</a> 		
	| <a href='<?php echo URL."sectioning/level/$level_id?sxns"; ?>' >All Sxns</a> 		
	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>

| SY <select onchange="redirSy();" id="sy" >
	<option value="<?php echo DBYR; ?>" <?php echo ($sy==DBYR)? 'selected':NULL; ?> ><?php echo DBYR; ?></option>
	<option value="<?php echo (DBYR+1); ?>" <?php echo ($sy==(DBYR+1))? 'selected':NULL; ?> ><?php echo (DBYR+1); ?></option>
</select>	


	
</h5>


<?php echo (DBYR==$sy)? NULL:"<h5 class='brown'>*NOT CURRENT</h5>"; ?>

	<p><?php $this->shovel('hdpdiv'); ?></p>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."sectioning/level/".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>

<table class="screen gis-table-bordered table-fx">

	<?php 
		$d['classrooms'] = $classrooms;
		$d['sy']		 = $sy;
		$d['axn']		 = 'classroom';
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
		<select id="icr" class='vc120'>	
			<option> TO </option>
			<?php foreach($classrooms as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> <input type="button" value="All" onclick="clsAdvi(<?php echo $sy; ?>);" >	
	</th>		
	<th class="" >Grp<br />
		<input class="pdl05 vc50" type="number" id="igrp" value="1" /><br />	
		<input type="button" value="All" onclick="populateColumn('grp');" >					
	</th>	
	
	
	<th class="" >
		<input class="pdl05 vc70" type="text" id="isy" placeholder="SY" /><br />	
		<input type="button" value="All" onclick="populateColumn('sy');" >			
	</th>		
	<th>CCR</th>
	
<!-- contacts -->	
	<th class="" >
		Actv
		<br /><input class="center vc50" type="number" min=0 max=1 id="iactv" placeholder="Actv" /><br />	
		<input type="button" value="All" onclick="populateColumn('actv');" >					
	</th>
	<th class="" >
		Male
		<br /><input class="pdl05 vc50" type="number" min=0 max=1 id="imale" placeholder="Male" /><br />			
		<input type="button" value="All" onclick="populateColumn('male');" >					
	</th>	

	<th class="hd" >
		<input class="center vc50" type="number" min=0 max=1 id="iclrd" placeholder="Clrd" /><br />	
		<input type="button" value="All" onclick="populateColumn('clrd');" >						
	</th>	
	
<!-- init: tsum,stud,ctp,prof,photo -->	
	<th class="hd" >Sum<br />Acid</th>	
	<th class="hd" >Attd</th>
	<th class="hd" >Stud</th>
	<th class="hd" >Ctp</th>
	<th class="hd" >Prof</th>
<!-- init -->	

</tr>

<?php 
	$num_sum=0;
?>


<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="" >		
		<button class="scb<?php echo $i; ?>" id="btn<?php echo $i; ?>" 
			onclick="xeditSectioning(<?php echo $i.','.$rows[$i]['scid']; ?>);return false;" >Save</button>  		
	</td>
	<td><?php echo $i+1; ?></td>	
<td>
	<a href="<?php echo URL.'contacts/ucis/'.$rows[$i]['scid']; ?>" ><?php echo $rows[$i]['sumscid']; ?>		
	<?php if($rows[$i]['ucid']!=$rows[$i]['pcid']){ echo "|".$rows[$i]['pcid']; } ?>			
</td>	

	<td><a href="<?php echo URL.'students/sectioner/'.$rows[$i]['scid'].DS.$sy; ?>" >Sxnr</a></td>	
	<td class="u" id="<?php echo $rows[$i]['ctp']; ?>" ondblclick="alert(this.id);" ><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
		
	<td>
		<select id="<?php echo $i; ?>" name='students[<?php echo $i; ?>][crid]' class="cr vc120" 
			onchange="thisAdvi(<?php echo $i; ?>,this.value,<?php echo $sy; ?>);"  >
		<?php foreach($classrooms AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$rows[$i]['crid'])? 'selected':null; ?> ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
		</select>	
	</td>
		
	<td >	
		<input name="students[<?php echo $i; ?>][grp]" id="grp<?php echo $i; ?>" class="vc30 grp right pdr05" type="text" 
			value="<?php echo $rows[$i]['grp']; ?>" tabIndex="10" />
	</td>			
	
		
	<td><input id="studsy<?php echo $i; ?>" class="sy right pdr05 vc70" 
		name="students[<?php echo $i; ?>][sy]" type="number" value="<?php echo $rows[$i]['sy']; ?>"  ></td>				

	<td ><input id="contcrid<?php echo $i; ?>" class="center vc50"  name="students[<?php echo $i; ?>][contcrid]" 
		value="<?php echo $rows[$i]['contcrid']; ?>" readonly ></td>	

	<td class="" ><input class="center vc50 actv"  name="students[<?php echo $i; ?>][is_active]" type="number" min=0 max=1
		value="<?php echo $rows[$i]['is_active']; ?>" /></td>

	<td class="" ><input class="center vc50 male"  name="students[<?php echo $i; ?>][is_male]" type="number" min=0 max=1
		value="<?php echo $rows[$i]['is_male']; ?>" /></td>
		
	
<!-- edit: contacts -->	


	<td class="hd" ><input class="center vc50 clrd"  name="students[<?php echo $i; ?>][is_cleared]" type="number" min=0 max=1
		value="<?php echo $rows[$i]['is_cleared']; ?>" /></td>

		
	
<!-- init: tsum,stud,ctp,prof,photo -->	

	<td class="hd" ><?php echo $rows[$i]['sumacid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['attdscid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['studscid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['ctpscid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['profscid']; ?></td>
<!-- init -->	
		
	<input type="hidden" name="students[<?php echo $i; ?>][scid]"  value="<?php echo $rows[$i]['scid']; ?>"  >

</tr>
<?php endfor; ?>
<?php echo $headrow; ?>
</table>
<br />

<p class="hd" ><input onclick="return confirm('Proceed?');" type="submit" name="submit" value="Save All"   /></p>
</form>




<!------------------------------------------------------------------------------------------------------------->

<?php  DEFINE('SECRET',$hdpass); ?>

<script>
var gurl = "http://<?php echo HOST.'/'.DOMAIN; ?>";
var sy	 = "<?php echo $sy; ?>";
var psy = "<?php echo $psy; ?>";
var lvl	 = "<?php echo $level_id; ?>";
var home = "sectioning";
var hdpass 	= "<?php echo SECRET; ?>";



$(function(){
	// hd();
	nextViaEnter();
	$('#hdpdiv').hide();

})


function redirSy(){
	var sy=$('#sy').val();
	var url=gurl+'/sectioning/level/'+lvl+'/'+sy;
	window.location=url;	
}	/* fxn */




</script>


<script type='text/javascript' src="<?php echo URL; ?>views/js/promotions.js"></script>













