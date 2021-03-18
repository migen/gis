<?php if(isset($_GET['printout'])): ?>

<div class="center" >

<table class="no-gis-table-bordered" >
	<tr><th rowspan="4" ></th></tr>
	<tr><th class="center" >LSM | <?php echo $dr['department']; ?> 
		| <?php echo 'SY '.$sy.' - '.($sy+1); ?>
		</th>
	</tr>
	<tr><td><?php echo $course['level'].' - '.$course['section']; ?>
	 - <?php echo $course['teacher']; ?> </td></tr>	
	<tr><td class="center" >
		<span class="tf12" >Date printed: <?php echo date('Y-m-d H:i:s'); ?></span>
	</td></tr>	
</table>

</div>


<?php else: ?>

<div class="center" >

<table class="no-gis-table-bordered" >
	<tr><th rowspan="6" ></th></tr>
	<tr><th class="center" >School ERP (Enterprise Resouce Planning)</th>
		<th rowspan="4" ></th>			
	</tr>
	<tr><th class="center" ><?php echo $dr['department']; ?> Department</th></tr>
	<tr><td class="center" ><?php echo 'SY '.$sy.' - '.($sy+1); ?></td></tr>
	<tr><td class="center" ><?php echo 'Class Record in '.$course['label']; ?></td></tr>
	<tr><td class="center" >
		<span class="tf12" >Date printed: <?php echo date('Y-m-d H:i:s'); ?></span>
	</td></tr>	
</table>

</div>



<div class="screen" >

<table class="no-gis-table-bordered" >
	<tr><th>Grade & Section: </th><td><?php echo $course['level'].' - '.$course['section']; ?></td></tr>
	<tr><th>Subject Teacher: </th><td><?php echo $course['teacher']; ?></td></tr>
</table>

</div>
<?php endif; ?>