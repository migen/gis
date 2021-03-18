<h5>
	Dashboard SY <?php echo $sy; ?>
	| <?php $this->shovel('homelinks','registrars'); ?>
	| <a href="<?php echo URL.'registrars/registration'; ?>" > Registration </a>	
</h5>

<!---------------------------------------------------------------------------------------------------------------->

<?php 


	
?>

<!---------------------------------------------------------------------------------------------------------------->


<table class="gis-table-bordered table-fx table-altrow"  >

<tr class="headrow" ><th class="white vc30" >#</th><th class="vc200 white" > Particular </th><th class="vc50 white" >Tally</th><th class="vc100 white" >Action</th></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Active Students </td><td class="right" ><?php echo $active_students; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Summaries </td><td class="right" ><?php echo $num_summaries; ?></td>
<td> &nbsp; </td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Sectioned Students </a></td><td class="right" ><?php echo $num_sectioned; ?></td>
<td> 
<?php if(($qtr==4) && ($is_finalized_sectioning) && ($num_sectioned==0)): ?> 
	<a href='<?php echo 'reg/setNewSY/'.$nsy; ?>' onclick="tripleConfirm();return false;" > Set New SY </a> 
<?php endif; ?> 
</td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Classrooms </td><td class="right" ><?php echo $num_classrooms; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Promotions-Classrooms </a></td><td class="right" ><?php echo $num_prom_classrooms; ?></td>
<td> 
<?php if($num_classrooms!=$num_prom_classrooms): ?>
	<a href="<?php echo URL.'utils/syncPromotions/index'; ?>" >Sync Classrooms-Promotions</a> 
<?php endif; ?>
</td></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Finalized Promotions-Classrooms </a></td><td class="right" ><?php echo $num_promotions; ?></td><td>&nbsp;</td></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Sectioning </td><td class="right" ><?php $sectioning = $_SESSION['settings']['is_finalized_sectioning']; echo ($sectioning==1)? 'Locked':'Open'; ?></td>
<td>
<?php if($sectioning==1): ?>
	<a onclick="return confirm('You sure?');" href="<?php echo URL.'registrars/openSectioning'; ?>" >Open Sectioning</a> 
<?php else: ?>
	<a onclick="return confirm('You sure?');" href="<?php echo URL.'registrars/lockSectioning'; ?>" >Lock Sectioning</a> 
<?php endif; ?>
</td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > 	
	<a href="<?php echo URL.'registrars/inactiveStudents/'.$sy; ?>" >Inactive Students <?php echo $sy; ?> </a>  
</td><td class="right" ><?php echo $num_dropouts; ?></td>
<td> &nbsp;  </td></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > 	
	<a href="<?php echo URL.'registrars/notes'; ?>" >Notes  </a>  
</td><td class="right" ></td>
<td> &nbsp;  </td></tr>


</table>

<!----------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';var x;

$(function(){
	rc('rc');

	
})


function rc(cls){
	var x;
	$('.'+cls).each(function(){
		x = this.rowIndex;
		$(this).find("td:first").text(x);
	});
}
	
	
</script>