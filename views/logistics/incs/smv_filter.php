<?php 
	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$day_id = date('d',strtotime($_SESSION['today'])); 	
	$ldm  = date('Y-m-t');
	$today = $_SESSION['today'];
	$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));

?>

<form method="GET" >

<div class="screen" style="width:30%;float:left"  >	<!--  left -->
<table class="gis-table-bordered table-fx" >

<tr><th colspan=2 >
	<a class="txt-blue underline" onclick="fby();return false;" >Year</a>
	| <a class="txt-blue underline" onclick="fbm();return false;" >Month</a>
	| <a class="txt-blue underline" onclick="fbtoday();return false;" >Today</a>		
</th></tr>

<tr><th>Start</th><td><input id="start" class="pdl05 " type="date" name="start" 
	value="<?php echo (isset($_GET['start']))? $_GET['start']:$_SESSION['today']; ?>" /></td></tr>
<tr><th>End</th><td><input id="end" class="pdl05 " type="date" name="end" 
	value="<?php echo (isset($_GET['end']))? $_GET['end']:$_SESSION['today']; ?>" /></td></tr>			


<tr>
<th>Product</th>
<td>
	<input class="vc100 pdl05" id="part" />		
	<input type="submit" name="auto" value="Filter" onclick="xgetProductsByPart();return false;" />		
	<input class="vc50" name="prid" id="prid" />
</td>
</tr>

<tr>
	<th>Reference</th>
	<td><input name="reference" /></td>
</tr>

<tr>
<th>Source (FROM)</th>
<td>
	<?php if($_SESSION['user']['privilege_id']==0): ?>
		<select class="vc200" name="src" >
			<option value="0" >Choose</option>
			<?php foreach($terminals AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" 
				<?php echo ((isset($_GET['src'])) && ($sel['id']==$_GET['src']))? 'selected':NULL; ?> >						
				<?php echo 'T'.$sel['id'].' - Terminal '.ucfirst($sel['name']); ?></option>
			<?php endforeach; ?>
		</select>
	<?php else: ?>
		<select class="vc200" name="src" >
			<option value="<?php echo '0'; ?>" >Choose</option>
			<option value="<?php echo $t; ?>" ><?php echo 'T'.$t; ?></option>
		</select>
	<?php endif; ?>
</td>
</tr>


<tr>
<th>Destination (TO)</th>
<td>
	<?php if($_SESSION['user']['privilege_id']==0): ?>
		<select class="vc200" name="dest" >
			<option value="0" >Choose</option>
			<?php foreach($terminals AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" 
				<?php echo ((isset($_GET['dest'])) && ($sel['id']==$_GET['dest']))? 'selected':NULL; ?> >						
				<?php echo 'T'.$sel['id'].' - Terminal '.ucfirst($sel['name']); ?></option>
			<?php endforeach; ?>
		</select>
	<?php else: ?>
		<select class="vc200" name="dest" >
			<option value="<?php echo '0'; ?>" >Choose</option>
			<option value="<?php echo $t; ?>" ><?php echo 'T'.$t; ?></option>
		</select>
	<?php endif; ?>		
</td>
</tr>




</table>
</div>


<div class="third screen" >	<!--  left -->
<table class="gis-table-bordered table-fx" >
<tr>
<th colspan="" >Sort</th>
<td><?php $sorts = array(
	array('key'=>'smv.date','value'=>'Date'),
); ?>	
<select class="vc100" name="sort" >
	<?php foreach($sorts AS $sel): ?>
		<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort)? 'selected':NULL; ?> >
			<?php echo $sel['value']; ?></option>
	<?php endforeach; ?>
</select>

<select name="order" >
	<option value="DESC" <?php echo ($order=='DESC')? 'selected':NULL; ?> >DESC</option>
	<option value="ASC" <?php echo ($order=='ASC')? 'selected':NULL; ?> >ASC</option>
</select>		
</td>
</tr>


<tr><th>Page | Count</th><th>
	<input class="vc40" id="page" name="page" value="<?php echo $page; ?>"  />
	<input class="vc40" id="limits" name="limits" 
		value="<?php echo (isset($_POST['limits']))? $_POST['limits']:30; ?>"  />
<button onclick="nolimits();return false;" >All</button>
</th></tr>		


</table>
</div>

<p class="screen clear" ><br /><input type="submit" name="submit" value="Filter"  /></p>

</form>

<div id="names" >Names</div>


<div class="clear" ></div>


<!------------------------------------------------------>

<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';
var month_id = "<?php echo $month_id; ?>";
var year = "<?php echo $year; ?>";
var ldm  = "<?php echo $ldm; ?>";
var day_id = "<?php echo $day_id; ?>";
var tomorrow = "<?php echo $tomorrow; ?>";

$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });

})


function redirLookup(id){
	$('#prid').val(id);
}


</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


