<?php 

// pr($data);
// pr($attmos);

?>


<h3>
	Attendance Quarterly by Student | SY <?php echo $sy; ?> - 
	<?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'attendance/student/'.$scid.DS.$sy.DS.$qtr; ?>" >Monthly</a>
	| <a href='<?php echo URL."conducts/editOne/$scid/$sy/$qtr"; ?>' >Conduct</a>	
	
	
<?php 
	$d['sy']=$sy;$d['repage']="attendance/studentQtr/$scid";
	$this->shovel('sy_selector',$d); 
?>	
	
</h3>


<?php 
	$dbo=PDBO;
	$dbcontacts="{$dbo}.00_contacts";
	
?>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID / Name</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Filter" onclick='getDataByTable(dbcontacts,30);return false;' />		
	</td></tr>
	
</table></p>

<div id="names" >names</div>


<p><?php echo $attendance['student']; ?></p>


<form method="POST" >

<table class="gis-table-bordered table-altrow table-fx" >

<tr class="headrow" >
	<th>Period</th>
	<th>Total</th>
	<th>Present</th>
	<th>Tardy</th>
</tr>

<tr>
	<th>Q1</th>
	<td><?php echo $attmos['q1_days_total']+0; ?></td>
	<td><input onchange="tallyAttd('pres');" class="pres vc50 center" tabIndex=2
		name="q1_days_present" value="<?php echo $attendance['q1_days_present']+0; ?>" /></td>
	<td><input onchange="tallyAttd('tar');" class="tar vc50 center" tabIndex=4
		name="q1_days_tardy" value="<?php echo $attendance['q1_days_tardy']+0; ?>" /></td>
</tr>

<tr>
	<th>Q2</th>
	<td><?php echo $attmos['q2_days_total']+0; ?></td>
	<td><input onchange="tallyAttd('pres');" class="pres vc50 center" tabIndex=2
		name="q2_days_present" value="<?php echo $attendance['q2_days_present']+0; ?>" /></td>
	<td><input onchange="tallyAttd('tar');" class="tar vc50 center" tabIndex=4
		name="q2_days_tardy" value="<?php echo $attendance['q2_days_tardy']+0; ?>" /></td>
</tr>

<tr>
	<th>Q3</th>
	<td><?php echo $attmos['q3_days_total']+0; ?></td>
	<td><input onchange="tallyAttd('pres');" class="pres vc50 center" tabIndex=2
		name="q3_days_present" value="<?php echo $attendance['q3_days_present']+0; ?>" /></td>
	<td><input onchange="tallyAttd('tar');" class="tar vc50 center" tabIndex=4
		name="q3_days_tardy" value="<?php echo $attendance['q3_days_tardy']+0; ?>" /></td>
</tr>

<tr>
	<th>Q4</th>
	<td><?php echo $attmos['q4_days_total']+0; ?></td>
	<td><input onchange="tallyAttd('pres');" class="pres vc50 center" tabIndex=2
		name="q4_days_present" value="<?php echo $attendance['q4_days_present']+0; ?>" /></td>
	<td><input onchange="tallyAttd('tar');" class="tar vc50 center" tabIndex=4
		name="q4_days_tardy" value="<?php echo $attendance['q4_days_tardy']+0; ?>" /></td>
</tr>

<tr>
	<th>Total</th>
	<td><?php echo $attmos['q5_days_total']+0; ?></td>
	<td><input class="tpres vc50 center" tabIndex=2
		name="total_days_present" value="<?php echo $attendance['total_days_present']+0; ?>" /></td>
	<td><input class="ttar vc50 center" name="total_days_tardy" 
		value="<?php echo $attendance['total_days_tardy']+0; ?>" /></td>
</tr>


</table>

<p>
	<input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');" />	
	<button><a href='<?php echo URL."attendance/monthly/$crid"; ?>' >Class</a></button>
</p>

</form>


<script>

var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var qtr = "<?php echo $qtr; ?>";
const dbcontacts = "<?php echo $dbcontacts; ?>";


$(function(){
	selectFocused();
	nextViaEnter();
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();


})


function tallyAttd(pt){
	var total=0;
	$('.'+pt).each(function(){
		var val=parseFloat($(this).val());
		total+=val;	
	})		
	$('.t'+pt).val(total);
	
	
}	/* fxn */


function axnFilter(id){
	var url=gurl+"/attendance/studentQtr/"+id+"/"+sy+"/"+qtr;
	window.location=url;
}



</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
