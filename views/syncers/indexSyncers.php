<?php 

// pr($classrooms[2]);
// pr($classrooms[0]);

?>


<h5> 
	Grades Syncer
	| <a href="<?php echo URL.$home; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href='<?php echo URL."misc/listClassrooms/$sy"; ?>' > Info </a>

</h5>


<table class="gis-table-bordered table-fx"  >
<tr class="headrow" >
	<th></th>
	<th>Crid</th>
	<th class="vc200" >Level-Section<br />Classroom</th>
	<th>Grades</th>
	<th></th>
	<th></th>
	<th></th>
	<th></th>
	<th>Adviser<br />Pass</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $classrooms[$i]['id']; ?></td>
	<td class="vc150" ><?php echo $classrooms[$i]['level'].' - '.$classrooms[$i]['section']; ?>
			<br /><a target="blank" href="<?php echo URL.'registrars/classroom/'.$classrooms[$i]['crid']; ?>" >		
			<?php echo $classrooms[$i]['classroom']; ?></a>	
	</td>
	<td>
		<a href='<?php echo URL."syncers/syncGrades/".$classrooms[$i]['crid'].DS.$sy.DS.CTYPEACAD; ?>' >Acad</a>
	<?php if(isset($classrooms[$i]['trait_id'])): ?>
		| <a href='<?php echo URL."cav/traits/".$classrooms[$i]['trait_id']."/$sy/$qtr"; ?>' >Traits</a>			
	<?php endif; ?>
	</td>
	<td><a href='<?php echo URL."matrix/grades/".$classrooms[$i]['crid'].DS.$sy.DS.$qtr; ?>' >Matrix</a></td>
	<td><a href='<?php echo URL."classlists/classroom/".$classrooms[$i]['crid'].DS.$sy; ?>' >Students</a></td>
	<td><a href='<?php echo URL."rosters/classroom/".$classrooms[$i]['crid'].DS.$sy; ?>' >Sxn</a></td>
	<td><a href='<?php echo URL."classrooms/courses/".$classrooms[$i]['crid']; ?>' >Crs</a></td>
	<td><?php echo $classrooms[$i]['adviser'].'<br />';
		echo '#'.$classrooms[$i]['ucid'].'-'.$classrooms[$i]['account'].'-'.$classrooms[$i]['ctp']; ?></td>	
</tr>
<?php endfor; ?>
</table>


<div class="ht100" ></div>