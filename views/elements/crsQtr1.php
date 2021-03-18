<?php 


$home 		= $data['home'];
$sy 		= $data['sy'];
$qtr 		= $data['qtr'];
$intfqtr 	= $data['intfqtr'];
$cq 		= $data['cq'];
$num_cq 	= $data['num_cq'];
$ssy 		= $_SESSION['sy'];	
$sqtr 		= $_SESSION['qtr'];	

$settings_scores = $_SESSION['settings']['scores'];


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


// pr($cq[0]);

?>



<div class='accordParent' >


<button onclick="accorToggle('cqt')" class="vc300 bg-blue2" > <p class="b f16" > Manage Courses </p> </button> 

<table id="cqt" class="gis-table-bordered table-fx table-altrow" >

<tr class="headrow" >
<td> &nbsp; </td>
<td> &nbsp; </td>
<td> &nbsp; </td>
<td> &nbsp; </td>
<td colspan="7" class="b center" > CQ Status : 1 - Lock / 0 - Unlock  </td>

<td class="b center vc200" > Class Records  </td>


</tr>

<!-- ================================================================================  -->

<tr class="headrow">
	<th class="vc30" >#</th>
	<th class="" >Averages<br /> 
	<?php 
		for($i=1;$i<=$_SESSION['qtr'];$i++){
			echo "Q$i ";
		} 
	?>
	
	</th>
	<th class="" >Subject</th>
	<th class="" >Teacher Loads</th>
	<?php for($j=1;$j<=$intfqtr;$j++): ?>
		<th class="vc50 center" >
			<select id="icq<?php echo $j; ?>" class='full'>	
				<option><?php echo $j; ?></option>
				<option value="1" >1</option>
				<option value="0" >0</option>				
			</select>				
			<br /> <input type="button" value="All" onclick="populateColumn('cq<?php echo $j; ?>');" />					
		</th>
	<?php endfor; ?>	
	
	<th class="vc50 center" >Save</th>
	<th class="vc100" > Q<?php echo $qtr; ?> Submitted </th>
	
	<th class="center" > &nbsp; </th>
</tr>

<!-- ================================================================================  -->

<?php for($i=0;$i<$num_cq;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><a href='<?php echo URL."averages/course/".$cq[$i]['course_id']."/$ssy/$sqtr"; ?>' >
		<?php echo $cq[$i]['level'].' - '.$cq[$i]['section']; ?></a></td>
	<td><?php echo $cq[$i]['label']; ?></td>
	<td>
		<a href='<?php echo URL."loads/teacher/".$cq[$i]['tcid']; ?>' ><?php echo $cq[$i]['teacher']; ?></a>
		<span class='hd'> | <a href='<?php echo URL."mgt/pass/".$cq[$i]['tcid']; ?>' >Log</a></span>
	
	</td>
	<td class="center <?php echo (!$cq[$i]['is_finalized_q1'])? 'bg-pink' : null; ?> " >			
		<select id="cq1<?php echo $i; ?>" class="cq1 vc40 center" name="cq[<?php echo $i; ?>][q1]"  >		
			<option value="0" <?php echo (!$cq[$i]['is_finalized_q1'])? 'selected' : null; ?>  > 0 </option>
			<option value="1" <?php echo ($cq[$i]['is_finalized_q1'])? 'selected' : null; ?>  > 1 </option>
		</select>		
	</td>
	
	<?php for($j=2;$j<=$intfqtr;$j++): ?>
		<td class="center <?php echo (!$cq[$i]['is_finalized_q'.$j])? 'bg-pink' : null; ?>" >			
			<select id="cq<?php echo $j; ?><?php echo $i; ?>" class="cq<?php echo $j; ?> vc40 center"   >		
				<option value="0" <?php echo (!$cq[$i]['is_finalized_q'.$j])? 'selected' : null; ?>  > 0 </option>
				<option value="1" <?php echo ($cq[$i]['is_finalized_q'.$j])? 'selected' : null; ?>  > 1 </option>
			</select>		
		</td>
	<?php endfor; ?>
	
	
	<?php $pcrs = ($cq[$i]['supsubject_id'])? $cq[$i]['supsubject_id']:0; ?>
	<td><button id="csb<?php echo $i; ?>" onclick="xeditCq(<?php echo $i.','.$pcrs; ?>);return false;" > Save <?php ; ?> </button>  </td>

	<td><?php echo ($cq[$i]['is_finalized_q'.$qtr])? $cq[$i]['finalized_date_q'.$qtr]: 'Pending'; ?></td>
	
	<td> 
		<?php $page = setPage($cq[$i]); $ctrl = (($page=='grades') || ($page=='scores'))? 'teachers':'advisers'; 	?>
		<a href='<?php echo URL."$ctrl/$page/".$cq[$i]['course_id']."/$ssy/1"; ?>'>Q1</a> | 
		<a href='<?php echo URL."$ctrl/$page/".$cq[$i]['course_id']."/$ssy/2"; ?>'>Q2</a> | 
		<a href='<?php echo URL."$ctrl/$page/".$cq[$i]['course_id']."/$ssy/3"; ?>'>Q3</a> | 
		<a href='<?php echo URL."$ctrl/$page/".$cq[$i]['course_id']."/$ssy/4"; ?>'>Q4</a> 
		- <?php echo $page; ?> 		
	</td>
	
	<!-- ajax post but still prefer to use val over text hence this hidden field -->
	<input id="crsid<?php echo $i; ?>"  type="hidden" value="<?php echo $cq[$i]['course_id']; ?>"  />
	<input id="crid<?php echo $i; ?>"  type="hidden" value="<?php echo $cq[$i]['crid']; ?>"  />
	
</tr>
<?php endfor; ?>
</table>

</div>
