<?php 

// pr($data);
// pr($components[0]);

// pr($classrooms);

if(isset($_GET['debug'])){ pr($q); }

?>
<!---------------------------------------------------------------------------->

<h5 class="" >
	<?php echo $level['name']; ?> <span class="u" ondblclick="tracehd();" >Components</span> 
	(<?php echo count($components); ?>)
<span class="screen" >
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'components/filter/?level_id=4&filter'; ?>" >Filter</a>
	| <a href="<?php echo URL.'components/setup/1'; ?>" >Batch</a>

	| <a href="<?php echo URL.'gset/components/'.$level_id.'?sort=sub.name'; ?>">Alphabetical</a> 	
	| <a href='<?php echo URL; ?>components/add'>Academic</a>
	| <a href='<?php echo URL; ?>components/addMisc'>Non-Acad </a>
	| <a href='<?php echo URL."gset/components/$level_id&sort=cri.id"; ?>'>Sort By Criteria</a>
</span>
	| <?php $this->shovel('links_gset'); ?>

</h5>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."gset/components/".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>


<p class="printNoScreen f10" >Printed on: <?php echo date('M d, Y'); ?></p>

<div class="vc500 screen" >
<h4>
	<?php foreach($classrooms AS $sel): ?>
		<a href='<?php echo URL."mis/courses/".$sel['crid']; ?>'><?php echo $sel['code']; ?></a>
		&nbsp; &nbsp; 
	<?php endforeach; ?>
</h4>
</div>

<p>*For equal weight of traits, put 100, else put pct value, i.e. 60 and 40.<br />
* Raw vs PCT: i.e. (0/10 + 50/100) > for Raw (50/110)=45% Else for Pct  (0+50)/2 = 25% 
</p>

<!---------------------------------------------------------------------------->

<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th class="screen" >&nbsp;</th>
	<th>Comp#</th>
	<th>Subjtype</th>
	<th>Subject</th>
	<th class="" >Criteria</th>
	<th>Trans</th>
	<th>Type</th>
	<th>Weight</th>
	<th class="screen" >Manage</th>
	
</tr>

<form method='post' > <!-- for batch edit/delete -->

<?php $i = 1; ?> <!-- for odd-even row shade -->
<?php foreach($data['components'] AS $row): ?>

<tr rel="<?php echo $row['id']; ?>" class="<?php echo (even($i))? 'even':'odd'?>" >
	<td class="screen" ><input type="checkbox" name="rows[<?php echo $row['id'];?>]" value="<?php echo $row['id']; ?>" /></td>

	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['subjtype_id']; ?></td>
	<td><?php echo $row['subject'].' #'.$row['subject_id']; ?></td>
	<td class="vc250" ><?php echo $row['criteria'].' #'.$row['criteria_id']; ?></td>
	<td><?php echo ($row['is_raw'])? 'Raw':'TRNS'; ?></td>
	<td><?php echo $row['ctype']; ?></td>
	<td><?php echo $row['weight']; ?></td>
	<td class="screen" >
<a href="<?php echo URL.'components/edit/'.$row['id']; ?>">Edit</a> | 		
<a href="<?php echo URL.'components/delete/'.$row['id']; ?>" onclick="return confirm('Are you sure?');" >Delete</a> 		
	</td>
</tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>

<p class="screen" >
	<input type='submit' name='batch' value='Edit' >
	<?php $this->shovel('boxes'); ?>
</p>

</form> <!-- for batch -->

<div class="hd" ><?php pr($_SESSION['q']); ?></div>







<div class="ht100" ></div>




<script>

$(function(){
	hd();
})

</script>
