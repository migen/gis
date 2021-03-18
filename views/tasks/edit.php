<?php 

// pr($data);

// pr($shs);



?>


<h5>
	Edit Tasks
	| <a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	
</h5>

<p class="brown" >* Sem is for traits only. </p>

<!---------------------------------------------------------------------------->

<form id='editCriteriaForm' method='post' >

<br />

<table class="table-fx gis-table-bordered">
<tr class="headrow" >
	<th>TID</th>
	<th>Date<input id="idate" class="vc100" />
		<br /><input type="button" value="All" onclick="populateColumn('date');" >										
	</th>
	<th>Item</th>
	<th>Remarks</th>
	<th>Status</th>
	<th>User</th>
</tr>

<?php $i=0; ?>
<?php foreach($rows as $row): ?>


<tr>
	<td><?php echo $row['id']; ?></td>		
	<td><input id="date<?php echo $i; ?>" class="date vc100" name='posts[<?php echo $i; ?>][date]' tabindex="4" 
		value="<?php echo ($row['date'])? $row['date'] : null; ?>" ></td>	

	<td><input id="item<?php echo $i; ?>" class="vc300" name='posts[<?php echo $i; ?>][item]' tabindex="6" 
		value="<?php echo ($row['item'])? $row['item'] : null; ?>" ></td>	
		
	<td><input id="remarks<?php echo $i; ?>" class="vc200" name='posts[<?php echo $i; ?>][remarks]' tabindex="8" 
		value="<?php echo ($row['remarks'])? $row['remarks'] : null; ?>" ></td>			
	<td>
		<select name="posts[<?php echo $i; ?>][is_done]" >
			<option value="0" <?php echo ($row['is_done']==1)? NULL:'selected'; ?> >Pending</option>
			<option value="1" <?php echo ($row['is_done']==1)? 'selected':NULL; ?> >Done</option>
		</select>
	</td>
	<td><?php echo $row['user']; ?></td>			
	<input type='hidden' name='posts[<?php echo $i; ?>][id]' value="<?php echo isset($row['id'])? $row['id']:null ?>"/>
</tr>


<?php $i++; ?>			
<?php endforeach; ?>
</table>



<p>
	<input type='submit' name='submit' value='Save'> &nbsp; 
	<button><a href="<?php echo isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : URL.'tasks'; ?>" 
		class="no-underline" >Cancel</a></button>
	
</p>


</form> 

<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="item" >Item</option>
	<option value="remarks" >Remarks</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<!------------------------------------------------------------------------------------------------------------------->


<script>

$(function(){
	hd();
	nextViaEnter();
	itago('clipboard');

})



</script>


