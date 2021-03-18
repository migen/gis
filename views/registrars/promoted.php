<?php 
$sy = $_SESSION['sy'];
$next_year = $sy + 1;


// pr($data);
// pr($boys);

$dc_today = date_create(date('Y-m-d'));
$this->shovel('age');


?>

<h5>
	Promotions | 
	<a href="<?php echo URL; ?>teachers">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'registrars/promoted/'.$crid.DS.$sy; ?>">Now</a>
	| <a href="<?php echo URL.'registrars/promoted/'.$crid.DS.$next_year; ?>">Nxt</a>
	
</h5>



<?php 



// pr($data);



$cr 		= $data['classroom'];
$boys 		= $data['boys'];
$num_boys	= $data['num_boys'];

$girls 		= $data['girls'];
$num_girls	= $data['num_girls'];


$dc_today = date_create(date('Y-m-d'));
$this->shovel('age');


?>


<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>CrID</th><td><?php echo $cr['crid']; ?></td></tr>
	<tr><th class='white headrow'>Level</th><td><?php echo $cr['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $cr['section']; ?></td></tr>
	<tr><th class='white headrow'>School Year</th><td><?php echo $sy .' - ' .($sy + 1); ?></td></tr>
</table>

<br />

<form method="POST" >

<!-- ================================================================================ -->

<h2> Profile Boys </h2>

<table class="gis-table-bordered table-fx boys" >
<tr class="headrow" >
	<th>#</th>
	<th class="hd" >CID</th>
	<th class="hd" >PCR</th>
	<th class="vc200" >Student</th>
	<th> 1-M<br />0-F </th>
	<th class="vc100" > Birthdate </th>
	<th class="center" > Age </th>
	<th> 1-P<br />0-NP</th>	
	<th class="center" > Edit </th>	
		
</tr>

<?php for($i=0;$i<$num_boys;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $boys[$i]['scid']; ?></td>
	<td class="hd" ><?php echo $boys[$i]['pcr_id']; ?></td>
	<td class="vc200" ><?php echo $boys[$i]['student'].'<br />'.$boys[$i]['student_code']; ?></td>
	<td> 1 </td>
	<td> <?php $bday = date('M-d-Y',strtotime($boys[$i]['birthdate'])); echo $bday; ?> </td>
	<td> <?php echo $boys[$i]['age']; ?> </td>
	<td> <?php echo $boys[$i]['is_finalized'];  ?> </td>
	<td> <a href="<?php echo URL.'registrars/editPromotion/'.$boys[$i]['scid']; ?>" > edit </a> </td>
		
	<!-- hidden scid -->
	<input type="hidden" name="data[profiles][<?php echo $i; ?>][scid]" value="<?php  echo $boys[$i]['scid']; ?>" >
</tr>
<?php endfor; ?>
</table>

<br /><hr /><br />
<!-- ================================================================================ -->

<h2> Profile Girls </h2>

<table class="gis-table-bordered table-fx boys" >
<tr class="headrow" >
	<th>#</th>
	<th class="hd" >CID</th>
	<th class="hd" >PCR</th>
	<th class="vc200" >Student</th>
	<th> 1-M<br />0-F </th>
	<th class="vc100" > Birthdate </th>
	<th class="center" > Age </th>
	<th> 1-P<br />0-NP</th>	
	<th class="center" > Edit </th>	
		
</tr>

<?php $j = $num_boys; ?>
<?php for($i=0;$i<$num_girls;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $girls[$i]['scid']; ?></td>
	<td class="hd" ><?php echo $girls[$i]['pcr_id']; ?></td>
	<td class="vc200" ><?php echo $girls[$i]['student'].'<br />'.$girls[$i]['student_code']; ?></td>
	<td> 1 </td>
	<td> <?php $bday = date('M-d-Y',strtotime($girls[$i]['birthdate'])); echo $bday; ?> </td>
	<td> <?php echo $girls[$i]['age'];  ?> </td>
	<td> <?php echo $girls[$i]['is_finalized'];  ?> </td>
	<td> <a href="<?php echo URL.'registrars/editPromotion/'.$girls[$i]['scid']; ?>" > edit </a> </td>
		
	<!-- hidden scid -->
	<input type="hidden" name="data[profiles][<?php echo $j; ?>][scid]" value="<?php  echo $girls[$i]['scid']; ?>" >
</tr>
<?php endfor; ?>
</table>


<!-- ================================================================================ -->

<br /><hr />

<?php 
	// $prep = $data['prep']; 

	$d['num_boys'] 	= $num_boys;
	$d['num_girls'] = $num_girls;
	$d['prep'] = $prep;
	
?>

<?php $this->shovel('prep',$d); ?>


<!-- 
	<br /><input type="submit" name="submit" value="Update" />
-->

<!-- ====== HIDDEN INPUTS   ======= -->
<!-- sy,crid,-->
<input type="hidden" name="data[crid]" value="<?php echo $data['crid']; ?>" >
<input type="hidden" name="data[sy]" value="<?php echo $sy; ?>" >
<input type="hidden" name="data[next_year]" value="<?php echo ($sy+1); ?>" >


<?php 

?>



</form>



<script>

$(function(){
	nextViaEnter();
})


function tally(cls,dv){
	var numcls=0;
	$('.'+cls).each(function(){
		if(this.value == dv) numcls+=1;		
	});
	$('.t'+cls).val(numcls);	
}

function tallyall(cls){
	var numcls=0;
	$('.'+cls).each(function(){
		numcls+=1;		
	});
	$('.t'+cls).val(numcls);	
}


function sum(cls){
	var sumcls=0;
	$('.'+cls).each(function(){
		sumcls+=parseInt(this.value);		
	});
	$('.t'+cls).val(sumcls);	
}


function ave(cls){
	var sumcls=0;
	var numcls=0;
	var avecls=0;
	$('.'+cls).each(function(){
		numcls++;
		sumcls+=parseInt(this.value);		
	});
	avecls = sumcls / numcls;
	$('.a'+cls).val(avecls.toFixed(2));	
}

function populateColumn(cls){
	var inVal = $("#i"+cls).val();
	$("."+cls).val(inVal);		
};



</script>