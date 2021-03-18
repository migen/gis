<h5>
	Balances
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	
</h5>

<table class="gis-table-bordered table-fx" >
<tr><th>ID</th><th>Level</th></tr>
<?php foreach($levels AS $sel): ?>
<tr><td><?php echo $sel['id']; ?></td><td><a href="<?php echo URL.'balances/level/'.$sel['id']; ?>" ><?php echo $sel['name']; ?></a></td></tr>
<?php endforeach; ?>
</table>


