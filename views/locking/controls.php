<h5>
	Locking Controls
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			


</h5>



<table class="gis-table-bordered" >

<tr>
<th class="rc" ></th>
<th class="" >Item</th>
<th class="" ></th>
<th class="" >Action</th>

</tr>



<tr class="rc" ><td  >&nbsp;</td><td class="vc200" >Lock All (Crs & Adv)</td><td class="right" ><?php echo ''; ?></td>
<td>
	<?php for($i=1;$i<5;$i++): ?>
		<a href="<?php echo URL.'acad/lockAll?qtr='.$i; ?>" onclick="return confirm('Sure?');" >Q<?php echo $i; ?></a> |
	<?php endfor; ?>	
	<a href='<?php echo URL."locking/closeCQ/5/$sy"; ?>' >Q5</a> | 		
	<a href="<?php echo URL.'locking/closeCQ/6/'.$sy; ?>" > Q6 </a> 
</td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" >UnLock All (Crs & Adv)</td><td class="right" ><?php echo ''; ?></td>
<td>
	<?php for($i=1;$i<5;$i++): ?>
		<a href="<?php echo URL.'acad/unlockAll?qtr='.$i; ?>" onclick="return confirm('Sure?');" >Q<?php echo $i; ?></a> |
	<?php endfor; ?>
	<a href="<?php echo URL.'locking/openCQ/5/'.$sy; ?>" >Q5</a> 	
	<a href="<?php echo URL.'locking/openCQ/6/'.$sy; ?>" >Q6</a> 	
</td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Lock Classrooms </td><td class="right" ><?php echo ''; ?></td>
<td>
	<?php for($i=1;$i<6;$i++): ?>
		<a href='<?php echo URL."locking/closeAQ/$i/$sy"; ?>' >Q<?php echo $i; ?></a> | 	
	<?php endfor; ?>
	<a href="<?php echo URL.'locking/closeAQ/6/'.$sy; ?>" >Q6</a> 
</td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Open Classrooms  </td><td class="right" ><?php echo ''; ?></td>
<td>
	<?php for($i=1;$i<6;$i++): ?>
		<a href='<?php echo URL."locking/openAQ/$i/$sy"; ?>' >Q<?php echo $i; ?></a> | 	
	<?php endfor; ?>
	<a href="<?php echo URL.'locking/openAQ/6/'.$sy; ?>" >Q6</a> 	
</td></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Lock Courses </td><td class="right" ><?php echo ''; ?></td>
<td>
	<?php for($i=1;$i<6;$i++): ?>
		<a href='<?php echo URL."locking/closeCQ/$i/$sy"; ?>' >Q<?php echo $i; ?></a> | 	
	<?php endfor; ?>
	<a href="<?php echo URL.'locking/closeCQ/6/'.$sy; ?>" >Q6</a> 
</td></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Open Courses  </td><td class="right" ><?php echo ''; ?></td>
<td>
	<?php for($i=1;$i<6;$i++): ?>
		<a href='<?php echo URL."locking/openCQ/$i/$sy"; ?>' >Q<?php echo $i; ?></a> | 	
	<?php endfor; ?>
	<a href="<?php echo URL.'locking/openCQ/6/'.$sy; ?>" >Q6</a> 	
</td></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Lock Attendance </td><td class="right" ><?php echo ''; ?></td>
<td>
	<?php for($i=1;$i<4;$i++): ?>
		<a href='<?php echo URL."locking/closeAttd/$i/$sy"; ?>' >Q<?php echo $i; ?></a> | 	
	<?php endfor; ?>
	<a href="<?php echo URL.'locking/closeAttd/4/'.$sy; ?>" >Q4</a> 	
</td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Open Attendance </td><td class="right" ><?php echo ''; ?></td>
<td>
	<?php for($i=1;$i<4;$i++): ?>
		<a href='<?php echo URL."locking/openAttd/$i/$sy"; ?>' >Q<?php echo $i; ?></a> | 	
	<?php endfor; ?>
	<a href="<?php echo URL.'locking/openAttd/4/'.$sy; ?>" >Q4</a> 	
</td></tr>

<?php if($_SESSION['settings']['has_clubs']==1): ?>
	<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Lock Clubs </td><td class="right" ><?php echo ''; ?></td>
	<td>
		<?php for($i=1;$i<5;$i++): ?>
			<a href='<?php echo URL."locking/closeClubs/$i/$sy"; ?>' >Q<?php echo $i; ?></a> | 	
		<?php endfor; ?>
	</td></tr>
	<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Open Clubs </td><td class="right" ><?php echo ''; ?></td>
	<td>
		<?php for($i=1;$i<5;$i++): ?>
			<a href='<?php echo URL."locking/openClubs/$i/$sy"; ?>' >Q<?php echo $i; ?></a> | 	
		<?php endfor; ?>
	</td></tr>


<?php endif; ?>



</table>




<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy 	 = '<?php echo $sy; ?>';
var x;

$(function(){
	rc('rc');

	
})



</script>