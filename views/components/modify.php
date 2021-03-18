<?php 

// pr($data);

// pr($shs);



?>

<!---------------------------------------------------------------------------->

<h5>
	Modify Components 
	| <a href="<?php echo URL; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	
</h5>

<p class="brown" >* Sem is for traits only. </p>
<p class="brown" >* Weight in Pct, i.e. 50 for 50%. </p>

<!---------------------------------------------------------------------------->

<form id='editCriteriaForm' method='post' >

<br />

<table class="table-fx gis-table-bordered">
<tr class="headrow" >
	<th class="screen" >&nbsp;</th>
	<th>ID</th>
	<th>Level</th>
	<th>Subject</th>
	<th>Criteria<br />
		<select id="icri" type='text' class="vc300"  >
			<?php	foreach($selectscriteria as $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['crstype_id'].' - '.$sel['name']; ?></option>
			<?php	endforeach; ?>				
		</select>
		<br />	
		<input type="button" value="All" onclick="populateColumn('cri');" >									
	</th>
	<th>Weight<br />
		<input id="iwt" class="vc50" />
		<br />	
		<input type="button" value="All" onclick="populateColumn('wt');" >									
	</th>
	<th  class="hd" >Label<br />
		<input id="ilbl" class="" />
		<br />	
		<input type="button" value="All" onclick="populateColumn('lbl');" >								
	</th>
	<th>Sem</th>
	<th></th>
</tr>

<tbody id='tableCriteria'>
<?php $i=0; ?>
<?php foreach($components as $row): ?>

<tr>
	<td class="screen" ><input type="checkbox" name="rows[<?php echo $row['id'];?>]" value="<?php echo $row['id']; ?>" /></td>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['level']; ?></td>	
	<td><?php echo $row['subject']; ?></td>	

	<td>
		<select id="cri<?php echo $i; ?>" class="cri vc300" name='components[<?php echo $i; ?>][criteria_id]' tabindex="2" >
			<?php	foreach($selectscriteria as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"  <?php echo ($row['criteria_id']==$sel['id'])? 'selected':null; ?> ><?php echo $sel['crstype_id'].' - '.$sel['name']; ?></option>
			<?php	endforeach; ?>				
		</select>
	</td>	
		
	<td><input id="wt<?php echo $i; ?>" class="wt vc50" name='components[<?php echo $i; ?>][weight]' tabindex="4" 
		value="<?php echo ($row['weight'])? $row['weight'] : null; ?>" ></td>	

	
	<?php $readonly = ($row['level_id']>13)? '':'readonly'; ?>
	<td><input id="sem<?php echo $i; ?>" class="sem vc50" name='components[<?php echo $i; ?>][semester]' tabindex="5" 
		value="<?php echo $row['semester']; ?>" <?php echo $readonly; ?> ></td>	
		
	<td class="hd" ><input id="lbl<?php echo $i; ?>" class="vc200 lbl" name='components[<?php echo $i; ?>][label]' 
		value="<?php echo ($row['label'])? $row['label'] : $row['subject']; ?>" ></td>	
	
	<td></td>			
	<input type='hidden' name='components[<?php echo $i; ?>][id]' value="<?php echo isset($row['id'])? $row['id']:null ?>"/>
</tr>





<?php $i++; ?>			
<?php endforeach; ?>
</tbody></table>

<!-------------------------------------------------------------------------------->

<?php $level_id = isset($_SESSION['criteria']['level_id'])? $_SESSION['criteria']['level_id'] : 1; ?>


<p>
	<input type='submit' name='submit' value='Save'> &nbsp; 
	<button><a href="<?php echo isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : URL; ?>" class="no-underline" >Cancel</a></button>
	<?php // $this->shovel('boxes'); ?>
	
</p>


</form> 

<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="cri" >Criteria</option>
	<option value="wt" >Weight</option>
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


