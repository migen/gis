<?php 

	// pr($data);

	

?>

<!------------------------------------------------------------------------------------------------------------------------>

<h5>
	<span class="u" ondblclick="tracehd();" >Criteria</span> 
	| <a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'criteria/set?order=ASC&sort=criteria_id'; ?>" >Criteria ID</a>
	| <a href="<?php echo URL.'criteria'; ?>" >Printable</a>
	
</h5>

<!------------------------------------------------------------------------------------------------------------------------>

<p>
1) List means 3rd-Tier Component in Scores/Activities<br />
2) Raw default, raw of 9/10 = 45 with base 50. Pct 9/10 = 90
</p>

<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th></th>
	<th>#</th>
	<th>ID</th>
	<th>Comp</th>	
	<th>Type</th>	
	<th>Code</th>	
	<th>Critype</th>
	<th>Criteria</th>
	<th>Pos</th>	
	<th>
		Active<br />
		<select id="iactv" class='vc50'>	
			<option value="1" >Yes</option>
			<option value="0" >No</option>
		</select>					
		<br />	
		<input type="button" value="All" onclick="populateColumn('actv');" >							
	</th>	
	<th>List<br />
		<select id="isublist" class='vc50'>	
			<option value="1" >Yes</option>
			<option value="0" >No</option>
		</select>					
		<br />	
		<input type="button" value="All" onclick="populateColumn('sublist');" >								
	</th>	
	<th>
		Raw/Pct<br />
		<select id="iraw" class='vc50'>	
			<option value="1" >Raw</option>
			<option value="0" >Pct</option>
		</select>					
		<br />	
		<input type="button" value="All" onclick="populateColumn('raw');" >								
	</th>	
	<th>Edit</th>
	<th class="hd" >DEL</th>

</tr>

<!--------------------- data --------------------------------------------------------->
<form method="POST" >
<?php for($i=0;$i<$num_criteria;$i++): ?>
	<tr class="<?php echo ($criteria[$i]['is_active'])? null: 'bg-pink'; ?>" >
		<td class="screen" ><input type="checkbox" name="rows[<?php echo $criteria[$i]['id']; ?>]" 
			value="<?php echo $criteria[$i]['id']; ?>" /></td>

		<td><?php echo $i+1; ?></td>
		<input type="hidden" name="criteria[<?php echo $i; ?>][cid]" value="<?php echo $criteria[$i]['id']; ?>"  />	
		<td><?php echo $criteria[$i]['id']; ?></td>			
		<td><a href="<?php echo URL.'mis/getComponents?criteria_id='.$criteria[$i]['criteria_id']; ?>" >Comp</a></td>
		<td><?php echo $criteria[$i]['crstype']; ?></td>		
<td><input class="pdl05 vc70" name="criteria[<?php echo $i; ?>][code]" tabIndex=2 value="<?php echo $criteria[$i]['code']; ?>"  ></td>		
		<td><input class="center vc50" name="criteria[<?php echo $i; ?>][critype_id]" 
			value="<?php echo $criteria[$i]['critype_id']; ?>" tabIndex=5 ></td>

<td class="vc300" ><?php echo $criteria[$i]['name']; ?></td>		

		<td><input id="pos<?php echo $i; ?>" class="center vc50" name="criteria[<?php echo $i; ?>][position]" 
			value="<?php echo $criteria[$i]['position']; ?>" tabIndex=6 ></td>

		<td>
			<select class="actv vc50" name="criteria[<?php echo $i; ?>][is_active]" tabIndex=8  >
				<option value="1" <?php echo ($criteria[$i]['is_active']==1)? 'selected':null; ?> >Y</option>
				<option value="0" <?php echo ($criteria[$i]['is_active']!=1)? 'selected':null; ?> >N</option>
			</select>	
		</td>	

		<td>
			<select class="sublist vc50" name="criteria[<?php echo $i; ?>][is_kpup_list]" tabIndex=10  >
				<option value="1" <?php echo ($criteria[$i]['is_kpup_list']==1)? 'selected':null; ?> >Y</option>
				<option value="0" <?php echo ($criteria[$i]['is_kpup_list']!=1)? 'selected':null; ?> >N</option>
			</select>	
		</td>	
		
		<td>
			<select class="raw vc80 <?php echo ($criteria[$i]['is_raw']!=1)? 'salmon': NULL ; ?>" name="criteria[<?php echo $i; ?>][is_raw]"   >
				<option value="1" <?php echo ($criteria[$i]['is_raw']==1)? 'selected':null; ?> >Raw</option>
				<option value="0" <?php echo ($criteria[$i]['is_raw']!=1)? 'selected':null; ?> >Pct</option>
			</select>	
		</td>			
									
		<td><a href="<?php echo URL.'criteria/edit/'.$criteria[$i]['id']; ?>">Edit</a></td>
		<td class="hd" ><a onclick="return confirm('Dangerous! Sure?');" 
			href="<?php echo URL.'criteria/delete/'.$criteria[$i]['id']; ?>">DEL</a></td>
	</tr>	
<?php endfor; ?>

</table>

<p>	
<input onclick="return confirm('Are you absolutely sure?');" type='submit' name='batch' value='Delete' >
<?php $this->shovel('boxes'); ?>
<input type="submit" name="edit" value="Save All" onclick="return confirm('You sure?');"  /> 

</p>

</form>

<br />
<!------------------------------------------------------------------>
<hr />

<form method="POST" >	<!-- form add subjects -->
<div style="width:600px;float:left;"  >
<h5> 
	  Add Criteria 
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
</h5>

<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th>Cri<br />type<br />
		<input id="icritype" class="vc50" >	
		<br /> <input type="button" value="All" onclick="populateColumn('critype');" >				
	</th>
	<th>Code</th>
	<th>Name</th>
	<th>
		<select id="ictype" class=''>	
			<?php foreach($crstypes as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('ctype');" >			
	</th>
</tr>

<tbody>
<?php $numrows=isset($_POST['numrows'])? $_POST['numrows']:1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
<td><input tabIndex=2 id="critype<?php echo $i; ?>" class="vc50 critype" type="text" name="criteria[<?php echo $i; ?>][critype_id]" /></td>		
<td><input tabIndex=4 id="cricode<?php echo $i; ?>" class="vc50" type="text" name="criteria[<?php echo $i; ?>][code]" /></td>		
<td><input tabIndex=6 id="criname<?php echo $i; ?>" class="vc200" type="text" name="criteria[<?php echo $i; ?>][name]" /></td>
	<td>
		<select id="ctype<?php echo $i; ?>" class="ctype" name="criteria[<?php echo $i; ?>][crstype_id]"  >
			<?php	foreach($crstypes as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>				
</tr>

<?php endfor; ?>			
</tbody></table>

<p>
	<input onclick="return confirm('Sure?');" type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->

<p><?php $this->shovel('numrows'); ?></p>
</div>

<!------------------------------------------------------------------------>

<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="" >Choose</option>
	<option value="critype" >Critype</option>
	<option value="cricode" >Code</option>
	<option value="criname" >Name</option>
	<option value="ctype" >Ctype</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>


<div class="clear ht100" >&nbsp;</div>


<!------------------------------------------------------------------------->


<script>

var gurl = "http://<?php echo GURL; ?>";

$(function(){
	hd();
	shd();
	itago('clipboard');
	nextViaEnter();
	
	
		
})




</script>

