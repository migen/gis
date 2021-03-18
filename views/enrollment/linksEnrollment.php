<?php 

// pr($data);
// $bs=2015;



?>


<h5>
	Enrollment Links | <?php $this->shovel('homelinks'); ?>

	

<?php 
	$d['sy']=$sy;$d['repage']="enrollment/links/$scid";
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

<h4>Student</h4>
<table class="gis-table-bordered" >
<tr><td class="vc200" >
	<a href='<?php echo URL."profiles/scid/$scid"; ?>' >Profile</a>
	| <a href='<?php echo URL."students/datasheet/$scid"; ?>' >Datasheet</a>
</td></tr>

<tr><td class="vc200" >
	<a href='<?php echo URL."enrollment/ledger/$scid/$sy"; ?>' >Ledger2</a>
	| <a href='<?php echo URL."students/datasheet/$scid"; ?>' >Datasheet</a>
</td></tr>




<tr><td>
	<a href='<?php echo URL."students/enrollment/$scid"; ?>' >Enrollment</a>
	| <a href='<?php echo URL."students/sectioner/$scid/$sy"; ?>' >Sectioner</a>
</td></tr>
	<?php if($level_id>15): ?>
		<tr><td><a href='<?php echo URL."enlistment/scid/$scid"; ?>' >Enlistment - NA</a></td></tr>
	<?php else: ?>
		<tr><td><a href='<?php echo URL."subjects/scid/$scid"; ?>' >Subjects - NA</a></td></tr>
	<?php endif; ?>

	<tr><td>
		  <a href='<?php echo URL."photos/one/$scid"; ?>' >Photo</a>
		| <a href='<?php echo URL."rfid/one/$scid"; ?>' >RFID</a>	
	</td></tr>




</table>



<h4>Classroom</h4>
<table class="gis-table-bordered" >
<tr><td class="vc200" >
	<a href='<?php echo URL."matrix/grades/".$row["crid"]."/$sy/$qtr"; ?>' >Matrix</a>
</td></tr>
<tr><td><a href='<?php echo URL."classlists/classroom/".$row["crid"]; ?>' >Classlist</a></td></tr>
<tr><td><a href='<?php echo URL."promotions/k12/".$row["crid"]; ?>' >Promotions</a></td></tr>

</table>
<?php endif; ?>	<!--  scid -->


<div class="clear ht50" ></div>





<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var limits='20';
// var lady=charmee();


	$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/enrollment/links/'+ucid;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
