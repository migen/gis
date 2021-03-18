<?php 

// pr($data);
// $bs=2015;



?>


<h5>
	Expired Student Finder
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'xaxis/finder'; ?>">Finder</a>

<?php 
	$d['sy']=$sy;$d['repage']="students/links/$scid";
	$this->shovel('sy_selector',$d); 
?>	

	
</h5>

<?php if($scid): ?>
<table class="gis-table-bordered" >
	<tr>
		<td><?php echo $row['id']; ?></td>
		<td><?php echo $row['code']; ?></td>
		<td><?php echo $row['name']; ?></td>	
		<td><?php echo $row['classroom']; ?> | #<?php echo $row['crid']; ?></td>	
	</tr>
</table>
<?php endif; ?>

<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>


<div id="names" >names</div>


<?php if($scid): ?>
<?php 
	$attdpage=($_SESSION['settings']['attd_qtr']==1)? "studentQtr":"student";
	$csy=$row['csy'];	
	$csy=($csy>2015)? $csy:DBYR;
	
	
?>


<table class="gis-table-bordered" >
<tr><th class="vc200" >Student</th></tr>
<tr><td><a href='<?php echo URL."xaxis/assessment/$scid"; ?>' >xAssessment</a></td></tr>
<tr><td><a href='<?php echo URL."assessment/assess/$scid"; ?>' >Assessment</a></td></tr>
<tr><td><a href='<?php echo URL."xaxis/ledger/$scid"; ?>' >xLedger</a></td></tr>
<tr><td><a href='<?php echo URL."ledgers/pay/$scid"; ?>' >Ledger</a></td></tr>

</table>



<h4>Classroom</h4>
<?php // pr($row); ?>
<table class="gis-table-bordered" >
<tr><td class="vc200" >
	<a href='<?php echo URL."matrix/grades/".$row["crid"]."/$sy/$qtr"; ?>' >Matrix</a>
	<?php if($current): ?>
<!-- 
		| <a href='<?php // echo URL."matrix/grades/".$row["prevcrid"]."/$prevsy/4"; ?>' ><?php echo $prevsy; ?></a>	

-->
	<?php endif; ?>
</td></tr>
<tr><td><a href='<?php echo URL."attendance/monthly/".$row["crid"]."/$sy/$qtr"; ?>' >Cls Attd</a></td></tr>
<tr><td><a href='<?php echo URL."classlists/classroom/".$row["crid"]; ?>' >Classlist</a></td></tr>
<tr><td><a href='<?php echo URL."promotions/k12/".$row["crid"]; ?>' >Promotions</a></td></tr>

</table>
<?php endif; ?>


<div class="clear ht50" ></div>





<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var limits='20';
// var lady=charmee();


$(function(){
	// alert(lady);
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/xaxis/finder/'+ucid;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
