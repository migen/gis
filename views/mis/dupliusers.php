
<?php 

// pr($rows[0]);

?>


<h5> 
	Duplicate Users
	| <a href="<?php echo URL; ?>" >Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?> 
	| <a href="<?php echo URL.'contacts'; ?>" >Users</a>	
</h5>


<?php if($duplicates): ?>
	<form method="POST" >

	<table class="gis-table-bordered" >

	<tr><th>Fields</th><td class="vc150" ><input class="pdl05 full" name="fields" value="id,code,name" ></td></tr>
	<tr><th>DB</th><td><input class="pdl05 full" name="db" value="dbone_<?php echo VCFOLDER; ?>" ></td></tr>
	<tr><th>Table</th><td><input class="pdl05 full" name="table" value="contacts" ></td></tr>
	<tr><th>Group By</th><td><input class="pdl05 full" name="group" value="code" ></td></tr>
	<tr><th>Order By</th><td><input class="pdl05 full" name="order" value="id" ></td></tr>

	</table>

	<p>
	<input type="submit" name="submit" value="Submit" />
	</p>


	</form>
<?php endif; ?>

<?php if(empty($rows)) exit; ?>


<table class="gis-table-bordered table-altrow table-fx">

<tr class="headrow" >
<?php for($j=0;$j<$numfields;$j++): ?>
	<th><?php echo $rfields[$j]; ?></th>
<?php endfor; ?>
</tr>

<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
<?php for($j=0;$j<$numfields;$j++): ?>
	<?php $field = $rfields[$j]; ?>
	<th><?php echo $rows[$i][$field]; ?></th>
<?php endfor; ?>
</tr>
<?php endfor; ?>


</table>
