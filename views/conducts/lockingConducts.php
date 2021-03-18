<style>

input{
	text-align:center;
}


</style>

<h3>
	<?php echo $level['name']; ?> Conducts Locking | <?php $this->shovel('homelinks'); ?>


</h3>

<?php 

// pr($data);
// pr($rows[0]);


// pr($_SESSION['q']);

?>

<p>
	<?php foreach($levels AS $sel): ?>
		<a href="<?php echo URL.'conducts/locking/'.$sel['id'].DS.$sy; ?>" ><?php echo $sel['code']; ?></a> | 
	<?php endforeach; ?>
</p>


<p class="brown b" >*0=open | 1=locked</p>


<form method="POST" >
<table class="gis-table-bordered table-altrow table-fx" >
<tr >
	<th>#</th>
	<th>Classroom</th>
	<th class="center" >Q1</th>
	<th class="center" >Q2</th>
	<th class="center" >Q3</th>
	<th class="center" >Q4</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>

	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><input class="vc50" id="q1-<?php echo $i; ?>"  value="<?php echo $rows[$i]['conduct_q1']; ?>" /></td>
	<td><input class="vc50" id="q2-<?php echo $i; ?>"  value="<?php echo $rows[$i]['conduct_q2']; ?>" /></td>
	<td><input class="vc50" id="q3-<?php echo $i; ?>"  value="<?php echo $rows[$i]['conduct_q3']; ?>" /></td>
	<td><input class="vc50" id="q4-<?php echo $i; ?>"  value="<?php echo $rows[$i]['conduct_q4']; ?>" /></td>
	<td><button onclick="saveLocking(<?php echo $i; ?>);" id="btn-<?php echo $i; ?>" >Save</button></td>
		<input type="hidden" class="vc50" id="pkid-<?php echo $i; ?>"  value="<?php echo $rows[$i]['pkid']; ?>" />
</tr>
<?php endfor; ?>
</table>
</form>



<div class="ht100" ></div>

<script>

var gurl = "http://<?php echo GURL; ?>";
var sy 	 = "<?php echo $sy; ?>";


$(function(){
	// alert(gurl+sy);
	selectFocused();
	nextViaEnter();
	
})


function saveLocking(i){
	const pkid=$('#pkid-'+i).val();
	const q1=$('#q1-'+i).val();
	const q2=$('#q2-'+i).val();
	const q3=$('#q3-'+i).val();
	const q4=$('#q4-'+i).val();
	
	var vurl 	= gurl + '/ajax/xlocking.php';	
	var task	= "xeditLockingConduct";	
	var pdata = "task="+task+"&pkid="+pkid+"&q1="+q1+"&q2="+q2+"&q3="+q3+"&q4="+q4+"&sy="+sy;

	$.ajax({type: 'POST',url: vurl,data: pdata,success:function(){} });				

	
	
	
}	/* fxn */
	





</script>
