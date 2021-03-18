<?php 

// pr($data);
// $bs=2015;



?>


<h5>
	College Student
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'students/filter'; ?>">Filter</a>
	<?php if($scid): ?>
		| <a href='<?php echo URL."students/edit/$scid"; ?>'>Edit</a>
	<?php endif; ?>
	

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


<h4>Student</h4>
<table class="gis-table-bordered" >
<tr><td><a href="<?php echo URL.'students/edit/'.$scid; ?>" >Edit SY</a></td></tr>
<tr><td class="vc200" ><a href='<?php echo URL."crcards/student/$scid"; ?>' >College Rpt Card</a>
	<?php for($is=$csy;$is<DBYR;$is++): ?>
		| <a href='<?php echo URL."rcards/scid/$scid/$is/4"; ?>' ><?php echo $is; ?></a>
	<?php endfor; ?>
</td></tr>
<tr><td><a href='<?php echo URL."attendance/$attdpage/$scid"; ?>' >Attendance</a></td></tr>
<tr><td><a href='<?php echo URL."college/grades/$scid?all"; ?>' >College Grades</a></td></tr>
<tr><td><a href='<?php echo URL."grades/student/$scid?all"; ?>' >BED Grades</a></td></tr>
<tr><td><a href='<?php echo URL."cav/go/$scid"; ?>' >Traits</a></td></tr>
<tr><td><a href='<?php echo URL."profiles/student/$scid"; ?>' >Profile</a></td></tr>
<tr><td><a href='<?php echo URL."contacts/ucis/$scid"; ?>' >UCIS</a></td></tr>
<tr><td><a href='<?php echo URL."summarizers/student/$scid"; ?>' >Summarizer</a></td></tr>
<tr><td><a href='<?php echo URL."summary/edit/$scid"; ?>' >Summary/Promotion</a></td></tr>
<tr><td><a href='<?php echo URL."photos/one/$scid"; ?>' >Photo</a></td></tr>
<tr><td><a href='<?php echo URL."students/sectioner/$scid"; ?>' >Sectioner</a></td></tr>
<tr><td><a href='<?php echo URL."promotions/student/$scid"; ?>' >Promotions</a></td></tr>
<tr><td><a href='<?php echo URL."codename/one/$scid"; ?>' >Code Name</a></td></tr>

<?php if($_SESSION['settings']['has_axis']): ?>
<tr><td><a href='<?php echo URL."assessment/assess/$scid"; ?>' >Assessment</a></td></tr>
<tr><td><a href='<?php echo URL."ledgers/pay/$scid"; ?>' >Ledger</a></td></tr>
<?php endif; ?>

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
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/college/student/'+ucid;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
