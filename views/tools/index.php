<?php 

// pr($data);
// pr($classes);

?>


<h5>
	Methods
	- <?php echo $class; ?>
	| <a href="<?php echo URL; ?>" />Home</a>  
	<?php echo ($is_mis)? '| <a href="'.URL.'tools" >Tools</a>' : ''; ?>					
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	
</h5>

<div class="half" >
<table class="gis-table-bordered table-fx" >

<tr class="headrow row-white" >
	<th class="vc30" >#</th>
	<th class="vc200" >Method</th>
</tr>

<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $methods[$i]; ?></td>
</tr>
<?php endfor; ?>
</table>
</div>


<?php if($is_index && $is_mis): ?>
<div class="third"  >

<?php foreach($classes AS $row): ?>
	<p><a href='<?php echo URL.$row['ctlr']."/methods/".$row['cls']; ?>' ><?php echo $row['cls']; ?></a> </p>
<?php endforeach; ?>
</div>
<?php endif; ?>