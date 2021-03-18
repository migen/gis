<?php 

// pr($_SESSION['q']);

$dbg=VCPREFIX.$sy.US.DBG;
$dbo=PDBO;
$dbtable="{$dbo}.`00_contacts`";

?>

<h5>
	Student Scores Filter | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'grades/student/'.$scid.DS.$sy; ?>" >Grades</a> 	
	| <span class="b u" onclick="traceshd();" >ID</span>		
	| <span class="b" >SY</span>: <input id="sy" type="number" class="vc100" value="<?php echo $sy; ?>" >
	<button onclick="jsredirect('grades/scid/'+<?php echo $scid; ?>+'/'+$('#sy').val());" >Go</button>
		
</h5>



<div class="third" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th class="headrow center" >Student</th>
	<td><input class="pdl05" id="part" value="" autofocus /> </td>
	<td><input type="submit" class="vc150" value="Filter" onclick="xgetDataByTable('<?php echo $dbtable; ?>');return false;" /></td>
</tr>
</table>
</div>

<div class="" id="names" >names</div>

<?php if($scid): ?>
	<div class="clear" >
		<?php // pr($student); ?>
		
		<br /><table class="gis-table-bordered table-altrow" >
			<tr>
				<th><?php echo $student['name'].' #'.$student['scid']; ?></th>
				<th><?php echo $student['classroom'].' #'.$student['crid']; ?></th>			
			</tr>
		</table><br />
		<table class="gis-table-bordered table-altrow" >
			<tr><th>#</th><th class="shd" >Crs</th><th>Label</th>
				<th class="center" >Grades</th><th class="center" >Scores</th></tr>
			<?php for($i=0;$i<$count;$i++): ?>			
				<?php $crs=$rows[$i]['crs']; ?>
				<?php $is_num=$rows[$i]['is_num']; ?>
				<tr>
					<td><?php echo $i+1; ?></td>
					<td class="shd" ><?php echo $rows[$i]['crs']; ?></td>
					<td><?php echo $rows[$i]['label']; ?></td>
					<?php if($is_num): ?>
						<td>
							<?php echo $rows[$i]['q1']+0; ?> &nbsp;
							<?php echo $rows[$i]['q2']+0; ?> &nbsp;
							<?php echo $rows[$i]['q3']+0; ?> &nbsp;
							<?php echo $rows[$i]['q4']+0; ?> 
						</td>
					<?php else: ?>	
						<td>
							<?php echo $rows[$i]['dg1']; ?> &nbsp;
							<?php echo $rows[$i]['dg2']; ?> &nbsp;
							<?php echo $rows[$i]['dg3']; ?> &nbsp;
							<?php echo $rows[$i]['dg4']; ?> 
						</td>					
					<?php endif; ?>	
					<td>
						<?php for($q=1;$q<5;$q++): ?>
							<a href="<?php echo URL.'scores/editStudent/'.$crs.DS.$scid.DS.$sy.DS.$q; ?>" >Q<?php echo $q; ?></a>&nbsp;
						<?php endfor; ?>
					</td>
				</tr>
			<?php endfor; ?>
		</table>				
	</div>	
	<div class="ht100" ></div>
<?php endif; ?> <!-- scid -->


<script>

var gurl="http://<?php echo GURL; ?>";
var limits=30;
var sy="<?php echo $sy; ?>";
var qtr="<?php echo $qtr; ?>";
var limits=100;

$(function(){
	// alert(sy+'/'+qtr);
	// alert(gurl+'/'+limits+'/'+crs);
	shd();
	$("#names").hide();	
	$('html').live('click',function(){ $('#names').hide(); });

	
})


function axnFilter(id){
	var url = gurl+'/grades/scid/'+id+'/'+sy;
	window.location=url;			
	
}	/* fxn */


function redirContact(ucid){
	var url = gurl+'/uniregister/student/'+ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>

