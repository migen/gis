<?php 

$dbg=PDBG;
$dbtable="{$dbg}.10_scores";


?>

<h5>
	Edit Student Uniscores | <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="traceshd();" >Show</span>
	| <a href="<?php echo URL.'unisync/studentScores/'.$crs.DS.$scid; ?>" >Sync</a>
	| <a href="<?php echo URL.'uniscores/crs/'.$crs; ?>" >Scores</a>
	
	
</h5>


<?php 
//pr($student); 
?>



<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="shd" >SID</th>
	<th class="shd" >SCID</th>
	<th>Date</th>
	<th>Acty</th>
	<th>Max</th>
	<th>Score</th>
	<th></th>
	<th class="shd" ></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr id="trow-<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td class="shd" ><?php $sid=$rows[$i]['sid']; echo $sid; ?></td>
	<td class="shd" ><?php echo $rows[$i]['scid']; ?></td>
	<td><?php $date=$rows[$i]['date']; echo date('M-d',strtotime($date)); ?></td>
	<td><?php echo $rows[$i]['activity']; ?></td>
	<td class="center" ><?php echo $rows[$i]['max_score']+0; ?></td>
	<td><input id="score-<?php echo $i; ?>" name="posts[<?php echo $i; ?>][score]" 
		class="vc50 center" value="<?php echo $rows[$i]['score']+0; ?>" ></td>
	<td><button id="btn-<?php echo $i; ?>" onclick="xeditData(<?php echo $i; ?>);" >Save</button></td>	
	<td class="shd" ><button class="" onclick="xdelrow(dbtable,<?php echo $sid.','.$i; ?>);" >Drop</button></td>	
	<td class="shd" ><input name="posts[<?php echo $i; ?>][sid]" value="<?php echo $sid; ?>" ></td>
	
</tr>
<?php endfor; ?>
</table>



<script>
var gurl="http://<?php echo GURL; ?>";
var dbtable="<?php echo $dbtable; ?>";

$(function(){
	shd();
	
})


function xeditData(i){
	var id=$('input[name="posts['+i+'][sid]"]').val();
	var score=$('input[name="posts['+i+'][score]"]').val();
	var vurl=gurl+'/ajax/xsaveData.php';	
	var task="xeditData";	
	
	// alert(vurl+', id: '+id+', score: '+score);
	
	$.ajax({
		url:vurl,type:"POST",data:"task="+task+"&dbtable="+dbtable+"&score="+score+"&id="+id,
		success: function() { $("#btn-"+i).hide(); }		  
    });				
	
}	/* fxn */



</script>
