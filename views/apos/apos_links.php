| <a href="<?php echo URL.'apos'; ?>" >Links</a>
| <a href="<?php echo URL.'apos/add'; ?>" >Add</a>
| <a href="<?php echo URL.'apos/abc'; ?>" >ABC</a>
| <a href="<?php echo URL.'apos/purge'; ?>" >Purge</a>
| <a href="<?php echo URL.'apos/items'; ?>" >Items</a>
| <a href="<?php echo URL.'apos/mir'; ?>" >MIR</a>



<?php if(isset($_GET['debug'])): ?>
	| <a href="<?php echo $axn; ?>" >Undebug</a>
<?php else: ?>
	| <a href="<?php echo $axn.'&debug' ?>" >Debug</a>
<?php endif; ?>
