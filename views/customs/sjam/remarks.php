<?php 
// pr($_SESSION['q']);


?>

<style>


</style>

<h5>
	SJAM Classroom Remarks
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	| <a href="<?php echo URL.'remarks/classroom/'.$crid.DS.$sy.DS.'1'; ?>" >Q1</a>
	| <a href="<?php echo URL.'remarks/classroom/'.$crid.DS.$sy.DS.'2'; ?>" >Q2 (Sem1)</a>
	| <a href="<?php echo URL.'remarks/classroom/'.$crid.DS.$sy.DS.'3'; ?>" >Q3</a>
	| <a href="<?php echo URL.'remarks/classroom/'.$crid.DS.$sy.DS.'4'; ?>" >Q4 (Sem2)</a>
	
	
</h5>

<?php $sync = false; ?>

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<th><?php echo "Q$qtr"; ?></th>

	<th>Save</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php if(!$rows[$i]['rscid']){ $sync=true; } ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['rscid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
		
	<td class="vc300" ><textarea cols="50" rows="5" id="remark<?php echo $i; ?>" 
		name="posts[<?php echo $i; ?>][q<?php echo $qtr; ?>]" ><?php echo $rows[$i]['q'.$qtr]; ?></textarea>
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

var gurl="http://<?php echo GURL; ?>";
var qtr="<?php echo $qtr; ?>";


$(function(){
	hd();
	nextViaEnter();
	itago('clipboard');

})


function saveRemarksScid(i){
	var scid = $('#scid'+i).val();
	var remark = $('#remark'+i).val();
	$('#btn'+i).hide();

	var vurl=gurl+"/ajax/xremarks.php";	
	var task="saveRemarksScid";	
	var pdata='task='+task+'&scid='+scid+'&'+('q'+qtr)+'='+remark;
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',data: pdata,async: true,success: function() {}		  
    });				

	
	
}	/* fxn */



</script>



