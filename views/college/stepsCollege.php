<h5>
	College Enrollment Steps (CES) | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

 
<!-- 
college
steps
1) register record - uniregister/student 1) existing, 2) new
2) enroll classroom (section/roster) - unienroll/student - 1) regular, 2) irregular
3) assess / advise / adjust / assign / (3A / EAF) - 
4) claim EAF
-->

<table class="accordion steps gis-table-bordered table-altrow" >
	<tr><th class="center headrow vc300" onclick="accordionTable('steps');" >Steps</th></tr>
	<tr><td class="" ><a href="<?php echo URL.'college/register'; ?>" >Register Old / New</a></td></tr>
	<tr><td class="" ><a href="<?php echo URL.'college/enroll'; ?>" >Enroll</a></td></tr>

</table>
<br />
<table class="accordion css gis-table-bordered table-altrow" >
	<tr><th class="headrow vc300" onclick="accordionTable('css');" >CSS</th></tr>
	<tr><td class="" ><a href="<?php echo URL.'css/one'; ?>" >CSS 1</a></td></tr>
</table>


<script>


$(function(){
	
	// $('.accordion td').hide();
	
})


</script>