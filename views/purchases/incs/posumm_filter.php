<?php
// pr($employees);

// pr($_POST['ccid']);


?>


<form method="GET" >

<div class="screen" style="width:25%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >
	
	<tr><th colspan=2 >
		<a class="txt-blue underline" onclick="fby();return false;" >Year</a>
		| <a class="txt-blue underline" onclick="fbm();return false;" >Month</a>
		| <a class="txt-blue underline" onclick="fbtoday();return false;" >Today</a>		
		| <a class="txt-blue underline" onclick="fbdate();return false;" >Date</a>		
	</th></tr>
	<tr><th>Start</th><td><input id="start" class="pdl05 " type="date" name="start" 
		value="<?php echo (isset($_GET['start']))? $_GET['start']:$_SESSION['today']; ?>" /></td></tr>
	<tr><th>End</th><td><input id="end" class="pdl05 " type="date" name="end" 
		value="<?php echo (isset($_GET['end']))? $_GET['end']:$_SESSION['today']; ?>" /></td></tr>			

</table>
<br />
</div>

<div class="screen" style="width:30%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >

	<tr><th>Supplier</th><td>
		<select class="vc150" name="suppid" >
			<option value="" >Supplier</option>
			<?php foreach($suppliers AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" 
					<?php echo (isset($_POST['suppid']) && $_POST['suppid']==$sel['id'])? 'selected':NULL; ?>
				><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>					
	</td></tr>			
	<tr><th>Comm </th><td><input name="comm" class="pdl05 vc150" 
	value="<?php echo (isset($_POST['comm']))? $_POST['comm']:NULL; ?>" /></td></tr>
	
</table>

</div>




<div class="screen" style="float:left;width:25%" >
<table class="gis-table-bordered table-fx table-altrow" >

<?php $sorts = array(
	array('key'=>'s.name,pr.name','value'=>'Supplier'),
); ?>



	<tr><th>Sort | Order</th><td>
		<select name="sort" class="vc80" >
			<?php $sort_key = (isset($_POST['sort']))? $_POST['sort']:'p.date'; ?>
			<?php foreach($sorts AS $sel): ?>
				<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort_key)? 'selected':NULL; ?> >
					<?php echo $sel['value']; ?></option>
			<?php endforeach; ?>
	
		</select>

		<select name="order" >
			<option value="ASC">ASC</option>
			<option value="DESC" 
				<?php echo (isset($_POST['order']) && $_POST['order']=='DESC')? 'selected':NULL; ?>  >DESC</option>
		</select>		
	</td></tr>
	<tr><th>Count | Page </th><td><input id="limits" class="vc80" type="number" name="limits" 
		value="<?php echo (isset($_POST['limits']))? $_POST['limits']:'0'; ?>" />
		<input id="page" class="pdl05 vc50" type="number" name="page" 	
				value="<?php echo (isset($_POST['page']))? $_POST['page']:1; ?>"	/>		
		<button onclick="zeroOut('limits');return false;" >All</button></td>
	</tr>
		
	

</table>
</div>

<div class="clear screen" >
	<input type="submit" name="submit" value="Filter" accesskey="g" />	
	<input type="submit" name="cancel" value="Clear" />					
</div>

</form>

<div class="hd" id="names" >names</div>

