<?php 

// pr($_SESSION['message']);
// pr($_SESSION['brid']);
// pr($_SESSION['branches']);

// pr();
?>

<h3>
	Branches | <?php $this->shovel('homelinks'); ?>
	| Brid <?php echo $_SESSION['brid']; ?> 
<?php if($_SESSION['srid']==RMIS): ?>
		Branch: <?php $d['branches']=$branches;$d['brid']=$brid;$this->shovel('selector_branches',$d); ?>			
<?php endif; ?>
	
	
</h3>



<h3>
	Active Branch - <?php echo '#'.$_SESSION['brid'].' - '.$_SESSION['branch']; ?>

</h3>

<script>

var gurl="http://<?php echo GURL; ?>";


$(function(){
	// alert(gurl);
	
})

</script>
