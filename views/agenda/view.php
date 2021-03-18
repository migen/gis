<?php 

// pr($_SESSION['q']);
// pr($data);

// pr($_SESSION['room'][$room_id]['members']);



?>

<h5> 
	<?php print($room['name']); ?>
	| <a href="<?php echo URL.'agenda/view/1?room='.$room_id.'&status=active'; ?>" >Active</a>
	| <span class="txt-blue underline" onclick="tracehd();" >Members</span>
	| <a href="<?php echo URL.'rooms'; ?>" >My Circles</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	
</h5>

<p class="vc800 hd" >
	<?php foreach($members AS $row): ?>
		<?php echo $row['name'].'&nbsp;'; ?> 
	<?php endforeach; ?>
</p>


<!------------------------------------------------------------------------------------------------------->

<p>
<form method='GET' >
	<input type="hidden" name="room" value="<?php echo $room_id; ?>" />

<table class="gis-table-bordered" >
<tr class="headrow" ><th>Sort</th><th>Order</th><th># Rows</th><th>Page</th><th>Status</th>
	<th>Public</th>
<th>Agenda</th><th>&nbsp;</th></tr>
<tr>
	<td>
		<select name="sort" >
			<option value="" >--</option>		
			<option value="a.date">Date</option>
			<option value="a.status">Status</option>
			<option value="a.is_public">Public</option>
			<option value="a.agenda">Agenda</option>
		</select>
	</td>	
	<td>
		<select name="order" >
			<option value="" >--</option>		
			<option value="ASC" >Asc</option>
			<option value="DESC" <?php $order = (isset($_SESSION['get']['order']) && ($_SESSION['get']['order']=='DESC'))? true:false; echo ($order)? 'selected': null; ?> >Desc</option>
		</select>
	</td>		
	<td><input class="pdl05 vc50" type='number' name='numrows' value="<?php echo (isset($_SESSION['get']['numrows']))? $_SESSION['get']['numrows']:''; ?>" /></td>		
	<td><input id="cpage" class="vc50 pdl05" type="number" name="page" value="1" /></td>	

	<td>
		<select name="status" >
			<option value="" >--</option>		
			<?php foreach($statuses AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"  > <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>
	</td>		

	
	<td>
		<select name="public" >
			<option value="" >--</option>
			<option value="1" >Public</option>
			<option value="0" >Private</option>
		</select>
	</td>		

	<td><input class="pdl05 vc80" id='eztext' type='text' name='agenda' placeholder="Agenda" /></td>	
	<td><input onclick="setPage();" type='submit' name='submit' value='Filter'></td>		
</tr>
</table>
</form>
</p>











<!------------------------------------------------------------------------------------------------------->


<form method="POST" >
<table class="gis-table-bordered table-fx"  >
<tr class="headrow" >
<th>&nbsp;</th> 	<!-- tickbox -->
	<th>#</th>
	<th class="vc300" >Report</th>
	<th class="vc100" >Status</th>
	<th class="vc100" >User</th>
	<th class="vc60" >Public</th>

</tr>

<?php for($i=0;$i<$numrows;$i++): ?>
<?php $owner = ($user['ucid']==$agenda[$i]['ucid'])? true:false; ?>

<tr>
	<td><input type="checkbox" value="<?php echo $agenda[$i]['aid']; ?>" /> </td>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $agenda[$i]['agenda']; ?></td>
	<td><?php echo $agenda[$i]['status']; ?></td>
	<td><?php echo $agenda[$i]['user']; ?></td>
	<td><?php echo ($agenda[$i]['is_public']==1)? 'Y':'-'; ?></td>
	
	<td><?php if($mis || $owner): ?>
		<a href='<?php echo URL."agenda/edit/".$agenda[$i]['aid']; ?>' >Edit</a>
		<?php endif; ?>
	</td>
</tr>
<?php endfor; ?>
</table>


</form>



<p>
	<!-- pagination -->
	<?php  // if(isset($num_pages) && $num_pages){ echo $data['pages']; } ?>
	<?php   echo $data['pages'];  ?>
</p>


<!-- --------------------------------------------------------------------------------------------- -->


<script>

var gurl 	= 'http://<?php echo GURL; ?>';


$(function(){

	hd();
	
	
})


</script>
