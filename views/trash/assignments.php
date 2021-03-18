<?php 

	// pr($rows[8]); 
	// pr($rows[4]); 
	// pr($_SESSION['q']);

// pr($_GET['filter']);
	
?>



<h5>
	<?php echo $sy; ?> Assignments
	<span class="u" ondblclick="tracehd();" >HD</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'products/assign'; ?>" >Assign</a>
	| <a href="<?php echo URL.'products'; ?>" >Products</a>
	| <a href="<?php echo URL.'products/assignments'; ?>" >Filter</a>
	
	
	
</h5>

<h4 class="brown" >*Red means critical or inventory level below reorder point.</h4>


<?php if(!isset($_GET['filter'])): ?><!-- filter here -->
<form method="GET" >
	<?php include_once('includes/filter_assignments.php'); ?>
</form>

<?php else: ?>

<form method="POST" >
	<?php include_once('includes/table_assignments.php'); ?>
</form>
<?php endif; ?>


<div class="hd" >
<?php pr($_SESSION['q']); ?>
</div>

<!--------------------------------------------------------------------------------------------------->


<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";



$(function(){
	hd();
	nextViaEnter();
	selectFocused();
	chkAllvar('a');

})


function xeditAssignment(i,psid){

	$('#btn'+i).hide();		
	var prod = $('#prod'+i).val();
	var supp = $('#supp'+i).val();
	var cost = $('#cost'+i).val();
	var roqty = $('#roqty'+i).val();
		
	var vurl 	= gurl + '/ajax/xproducts.php';	
	var task	= "xeditAssignment";	
	
	var pdata = "task="+task+"&psid="+psid+"&prod="+prod+"&supp="+supp+"&cost="+cost+"&sy="+sy+"&roqty="+roqty;
		
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,
	  success:function(){} 
   });				
	
}	/* fxn */



</script>
