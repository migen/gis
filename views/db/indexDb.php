<h5>
	DB | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<table class="menu gis-table-bordered table-altrow" >

<tr><th class="vc300 headrow" onclick="accordionTable('menu');" >Menu</th></tr>
<tr><td><a href="<?php echo URL.'db/diff_tables'; ?>" >1) Difference Tables</a></td></tr>
<tr><td><a href="<?php echo URL.'db/diff_structs'; ?>" >2) Difference Structures</a></td></tr>
<tr><td><a href="<?php echo URL.'db/deport'; ?>" >Deport</a></td></tr>
<tr><td>
	<a href="<?php echo URL.'db/stacker'; ?>" >Stacker</a>
| <a href="<?php echo URL.'db/ctr'; ?>" >Counter (numrows)</a></td></tr>
<tr><td>
	  <a href="<?php echo URL.'db/query'; ?>" >Query</a>
	| <a href="<?php echo URL.'db/querysoc'; ?>" >Qrysoc</a>
</td></tr>


</table>

