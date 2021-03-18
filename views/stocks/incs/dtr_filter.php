
<p>
<table class="screen gis-table-bordered" >
<tr>
	<th>Terminal</th>
	<td><input class="vc50 center" type="number" name="terminal" id="terminal"
		value="<?php echo (isset($terminal))? $terminal:1; ?>" <?php echo ($admin)? NULL:'readonly'; ?> /></td>
	<th>Ecid</th>
	<td><input class="vc70 center" 
		value="<?php echo (isset($ecid))? $ecid:1; ?>" <?php echo ($admin)? NULL:'readonly'; ?> /></td>				

</tr>

<tr>
	<th>Start</th>
	<td><input class="pdl05" type="date" id="start" 
		value="<?php echo (isset($_GET['start']))? $_GET['start']:$today; ?>" /></td>
	<th>End</th>
	<td><input class="pdl05" type="date" id="end" 
		value="<?php echo (isset($_GET['end']))? $_GET['end']:$today; ?>" /></td>	
		
</tr>

<tr>
		
	<td>
		<select id="paid" >
			<option value="0" >All</option>
			<option value="1" <?php echo (isset($_GET['paid']) && $_GET['paid']==1)? 'selected':NULL; ?> >Paid</option>
		</select>
	</td>		
	<td>
	<?php if($admin): ?>
		<select id="ecid" class="vc200"  >
		<option value="0" >All Employees</option>
		<?php foreach($cashiers AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
				<?php echo (isset($_GET['ecid']) && ($_GET['ecid']==$sel['id']))? 'selected':NULL; ?>
			><?php echo $sel['name'].' #'.$sel['id']; ?></option>
		<?php endforeach; ?>
		</select>
	<?php else: ?>
		<select id="ecid" ><option value="<?php echo $ecid; ?>" ><?php echo $_SESSION['user']['code']; ?></option></select>
	<?php endif; ?>
	</td>		
	<th colspan="" >	
		SY</th><th><input id="sy" class="pdl05 vc70" type="number" name="sy"  value="<?php echo $sy; ?>" />	
		&nbsp; &nbsp; 
		<a class="txt-blue u" onclick="redirUrl();" >Go</a></th>		
	
</tr>

</table>
</p>

<?php if($admin): ?>
<p class="screen" >*Note - Set value=0 to exclude that condition, example ecid=0 to get combined sales of employees of a specific terminal.</p>
<?php endif; ?>

<div class="hd" id="names" > </div>



<!-------------------------------------------------------------->
<script>
var gurl = 'http://<?php echo GURL; ?>';

$(function(){

})



function redirUrl(){
	var ecid = $('#ecid').val();
	var start = $('#start').val();
	var end = $('#end').val();
	var trml = $('#terminal').val();
	var paid = $('#paid').val();
	var sy = $('#sy').val();
	var url = gurl+'/stocks/dtr?start='+start+'&end='+end+'&terminal='+trml+'&ecid='+ecid+'&paid='+paid+'&sy='+sy;
	window.location=url;
}	/* fxn */




</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>