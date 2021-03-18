<?php 

// pr($data);
// $bs=2015;


// pr($_SESSION['q']);
$dbg=VCPREFIX.$sy.US.DBG;
$dbtable="{$dbg}.05_classrooms";

?>


<h5>
	Classroom Links | <?php $this->shovel('homelinks'); ?>
	

	
</h5>

<p><?php require_once(SITE.'/views/elements/filter_redirect.php'); ?></p>


<?php if($crid): ?>
<table class="gis-table-bordered" >
	<tr>
		<td><?php echo $classroom['id']; ?></td>
		<td><?php echo $classroom['name']; ?></td>
	</tr>
</table><br />

<table class="gis-table-bordered" >
<tr><td><a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>' >Classlist</a></td></tr>
<tr><td><a href='<?php echo URL."attendance/monthly/$crid/$sy".$row["crid"]."/$sy/$qtr"; ?>' >Attendance</a></td></tr>
<tr><td><a href='<?php echo URL."promotions/k12/$crid"; ?>' >Promotions</a></td></tr>
<tr><td><a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>' >Matrix</a></td></tr>



<?php if($_SESSION['settings']['has_axis']): ?>
	<tr><td><a href='<?php echo URL."assessment/assess/$scid"; ?>' >Assessment</a></td></tr>
	<tr><td><a href='<?php echo URL."ledgers/pay/$scid"; ?>' >Ledger</a></td></tr>
<?php endif; ?>

</table>


<?php endif; ?>	<!-- crid -->

<div class="clear ht50" ></div>





<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var qtr = "<?php echo $qtr; ?>";
var limits='20';
var dbtable="<?php echo $dbtable; ?>";

$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})



function axnFilter(id){
	var url = gurl+"/cir/links/"+id+"/"+sy+"/"+qtr;	
	window.location = url;		
}



</script>

