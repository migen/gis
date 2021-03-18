<?php 
// pr($_SESSION['q']);


?>

<style>


</style>

<h5>
	GIS Classroom Remarks
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	| <a href="<?php echo URL.'remarks/classroom/'.$crid.DS.$sy.'1'; ?>" >Q1</a>
	| <a href="<?php echo URL.'remarks/classroom/'.$crid.DS.$sy.'2'; ?>" >Q2/ Sem1 </a>
	| <a href="<?php echo URL.'remarks/classroom/'.$crid.DS.$sy.'3'; ?>" >Q3</a>
	| <a href="<?php echo URL.'remarks/classroom/'.$crid.DS.$sy.'4'; ?>" >Q4/ Sem2</a>
	
	
</h5>

<?php $sync = false; ?>

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<th>Initial</th>
	<th>Final</th>
	<th>Save</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php if(!$rows[$i]['rscid']){ $sync=true; } ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['rscid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td class="vc500" ><textarea cols="70" rows="5" id="initial<?php echo $i; ?>" 
		name="posts[<?php echo $i; ?>][initial]" ><?php echo $rows[$i]['initial']; ?></textarea>
	</td>
	<td class="vc500" ><textarea cols="70" rows="5" id="final<?php echo $i; ?>" 
		name="posts[<?php echo $i; ?>][final]" ><?php echo $rows[$i]['final']; ?></textarea>
	</td>		
	<input type="hidden" name="posts[<?php echo $i; ?>][scid]" id="scid<?php echo $i; ?>"
		value="<?php echo $rows[$i]['rscid']; ?>" />
	<td><button id="btn<?php echo $i; ?>" onclick="saveRemarksScid(<?php echo $i; ?>);return false;" >Save</button></td>
</tr>
<?php endfor; ?>
</table>

<p><?php if($sync): ?>
	<a href="<?php echo URL.'utils/syncRemarksCrid/'.$crid; ?>" >Sync</a>
<?php else: ?>
	<input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');"  />
<?php endif; ?></p>

</form>



<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="initial" >Initial</option>
	<option value="final" >Final</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>




<!------------------------------------------------------------>

<script>

var gurl = "http://<?php echo GURL; ?>";


$(function(){
	hd();
	nextViaEnter();
	itago('clipboard');

})


function saveRemarksScid(i){
	var scid = $('#scid'+i).val();
	var rinitial = $('#initial'+i).val();
	var rfinal = $('#final'+i).val();
	$('#btn'+i).hide();

	var vurl 	= gurl + '/ajax/xremarks.php';	
	var task	= "saveRemarksScid";	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&scid='+scid+'&rinitial='+rinitial+'&rfinal='+rfinal,				
		async: true,
		success: function() {}		  
    });				

	
	
}	/* fxn */



</script>



