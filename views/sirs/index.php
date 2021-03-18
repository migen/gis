<h5>
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."poster/productEnum/$product_id?start=$start&end=$end"; ?>'>Details</a>
	| <a href="<?php echo URL.'pos'; ?>">Sales</a>
	| <a href="<?php echo URL.'pos/add'; ?>">Add</a>
	| <a href="<?php echo URL.'bills/loadingReport'; ?>">Loading</a>
	| <a href="<?php echo URL.'products/index'; ?>">Inventory</a>


</h5>


<!----------------------- pos ------------------------------------------------------------->

<table class="gis-table-bordered table-fx table-altrow" >
<tr><th class="headrow white vc200" > Menu </th></tr>

<tr><td> <a href='<?php echo URL."pos/add"; ?>' >POS</a></td></tr>







<tr><td> 
<select class="vc200" onchange="looper('teachers,profiling,'+this.value+','+sy+','+qtr);" >
	<option value="0">Profiling</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>



<tr><td> <a href='<?php echo URL."registrars/sxns"; ?>' >All Students</a></td></tr>
<tr><td> <a href='<?php echo URL."speed/informant"; ?>' >Informant</a></td></tr>
<tr><td> <a href='<?php echo URL."registrars/reporter "; ?>' > Reporter - Draft </a></td></tr>	<!-- gcontroller -->

<tr><td><a href="<?php echo URL.'registrars/registration'; ?>" > Registration (Student) </a></td></tr>
<tr><td><a href="<?php echo URL.'students/sectioner'; ?>" > Sectioner (Student) </a></td></tr>
<tr><td><a href="<?php echo URL.'contacts/ucis'; ?>" > UCIS / Profile </a></td></tr>


<tr><td> 
<input id="status" type="text" class="pdl05 vc200" placeholder="ID# Status" />
 &nbsp; <button onclick="redirStatus('registrars');" >Go</button>
</td></tr>

<!--
	<tr><td> <a href="<?php echo URL.'registrars/notes'; ?>" >Notes </a> </td></tr>
-->

</table>


<div class="ht100" ></div>



<!------------------------ axis clerk ------------------------------------------------------------>




<!------------------------ finance officer / treasurer ------------------------------------------------------------>



<!------------------------ etc ------------------------------------------------------------>


<script>

	var gurl  = "http://<?php echo GURL; ?>";	
	var home  = "<?php echo $home; ?>";
	
	$(function(){
		hd();
		alert(gurl+', home: '+home);
	
	})
	
	

	
	

	
/* ------------------------------------------------ */


	
	
	
</script>



