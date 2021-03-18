<?php 
	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$ldm  = date('Y-m-t');

?>


<script>

var gurl = "http://<?php echo GURL; ?>";
var month_id = "<?php echo $month_id; ?>";
var year = "<?php echo $year; ?>";
var ldm  = "<?php echo $ldm; ?>";

$(function(){
	hd();
	

})

function fby(){
	var start = year+'-01-01';
	var end = year+'-12-31';
	$('#start').val(start);
	$('#end').val(end);
}

function fbm(){
	$('#start').val(year+'-'+month_id+'-01');
	$('#end').val(ldm);
}



</script>


<!---------------------------------------------------------------------------->

<h5>
	Schedules
	<span class="hd" >HD</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'schedules/add'; ?>" >Add</a>
	| <a href="<?php echo URL.'schedules/bulk'; ?>" >Bulk</a>
</h5>


<form method="POST" >
<div style="width:35%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >
	
	<tr><th colspan=2 >
		<a class="txt-blue underline" onclick="fby();return false;" >Year</a>
		| <a class="txt-blue underline" onclick="fbm();return false;" >Month</a>
	</th></tr>
	
	<tr><th>Date Range</th><td><input id="start" class="pdl05 " type="date" name="start" 
		value="<?php echo (isset($_POST['start']))? $_POST['start']:$_SESSION['today']; ?>" /> 	
		- <input id="end" class="pdl05 " type="date" name="end" 
		value="<?php echo (isset($_POST['end']))? $_POST['end']:$_SESSION['today']; ?>" />
	</td></tr>	
	
	<tr><th>Active</th><td>
	<input type="radio" name="is_active" value="1" <?php echo (isset($_POST['is_active']) && $_POST['is_active']==1)? 'checked':NULL; ?> />Yes
	| <input type="radio" name="is_active" value="0" <?php echo (isset($_POST['is_active']) && $_POST['is_active']==0)? 'checked':NULL; ?> />No
	| <input type="radio" name="is_active" value="2" <?php echo (isset($_POST['is_active']) && $_POST['is_active']==2)? 'checked':NULL; ?> />All
	</td></tr>	

	<tr><th>Important</th><td>
	<input type="radio" name="is_impt" value="1" <?php echo (isset($_POST['is_impt']) && $_POST['is_impt']==1)? 'checked':NULL; ?> />Yes
	| <input type="radio" name="is_impt" value="0" <?php echo (isset($_POST['is_impt']) && $_POST['is_impt']==0)? 'checked':NULL; ?> />No
	| <input type="radio" name="is_impt" value="2" <?php echo (isset($_POST['is_impt']) && $_POST['is_impt']==2)? 'checked':NULL; ?> />All
	</td></tr>	

	<tr><th>Recurring</th><td>
<input type="radio" name="is_recursive" value="1" <?php echo (isset($_POST['is_recursive']) && $_POST['is_recursive']==1)? 'checked':NULL; ?> />Yes
| <input type="radio" name="is_recursive" value="0" <?php echo (isset($_POST['is_recursive']) && $_POST['is_recursive']==0)? 'checked':NULL; ?> />No
| <input type="radio" name="is_recursive" value="2" <?php echo (isset($_POST['is_recursive']) && $_POST['is_recursive']==2)? 'checked':NULL; ?> />All
	</td></tr>	
	
	
<?php if($is_admin): ?>		
	<tr><th>Group ID</th><td><input class="pdl05" type="text" name="room_id" 
		value="<?php echo (isset($_POST['room_id']))? $_POST['room_id']:NULL; ?>" /></td></tr>
<?php endif; ?>
	<tr><th>Event</th><td><input class="pdl05" type="text" name="event" 
		value="<?php echo (isset($_POST['event']))? $_POST['event']:NULL; ?>" /></td></tr>
		

</table>
</div>

<div class="half" >
<table class="gis-table-bordered table-fx table-altrow" >

<?php $sorts = array(
	array('key'=>'s.date','value'=>'Date'),
	array('key'=>'r.name','value'=>'Group'),
); ?>



	<tr><th>Sort | Order</th><td>
		<select name="sort" >
			<?php $sort_key = (isset($_POST['sort']))? $_POST['sort']:'p.datetime'; ?>
			<?php foreach($sorts AS $sel): ?>
				<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort_key)? 'selected':NULL; ?> >
					<?php echo $sel['value']; ?></option>
			<?php endforeach; ?>
	
		</select>

		<select name="order" >
			<option value="DESC">DESC</option>
			<option value="ASC" <?php echo (isset($_POST['order']) && $_POST['order']=='ASC')? 'selected':NULL; ?>  >ASC</option>
		</select>		
	</td></tr>
	<tr><th>Records / Page </th><td><input class="pdl05" type="number" name="limits" 
		value="<?php echo (isset($_POST['limits']))? $_POST['limits']:LIMITS; ?>" /></td></tr>
	<tr><th>Page</th><td><input class="pdl05" type="number" name="page" 
		value="<?php echo (isset($_POST['page']))? $_POST['page']:1; ?>"	/></td></tr>


		
	<tr><th colspan=2 >
		<input type="submit" name="submit" value="Generate" />	
		<input type="submit" name="cancel" value="Clear" />					
	</th></tr>


</table>
</div>


</form>



<div class="clear"><br /></div>
<!---------------------------------------------------------------------------->

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Date</th>
	<th>Event</th>
	<th>Owner</th>
	<th>Group</th>
	<th>Active</th>
	<th>Impt</th>
	<th>Recur</th>
	<th></th>
</tr>


<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><input class="pdl05" type="date" name="posts[<?php echo $i; ?>][date]" value="<?php echo $rows[$i]['date']; ?>" /></td>	
		<td><input class="pdl05" type="" name="posts[<?php echo $i; ?>][event]" value="<?php echo $rows[$i]['event']; ?>" /></td>			
		<td><?php echo $rows[$i]['owner']; ?></td>
		<td><?php echo $rows[$i]['room']; ?></td>
		<td><input class="center" type="number" min=0 max=1 name="posts[<?php echo $i; ?>][is_active]" 
			value="<?php echo $rows[$i]['is_active']; ?>" ></td>
		<td><input class="center" type="number" min=0 max=1 name="posts[<?php echo $i; ?>][is_impt]" 
			value="<?php echo $rows[$i]['is_impt']; ?>" ></td>
		<td><input class="center" type="number" min=0 max=1 name="posts[<?php echo $i; ?>][is_recursive]" 
			value="<?php echo $rows[$i]['is_recursive']; ?>" ></td>						
		<td>
			<?php if($_SESSION['pcid']==$rows[$i]['owner_pcid']): ?>
				<a href='<?php echo URL."schedules/edit/".$rows[$i]['id']; ?>' >Edit</a>
				| <a href='<?php echo URL."schedules/delete/".$rows[$i]['id']; ?>' onclick="return confirm('Dangerous! Sure?');" >DEL</a>
			<?php endif; ?>
		</td>	
	</tr>
	<input type="hidden" name="posts[<?php echo $i; ?>][owner_pcid]" value="<?php echo $rows[$i]['owner_pcid']; ?>" />	
	<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>" />	
<?php endfor; ?>

</table>

<p>
	<input type="submit" name="save" value="Save"  />
	
</p>



</form>