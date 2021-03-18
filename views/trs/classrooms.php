<h5>
	Classrooms Handled by
	<?php echo $teacher['name']; ?>		
	
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			

</h5>

<p>Settings - trs_adviser (Set to 1 to include adviser or 0 to exclude.)</p>

<?php 



$sync=false;

?>



<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Crid</th>
	<th>Acid</th>
	<th>Classroom</th>
	<th>Axn</th>
	<th>Status</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['acid']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td>
		<?php if($rows[$i]['acid']==$ucid): ?>
			<?php if(isset($rows[$i]['trsid'])): ?>
				<a href="<?php echo URL.'trs/view/'.$rows[$i]['trsid'].DS.$ucid.DS.$sy.DS.$qtr; ?>" >View<a>				
				| <a href="<?php echo URL.'cav/traits/'.$rows[$i]['trsid'].DS.$sy.DS.$qtr; ?>" >Traits<a>
				| <a href="<?php echo URL.'trs/teachers/'.$rows[$i]['crid']; ?>" >Teachers<a>	
			<?php endif; ?>	

		<?php else: ?>
			<?php if(isset($rows[$i]['trsid'])): ?>
				<a href="<?php echo URL.'trs/view/'.$rows[$i]['trsid'].DS.$ucid.DS.$sy.DS.$qtr; ?>" >View<a>	
			<?php endif; ?>				
		<?php endif; ?>
	</td>
	<td>
		<?php 
			if(isset($rows[$i]['status'])){
				echo ($rows[$i]['status']==1)? 'Locked':'Open';				
			} 
			else{ 
				if(isset($rows[$i]['trsid'])){ ?>
				<input type="hidden" name="posts[<?php echo $i; ?>][trsid]" value="<?php echo $rows[$i]['trsid']; ?>" />				
			<?php
					$sync=true;
					echo '-';
				}
			}	/* if */
		
		?>	
	</td>
</tr>
<?php endfor; ?>
</table>


<?php if($sync): ?>
	<p><input type="submit" name="sync" value="Sync"  /></p>
<?php endif; ?>

</form>
