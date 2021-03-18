<?php 
$dbo=PDBO;
?>

<h3>
	Setup GIS | <?php $this->shovel('homelinks'); ?>
	
</h3>



<table class="accordion treeset gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('treeset');" >Tree Setup</th></tr>
	<tr><td class="" ><a href="<?php echo URL.'records/dbtables'; ?>" >Records DB Tables</a></td></tr>
	<tr><td class="" ><a href='<?php echo URL."records/batch/{$dbo}.`00_contacts`"; ?>' >Contacts Setup</a></td></tr>

</table>
<br />




