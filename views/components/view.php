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
	| <a href="<?php echo URL; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'components/view/'.$level_id.'?sort=sub.name'; ?>">Alphabetical</a> 	
	| <a href='<?php echo URL."components/view/$level_id&sort=cri.id"; ?>'>Sort By Criteria</a>
	| <a href='<?php echo URL."components/add"; ?>'>Add Component</a>
</span>
</h5>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."components/view/".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>


<p class="printNoScreen f10" >Printed on: <?php echo date('M d, Y'); ?></p>


<p>*For equal weight of traits, put 100, else put pct value, i.e. 60 and 40.</p>

<!---------------------------------------------------------------------------->

<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th class="screen" >&nbsp;</th>
	<th>Comp#</th>
	<th>Subj<br />ID</th>
	<th>Subject</th>
	<th>Cri<br />ID</th>
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
	<td><?php echo '#'.$row['subject_id']; ?></td>
	<td><?php echo $row['subject']; ?></td>
	<td><?php echo $row['criteria_id']; ?></td>
	<td class="vc250" ><?php echo $row['criteria']; ?></td>
	<td><?php echo ($row['is_raw'])? 'Raw':'TRNS'; ?></td>
	<td><?php echo $row['ctype']; ?></td>
	<td><?php echo $row['weight']; ?></td>
	<td class="screen" >
<a href="<?php echo URL.'components/modify/'.$row['id']; ?>">Modify</a> 
	</td>
</tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>


</form> <!-- for batch -->

<div class="hd" ><?php pr($_SESSION['q']); ?></div>







<div class="ht100" ></div>




<script>

$(function(){
	hd();
})

</script>
