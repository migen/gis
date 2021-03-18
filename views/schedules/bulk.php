<h5>
	Add Schedules in Bulk
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'schedules/index'; ?>" >Schedules</a>

</h5>


<form method="POST" >

<div class="half" >
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Date</th>
	<th>Event</th>
</tr>

<?php $numrows = (isset($_POST['numrows']))? $_POST['numrows']:1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><input class="pdl05" id="date<?php echo $i; ?>" type="date" name="posts[<?php echo $i; ?>][date]" 
		value="<?php echo $_SESSION['today']; ?>"  /></td>
	<td><input class="pdl05" id="event<?php echo $i; ?>" type="text" name="posts[<?php echo $i; ?>][event]" value=""  /></td>
</tr>
<?php endfor; ?>
</table>

<p>
	<input type="submit" name="submit" value="Add"   />
</p>
</form>

<?php $this->shovel('numrows'); ?>

</div>



<!--------------------------------------------------------------------------------------------->

<p>
<select id="classbox" >
	<option value="date" >Date</option>
	<option value="event" >Event</option>
</select>
</p>


<?php $this->shovel('smartboard'); ?>




