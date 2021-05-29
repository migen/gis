<?php  
	$controller=isset($data)? strtolower($data):false;
	$hometext=($controller)? $data:"Home";	
?>

<?php if(isset($_SESSION['settings']) && $_SESSION['settings']['has_branches']): ?>
	<?php echo $_SESSION['brcode']; ?>
	<a href="<?php echo URL.$controller; ?>"><?php echo $hometext; ?></a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
<?php else: ?>
	<a href="<?php echo URL.$controller; ?>"><?php echo $hometext; ?></a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
<?php endif; ?>

