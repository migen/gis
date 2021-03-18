
<?php 
	$reaxn=$data['reaxn'];
	$letters=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
?>

<?php $ls=""; ?>
<?php foreach($letters AS $letter): ?>
	<?php $ls.= '<a href="'.$reaxn.'/'.$letter.'" >'.$letter.'</a> | '; ?>
	
<?php endforeach; ?>

<?php echo $ls; ?>

