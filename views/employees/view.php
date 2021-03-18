<?php 

	// pr($data);

	// pr($_SESSION['q']);

?>


<h5>
	Employee | 
	<?php 	$controller = 'mis'; $this->shovel('homelinks',$controller); ?>
	
</h5>



<table class="gis-table-bordered table-fx" >

<tr><th class="bg-blue2 white" >ID</th><td class="vc300" ><?php echo $employee['code']; ?></td></tr>
<tr><th class="bg-blue2 white" >Name</th><td> <?php echo $employee['name']; ?> &nbsp; | <a href="<?php echo URL.'contacts/edit/'.$employee['ecid']; ?>" > Edit </a></td></tr>
<tr><th class="bg-blue2 white" >Username</th><td><?php echo $employee['account']; ?></td></tr>
<tr><th class="bg-blue2 white" >Title</th><td><?php echo $employee['title']; ?></td></tr>
<tr><th class="bg-blue2 white" >Password</th><td><?php echo $employee['ctp']; ?></td></tr>


</table>


<!------------------------------------------------------------------------------------------------------------------------>
