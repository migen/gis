<?php 

// pr($data);
// pr($selects['criteria'][0]);



?>
<!-- ============================================================== -->

<h5>
	<a href="<?php echo URL.'mis'; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	
</h5>

<!-- ============================================================== -->


<form method='post' >

<div style="width:70%;float:left;" >	<!-- main -->
<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>#</th>
	<th class="vc100 center" >
		Subject
		<select id="isub" class="full"  >	
			<option> Subject </option>
			<?php foreach($data['selects']['subjects'] as $sel): ?>
				<option value="<?php echo $sel['id']; ?>">
					<?php echo $sel['name'].' - #'.$sel['id']; ?></option>
			<?php endforeach; ?>
		</select>				
		<br /><input type="button" value="All" onclick="populateColumn('sub');" >		
	</th>	
	<th class="vc100 center" >
		Level
		<select id="ilvl" class="full" >	
			<option> Level </option>
			<?php foreach($data['selects']['levels'] as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> 
					<?php echo $sel['name'].' - #'.$sel['id']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /><input type="button" value="All" onclick="populateColumn('lvl');" >		
	</th>	
	
	<th class="vc200 center" >
		Criteria
		<select id="icri" class="full" >	
			<option> Select criteria </option>
			<?php foreach($data['selects']['criteria'] as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> 
					<?php echo $sel['crstype_id'].'-'.$sel['name'].' - #'.$sel['id']; ?> 
				</option>
			<?php endforeach; ?>
		</select>				
		<br /><input type="button" value="All" onclick="populateColumn('cri');" >		
	</th>		
	<th class="vc50" > Weight
		<input class="vc50" type="text" id="iwt" value="" >
		<input type="button" value="All" onclick="populateColumn('wt');" >		
	</th>			
	
</tr>

<tbody id='tableCriteria'>
<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	
	<td>
		<select id="sub<?php echo $i; ?>" class="sub vc100" name='components[<?php echo $i; ?>][subject_id]' >
			<?php	foreach($data['selects']['subjects'] as $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php	endforeach; ?>				
		</select>
	</td>	

	<td>
		<select id="lvl<?php echo $i; ?>" class="lvl vc100" type='text' name='components[<?php echo $i; ?>][level_id]'  >
			<?php	foreach($data['selects']['levels'] as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>
	
	<td>
		<select id="cri<?php echo $i; ?>" class="cri vc200" name='components[<?php echo $i; ?>][criteria_id]'  >
			<?php	foreach($data['selects']['criteria'] as $sel): ?>
				<option value="<?php echo $sel['id']; ?>">
					<?php echo $sel['crstype_id'].'-'.$sel['name']; ?></option>
			<?php	endforeach; ?>				
		</select>
	</td>	
	<td><input id="wt<?php echo $i; ?>" class="wt vc50 pdl05" name='components[<?php echo $i; ?>][weight]'  ></td>
	
</tr>



<?php endfor; ?>			
</tbody></table>

<!-------------------------------------------------------------------------------->

<?php $level_id = isset($_SESSION['criteria']['level_id'])? $_SESSION['criteria']['level_id'] : 1; ?>

<p>
	<input type='submit' name='submit' value='Submit'> &nbsp; 
	<button><a href="<?php echo URL.'mis/criteria/'.$level_id; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> 


<!-- form_numrows-->
<?php $this->shovel('numrows'); ?>
</div>	<!-- main -->


<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="sub" >Subject</option>
	<option value="lvl" >Level</option>
	<option value="cri" >Criteria</option>
	<option value="wt" >Weight</option>
	<option value="sem" >Sem</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<!------------------------------------------------------------>

<script>

$(function(){
	hd();
	nextViaEnter();
	itago('clipboard');

})


function changeLabel(i){
	var lbl = $('select[name="components['+i+'][subject_id]"]').text();		
	// alert(lbl);

}


</script>


